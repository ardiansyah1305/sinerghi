<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-footer .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .modal-footer .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">User Management</h2>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>NIP</th>
                        <th>Gelar Depan</th>
                        <th>Nama</th>
                        <th>Gelar Belakang</th>
                        <th>Role</th>
                        <th>Kode Bidang</th>
                        <th>Status</th>
                        <th>Jabatan Struktural</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['nip']); ?></td>
                            <td><?= esc($user['gelar_depan']); ?></td>
                            <td><?= esc($user['nama']); ?></td>
                            <td><?= esc($user['gelar_belakang']); ?></td>
                            <td><?= $user['role'] == '1' ? 'Admin' : 'User'; ?></td>
                            <td><?= esc($user['kode_bidang']); ?></td>
                            <td><?= esc($user['status']); ?></td>
                            <td><?= esc($user['jabatan_struktural']); ?></td>
                            <td>
                                <a href="<?= site_url('admin/users/edit/' . $user['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= site_url('admin/users/delete/' . $user['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('admin/users/store'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gelar_depan">Gelar Depan</label>
                            <input type="text" name="gelar_depan" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="gelar_belakang">Gelar Belakang</label>
                            <input type="text" name="gelar_belakang" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="role">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="kode_bidang">Kode Bidang</label>
                            <input type="text" name="kode_bidang" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <input type="text" name="status" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jabatan_struktural">Jabatan Struktural</label>
                            <input type="text" name="jabatan_struktural" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-custom">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
