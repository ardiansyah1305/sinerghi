<!-- Index.php -->
<?= $this->extend('pegawai/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-3 py-2 px-md-5 py-md-4">
        <h2 class="my-4 fw-semibold">Dashboard</h2>
        <div class="row">

        <!-- Card 1 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-success-custom text-uppercase mb-3">Kepegawaian</div>
                            <div class="mb-0 fw-bold text-pegawai-custom">Kelola Pegawai</div>
                        </div>
                    </div>
                    <a href="<?= site_url('pegawai/pegawai'); ?>" class="btn btn-success-custom d-flex justify-content-between mt-3 my-2">
                        Kepegawaian
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-primary-custom text-uppercase mb-3">Jabatan</div>
                            <div class="mb-0 fw-bold text-jabatan-custom">Kelola Jabatan</div>
                        </div>
                    </div>
                    <a href="<?= site_url('pegawai/jabatan'); ?>" class="btn btn-primary-custom d-flex justify-content-between mt-3 my-2">
                        Jabatan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger-custom shadow py-2 card-custom-size">
                <div class="card-body">
                    <div class="row">
                        <div class="col mr-2">
                            <div class="fw-semibold text-danger-custom text-uppercase mb-3">Riwayat Pendidikan</div>
                            <div class="mb-0 text-penpeg-custom fw-bold">Kelola Riwayat Pendidikan</div>
                        </div>
                    </div>
                    <a href="<?= site_url('pegawai/riwayat_pendidikan'); ?>" class="btn btn-danger-custom d-flex justify-content-between mt-3 my-2">
                        Riwayat Pendidikan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>