<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../../core/Database.php';

// Admin access check
if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: ../../login');
    exit();
}

$db = Database::getInstance()->getConnection();

// Get payment statistics
$stmt = $db->query("SELECT SUM(total_price) FROM reservations WHERE payment_status = 'paid'");
$totalRevenue = $stmt->fetchColumn() ?? 0;

$stmt = $db->query("SELECT COUNT(*) FROM reservations WHERE payment_type IS NOT NULL");
$totalPayments = $stmt->fetchColumn() ?? 0;

$stmt = $db->query("SELECT COUNT(*) FROM reservations WHERE payment_status = 'paid'");
$successfulPayments = $stmt->fetchColumn() ?? 0;

$stmt = $db->query("SELECT COUNT(*) FROM reservations WHERE payment_status = 'failed'");
$failedPayments = $stmt->fetchColumn() ?? 0;

// Get all payments
$payments = $db->query("
    SELECT r.*, u.name as user_name, u.email, c.name as court_name 
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    JOIN courts c ON r.court_id = c.id
    WHERE r.payment_type IS NOT NULL
    ORDER BY r.created_at DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Payments - PadelPro Admin</title>

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
                    <li><a href="admin-bookings.php" class="nav-link">Bookings</a></li>
                    <li><a href="admin-users.php" class="nav-link">Users</a></li>
                    <li><a href="admin-payments.php" class="nav-link active">Payments</a></li>
                </ul>
                
            </div>
        </div>
    </nav>
</header>

<!-- ================= CONTENT ================= -->
<section class="admin-section">
    <div class="container">

        <div class="section-header">
            <h2 class="section-title">Payments Overview</h2>
            <p class="section-subtitle">Track all transactions and revenue</p>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="dashboard-cards">
            <div class="card stat-card">
                <i class="fas fa-wallet"></i>
                <h3>EGP <?= number_format($totalRevenue, 0) ?></h3>
                <p>Total Revenue</p>
            </div>

            <div class="card stat-card">
                <i class="fas fa-credit-card"></i>
                <h3><?= $totalPayments ?></h3>
                <p>Total Payments</p>
            </div>

            <div class="card stat-card">
                <i class="fas fa-check-circle"></i>
                <h3><?= $successfulPayments ?></h3>
                <p>Successful</p>
            </div>

            <div class="card stat-card">
                <i class="fas fa-times-circle"></i>
                <h3><?= $failedPayments ?></h3>
                <p>Failed</p>
            </div>
        </div>

        <!-- PAYMENTS TABLE -->
        <div class="table-section">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Court</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($payments) == 0): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No payments found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($payments as $payment): ?>
                        <tr>
                            <td><?= htmlspecialchars($payment['user_name']) ?></td>
                            <td><?= htmlspecialchars($payment['court_name']) ?></td>
                            <td>EGP <?= number_format($payment['total_price'], 0) ?></td>
                            <td><?= ucfirst($payment['payment_type'] ?? 'N/A') ?></td>
                            <td>
                                <span class="status <?= $payment['payment_status'] == 'paid' ? 'confirmed' : ($payment['payment_status'] == 'failed' ? 'pending' : 'pending') ?>">
                                    <?= ucfirst($payment['payment_status'] ?? 'pending') ?>
                                </span>
                            </td>
                            <td><?= date('Y-m-d H:i', strtotime($payment['created_at'])) ?></td>
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