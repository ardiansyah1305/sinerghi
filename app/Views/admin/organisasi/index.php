<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="p-4 mb-4" style="background-color: #f0f4f7; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <h1 class="mb-4">Kelola Organisasi</h1>
        <div class="d-flex justify-content-end mb-3">
            <div class="d-flex">
                <form action="<?= site_url('admin/organisasi'); ?>" method="get" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Search by Nama Unit Kerja" value="<?= esc($search) ?>" style="width: 200px;">
                    <button type="submit" class="btn btn-primary ml-2 custom-search-btn">Search</button>
                </form>
                <button class="btn btn-success custom-add-organisasi-btn ml-2" data-bs-toggle="modal" data-bs-target="#addOrganisasiModal">Add Unit Kerja</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mx-auto" style="max-width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Unit Kerja</th>
                        <th class="text-center">Parent ID</th>
                        <th class="text-center" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 + (20 * ($currentPage - 1)); ?>
                    <?php foreach ($organisasi as $organisasi): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= esc($organisasi['nama_unit_kerja']); ?></td>
                            <td class="text-center"><?= esc($organisasi['parent_id']); ?></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-3 custom-action-buttons">
                                    <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editOrganisasiModal<?= $organisasi['id']; ?>">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete(<?= $organisasi['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

    <!-- Success Alert -->
    <script>
        <?php if (session()->getFlashdata('success')): ?>
            swal({
                title: "Berhasil!",
                text: "<?= session()->getFlashdata('success') ?>",
                icon: "success",
                button: "OK",
            });
        <?php endif; ?>

        // Confirm Delete
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                swal({
                        title: "Apakah Anda yakin?",
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: "warning",
                        buttons: ["Batal", "Hapus"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Data Anda aman!");
                        }
                    });
            });
        });
    </script>

    <?= $this->endSection(); ?>