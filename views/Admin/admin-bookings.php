<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../../core/Database.php';

// Admin access check
if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: /padel_project/padel_project/login');
    exit();
}

$db = Database::getInstance()->getConnection();

// Handle Status Update
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $booking_id = (int)$_POST['booking_id'];
    $new_status = $_POST['new_status'];
    
    $stmt = $db->prepare("UPDATE reservations SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $booking_id]);
    
    header('Location: admin-bookings.php');
    exit();
}

// Handle Delete Booking
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin-bookings.php');
    exit();
}

// Get filter values
$filter_status = $_GET['status'] ?? 'all';
$filter_date = $_GET['date'] ?? '';

// Build query
$sql = "
    SELECT r.*, u.name as user_name, u.email as user_email, c.name as court_name 
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    JOIN courts c ON r.court_id = c.id
    WHERE 1=1
";
$params = [];

if($filter_status !== 'all') {
    $sql .= " AND r.status = ?";
    $params[] = $filter_status;
}

if($filter_date) {
    $sql .= " AND r.reservation_date = ?";
    $params[] = $filter_date;
}

$sql .= " ORDER BY r.reservation_date DESC, r.start_time DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Bookings - PadelPro Admin</title>

    <link rel="stylesheet" href="../../css/admin-home.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="admin.php" class="logo">
                    <span class="logo-icon">🎾</span>
                    <span class="logo-text">PadelPro Admin</span>
                </a>
                <ul class="nav-menu">
                    <li><a href="admin.php" class="nav-link">Dashboard</a></li>
                    <li><a href="admin-courts.php" class="nav-link">Courts</a></li>
                    <li><a href="admin-bookings.php" class="nav-link active">Bookings</a></li>
                    <li><a href="admin-users.php" class="nav-link">Users</a></li>
                    <li><a href="admin-payments.php" class="nav-link">Payments</a></li>
                </ul>
                
            </div>
        </div>
    </nav>
</header>

<!-- ================= CONTENT ================= -->
<section class="admin-section">
    <div class="container">

        <div class="section-header">
            <h2 class="section-title">Manage Bookings</h2>
            <p class="section-subtitle">Approve, cancel, or monitor all reservations</p>
        </div>

        <!-- FILTER BAR -->
        <div class="filter-bar">
            <form method="GET" action="" class="filter-form" style="display: flex; gap: 15px; flex-wrap: wrap;">
                <select name="status">
                    <option value="all" <?= $filter_status == 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="pending" <?= $filter_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="confirmed" <?= $filter_status == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="cancelled" <?= $filter_status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    <option value="completed" <?= $filter_status == 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>

                <input type="date" name="date" value="<?= htmlspecialchars($filter_date) ?>" />

                <button type="submit" class="btn btn-primary">Filter</button>
                
                <?php if($filter_status != 'all' || $filter_date): ?>
                    <a href="admin-bookings.php" class="btn btn-outline">Clear Filters</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- BOOKINGS TABLE -->
        <div class="table-section">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Court</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($bookings) == 0): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No bookings found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['user_name']) ?></td>
                            <td><?= htmlspecialchars($booking['court_name']) ?></td>
                            <td><?= date('Y-m-d', strtotime($booking['reservation_date'])) ?></td>
                            <td><?= date('g:i A', strtotime($booking['start_time'])) ?> - <?= date('g:i A', strtotime($booking['end_time'])) ?></td>
                            <td>EGP <?= number_format($booking['total_price'], 0) ?></td>
                            <td>
                                <span class="status <?= strtolower($booking['status']) ?>">
                                    <?= ucfirst($booking['status']) ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" style="display: inline-block;" onsubmit="return confirm('Update booking status?')">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                    <select name="new_status" onchange="this.form.submit()" style="padding: 5px;">
                                        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="completed" <?= $booking['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </form>
                                <a href="?delete=<?= $booking['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete this booking?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

</body>
</html>