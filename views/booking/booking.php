<?php
$activePage = 'booking';
$pageStyles = ['css/book.css'];
?>
<div class="booking-page">
    <div class="container">
        <div class="page-header">
            <h1>Choose Your Court</h1>
            <p>Select a court to continue your booking</p>
        </div>

        <!-- AVAILABLE Courts -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot green"></span>
                <h2>AVAILABLE</h2>
            </div>
            
            <div class="courts-grid">
                <?php if (!empty($courts)): ?>
                    <?php foreach ($courts as $court): ?>
                        <?php if (($court['status'] ?? 'available') === 'available'): ?>
                        <div class="court-card" onclick="goToReservation(<?php echo $court['id']; ?>, '<?php echo addslashes($court['name']); ?>', <?php echo $court['price']; ?>)">
                            <div class="court-card-header">
                                <span class="court-icon">🏟️</span>
                                <span class="status available">Available</span>
                            </div>
                            <div class="court-card-body">
                                <h3><?php echo htmlspecialchars($court['name']); ?></h3>
                                <p>📍 <?php echo htmlspecialchars($court['location']); ?></p>
                                <div class="price">EGP<?php echo number_format($court['price']); ?>/hour</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No courts available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- POPULAR/OTHER Courts -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot orange"></span>
                <h2>POPULAR / BUSY</h2>
            </div>
            
            <div class="courts-grid">
                <?php if (!empty($courts)): ?>
                    <?php foreach ($courts as $court): ?>
                        <?php if (($court['status'] ?? 'available') !== 'available'): ?>
                        <div class="court-card" onclick="goToReservation(<?php echo $court['id']; ?>, '<?php echo addslashes($court['name']); ?>', <?php echo $court['price']; ?>)">
                            <div class="court-card-header">
                                <span class="court-icon">🏟️</span>
                                <span class="status popular"><?php echo ucfirst(htmlspecialchars($court['status'])); ?></span>
                            </div>
                            <div class="court-card-body">
                                <h3><?php echo htmlspecialchars($court['name']); ?></h3>
                                <p>📍 <?php echo htmlspecialchars($court['location']); ?></p>
                                <div class="price">EGP<?php echo number_format($court['price']); ?>/hour</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
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