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
$routes->get('/dashboard/detail_pengumuman/(:num)', 'DashboardController::detail_pengumuman/$1');
$routes->get('/layanan', 'LayananController::index');
$routes->get('/referensi', 'ReferensiController::index');

//organisasi
$routes->get('/organisasi', 'OrganisasiController::index');
$routes->get('/organisasi', 'OrganisasiController::index');
$routes->get('/deputi_satu', 'OrganisasiController::deputi_satu');
$routes->get('/deputi_dua', 'OrganisasiController::deputi_dua');
$routes->get('/deputi_tiga', 'OrganisasiController::deputi_tiga');
$routes->get('/deputi_empat', 'OrganisasiController::deputi_empat');
$routes->get('/deputi_lima', 'OrganisasiController::deputi_lima');
$routes->get('/deputi_enam', 'OrganisasiController::deputi_enam');

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

    // Beranda
    $routes->get('beranda', 'Admin\BerandaController::index');
    $routes->post('beranda/storeSlider', 'Admin\BerandaController::storeSlider');
    $routes->get('beranda/deleteSlider/(:segment)', 'Admin\BerandaController::deleteSlider/$1');
    
    $routes->post('beranda/storePopup', 'Admin\BerandaController::storePopup');
    $routes->get('beranda/deletePopup/(:segment)', 'Admin\BerandaController::deletePopup/$1');
    
    $routes->post('beranda/storeCard', 'Admin\BerandaController::storeCard');
    $routes->get('beranda/deleteCard/(:segment)', 'Admin\BerandaController::deleteCard/$1');
    $routes->post('beranda/updateCard', 'Admin\BerandaController::updateCard');
    $routes->get('beranda/detail_pengumuman/(:num)', 'Admin\BerandaController::detail_pengumuman/$1');
    
    // Kalender
    $routes->get('beranda/calender', 'Admin\BerandaController::index');
    $routes->post('beranda/calender/createKalender', 'Admin\BerandaController::createKalender');
    $routes->get('beranda/calender/deleteKalender/(:num)', 'Admin\BerandaController::deleteKalender/$1');

    // Layanan
    $routes->get('layanan', 'Admin\LayananController::index');
    $routes->get('layanan/create', 'Admin\LayananController::create');
    $routes->post('layanan/store', 'Admin\LayananController::store');
    $routes->get('layanan/edit/(:num)', 'Admin\LayananController::edit/$1');
    $routes->post('layanan/update/(:num)', 'Admin\LayananController::update/$1');
    $routes->post('layanan/delete/(:num)', 'Admin\LayananController::delete/$1');

    $routes->get('layanan/kategori', 'Admin\LayananController::kategori');
    $routes->get('layanan/createKategori', 'Admin\LayananController::createKategori');
    $routes->post('layanan/storeKategori', 'Admin\LayananController::storeKategori');
    $routes->get('layanan/editKategori/(:num)', 'Admin\LayananController::editKategori/$1');
    $routes->post('layanan/updateKategori/(:num)', 'Admin\LayananController::updateKategori/$1');
    $routes->post('layanan/deleteKategori/(:num)', 'Admin\LayananController::deleteKategori/$1');

       
    
});
