<!-- app/Views/admin/layanan/createKategori.php -->
<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <h2>Tambah Kategori Baru</h2>
    <form action="<?= site_url('admin/layanan/storeKategori') ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
    </form>
</div>
<?= $this->endSection(); ?>
