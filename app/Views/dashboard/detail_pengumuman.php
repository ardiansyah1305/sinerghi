<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Bagian Banner Atas -->
<div class="announcement-banner">
    <img src="<?= base_url('images/beritaback.jpg'); ?>" alt="Banner Image" class="banner-image">
    <div class="banner-content">
        <a href="<?= site_url('dashboard'); ?>" class="back-button">&larr; Berita</a>
    </div>
</div>

<div class="announcement-container mt-4 bg-white p-4">
    <h2 class="announcement-title"><?= $announcement['title']; ?></h2>
    <br>
    <div class="announcement-wrapper">
        <div class="announcement-image-wrapper">
            <img src="<?= base_url('img/' . $announcement['image']); ?>" alt="Announcement Image" class="img-fluid announcement-image">
        </div>
        <div class="announcement-description">
            <p><?= $announcement['description']; ?></p>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
