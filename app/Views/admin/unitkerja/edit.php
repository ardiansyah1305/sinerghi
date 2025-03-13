<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Unit Kerja</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-warning text-white rounded-top">
            <h5 class="mb-0">Edit Unit Kerja</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/unitkerja/update/' . $unitkerja['id']); ?>" method="post" enctype="multipart/form-data" id="eunitKerjaForm" class="needs-validation" novalidate>
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="nama_unit_kerja">Nama Unit Kerja</label>
                    <input type="text" name="nama_unit_kerja" class="form-control" value="<?= esc($unitkerja['nama_unit_kerja']); ?>" id="enama_unit_kerja">
                    <div id="enama_uk_error" class="invalid-feedback">Kolom Unit Kerja tidak boleh kosong.</div>
                    <div id="enama_uk_error_invalid" class="invalid-feedback">Unit Kerja Hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="parent_id">Induk Unit Kerja</label>
                    <select name="parent_id" class="form-select select2" id="einduk" required>
                        <option value="">-- Pilih Induk Unit Kerja --</option>
                        <?php if (!empty($all_unit_kerja)): ?>
                            <?php foreach ($all_unit_kerja as $unit): ?>
                                <option value="<?= $unit['parent_id']; ?>" <?= ($unit['id'] == $unitkerja['parent_id']) ? 'selected' : ''; ?>><?= esc($unit['nama_unit_kerja']); ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Tidak ada data unit kerja</option>
                        <?php endif; ?>
                    </select>
                    <div id="eparent_id_error" class="invalid-feedback">Silakan pilih Induk Unit Kerja.</div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= site_url('admin/unitkerja'); ?>'">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- Initialize Select2 -->
<script>
    $(document).ready(function() {
        // Initialize Select2 on the 'Induk Unit Kerja' select element
        $('#einduk').select2({
            placeholder: "-- Pilih Induk Unit Kerja --", // Placeholder text
            allowClear: true // Allow clearing selection
        });
    });
</script>

<?= $this->endSection(); ?>