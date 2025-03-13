<!-- Index.php -->
<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<?php $role = session()->get('role_id'); ?>
<div class="container-fluid px-5 py-4 border-bottom">
    <h2 class=" mb-4 fw-semibold">Dashboard</h2>
    <div class="row">

        <!-- Card 1 -->
        <?php if ($role == 1): ?>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-users-custom shadow py-2 card-custom-size">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mr-2">
                                <div class="fw-semibold text-primary-custom text-uppercase mb-3">Akun</div>
                                <div class="mb-0 fw-bold text-pegawai-custom">Kelola Akun</div>
                            </div>
                        </div>
                        <a href="<?= site_url('admin/users'); ?>" class="btn btn-users-custom d-flex justify-content-between mt-3 my-2">
                            Akun
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-slider-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-slider-custom text-uppercase mb-3">Slider</div>
                            <div class="mb-0 fw-bold text-pegawai-custom">Kelola Slider</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/beranda'); ?>" class="btn btn-slider-custom d-flex justify-content-between mt-3 my-2">
                        Slider
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-pengumuman-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-pengumuman-custom text-uppercase mb-3">Pengumuman</div>
                            <div class="mb-0 fw-bold text-pegawai-custom">Kelola Pengumuman</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/card'); ?>" class="btn btn-pengumuman-custom d-flex justify-content-between mt-3 my-2">
                        Pengumuman
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-kalender-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-kalender-custom text-uppercase mb-3">Kalender</div>
                            <div class="mb-0 fw-bold text-pegawai-custom">Kelola Kalender</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/kalender'); ?>" class="btn btn-kalender-custom d-flex justify-content-between mt-3 my-2">
                        Kalender
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-unit-kerja-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-unit-kerja-custom text-uppercase mb-3">Unit Kerja</div>
                            <div class="mb-0 fw-bold text-pegawai-custom">Kelola Unit Kerja</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/unitkerja'); ?>" class="btn btn-unit-kerja-custom d-flex justify-content-between mt-3 my-2">
                        Unit Kerja
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-jabatan-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-jabatan-custom text-uppercase mb-3">Jabatan</div>
                            <div class="mb-0 fw-bold text-pegawai-custom">Kelola Jabatan</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/jabatan'); ?>" class="btn btn-jabatan-custom d-flex justify-content-between mt-3 my-2">
                        Jabatan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-rp-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-rp-custom text-uppercase mb-3">Riwayat Pendidikan</div>
                            <div class="mb-0 fw-bold text-riwpen-custom">Kelola Riwayat Pendidikan</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/riwayat_pendidikan'); ?>" class="btn btn-rp-custom d-flex justify-content-between mt-3 my-2">
                        Riwayat Pendidikan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>


        <!-- Card 6 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-referensi-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-referensi-custom text-uppercase mb-3">Referensi</div>
                            <div class="mb-0 text-penpeg-custom fw-bold">Kelola Referensi</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/referensi'); ?>" class="btn btn-referensi-custom d-flex justify-content-between mt-3 my-2">
                        Referensi
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-pustaka-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-pustaka-custom text-uppercase mb-3">Pustaka</div>
                            <div class="mb-0 text-penpeg-custom fw-bold">Kelola Pustaka</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/pustaka'); ?>" class="btn btn-pustaka-custom d-flex justify-content-between mt-3 my-2">
                        Pustaka
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-layanan-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-layanan-custom text-uppercase mb-3">Layanan</div>
                            <div class="mb-0 text-penpeg-custom fw-bold">Kelola Layanan</div>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/layanan'); ?>" class="btn btn-layanan-custom d-flex justify-content-between mt-3 my-2">
                        Layanan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($role == 1 || $role == 2): ?>
            <!-- Card 2 -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-popup-custom shadow py-2 card-custom-size">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mr-2">
                                <div class="fw-semibold text-popup-custom text-uppercase mb-3">Pegawai</div>
                                <div class="mb-0 fw-bold text-pegawai-custom">Kelola Pegawai</div>
                            </div>
                        </div>
                        <a href="<?= site_url('admin/pegawai'); ?>" class="btn btn-popup-custom d-flex justify-content-between mt-3 my-2">
                            Pegawai
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($role == 1 || $role == 2 || $role == 3): ?>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-popup-custom shadow py-2 card-custom-size">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mr-2">
                                <div class="fw-semibold text-popup-custom text-uppercase mb-3">Penugasan</div>
                                <div class="mb-0 fw-bold text-pegawai-custom">Kelola Penugasan</div>
                            </div>
                        </div>
                        <a href="<?= site_url('admin/penugasan'); ?>" class="btn btn-popup-custom d-flex justify-content-between mt-3 my-2">
                            Penugasan
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>