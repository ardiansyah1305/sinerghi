<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Popup</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Popup</h5>
        </div>
        <div class="card-body"></div>
        <form action="<?= site_url('admin/beranda/storePopup'); ?>" method="post" enctype="multipart/form-data"
            id="addpopupForm" class="mb-4">
            <?= csrf_field(); ?>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
            </div>
            <button type="submit" class="btn btn-success">
                Tambah
                <i class="bi bi-plus-circle"></i>
            </button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>