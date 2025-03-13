<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container px-5 py-4">
    <div class="card shadow">
        <div class="card-header">
            <h2>Edit Kategori</h2>
        </div>
        <div class="card-body mx-4 my-4">
            <form action="<?= site_url('admin/referensi/updateCategory/' . $category['id']); ?>" method="post">
                <div class="mb-3">
                    <label for="judul_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="judul_kategori" name="judul" value="<?= $category['judul']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Kategori</button>
            </form>
        </div>
    </div>

    
</div>

<?= $this->endSection(); ?>
