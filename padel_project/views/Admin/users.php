<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Users - PadelPro Admin</title>

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
                    <li><a href="<?= BASE_URL ?>/admin/courts" class="nav-link">Courts</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/bookings" class="nav-link">Bookings</a></li>
                    <li><a href="<?= BASE_URL ?>/admin/users" class="nav-link active">Users</a></li>
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
            <h2 class="section-title">Manage Users</h2>
            <p class="section-subtitle">View, add, or manage user roles</p>
        </div>

        <!-- ADD USER FORM -->
        <div class="form-card">
            <h3>Add New User</h3>
            <form method="POST" action="<?= BASE_URL ?>/admin/users/add" class="form-grid">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="phone" placeholder="Phone (optional)">
                <select name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>

        <!-- USERS TABLE -->
        <div class="table-section">
            <h3>All Users</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Bookings</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($users) == 0): ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No users found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                            <td>
                                <span class="status <?= $user['role'] == 'admin' ? 'confirmed' : 'pending' ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td><?= $user['booking_count'] ?></td>
                            <td>
                                <?php if($user['id'] != $_SESSION['user']['id']): ?>
                                    <a href="<?= BASE_URL ?>/admin/users/toggle?toggle_role=<?= $user['id'] ?>" class="action-btn view-btn" onclick="return confirm('Change role for <?= htmlspecialchars($user['name']) ?>?')">
                                        Toggle Role
                                    </a>
                                    <a href="<?= BASE_URL ?>/admin/users/delete?delete=<?= $user['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete user <?= htmlspecialchars($user['name']) ?>?')">
                                        Delete
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999;">(You)</span>
                                <?php endif; ?>
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
