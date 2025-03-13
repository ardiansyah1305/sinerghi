<form action="<?= site_url('admin/statuspernikahan/store'); ?>" method="post" id="statusPernikahanForm">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="status">Status
        </label>
        <input type="text" name="status" class="form-control" id="status">
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