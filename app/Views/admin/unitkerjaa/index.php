<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Unit Kerja Management</h2>
    <div class="card shadow">
        <div class="card-header">
            DataTables Unit Kerja
        </div>
        <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUnitkerjaaModal">
                    Tambah
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
            <div class="d-flex">
                <form action="<?= site_url('admin/unitkerjaa'); ?>" method="get" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Pencarian" value="<?= esc($search) ?>" style="width: 200px;">
                    <button type="submit" class="btn btn-primary ml-2 custom-search-btn">Cari</button>
                </form>
            </div>
        </div>
    <!-- </div> -->

    <!-- Tabel Pegawai -->
    <table class="table table table ms-auto border table-responsive-lg" style="max-width: 100%;">
        <thead class="table">
            <tr>
                <th class="text-center border">No</th>
                <th class="text-center border">Nama Unit Kerja</th>
                <th class="text-center border">Induk Unit Kerja</th>
                <th class="text-center border" style="width: 180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
        
        
        <!-- Display unit_kerja -->
        <?php foreach ($unit_kerja as $uk): ?>
            <tr>
              
            </tr>
 
            <!-- Check and display unit_kerjaa entries -->
            <?php foreach ($unit_kerjaa as $uka): ?>
                <?php if ($uk['id'] == $uka['unit_kerja_id']): ?>
                    <tr>
                        <td class="text-center border"><?= $i++; ?></td>
                        <td class="text-center border"><?= $uka['nama_unit_kerja']; ?></td>
                        <td class="text-center border"><?= $uka['nama_unit_kerja_utama']; ?></td>
                        <td class="text-center border">
                            <div class="d-flex justify-content-center gap-3 custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn border" data-bs-toggle="modal" data-bs-target="#editUnitkerjaaModal<?= $uka['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $uka['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn border">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        
        
    <?php $i = 1; foreach ($unit_kerja as $uk): ?>
                 <!-- Edit unitkerja Modal -->
                 <div class="modal fade" id="editUnitkerjaModal<?= $uk['id']; ?>" tabindex="-1" aria-labelledby="editUnitkerjaModalLabel<?= $uk['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editUnitkerjaModalLabel<?= $uk['id']; ?>">Edit Unit Kerja</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('admin/unitkerja/edit', ['unitkerja' => $uk]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($unit_kerjaa as $uka): ?>
                        <?php if ($uka['unit_kerja_id'] == $uk['id']): ?>
                 <!-- Edit unitkerjaa Modal -->
                 <div class="modal fade" id="editUnitkerjaaModal<?= $uka['id']; ?>" tabindex="-1" aria-labelledby="editUnitkerjaaModalLabel<?= $uka['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editUnitkerjaModalLabel<?= $uka['id']; ?>">Edit Unit Kerja</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('admin/unitkerjaa/edit', ['unitkerjaa' => $uka]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
    <?php endforeach; ?>
    <?php endforeach; ?>
        </tbody>
    </table>
        </div>
    </div>
    
    
    <div class="d-flex justify-content-end mt-3">
        <nav>
            <?= $pager->links('default', 'bootstrap_full'); ?>
        </nav>
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
<div class="modal fade" id="addUnitkerjaaModal" tabindex="-1" aria-labelledby="addUnitkerjaaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUnitkerjaaModalLabel">Tambah Induk Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('admin/unitkerjaa/create'); ?>
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
                    window.location.href = "<?= site_url('admin/unitkerjaa/delete/'); ?>" + id;
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