<form action="<?= site_url('admin/beranda/storeCard'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="short_description">Deskripsi Singkat</label>
        <textarea name="short_description" class="form-control" rows="2" required></textarea>
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    <div class="form-group">
        <label for="image">Foto</label>
        <input type="file" name="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">
        Tambah
        <i class="bi bi-plus-circle"></i>
    </button>
</form>
