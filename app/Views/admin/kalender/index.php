<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Calendar Section -->
 <div class="container py-4 px-5">
    <h2 class="fw-semibold text-uppercase mb-4">Kelola Kalender penting</h2>
    <div class="card shadow rounded-4 mb-2 mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addkalenderModal">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>
            
        <div class="table-responsive">
            <table class="table ref-table table-striped table-bordered" style="max-width: 100%;">
                <thead class="table bg-light">
                    <tr>
                        <th class="text-center text-white bg-dark">No</th>
                        <th class="text-center text-white bg-dark">Judul</th>
                        <th class="text-center text-white bg-dark">Deskripsi</th>
                        <th class="text-center text-white bg-dark">Tanggal Mulai</th>
                        <th class="text-center text-white bg-dark">Tanggal Akhir</th>
                        <th class="text-center text-white bg-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($calenders as $calender): ?>
                        <tr>
                            <td class="text-center border align-middle"><?= $i++; ?></td>
                            <td class="border align-middle"><?= $calender['title']; ?></td>
                            <td class="border align-middle"><?= $calender['description']; ?></td>
                            <td class="text-center border align-middle"><?= $calender['start']; ?></td>
                            <td class="text-center border align-middle"><?= $calender['end']; ?></td>
                            <td class="text-center border align-middle">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCalendarModal<?= $calender['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDeleteKalender(<?= $calender['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Calendar Modal -->
                        <div class="modal fade" id="editCalendarModal<?= $calender['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCalendarModalLabel<?= $calender['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title" id="editCalendarModalLabel<?= $calender['id']; ?>">Edit Kalender</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= view('admin/kalender/edit', ['calender' => $calender]); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Add Calender Modal -->
                        <div class="modal fade" id="addkalenderModal" tabindex="-1" aria-labelledby="addAgamaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="addAgamaModalLabel">Tambah Kalender</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?= view('admin/kalender/create'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
 </div>

 

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteKalender(kalenderId) {
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
                    window.location.href = "<?= site_url('admin/kalender/delete/'); ?>" + kalenderId;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_kalender')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_kalender'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_kalender')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_kalender'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formKalender');

        form.addEventListener('submit', function (e) {
            // Menghentikan submit default
            e.preventDefault();

            let isValid = true;

            // Validasi Judul
            const title = document.getElementById('title');
            if (title.value.trim() === '') {
                isValid = false;
                title.classList.add('is-invalid');
                title.nextElementSibling.textContent = 'Judul wajib diisi.';
            } else {
                title.classList.remove('is-invalid');
                title.classList.add('is-valid');
                title.nextElementSibling.textContent = '';
            }

            // Validasi Deskripsi
            const description = document.getElementById('description');
            if (description.value.trim() === '') {
                isValid = false;
                description.classList.add('is-invalid');
                description.nextElementSibling.textContent = 'Deskripsi wajib diisi.';
            } else {
                description.classList.remove('is-invalid');
                description.classList.add('is-valid');
                description.nextElementSibling.textContent = '';
            }

            // Validasi Tanggal Mulai
            const start = document.getElementById('start');
            if (start.value === '') {
                isValid = false;
                start.classList.add('is-invalid');
                start.nextElementSibling.textContent = 'Tanggal mulai wajib diisi.';
            } else {
                start.classList.remove('is-invalid');
                start.classList.add('is-valid');
                start.nextElementSibling.textContent = '';
            }

            // Validasi Tanggal Selesai
            const end = document.getElementById('end');
            if (end.value === '') {
                isValid = false;
                end.classList.add('is-invalid');
                end.nextElementSibling.textContent = 'Tanggal selesai wajib diisi.';
            } else if (start.value && new Date(end.value) < new Date(start.value)) {
                isValid = false;
                end.classList.add('is-invalid');
                end.nextElementSibling.textContent = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
            } else {
                end.classList.remove('is-invalid');
                end.classList.add('is-valid');
                end.nextElementSibling.textContent = '';
            }

            // Jika valid, submit form
            if (isValid) {
                form.submit();
            }
        });
    });
</script> -->



<!-- Success Alert -->
<!-- <script>
    <?php if(session()->getFlashdata('success')): ?>
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
</script> -->

<?= $this->endSection(); ?>
