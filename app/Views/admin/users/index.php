<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="mb-4 fw-semibold">Kelola Data User</h2>
    <div class="card shadow rounded-4" style="width: 100%;">
        <div class="card-body">
            <div class="d-flex justify-content-start">
                <div class="d-flex">
                    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-success" style="margin-left: 12px;"><span class="btn-text">Tambah</span> <i class="bi bi-plus-circle"></i></a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-bordered mb-2" style="max-width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center align-middle bg-dark text-white">No</th>
                            <th class="text-center align-middle bg-dark text-white">NIP</th>
                            <th class="text-center align-middle bg-dark text-white">Nama</th>
                            <!--<th class="dt-center">Nama</th>-->
                            <th class="text-center align-middle bg-dark text-white">Role</th>
                            <th class="text-center align-middle bg-dark text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $i++; ?></td>
                                <td class="text-center align-middle"><?= $user['nip'] ?></td>
                                <td class="text-center align-middle"><?= $user['nama'] ?></td>
                                <!-- <td class="dt-center"><?= $user['nama'] ?></td> -->
                                <td class="text-center align-middle">
                                    <?php $role_id = $user['role_id'];
                                    if ($role_id == 1) {
                                        echo "Super Admin";
                                    } elseif ($role_id == 2) {
                                        echo "Unit Kepegawaian";
                                    } elseif ($role_id == 3) {
                                        echo "verifikator Unit";
                                    } elseif ($role_id == 4) {
                                        echo "Pegawai";
                                    }
                                    ?>
                                </td>
                                <td class="text-center align-middle">
                                <a href="<?= base_url('admin/users/edit/'. $user['id'])?>" class="btn btn-warning" style="margin-left: 12px;"><span class="btn-text"></span> <i class="bi bi-pencil-square"></i></a>
                                    <button onclick="confirmDeleteUsers(<?= $user['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr> <!-- Edit unitkerja Modal -->
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <!-- Pagination -->

        </div>
    </div>
</div>

<?= $this->endSection(); ?>