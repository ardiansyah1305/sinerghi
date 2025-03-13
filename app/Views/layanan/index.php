<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <img src="<?= base_url('images/coming-soon.svg'); ?>" alt="Coming Soon" class="img-fluid mb-4" style="max-height: 250px;">
                    <h1 class="display-4 fw-bold text-primary mb-3">Coming Soon</h1>
                    <p class="lead text-muted mb-4">
                        Halaman Layanan sedang dalam pengembangan. Kami sedang bekerja keras untuk memberikan layanan terbaik bagi Anda.
                    </p>
                    <p class="text-muted mb-4">
                        Silahkan kembali lagi nanti untuk melihat fitur-fitur baru yang akan kami hadirkan.
                    </p>
                    <a href="<?= site_url('dashboard'); ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
