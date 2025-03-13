<!-- edit.php -->
<form action="<?= site_url('admin/jabatan/update/' . $jabatan['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_jabatan">Nama Jabatan</label>
        <input type="text" name="nama_jabatan" class="form-control" value="<?= esc($jabatan['nama_jabatan']); ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="is_fungsional">Fungsional</label>
        <input type="text" name="is_fungsional" class="form-control" value="<?= esc($jabatan['is_fungsional']); ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="is_pelaksana">Pelaksana</label>
        <input type="text" name="is_pelaksana" class="form-control" value="<?= esc($jabatan['is_pelaksana']); ?>" required>
    </div>
    <div class="form-group mb-3">
        <label for="eselon">Eselon</label>
        <input type="text" name="eselon" class="form-control" value="<?= esc($jabatan['eselon']); ?>">
    </div>
    <div class="form-group mb-3">
        <label for="is_pjp">Pjp</label>
        <input type="text" name="is_pjp" class="form-control" value="<?= esc($jabatan['is_pjp']); ?>">
    </div>
    <div class="form-group mb-3">
        <label for="is_pppk">Pppk</label>
        <input type="text" name="is_pppk" class="form-control" value="<?= esc($jabatan['is_pppk']); ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning">Save Changes</button>
    </div>
</form>