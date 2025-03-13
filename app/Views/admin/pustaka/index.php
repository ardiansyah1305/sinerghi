<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container py-4 px-5">
<h2 class="fw-semibold mb-4">Kelola Pustaka</h2>
<!-- Tabel Konten -->
    <div class="card shadow mt-4">
        <div class="card-body">
            <a href="<?= site_url('admin/pustaka/create'); ?>" class="btn btn-success-add mb-3 mt-2" style="margin-left: 12px;">
                Tambah
                <i class="bi bi-plus-circle"></i>
            </a>
	    <div class="table-responsive">
		<table id="example" class="table table-bordered table-striped table-hover" style="width: 100%;">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="text-center align-middle bg-dark text-white">Judul</th>
                        <th class="text-center align-middle bg-dark text-white">Deskripsi</th>
                        <th class="text-center align-middle bg-dark text-white">Unit Terkait</th>
                        <th class="text-center align-middle bg-dark text-white">Tanggal</th>
                        <th class="text-center align-middle bg-dark text-white">File Upload</th>
                        <th class="text-center align-middle bg-dark text-white">Kategori</th>
                        <th class="text-center align-middle bg-dark text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contents as $content): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $content['judul']; ?></td>
                        <td class="text-center align-middle"><?= $content['deskripsi']; ?></td>
                        <td class="text-center align-middle"><?= $content['unit_terkait']; ?></td>
                        <td class="text-center align-middle"><?= $content['tanggal']; ?></td>
                        <td class="text-center align-middle"><a href="<?= site_url('admin/referensi/viewFile/' . $content['file_upload']); ?>" target="_blank">Lihat File</a></td>
                        <td class="text-center align-middle"><?= $categories[$content['parent_id']] ?? 'Tanpa Kategori'; ?></td>
                        <td class="text-center align-middle">
                            <a href="<?= site_url('admin/pustaka/edit/' . $content['id']); ?>" class="btn btn-sm btn-warning text-black mb-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            				<button onclick="confirmDeleteContent(<?= $content['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Kategori & Content -->
<script>

    // Content
    function confirmDeleteContent(contentId) {

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
                    timer: 2000,
                    timerProgressBar: true
                }).then((result) => {
                    window.location.href = "<?= site_url('admin/pustaka/delete/'); ?>" + contentId;
                });
            }
        });
    }
</script>

<!-- Konten -->
<?php if (session()->getFlashdata('success_pustaka')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_pustaka'); ?>",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_pustaka')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_pustaka'); ?>",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>