<form action="<?= site_url('admin/referensi/store-role'); ?>" method="post" id="RoleForm">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_role">Nama Role
        </label>
        <input type="text" name="nama_role" class="form-control" id="nama_role">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>