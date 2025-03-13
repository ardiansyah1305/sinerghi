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
    <h2 class="mb-4 fw-semibold text-uppercase">Kelola Slider dan Popup</h2>

    <!-- Card Slider -->
    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <a href="<?= base_url('admin/beranda/create-slider'); ?>" class="btn btn-success"><i class="bi bi-plus-circle"></i>Tambah </a>
                    <!-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addslider">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button> -->
                </div>
            </div>

            
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center border" style="width: 100px;">No</th>
                                <th class="text-center border">Foto</th>
                                <th class="text-center border" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                            <?php foreach ($sliders as $slider): ?>
                                <tr>
                                    <td class="text-center border"><?= $i++; ?></td>
                                    <td class="text-center border"><img src="<?= base_url('img/' . $slider['image']); ?>" alt="Slider Image" width="100"></td>
                                    <td class="text-center border">
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSliderModal<?= $slider['id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button onclick="confirmDeletedSlide(<?= $slider['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
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
                                            <?= view('admin/beranda/edit', ['sliders' => $slider]); ?>                                        
					</div>
                                    </div>
                                </div>

                                <!-- Add Slider Modal -->
                                <!-- <div class="modal fade" id="addslider" tabindex="-1" aria-labelledby="addsliderLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success">
                                                <h5 class="modal-title text-white" id="addsliderLabel">Tambah Slider</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <//?= view('admin/beranda/create_slider'); ?>
                                        </div>
                                    </div>
                                </div> -->

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- End Card Slider-->

    <hr>

    <!-- Popup -->
    <div class="card shadow rounded-4 mb-4 mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                <a href="<?= base_url('admin/beranda/create-popup'); ?>" class="btn btn-success"><i class="bi bi-plus-circle"></i>Tambah </a>
                    <!-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addpopup">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button> -->
                </div>
            </div>

            
        <div class="table-responsive">
            <table class="table ref-table table-striped table-bordered table-hover" style="max-width: 100%;">
                <thead class="table bg-light">
                    <tr>
                        <th class="text-center text-white bg-dark border" style="width: 100px;">No</th>
                        <th class="text-center text-white bg-dark border">Foto</th>
                        <th class="text-center text-white bg-dark border" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                    <?php foreach ($popups as $popup): ?>
                        <tr>
                            <td class="text-center border align-middle"><?= $i++; ?></td>
                            <td class="text-center border align-middle"><img src="<?= base_url('img/' . $popup['image']); ?>" alt="Popup Image" width="100"></td>
                            <td class="text-center border align-middle">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPopupModal<?= $popup['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $popup['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Edit Card Modal -->
                        <div class="modal fade" id="editPopupModal<?= $popup['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPopupModalLabel<?= $popup['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title" id="editPopupModalLabel<?= $popup['id']; ?>">Edit Popup</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= view('admin/popup/edit', ['popups' => $popup]); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Add Card Modal -->
                        <div class="modal fade" id="addpopup" tabindex="-1" aria-labelledby="addpopupLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title text-white" id="addpopupLabel">Tambah Popup</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?= view('admin/popup/create'); ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <!-- End Popup -->
    
</div>

<!-- Include SweetAlert library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function confirmDeletedSlide(sliderId) {
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

    function confirmDelete(popupId) {
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
                    window.location.href = "<?= site_url('admin/popup/delete/'); ?>" + popupId;
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

<?php if (session()->getFlashdata('success_popup')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_popup'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_popup')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_popup'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>


<!-- <script>
    document.getElementById('addsliderForm').addEventListener('submit', function(event) {
        const imageInput = document.getElementById('image');
        const errorMessage = document.getElementById('error-message');
        const file = imageInput.files[0];

        // Reset pesan error dan border
        errorMessage.style.display = 'none';
        errorMessage.textContent = '';
        imageInput.style.border = '2px solid #ff0000';

        // Validasi apakah file telah dipilih
        if (!file) {
            showError('Silakan pilih file gambar.', imageInput, errorMessage);
            event.preventDefault();
            return;
        }

        // Validasi ukuran file (maksimal 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            showError('Ukuran file tidak boleh lebih dari 2MB.', imageInput, errorMessage);
            event.preventDefault();
            return;
        }

        // Validasi format file
        const allowedExtensions = ['image/jpeg', 'image/png'];
        if (!allowedExtensions.includes(file.type)) {
            showError('Format file tidak valid. Hanya .jpg, .jpeg, atau .png yang diperbolehkan.', imageInput, errorMessage);
            event.preventDefault();
            return;
        }
    });

    function showError(message, inputElement, errorElement) {
        // Menampilkan pesan error
        errorElement.textContent = message;
        errorElement.style.display = 'block';

        // Menambahkan border merah pada input
        inputElement.style.border = '2px solid red';

        // Menghilangkan error setelah 5 detik
        setTimeout(() => {
            errorElement.style.display = 'none';
            inputElement.style.border = '2px solid #ff0000';
        }, 5000);
    }
</script> -->

<!-- <script>
    // Menghilangkan alert otomatis setelah 10 detik
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        });
    }, 10000); // 10 detik dalam milidetik
</script> -->


<?= $this->endSection(); ?>