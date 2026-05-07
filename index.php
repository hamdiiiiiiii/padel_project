<?php
require_once 'core/Database.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'courts';
$db = Database::getInstance()->getConnection();

// Basic HTML layout header
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PadelPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  </head>
  <body>
    <header class="header">
      <nav class="navbar">
        <div class="container">
          <div class="nav-wrapper">
            <a href="index.php?page=courts" class="logo">
              <span class="logo-icon">🎾</span>
              <span class="logo-text">PadelPro</span>
            </a>
            <ul class="nav-menu">
              <li class="nav-item">
                <a href="index.php?page=courts" class="nav-link <?= $page == 'courts' ? 'active' : '' ?>">Home</a>
              </li>
              <li class="nav-item">
                <a href="index.php?page=courts" class="nav-link">Book Court</a>
              </li>
            </ul>
            <div class="nav-actions">
              <a href="index.php?page=login" class="btn btn-outline">Login</a>
              <a href="index.php?page=register" class="btn btn-primary">Register</a>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <div style="margin-top: 100px;">
<?php

if ($page == 'courts') {
    // Fetch courts from DB
    $stmt = $db->query("SELECT * FROM courts");
    $courts = $stmt->fetchAll();
    ?>
    <section class="courts-preview">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Our Padel Courts</h2>
          <p class="section-subtitle">Choose from our premium courts at convenient locations</p>
        </div>
        <div class="courts-grid">
          <?php foreach ($courts as $court): ?>
          <div class="court-card">
            <div class="court-image">
              <span class="court-icon">🏟️</span>
              <span class="court-status <?= strtolower($court['status']) ?>"><?= ucfirst($court['status']) ?></span>
            </div>
            <div class="court-details">
              <h3 class="court-name"><?= htmlspecialchars($court['name']) ?></h3>
              <p class="court-location"><?= htmlspecialchars($court['location']) ?></p>
              <div class="court-info">
                <span class="court-price">EGP<?= htmlspecialchars($court['price']) ?>/hour</span>
                <span class="court-type"><?= htmlspecialchars($court['type']) ?></span>
              </div>
              <div style="margin-top: 15px;">
                  <a href="index.php?page=court&id=<?= $court['id'] ?>" class="btn btn-primary btn-block">View Details</a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php
} elseif ($page == 'court') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $stmt = $db->prepare("SELECT * FROM courts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $court = $stmt->fetch();
    if ($court) {
        echo "<div class='container'><h2>Court Details: " . htmlspecialchars($court['name']) . "</h2>";
        echo "<p>Location: " . htmlspecialchars($court['location']) . "</p>";
        echo "<p>Price: EGP" . htmlspecialchars($court['price']) . "/hour</p>";
        echo "<p>Type: " . htmlspecialchars($court['type']) . "</p>";
        echo "<a href='index.php?page=courts' class='btn btn-outline'>Back to Courts</a></div>";
    } else {
        echo "<div class='container'><h2>Court not found</h2></div>";
    }
} elseif ($page == 'login') {
    echo "<div class='container'><h2>Login Form</h2><p>Login functionality under development.</p></div>";
} elseif ($page == 'register') {
    echo "<div class='container'><h2>Register Form</h2><p>Registration functionality under development.</p></div>";
} else {
    echo "<div class='container'><h2>Page not found</h2></div>";
}

?>
    </div>
  </body>
</html>
