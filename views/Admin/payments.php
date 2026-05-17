<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Payments - PadelPro Admin</title>

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
                    <li><a href="<?= BASE_URL ?>/admin" class="nav-link">Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/courts" class="nav-link">Courts</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/bookings" class="nav-link">Bookings</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/users" class="nav-link">Users</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/payments" class="nav-link active">Payments</a></li>
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
                        <th>Venue</th>
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
                            <td colspan="7" style="text-align: center;">No payments found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($payments as $payment): ?>
                        <tr>
                            <td><?= htmlspecialchars($payment['user_name']) ?></td>
                            <td><?= htmlspecialchars($payment['venue_name']) ?></td>
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
