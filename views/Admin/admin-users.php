<<<<<<< HEAD
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../../core/Database.php';

// Admin access check
if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: /padel_project/padel_project/login');
    exit();
}

$db = Database::getInstance()->getConnection();

// Handle Delete User
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Don't delete yourself
    if($id != $_SESSION['user_id']) {
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: admin-users.php');
    exit();
}

// Handle Toggle Role (user/admin)
if(isset($_GET['toggle_role'])) {
    $id = (int)$_GET['toggle_role'];
    
    // Don't change your own role
    if($id != $_SESSION['user_id']) {
        $stmt = $db->prepare("UPDATE users SET role = IF(role = 'admin', 'user', 'admin') WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: admin-users.php');
    exit();
}

// Handle Add User
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    if($name && $email && $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (name, email, password_hash, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password_hash, $phone, $role]);
    }
    header('Location: admin-users.php');
    exit();
}

// Get all users with booking counts
$users = $db->query("
    SELECT u.*, COUNT(r.id) as booking_count 
    FROM users u
    LEFT JOIN reservations r ON u.id = r.user_id
    GROUP BY u.id
    ORDER BY u.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Users - PadelPro Admin</title>

    <link rel="stylesheet" href="../../css/admin-home.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="admin.php" class="logo">
                    <span class="logo-icon">🎾</span>
                    <span class="logo-text">PadelPro Admin</span>
                </a>
                <ul class="nav-menu">
                    <li><a href="admin.php" class="nav-link">Dashboard</a></li>
                    <li><a href="admin-courts.php" class="nav-link">Courts</a></li>
                    <li><a href="admin-bookings.php" class="nav-link">Bookings</a></li>
                    <li><a href="admin-users.php" class="nav-link active">Users</a></li>
                    <li><a href="admin-payments.php" class="nav-link">Payments</a></li>
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
            <form method="POST" class="form-grid">
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
                                <?php if($user['id'] != $_SESSION['user_id']): ?>
                                    <a href="?toggle_role=<?= $user['id'] ?>" class="action-btn view-btn" onclick="return confirm('Change role for <?= htmlspecialchars($user['name']) ?>?')">
                                        Toggle Role
                                    </a>
                                    <a href="?delete=<?= $user['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete user <?= htmlspecialchars($user['name']) ?>?')">
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
=======
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../../core/Database.php';

// Admin access check
if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: /padel_project/padel_project/login');
    exit();
}

$db = Database::getInstance()->getConnection();

// Handle Delete User
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Don't delete yourself
    if($id != $_SESSION['user_id']) {
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: admin-users.php');
    exit();
}

// Handle Toggle Role (user/admin)
if(isset($_GET['toggle_role'])) {
    $id = (int)$_GET['toggle_role'];
    
    // Don't change your own role
    if($id != $_SESSION['user_id']) {
        $stmt = $db->prepare("UPDATE users SET role = IF(role = 'admin', 'user', 'admin') WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: admin-users.php');
    exit();
}

// Handle Add User
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    if($name && $email && $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (name, email, password_hash, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password_hash, $phone, $role]);
    }
    header('Location: admin-users.php');
    exit();
}

// Get all users with booking counts
$users = $db->query("
    SELECT u.*, COUNT(r.id) as booking_count 
    FROM users u
    LEFT JOIN reservations r ON u.id = r.user_id
    GROUP BY u.id
    ORDER BY u.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Users - PadelPro Admin</title>

    <link rel="stylesheet" href="../../css/admin-home.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="admin.php" class="logo">
                    <span class="logo-icon">🎾</span>
                    <span class="logo-text">PadelPro Admin</span>
                </a>
                <ul class="nav-menu">
                    <li><a href="admin.php" class="nav-link">Dashboard</a></li>
                    <li><a href="admin-courts.php" class="nav-link">Courts</a></li>
                    <li><a href="admin-bookings.php" class="nav-link">Bookings</a></li>
                    <li><a href="admin-users.php" class="nav-link active">Users</a></li>
                    <li><a href="admin-payments.php" class="nav-link">Payments</a></li>
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
            <form method="POST" class="form-grid">
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
                                <?php if($user['id'] != $_SESSION['user_id']): ?>
                                    <a href="?toggle_role=<?= $user['id'] ?>" class="action-btn view-btn" onclick="return confirm('Change role for <?= htmlspecialchars($user['name']) ?>?')">
                                        Toggle Role
                                    </a>
                                    <a href="?delete=<?= $user['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete user <?= htmlspecialchars($user['name']) ?>?')">
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
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
</html>