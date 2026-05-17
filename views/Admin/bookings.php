<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Bookings - PadelPro Admin</title>

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
                    <li><a href="<?= BASE_URL ?>/admin/venues" class="nav-link">Venues</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/bookings" class="nav-link active">Bookings</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/users" class="nav-link">Users</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/payments" class="nav-link">Payments</a></li>
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
            <form method="GET" action="<?= BASE_URL ?>/admin/bookings" class="filter-form" style="display: flex; gap: 15px; flex-wrap: wrap;">
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
                    <a href="<?= BASE_URL ?>/admin/bookings" class="btn btn-outline">Clear Filters</a>
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
                            <td><?= htmlspecialchars($booking['venue_name'] . ' - ' . $booking['court_name']) ?></td>
                            <td><?= date('Y-m-d', strtotime($booking['reservation_date'])) ?></td>
                            <td><?= date('g:i A', strtotime($booking['start_time'])) ?> - <?= date('g:i A', strtotime($booking['end_time'])) ?></td>
                            <td>EGP <?= number_format($booking['total_price'], 0) ?></td>
                            <td>
                                <span class="status <?= strtolower($booking['status']) ?>">
                                    <?= ucfirst($booking['status']) ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>/admin/bookings/update" style="display: inline-block;" onsubmit="return confirm('Update booking status?')">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                    <select name="new_status" onchange="this.form.submit()" style="padding: 5px;">
                                        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="completed" <?= $booking['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </form>
                                <a href="<?= BASE_URL ?>/admin/bookings/delete?delete=<?= $booking['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete this booking?')">Delete</a>
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
