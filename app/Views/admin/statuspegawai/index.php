<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Unit Kerja Management</h2>
    <div class="card shadow">
        <div class="card-header">
            DataTables Unit Kerja
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
        <div class="d-flex">
            <button class="btn btn-success-add" data-bs-toggle="modal" data-bs-target="#addUnitkerjaModal">
                Tambah
                <i class="bi bi-plus-circle"></i>
            </button>
        </div>
    </div>
<table id="example" class="table table-bordered table-responsive-lg" style="max-width: 100%;">
        <thead class="table bg-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Status Pegawai</th>
                    <th class="text-center" style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            <?php if (!empty($statuspegawai) && is_array($statuspegawai)): ?>
                <?php foreach ($statuspegawai as $status): ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td class="text-center"><?= esc($status['nama_status']); ?></td>
                        
                        
                        <td class="text-center">
                            <div class="d-flex justify-content-center custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editUnitkerjaModal<?= $status['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $status['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit unitkerja Modal -->
                    <div class="modal fade" id="editUnitkerjaModal<?= $status['id']; ?>" tabindex="-1" aria-labelledby="editUnitkerjaModalLabel<?= $status['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editUnitkerjaModalLabel<?= $status['id']; ?>">Edit Unit Kerja</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('admin/statuspegawai/edit', ['statuspegawai' => $status]); ?>
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
    <!-- Bagian Pencarian dan Tombol Add Pegawai -->
    
        <!-- Pagination -->
</div>
<!-- Add Unit Kerja Modal -->
<div class="modal fade" id="addUnitkerjaModal" tabindex="-1" aria-labelledby="addUnitkerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="addUnitkerjaModalLabel">Tambah Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('admin/statuspegawai/create'); ?>
            </div>
        </div>
    </div>
</div>
                

<!-- Bootstrap JS -->
<script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function confirmDelete(unitkerjaId) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Unit Kerja!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('admin/unitkerja/delete/'); ?>" + unitkerjaId;
                } else {
                    swal("Your Unit Kerja is safe!");
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

    .custom-add-unitkerja-btn {
        margin-left: 10px;
    }
</style>