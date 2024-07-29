<!-- app/Views/dashboard/detail_pengumuman.php -->
<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2><?= $announcement['title']; ?></h2>
    <p><?= $announcement['date']; ?></p>
    <img src="<?= base_url('uploads/' . $announcement['image']); ?>" alt="Announcement Image" class="img-fluid mb-3">
    <p><?= $announcement['description']; ?></p>
</div>

<?= $this->endSection(); ?>
