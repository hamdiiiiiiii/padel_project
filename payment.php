<?php

session_start();

require_once __DIR__ . '/controllers/BookingController.php';

$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
define('BASE_URL', ($basePath === '/' || $basePath === '.') ? '' : $basePath);

(new BookingController())->payment();
