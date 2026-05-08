<<<<<<< Updated upstream
<?php
$activePage = 'home';
require_once __DIR__ . '/core/Database.php';
$db = Database::getInstance()->getConnection();
?>

// Basic HTML layout header
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Book your padel court easily online. Reserve courts, choose time slots, and pay securely."
    />
    <title>PadelPro - Book Your Padel Court Online</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  </head>
  <body>
 
    <?php require_once __DIR__ . '/views/layouts/header.php'; ?>
 
    <!--start Hero Section -->
    <section class="hero">
      <div class="container">
        <div class="hero-content">
          <div class="hero-text">
            <h1 class="hero-title">
              Book Your Padel Court
              <span class="highlight">In Seconds</span>
            </h1>
            <p class="hero-description">
              Skip the phone calls and long queues. Reserve your favorite padel
              court online, choose your preferred time slot, and pay securely.
              Your game awaits!
            </p>
            <div class="hero-features">
              <div class="feature-tag">
                <i class="feature-icon">✓</i>
                <span>Instant Booking</span>
              </div>
              <div class="feature-tag">
                <i class="feature-icon">✓</i>
                <span>Secure Payment</span>
              </div>
              <div class="feature-tag">
                <i class="feature-icon">✓</i>
                <span>24/7 Access</span>
              </div>
            </div>
            <div class="hero-cta">
              <a href="#" class="btn btn-primary btn-large">Book a Court Now</a>
              <a href="#" class="btn btn-outline btn-large">View Available Courts</a>
            </div>
          </div>
          <div class="hero-image">
            <div class="booking-card">
              <div class="booking-card-header">
                <h3>Quick Booking</h3>
                <span class="badge">2 mins</span>
              </div>
              <div class="booking-card-body">
                <div class="booking-step">
                  <div class="step-number">1</div>
                  <div class="step-text">Choose your court</div>
                </div>
                <div class="booking-step">
                  <div class="step-number">2</div>
                  <div class="step-text">Select time slot</div>
                </div>
                <div class="booking-step">
                  <div class="step-number">3</div>
                  <div class="step-text">Complete payment</div>
                </div>
              </div>
              <div class="booking-card-footer">
                <a href="#" class="btn btn-primary btn-block">Start Booking</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--end Hero Section -->
 
    <!--start How It Works Section -->
    <section class="how-it-works">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">How It Works</h2>
          <p class="section-subtitle">Simple steps to get you on the court</p>
        </div>
        <div class="steps-grid">
          <div class="step-card">
            <div class="step-icon">🎾</div>
            <h3 class="step-title">Browse Courts</h3>
            <p class="step-description">
              View all available padel courts with their locations, status, and
              hourly rates.
            </p>
          </div>
          <div class="step-card">
            <div class="step-icon">📅</div>
            <h3 class="step-title">Select Time Slot</h3>
            <p class="step-description">
              Choose from available time slots that fit your schedule. Real-time
              availability updates.
            </p>
          </div>
          <div class="step-card">
            <div class="step-icon">💳</div>
            <h3 class="step-title">Pay & Confirm</h3>
            <p class="step-description">
              Complete your booking with secure payment. Receive instant
              confirmation.
            </p>
          </div>
          <div class="step-card">
            <div class="step-icon">🏸</div>
            <h3 class="step-title">Play & Enjoy</h3>
            <p class="step-description">
              Show up at your reserved time and enjoy your game. No waiting, no
              hassle.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!--end How It Works Section -->
 
    <!--start Features Section -->
    <section class="features">
      <div class="container">
        <div class="features-grid">
          <div class="feature-card">
            <div class="feature-icon-wrapper">⚡</div>
            <h3 class="feature-title">Real-Time Availability</h3>
            <p class="feature-description">
              See up-to-date court availability and avoid double bookings with
              our automated system.
            </p>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrapper">🔒</div>
            <h3 class="feature-title">Secure Payments</h3>
            <p class="feature-description">
              Your payments are protected with industry-standard security.
              Multiple payment methods supported.
            </p>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrapper">📱</div>
            <h3 class="feature-title">Mobile Friendly</h3>
            <p class="feature-description">
              Book courts on the go. Our platform works perfectly on all
              devices.
            </p>
          </div>
          <div class="feature-card">
            <div class="feature-icon-wrapper">📊</div>
            <h3 class="feature-title">Booking History</h3>
            <p class="feature-description">
              Track all your reservations in one place. Easy to manage and
              reschedule.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!--end Features Section -->
 
    <!--start Padel Courts Section -->
    <section class="courts-preview">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Our Padel Courts</h2>
          <p class="section-subtitle">
            Choose from our premium courts at convenient locations
          </p>
        </div>
        <div class="courts-grid">
          <div class="court-card">
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
          <div class="court-card">
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
          <div class="court-card">
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
          <div class="court-card">
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
    <!--end Padel Courts Section -->
 
    <!--start Ready to Play Section -->
    <section class="cta">
      <div class="container">
        <div class="cta-content">
          <h2 class="cta-title">Ready to Play?</h2>
          <p class="cta-text">
            Join thousands of players who book their courts online. Sign up now
            and get instant access to all our courts.
          </p>
          <div class="cta-buttons">
            <a href="#" class="btn btn-primary btn-large">Create Free Account</a>
            <a href="#" class="btn btn-outline btn-large">View Pricing</a>
          </div>
        </div>
      </div>
    </section>
    <!--end Ready to Play Section -->
 
    <?php require_once __DIR__ . '/views/layouts/footer.php'; ?>
 
  </body>
</html>
=======
<?php
session_start();
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/controllers/CourtController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/BookingController.php';
require_once __DIR__ . '/controllers/HomeController.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
define('BASE_URL', ($basePath === '/' || $basePath === '.') ? '' : $basePath);

if ($basePath !== '' && $basePath !== '/') {
    if (str_starts_with($requestUri, $basePath)) {
        $requestUri = substr($requestUri, strlen($basePath));
    }
}

$path = rtrim($requestUri, '/');
$path = $path === '' ? '/' : $path;
$method = $_SERVER['REQUEST_METHOD'];
if ($path === '/' || $path === '/home') {
    (new HomeController())->index();
    exit;
}
if ($path === '/' || $path === '/courts') {
    (new CourtController())->index();
    exit;
}

if (preg_match('#^/court/(\d+)$#', $path, $matches)) {
    (new CourtController())->show((int) $matches[1]);
    exit;
}

if ($path === '/login' && $method === 'GET') {
    (new AuthController())->login();
    exit;
}

if ($path === '/login' && $method === 'POST') {
    (new AuthController())->doLogin();
    exit;
}

if ($path === '/register' && $method === 'GET') {
    (new AuthController())->register();
    exit;
}

if ($path === '/register' && $method === 'POST') {
    (new AuthController())->doRegister();
    exit;
}

if ($path === '/logout') {
    (new AuthController())->logout();
    exit;
}

if ($path === '/dashboard') {
    (new UserController())->reservations();
    exit;
}

if ($path === '/reservations') {
    (new UserController())->reservations();
    exit;
}

if ($path === '/booking') {
    (new BookingController())->booking();
    exit;
}

if ($path === '/payment') {
    (new BookingController())->payment();
    exit;
}

if ($path === '/reservation') {
    (new BookingController())->reservation();
    exit;
}

http_response_code(404);
echo 'Page not found.';
>>>>>>> Stashed changes
