<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
    <h1>Edit Kategori</h1>

    <form action="<?= site_url('admin/referensi/updateCategory/' . $category['id']); ?>" method="post">
        <div class="mb-3">
            <label for="judul_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="judul_kategori" name="judul" value="<?= $category['judul']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Kategori</button>
    </form>
</div>

<?= $this->endSection(); ?>
