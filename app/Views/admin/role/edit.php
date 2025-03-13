<!-- edit.php -->
<form action="<?= site_url('admin/referensi/role/update-role/' . $roles['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_role">Nama Role</label>
        <input type="text" name="nama_role" class="form-control" value="<?= esc($roles['nama_role']); ?>">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>