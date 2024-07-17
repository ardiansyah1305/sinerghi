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


// Dashboard detail pengumuman
$routes->get('/dashboard/detail_pengumuman1', 'PengumumanController::detail_pengumuman1');
$routes->get('/dashboard/detail_pengumuman2', 'PengumumanController::detail_pengumuman2');
$routes->get('/dashboard/detail_pengumuman3', 'PengumumanController::detail_pengumuman3');
