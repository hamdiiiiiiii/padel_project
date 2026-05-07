<section class="courts-preview" style="margin-top:120px;">
    <div class="container">
        <div class="court-card">
            <div class="court-details">
                <h1 class="court-name"><?php echo htmlspecialchars($court['name'] ?? 'Court'); ?></h1>
                <p class="court-location"><strong>Location:</strong> <?php echo htmlspecialchars($court['location'] ?? 'N/A'); ?></p>
                <p><strong>Price:</strong> <?php echo htmlspecialchars((string) ($court['price'] ?? 'N/A')); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($court['description'] ?? 'No description'); ?></p>
                <a href="<?php echo BASE_URL; ?>/courts">Back to courts</a>
            </div>
        </div>
    </div>
</section>
