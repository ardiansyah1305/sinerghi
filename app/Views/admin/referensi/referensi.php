<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    /* Styles for the main container */
    .ref-container {
        padding: 20px;
        font-family: 'Arial', sans-serif;
    }

    .ref-header,
    .ref-subheader {
        color: #333;
        margin-bottom: 20px;
    }

    .ref-subheader {
        font-size: 1.2rem;
        margin-top: 40px;
    }

    /* Form Styles */
    .ref-form {
        margin-bottom: 20px;
    }

    .ref-form-label {
        font-weight: bold;
        color: #555;
    }

    .ref-form-control {
        border-radius: 5px;
        box-shadow: none;
        border: 1px solid #ced4da;
    }

    .ref-form-control:focus {
        border-color: #6c757d;
        box-shadow: 0 0 5px rgba(108, 117, 125, 0.25);
    }

    .ref-btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff !important;
        /* Teks warna putih dengan !important */
        padding: 10px 20px;
        font-size: 1rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .ref-btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    /* Table Styles */
    .ref-table {
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .ref-table th {
        background-color: #343a40;
        color: #fff;
        border: none;
    }

    .ref-table td,
    .ref-table th {
        vertical-align: middle;
    }

    .ref-table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .ref-table-striped tbody tr:hover {
        background-color: #e9ecef;
    }

    .ref-table a {
        text-decoration: none;
        color: #007bff;
    }

    .ref-table a:hover {
        text-decoration: underline;
    }

    .ref-btn-sm {
        padding: 5px 10px;
        font-size: 0.875rem;
        border-radius: 5px;
    }

    .ref-btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #fff !important;
        /* Teks warna putih dengan !important */
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .ref-btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }

    .ref-btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff !important;
        /* Teks warna putih dengan !important */
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .ref-btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .table-custom,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

