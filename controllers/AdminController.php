<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Database.php';

class AdminController extends Controller
{
    private $db;

    public function __construct()
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Admin access check — delegates to AuthGuard (SRP, DRY)
        $this->requireAdmin();

        $this->db = Database::getInstance()->getConnection();
    }

    protected function renderAdmin(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }

    public function dashboard(): void
    {
        // Get stats
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        $totalUsers = $stmt->fetchColumn();

        $stmt = $this->db->query("SELECT COUNT(*) FROM reservations");
        $totalBookings = $stmt->fetchColumn();

        $stmt = $this->db->query("SELECT SUM(total_price) FROM reservations WHERE payment_status = 'paid'");
        $totalRevenue = $stmt->fetchColumn() ?? 0;

        $stmt = $this->db->query("SELECT COUNT(*) FROM courts WHERE is_active = 1");
        $activeCourts = $stmt->fetchColumn();

        // Get recent bookings
        $stmt = $this->db->query("
            SELECT r.*, u.name as user_name, c.name as court_name, v.name as venue_name 
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            JOIN courts c ON r.court_id = c.id
            JOIN venues v ON c.venue_id = v.id
            ORDER BY r.created_at DESC
            LIMIT 5
        ");
        $recentBookings = $stmt->fetchAll();

        $this->renderAdmin('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'activeCourts' => $activeCourts,
            'recentBookings' => $recentBookings
        ]);
    }

    public function bookings(): void
    {
        // Get filter values
        $filter_status = $_GET['status'] ?? 'all';
        $filter_date = $_GET['date'] ?? '';

        // Build query
        $sql = "
            SELECT r.*, u.name as user_name, u.email as user_email, c.name as court_name, v.name as venue_name 
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            JOIN courts c ON r.court_id = c.id
            JOIN venues v ON c.venue_id = v.id
            WHERE 1=1
        ";
        $params = [];

        if ($filter_status !== 'all') {
            $sql .= " AND r.status = ?";
            $params[] = $filter_status;
        }

        if ($filter_date) {
            $sql .= " AND r.reservation_date = ?";
            $params[] = $filter_date;
        }

        $sql .= " ORDER BY r.reservation_date DESC, r.start_time DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $bookings = $stmt->fetchAll();

        $this->renderAdmin('admin/bookings', [
            'bookings' => $bookings,
            'filter_status' => $filter_status,
            'filter_date' => $filter_date
        ]);
    }

    public function updateBooking(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
            $booking_id = (int)$_POST['booking_id'];
            $new_status = $_POST['new_status'];
            
            if ($new_status === 'completed') {
                $stmt = $this->db->prepare("UPDATE reservations SET status = ?, payment_status = 'paid' WHERE id = ?");
                $stmt->execute([$new_status, $booking_id]);
            } else {
                $stmt = $this->db->prepare("UPDATE reservations SET status = ? WHERE id = ?");
                $stmt->execute([$new_status, $booking_id]);
            }
        }
        $this->redirect('/admin/bookings');
    }


    public function deleteBooking(): void
    {
        if (isset($_GET['delete'])) {
            $id = (int)$_GET['delete'];
            $stmt = $this->db->prepare("DELETE FROM reservations WHERE id = ?");
            $stmt->execute([$id]);
        }
        $this->redirect('/admin/bookings');
    }

    public function venues(): void
    {
        $venues = $this->db->query("SELECT * FROM venues ORDER BY id")->fetchAll();
        $this->renderAdmin('admin/venues', ['venues' => $venues]);
    }

    public function addVenue(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
            $name = $_POST['name'] ?? '';
            $location = $_POST['location'] ?? '';
            $price = $_POST['price'] ?? 0;
            $type = $_POST['type'] ?? 'Indoor';
            
            if ($name && $location && $price) {
                $stmt = $this->db->prepare("INSERT INTO venues (name, location, price, type, status) VALUES (?, ?, ?, ?, 'available')");
                $stmt->execute([$name, $location, $price, $type]);
            }
        }
        $this->redirect('/admin/venues');
    }

    public function deleteVenue(): void
    {
        if (isset($_GET['delete'])) {
            $id = (int)$_GET['delete'];
            $stmt = $this->db->prepare("DELETE FROM venues WHERE id = ?");
            $stmt->execute([$id]);
        }
        $this->redirect('/admin/venues');
    }

    public function toggleVenueStatus(): void
    {
        if (isset($_GET['toggle'])) {
            $id = (int)$_GET['toggle'];
            $stmt = $this->db->prepare("UPDATE venues SET status = IF(status = 'available', 'busy', 'available') WHERE id = ?");
            $stmt->execute([$id]);
        }
        $this->redirect('/admin/venues');
    }

    public function courts(): void
    {
        $venueId = (int)($_GET['venue_id'] ?? 0);
        if (!$venueId) {
            $this->redirect('/admin/venues');
            return;
        }

        $venueStmt = $this->db->prepare("SELECT * FROM venues WHERE id = ?");
        $venueStmt->execute([$venueId]);
        $venue = $venueStmt->fetch();

        if (!$venue) {
            $this->redirect('/admin/venues');
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM courts WHERE venue_id = ? ORDER BY id");
        $stmt->execute([$venueId]);
        $courts = $stmt->fetchAll();

        $this->renderAdmin('admin/venue_courts', [
            'venue' => $venue,
            'courts' => $courts
        ]);
    }

    public function addCourt(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
            $venueId = (int)($_POST['venue_id'] ?? 0);
            $name = $_POST['name'] ?? '';
            
            if ($venueId && $name) {
                $stmt = $this->db->prepare("INSERT INTO courts (venue_id, name) VALUES (?, ?)");
                $stmt->execute([$venueId, $name]);
            }
            $this->redirect('/admin/courts?venue_id=' . $venueId);
        } else {
            $this->redirect('/admin/venues');
        }
    }

    public function deleteCourt(): void
    {
        $venueId = (int)($_GET['venue_id'] ?? 0);
        if (isset($_GET['delete'])) {
            $id = (int)$_GET['delete'];
            $stmt = $this->db->prepare("DELETE FROM courts WHERE id = ?");
            $stmt->execute([$id]);
        }
        if ($venueId) {
            $this->redirect('/admin/courts?venue_id=' . $venueId);
        } else {
            $this->redirect('/admin/venues');
        }
    }


    public function users(): void
    {
        $users = $this->db->query("
            SELECT u.*, COUNT(r.id) as booking_count 
            FROM users u
            LEFT JOIN reservations r ON u.id = r.user_id
            GROUP BY u.id
            ORDER BY u.id
        ")->fetchAll();
        $this->renderAdmin('admin/users', ['users' => $users]);
    }

    public function addUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $role = $_POST['role'] ?? 'user';
            
            if ($name && $email && $password) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("INSERT INTO users (name, email, password_hash, phone, role) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $password_hash, $phone, $role]);
            }
        }
        $this->redirect('/admin/users');
    }

    public function deleteUser(): void
    {
        if (isset($_GET['delete'])) {
            $id = (int)$_GET['delete'];
            
            // Don't delete yourself
            if ($id != $_SESSION['user']['id']) {
                // Delete user's reservations first due to foreign key constraint
                $stmt = $this->db->prepare("DELETE FROM reservations WHERE user_id = ?");
                $stmt->execute([$id]);

                // Then delete the user
                $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$id]);
            }
        }
        $this->redirect('/admin/users');
    }


    public function toggleUserRole(): void
    {
        if (isset($_GET['toggle_role'])) {
            $id = (int)$_GET['toggle_role'];
            
            // Don't change your own role
            if ($id != $_SESSION['user']['id']) {
                $stmt = $this->db->prepare("UPDATE users SET role = IF(role = 'admin', 'user', 'admin') WHERE id = ?");
                $stmt->execute([$id]);
            }
        }
        $this->redirect('/admin/users');
    }

    public function payments(): void
    {
        // Get payment statistics
        $stmt = $this->db->query("SELECT SUM(total_price) FROM reservations WHERE payment_status = 'paid'");
        $totalRevenue = $stmt->fetchColumn() ?? 0;

        $stmt = $this->db->query("SELECT COUNT(*) FROM reservations WHERE payment_type IS NOT NULL");
        $totalPayments = $stmt->fetchColumn() ?? 0;

        $stmt = $this->db->query("SELECT COUNT(*) FROM reservations WHERE payment_status = 'paid'");
        $successfulPayments = $stmt->fetchColumn() ?? 0;

        $stmt = $this->db->query("SELECT COUNT(*) FROM reservations WHERE payment_status = 'failed'");
        $failedPayments = $stmt->fetchColumn() ?? 0;

        // Get all payments
        $payments = $this->db->query("
            SELECT r.*, u.name as user_name, u.email, c.name as court_name, v.name as venue_name 
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            JOIN courts c ON r.court_id = c.id
            JOIN venues v ON c.venue_id = v.id
            WHERE r.payment_type IS NOT NULL
            ORDER BY r.created_at DESC
        ")->fetchAll();

        $this->renderAdmin('admin/payments', [
            'totalRevenue' => $totalRevenue,
            'totalPayments' => $totalPayments,
            'successfulPayments' => $successfulPayments,
            'failedPayments' => $failedPayments,
            'payments' => $payments
        ]);
    }

    /**
     * GET  /admin/generate-slots  — show form
     * POST /admin/generate-slots  — bulk-insert time_slots rows
     *
     * Moved from admin/generate-slots.php into the MVC router.
     */
    public function generateSlots(): void
    {
        $courts = $this->db->query('
            SELECT c.id, c.name as court_name, v.name as venue_name 
            FROM courts c 
            JOIN venues v ON c.venue_id = v.id 
            ORDER BY v.name ASC, c.name ASC
        ')->fetchAll();
        $successMessage = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $dateFrom = trim($_POST['date_from'] ?? '');
                $dateTo   = trim($_POST['date_to']   ?? '');
                $courtId  = (int) ($_POST['court_id'] ?? 0);

                if ($dateFrom === '' || $dateTo === '') {
                    throw new \RuntimeException('Please select a start and end date.');
                }
                if ($dateFrom > $dateTo) {
                    throw new \RuntimeException('Start date cannot be after end date.');
                }

                $courtIds = [];
                if ($courtId > 0) {
                    $courtIds[] = $courtId;
                } else {
                    foreach ($courts as $court) {
                        $courtIds[] = (int) $court['id'];
                    }
                }

                $inserted    = 0;
                $startDate   = new \DateTimeImmutable($dateFrom);
                $endDate     = new \DateTimeImmutable($dateTo);
                $insertStmt  = $this->db->prepare(
                    'INSERT INTO time_slots (court_id, slot_date, start_time, end_time, is_available)
                     SELECT :court_id, :slot_date, :start_time, :end_time, 1
                     FROM DUAL
                     WHERE NOT EXISTS (
                         SELECT 1 FROM time_slots
                         WHERE court_id  = :court_id_check
                           AND slot_date = :slot_date_check
                           AND start_time = :start_time_check
                           AND end_time   = :end_time_check
                     )'
                );

                for ($date = $startDate; $date <= $endDate; $date = $date->modify('+1 day')) {
                    $slotDate = $date->format('Y-m-d');
                    foreach ($courtIds as $cid) {
                        for ($hour = 8; $hour < 22; $hour++) {
                            $startTime = sprintf('%02d:00:00', $hour);
                            $endTime   = sprintf('%02d:00:00', $hour + 1);
                            $insertStmt->execute([
                                'court_id'         => $cid,
                                'slot_date'        => $slotDate,
                                'start_time'       => $startTime,
                                'end_time'         => $endTime,
                                'court_id_check'   => $cid,
                                'slot_date_check'  => $slotDate,
                                'start_time_check' => $startTime,
                                'end_time_check'   => $endTime,
                            ]);
                            $inserted += $insertStmt->rowCount();
                        }
                    }
                }

                $successMessage = "Slots generated successfully. New slots inserted: {$inserted}.";
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }
        }

        $this->renderAdmin('admin/generate_slots', [
            'courts'         => $courts,
            'successMessage' => $successMessage,
            'error'          => $error,
        ]);
    }
}
