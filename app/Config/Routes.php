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
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/layanan', 'LayananController::index');
$routes->get('/referensi', 'ReferensiController::index');
$routes->get('/organisasi', 'OrganisasiController::index');

$routes->get('/admin/referensi/', 'Admin\ReferensiController::index');
$routes->get('/admin/referensi/create', 'Admin\ReferensiController::create');
$routes->post('/admin/referensi/store', 'Admin\ReferensiController::store');
$routes->get('/admin/referensi/edit/(:segment)', 'Admin\ReferensiController::edit/$1');
$routes->post('/admin/referensi/update/(:segment)', 'Admin\ReferensiController::update/$1');
$routes->get('/admin/referensi/delete/(:segment)', 'Admin\ReferensiController::delete/$1');
$routes->post('/admin/referensi/addCategory', 'Admin\referensi\ReferensiController::addCategory');

$routes->get('/admin/adminreferensi', 'Admin\ReferensiController::index');
