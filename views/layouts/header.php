<?php if (!isset($activePage)) { $activePage = ''; } ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PadelPro</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/base.css">
    <?php if (!empty($pageStyles) && is_array($pageStyles)): ?>
        <?php foreach ($pageStyles as $styleFile): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL . '/' . ltrim($styleFile, '/'); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo BASE_URL; ?>/home" class="logo">
                    <span class="logo-icon">🎾</span>
                    <span class="logo-text">PadelPro</span>
                </a>
                <ul class="nav-menu">
                    <li class="nav-item">
                       <a href="<?php echo BASE_URL; ?>/home" class="nav-link <?php echo $activePage === 'home' ? 'active' : ''; ?>">
    Home
</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/booking" class="nav-link <?php echo $activePage === 'booking' ? 'active' : ''; ?>">Book Court</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL; ?>/about" class="nav-link <?php echo $activePage === 'about' ? 'active' : ''; ?>">About Us</a>
                    </li>
                </ul>
                <div class="nav-actions">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                            <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-outline">Admin Panel</a>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-outline">Dashboard</a>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-primary">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">Login</a>
                        <a href="<?php echo BASE_URL; ?>/register" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>