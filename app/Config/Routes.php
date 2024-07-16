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
$routes->get('/dashboard', 'DashboardControllers::index');
$routes->get('/layanan', 'LayananController::index');
$routes->get('/referensi', 'ReferensiController::index');
$routes->get('/organisasi', 'OrganisasiController::index');
$routes->get('/pengumuman', 'PengumumanController::index');
