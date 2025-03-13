<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->GET('/', 'AuthController::login');
$routes->GET('/register', 'RegisterController::index');
$routes->POST('/register/store', 'RegisterController::store');

$routes->GET('/login', 'AuthController::login');
$routes->POST('/sso/callback', 'AuthController::ssoCallback');
$routes->GET('/sso/callback', 'AuthController::ssoCallback');
$routes->POST('/loginAuth', 'AuthController::loginAuth', ['filter' => 'csrf-disable']);
$routes->GET('/logout', 'AuthController::logout');
$routes->GET('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->GET('/dashboard/detail_pengumuman/(:num)', 'DashboardController::detail_pengumuman/$1');
$routes->GET('/layanan', 'LayananController::index');
$routes->GET('/profile', 'ProfileController::index');
$routes->GET('/profile/edit', 'ProfileController::edit');
$routes->POST( '/profile/update', 'ProfileController::update');

//referensi/pustaka
$routes->GET('/referensi', 'ReferensiController::index');
$routes->GET('referensi/viewFile/(:segment)', 'ReferensiController::viewFile/$1');
$routes->GET('referensi/downloadFile/(:segment)', 'ReferensiController::downloadFile/$1');

//organisasi
$routes->GET('/organisasi', 'OrganisasiController::index');
$routes->GET('organisasi/staffahli', 'OrganisasiController::staffAhli');
$routes->GET('organisasi/cariPegawai', 'OrganisasiController::cariPegawai');
$routes->GET('organisasi/cariStaff', 'OrganisasiController::cariStaff');
$routes->GET('organisasi/staffahli/staffahli', 'OrganisasiController::sekretaris');
$routes->GET('organisasi/staffahli/staffahli(:num)', 'OrganisasiController::sekretaris/$1');
$routes->GET('organisasi/pegawai/(:any)/(:any)', 'OrganisasiController::pegawai/$1/$2'); // Fungsi pegawai
$routes->GET('organisasi/pegawai/(:any)', 'OrganisasiController::sekretaris/$1'); // Fungsi sekretaris
// Routes pada app/Config/Routes.php
$routes->GET('/organisasi/menkopmk/menteri', 'MenteriController::index');
$routes->GET('/organisasi/sesmenko/biro_sistem_informasi_dan_pengelolaan_data', 'biro_sistem_informasi_dan_pengelolaan_dataController::index');
$routes->GET('/organisasi/sesmenko/biro_hukum_persidangan_organisasi_dan_komunikasi', 'biro_hukum_persidangan_organisasi_dan_komunikasiController::index');
$routes->GET('/organisasi/sesmenko/biro_perencanaan_dan_kerjasama', 'biro_perencanaan_dan_kerjasamaController::index');
$routes->GET('/organisasi/sesmenko/biro_umum_dan_sumber_daya_manusia', 'biro_umum_dan_sumber_daya_manusiaController::index');
$routes->GET('/organisasi/sesmenko/', 'MenteriController::index');
$routes->GET('/organisasi/sesmenko/', 'MenteriController::index');
$routes->GET('/organisasi', 'OrganisasiController::index');
$routes->GET('/deputi_satu', 'OrganisasiController::deputi_satu');
$routes->GET('/deputi_dua', 'OrganisasiController::deputi_dua');
$routes->GET('/deputi_tiga', 'OrganisasiController::deputi_tiga');
$routes->GET('/deputi_empat', 'OrganisasiController::deputi_empat');
$routes->GET('/deputi_lima', 'OrganisasiController::deputi_lima');
$routes->GET('/deputi_enam', 'OrganisasiController::deputi_enam');

// Authentication Routes
$routes->get('/login', 'AuthController::login');
$routes->get('/sso/callback', 'AuthController::ssoCallback');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/sso/status', 'AuthController::ssoStatus');

// Attendance Routes
$routes->get('attendance', 'AttendanceController::index');
$routes->post('attendance/checkin', 'AttendanceController::recordCheckIn');
$routes->post('attendance/checkout', 'AttendanceController::recordCheckOut');

//presensi
$routes->match(['GET', 'POST'], '/presensi', 'PresensiController::index');
$routes->GET('presensi/ed/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)', 'PresensiController::ed/$1/$2/$3/$4/$5');
$routes->POST('presensi/store', 'PresensiController::store');
$routes->GET('presensi/download_file_bukti/(:segment)', 'PresensiController::download_file_bukti/$1');
$routes->GET('presensi/infografis_kehadiran/(:segment)/(:segment)/(:segment)', 'PresensiController::infografis_kehadiran/$1/$2/$3');
$routes->GET('presensi/infografis_kekurangan/(:segment)/(:segment)/(:segment)', 'PresensiController::infografis_kekurangan/$1/$2/$3');
$routes->get('presensi', 'PresensiController::checkin');
$routes->post('presensi/checkin', 'PresensiController::recordCheckIn');
$routes->post('presensi/checkout', 'PresensiController::recordCheckOut');

//Service Desk
$routes->GET('/servicedesk', 'ServiceDeskController::comingSoon');
$routes->GET('/servicedesk/page/(:num)', 'ServicedeskController::index/$1');
$routes->GET('/servicedesk/response', 'ServicedeskController::response');
$routes->GET('/servicedesk/detail_ticket/(:any)', 'ServicedeskController::detail/$1');
$routes->POST('/servicedesk/insert', 'ServicedeskController::insert');
$routes->POST('/servicedesk/updateStatus', 'ServicedeskController::updateStatus');
$routes->POST('/servicedesk/sendMessage', 'ServicedeskController::sendMessage');

$routes->group('pegawai', ['filter' => 'auth'], function ($routes) {

    //Referensi
    $routes->GET('dashboard', 'Pegawai\DashboardController::index');
    $routes->GET('referensi/', 'Pegawai\ReferensiController::index');
    $routes->GET('referensi/create', 'Pegawai\ReferensiController::create');
    $routes->POST('referensi/store', 'Pegawai\ReferensiController::store');
    $routes->GET('referensi/edit/(:segment)', 'Pegawai\ReferensiController::edit/$1');
    $routes->POST('referensi/update/(:segment)', 'Pegawai\ReferensiController::update/$1');
    $routes->GET('referensi/delete/(:segment)', 'Pegawai\ReferensiController::delete/$1');
    $routes->GET('referensi/viewFile/(:segment)', 'Pegawai\ReferensiController::viewFile/$1');

    // Profile

    // Referensi Category
    $routes->POST('referensi/storeCategory', 'Pegawai\ReferensiController::storeCategory');
    $routes->GET('referensi/editCategory/(:segment)', 'Pegawai\ReferensiController::editCategory/$1');
    $routes->POST('referensi/updateCategory/(:segment)', 'Pegawai\ReferensiController::updateCategory/$1');
    $routes->GET('referensi/deleteCategory/(:segment)', 'Pegawai\ReferensiController::deleteCategory/$1');

    // Beranda
    $routes->GET('beranda', 'Pegawai\BerandaController::index');
    $routes->POST('beranda/storeSlider', 'Pegawai\BerandaController::storeSlider');
    $routes->GET('beranda/deleteSlider/(:segment)', 'Pegawai\BerandaController::deleteSlider/$1');

    $routes->POST('beranda/storePopup', 'Pegawai\BerandaController::storePopup');
    $routes->GET('beranda/deletePopup/(:segment)', 'Pegawai\BerandaController::deletePopup/$1');

    $routes->POST('beranda/storeCard', 'Pegawai\BerandaController::storeCard');
    $routes->GET('beranda/deleteCard/(:segment)', 'Pegawai\BerandaController::deleteCard/$1');
    $routes->POST('beranda/updateCard', 'Pegawai\BerandaController::updateCard');
    $routes->GET('beranda/detail_pengumuman/(:num)', 'Pegawai\BerandaController::detail_pengumuman/$1');

    // Kalender
    $routes->GET('beranda/calender', 'Pegawai\BerandaController::index');
    $routes->POST('beranda/calender/createKalender', 'Pegawai\BerandaController::createKalender');
    $routes->GET('beranda/calender/deleteKalender/(:num)', 'Pegawai\BerandaController::deleteKalender/$1');

    //Jabatan
    $routes->GET('jabatan', 'Pegawai\JabatanController::index');
    $routes->GET('jabatan/create', 'Pegawai\JabatanController::create');
    $routes->POST('jabatan/store', 'Pegawai\JabatanController::store');
    $routes->GET('jabatan/edit/(:segment)', 'Pegawai\JabatanController::edit/$1');
    $routes->POST('jabatan/update/(:segment)', 'Pegawai\JabatanController::update/$1');
    $routes->GET('jabatan/delete/(:segment)', 'Pegawai\JabatanController::delete/$1');
    $routes->POST('jabatan/uploadXlsx', 'Pegawai\JabatanController::uploadXlsx');

    //Pegawai
    $routes->GET('pegawai', 'Pegawai\PegawaiController::index');
    $routes->GET('pegawai/GETNipList', 'Pegawai\PegawaiController::GETNipList');
    $routes->GET('pegawai/searchNIP', 'Pegawai\PegawaiController::searchNIP');

    $routes->GET('pegawai/create', 'Pegawai\PegawaiController::create');
    $routes->POST('pegawai/store', 'Pegawai\PegawaiController::store');
    $routes->POST('/pegawai/check-nip', 'Pegawai\PegawaiController::checkNip');
    $routes->GET('pegawai/edit/(:segment)', 'Pegawai\PegawaiController::edit/$1');
    $routes->POST('pegawai/update/(:segment)', 'Pegawai\PegawaiController::update/$1');
    $routes->GET('pegawai/delete/(:segment)', 'Pegawai\PegawaiController::delete/$1');
    $routes->POST('pegawai/uploadXlsx', 'Pegawai\PegawaiController::uploadXlsx');
    $routes->GET('pegawai/viewDetail/(:segment)', 'Pegawai\PegawaiController::viewDetail/$1');

    //Riwayat Pendidikan
    $routes->GET('riwayat_pendidikan', 'Pegawai\Riwayat_pendidikanController::index');
    $routes->GET('riwayat_pendidikan/create', 'Pegawai\Riwayat_pendidikanController::create');
    $routes->POST('riwayat_pendidikan/store', 'Pegawai\Riwayat_pendidikanController::store');
    $routes->GET('riwayat_pendidikan/edit/(:segment)', 'Pegawai\Riwayat_pendidikanController::edit/$1');
    $routes->POST('riwayat_pendidikan/update/(:segment)', 'Pegawai\Riwayat_pendidikanController::update/$1');
    $routes->GET('riwayat_pendidikan/delete/(:segment)', 'Pegawai\Riwayat_pendidikanController::delete/$1');
    $routes->POST('riwayat_pendidikan/uploadXlsx', 'Pegawai\Riwayat_pendidikanController::uploadXlsx');

    //organisasi
    $routes->GET('organisasi', 'Pegawai\OrganisasiController::index');
    $routes->GET('organisasi/create', 'Pegawai\OrganisasiController::create');
    $routes->POST('organisasi/store', 'Pegawai\OrganisasiController::store');
    $routes->GET('organisasi/edit/(:segment)', 'Pegawai\OrganisasiController::edit/$1');
    $routes->POST('organisasi/update/(:segment)', 'Pegawai\OrganisasiController::update/$1');
    $routes->GET('organisasi/delete/(:segment)', 'Pegawai\OrganisasiController::delete/$1');

    //edit beranda
    $routes->POST('beranda/updateSlider/(:segment)', 'Pegawai\BerandaController::updateSlider/$1');
    $routes->POST('beranda/updatePopup/(:segment)', 'Pegawai\BerandaController::updatePopup/$1');
    $routes->POST('beranda/updateCard/(:segment)', 'Pegawai\BerandaController::updateCard/$1');
    $routes->POST('beranda/updateCalendar/(:segment)', 'Pegawai\BerandaController::updateCalendar/$1');
});

$routes->GET('api/penugasan/get-jadwal-tersedia/(:num)', 'Admin\PenugasanController::getJadwalTersedia/$1', ['filter' => 'cors']);

$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    // Beranda
    $routes->GET('beranda', 'Admin\BerandaController::index');
    $routes->GET('beranda/create-slider', 'Admin\BerandaController::create_slider');
    $routes->POST('beranda/storeSlider', 'Admin\BerandaController::storeSlider');
    $routes->GET('beranda/editSlider/(:segment)', 'Admin\BerandaController::editSlider/$1');
    $routes->POST('beranda/updateSlider/(:segment)', 'Admin\BerandaController::updateSlider/$1');
    $routes->GET('beranda/deleteSlider/(:segment)', 'Admin\BerandaController::deleteSlider/$1');
    $routes->GET('beranda/create-popup', 'Admin\BerandaController::create_popup');
    $routes->POST('beranda/storePopup', 'Admin\BerandaController::storePopup');

    $routes->GET('beranda/deletePopup/(:segment)', 'Admin\BerandaController::deletePopup/$1');

    $routes->POST('beranda/storeCard', 'Admin\BerandaController::storeCard');
    $routes->GET('beranda/deleteCard/(:segment)', 'Admin\BerandaController::deleteCard/$1');
    $routes->POST('beranda/updateCard', 'Admin\BerandaController::updateCard');
    $routes->GET('beranda/detail_pengumuman/(:num)', 'Admin\BerandaController::detail_pengumuman/$1');

    // Kalender
    // $routes->GET('beranda/calender', 'Admin\BerandaController::index');
    // $routes->POST('beranda/calender/createKalender', 'Admin\BerandaController::createKalender');
    // $routes->GET('beranda/calender/deleteKalender/(:num)', 'Admin\BerandaController::deleteKalender/$1');

    // Kalender
    $routes->GET('kalender', 'Admin\KalenderController::index');
    $routes->POST('kalender/create', 'Admin\KalenderController::create');
    $routes->POST('kalender/store', 'Admin\KalenderController::store');
    $routes->GET('kalender/edit/(:segment)', 'Admin\KalenderController::edit/$1');
    $routes->POST('kalender/update/(:segment)', 'Admin\KalenderController::update/$1');
    $routes->GET('kalender/delete/(:segment)', 'Admin\KalenderController::delete/$1');

    // Card
    $routes->GET('card', 'Admin\CardController::index');
    $routes->GET('card/create', 'Admin\CardController::create');
    $routes->POST('card/create', 'Admin\CardController::create');
    $routes->POST('card/store', 'Admin\CardController::store');
    $routes->GET('card/edit/(:segment)', 'Admin\CardController::edit/$1');
    $routes->POST('card/update/(:segment)', 'Admin\CardController::update/$1');
    $routes->GET('card/delete/(:segment)', 'Admin\CardController::delete/$1');

    // Popup
    $routes->GET('popup', 'Admin\PopupController::index');
    $routes->POST('popup/create', 'Admin\PopupController::create');
    $routes->POST('popup/store', 'Admin\PopupController::store');
    $routes->GET('popup/edit/(:segment)', 'Admin\PopupController::edit/$1');
    $routes->POST('popup/update/(:segment)', 'Admin\PopupController::update/$1');
    $routes->GET('popup/delete/(:segment)', 'Admin\PopupController::delete/$1');

    //Referensi
    $routes->GET('dashboard', 'Admin\DashboardController::index');
    $routes->GET('referensi/', 'Admin\ReferensiController::index');
    $routes->GET('referensi/referensi', 'Admin\ReferensiController::index');
    $routes->GET('referensi/', 'Admin\StatuspegawaiController::index');
    $routes->GET('referensi/create', 'Admin\ReferensiController::create');
    $routes->POST('referensi/store', 'Admin\ReferensiController::store');
    $routes->POST('referensi/store-role', 'Admin\ReferensiController::store_role');
    $routes->GET('referensi/edit/(:segment)', 'Admin\ReferensiController::edit/$1');
    $routes->GET('referensi/role/edit/(:segment)', 'Admin\ReferensiController::edit/$1');
    $routes->POST('referensi/role/update-role/(:segment)', 'Admin\ReferensiController::update_role/$1');
    $routes->GET('referensi/role/delete-role/(:segment)', 'Admin\ReferensiController::delete_role/$1');
    $routes->POST('referensi/update/(:segment)', 'Admin\ReferensiController::update/$1');
    $routes->GET('referensi/delete/(:segment)', 'Admin\ReferensiController::delete/$1');
    $routes->GET('referensi/viewFile/(:segment)', 'Admin\ReferensiController::viewFile/$1');

    // Penugasan
    $routes->GET('penugasan', 'Admin\PenugasanController::index');
    $routes->GET('penugasan/create-usulan', 'Admin\PenugasanController::createUsulan');
    $routes->POST('penugasan/store-usulan', 'Admin\PenugasanController::storeUsulan');
    $routes->POST('penugasan/ajukan-usulan', 'Admin\PenugasanController::ajukanUsulan');
    $routes->GET('penugasan/daftar-unit/(:any)', 'Admin\PenugasanController::daftar_unit/$1');
    $routes->GET('penugasan/daftar-usulan/(:any)', 'Admin\PenugasanController::daftar_usulan/$1');
    $routes->POST('penugasan/store-jadwal/', 'Admin\PenugasanController::storeJadwal');
    $routes->GET('penugasan/get-jadwal-tersedia/(:num)', 'Admin\PenugasanController::getJadwalTersedia/$1');
    $routes->GET('penugasan/editjadwal/(:any)', 'Admin\PenugasanController::editJadwal/$1');
    $routes->POST('penugasan/batalkan-usulan', 'Admin\PenugasanController::batalkanUsulan');
    $routes->POST('penugasan/update-status', 'Admin\PenugasanController::updateStatus');
    $routes->POST('penugasan/validate-excel', 'Admin\PenugasanController::validateExcel');
    $routes->POST('penugasan/generate-excel-template', 'Admin\PenugasanController::generateExcelTemplate');
    $routes->GET('penugasan/download-template/(:any)', 'Admin\PenugasanController::downloadTemplate/$1');
    $routes->POST('penugasan/check-complete-schedule', 'Admin\PenugasanController::checkCompleteSchedule');
    $routes->POST('penugasan/simpan-catatan-penolakan', 'Admin\PenugasanController::simpanCatatanPenolakan');
    $routes->GET('penugasan/edit-usulan/(:segment)', 'Admin\PenugasanController::edit_usulan/$1');
    $routes->POST('penugasan/update-usulan/(:segment)', 'Admin\PenugasanController::updateUsulan/$1');
    $routes->GET('penugasan/editjadwal/(:segment)', 'Admin\PenugasanController::editJadwal/$1');

    $routes->get('admin/penugasan/editjadwal/(:segment)', 'Admin\PenugasanController::editJadwal/$1');
    $routes->post('admin/penugasan/update-status', 'Admin\PenugasanController::updateStatus');
    $routes->GET('admin/penugasan/get-jadwal-tersedia/(:num)', 'Admin\PenugasanController::getJadwalTersedia/$1');
    $routes->post('admin/penugasan/update-usulan/(:segment)', 'Admin\PenugasanController::updateUsulan/$1');

    // Hari Libur
    $routes->GET('hari-libur', 'Admin\HariLiburController::index');
    $routes->GET('hari-libur/create', 'Admin\HariLiburController::create');
    $routes->POST('hari-libur/store', 'Admin\HariLiburController::store');
    $routes->GET('hari-libur/edit/(:num)', 'Admin\HariLiburController::edit/$1');
    $routes->POST('hari-libur/update/(:num)', 'Admin\HariLiburController::update/$1');
    $routes->GET('hari-libur/delete/(:num)', 'Admin\HariLiburController::delete/$1');
    $routes->POST('hari-libur/is-holiday', 'Admin\HariLiburController::isHoliday');
    $routes->GET('hari-libur/get-holidays', 'Admin\HariLiburController::getHolidays');

    //Pustaka
    $routes->GET('pustaka/', 'Admin\PustakaController::index');
    $routes->GET('pustaka/create', 'Admin\PustakaController::createUsulan');
    $routes->POST('pustaka/store', 'Admin\PustakaController::store');
    $routes->GET('pustaka/edit/(:segment)', 'Admin\PustakaController::edit/$1');
    $routes->POST('pustaka/update/(:segment)', 'Admin\PustakaController::update/$1');
    $routes->GET('pustaka/delete/(:segment)', 'Admin\PustakaController::delete/$1');
    $routes->GET('pustaka/viewFile/(:segment)', 'Admin\PustakaController::viewFile/$1');

    // Status Pernikahan
    $routes->GET('statuspernikahan/', 'Admin\StatusPernikahanController::index');
    $routes->GET('statuspernikahan/', 'Admin\StatuspegawaiController::index');
    $routes->GET('statuspernikahan/create', 'Admin\StatusPernikahanController::create');
    $routes->POST('statuspernikahan/store', 'Admin\StatusPernikahanController::store');
    $routes->GET('statuspernikahan/edit/(:segment)', 'Admin\StatusPernikahanController::edit/$1');
    $routes->POST('statuspernikahan/update/(:segment)', 'Admin\StatusPernikahanController::update/$1');
    $routes->GET('statuspernikahan/delete/(:segment)', 'Admin\StatusPernikahanController::delete/$1');

    // Status Agama
    $routes->GET('agama/', 'Admin\AgamaController::index');
    $routes->GET('agama/', 'Admin\StatuspegawaiController::index');
    $routes->GET('agama/create', 'Admin\AgamaController::create');
    $routes->POST('agama/store', 'Admin\AgamaController::store');
    $routes->GET('agama/edit/(:segment)', 'Admin\AgamaController::edit/$1');
    $routes->POST('agama/update/(:segment)', 'Admin\AgamaController::update/$1');
    $routes->GET('agama/delete/(:segment)', 'Admin\AgamaController::delete/$1');

    // Referensi Category
    $routes->POST('referensi/storeCategory', 'Admin\ReferensiController::storeCategory');
    $routes->GET('referensi/editCategory/(:segment)', 'Admin\ReferensiController::editCategory/$1');
    $routes->POST('referensi/updateCategory/(:segment)', 'Admin\ReferensiController::updateCategory/$1');
    $routes->GET('referensi/deleteCategory/(:segment)', 'Admin\ReferensiController::deleteCategory/$1');

    // Routes for User Management
    $routes->GET('users', 'Admin\UserController::index');
    $routes->GET('users/create', 'Admin\UserController::create');
    $routes->POST('users/store', 'Admin\UserController::store');
    $routes->GET('users/GETNipList', 'Admin\UserController::GETNipList');
    $routes->GET('users/searchNIP', 'Admin\UserController::searchNIP');
    $routes->GET('users/edit/(:segment)', 'Admin\UserController::edit/$1');
    $routes->POST('users/update/(:segment)', 'Admin\UserController::update/$1');
    $routes->GET('users/delete/(:segment)', 'Admin\UserController::delete/$1');

    //UnitKerja
    $routes->GET('statuspegawai', 'Admin\statuspegawaiController::index');
    $routes->GET('statuspegawai/create', 'Admin\statuspegawaiController::create');
    $routes->POST('statuspegawai/store', 'Admin\statuspegawaiController::store');
    $routes->GET('statuspegawai/edit/(:segment)', 'Admin\statuspegawaiController::edit/$1');
    $routes->POST('statuspegawai/update/(:segment)', 'Admin\statuspegawaiController::update/$1');
    $routes->GET('statuspegawai/delete/(:segment)', 'Admin\statuspegawaiController::delete/$1');

    //Pegawai
    $routes->GET('pegawai', 'Admin\PegawaiController::index');
    $routes->GET('pegawai/create', 'Admin\PegawaiController::create');
    $routes->POST('pegawai/store', 'Admin\PegawaiController::store');
    $routes->GET('pegawai/GETNipList', 'Admin\PegawaiController::GETNipList');
    $routes->GET('pegawai/downloadTemplate', 'Admin\PegawaiController::downloadTemplate');
    $routes->GET('pegawai/uploadCSV', 'Admin\PegawaiController::uploadCSV');
    $routes->GET('pegawai/edit/(:segment)', 'Admin\PegawaiController::edit/$1');
    $routes->POST('pegawai/update/(:segment)', 'Admin\PegawaiController::update/$1');
    $routes->GET('pegawai/delete/(:segment)', 'Admin\PegawaiController::delete/$1');
    $routes->POST('pegawai/uploadXlsx', 'Admin\PegawaiController::uploadXlsx');
    $routes->GET('pegawai/viewDetail/(:segment)', 'Admin\PegawaiController::viewDetail/$1');

    //Jabatan
    $routes->GET('jabatan', 'Admin\JabatanController::index');
    $routes->GET('jabatan/create', 'Admin\JabatanController::create');
    $routes->POST('jabatan/store', 'Admin\JabatanController::store');
    $routes->GET('jabatan/edit/(:segment)', 'Admin\JabatanController::edit/$1');
    $routes->POST('jabatan/update/(:segment)', 'Admin\JabatanController::update/$1');
    $routes->GET('jabatan/delete/(:segment)', 'Admin\JabatanController::delete/$1');
    $routes->POST('jabatan/uploadXlsx', 'Admin\JabatanController::uploadXlsx');

    //Riwayat Pendidikan
    $routes->GET('riwayat_pendidikan', 'Admin\Riwayat_pendidikanController::index');
    $routes->GET('riwayat_pendidikan/create', 'Admin\Riwayat_pendidikanController::create');
    $routes->POST('riwayat_pendidikan/store', 'Admin\Riwayat_pendidikanController::store');
    $routes->GET('riwayat_pendidikan/edit/(:segment)', 'Admin\Riwayat_pendidikanController::edit/$1');
    $routes->POST('riwayat_pendidikan/update/(:segment)', 'Admin\Riwayat_pendidikanController::update/$1');
    $routes->GET('riwayat_pendidikan/delete/(:segment)', 'Admin\Riwayat_pendidikanController::delete/$1');
    $routes->POST('riwayat_pendidikan/uploadXlsx', 'Admin\Riwayat_pendidikanController::uploadXlsx');

    //UnitKerja
    $routes->GET('unitkerja', 'Admin\UnitkerjaController::index');
    $routes->GET('unitkerja/create', 'Admin\UnitkerjaController::create');
    $routes->POST('unitkerja/store', 'Admin\UnitkerjaController::store');
    $routes->GET('unitkerja/edit/(:segment)', 'Admin\UnitkerjaController::edit/$1');
    $routes->POST('unitkerja/update/(:segment)', 'Admin\UnitkerjaController::update/$1');
    $routes->GET('unitkerja/delete/(:segment)', 'Admin\UnitkerjaController::delete/$1');

    //UnitKerja
    $routes->GET('unitkerjaa', 'Admin\UnitkerjaaController::index');
    $routes->GET('unitkerjaa/create', 'Admin\UnitkerjaaController::create');
    $routes->POST('unitkerjaa/store', 'Admin\UnitkerjaaController::store');
    $routes->GET('unitkerjaa/edit/(:segment)', 'Admin\UnitkerjaaController::edit/$1');
    $routes->POST('unitkerjaa/update/(:segment)', 'Admin\UnitkerjaaController::update/$1');
    $routes->GET('unitkerjaa/delete/(:segment)', 'Admin\UnitkerjaaController::delete/$1');

    // Layanan
    $routes->GET('layanan', 'Admin\LayananController::index');
    $routes->GET('layanan/create', 'Admin\LayananController::create');
    $routes->POST('layanan/store', 'Admin\LayananController::store');
    $routes->GET('layanan/edit/(:num)', 'Admin\LayananController::edit/$1');
    $routes->POST('layanan/update/(:num)', 'Admin\LayananController::update/$1');
    $routes->POST('layanan/delete/(:num)', 'Admin\LayananController::delete/$1');

    $routes->GET('layanan/kategori', 'Admin\LayananController::kategori');
    $routes->GET('layanan/createKategori', 'Admin\LayananController::createKategori');
    $routes->POST('layanan/storeKategori', 'Admin\LayananController::storeKategori');
    $routes->GET('layanan/editKategori/(:num)', 'Admin\LayananController::editKategori/$1');
    $routes->POST('layanan/updateKategori/(:num)', 'Admin\LayananController::updateKategori/$1');
    $routes->POST('layanan/deleteKategori/(:num)', 'Admin\LayananController::deleteKategori/$1');
});
