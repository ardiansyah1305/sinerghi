<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4">
    <h2>Detail Pengumuman</h2>
    <div class="card mb-4">
        <div class="card-header">
            <h3><?= $announcement['title']; ?></h3>
        </div>
        <div class="card-body">
            <img src="<?= base_url('uploads/' . $announcement['image']); ?>" alt="Card Image" class="img-fluid mb-4">
            <p><?= $announcement['description']; ?></p>
        </div>
    </div>
    <a href="<?= site_url('admin/beranda'); ?>" class="btn btn-secondary">Back to Beranda</a>
</div>
<?= $this->endSection(); ?>
