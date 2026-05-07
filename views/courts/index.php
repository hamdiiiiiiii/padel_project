<h1>Available Courts</h1>

<?php if (empty($courts)): ?>
    <p>No courts found.</p>
<?php else: ?>
    <div class="grid">
        <?php foreach ($courts as $court): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($court['name'] ?? 'Court'); ?></h3>
                <p>Location: <?php echo htmlspecialchars($court['location'] ?? 'N/A'); ?></p>
                <a href="<?php echo BASE_URL; ?>/court/<?php echo (int) $court['id']; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
