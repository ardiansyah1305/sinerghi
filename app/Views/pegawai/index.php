<?= $this->extend('pegawai/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Data Pegawai</h2>
    <div class="card shadow">
        <div class="card-header">
            <h4>Pegawai</h4>
        </div>
        <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPegawaiModal">
                            Tambah
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                    <div class="d-flex">
                        <a href="<?= base_url('pegawai/pegawai/downloadTemplateCsv') ?>" class="btn btn-secondary me-2">
                            Template CSV
                            <i class="bi bi-download"></i>
                        </a>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                            CSV
                            <i class="bi bi-filetype-csv"></i>
                        </button>
                        <button class="btn btn-success custom-add-pegawai-btn ml-1" data-bs-toggle="modal" data-bs-target="#addFilterModal">
                            Filter
                            <i class="bi bi-filter"></i>
                        </button>
                    </div>
                </div>

                <!-- Alert -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success my-3" role="alert"><?= session()->getFlashdata('success') ?></div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger my-3" role="alert"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
            <!-- End Alert -->
    <!-- </div> -->

    <!-- Tabel Pegawai -->
    <table id="example" class="table ms-auto border table-responsive-lg" style="max-width: 100%;">
        <thead>
            <tr>
                <th class="text-center border">No</th>
                <th class="text-center border">NIP</th>
                <th class="text-center border">Gelar Depan</th>
                <th class="text-center border">Nama Pegawai</th>
                <th class="text-center border">Gelar Belakang</th>
                <th class="text-center border">Pangkat</th>
                <th class="text-center border">Agama</th>
                <th class="text-center border" style="width: 180px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($pegawai)): ?>
        <?php $i = 1; foreach ($pegawai as $pgw): ?>
            <tr>
                <td class="text-center border"><?= $i++; ?></td>
                <td class="text-center border"><?= esc($pgw['nip']); ?></td>
                <td class="text-center border"><?= esc($pgw['gelar_depan']); ?></td>
                <td class="text-center border"><?= esc($pgw['nama']); ?></td>
                <td class="text-center border"><?= esc($pgw['gelar_belakang']); ?></td>
                <td class="text-center border"><?= esc($pgw['pangkat']); ?></td>
                <td class="text-center border"><?= esc($pgw['agama']); ?></td>
                <td class="text-center border">
                <div class="d-flex justify-content-center gap-3 custom-action-buttons">
                    <button class="btn btn-sm custom-edit-btn border border-warning text-warning" data-bs-toggle="modal" data-bs-target="#editPegawaiModal<?= $pgw['id']; ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button onclick="confirmDelete(<?= $pgw['id']; ?>)" class="btn text-danger border-danger btn-sm custom-delete-btn border">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            </td>
        </tr>
        
                <!-- Edit Pegawai Modal -->
                <div class="modal fade" id="editPegawaiModal<?= $pgw['id']; ?>" tabindex="-1" aria-labelledby="editPegawaiModalLabel<?= $pgw['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border">
                            <div class="modal-header bg-warning text-white border-bottom">
                                <h5 class="modal-title" id="editPegawaiModalLabel<?= $pgw['id']; ?>">Edit Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= view('pegawai/pegawai/edit', ['pegawai' => $pgw]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Edit Pegawai Modal -->
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pegawai yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
    </style>

    <!-- Pagination -->
    

<!-- Add User Modal -->
<div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addPegawaiModalLabel">Add Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('pegawai/pegawai/create'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload CSV -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="uploadCsvModalLabel">Import Data Pegawai dari CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pegawai/pegawai/uploadCsv') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Pilih File CSV:</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv, .xlsx" required>
                    </div>
                    <small class="text-muted">Unggah dengan format .csv</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div

<!-- Add User Modal -->
<div class="modal fade" id="addFilterModal" tabindex="-1" aria-labelledby="addFilterLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addFilterLabel">Add Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('pegawai/pegawai/filter'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function confirmDelete(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this pegawai!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('pegawai/pegawai/delete/'); ?>" + id;
                } else {
                    swal("Your pegawai is safe!");
                }
            });
    }
</script>

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