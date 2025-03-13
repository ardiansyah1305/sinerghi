<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <h3 class="fw-bold mb-4 text-uppercase">Kelola Pegawai</h3>
    <div class="card shadow rounded-4 mb-4">
        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 mt-3">
                <div class="d-flex">
                    <a href="<?= base_url('admin/pegawai/create')?>" class="btn btn-success" style="margin-left: 12px;"><span class="btn-text">Tambah</span> <i class="bi bi-plus-circle"></i></a>
                    <!-- <button class="btn btn-success" style="margin-left: 12px;" data-bs-toggle="modal" data-bs-target="#addPegawaiModal">
                        <span class="btn-text">Tambah</span>
                        
                    </button> -->
                </div>
                <div class="d-flex">
                    <div class="dropdown-center">
                        <button class="btn btn-primary dropdown-toggle" style="margin-right: 12px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Unggah Data
                            <i class="bi bi-filetype-xlsx"></i>
                        </button>

                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item text-primary" href="<?= base_url('templates/template_pegawai.xlsx') ?>"><i class="bi bi-download"></i> Download Template</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-primary" href="UnggahData" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-upload"></i> Unggah</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <!-- Table Pegawai -->
            <div class="table-responsive">
                 <table id="example" class="table table-striped table-hover" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center border align-middle text-white bg-dark">No</th>
                    <th class="text-center border align-middle text-white bg-dark">NIP</th>
                    <th class="text-center border align-middle text-white bg-dark">Nama Pegawai</th>
                    <th class="text-center border align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>  
            
            <?php if (!empty($pegawai)): ?>
            <?php $i = 1; foreach ($pegawai as $pgw): ?>
                <tr>
                    <td class="text-center border align-middle"><?= $i++; ?></td>
                    <td class="text-center border align-middle"><?= esc($pgw['nip']); ?></td>
                    <td class="text-center border align-middle"><?= esc($pgw['nama']); ?></td>
		   <td class="text-center border align-middle">
                        <div class="d-flex justify-content-center custom-action-buttons">
                            <button class="btn btn-info btn-sm me-1 view-pegawai-btn" data-id="<?= $pgw['id']; ?>">
                                <i class="bi bi-eye"></i>
                            </button>
                            <a href="<?= base_url('admin/pegawai/edit/'. $pgw['id'])?>" class="btn btn-warning" style="margin-left: 12px;"><span class="btn-text"></span> <i class="bi bi-pencil-square"></i></a>
                            <button onclick="confirmDeletePegawai(<?= $pgw['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
            </tr>
            
                    <!-- Edit Pegawai Modal -->
                    <!-- <div class="modal fade" id="editPegawaiModal<//?= $pgw['id']; ?>" tabindex="-1" aria-labelledby="editPegawaiModalLabel<//?= $pgw['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-center w-100" id="editPegawaiModalLabel<//?= $pgw['id']; ?>">Edit Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <a href="<//?= base_url('admin/pegawai/create')?>" class="btn btn-success" style="margin-left: 12px;"><span class="btn-text">Tambah</span> <i class="bi bi-plus-circle"></i></a>
                                <//?= view('admin/pegawai/edit', ['pegawai' => $pgw]); ?>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Edit Pegawai Modal -->

                    <!-- Add User Modal -->
                    <!-- <div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                 <div class="modal-header bg-success">
                                      <h5 class="modal-title text-center text-white w-100" id="addPegawaiModalLabel">Tambah Pegawai</h5>
                                      <<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 
                                 <?//= view('admin/pegawai/create'); ?>
                                 
                            </div>
                       </div>
                    </div> -->

                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pegawai yang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- End Table -->
            </div>
            

            



            <!-- Modal Upload Excel-->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title fw-semibold" id="uploadModalLabel">Unggah Berkas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/pegawai/uploadXlsx') ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <!-- Link untuk mengunduh template -->
                                <a href="<?= base_url('templates/template_pegawai.xlsx') ?>" class="text-primary-custom text-decoration-none">
                                    <i class="bi bi-download"></i> Download Template
                                </a>
                                <!-- Dropzone untuk unggahan file -->
                                <div id="dropZone" class="py-5 mt-2 text-center" style="border: 2px dashed; border-color: #ced4da;">
                                    <p class="mb-0 text-muted">Letakkan berkas disini <br>
                                        <small class="text-muted">atau</small>
                                    </p>
                                    <!-- Input file untuk unggahan XLSX -->
                                    <input type="file" id="fileInput" name="xlsx_file" class="d-none" accept=".xlsx">
                                    <button type="button" class="btn btn-outline-secondary px-3 py-0" style="border: 1px solid #5B878E;" onclick="document.getElementById('fileInput').click()">Pilih Berkas</button><br>
                                    <small class="text-muted">Berkas harus ekstensi: .xlsx</small>
                                </div>
                                <!-- Feedback untuk format file yang salah -->
                                <div id="feedback" class="invalid-feedback">Ekstensi yang diperbolehkan: .xlsx</div>
                            </div>
                            <div class="modal-footer" style="border-top: none;">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Card Body -->

    </div>
    <!-- End Card -->
    
