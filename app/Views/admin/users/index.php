<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">User Management</h2>
    <div class="d-flex justify-content-between mb-3">
        <form action="<?= site_url('admin/users'); ?>" method="get" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="<?= esc($search) ?>">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm w-100">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Gelar Depan</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Gelar Belakang</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Kode Bidang</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Jabatan Struktural</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 + (20 * ($currentPage - 1)); ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= esc($user['nip']); ?></td>
                        <td class="text-center"><?= esc($user['gelar_depan']); ?></td>
                        <td class="text-center"><?= esc($user['nama']); ?></td>
                        <td class="text-center"><?= esc($user['gelar_belakang']); ?></td>
                        <td class="text-center"><?= $user['role'] == '1' ? 'Admin' : 'User'; ?></td>
                        <td class="text-center"><?= esc($user['kode_bidang']); ?></td>
                        <td class="text-center"><?= esc($user['status']); ?></td>
                        <td class="text-center"><?= esc($user['jabatan_struktural']); ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $user['id']; ?>)" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal<?= $user['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $user['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editUserModalLabel<?= $user['id']; ?>">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('admin/users/edit', ['user' => $user]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit User Modal -->
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        <nav>
            <?= $pager->links('default', 'bootstrap_full'); ?>
        </nav>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('admin/users/create'); ?>
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
    function confirmDelete(userId) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.location.href = "<?= site_url('admin/users/delete/'); ?>" + userId;
            } else {
                swal("Your user is safe!");
            }
        });
    }
</script>

<?= $this->endSection(); ?>
