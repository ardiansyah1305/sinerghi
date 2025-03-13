<?php $role = session()->get('role_id'); ?>

<!-- Navbar Top -->
<nav class="sb-topnav navbar navbar-expand bg-light ms-auto shadow">
  <!-- Navbar Brand-->
  <button class="btn btn-link btn-link-custom btn-sm order-lg-0 me-0 me-lg-0 ms-2 text-black" id="sidebarToggle" href="#!">
    <i class="bi bi-list"></i>
  </button>
  <a class="navbar-brand ps-2 text-uppercase d-none d-sm-block fw-bold fs-custome" href="<?= site_url('admin/dashboard'); ?>">Kelola</a>

  <!-- Logo -->
  <a class="me-0 me-md-0 my-2 my-md-0 logo-custome p-2" href="#">
    <img src="<?= base_url('images/logopmksatu.png'); ?>" alt="logo" style="max-height: 45px; margin-right: 10px;">
  </a>
</nav>

<!-- Add CSS for hover effect -->
<style>
.dropdown-toggle::after {
    display: none;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-divider {
    margin: 0.5rem 0;
}

.bi {
    font-size: 1rem;
}
</style>

<!-- Sidebar Left-->
<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav sb-sidenav-light shadow" id="sidenavAccordion" style="background-color: #f2f2f2;">
      <div class="sb-sidenav-menu">
        <div class="nav">
          <?php if ($role == 1): ?>
            <li class="nav-item">
              <a class="nav-link mt-3" href="<?= site_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/users'); ?>">Akun</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/pegawai'); ?>">Pegawai</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/penugasan'); ?>">Penugasan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/unitkerja'); ?>">Unit Kerja</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/jabatan'); ?>">Jabatan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/riwayat_pendidikan'); ?>">Riwayat Pendidikan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/beranda'); ?>">Slider</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/card'); ?>">Pengumuman</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/layanan'); ?>">Layanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/kalender'); ?>">Kalender Penting</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/pustaka'); ?>">Pustaka</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/referensi'); ?>">Referensi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/hari-libur'); ?>">Hari Libur</a>
            </li>
          <?php endif; ?>
          <?php if ($role == 2): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/pegawai'); ?>">Pegawai</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/penugasan'); ?>">Penugasan</a>
            </li>
          <?php endif; ?>
          <?php if ($role == 3): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('admin/penugasan'); ?>">Penugasan</a>
            </li>
          <?php endif; ?>
        </div>
      </div>
      <div class="sb-sidenav-footer d-flex flex-column justify-content-center align-items-center py-4 border-top">
        <a type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
        <a type="button" class="btn btn-haluta-custom" href="<?= site_url('dashboard'); ?>">Halaman Utama</a>
      </div>
    </nav>
  </div>
