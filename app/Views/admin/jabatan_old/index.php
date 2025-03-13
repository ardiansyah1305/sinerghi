<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">Jabatan Management</h2>
    <div class="table-responsive border p-3">
    <!-- Bagian Pencarian dan Tombol Add Pegawai -->
    <!-- <div class="d-flex justify-content-between align-items-center mb-3 border p-2"> -->
    <div class="d-flex justify-content-end mb-3">
        <div class="d-flex">
            <form action="<?= site_url('admin/jabatan'); ?>" method="get" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Pencarian" value="<?= esc($search) ?>" style="width: 200px;">
                <button type="submit" class="btn btn-primary ml-2 custom-search-btn">Cari</button>
            </form>
            <button class="btn btn-success custom-add-jabatan-btn ml-2" data-bs-toggle="modal" data-bs-target="#addJabatanModal">Add Jabatan</button>
        </div>
    </div>
    <!-- </div> -->

    <!-- Tabel Pegawai -->
    <table class="table table table ms-auto border" style="max-width: 100%;">
        <thead class="table">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Jabatan</th>
                    <th class="text-center">Fungsional</th>
                    <th class="text-center">Pelaksana</th>
                    <th class="text-center">Eselon</th>
                    <th class="text-center">Pjp</th>
                    <th class="text-center">Pppk</th>
                    <th class="text-center" style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 + (20 * ($currentPage - 1)); ?>
                <?php foreach ($jabatan as $jabatan): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= esc($jabatan['nama_jabatan']); ?></td>
                        <td class="text-center"><?= esc($jabatan['is_fungsional']); ?></td>
                        <td class="text-center"><?= esc($jabatan['is_pelaksana']); ?></td>
                        <td class="text-center"><?= esc($jabatan['eselon']); ?></td>
                        <td class="text-center"><?= esc($jabatan['is_pjp']); ?></td>
                        <td class="text-center"><?= esc($jabatan['is_pppk']); ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-3 custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editJabatanModal<?= $jabatan['id']; ?>">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $jabatan['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>



                    <!-- Edit Jabatan Modal -->
                    <div class="modal fade" id="editJabatanModal<?= $jabatan['id']; ?>" tabindex="-1" aria-labelledby="editJabatanModalLabel<?= $jabatan['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editJabatanModalLabel<?= $jabatan['id']; ?>">Edit Jabatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('admin/jabatan/edit', ['jabatan' => $jabatan]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Jabatan Modal -->
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        <nav>
            <?= $pager->links('default', 'bootstrap_full'); ?>
        </nav>
    </div>
</div>
    </div>

    

<!-- Add Jabatan Modal -->
<div class="modal fade" id="addJabatanModal" tabindex="-1" aria-labelledby="addJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="addJabatanModalLabel">Add Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('admin/jabatan/create'); ?>
            </div>
        </div>
    </div>
</div>

<!--  -->


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function confirmDelete(jabatanId) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this jabatan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('admin/jabatan/delete/'); ?>" + jabatanId;
                } else {
                    swal("Your jabatan is safe!");
                }
            });
    }
    document.getElementById("nama_jabatan").addEventListener("invalid", function(e) {
            e.target.setCustomValidity("Field ini harus diisi");
        });

        document.getElementById("nama_jabatan").addEventListener("input", function(e) {
            e.target.setCustomValidity("");
        });
</script>

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

    .required-label::after {
            content: '*';
            color: red;
            margin-left: 5px;
        }
</style>

<?= $this->endSection(); ?>