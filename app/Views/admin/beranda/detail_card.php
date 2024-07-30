<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4">
    <h2><?= $announcement['title']; ?></h2>
    <img src="<?= base_url('img/' . $announcement['image']); ?>" alt="Announcement Image" class="img-fluid mb-3">
    <p><?= $announcement['description']; ?></p>
</div>
<?= $this->endSection(); ?>