<div class="ref-container px-5 py-4">
    <!-- <h1 class="ref-header">Kelola Referensi</h1> -->
    <h2 class="fw-semibold mb-4">Kelola Referensi</h2>

    <!-- Form Tambah Kategori -->

    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addkategoriModal">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Tabel Kategori -->
            <div class="table-responsive">
                <table class="table ref-table table-striped table-bordered table-hover mb-4">
                    <thead>
                        <tr>
                            <th class="text-center bg-dark text-white border" style="width: 100px;">No</th>
                            <th class="text-center bg-dark text-white border">Judul Kategori</th>
                            <th class="text-center bg-dark text-white border" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($categories as $id => $judul): ?>
                            <tr>
                                <td class="text-center align-middle border"><?= $i++; ?></td>
                                <td class="text-center border align-middle"><?= $judul; ?></td>
                                <td class="text-center border align-middle">
                                    <a href="<?= site_url('admin/referensi/editCategory/' . $id); ?>" class="btn btn-sm btn-warning text-black">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button onclick="confirmDeleteCategory(<?= $id; ?>)" class="btn btn-danger btn-sm custom-delete-btn ml-2">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>


                            <!-- Add Kategori Modal -->
                            <div class="modal fade" id="addkategoriModal" tabindex="-1" aria-labelledby="addkategoriModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="addkategoriModalLabel">Tambah Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <?= view('admin/referensi/create_kategori'); ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <hr>

    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Tabel Kategori -->
            <div class="table-responsive">
                <table class="table ref-table table-striped table-bordered table-hover mb-4">
                    <thead>
                        <tr>
                            <th class="text-center bg-dark text-white border" style="width: 100px;">No</th>
                            <th class="text-center bg-dark text-white border">Role</th>
                            <th class="text-center bg-dark text-white border" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($role as $roles): ?>
                            <tr>
                                <td class="text-center align-middle border"><?= $i++; ?></td>
                                <td class="text-center border align-middle"><?= $roles['nama_role']; ?></td>
                                <td class="text-center border align-middle">
                                    <div class="d-flex justify-content-center custom-action-buttons">
                                        <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editRoleModal<?= $roles['id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button onclick="confirmDeleteRole(<?= $roles['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn ml-2">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editRoleModal<?= $roles['id']; ?>" tabindex="-1" aria-labelledby="editRoleModalLabel<?= $roles['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title text-black" id="editRoleModalLabel<?= $roles['id']; ?>">Edit Role</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?= view('admin/role/edit', ['roles' => $roles]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Add Kategori Modal -->
                            <div class="modal fade" id="addkategoriModal" tabindex="-1" aria-labelledby="addkategoriModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="addkategoriModalLabel">Tambah Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <?= view('admin/referensi/create_kategori'); ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <hr>


    <!-- </div> -->


    <!-- Table Status Pernikahan -->
    <div class="card shadow rounded-4 mt-4 mb-4">
        <div class="card-body">
            <button class="btn btn-success mb-3 mt-2" data-bs-toggle="modal" data-bs-target="#addStatusPernikahanModal">
                <span class="btn-text">Tambah</span>
                <i class="bi bi-plus-circle"></i>
            </button>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" style="max-width: 100%;">
                    <thead class="table bg-light">
                        <tr>
                            <th class="text-center bg-dark text-white" style="width: 100px;">No</th>
                            <th class="text-center bg-dark text-white">Status Pernikahan</th>
                            <th class="text-center bg-dark text-white" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($statuspernikahan) && is_array($statuspernikahan)): ?>
                            <?php foreach ($statuspernikahan as $sp): ?>
                                <tr>
                                    <td class="text-center border align-middle"><?= $i++; ?></td>
                                    <td class="text-center border align-middle"><?= esc($sp['status']); ?></td>


                                    <td class="text-center border align-middle">
                                        <div class="d-flex justify-content-center custom-action-buttons">
                                            <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editStatusPernikahanModal<?= $sp['id']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button onclick="confirmDeleteSp(<?= $sp['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn ml-2">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit unitkerja Modal -->
                                <div class="modal fade" id="editStatusPernikahanModal<?= $sp['id']; ?>" tabindex="-1" aria-labelledby="editStatusPernikahanModalLabel<?= $sp['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title" id="editStatusPernikahanModalLabel<?= $sp['id']; ?>">Edit Status Pernikahan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?= view('admin/statuspernikahan/edit', ['statuspernikahan' => $sp]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Edit Unit Kerja Modal -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- End Status Pernikahan -->

    <!-- Add Status Pernikahan Modal -->
    <div class="modal fade" id="addStatusPernikahanModal" tabindex="-1" aria-labelledby="addStatusPernikahanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addStatusPernikahanModalLabel">Tambah Status Pernikahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= view('admin/statuspernikahan/create'); ?>
                </div>
            </div>
        </div>
    </div>



    <hr>

    <!-- Table Agama -->
    <div class="card shadow rounded-4 mt-4 mb-4">
        <div class="card-body">
            <button class="btn btn-success mb-3 mt-2" data-bs-toggle="modal" data-bs-target="#addAgamaModal">
                <span class="btn-text">Tambah</span>
                <i class="bi bi-plus-circle"></i>
            </button>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" style="max-width: 100%;">
                    <thead class="table bg-light">
                        <tr>
                            <th class="text-center bg-dark text-white" style="width: 100px;">No</th>
                            <th class="text-center bg-dark text-white">Nama Agama</th>
                            <th class="text-center bg-dark text-white" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($agama) && is_array($agama)): ?>
                            <?php foreach ($agama as $agama): ?>
                                <tr>
                                    <td class="text-center border align-middle"><?= $i++; ?></td>
                                    <td class="text-center border align-middle"><?= esc($agama['nama_agama']); ?></td>


                                    <td class="text-center border align-middle">
                                        <div class="d-flex justify-content-center custom-action-buttons">
                                            <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editAgamaModal<?= $agama['id']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button onclick="confirmDeleteAgama(<?= $agama['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn ml-2">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit unitkerja Modal -->
                                <div class="modal fade" id="editAgamaModal<?= $agama['id']; ?>" tabindex="-1" aria-labelledby="editAgamaModalLabel<?= $agama['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title" id="editAgamaModalLabel<?= $agama['id']; ?>">Edit Agama</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?= view('admin/agama/edit', ['agama' => $agama]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Edit Unit Kerja Modal -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Status Pernikahan -->

    <!-- Add Agama Modal -->
    <div class="modal fade" id="addAgamaModal" tabindex="-1" aria-labelledby="addAgamaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addAgamaModalLabel">Tambah Agama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= view('admin/agama/create'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addRoleModalLabel">Tambah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= view('admin/role/create'); ?>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Table Status Pegawai -->
    <div class="card shadow rounded-4 mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" style="max-width: 100%;">
                    <thead class="table bg-light">
                        <tr>
                            <th class="text-center bg-dark text-white" style="width: 100px;">No</th>
                            <th class="text-center bg-dark text-white">Status Pegawai</th>
                            <!-- <th class="text-center bg-dark text-white" style="width: 180px;">Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($statuspegawai) && is_array($statuspegawai)): ?>
                            <?php foreach ($statuspegawai as $status): ?>
                                <tr>
                                    <td class="text-center border align-middle"><?= $i++; ?></td>
                                    <td class="text-center border align-middle"><?= esc($status['nama_status']); ?></td>


                                    <!-- <td class="text-center">
                            <div class="d-flex justify-content-center custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editUnitkerjaModal<?= $status['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $status['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn ml-2">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td> -->
                                </tr>

                                <!-- Edit Status Pegawai Modal -->
                                <div class="modal fade" id="editUnitkerjaModal<?= $status['id']; ?>" tabindex="-1" aria-labelledby="editUnitkerjaModalLabel<?= $status['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title text-black" id="editUnitkerjaModalLabel<?= $status['id']; ?>">Edit Status Pegawai</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?= view('admin/statuspegawai/edit', ['statuspegawai' => $status]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- End Edit Status Pegawai Modal -->
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- End Status Pegawai -->

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteCategory(kategoriId) {
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
                    window.location.href = "<?= site_url('admin/referensi/deleteCategory/'); ?>" + kategoriId;
                });
            }
        });
    }

    function confirmDeleteRole(RoleId) {
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
                    window.location.href = "<?= site_url('admin/referensi/role/delete-role/'); ?>" + RoleId;
                });
            }
        });
    }

    function confirmDeleteSp(spId) {
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
                    window.location.href = "<?= site_url('admin/statuspernikahan/delete/'); ?>" + spId;
                });
            }
        });
    }

    function confirmDeleteAgama(agamaId) {
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
                    window.location.href = "<?= site_url('admin/agama/delete/'); ?>" + agamaId;
                });
            }
        });
    }
</script>


<?php if (session()->getFlashdata('success_kategori')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_kategori'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_kategori')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_kategori'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('success_role')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_role'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_role')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_role'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>


<?php if (session()->getFlashdata('success_status')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_status'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_status')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_status'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>


<?php if (session()->getFlashdata('success_agama')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_agama'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_agama')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_agama'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>



<?= $this->endSection(); ?>