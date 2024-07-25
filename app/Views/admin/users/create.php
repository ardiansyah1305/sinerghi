<!-- create.php -->
<form action="<?= site_url('admin/users/store'); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nip">NIP</label>
        <input type="text" name="nip" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="gelar_belakang">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="role">Role</label>
        <select name="role" class="form-select" required>
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="kode_bidang">Kode Bidang</label>
        <input type="text" name="kode_bidang" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="status">Status</label>
        <input type="text" name="status" class="form-control" required>
    </div>
    <div class="form-group mb-3">
        <label for="jabatan_struktural">Jabatan Struktural</label>
        <input type="text" name="jabatan_struktural" class="form-control" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
