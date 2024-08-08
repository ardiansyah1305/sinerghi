<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4 bg-white p-4">
    <h2 class="text-center"><?= $announcement['title']; ?></h2>
    <br>
    <div class="text-center">
        <img src="<?= base_url('img/' . $announcement['image']); ?>" alt="Announcement Image" class="img-fluid mb-4">
    </div>
    <br>
    <p class="text-center"><?= $announcement['description']; ?></p>
</div>

<?= $this->endSection(); ?>