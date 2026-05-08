<<<<<<< HEAD
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

if (!isset($_SESSION['user']) || (($_SESSION['user']['role'] ?? '') !== 'admin')) {
    http_response_code(403);
    echo 'Access denied. Admin only.';
    exit;
}

$db = Database::getInstance()->getConnection();
$courts = $db->query('SELECT id, name FROM courts ORDER BY name ASC')->fetchAll();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dateFrom = trim($_POST['date_from'] ?? '');
        $dateTo = trim($_POST['date_to'] ?? '');
        $courtId = (int) ($_POST['court_id'] ?? 0);

        if ($dateFrom === '' || $dateTo === '') {
            throw new RuntimeException('Please select a start and end date.');
        }
        if ($dateFrom > $dateTo) {
            throw new RuntimeException('Start date cannot be after end date.');
        }

        $courtIds = [];
        if ($courtId > 0) {
            $courtIds[] = $courtId;
        } else {
            foreach ($courts as $court) {
                $courtIds[] = (int) $court['id'];
            }
        }

        $inserted = 0;
        $startDate = new DateTimeImmutable($dateFrom);
        $endDate = new DateTimeImmutable($dateTo);
        $insertStmt = $db->prepare(
            'INSERT INTO time_slots (court_id, slot_date, start_time, end_time, is_available)
             SELECT :court_id, :slot_date, :start_time, :end_time, 1
             FROM DUAL
             WHERE NOT EXISTS (
                 SELECT 1 FROM time_slots
                 WHERE court_id = :court_id_check
                   AND slot_date = :slot_date_check
                   AND start_time = :start_time_check
                   AND end_time = :end_time_check
             )'
        );

        for ($date = $startDate; $date <= $endDate; $date = $date->modify('+1 day')) {
            $slotDate = $date->format('Y-m-d');
            foreach ($courtIds as $cid) {
                for ($hour = 8; $hour < 22; $hour++) {
                    $startTime = sprintf('%02d:00:00', $hour);
                    $endTime = sprintf('%02d:00:00', $hour + 1);
                    $insertStmt->execute([
                        'court_id' => $cid,
                        'slot_date' => $slotDate,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'court_id_check' => $cid,
                        'slot_date_check' => $slotDate,
                        'start_time_check' => $startTime,
                        'end_time_check' => $endTime,
                    ]);
                    $inserted += $insertStmt->rowCount();
                }
            }
        }

        $message = "Slots generated successfully. New slots inserted: {$inserted}.";
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Time Slots</title>
</head>
<body>
    <h1>Generate Time Slots</h1>

    <?php if ($error !== ''): ?>
        <p style="color: #b00020;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($message !== ''): ?>
        <p style="color: #0a7d23;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="court_id">Court (optional):</label><br>
        <select name="court_id" id="court_id">
            <option value="0">All Courts</option>
            <?php foreach ($courts as $court): ?>
                <option value="<?php echo (int) $court['id']; ?>">
                    <?php echo htmlspecialchars($court['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="date_from">From date:</label><br>
        <input type="date" id="date_from" name="date_from" required>
        <br><br>

        <label for="date_to">To date:</label><br>
        <input type="date" id="date_to" name="date_to" required>
        <br><br>

        <button type="submit">Generate Slots (08:00 - 22:00)</button>
    </form>

    <p><a href="<?php echo BASE_URL; ?>/home">Back to Home</a></p>
</body>
</html>
=======
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

if (!isset($_SESSION['user']) || (($_SESSION['user']['role'] ?? '') !== 'admin')) {
    http_response_code(403);
    echo 'Access denied. Admin only.';
    exit;
}

$db = Database::getInstance()->getConnection();
$courts = $db->query('SELECT id, name FROM courts ORDER BY name ASC')->fetchAll();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dateFrom = trim($_POST['date_from'] ?? '');
        $dateTo = trim($_POST['date_to'] ?? '');
        $courtId = (int) ($_POST['court_id'] ?? 0);

        if ($dateFrom === '' || $dateTo === '') {
            throw new RuntimeException('Please select a start and end date.');
        }
        if ($dateFrom > $dateTo) {
            throw new RuntimeException('Start date cannot be after end date.');
        }

        $courtIds = [];
        if ($courtId > 0) {
            $courtIds[] = $courtId;
        } else {
            foreach ($courts as $court) {
                $courtIds[] = (int) $court['id'];
            }
        }

        $inserted = 0;
        $startDate = new DateTimeImmutable($dateFrom);
        $endDate = new DateTimeImmutable($dateTo);
        $insertStmt = $db->prepare(
            'INSERT INTO time_slots (court_id, slot_date, start_time, end_time, is_available)
             SELECT :court_id, :slot_date, :start_time, :end_time, 1
             FROM DUAL
             WHERE NOT EXISTS (
                 SELECT 1 FROM time_slots
                 WHERE court_id = :court_id_check
                   AND slot_date = :slot_date_check
                   AND start_time = :start_time_check
                   AND end_time = :end_time_check
             )'
        );

        for ($date = $startDate; $date <= $endDate; $date = $date->modify('+1 day')) {
            $slotDate = $date->format('Y-m-d');
            foreach ($courtIds as $cid) {
                for ($hour = 8; $hour < 22; $hour++) {
                    $startTime = sprintf('%02d:00:00', $hour);
                    $endTime = sprintf('%02d:00:00', $hour + 1);
                    $insertStmt->execute([
                        'court_id' => $cid,
                        'slot_date' => $slotDate,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'court_id_check' => $cid,
                        'slot_date_check' => $slotDate,
                        'start_time_check' => $startTime,
                        'end_time_check' => $endTime,
                    ]);
                    $inserted += $insertStmt->rowCount();
                }
            }
        }

        $message = "Slots generated successfully. New slots inserted: {$inserted}.";
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Time Slots</title>
</head>
<body>
    <h1>Generate Time Slots</h1>

    <?php if ($error !== ''): ?>
        <p style="color: #b00020;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($message !== ''): ?>
        <p style="color: #0a7d23;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="court_id">Court (optional):</label><br>
        <select name="court_id" id="court_id">
            <option value="0">All Courts</option>
            <?php foreach ($courts as $court): ?>
                <option value="<?php echo (int) $court['id']; ?>">
                    <?php echo htmlspecialchars($court['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="date_from">From date:</label><br>
        <input type="date" id="date_from" name="date_from" required>
        <br><br>

        <label for="date_to">To date:</label><br>
        <input type="date" id="date_to" name="date_to" required>
        <br><br>

        <button type="submit">Generate Slots (08:00 - 22:00)</button>
    </form>

    <p><a href="<?php echo BASE_URL; ?>/home">Back to Home</a></p>
</body>
</html>
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
