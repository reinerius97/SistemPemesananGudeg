<?php

namespace Config;

use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\Home;
use App\Controllers\MenuController;
use App\Controllers\OrderController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\AdminMenuController;
use App\Controllers\Admin\AdminOrderController;
use App\Controllers\Admin\ReportController;

$routes = Services::routes();

$routes->get('/', [Home::class, 'index']);
$routes->get('/promo', [Home::class, 'promo']);
$routes->get('/tentang', [Home::class, 'tentang']);
$routes->get('/kontak', [Home::class, 'kontak']);
$routes->get('fix-admin', 'FixAdmin::index');

$routes->group('auth', function ($routes) {
    $routes->get('login', [AuthController::class, 'login']);
    $routes->post('login', [AuthController::class, 'attemptLogin']);
    $routes->get('register', [AuthController::class, 'register']);
    $routes->post('register', [AuthController::class, 'attemptRegister']);
    $routes->get('logout', [AuthController::class, 'logout']);
});

$routes->group('menu', function ($routes) {
    $routes->get('/', [MenuController::class, 'index']);
    $routes->get('detail/(:num)', [MenuController::class, 'detail/$1']);
});

$routes->group('cart', function ($routes) {
    $routes->get('/', [CartController::class, 'index']);
    $routes->post('add', [CartController::class, 'add']);
    $routes->post('update', [CartController::class, 'update']);
    $routes->post('remove', [CartController::class, 'remove']);
    $routes->get('checkout', [CartController::class, 'checkout']);
    $routes->post('processCheckout', [CartController::class, 'processCheckout']); // ← DI SINI!
    $routes->get('success/(:num)', 'CartController::success/$1');

});

$routes->group('orders', function ($routes) {
    $routes->get('history', [OrderController::class, 'history']);
    $routes->get('detail/(:num)', [OrderController::class, 'detail/$1']);
});

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', [DashboardController::class, 'index']);
    $routes->get('dashboard/filter', [DashboardController::class, 'filter']);
    
    $routes->group('menu', function ($routes) {
        $routes->get('/', [AdminMenuController::class, 'index']);
        $routes->get('create', [AdminMenuController::class, 'create']);
        $routes->post('/', [AdminMenuController::class, 'store']);
        $routes->get('edit/(:num)', [AdminMenuController::class, 'edit/$1']);
        $routes->post('update/(:num)', [AdminMenuController::class, 'update/$1']);
        $routes->post('delete/(:num)', [AdminMenuController::class, 'delete/$1']);
    });
    
    $routes->group('orders', function ($routes) {
        $routes->get('/', [AdminOrderController::class, 'index']);
        $routes->get('filter', [AdminOrderController::class, 'filter']);
        $routes->post('update-status/(:num)', [AdminOrderController::class, 'updateStatus/$1']);
        $routes->post('update-verifikasi/(:num)', [AdminOrderController::class, 'updateVerifikasi/$1']);

    });

    $routes->get('report', [ReportController::class, 'index']);
    $routes->get('report/filter', [ReportController::class, 'filter']);
});