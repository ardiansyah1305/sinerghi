<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">Riwayat Pendidikan Management</h2>
    <div class="d-flex justify-content-end mb-3">
        <div class="d-flex align-items-center">
            <form action="<?= site_url('admin/riwayat_pendidikan'); ?>" method="get" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search by name" value="<?= esc($search) ?>" style="width: 200px;">
                <button type="submit" class="btn btn-primary ml-2 custom-search-btn">Search</button>
            </form>
            <button class="btn btn-success custom-add- RiwayatPendidikan-btn ml-2" data-bs-toggle="modal" data-bs-target="#addRiwayatPendidikanModal">Tambah Riwayat Pendidikan</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover ms-auto" style="max-width: 100%;">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jurusan</th>
                    <th class="text-center" style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($riwayat_pendidikan as $rp): ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td class="text-center"><?= $rp['pegawai_id']; ?></td>
                        <td class="text-center"><?= $rp['jurusan']; ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-3 custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editRiwayatPendidikanModal<?= $rp['id']; ?>">Edit</button>
                                <button onclick="confirmDelete(<?= $rp['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">Delete</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Riwayat Pendidikan Modal -->
                    <div class="modal fade" id="editRiwayatPendidikanModal<?= $rp['id']; ?>" tabindex="-1" aria-labelledby="editRiwayatPendidikanModalLabel<?= $rp['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editRiwayatPendidikanModalLabel<?= $rp['id']; ?>">Edit Riwayat Pendidikan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('admin/riwayat_pendidikan/edit', ['riwayat_pendidikan' => $rp]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Riwayat Pendidikan Modal -->
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <style>
        .custom-search-btn,
        .custom-add- RiwayatPendidikan-btn {
            margin-left: 10px;
        }

        .custom-add- RiwayatPendidikan-btn {
            white-space: nowrap;
        }

        /* Optional: Jika butuh padding lebih untuk memperbaiki posisi */
        .d-flex.align-items-center {
            justify-content: flex-end;
        }
    </style>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        <nav>
            <?= $pager->links('default', 'bootstrap_full'); ?>
        </nav>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addRiwayatPendidikanModal" tabindex="-1" aria-labelledby="addRiwayatPendidikanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addRiwayatPendidikanModalLabel">Tambah Riwayat Pendidikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('admin/riwayat_pendidikan/create'); ?>
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
    function confirmDelete(RiwayatPendidikanId) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Riwayat Pendidikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('admin/riwayat_pendidikan/delete/'); ?>" + RiwayatPendidikanId;
                } else {
                    swal("Your Riwayat Pendidikan is safe!");
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

    .custom-add- RiwayatPendidikan-btn {
        margin-left: 10px;
    }
</style>

<?= $this->endSection(); ?>