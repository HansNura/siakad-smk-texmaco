<?php

session_start();
$_SESSION['error'] = 'asdad';
require_once 'app/controllers/ProductController.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/AuthController.php';
require_once 'config/Route.php';
require_once 'config/Middleware.php';

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;

$routes = new Route();

$routes->get('/', [HomeController::class, 'index'], 'authMiddleware');
$routes->get('/dashboard', [HomeController::class, 'index'], 'authMiddleware');
$routes->get('/login', [AuthController::class, 'login']);
$routes->post('/login', [AuthController::class, 'submitLogin']);
$routes->get('/logout', [AuthController::class, 'logout'], 'authMiddleware');

$routes->get('/product', [ProductController::class, 'index'], 'authMiddleware');
$routes->get('/product/create', [ProductController::class, 'create'], 'authMiddleware');
$routes->post('/product', [ProductController::class, 'store'], 'authMiddleware');

$routes->run();