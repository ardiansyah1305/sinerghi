<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Slider</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Slider</h5>
        </div>
        <div class="card-body"></div>
        <form action="<?= site_url('admin/beranda/storeSlider'); ?>" method="post" enctype="multipart/form-data"
            id="addsliderForm">
            <?= csrf_field(); ?>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="image">Foto</label>
                    <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="error_foto">
                        <div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary fw-semibold text-black"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-semibold">Simpan</button>
                    </div>

        </form>
    </div>
</div>
<?= $this->endSection(); ?>