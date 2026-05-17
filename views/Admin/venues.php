<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Venues - PadelPro Admin</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin-home.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?= BASE_URL ?>/admin" class="logo">
                    <span class="logo-icon">🎾</span>
                    <span class="logo-text">PadelPro Admin</span>
                </a>
                <ul class="nav-menu">
                    <li><a href="<?= BASE_URL ?>/admin" class="nav-link">Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/venues" class="nav-link active">Venues</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/bookings" class="nav-link">Bookings</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/users" class="nav-link">Users</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/payments" class="nav-link">Payments</a></li>
                </ul>
               
            </div>
        </div>
    </nav>
</header>

<!-- ================= CONTENT ================= -->
<section class="admin-section">
    <div class="container">

        <div class="section-header">
            <h2 class="section-title">Manage Venues</h2>
            <p class="section-subtitle">Add, edit, or remove padel locations (Venues)</p>
        </div>

        <!-- ADD VENUE FORM -->
        <div class="form-card">
            <h3>Add New Venue</h3>
            <form method="POST" action="<?= BASE_URL ?>/admin/venues/add" class="form-grid">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Venue Name (e.g. Pro Court)" required>
                <input type="text" name="location" placeholder="Location" required>
                <input type="number" name="price" placeholder="Price per hour (EGP)" required>
                <select name="type">
                    <option value="Indoor">Indoor</option>
                    <option value="Outdoor">Outdoor</option>
                    <option value="Premium">Premium</option>
                </select>
                <button type="submit" class="btn btn-primary">Add Venue</button>
            </form>
        </div>

        <!-- VENUES LIST -->
        <div class="table-section">
            <h3>All Venues</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($venues as $venue): ?>
                    <tr>
                        <td><?= htmlspecialchars($venue['name']) ?></td>
                        <td><?= htmlspecialchars($venue['location']) ?></td>
                        <td>EGP <?= number_format($venue['price'], 0) ?></td>
                        <td><?= htmlspecialchars($venue['type']) ?></td>
                        <td>
                            <span class="status <?= $venue['status'] == 'available' ? 'confirmed' : 'pending' ?>">
                                <?= ucfirst($venue['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/courts?venue_id=<?= $venue['id'] ?>" class="action-btn view-btn">Manage Courts</a>
                            <a href="<?= BASE_URL ?>/admin/venues/toggle?toggle=<?= $venue['id'] ?>" class="action-btn view-btn">Toggle Status</a>
                            <a href="<?= BASE_URL ?>/admin/venues/delete?delete=<?= $venue['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete this venue?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

</body>
</html>
