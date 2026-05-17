<?php
$activePage = 'booking';
$pageStyles = ['css/book.css'];
?>
<div class="booking-page">
    <div class="container">
        <div class="page-header">
            <h1>Choose Your Venue</h1>
            <p>Select a location to see available courts</p>
        </div>

        <!-- AVAILABLE Venues -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot green"></span>
                <h2>AVAILABLE VENUES</h2>
            </div>
            
            <div class="courts-grid">
                <?php if (!empty($venues)): ?>
                    <?php foreach ($venues as $venue): ?>
                        <?php if (($venue['status'] ?? 'available') === 'available'): ?>
                        <div class="court-card" onclick="goToVenueCourts(<?php echo $venue['id']; ?>)">
                            <div class="court-card-header">
                                <span class="court-icon">🏟️</span>
                                <span class="status available">Available</span>
                            </div>
                            <div class="court-card-body">
                                <h3><?php echo htmlspecialchars($venue['name']); ?></h3>
                                <p>📍 <?php echo htmlspecialchars($venue['location']); ?></p>
                                <div class="price">EGP<?php echo number_format($venue['price']); ?>/hour</div>
                                <div class="type"><?php echo htmlspecialchars($venue['type']); ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No venues available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>




<script>
function goToVenueCourts(venueId) {
    window.location.href = '<?php echo defined('BASE_URL') ? BASE_URL : ''; ?>/booking/courts?venue_id=' + venueId;
}
</script>