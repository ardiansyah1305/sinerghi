<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/store', 'RegisterController::store');

$routes->get('/login', 'AuthController::login');
$routes->post('/loginAuth', 'AuthController::loginAuth');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/layanan', 'LayananController::index');
$routes->get('/referensi', 'ReferensiController::index');
$routes->get('/organisasi', 'OrganisasiController::index');

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('referensi/', 'Admin\ReferensiController::index');
    $routes->get('referensi/create', 'Admin\ReferensiController::create');
    $routes->post('referensi/store', 'Admin\ReferensiController::store');
    $routes->get('referensi/edit/(:segment)', 'Admin\ReferensiController::edit/$1');
    $routes->post('referensi/update/(:segment)', 'Admin\ReferensiController::update/$1');
    $routes->get('referensi/delete/(:segment)', 'Admin\ReferensiController::delete/$1');
    $routes->post('referensi/addCategory', 'Admin\ReferensiController::addCategory');

    // Routes for User Management
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:segment)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:segment)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:segment)', 'Admin\UserController::delete/$1');


    //Beranda
    $routes->get('beranda', 'Admin\BerandaController::index');
    $routes->post('beranda/storeSlider', 'Admin\BerandaController::storeSlider');
    $routes->get('beranda/deleteSlider/(:segment)', 'Admin\BerandaController::deleteSlider/$1');

    $routes->post('beranda/storePopup', 'Admin\BerandaController::storePopup');
    $routes->get('/admin/beranda/deletePopup/(:segment)', 'Admin\BerandaController::deletePopup/$1');

    $routes->post('beranda/storeCard', 'Admin\BerandaController::storeCard');
    $routes->get('beranda/deleteCard/(:segment)', 'Admin\BerandaController::deleteCard/$1');
    $routes->get('beranda/detail_pengumuman/(:num)', 'Admin\BerandaController::detail_pengumuman/$1');

});
