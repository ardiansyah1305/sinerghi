<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Layanan</h2>
    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2" style="margin-left: 12px;">
                <a href="<?= site_url('admin/layanan/create') ?>" class="btn btn-success-add">
                    Tambah
                    <i class="bi bi-plus-circle"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="max-width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center align-middle text-white bg-dark">No</th>
                            <th class="text-center align-middle text-white bg-dark">Kategori</th>
                            <th class="text-center align-middle text-white bg-dark">Judul</th>
                            <th class="text-center align-middle text-white bg-dark">Warna</th>
                            <th class="text-center align-middle text-white bg-dark">Link</th>
                            <th class="text-center align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($layanan as $item): ?>
                        <tr>
                            <td class="text-center align-middle"><?= $i++; ?></td>
                            <td class="text-center align-middle"><?= $item['kategori_name']; ?></td>
                            <td class="text-center align-middle"><?= $item['title']; ?></td>
                            <td class="text-center align-middle" style="background-color: <?= $item['color']; ?>;"></td>
                            <td class="align-middle">
                                <?php $links = json_decode($item['links'], true); ?>
                                <?php if (is_array($links)): ?>
                                    <?php foreach ($links as $link): ?>
                                        <div><?= $link['name']; ?>: <a href="<?= $link['url']; ?>" target="_blank" style="color: #007bff;"><?= $link['url']; ?></a></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center align-middle">
                                <a href="<?= site_url('admin/layanan/edit/' . $item['id']); ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                				<button onclick="confirmDeleteLayanan(<?= $item['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        
        </div>
    </div>
</div>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteLayanan(layananId) {
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
                    window.location.href = "<?= site_url('admin/layanan/delete/'); ?>" + layananId;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_layanan')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_layanan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_layanan')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_layanan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>
