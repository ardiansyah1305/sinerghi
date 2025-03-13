<!-- edit.php -->
<form action="<?= site_url('admin/statuspegawai/update/' . $statuspegawai['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_status">Status Pegawai</label>
        <input type="text" name="nama_status" class="form-control" value="<?= esc($statuspegawai['nama_status']); ?>" required>
    </div>
   

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>