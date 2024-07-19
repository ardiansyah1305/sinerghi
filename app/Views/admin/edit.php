
<div class="container mt-4">
    <h1>Edit Konten</h1>
    <form action="<?= site_url('admin/update/' . $content['id']); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?= $content['judul']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= $content['deskripsi']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="unit_terkait" class="form-label">Unit Terkait</label>
            <input type="text" class="form-control" id="unit_terkait" name="unit_terkait" value="<?= $content['unit_terkait']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $content['tanggal']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="file_upload" class="form-label">File Upload</label>
            <input type="file" class="form-control" id="file_upload" name="file_upload">
            <input type="hidden" name="existing_file" value="<?= $content['file_upload']; ?>">
        </div>
        <div class="mb-3">
            <label for="parent_id" class="form-label">Kategori</label>
            <select class="form-control" id="parent_id" name="parent_id">
                <option value="0">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $content['parent_id'] ? 'selected' : '' ?>><?= $category['judul'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

