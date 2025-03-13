<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    /* Gaya untuk merapikan tampilan */
    .container {
        padding: 20px;
    }

    /* Section Styles */
    .section-wrapper {
        margin-bottom: 40px;
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
        /* Warna latar belakang netral */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Slider Section */
    .slider-section h3,
    .popup-section h3,
    .card-section h3,
    .calendar-section h3 {
        color: #343a40;
        margin-bottom: 20px;
        border-bottom: 2px solid #e3e3e3;
        /* Garis bawah untuk judul section */
        padding-bottom: 10px;
    }

    .form-wrapper {
        margin-bottom: 20px;
    }

    .table-responsive {
        margin-bottom: 40px;
    }

    .table {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #343a40;
        color: #fff;
        border: none;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .table img {
        border-radius: 5px;
    }

    .btn {
        border-radius: 5px;
    }


    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        color: #fff;
    }

.btn-primary {
    background-color:  #1687a7;
    border-color: #007bff;
    color: #fff;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #157f9e;
    border-color: #0056b3;
    color: #fff;
}


    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        color: #fff;
    }
</style>

<div class="container-fluid px-5 py-4">
    <h2 class="mb-4 fw-semibold">Kelola Slider</h2>

    <!-- Card Slider -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h3>Slider</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
                <div class="d-flex">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addslider">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sliders as $slider): ?>
                                <tr>
                                    <td class="text-center"><?= $slider['id']; ?></td>
                                    <td class="text-center"><img src="<?= base_url('img/' . $slider['image']); ?>" alt="Slider Image" width="100"></td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSliderModal<?= $slider['id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button onclick="confirmDeleteSlider(<?= $slider['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Slider Modal -->
                                <div class="modal fade" id="editSliderModal<?= $slider['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editSliderModalLabel<?= $slider['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title" id="editSliderModalLabel<?= $slider['id']; ?>">Edit Slider</h5>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                                    <!-- <span aria-hidden="true">&times;</span> -->
                                                </button>
                                            </div>
                                            <?= view('admin/beranda/edit', ['sliders' => $slider]); ?>                                        </div>
                                    </div>
                                </div>

                                <!-- Add Card Modal -->
                                <div class="modal fade" id="addslider" tabindex="-1" aria-labelledby="addsliderLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="addsliderLabel">Tambah Slider</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <?= view('admin/beranda/create_slider'); ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- End Card Slider-->
    
</div>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteSlider(sliderId) {
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
                    window.location.href = "<?= site_url('admin/beranda/deleteSlider/'); ?>" + sliderId;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_slider')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_slider'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_slider')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_slider'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>