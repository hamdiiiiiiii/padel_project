<?php

session_start();

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/controllers/CourtController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';

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
    (new UserController())->dashboard();
    exit;
}

http_response_code(404);
echo 'Page not found.';
