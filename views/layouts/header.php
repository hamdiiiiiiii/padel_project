<<<<<<< HEAD
<<<<<<< Updated upstream
<?php
if (!isset($activePage)) $activePage = '';
?>

=======
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
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo BASE_URL; ?>/courts" class="logo">
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
                </ul>
                <div class="nav-actions">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-outline">Dashboard</a>
                        <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-primary">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">Login</a>
                        <a href="<?php echo BASE_URL; ?>/register" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
<<<<<<< HEAD

        <button class="mobile-menu-toggle">
          <span></span><span></span><span></span>
        </button>

      </div>
    </div>
  </nav>
</header>

<script>
(function () {

  const profileIconBtn = document.getElementById('profileIconBtn');
  const profileDropdown = document.getElementById('profileDropdown');
  const userInfoHeader = document.getElementById('userInfoHeader');
  const loginBtn = document.getElementById('loginBtn');
  const registerBtn = document.getElementById('registerBtn');
  const logoutItem = document.getElementById('logoutItem');

  // dropdown toggle
  if (profileIconBtn) {
    profileIconBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      profileDropdown.classList.toggle('show');
    });

    document.addEventListener('click', () => {
      profileDropdown.classList.remove('show');
    });
  }

  // login state
  function checkUser() {
    const user = localStorage.getItem('padelpro_current_user');

    if (user) {
      const u = JSON.parse(user);
      userInfoHeader.innerHTML = `<i class="fas fa-user"></i><span>${u.name || u.email}</span>`;

      if (loginBtn) loginBtn.style.display = 'none';
      if (registerBtn) registerBtn.style.display = 'none';
    } else {
      userInfoHeader.innerHTML = `<i class="fas fa-user"></i><span>Guest User</span>`;

      if (loginBtn) loginBtn.style.display = 'inline-block';
      if (registerBtn) registerBtn.style.display = 'inline-block';
    }
  }

  // logout
  if (logoutItem) {
    logoutItem.addEventListener('click', (e) => {
      e.preventDefault();
      localStorage.removeItem('padelpro_current_user');
      checkUser();
      location.reload();
    });
  }

  checkUser();

})();
</script>
=======
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
                <a href="<?php echo BASE_URL; ?>/courts" class="logo">
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
                </ul>
                <div class="nav-actions">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-outline">Dashboard</a>
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
>>>>>>> Stashed changes
=======
    </nav>
</header>
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
