<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Unit Kerja</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Unit Kerja</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/unitkerja/store'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="nama_unit_kerja">Nama Unit Kerja <span class="text-danger">*</span></label>
                    <input type="text" name="nama_unit_kerja" class="form-control <?= isset(session('errors')['nama_unit_kerja']) ? 'is-invalid' : ''; ?>" id="nama_unit_kerja" value="<?= old('nama_unit_kerja'); ?>">
                    <?php if (isset(session('errors')['nama_unit_kerja'])): ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['nama_unit_kerja']; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="parent_id">Induk Unit Kerja</label>
                    <select name="parent_id" class="form-control select2 <?= isset(session('errors')['parent_id']) ? 'is-invalid' : ''; ?>" id="parent_id">
                        <option value="">Pilih Induk Unit Kerja</option>
                        <?php foreach ($all_unit_kerja as $unit): ?>
                            <option value="<?= $unit['id']; ?>" <?= old('parent_id') == $unit['id'] ? 'selected' : ''; ?>>
                                <?= $unit['nama_unit_kerja']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset(session('errors')['parent_id'])): ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['parent_id']; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select2').select2();

        // Validasi sebelum submit
        $('#submitBtn').on('click', function(event) {
            let isValid = true;

            // Validasi input nama_unit_kerja
            const namaUnitKerja = $('#nama_unit_kerja').val().trim();
            if (namaUnitKerja === '') {
                $('#nama_unit_kerja').addClass('is-invalid');
                isValid = false;
            } else {
                $('#nama_unit_kerja').removeClass('is-invalid');
            }

            // Validasi select parent_id
            const parentId = $('#parent_id').val();
            if (parentId === '') {
                $('#parent_id').addClass('is-invalid');
                isValid = false;
            } else {
                $('#parent_id').removeClass('is-invalid');
            }

            // Jika validasi gagal, cegah submit form
            if (!isValid) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan lengkapi semua bidang yang wajib diisi!'
                });
            }
        });
    });
</script>

<?= $this->endSection(); ?>