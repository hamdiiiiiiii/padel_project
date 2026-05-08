<<<<<<< HEAD
<?php

session_start();

require_once __DIR__ . '/controllers/BookingController.php';

$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
define('BASE_URL', ($basePath === '/' || $basePath === '.') ? '' : $basePath);

(new BookingController())->booking();
=======
<?php

session_start();

require_once __DIR__ . '/controllers/BookingController.php';

$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
define('BASE_URL', ($basePath === '/' || $basePath === '.') ? '' : $basePath);

(new BookingController())->booking();
>>>>>>> 33f0fd7199ed9b6d860ae47c0bc1bd16e492bba8
