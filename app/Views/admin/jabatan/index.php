<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-3 py-4 px-sm-5 py-sm-4">
    <h3 class="fw-bold text-uppercase mb-4">Kelola Jabatan</h3>


    <!-- Card -->
    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">

            <!-- Button Add & Import -->
            <div class="d-flex justify-content-between mb-3 mt-3">
                <div class="d-flex">
                    <a href="<?= base_url('admin/jabatan/create') ?>" class="btn btn-success" style="margin-left: 12px;"><span class="btn-text">Tambah</span> <i class="bi bi-plus-circle"></i></a>
                    <!-- <button class="btn btn-success-add fs-6 fs-md-4" style="margin-left: 12px;" data-bs-toggle="modal" data-bs-target="#addJabatanModal">
                        Tambah
                        <i class="bi bi-plus-circle"></i>
                    </button> -->
                </div>
            </div>
            <!-- End Button Add & Import -->

            <!-- Table Jabatan -->
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover ms-auto" style="max-width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center border align-middle text-white bg-dark">No</th>
                            <th class="text-center border align-middle text-white bg-dark">Nama Jabatan</th>
                            <th class="text-center border align-middle text-white bg-dark">Eselon</th>
                            <th class="text-center border align-middle text-white bg-dark">Tipe Jabatan</th>
                            <th class="text-center border align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($jabatan as $jabatan): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $i++; ?></td>
                                <td class="text-center align-middle"><?= esc($jabatan['nama_jabatan']); ?></td>
                                <td class="text-center align-middle"><?php $eselon =$jabatan['eselon']; if($eselon != null){ echo $eselon;} else { echo "-";} ?></td>
                                <td class="text-center align-middle"><?= esc($jabatan['tipe_jabatan']); ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center custom-action-buttons">
                                        <a href="<?= base_url('admin/jabatan/edit/' . $jabatan['id']) ?>" class="btn btn-warning custom-edit-btn"> <i class="bi bi-pencil-square"></i></a>
                                        <button onclick="confirmDeleteJabatan(<?= $jabatan['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

        </div>
    </div>
    <!-- End Card -->

</div>
<!--  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteJabatan(jabatanId) {
        Swal.fire({
            title: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil Terhapus!",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    window.location.href = "<?= site_url('admin/jabatan/delete/'); ?>" + jabatanId;
                });
            }
        });
    }
</script>

<?php if (session()->getFlashdata('success_jabatan')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_jabatan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_jabatan')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_jabatan'); ?>",
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

    .custom-add-jabatan-btn {
        margin-left: 10px;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<?= $this->endSection(); ?>