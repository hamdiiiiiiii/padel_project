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

// Get stats
$stmt = $db->query("SELECT COUNT(*) FROM users");
$totalUsers = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(*) FROM reservations");
$totalBookings = $stmt->fetchColumn();

$stmt = $db->query("SELECT SUM(total_price) FROM reservations WHERE payment_status = 'paid'");
$totalRevenue = $stmt->fetchColumn() ?? 0;

$stmt = $db->query("SELECT COUNT(*) FROM courts WHERE is_active = 1");
$activeCourts = $stmt->fetchColumn();

// Get recent bookings
$stmt = $db->query("
    SELECT r.*, u.name as user_name, c.name as court_name 
    FROM reservations r
    JOIN users u ON r.user_id = u.id
    JOIN courts c ON r.court_id = c.id
    ORDER BY r.created_at DESC
    LIMIT 5
");
$recentBookings = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - PadelPro</title>
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
          <li><a href="admin.php" class="nav-link active">Dashboard</a></li>
          <li><a href="admin-courts.php" class="nav-link">Courts</a></li>
          <li><a href="admin-bookings.php" class="nav-link">Bookings</a></li>
          <li><a href="admin-users.php" class="nav-link">Users</a></li>
          <li><a href="admin-payments.php" class="nav-link">Payments</a></li>
        </ul>

        

      </div>
    </div>
  </nav>
</header>

<!-- ================= DASHBOARD CONTENT ================= -->
<section class="admin-dashboard">
  <div class="container">

    <div class="section-header">
      <h2 class="section-title">Admin Dashboard</h2>
      <p class="section-subtitle">Overview of your Padel Reservation System</p>
    </div>

    <!-- STATS CARDS -->
    <div class="dashboard-cards">

      <div class="card stat-card">
        <i class="fas fa-users"></i>
        <h3><?= $totalUsers ?></h3>
        <p>Total Users</p>
      </div>

      <div class="card stat-card">
        <i class="fas fa-calendar-check"></i>
        <h3><?= $totalBookings ?></h3>
        <p>Total Bookings</p>
      </div>

      <div class="card stat-card">
        <i class="fas fa-dollar-sign"></i>
        <h3>EGP <?= number_format($totalRevenue, 0) ?></h3>
        <p>Revenue</p>
      </div>

      <div class="card stat-card">
        <i class="fas fa-table-tennis"></i>
        <h3><?= $activeCourts ?></h3>
        <p>Active Courts</p>
      </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="quick-actions">

      <h3>Quick Actions</h3>

      <div class="actions-grid">

        <a href="admin-courts.php" class="action-card">
          <i class="fas fa-plus-circle"></i>
          <p>Add Court</p>
        </a>

        <a href="admin-bookings.php" class="action-card">
          <i class="fas fa-eye"></i>
          <p>View Bookings</p>
        </a>

        <a href="admin-users.php" class="action-card">
          <i class="fas fa-user-cog"></i>
          <p>Manage Users</p>
        </a>

        <a href="admin-payments.php" class="action-card">
          <i class="fas fa-credit-card"></i>
          <p>Payments</p>
        </a>

      </div>
    </div>

    <!-- RECENT BOOKINGS -->
    <div class="recent-section">
      <h3>Recent Bookings</h3>

      <table class="admin-table">
        <thead>
          <tr>
            <th>User</th>
            <th>Court</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach($recentBookings as $booking): ?>
          <tr>
            <td><?= htmlspecialchars($booking['user_name']) ?></td>
            <td><?= htmlspecialchars($booking['court_name']) ?></td>
            <td><?= $booking['reservation_date'] ?></td>
            <td><?= date('g:i A', strtotime($booking['start_time'])) ?></td>
            <td>
              <span class="status <?= strtolower($booking['status']) ?>">
                <?= ucfirst($booking['status']) ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
          
          <?php if(count($recentBookings) == 0): ?>
          <tr>
            <td colspan="5" style="text-align: center;">No bookings yet</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>

    </div>

  </div>
</section>

<script src="js/admin-dashboard.js"></script>
</body>
</html>