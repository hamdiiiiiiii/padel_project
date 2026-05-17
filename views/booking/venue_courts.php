<?php
$activePage = 'booking';
$pageStyles = ['css/book.css'];
?>
<div class="booking-page">
    <div class="container">
        <div class="page-header">
            <h1>Choose Your Court</h1>
            <p>Select a specific court at <strong><?php echo htmlspecialchars($venue['name']); ?></strong></p>
            <a href="<?php echo BASE_URL; ?>/booking" class="btn btn-secondary" style="margin-top: 10px; display: inline-block;">Back to Venues</a>
        </div>

        <div class="court-category">
            <div class="category-header">
                <span class="dot green"></span>
                <h2>AVAILABLE COURTS</h2>
            </div>
            
            <div class="courts-grid">
                <?php if (!empty($courts)): ?>
                    <?php foreach ($courts as $court): ?>
                        <div class="court-card" onclick="goToReservation(<?php echo $court['id']; ?>, '<?php echo addslashes($venue['name'] . ' - ' . $court['name']); ?>', <?php echo $venue['price']; ?>)">
                            <div class="court-card-header">
                                <span class="court-icon">🎾</span>
                                <span class="status available">Available</span>
                            </div>
                            <div class="court-card-body">
                                <h3><?php echo htmlspecialchars($court['name']); ?></h3>
                                <p>Part of <?php echo htmlspecialchars($venue['name']); ?></p>
                                <div class="price">EGP<?php echo number_format($venue['price']); ?>/hour</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No courts available in this venue.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function goToReservation(courtId, courtName, price) {
    window.location.href = '<?php echo defined('BASE_URL') ? BASE_URL : ''; ?>/reservation?court_id=' + courtId + '&court=' + encodeURIComponent(courtName) + '&price=' + price;
}
</script>
