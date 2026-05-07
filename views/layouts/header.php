<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel Booking</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
        nav { background: #1f2937; padding: 12px 20px; }
        nav a { color: #fff; margin-right: 14px; text-decoration: none; }
        .container { max-width: 1000px; margin: 20px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 16px; margin-bottom: 14px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; }
        input, button { width: 100%; padding: 10px; margin: 6px 0; box-sizing: border-box; }
        button { background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body>
    <nav>
        <a href="<?php echo BASE_URL; ?>/courts">Courts</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="<?php echo BASE_URL; ?>/dashboard">Dashboard</a>
            <a href="<?php echo BASE_URL; ?>/logout">Logout</a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/login">Login</a>
            <a href="<?php echo BASE_URL; ?>/register">Register</a>
        <?php endif; ?>
    </nav>
    <div class="container">
