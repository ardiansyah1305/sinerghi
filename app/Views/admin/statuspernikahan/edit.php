<!-- edit.php -->
<form action="<?= site_url('admin/statuspernikahan/update/' . $statuspernikahan['id']); ?>" method="post">
    <?= csrf_field(); ?>

    <div class="form-group mb-3">
        <label for="nama_status">Status Pernikaan</label>
        <input type="text" name="status" class="form-control" value="<?= esc($statuspernikahan['status']); ?>">
    </div>

    <div class="form-group mb-3">
        <label for="kode">Kode</label>
        <input type="text" name="kode" class="form-control" value="<?= esc($statuspernikahan['kode']); ?>">
    </div>

   

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>