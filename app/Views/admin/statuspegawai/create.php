<form action="<?= site_url('admin/statuspegawai/store'); ?>" method="post" id="unitKerjaForm">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_unit_kerja">Nama Unit Kerja 
            <span class="invalid-feedback fs-5" id="nama_unit_kerja_error" style="display:none; color: red;">
                *
            </span>
        </label>
        <input type="text" name="nama_unit_kerja" class="form-control" id="nama_unit_kerja">
    </div>
    <div class="form-group mb-3">
        <label for="parent_id">Induk Unit Kerja
            <span class="invalid-feedback" id="parent_id_error" style="display:none; color: red;">
                *
            </span>
        </label>
        <input type="text" name="parent_id" class="form-control" id="parent_id">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>