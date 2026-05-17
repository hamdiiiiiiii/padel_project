<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Courts - PadelPro Admin</title>

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
            <h2 class="section-title">Manage Courts for <?= htmlspecialchars($venue['name']) ?></h2>
            <p class="section-subtitle">Add or remove physical courts inside this venue</p>
            <a href="<?= BASE_URL ?>/admin/venues" class="btn btn-secondary" style="margin-top: 10px; display: inline-block;">Back to Venues</a>
        </div>

        <!-- ADD COURT FORM -->
        <div class="form-card">
            <h3>Add New Court to <?= htmlspecialchars($venue['name']) ?></h3>
            <form method="POST" action="<?= BASE_URL ?>/admin/courts/add" class="form-grid">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="venue_id" value="<?= $venue['id'] ?>">
                <input type="text" name="name" placeholder="Court Name (e.g. Court 1, Court 2)" required>
                <button type="submit" class="btn btn-primary">Add Court</button>
            </form>
        </div>

        <!-- COURTS LIST -->
        <div class="table-section">
            <h3>Courts in <?= htmlspecialchars($venue['name']) ?></h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Court Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courts)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">No courts added yet.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach($courts as $court): ?>
                        <tr>
                            <td><?= $court['id'] ?></td>
                            <td><?= htmlspecialchars($court['name']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/admin/courts/delete?delete=<?= $court['id'] ?>&venue_id=<?= $venue['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete this court?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

</body>
</html>
