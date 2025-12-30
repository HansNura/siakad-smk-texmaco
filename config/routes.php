<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;

$routes = new Route();

$routes->get('/', [HomeController::class, 'index'], 'authMiddleware');
$routes->get('/dashboard', [HomeController::class, 'index'], 'authMiddleware');

$routes->get('/login', [AuthController::class, 'login']);
$routes->post('/login', [AuthController::class, 'submitLogin']);
$routes->get('/logout', [AuthController::class, 'logout'], 'authMiddleware');

// MANAJEMEN USER (Hanya Admin)
// middleware 'authMiddleware' dipasang sebagai lapisan keamanan pertama (harus login dulu)
$routes->get('/users', [App\Controllers\UserController::class, 'index'], 'authMiddleware');
$routes->get('/users/create', [App\Controllers\UserController::class, 'create'], 'authMiddleware');
$routes->post('/users/store', [App\Controllers\UserController::class, 'store'], 'authMiddleware');
$routes->get('/users/edit', [App\Controllers\UserController::class, 'edit'], 'authMiddleware');
$routes->post('/users/update', [App\Controllers\UserController::class, 'update'], 'authMiddleware');
$routes->get('/users/delete', [App\Controllers\UserController::class, 'destroy'], 'authMiddleware');

return $routes;