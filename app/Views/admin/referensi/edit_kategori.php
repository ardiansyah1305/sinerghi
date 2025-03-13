<form action="<?= site_url('admin/referensi/updateCategory/' . $categories['id']); ?>" method="post">
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="mb-3">
            <label for="judul_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="judul_kategori" name="judul" value="<?= $categories['judul']; ?>">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
            
</form>