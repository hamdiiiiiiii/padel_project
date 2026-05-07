<div class="card">
    <h1>Welcome, <?php echo htmlspecialchars($user['name'] ?? 'User'); ?>!</h1>
    <p>Your bookings:</p>

    <?php if (empty($bookings)): ?>
        <p>No bookings yet.</p>
    <?php else: ?>
        <?php foreach ($bookings as $booking): ?>
            <div class="card">
                <strong><?php echo htmlspecialchars($booking['court_name'] ?? 'Court'); ?></strong><br>
                Date: <?php echo htmlspecialchars($booking['reservation_date'] ?? ''); ?><br>
                Time: <?php echo htmlspecialchars($booking['reservation_time'] ?? ''); ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
