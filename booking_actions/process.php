<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require_once __DIR__ . '/../core/Database.php';

// BASE_URL must point to the project root (two levels up from /booking_actions/process.php)
if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME'])));
    $basePath = rtrim($scriptDir, '/');
    define('BASE_URL', ($basePath === '/' || $basePath === '.' || $basePath === '') ? '' : $basePath);
}

if (!isset($_SESSION['user'])) {
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    header('Location: ' . $scheme . '://' . $host . BASE_URL . '/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    header('Location: ' . $scheme . '://' . $host . BASE_URL . '/courts');
    exit;
}

$userId = (int) $_SESSION['user']['id'];
$courtId = (int) ($_POST['court_id'] ?? 0);
$date = trim($_POST['date'] ?? '');
$rawStartTime = trim($_POST['start_time'] ?? '');
$rawEndTime = trim($_POST['end_time'] ?? '');
$totalPrice = (float) ($_POST['total_price'] ?? 0);
$paymentType = trim($_POST['payment_type'] ?? 'on_court');
if ($paymentType === 'visa') {
    $paymentType = 'online';
}

if ($courtId <= 0 || $date === '' || $rawStartTime === '' || $rawEndTime === '') {
    die('Missing required booking data.');
}

if ($paymentType === 'online') {
    $cardHolderName = trim($_POST['card_holder_name'] ?? '');
    $cardNumber = preg_replace('/\D/', '', (string) ($_POST['card_number'] ?? ''));
    $expiryDate = trim($_POST['expiry_date'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    if ($cardHolderName === '' || !preg_match('/^\d{13,19}$/', $cardNumber) || !preg_match('/^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/', $expiryDate) || !preg_match('/^\d{3,4}$/', $cvv)) {
        die('Invalid Visa payment details.');
    }

    [$expiryMonth, $expiryYear] = explode('/', $expiryDate);
    $expiryMonth = (int) $expiryMonth;
    $expiryYear = (int) $expiryYear;
    if ($expiryYear < 100) {
        $expiryYear += 2000;
    }

    $expiry = DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-01', $expiryYear, $expiryMonth));
    $current = new DateTime('first day of this month');
    if ($expiry === false || $expiry < $current) {
        die('Visa card has expired.');
    }
}

// Convert "1 PM" format to MySQL "13:00:00" format
$startTime = date('H:i:s', strtotime($rawStartTime));
$endTime = date('H:i:s', strtotime($rawEndTime));

$db = Database::getInstance()->getConnection();

try {
    $db->beginTransaction();

    // Check for conflicting reservations
    $conflictStmt = $db->prepare(
        'SELECT id
         FROM reservations
         WHERE court_id = :court_id
           AND reservation_date = :slot_date
           AND status != "cancelled"
           AND (
               (start_time < :end_time AND end_time > :start_time)
           )
         FOR UPDATE'
    );
    $conflictStmt->execute([
        'court_id' => $courtId,
        'slot_date' => $date,
        'start_time' => $startTime,
        'end_time' => $endTime,
    ]);
    
    if ($conflictStmt->fetch()) {
        throw new RuntimeException('Selected time slot is already booked.');
    }

    $columns = $db->query('SHOW COLUMNS FROM reservations')->fetchAll();
    $colNames = array_map(static fn(array $c): string => $c['Field'], $columns);

    $insertFields = ['user_id', 'court_id'];
    $insertParams = ['user_id' => $userId, 'court_id' => $courtId];

    if (in_array('reservation_date', $colNames, true)) {
        $insertFields[] = 'reservation_date';
        $insertParams['reservation_date'] = $date;
    }
    if (in_array('start_time', $colNames, true)) {
        $insertFields[] = 'start_time';
        $insertParams['start_time'] = $startTime;
    }
    if (in_array('end_time', $colNames, true)) {
        $insertFields[] = 'end_time';
        $insertParams['end_time'] = $endTime;
    }
    if (in_array('total_price', $colNames, true)) {
        $insertFields[] = 'total_price';
        $insertParams['total_price'] = $totalPrice;
    }
    if (in_array('payment_type', $colNames, true)) {
        $insertFields[] = 'payment_type';
        $insertParams['payment_type'] = $paymentType;
    }
    if (in_array('status', $colNames, true)) {
        $insertFields[] = 'status';
        $insertParams['status'] = 'confirmed';
    }
    if (in_array('payment_status', $colNames, true)) {
        $insertFields[] = 'payment_status';
        $insertParams['payment_status'] = $paymentType === 'on_court' ? 'pending' : 'paid';
    }

    $fieldSql = implode(', ', $insertFields);
    $placeholders = implode(', ', array_map(static fn(string $f): string => ':' . $f, $insertFields));
    $insertSql = "INSERT INTO reservations ({$fieldSql}) VALUES ({$placeholders})";

    $insertStmt = $db->prepare($insertSql);
    $insertStmt->execute($insertParams);

    $db->commit();
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    header('Location: ' . $scheme . '://' . $host . BASE_URL . '/reservations');
    exit;
} catch (Throwable $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    die('Booking failed: ' . $e->getMessage());
}
