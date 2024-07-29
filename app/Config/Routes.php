<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/store', 'RegisterController::store');

$routes->get('/login', 'AuthController::login');
$routes->post('/loginAuth', 'AuthController::loginAuth');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/dashboard/detail_pengumuman/(:num)', 'DashboardController::detail_pengumuman/$1');

$routes->get('/layanan', 'LayananController::index');
$routes->get('/referensi', 'ReferensiController::index');
$routes->get('/organisasi', 'OrganisasiController::index');

$routes->get('/admin/dashboard', 'Admin\DashboardController::index');

// Referensi (Admin)
$routes->get('/admin/referensi/', 'Admin\ReferensiController::index');
$routes->get('/admin/referensi/create', 'Admin\ReferensiController::create');
$routes->post('/admin/referensi/store', 'Admin\ReferensiController::store');
$routes->get('/admin/referensi/edit/(:segment)', 'Admin\ReferensiController::edit/$1');
$routes->post('/admin/referensi/update/(:segment)', 'Admin\ReferensiController::update/$1');
$routes->get('/admin/referensi/delete/(:segment)', 'Admin\ReferensiController::delete/$1');
$routes->post('/admin/referensi/addCategory', 'Admin\ReferensiController::addCategory');

// Beranda (Admin)
$routes->get('/admin/beranda', 'Admin\BerandaController::index');
$routes->get('/admin/beranda/createSlider', 'Admin\BerandaController::createSlider');
$routes->post('/admin/beranda/storeSlider', 'Admin\BerandaController::storeSlider');
$routes->get('/admin/beranda/deleteSlider/(:segment)', 'Admin\BerandaController::deleteSlider/$1');

$routes->get('/admin/beranda/createPopup', 'Admin\BerandaController::createPopup');
$routes->post('/admin/beranda/storePopup', 'Admin\BerandaController::storePopup');
$routes->get('/admin/beranda/deletePopup/(:segment)', 'Admin\BerandaController::deletePopup/$1');

$routes->get('/admin/beranda/createCard', 'Admin\BerandaController::createCard');
$routes->post('/admin/beranda/storeCard', 'Admin\BerandaController::storeCard');
$routes->get('/admin/beranda/deleteCard/(:segment)', 'Admin\BerandaController::deleteCard/$1');

$routes->get('/admin/beranda/detail_pengumuman/(:num)', 'Admin\BerandaController::detail_pengumuman/$1');

// User Management (Admin)
$routes->get('/admin/users', 'Admin\UserController::index');
$routes->get('/admin/users/create', 'Admin\UserController::create');
$routes->post('/admin/users/store', 'Admin\UserController::store');
$routes->get('/admin/users/edit/(:segment)', 'Admin\UserController::edit/$1');
$routes->post('/admin/users/update/(:segment)', 'Admin\UserController::update/$1');
$routes->get('/admin/users/delete/(:segment)', 'Admin\UserController::delete/$1');








// Routes for User Management
$routes->get('/admin/users', 'Admin\UserController::index');
$routes->get('/admin/users/create', 'Admin\UserController::create');
$routes->post('/admin/users/store', 'Admin\UserController::store');
$routes->get('/admin/users/edit/(:segment)', 'Admin\UserController::edit/$1');
$routes->post('/admin/users/update/(:segment)', 'Admin\UserController::update/$1');
$routes->get('/admin/users/delete/(:segment)', 'Admin\UserController::delete/$1');
