<?php
declare(strict_types=1);

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Payment/PaymentContext.php';
require_once __DIR__ . '/../core/Events/BookingEmitterFactory.php';
require_once __DIR__ . '/../models/Court.php';

class BookingController extends Controller
{
    public function booking(): void
    {
        $courtModel = new Court();
        $courts = $courtModel->getAll();

        $this->render('booking/booking', [
            'activePage' => 'booking',
            'pageStyles' => ['css/book.css'],
            'courts'     => $courts,
        ]);
    }

    public function payment(): void
    {
        $this->render('payment/payment', [
            'activePage' => 'booking',
            'pageStyles' => ['css/payment.css'],
        ]);
    }

    public function reservation(): void
    {
        $this->render('reservation', [
            'activePage' => 'booking',
            'pageStyles' => ['css/reservation.css'],
        ]);
    }

    /**
     * POST /booking/process
     *
     * Handles payment validation (Strategy pattern), conflict checking,
     * reservation insertion, and event emission (Observer + Factory patterns).
     * Replaces booking_actions/process.php.
     */
    public function processBooking(): void
    {
        // Auth guard — must be logged in
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $userId         = (int) $_SESSION['user']['id'];
        $courtId        = (int) ($_POST['court_id'] ?? 0);
        $date           = trim($_POST['date'] ?? '');
        $rawStartTime   = trim($_POST['start_time'] ?? '');
        $rawEndTime     = trim($_POST['end_time'] ?? '');
        $totalPrice     = (float) ($_POST['total_price'] ?? 0);
        $rawPaymentType = trim($_POST['payment_type'] ?? 'on_court');

        if ($courtId <= 0 || $date === '' || $rawStartTime === '' || $rawEndTime === '') {
            http_response_code(400);
            die('Missing required booking data.');
        }

        // --- Strategy Pattern: delegate payment validation to PaymentContext ---
        try {
            $paymentContext = new PaymentContext($rawPaymentType, $_POST);
        } catch (\InvalidArgumentException $e) {
            http_response_code(422);
            die('Payment validation failed: ' . $e->getMessage());
        }

        // Convert "1 PM" format to MySQL "13:00:00" format
        $startTime = date('H:i:s', strtotime($rawStartTime));
        $endTime   = date('H:i:s', strtotime($rawEndTime));

        $db = Database::getInstance()->getConnection();

        // Fetch court name for event notifications
        $courtRow = $db->prepare('SELECT name FROM courts WHERE id = :id LIMIT 1');
        $courtRow->execute(['id' => $courtId]);
        $courtName = (string) ($courtRow->fetchColumn() ?: 'Unknown Court');

        try {
            $db->beginTransaction();

            // Check for conflicting reservations
            $conflictStmt = $db->prepare(
                'SELECT id
                 FROM reservations
                 WHERE court_id = :court_id
                   AND reservation_date = :slot_date
                   AND status != "cancelled"
                   AND (start_time < :end_time AND end_time > :start_time)
                 FOR UPDATE'
            );
            $conflictStmt->execute([
                'court_id'   => $courtId,
                'slot_date'  => $date,
                'start_time' => $startTime,
                'end_time'   => $endTime,
            ]);

            if ($conflictStmt->fetch()) {
                throw new \RuntimeException('Selected time slot is already booked.');
            }

            // Build INSERT dynamically based on existing columns
            $columns  = $db->query('SHOW COLUMNS FROM reservations')->fetchAll();
            $colNames = array_map(static fn(array $c): string => $c['Field'], $columns);

            $insertFields = ['user_id', 'court_id'];
            $insertParams = ['user_id' => $userId, 'court_id' => $courtId];

            $fieldMap = [
                'reservation_date' => $date,
                'start_time'       => $startTime,
                'end_time'         => $endTime,
                'total_price'      => $totalPrice,
                'payment_type'     => $paymentContext->getType(),
                'status'           => 'confirmed',
                'payment_status'   => $paymentContext->getPaymentStatus(),
            ];

            foreach ($fieldMap as $col => $value) {
                if (in_array($col, $colNames, true)) {
                    $insertFields[]      = $col;
                    $insertParams[$col]  = $value;
                }
            }

            $fieldSql     = implode(', ', $insertFields);
            $placeholders = implode(', ', array_map(static fn(string $f): string => ':' . $f, $insertFields));
            $insertSql    = "INSERT INTO reservations ({$fieldSql}) VALUES ({$placeholders})";

            $db->prepare($insertSql)->execute($insertParams);
            $reservationId = (int) $db->lastInsertId();

            $db->commit();

            // --- Factory + Observer Pattern: notify all subscribers ---
            $emitter = BookingEmitterFactory::create($db);
            $emitter->emit([
                'reservation_id' => $reservationId,
                'user_id'        => $userId,
                'user_name'      => $_SESSION['user']['name'] ?? 'Unknown',
                'court_id'       => $courtId,
                'court_name'     => $courtName,
                'date'           => $date,
                'start_time'     => $startTime,
                'end_time'       => $endTime,
                'payment_type'   => $paymentContext->getType(),
                'total_price'    => $totalPrice,
            ]);

            $this->redirect('/reservations');

        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            http_response_code(500);
            die('Booking failed: ' . $e->getMessage());
        }
    }

    /**
     * GET /booking/cancel?id=X
     *
     * Marks the reservation as cancelled (only the owning user can do this).
     * Replaces booking_actions/cancel.php.
     */
    public function cancelBooking(): void
    {
        // Auth guard — must be logged in
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        $reservationId = (int) ($_GET['id'] ?? 0);
        $userId        = (int) $_SESSION['user']['id'];

        if ($reservationId <= 0) {
            http_response_code(400);
            die('Invalid reservation id.');
        }

        $db = Database::getInstance()->getConnection();

        try {
            $db->beginTransaction();

            // Lock the row and verify ownership
            $stmt = $db->prepare(
                'SELECT * FROM reservations WHERE id = :id AND user_id = :user_id FOR UPDATE'
            );
            $stmt->execute(['id' => $reservationId, 'user_id' => $userId]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                throw new \RuntimeException('Reservation not found.');
            }

            $db->prepare('UPDATE reservations SET status = :status WHERE id = :id')
               ->execute(['status' => 'cancelled', 'id' => $reservationId]);

            $db->commit();

            $this->redirect('/reservations');

        } catch (\Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            http_response_code(500);
            die('Cancel failed: ' . $e->getMessage());
        }
    }
}