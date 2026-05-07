<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require_once __DIR__ . '/../core/Database.php';

$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if (!defined('BASE_URL')) {
    define('BASE_URL', ($basePath === '/' || $basePath === '.') ? '' : $basePath);
}

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$reservationId = (int) ($_GET['id'] ?? 0);
$userId = (int) $_SESSION['user']['id'];

if ($reservationId <= 0) {
    die('Invalid reservation id.');
}

$db = Database::getInstance()->getConnection();

try {
    $db->beginTransaction();

    $reservationStmt = $db->prepare('SELECT * FROM reservations WHERE id = :id AND user_id = :user_id FOR UPDATE');
    $reservationStmt->execute([
        'id' => $reservationId,
        'user_id' => $userId,
    ]);
    $reservation = $reservationStmt->fetch();

    if (!$reservation) {
        throw new RuntimeException('Reservation not found.');
    }

    $columns = $db->query('SHOW COLUMNS FROM reservations')->fetchAll();
    $colNames = array_map(static fn(array $c): string => $c['Field'], $columns);
    if (in_array('status', $colNames, true)) {
        $updateReservation = $db->prepare('UPDATE reservations SET status = :status WHERE id = :id');
        $updateReservation->execute([
            'status' => 'cancelled',
            'id' => $reservationId,
        ]);
    }

    $slotDate = $reservation['reservation_date'] ?? null;
    $startTime = $reservation['start_time'] ?? null;
    $endTime = $reservation['end_time'] ?? null;

    if (($startTime === null || $endTime === null) && !empty($reservation['reservation_time'])) {
        $parts = explode('-', (string) $reservation['reservation_time']);
        if (count($parts) === 2) {
            $startTime = trim($parts[0]) . ':00';
            $endTime = trim($parts[1]) . ':00';
        }
    }

    if (!empty($slotDate) && !empty($startTime) && !empty($endTime)) {
        $freeSlot = $db->prepare(
            'UPDATE time_slots
             SET is_available = 1
             WHERE court_id = :court_id
               AND slot_date = :slot_date
               AND start_time = :start_time
               AND end_time = :end_time'
        );
        $freeSlot->execute([
            'court_id' => (int) $reservation['court_id'],
            'slot_date' => $slotDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
    }

    $db->commit();
    header('Location: ' . BASE_URL . '/reservations');
    exit;
} catch (Throwable $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    die('Cancel failed: ' . $e->getMessage());
}
