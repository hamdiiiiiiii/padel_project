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

// Handle Add Court
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $location = $_POST['location'] ?? '';
    $price = $_POST['price'] ?? 0;
    $type = $_POST['type'] ?? 'Indoor';
    
    if($name && $location && $price) {
        $stmt = $db->prepare("INSERT INTO courts (name, location, price, type, status) VALUES (?, ?, ?, ?, 'available')");
        $stmt->execute([$name, $location, $price, $type]);
    }
    header('Location: admin-courts.php');
    exit();
}

// Handle Delete Court
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM courts WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin-courts.php');
    exit();
}

// Handle Toggle Status
if(isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $stmt = $db->prepare("UPDATE courts SET status = IF(status = 'available', 'busy', 'available') WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin-courts.php');
    exit();
}

// Get all courts
$courts = $db->query("SELECT * FROM courts ORDER BY id")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Courts - PadelPro Admin</title>

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
                    <li><a href="admin-courts.php" class="nav-link active">Courts</a></li>
                    <li><a href="admin-bookings.php" class="nav-link">Bookings</a></li>
                    <li><a href="admin-users.php" class="nav-link">Users</a></li>
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
            <h2 class="section-title">Manage Courts</h2>
            <p class="section-subtitle">Add, edit, or remove padel courts</p>
        </div>

        <!-- ADD COURT FORM -->
        <div class="form-card">
            <h3>Add New Court</h3>
            <form method="POST" class="form-grid">
                <input type="hidden" name="action" value="add">
                <input type="text" name="name" placeholder="Court Name" required>
                <input type="text" name="location" placeholder="Location" required>
                <input type="number" name="price" placeholder="Price per hour (EGP)" required>
                <select name="type">
                    <option value="Indoor">Indoor</option>
                    <option value="Outdoor">Outdoor</option>
                    <option value="Premium">Premium</option>
                </select>
                <button type="submit" class="btn btn-primary">Add Court</button>
            </form>
        </div>

        <!-- COURTS LIST -->
        <div class="table-section">
            <h3>All Courts</h3>
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
                    <?php foreach($courts as $court): ?>
                    <tr>
                        <td><?= htmlspecialchars($court['name']) ?></td>
                        <td><?= htmlspecialchars($court['location']) ?></td>
                        <td>EGP <?= number_format($court['price'], 0) ?></td>
                        <td><?= htmlspecialchars($court['type']) ?></td>
                        <td>
                            <span class="status <?= $court['status'] == 'available' ? 'confirmed' : 'pending' ?>">
                                <?= ucfirst($court['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="?toggle=<?= $court['id'] ?>" class="action-btn view-btn">Toggle Status</a>
                            <a href="?delete=<?= $court['id'] ?>" class="action-btn cancel-btn" onclick="return confirm('Delete this court?')">Delete</a>
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