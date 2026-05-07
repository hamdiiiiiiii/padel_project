<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json');

require_once __DIR__ . '/../core/Database.php';

try {
    $courtId = (int) ($_GET['court_id'] ?? 0);
    $slotDate = trim($_GET['date'] ?? '');

    if ($courtId <= 0 || $slotDate === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'court_id and date are required.']);
        exit;
    }

    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare(
        'SELECT id, start_time, end_time
         FROM time_slots
         WHERE court_id = :court_id AND slot_date = :slot_date AND is_available = 1
         ORDER BY start_time ASC'
    );
    $stmt->execute([
        'court_id' => $courtId,
        'slot_date' => $slotDate,
    ]);

    $slots = [];
    foreach ($stmt->fetchAll() as $row) {
        $start = substr((string) $row['start_time'], 0, 5);
        $end = substr((string) $row['end_time'], 0, 5);
        $slots[] = [
            'id' => (int) $row['id'],
            'start_time' => $start,
            'end_time' => $end,
            'label' => $start . ' - ' . $end,
        ];
    }

    echo json_encode(['success' => true, 'slots' => $slots]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
