<?= $this->extend('pegawai/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-3 py-4 px-sm-5 py-sm-4">
    <h3 class="fw-bold text-uppercase mb-4">Kelola Jabatan</h3>


    <!-- Card -->
    <div class="card shadow rounded-4 mb-4">
        <div class="card-body">

            <!-- Button Add & Import -->
            <div class="d-flex justify-content-between mb-3 mt-3">
                <div class="d-flex">
                    <button class="btn btn-success-add fs-6 fs-md-4" style="margin-left: 12px;" data-bs-toggle="modal" data-bs-target="#addJabatanModal">
                        Tambah
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>
            <!-- End Button Add & Import -->

            <!-- Table Jabatan -->
             <div class="table-responsive">
             <table id="example" class="table table-striped table-bordered table-hover ms-auto" style="max-width: 100%;">
                <thead>
                        <tr>
                            <th class="text-center border align-middle text-white bg-dark">No</th>
                            <th class="text-center border align-middle text-white bg-dark">Nama Jabatan</th>
                            <th class="text-center border align-middle text-white bg-dark">Eselon</th>
                            <th class="text-center border align-middle text-white bg-dark">Fungsional</th>
                            <th class="text-center border align-middle text-white bg-dark">Pelaksana</th>
			    <th class="text-center border align-middle text-white bg-dark">Pppk</th>
                            <th class="text-center border align-middle text-white bg-dark">Non ASN</th>  
                            <th class="text-center border align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($jabatan as $jabatan): ?>
                            <tr>
                                <td class="text-center align-middle"><?= $i++; ?></td>
                                <td class="text-center align-middle"><?= esc($jabatan['nama_jabatan']); ?></td>
                                <td class="text-center align-middle"><?= esc($jabatan['eselon']); ?></td>
                                <td class="text-center align-middle"><?= esc($jabatan['is_fungsional']); ?></td>
                                <td class="text-center align-middle"><?= esc($jabatan['is_pelaksana']); ?></td>                                
                                <td class="text-center align-middle"><?= esc($jabatan['is_pppk']); ?></td>
				<td class="text-center align-middle"><?= esc($jabatan['is_non_asn']); ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center custom-action-buttons">
                                        <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editJabatanModal<?= $jabatan['id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button onclick="confirmDeleteJabatan(<?= $jabatan['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>



                            <!-- Edit Jabatan Modal -->
                            <div class="modal fade" id="editJabatanModal<?= $jabatan['id']; ?>" tabindex="-1" aria-labelledby="editJabatanModalLabel<?= $jabatan['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title text-center w-100" id="editJabatanModalLabel<?= $jabatan['id']; ?>">Edit Jabatan</h5>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
					<?= view('pegawai/jabatan/edit', ['jabatan' => $jabatan]); ?>                                        
                                    </div>
                                </div>
                            </div>
                            <!-- End Edit Jabatan Modal -->
                            
                            <!-- Add Jabatan Modal -->
			    <div class="modal fade" id="addJabatanModal" tabindex="-1" aria-labelledby="addJabatanModalLabel" aria-hidden="true">
    				<div class="modal-dialog modal-dialog-scrollable modal-lg">
        			     <div class="modal-content">
            				  <div class="modal-header bg-success">
                				<h5 class="modal-title text-center text-white w-100" id="addJabatanModalLabel">Tambah Jabatan</h5>
                				<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            				  </div>
					  <?= view('pegawai/jabatan/create'); ?>            			     	  
        			     </div>
    			        </div>
                            </div>


                        <?php endforeach; ?>
                </tbody>
            </table>
             </div>                                   
            <!-- End Table -->

        </div>
    </div>
    <!-- End Card -->

</div>
    

    


<!-- Modal Upload Excel-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title fw-semibold" id="uploadModalLabel">Unggah Berkas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('pegawai/jabatan/uploadXlsx') ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <!-- Link untuk mengunduh template -->
                                <!-- <a href="<?= base_url('templates/Template_Jabatan.xlsx') ?>" class="text-primary-custom text-decoration-none">
                                    <i class="bi bi-download"></i> Download Template
                                </a> -->
                                <!-- Dropzone untuk unggahan file -->
                                <div id="dropZone" class="py-5 mt-2 text-center" style="border: 2px dashed; border-color: #ced4da;">
                                    <p class="mb-0 text-muted">Letakkan berkas disini <br>
                                        <small class="text-muted">atau</small>
                                    </p>
                                    <!-- Input file untuk unggahan XLSX -->
                                    <input type="file" id="fileInput" name="xlsx_file" class="d-none" accept=".xlsx">
                                    <button type="button" class="btn btn-outline-secondary px-3 py-0" style="border: 1px solid #5B878E;" onclick="document.getElementById('fileInput').click()">Pilih Berkas</button><br>
                                    <small class="text-muted">Berkas harus ekstensi: .xlsx</small>
                                </div>
                                <!-- Feedback untuk format file yang salah -->
                                <div id="feedback" class="invalid-feedback">Ekstensi yang diperbolehkan: .xlsx</div>
                            </div>
                            <div class="modal-footer" style="border-top: none;">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary-add">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<!--  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteJabatan(jabatanId) {
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
                    window.location.href = "<?= site_url('pegawai/jabatan/delete/'); ?>" + jabatanId;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_jabatan')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_jabatan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_jabatan')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_jabatan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<script>
    document.getElementById("jabatanForm").addEventListener("submit", function (event) {
    let valid = true;

    // Function to show error and remove it after a timer
    function setError(element, errorId, isError) {
        const errorElement = document.getElementById(errorId);

        if (isError) {
            element.classList.add("is-invalid");
            errorElement.style.display = "inline";

            // Timer to remove error and is-invalid class after 5 seconds
            setTimeout(() => {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }, 5000); // 5000 ms = 5 seconds
        } else {
            element.classList.remove("is-invalid");
            errorElement.style.display = "none";
        }
    }

    // Validate Nama Jabatan
    let nama_jabatan = document.getElementById("cnama_jabatan");
    const namaJabatanRegex = /^[a-zA-Z0-9\s]+$/; // Only letters, numbers, spaces, and commas
    if (nama_jabatan.value.trim() === "") {
        setError(nama_jabatan, "cnama_jabatan_error", true);
        setError(nama_jabatan, "cnama_jabatan_error_invalid", false);
        valid = false;
    } else if (!namaJabatanRegex.test(nama_jabatan.value.trim())) {
        setError(nama_jabatan, "cnama_jabatan_error", false);
        setError(nama_jabatan, "cnama_jabatan_error_invalid", true);
        valid = false;
    } else {
        setError(nama_jabatan, "cnama_jabatan_error", false);
        setError(nama_jabatan, "cnama_jabatan_error_invalid", false);
    }

    // Validate Eselon
    //let eselon = document.getElementById("eselon");
    //if (eselon.value.trim() === "") {
    //    setError(eselon, "eselon_error", true);
    //    valid = false;
    //} else {
    //    setError(eselon, "eselon_error", false);
    //}

    // Validate other inputs (is_fungsional, is_pelaksana, etc.)
    // Add additional validation logic as necessary...

    // If there are any validation errors, prevent form submission
    if (!valid) {
        event.preventDefault();
    }
});

document.querySelectorAll(".form-control").forEach((element) => {
    element.addEventListener("input", function () {
        const errorId1 = this.id + "_error";
        const errorId2 = this.id + "_error_invalid";
        const errorElement1 = document.getElementById(errorId1);
        const errorElement2 = document.getElementById(errorId2);

        // Validate Nama Jabatan and Eselon
        if (this.id === "cnama_jabatan") {
//if (this.id === "nama_jabatan" || this.id === "eselon") {

            const regex = /^[a-zA-Z0-9\s]+$/;
            if (this.value.trim() === "") {
                this.classList.add("is-invalid");
                if (errorElement1) errorElement1.style.display = "inline";
            } else if (!regex.test(this.value)) {
                this.classList.add("is-invalid");
                if (errorElement2) errorElement2.style.display = "inline";
            } else {
                this.classList.remove("is-invalid");
                if (errorElement1) errorElement1.style.display = "none";
                if (errorElement2) errorElement2.style.display = "none";
            }
        }

        // Timer to remove error after input is cleared
        setTimeout(() => {
            if (this.value.trim() === "") {
                this.classList.remove("is-invalid");  // Remove is-invalid class when input is cleared
                if (errorElement1) errorElement1.style.display = "none";
                if (errorElement2) errorElement2.style.display = "none";
            }
        }, 5000); // Timer duration set to 5 seconds
    });
});

</script>

<script>
    document.getElementById("editjabatanForm").addEventListener("submit", function (event) {
    let valid = true;

    // Function to show error and remove it after a timer
    function setError(element, errorId, isError) {
        const errorElement = document.getElementById(errorId);

        if (isError) {
            element.classList.add("is-invalid");
            errorElement.style.display = "inline";

            // Timer to remove error and is-invalid class after 5 seconds
            setTimeout(() => {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }, 5000); // 5000 ms = 5 seconds
        } else {
            element.classList.remove("is-invalid");
            errorElement.style.display = "none";
        }
    }

    // Validate Nama Jabatan
    let nama_jabatan = document.getElementById("enama_jabatan");
    const namaJabatanRegex = /^[a-zA-Z0-9\s]+$/; // Only letters, numbers, spaces, and commas
    if (nama_jabatan.value.trim() === "") {
        setError(nama_jabatan, "enama_jabatan_error", true);
        setError(nama_jabatan, "enama_jabatan_error_invalid", false);
        valid = false;
    } else if (!namaJabatanRegex.test(nama_jabatan.value.trim())) {
        setError(nama_jabatan, "enama_jabatan_error", false);
        setError(nama_jabatan, "enama_jabatan_error_invalid", true);
        valid = false;
    } else {
        setError(nama_jabatan, "enama_jabatan_error", false);
        setError(nama_jabatan, "enama_jabatan_error_invalid", false);
    }

    // Validate Eselon
    //let eselon = document.getElementById("eselon");
    //if (eselon.value.trim() === "") {
    //    setError(eselon, "eselon_error", true);
    //    valid = false;
    //} else {
    //    setError(eselon, "eselon_error", false);
    //}

    // Validate other inputs (is_fungsional, is_pelaksana, etc.)
    // Add additional validation logic as necessary...

    // If there are any validation errors, prevent form submission
    if (!valid) {
        event.preventDefault();
    }
});

document.querySelectorAll(".form-control").forEach((element) => {
    element.addEventListener("input", function () {
        const errorId1 = this.id + "_error";
        const errorId2 = this.id + "_error_invalid";
        const errorElement1 = document.getElementById(errorId1);
        const errorElement2 = document.getElementById(errorId2);

        // Validate Nama Jabatan and Eselon
        if (this.id === "enama_jabatan") {
//if (this.id === "nama_jabatan" || this.id === "eselon") {

            const regex = /^[a-zA-Z0-9\s]+$/;
            if (this.value.trim() === "") {
                this.classList.add("is-invalid");
                if (errorElement1) errorElement1.style.display = "inline";
            } else if (!regex.test(this.value)) {
                this.classList.add("is-invalid");
                if (errorElement2) errorElement2.style.display = "inline";
            } else {
                this.classList.remove("is-invalid");
                if (errorElement1) errorElement1.style.display = "none";
                if (errorElement2) errorElement2.style.display = "none";
            }
        }

        // Timer to remove error after input is cleared
        setTimeout(() => {
            if (this.value.trim() === "") {
                this.classList.remove("is-invalid");  // Remove is-invalid class when input is cleared
                if (errorElement1) errorElement1.style.display = "none";
                if (errorElement2) errorElement2.style.display = "none";
            }
        }, 5000); // Timer duration set to 5 seconds
    });
});

</script>


<style>
    .custom-action-buttons .btn {
        margin-right: 5px;
    }

    .custom-search-btn {
        margin-left: 5px;
    }

    .custom-add-jabatan-btn {
        margin-left: 10px;
    }
    .is-invalid { border-color: #dc3545 !important; }
</style>

<?= $this->endSection(); ?>