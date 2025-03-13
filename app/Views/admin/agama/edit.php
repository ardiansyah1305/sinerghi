<!-- edit.php -->
<form action="<?= site_url('admin/agama/update/' . $agama['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
        <label for="nama_agama">Agama</label>
        <input type="text" name="nama_agama" class="form-control" value="<?= esc($agama['nama_agama']); ?>">
    </div>
   
    <div class="form-group mb-3">
        <label for="nama_agama">Kode</label>
        <input type="text" name="kode" class="form-control" value="<?= esc($agama['kode']); ?>">
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>