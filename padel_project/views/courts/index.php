<section class="courts-preview" style="margin-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Available Courts</h2>
        </div>
        <?php if (empty($courts)): ?>
            <p>No courts found.</p>
        <?php else: ?>
            <div class="courts-grid">
                <?php foreach ($courts as $court): ?>
                    <div class="court-card">
                        <div class="court-details">
                            <h3 class="court-name"><?php echo htmlspecialchars($court['name'] ?? 'Court'); ?></h3>
                            <p class="court-location">📍 <?php echo htmlspecialchars($court['location'] ?? 'N/A'); ?></p>
                            <a href="<?php echo BASE_URL; ?>/court/<?php echo (int) $court['id']; ?>">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
