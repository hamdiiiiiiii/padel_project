<?php
$activePage = 'booking';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Court</title>

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/book.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<?php require_once __DIR__ . '/views/layouts/header.php'; ?>

    <div class="courts-grid">

      <!-- Court 1 -->
      <div class="court-card" onclick="goToReservation('Central Court',400)">
        <div class="court-image">
          <span class="court-icon">🏟️</span>
          <span class="court-status available">Available</span>
        </div>
        <div class="court-details">
          <h3 class="court-name">Central Court</h3>
          <p class="court-location">📍 Mivida</p>
          <div class="court-info">
            <span class="court-price">EGP400/hour</span>
            <span class="court-type">Indoor</span>
          </div>
        </div>
      </div>

      <!-- Court 2 -->
      <div class="court-card" onclick="goToReservation('Lakeside Court',450)">
        <div class="court-image">
          <span class="court-icon">🏟️</span>
          <span class="court-status available">Available</span>
        </div>
        <div class="court-details">
          <h3 class="court-name">Lakeside Court</h3>
          <p class="court-location">📍 Hyde Park Sports Club</p>
          <div class="court-info">
            <span class="court-price">EGP450/hour</span>
            <span class="court-type">Outdoor</span>
          </div>
        </div>
      </div>

      <!-- Court 3 -->
      <div class="court-card" onclick="goToReservation('Elite Arena',350)">
        <div class="court-image">
          <span class="court-icon">🏟️</span>
          <span class="court-status busy">Popular</span>
        </div>
        <div class="court-details">
          <h3 class="court-name">Elite Arena</h3>
          <p class="court-location">📍 Cairo Stadium</p>
          <div class="court-info">
            <span class="court-price">EGP350/hour</span>
            <span class="court-type">Indoor</span>
          </div>
        </div>
      </div>

      <!-- Court 4 -->
      <div class="court-card" onclick="goToReservation('Pro Court',500)">
        <div class="court-image">
          <span class="court-icon">🏟️</span>
          <span class="court-status available">Available</span>
        </div>
        <div class="court-details">
          <h3 class="court-name">Pro Court</h3>
          <p class="court-location">📍 New Cairo Club</p>
          <div class="court-info">
            <span class="court-price">EGP500/hour</span>
            <span class="court-type">Premium</span>
          </div>
        </div>
      </div>

    </div>
  </div>

</section>

<script src="../js/book.js"></script>

</body>
</html>