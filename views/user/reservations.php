<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

require_once __DIR__ . '/../../core/Database.php';
$db = Database::getInstance()->getConnection();
$userId = (int) $_SESSION['user']['id'];

$reservations = $bookings ?? [];


// --- Observer Pattern: fetch and display unread confirmation notifications ---
$notifications = [];
try {
    $notifStmt = $db->prepare(
        'SELECT id, message FROM notifications
         WHERE type = :type AND user_id = :user_id AND is_read = 0
         ORDER BY created_at DESC'
    );
    $notifStmt->execute(['type' => 'user', 'user_id' => $userId]);
    $notifications = $notifStmt->fetchAll();

    if (!empty($notifications)) {
        $ids = implode(',', array_map(static fn($n) => (int) $n['id'], $notifications));
        $db->exec("UPDATE notifications SET is_read = 1 WHERE id IN ({$ids})");
    }
} catch (\Throwable $e) {
    // Non-fatal — notifications are a convenience feature
    $notifications = [];
}

?>

<section style="margin-top:120px;">
    <div class="container">
        <div class="card">
            <h1>My Reservations</h1>

            <?php if (!empty($notifications)): ?>
                <div class="notification-banner" style="
                    background: linear-gradient(135deg, #1a7a4a, #22c55e);
                    color: #fff;
                    border-radius: 10px;
                    padding: 14px 20px;
                    margin-bottom: 20px;
                    box-shadow: 0 4px 15px rgba(34,197,94,0.3);
                ">
                    <?php foreach ($notifications as $notif): ?>
                        <p style="margin: 4px 0; font-size: 0.95rem;">
                            ✅ <?php echo htmlspecialchars($notif['message']); ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (empty($reservations)): ?>
                <p>No reservations found.</p>
            <?php else: ?>
                <?php foreach ($reservations as $reservation): ?>
                    <div class="card">
                        <p><strong>Venue:</strong> <?php echo htmlspecialchars((string) ($reservation['venue_name'] ?? 'N/A')); ?></p>
                        <p><strong>Court:</strong> <?php echo htmlspecialchars((string) ($reservation['court_name'] ?? 'N/A')); ?></p>

                        <p><strong>Date:</strong> <?php echo htmlspecialchars((string) ($reservation['reservation_date'] ?? '-')); ?></p>
                        <p>
                            <strong>Time:</strong>
                            <?php
                            $timeDisplay = $reservation['reservation_time'] ?? '';
                            if ($timeDisplay === '' && !empty($reservation['start_time']) && !empty($reservation['end_time'])) {
                                $timeDisplay = substr((string) $reservation['start_time'], 0, 5) . ' - ' . substr((string) $reservation['end_time'], 0, 5);
                            }
                            echo htmlspecialchars((string) ($timeDisplay ?: '-'));
                            ?>
                        </p>
                        <p><strong>Price:</strong> <?php echo htmlspecialchars((string) ($reservation['total_price'] ?? '-')); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars((string) ($reservation['status'] ?? 'confirmed')); ?></p>
                        <p><strong>Payment Status:</strong> <?php echo htmlspecialchars((string) ($reservation['payment_status'] ?? 'pending')); ?></p>

                        <?php if (($reservation['status'] ?? '') !== 'cancelled'): ?>
                            <a class="btn btn-outline" href="<?php echo BASE_URL; ?>/booking/cancel?id=<?php echo (int) $reservation['id']; ?>">
                                Cancel Booking
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
