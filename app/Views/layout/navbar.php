<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="font-family: Arial, Helvetica, sans-serif;">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="<?= site_url(); ?>">
            <img src="<?= base_url('images/logopmk.png'); ?>" alt="logo" style="max-height: 50px; margin-right: 10px;">
        </a>

        <!-- Hamburger button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Main menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mx-2">
                    <a class="nav-link py-2" aria-current="page" href="<?= site_url('dashboard'); ?>">Beranda</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link py-2" href="https://kehadiran.kemenkopmk.go.id">Presensi</a>
                </li>
               <!-- <li class="nav-item mx-2">
                    <a class="nav-link py-2" href="<?= site_url('layanan'); ?>">Layanan</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link py-2" href="<?= site_url('servicedesk'); ?>">ServiceDesk</a>
                </li>-->
                
                <!-- Profile items for mobile view only -->
                <li class="nav-item d-block d-lg-none mt-3">
                    <div class="px-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <p class="mb-0 fw-bold"><?= session()->get('nama'); ?></p>
                                <small class="text-muted"><?= session()->get('email'); ?></small>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-block d-lg-none">
                    <hr class="dropdown-divider mx-2">
                </li>
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link py-2" href="<?= site_url('/profile'); ?>">
                        <i class="bi bi-person me-2"></i> Profilllll
                    </a>
                </li>
                <?php
                $role = session()->get('role_id');
                if ($role == 1 || $role == 2 || $role == 3):
                ?>
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link py-2" href="<?= site_url('admin/dashboard'); ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Kelola
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link py-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>

            <!-- Right-aligned items -->
            <div class="d-none d-lg-flex align-items-center">
                <!-- Menu Dashboard (Hanya untuk Admin) - desktop view only -->
                <div class="dropdown">
                    <button class="btn nav-link d-flex align-items-center py-2 px-3 position-relative" type="button"
                        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 10px; background: none; border: none;">
                        <i class="bi bi-person-circle fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dropdownUser" style="margin-top: 5px; min-width: 280px; right: 0; left: auto;">
                        <li>
                            <div class="dropdown-item-text">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-circle fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p class="mb-0 fw-bold"><?= session()->get('nama'); ?></p>
                                        <small class="text-muted"><?= session()->get('email'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= site_url('/profile'); ?>"><i class="bi bi-person me-2"></i> Profil</a></li>
                        <?php if ($role == 1 || $role == 2 || $role == 3): ?>
                            <li><a class="dropdown-item" href="<?= site_url('admin/dashboard'); ?>"><i class="bi bi-speedometer2 me-2"></i> Kelola</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center text-danger mb-3"><i class="bi bi-exclamation-circle fs-1"></i></div>
                <p class="text-center">Apakah Anda yakin ingin keluar dari sistem?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="<?= site_url('logout'); ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
