<section class="courts-preview" style="margin-top:120px;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Available Courts</h2>
        </div>

        <?php if (empty($courts)): ?>
            <p class="no-courts-msg">No courts found at the moment. Please check back later!</p>
        <?php else: ?>
            <div class="courts-grid">
                <?php foreach ($courts as $court): ?>
                    <div class="court-card">
                        <div class="court-details">
                            <h3 class="court-name">
                                <?php echo htmlspecialchars($court['name'] ?? 'Padel Court'); ?>
                            </h3>
                            
                            <p class="court-location">
                                📍 <?php echo htmlspecialchars($court['location'] ?? 'Location TBD'); ?>
                            </p>

                            <p class="court-price">
                                <strong>Price:</strong> <?php echo htmlspecialchars($court['price_per_hour'] ?? '0'); ?> EGP/hr
                            </p>
                            
                            <a href="<?php echo BASE_URL; ?>/court/<?php echo (int) $court['id']; ?>" class="view-details-btn">
                                View Details & Book
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>