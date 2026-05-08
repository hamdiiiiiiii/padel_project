<<<<<<< HEAD
<?php
$activePage = 'booking';
$pageStyles = ['css/book.css'];
?>
<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$folder = '/padel_project/padel_project';
define('BASE_URL', $protocol . '://' . $host . $folder);
?>  
<div class="booking-page">
    <div class="container">
        <div class="page-header">
            <h1>Choose Your Court</h1>
            <p>Select a court to continue your booking</p>
        </div>

        <!-- AVAILABLE Courts -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot green"></span>
                <h2>AVAILABLE</h2>
            </div>
            
            <div class="courts-grid">
                <div class="court-card" onclick="goToReservation(1, 'Central Court', 400)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status available">Available</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Central Court</h3>
                        <p>📍 Mivida</p>
                        <div class="price">EGP400/hour</div>
                    </div>
                </div>

                <div class="court-card" onclick="goToReservation(2, 'Lakeside Court', 450)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status available">Available</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Lakeside Court</h3>
                        <p>📍 Hyde Park Sports Club</p>
                        <div class="price">EGP450/hour</div>
                    </div>
                </div>

                <div class="court-card" onclick="goToReservation(3, 'Elite Arena', 350)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status popular">Popular</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Elite Arena</h3>
                        <p>📍 Cairo Stadium</p>
                        <div class="price">EGP350/hour</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- POPULAR Courts -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot orange"></span>
                <h2>POPULAR</h2>
            </div>
            
            <div class="courts-grid">
                <div class="court-card" onclick="goToReservation(4, 'Pro Court', 500)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status popular">Popular</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Pro Court</h3>
                        <p>📍 New Cairo Club</p>
                        <div class="price">EGP500/hour</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function goToReservation(courtId, courtName, price) {
    window.location.href = '<?php echo BASE_URL; ?>/reservation?court_id=' + courtId + '&court=' + encodeURIComponent(courtName) + '&price=' + price;
}
=======
<?php
$activePage = 'booking';
$pageStyles = ['css/book.css'];
?>
<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$folder = '/padel_project/padel_project';
define('BASE_URL', $protocol . '://' . $host . $folder);
?>  
<div class="booking-page">
    <div class="container">
        <div class="page-header">
            <h1>Choose Your Court</h1>
            <p>Select a court to continue your booking</p>
        </div>

        <!-- AVAILABLE Courts -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot green"></span>
                <h2>AVAILABLE</h2>
            </div>
            
            <div class="courts-grid">
                <div class="court-card" onclick="goToReservation(1, 'Central Court', 400)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status available">Available</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Central Court</h3>
                        <p>📍 Mivida</p>
                        <div class="price">EGP400/hour</div>
                    </div>
                </div>

                <div class="court-card" onclick="goToReservation(2, 'Lakeside Court', 450)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status available">Available</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Lakeside Court</h3>
                        <p>📍 Hyde Park Sports Club</p>
                        <div class="price">EGP450/hour</div>
                    </div>
                </div>

                <div class="court-card" onclick="goToReservation(3, 'Elite Arena', 350)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status popular">Popular</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Elite Arena</h3>
                        <p>📍 Cairo Stadium</p>
                        <div class="price">EGP350/hour</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- POPULAR Courts -->
        <div class="court-category">
            <div class="category-header">
                <span class="dot orange"></span>
                <h2>POPULAR</h2>
            </div>
            
            <div class="courts-grid">
                <div class="court-card" onclick="goToReservation(4, 'Pro Court', 500)">
                    <div class="court-card-header">
                        <span class="court-icon">🏟️</span>
                        <span class="status popular">Popular</span>
                    </div>
                    <div class="court-card-body">
                        <h3>Pro Court</h3>
                        <p>📍 New Cairo Club</p>
                        <div class="price">EGP500/hour</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function goToReservation(courtId, courtName, price) {
    window.location.href = '<?php echo BASE_URL; ?>/reservation?court_id=' + courtId + '&court=' + encodeURIComponent(courtName) + '&price=' + price;
}
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
</script>