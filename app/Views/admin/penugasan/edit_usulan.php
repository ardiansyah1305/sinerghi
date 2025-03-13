<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4 py-4">
    <h2 class="fw-semibold mb-4">Edit Usulan Jadwal Kerja</h2>

    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white rounded-top py-3">
            <h5 class="mb-0 text-center"><i class="bi bi-calendar-check"></i> Form Edit Usulan Jadwal Kerja</h5>
        </div>
        <div class="card-body">
            <?php if ($usulan['status_approval'] == 1): ?>
            <div class="alert alert-info mb-4">
                <i class="bi bi-info-circle"></i> Usulan ini sudah diajukan dan sedang dalam proses review. Anda hanya dapat melihat data usulan tanpa mengubahnya.
            </div>
            <?php elseif ($usulan['status_approval'] == 2): ?>
            <div class="alert alert-success mb-4">
                <i class="bi bi-check-circle"></i> Usulan ini telah disetujui. Anda hanya dapat melihat data usulan tanpa mengubahnya.
            </div>
            <?php elseif ($usulan['status_approval'] == 3 && $role_id != 3): ?>
            <div class="alert alert-danger mb-4">
                <i class="bi bi-x-circle"></i> Usulan ini telah ditolak. Anda hanya dapat melihat data usulan tanpa mengubahnya.
            </div>
            <?php elseif ($usulan['status_approval'] == 3 && $role_id == 3): ?>
            <div class="alert alert-warning mb-4">
                <i class="bi bi-exclamation-triangle"></i> Usulan ini telah ditolak. Sebagai Operator, Anda dapat mengedit dan mengajukan kembali usulan ini.
            </div>
            <?php endif; ?>
            <?php $can_edit = ($usulan['status_approval'] == 0 || ($usulan['status_approval'] == 3 && $role_id == 3)); ?>
            <div class="card">
                <div class="card-body">
                    <form id="usulanForm" action="<?= base_url('admin/penugasan/update-usulan/' . encrypt_url($usulan['id'])); ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="bi bi-calendar"></i> Periode Pengajuan</h5>

                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <input type="text" id="bulan" class="form-control" value="<?= date('F', mktime(0, 0, 0, $bulan, 1)); ?>" readonly>
                                    <input type="hidden" name="bulan" value="<?= $bulan; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="text" id="tahun" name="tahun" class="form-control" value="<?= $tahun; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="bi bi-upload"></i> Upload Dokumen</h5>

                                <div class="mb-3">
                                <?php if (!empty($usulan['file_surat'])): ?>
                                        <a href="<?= base_url('uploads/data_dukung/' . $usulan['file_surat']); ?>" target="_blank">
                                            <?= $usulan['file_surat']; ?>
                                        </a>
                                        <?php endif; ?> 
                                        <br>
                                    <label for="file_surat" class="form-label">Surat Pengajuan (PDF, max 2MB)</label>
                                    
                                    <?php if ($can_edit): ?>
                                        <input type="file" id="file_surat" name="file_surat" class="form-control" accept=".pdf">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti file surat</small>
                                    <?php else: ?>
                                        <input type="file" id="file_surat" name="file_surat" class="form-control" accept=".pdf" disabled>
                                        <small class="text-muted">File tidak dapat diubah pada status saat ini</small>
                                    <?php endif; ?>
                                    <div class="invalid-feedback" id="suratError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="file_excel" class="form-label">
                                        Jadwal Kerja (Excel, .xlsx, max 2MB)
                                        <a href="<?= base_url('uploads/template/template_jadwal.xlsx'); ?>" class="btn btn-link p-0 text-decoration-none">
                                            <i class="bi bi-file-earmark-excel"></i> Download Template Excel
                                        </a>
                                    </label>
                                    <?php if ($can_edit): ?>
                                        <input type="file" id="file_excel" name="file_excel" class="form-control" accept=".xlsx">
                                        <small class="text-muted">Upload file Excel baru akan mengganti seluruh jadwal yang ada</small>
                                    <?php else: ?>
                                        <input type="file" id="file_excel" name="file_excel" class="form-control" accept=".xlsx" disabled>
                                        <small class="text-muted">File tidak dapat diubah pada status saat ini</small>
                                    <?php endif; ?>
                                    <div class="invalid-feedback" id="fileError"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="position-fixed top-50 start-50 translate-middle" style="display: none; z-index: 9999;">
                            <div class="bg-white p-4 rounded shadow-lg text-center">
                                <div class="spinner-border text-primary mb-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mb-0">Sedang memproses data...</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?= base_url('admin/penugasan'); ?>" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <?php if ($can_edit): ?>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>

                    <!-- Tabel error validasi -->
                    <div id="validationErrors" class="mt-3" style="display: none;">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Error Validasi</h5>
                            </div>
                            <div class="card-body">
                                <div id="errorList" class="text-danger"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Status approval check
        const statusApproval = <?= $usulan['status_approval'] ?>;
        const roleId = <?= $role_id ?>;
        const canEdit = <?= $can_edit ? 'true' : 'false' ?>;
        
        // Handle file excel upload dan validasi
        $('#file_excel').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Reset error sebelumnya
                clearErrors();
                
                // Validasi ekstensi
                const fileExt = file.name.split('.').pop().toLowerCase();
                if (fileExt !== 'xlsx') {
                    showError('fileError', 'File harus dalam format Excel (.xlsx)');
                    this.value = '';
                    return;
                }
                
                // Validasi ukuran
                if (file.size > 2097152) { // 2MB
                    showError('fileError', 'Ukuran file maksimal 2MB');
                    this.value = '';
                    return;
                }
            }
        });
        
        // Handle file surat upload dan validasi
        $('#file_surat').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Reset error sebelumnya
                clearErrors();
                
                // Validasi ekstensi
                const fileType = file.type;
                if (fileType !== 'application/pdf') {
                    showError('suratError', 'File harus dalam format PDF');
                    this.value = '';
                    return;
                }
                
                // Validasi ukuran
                if (file.size > 2097152) { // 2MB
                    showError('suratError', 'Ukuran file maksimal 2MB');
                    this.value = '';
                    return;
                }
            }
        });

        // Handle form submission
        $('#usulanForm').on('submit', function(e) {
            e.preventDefault();
            
            // If user cannot edit, prevent submission
            if (!canEdit) {
                let message = '';
                
                if (statusApproval === 1) {
                    message = 'Usulan yang sudah diajukan tidak dapat diedit.';
                } else if (statusApproval === 2) {
                    message = 'Usulan yang sudah disetujui tidak dapat diedit.';
                } else if (statusApproval === 3 && roleId !== 3) {
                    message = 'Usulan yang sudah ditolak hanya dapat diedit oleh koordinator.';
                } else {
                    message = 'Usulan tidak dapat diedit pada status saat ini.';
                }
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Dapat Diedit',
                    text: message,
                    confirmButtonText: 'OK'
                });
                return false;
            }
            
            // Show loading spinner
            $('#loadingSpinner').show();
            
            // Submit form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    $('#loadingSpinner').hide();
                    
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed && response.redirect) {
                                window.location.href = response.redirect;
                            }
                        });
                    } else {
                        // Show validation errors if any
                        if (response.message.includes('<br>')) {
                            $('#validationErrors').show();
                            $('#errorList').html(response.message);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        function showError(elementId, message) {
            $('#' + elementId).text(message);
            $('#' + elementId).closest('.mb-3').find('input').addClass('is-invalid');
        }
        
        function clearErrors() {
            $('.invalid-feedback').text('');
            $('input').removeClass('is-invalid');
            $('#validationErrors').hide();
        }
    });
</script>
<?= $this->endSection(); ?>
