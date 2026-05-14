<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - PadelPro</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/admin-home.css"/>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header">
  <nav class="navbar">
    <div class="container">
      <div class="nav-wrapper">

        <a href="<?= BASE_URL ?>/admin" class="logo">
          <span class="logo-icon">🎾</span>
          <span class="logo-text">PadelPro Admin</span>
        </a>

        <ul class="nav-menu">
          <li><a href="<?= BASE_URL ?>/admin" class="nav-link active">Dashboard</a></li>
          <li><a href="<?= BASE_URL ?>/admin/courts" class="nav-link">Courts</a></li>
          <li><a href="<?= BASE_URL ?>/admin/bookings" class="nav-link">Bookings</a></li>
          <li><a href="<?= BASE_URL ?>/admin/users" class="nav-link">Users</a></li>
          <li><a href="<?= BASE_URL ?>/admin/payments" class="nav-link">Payments</a></li>
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

        <a href="<?= BASE_URL ?>/admin/courts" class="action-card">
          <i class="fas fa-plus-circle"></i>
          <p>Add Court</p>
        </a>

        <a href="<?= BASE_URL ?>/admin/bookings" class="action-card">
          <i class="fas fa-eye"></i>
          <p>View Bookings</p>
        </a>

        <a href="<?= BASE_URL ?>/admin/users" class="action-card">
          <i class="fas fa-user-cog"></i>
          <p>Manage Users</p>
        </a>

        <a href="<?= BASE_URL ?>/admin/payments" class="action-card">
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

<script src="<?= BASE_URL ?>/js/admin-dashboard.js"></script>
</body>
</html>