</div>

<!-- Detail Pegawai Modal -->
<div class="modal fade" id="viewPegawaiModal" tabindex="-1" aria-labelledby="viewPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewPegawaiModalLabel">Detail Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="viewPegawaiContent">
                <!-- Content will be loaded here via AJAX -->
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        .custom-search-btn,
        .custom-add-pegawai-btn {
            margin-left: 10px;
        }

        .custom-add-pegawai-btn {
            white-space: nowrap;
        }

        /* Optional: Jika butuh padding lebih untuk memperbaiki posisi */
        .d-flex.align-items-center {
            justify-content: flex-end;
        }

        @media (max-width: 576px) {
            .btn-text {
                display: none; /* Sembunyikan teks */
            }
            .btn {
                padding: 0.25rem 1.5rem; /* Ukuran padding lebih kecil */
                font-size: 1rem; /* Ukuran font lebih kecil */
            }
        }

        .is-invalid { border-color: #dc3545 !important; }

    </style>
    

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Handle view pegawai button click using event delegation
        $(document).on('click', '.view-pegawai-btn', function() {
            const pegawaiId = $(this).data('id');
            
            // Show modal with loading spinner
            $('#viewPegawaiModal').modal('show');
            
            // Fetch employee details via AJAX
            $.ajax({
                url: '<?= base_url('admin/pegawai/viewDetail') ?>/' + pegawaiId,
                type: 'GET',
                dataType: 'json',
                error: function(xhr, status, error) {
                    // If admin route fails, try the regular employee route
                    $.ajax({
                        url: '<?= base_url('pegawai/viewDetail') ?>/' + pegawaiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Replace modal content with the returned HTML
                                $('#viewPegawaiContent').html(response.html);
                            } else {
                                // Show error message
                                $('#viewPegawaiContent').html('<div class="alert alert-danger m-3">' + response.message + '</div>');
                            }
                        },
                        error: function() {
                            // Show error message if both routes fail
                            $('#viewPegawaiContent').html('<div class="alert alert-danger m-3">Terjadi kesalahan saat mengambil data pegawai.</div>');
                        }
                    });
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Replace modal content with the returned HTML
                        $('#viewPegawaiContent').html(response.html);
                    } else {
                        // Show error message
                        $('#viewPegawaiContent').html('<div class="alert alert-danger m-3">' + response.message + '</div>');
                    }
                }
            });
        });
        
        // Reset modal content when modal is closed
        $('#viewPegawaiModal').on('hidden.bs.modal', function() {
            $('#viewPegawaiContent').html(`
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
            `);
        });
        
        // Confirm delete function
        window.confirmDeletePegawai = function(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pegawai ini?')) {
                window.location.href = '<?= base_url('admin/pegawai/delete') ?>/' + id;
            }
        };
    });
</script>

<?php if (session()->getFlashdata('success_pegawai')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_pegawai'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_pegawai')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_pegawai'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<style>
    .custom-action-buttons .btn {
        margin-right: 5px;
    }

    .custom-search-btn {
        margin-left: 5px;
    }

    .custom-add-pegawai-btn {
        margin-left: 10px;
    }
</style>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        // Handle view pegawai button click using event delegation
        $(document).on('click', '.view-pegawai-btn', function() {
            const pegawaiId = $(this).data('id');
            
            // Show modal with loading spinner
            $('#viewPegawaiModal').modal('show');
            
            // Fetch employee details via AJAX
            $.ajax({
                url: '<?= base_url('admin/pegawai/viewDetail') ?>/' + pegawaiId,
                type: 'GET',
                dataType: 'json',
                error: function(xhr, status, error) {
                    // If admin route fails, try the regular employee route
                    $.ajax({
                        url: '<?= base_url('pegawai/viewDetail') ?>/' + pegawaiId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Replace modal content with the returned HTML
                                $('#viewPegawaiContent').html(response.html);
                            } else {
                                // Show error message
                                $('#viewPegawaiContent').html('<div class="alert alert-danger m-3">' + response.message + '</div>');
                            }
                        },
                        error: function() {
                            // Show error message if both routes fail
                            $('#viewPegawaiContent').html('<div class="alert alert-danger m-3">Terjadi kesalahan saat mengambil data pegawai.</div>');
                        }
                    });
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Replace modal content with the returned HTML
                        $('#viewPegawaiContent').html(response.html);
                    } else {
                        // Show error message
                        $('#viewPegawaiContent').html('<div class="alert alert-danger m-3">' + response.message + '</div>');
                    }
                }
            });
        });
        
        // Reset modal content when modal is closed
        $('#viewPegawaiModal').on('hidden.bs.modal', function() {
            $('#viewPegawaiContent').html(`
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
            `);
        });
        
        // Confirm delete function
        window.confirmDeletePegawai = function(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pegawai ini?')) {
                window.location.href = '<?= base_url('admin/pegawai/delete') ?>/' + id;
            }
        };
    });
</script>
<?= $this->endSection(); ?>