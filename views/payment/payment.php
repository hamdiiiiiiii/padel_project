<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$courtId = (int) ($_GET['court_id'] ?? 0);
$courtName = trim($_GET['court_name'] ?? '');
$date = trim($_GET['date'] ?? '');
$startTime = trim($_GET['start_time'] ?? '');
$endTime = trim($_GET['end_time'] ?? '');
$price = trim($_GET['price'] ?? '0');
?>

<section class="payment-section" style="margin-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Payment</h2>
            <p class="section-subtitle">Complete your booking securely</p>
        </div>

        <div class="card">
            <h3>Booking Summary</h3>
            <p><strong>Court:</strong> <span id="court"><?php echo htmlspecialchars($courtName); ?></span></p>
            <p><strong>Date:</strong> <span id="date"><?php echo htmlspecialchars($date); ?></span></p>
            <p><strong>Time:</strong> <span id="time"><?php echo htmlspecialchars($startTime . ' - ' . $endTime); ?></span></p>
            <div class="price-box">
                <span>Total:</span>
                <span id="price" class="price"><?php echo htmlspecialchars($price); ?></span> EGP
            </div>
        </div>

        <div class="card">
            <h3>Payment Method</h3>
            <form method="POST" action="<?php echo BASE_URL; ?>/booking/process.php">
                <label class="radio">
                    <input type="radio" name="payment_type" value="on_court" checked>
                    Pay On Court
                </label>
                <p>Online payment will be added later. For now, your booking will be confirmed with on-court payment.</p>

                <input type="hidden" name="court_id" value="<?php echo (int) $courtId; ?>">
                <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
                <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($startTime); ?>">
                <input type="hidden" name="end_time" value="<?php echo htmlspecialchars($endTime); ?>">
                <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($price); ?>">

                <button id="payBtn" class="btn btn-primary btn-block" type="submit">
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>
</section>
