
<div class="container mt-4">
    <h1>Tambah Konten</h1>
    <form action="<?= site_url('admin/store'); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="unit_terkait" class="form-label">Unit Terkait</label>
            <input type="text" class="form-control" id="unit_terkait" name="unit_terkait" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <div class="mb-3">
            <label for="file_upload" class="form-label">File Upload</label>
            <input type="file" class="form-control" id="file_upload" name="file_upload" required>
        </div>
        <div class="mb-3">
            <label for="parent_id" class="form-label">Kategori</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="0">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['judul'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

