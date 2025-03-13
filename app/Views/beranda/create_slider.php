<form action="<?= site_url('admin/beranda/storeSlider'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="card-body">
        <div class="form-group">
            <label for="image">Foto</label>
            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>

</form>
