<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>


<div class="container-fluid px-5 py-4">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="text-center">Tambah Konten Referensi</h2>
        </div>
        <div class="card-body mx-5 my-3">
            <form action="<?= site_url('admin/referensi/store'); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger fs-5">*</span></label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger fs-5">*</span></label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="unit_terkait" class="form-label">Unit Terkait <span class="text-danger fs-5">*</span></label>
                    <input type="text" class="form-control" id="unit_terkait" name="unit_terkait" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger fs-5">*</span></label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
                <div class="mb-3">
                    <label for="file_upload" class="form-label">Unggah File <span class="text-danger fs-5">*</span></label>
                    <input type="file" class="form-control" id="file_upload" name="file_upload" required>
                </div>
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Kategori <span class="text-danger fs-5">*</span></label>
                    <select class="form-control" id="parent_id" name="parent_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>"><?= $category['judul']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>
