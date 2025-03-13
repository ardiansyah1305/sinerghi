<?php 
helper(['encrypt']);
?>
<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-semibold"><?= $title; ?></h2>
            <p class="text-muted">Pilih unit untuk melihat daftar usulan</p>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($unit_eselon_2)): ?>
            <?php foreach ($unit_eselon_2 as $unit): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3"><?= $unit['nama_unit_kerja']; ?></h5>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="<?= site_url('admin/penugasan/daftar-usulan/' . encrypt_url($unit['id'])); ?>" 
                               class="btn btn-outline-primary">
                                <i class="bi bi-eye me-2"></i> Lihat Usulan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada unit yang tersedia
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>