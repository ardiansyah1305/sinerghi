<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white rounded-top">
                    <h5 class="mb-0">Edit Jadwal Kerja</h5>
                </div>
                <div class="card-body">
                    <form id="formEditJadwal">
                        <input type="hidden" id="usulan_id" value="<?= $usulan['id'] ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bulan">Periode:</label>
                                <input type="text" class="form-control" value="<?= date('F Y', strtotime($usulan['bulan'])) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="status">Status:</label>
                                <input type="text" class="form-control" value="<?= get_status_label($status_approval) ?>" readonly>
                            </div>
                        </div>

                        <?php if ($can_edit): ?>
                        <div class="jadwal-container">
                            <!-- Calendar and jadwal editing interface will be loaded here -->
                        </div>
                        <?php endif; ?>

                        <div class="mt-4 d-flex justify-content-between">
                            <a href="<?= base_url('admin/penugasan') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            
                            <div>
                                <?php if ($role_id == 3): ?>
                                    <?php if ($status_approval == 0 || $status_approval == 3): ?>
                                        <button type="button" class="btn btn-primary me-2" id="btnSimpan">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <button type="button" class="btn btn-success" id="btnAjukan">
                                            <i class="fas fa-paper-plane"></i> Ajukan
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($role_id == 1 || $role_id == 2): ?>
                                    <?php if ($status_approval == 1): ?>
                                        <button type="button" class="btn btn-success me-2" id="btnTerima">
                                            <i class="fas fa-check"></i> Terima
                                        </button>
                                        <button type="button" class="btn btn-danger" id="btnBatalkan">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    <?php elseif ($status_approval == 2): ?>
                                        <button type="button" class="btn btn-danger" id="btnBatalkan">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Button click handlers
    $('#btnSimpan').on('click', function() {
        // Save jadwal logic
    });

    $('#btnAjukan').on('click', function() {
        // Submit usulan logic
    });

    $('#btnTerima').on('click', function() {
        // Approve usulan logic
    });

    $('#btnBatalkan').on('click', function() {
        // Cancel usulan logic
    });
});
</script>

<?php
function get_status_label($status) {
    switch ($status) {
        case 0:
            return 'Draft';
        case 1:
            return 'Menunggu Persetujuan';
        case 2:
            return 'Disetujui';
        case 3:
            return 'Ditolak';
        default:
            return 'Unknown';
    }
}
?>

<?= $this->endSection(); ?>
