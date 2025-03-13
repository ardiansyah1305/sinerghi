<!-- Navbar Top -->
<nav class="sb-topnav navbar navbar-expand bg-light ms-auto shadow">
    <!-- Navbar Brand-->
    <button class="btn btn-link btn-link-custom btn-sm order-lg-0 me-0 me-lg-0 ms-2" id="sidebarToggle" href="<?= site_url('pegawai/dashboard'); ?>">
        <i class="bi bi-list"></i>
     </button>
    <a class="navbar-brand ps-2 text-uppercase fw-bold fs-custome" href="<?= site_url('pegawai/dashboard'); ?>">Kepegawaian Dashboard</a>
    <!-- Sidebar Toggle-->
    <a class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-0 my-2 my-md-0 logo-custome p-2" href="<?= site_url('pegawai/dashboard'); ?>">
        <img src="<?= base_url('images/logopmksatu.png'); ?>" alt="logo" style="max-height: 45px; margin-right: 10px;">
    </a>
</nav>

<!-- Sidebar Left-->
<div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav sb-sidenav-light shadow" id="sidenavAccordion" style="background-color: #f2f2f2;">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                      <li class="nav-item">
                        <a class="nav-link mt-3" href="<?= site_url('pegawai/dashboard'); ?>">Dashboard</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link nav-link-custome" href="<?= site_url('pegawai/pegawai'); ?>">Pegawai</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('pegawai/jabatan'); ?>">Jabatan</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('pegawai/riwayat_pendidikan'); ?>">Riwayat Pendidikan</a>
                      </li>                       
                    </div>
                </div>
                <div class="sb-sidenav-footer d-flex flex-column justify-content-center align-items-center py-4">
                <a type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    <a type="button" class="btn btn-haluta-custom" href="<?= site_url('dashboard'); ?>">Halaman Utama</a>
                </div>
            </nav>
            
        </div>