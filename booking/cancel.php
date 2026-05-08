<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require_once __DIR__ . '/../core/Database.php';

// BASE_URL must point to the project root (two levels up from /booking/cancel.php)
if (!defined('BASE_URL')) {
    $scriptDir = dirname(dirname($_SERVER['SCRIPT_NAME']));
    $basePath = rtrim($scriptDir, '/');
    define('BASE_URL', ($basePath === '/' || $basePath === '.' || $basePath === '') ? '' : $basePath);
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

    // The time_slots table has been removed from the design.
    // Cancelling a booking is handled simply by updating its status to 'cancelled' in the reservations table.

    $db->commit();
    header('Location: ' . BASE_URL . '/reservations');
    exit;
} catch (Throwable $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    die('Cancel failed: ' . $e->getMessage());
}
