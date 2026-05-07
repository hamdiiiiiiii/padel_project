<div class="card">
    <h1><?php echo htmlspecialchars($court['name'] ?? 'Court'); ?></h1>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($court['location'] ?? 'N/A'); ?></p>
    <p><strong>Price:</strong> <?php echo htmlspecialchars((string) ($court['price'] ?? 'N/A')); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($court['description'] ?? 'No description'); ?></p>
    <a href="<?php echo BASE_URL; ?>/courts">Back to courts</a>
</div>
