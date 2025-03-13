<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>


<div class="container-fluid px-5 py-4">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="text-center">Tambah Pustaka</h2>
        </div>
        <div class="card-body mx-5 my-3">
            <form action="<?= site_url('admin/pustaka/store'); ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul <span class="text-danger fs-5">*</span></label>
                    <input type="text" class="form-control" id="judul" name="judul">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger fs-5">*</span></label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                </div>
                <div class="mb-3">
                    <label for="unit_terkait" class="form-label">Unit Terkait <span class="text-danger fs-5">*</span></label>
                    <input type="text" class="form-control" id="unit_terkait" name="unit_terkait">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger fs-5">*</span></label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                </div>
                <div class="mb-3">
                    <label for="file_upload" class="form-label">Unggah File <span class="text-danger fs-5">*</span></label>
                    <input type="file" class="form-control" id="file_upload" name="file_upload">
                </div>
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Kategori <span class="text-danger fs-5">*</span></label>
                    <select class="form-select" id="parent_id" name="parent_id">
			<option value="" selected disabled>-- Pilihh Kategori --</option>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Konten -->
<?php if (session()->getFlashdata('success_pustaka')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_pustaka'); ?>",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_pustaka')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_pustaka'); ?>",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>


<?= $this->endSection(); ?>
