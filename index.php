<?php
session_start();
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/controllers/CourtController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/BookingController.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AdminController.php';

$requestUri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = rtrim($basePath, '/');
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

if ($path === '/booking/process' && $method === 'POST') {
    (new BookingController())->processBooking();
    exit;
}

if ($path === '/booking/cancel' && $method === 'GET') {
    (new BookingController())->cancelBooking();
    exit;
}

// Admin Routes
if ($path === '/admin' && $method === 'GET') { (new AdminController())->dashboard(); exit; }

if ($path === '/admin/bookings' && $method === 'GET') { (new AdminController())->bookings(); exit; }
if ($path === '/admin/bookings/update' && $method === 'POST') { (new AdminController())->updateBooking(); exit; }
if ($path === '/admin/bookings/delete' && $method === 'GET') { (new AdminController())->deleteBooking(); exit; }

if ($path === '/admin/courts' && $method === 'GET') { (new AdminController())->courts(); exit; }
if ($path === '/admin/courts/add' && $method === 'POST') { (new AdminController())->addCourt(); exit; }
if ($path === '/admin/courts/delete' && $method === 'GET') { (new AdminController())->deleteCourt(); exit; }
if ($path === '/admin/courts/toggle' && $method === 'GET') { (new AdminController())->toggleCourtStatus(); exit; }

if ($path === '/admin/payments' && $method === 'GET') { (new AdminController())->payments(); exit; }

if ($path === '/admin/users' && $method === 'GET') { (new AdminController())->users(); exit; }
if ($path === '/admin/users/add' && $method === 'POST') { (new AdminController())->addUser(); exit; }
if ($path === '/admin/users/delete' && $method === 'GET') { (new AdminController())->deleteUser(); exit; }
if ($path === '/admin/users/toggle' && $method === 'GET') { (new AdminController())->toggleUserRole(); exit; }

http_response_code(404);
echo 'Page not found.';