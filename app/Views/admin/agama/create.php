<form action="<?= site_url('admin/agama/store'); ?>" method="post" id="agamaForm">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_agama">Agama
        </label>
        <input type="text" name="nama_agama" class="form-control" id="nama_agama">
    </div>
    <div class="form-group mb-3">
        <label for="kode">Kode
        </label>
        <input type="number" name="kode" class="form-control" id="kode">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>