<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4"><?= $title; ?></h2>
    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <!-- <a href="<//?= base_url('admin/penugasan/create-usulan') ?>" class="btn btn-success-add"> Tambah <i class="bi bi-plus-circle"></i></a> ganti nama usulan nya saja-->
                    <a href="<?= base_url('admin/penugasan/create-usulan') ?>" class="btn btn-success-add"> Tambah <i class="bi bi-plus-circle"></i></a>
                    <!-- <button class="btn btn-success-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah
                        <i class="bi bi-plus-circle"></i>
                    </button> -->
                </div>
            </div>
            <!-- </div> -->

            <!-- Tabel Pegawai -->
            <table id="example" class="table table-bordered table-striped table-hover" style="max-width: 100%;">
                <thead class="">
                    <tr>
                        <th class="text-center align-middle text-white bg-dark" style="width: 80px;">No</th>
                        <th class="text-center align-middle text-white bg-dark">Operator</th>
                        <th class="text-center align-middle text-white bg-dark">Bulan Usulan</th>
                        <th class="text-center align-middle text-white bg-dark">Catatan</th>
                        <th class="text-center align-middle text-white bg-dark">Status Approval</th>
                        <?php if ($role == 1 || $role == 2 || $role == 3): ?>
                            <th class="text-center align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>

                    <?php foreach ($penugasan as $p): ?>
                        <tr>
                            <td class="text-center align-middle"><?= $i++; ?></td>
                            <td class="text-center align-middle"><?= esc($p['nama']); ?></td>
                            <td class="text-center align-middle"><?= esc($p['bulan']); ?></td>
                            <td class="text-center align-middle"><?= esc($p['catatan']); ?></td>
                            <td class="text-center align-middle"><?= esc($p['status_approval']); ?></td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center custom-action-buttons">
                                    <!-- Edit button directs to edit page -->
                                    <a href="<?= site_url('admin/penugasan/edit-jadwal/' . $p['id']); ?>" class="btn btn-warning btn-sm custom-edit-btn">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Delete button with confirmation -->
                                    <button onclick="confirmDeleteUnitKerja(<?= $p['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambah" action="<?= base_url('admin/penugasan/create-usulan')?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Pilihan Bulan -->
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Pilih Bulan</label>
                        <select class="form-select" id="bulan" name="bulan" required></select>
                        <div class="invalid-feedback">Silakan pilih bulan yang valid.</div>
                    </div>

                    <!-- Pilihan Tahun -->
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select class="form-select" id="tahun" name="tahun" required></select>
                        <div class="invalid-feedback">Silakan pilih tahun yang valid.</div>
                    </div>

                    <!-- Upload File (Opsional) -->
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File (PDF, max 2MB) (Opsional)</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf">
                        <div class="invalid-feedback" id="fileError"></div>
                    </div>

                    <!-- Peringatan Batas Tanggal -->
                    <div class="alert alert-danger d-none" id="tanggalError">
                        Pengajuan tidak dapat dilakukan setelah tanggal 25 setiap bulan!
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bulanSelect = document.getElementById("bulan");
        const tahunSelect = document.getElementById("tahun");
        const fileInput = document.getElementById("file");
        const formTambah = document.getElementById("formTambah");
        const submitButton = document.getElementById("submitButton");
        const tanggalError = document.getElementById("tanggalError");

        // Ambil tanggal hari ini
        const today = new Date();
        const currentDate = today.getDate();
        const currentMonth = today.getMonth() + 1; // Januari = 0, jadi ditambah 1
        const currentYear = today.getFullYear();

        // Cek apakah lewat tanggal 25
        if (currentDate > 25) {
            submitButton.disabled = true;
            tanggalError.classList.remove("d-none"); // Tampilkan pesan error
        }

        // Generate opsi bulan (bulan sekarang & bulan depan saja)
        const bulanOptions = [{
                value: currentMonth,
                text: new Intl.DateTimeFormat('id', {
                    month: 'long'
                }).format(new Date(currentYear, currentMonth - 1))
            },
            {
                value: currentMonth + 1,
                text: new Intl.DateTimeFormat('id', {
                    month: 'long'
                }).format(new Date(currentYear, currentMonth))
            }
        ];

        bulanOptions.forEach(option => {
            if (option.value <= 12) { // Hanya sampai Desember
                bulanSelect.innerHTML += `<option value="${option.value}">${option.text}</option>`;
            }
        });

        // Tahun hanya tahun sekarang
        tahunSelect.innerHTML = `<option value="${currentYear}">${currentYear}</option>`;

        // Validasi file upload (jika diisi)
        fileInput.addEventListener("change", function() {
            const file = fileInput.files[0];
            const fileError = document.getElementById("fileError");

            if (file) {
                const fileType = file.name.split('.').pop().toLowerCase();
                const fileSize = file.size / 1024 / 1024; // Convert ke MB

                if (fileType !== "pdf") {
                    fileInput.classList.add("is-invalid");
                    fileError.textContent = "Hanya file PDF yang diperbolehkan.";
                    fileInput.value = "";
                } else if (fileSize > 2) {
                    fileInput.classList.add("is-invalid");
                    fileError.textContent = "Ukuran file maksimal 2MB.";
                    fileInput.value = "";
                } else {
                    fileInput.classList.remove("is-invalid");
                    fileError.textContent = "";
                }
            } else {
                fileInput.classList.remove("is-invalid");
                fileError.textContent = "";
            }
        });

        // Validasi Form Submit
        formTambah.addEventListener("submit", function(event) {
            let valid = true;

            if (!bulanSelect.value) {
                bulanSelect.classList.add("is-invalid");
                valid = false;
            } else {
                bulanSelect.classList.remove("is-invalid");
            }

            if (!tahunSelect.value) {
                tahunSelect.classList.add("is-invalid");
                valid = false;
            } else {
                tahunSelect.classList.remove("is-invalid");
            }

            // Cek tanggal (tidak bisa submit setelah tanggal 25)
            if (currentDate > 25) {
                tanggalError.classList.remove("d-none"); // Tampilkan pesan error
                submitButton.disabled = true;
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    });
</script>

<!-- Bootstrap JS -->
<script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<!-- <script>
    // Inisialisasi Select2 pada elemen select
    $(document).ready(function() {
        // Inisialisasi select2 untuk semua elemen select yang memiliki kelas 'select2'
        $(".select2").select2({
            placeholder: "Pilih Induk Unit Kerja", // Menambahkan placeholder
            allowClear: true // Memungkinkan untuk menghapus pilihan
        });
    });
</script> -->
<script>
    function confirmDeleteUnitKerja(unitkerjaid) {
        Swal.fire({
            title: "Apa Anda yakin?",
            text: "Data tidak dapat dipulihkan!",
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
                    window.location.href = "<?= site_url('admin/unitkerja/delete/'); ?>" + unitkerjaid;
                });
            }
        });
    }
</script>

<?php if (session()->getFlashdata('success_unitkerja')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_unitkerja'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_unitkerja')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_unitkerja'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<!-- <script>
    document.getElementById("unitKerjaForm").addEventListener("submit", function(event) {
        let valid = true;

        // Fungsi untuk menampilkan dan menyembunyikan error
        function setError(element, errorId, isError) {
            const errorElement = document.getElementById(errorId);

            if (isError) {
                element.classList.add("is-invalid");
                errorElement.style.display = "inline";

                // Timer untuk menyembunyikan error setelah 5 detik
                setTimeout(() => {
                    element.classList.remove("is-invalid");
                    errorElement.style.display = "none";
                }, 5000); // 5000 ms = 5 detik
            } else {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }
        }

        let nama_unit_kerja = document.getElementById("nama_unit_kerja");
        let regex = /^[a-zA-Z0-9, ]+$/; // Hanya huruf, angka, tanda koma, dan spasi

        if (nama_unit_kerja.value.trim() === "") {
            setError(nama_unit_kerja, "nama_uk_error", true); // Tampilkan error "Kolom tidak boleh kosong"
            setError(nama_unit_kerja, "nama_uk_error_invalid", false);
            valid = false;
        } else if (!regex.test(nama_unit_kerja.value.trim())) {
            setError(nama_unit_kerja, "nama_uk_error", false);
            setError(nama_unit_kerja, "nama_uk_error_invalid", true); // Tampilkan error jika tidak sesuai aturan
            valid = false;
        } else {
            setError(nama_unit_kerja, "nama_uk_error", false);
            setError(nama_unit_kerja, "nama_uk_error_invalid", false);
        }


        let parent_id = document.getElementById("induk");
        if (parent_id.value.trim() === "") {
            setError(parent_id, "parent_id_error", true);
            valid = false;
        } else {
            setError(parent_id, "parent_id_error", false);
        }


        // Jika validasi gagal, cegah pengiriman form
        if (!valid) {
            event.preventDefault();
            return false;
        }
    });

    // Event listener untuk validasi real-time pada input
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function() {
            const errorId1 = this.id + "_error";

            // Validasi untuk setiap field input
            if (this.id === "nama_unit_kerja") {
                let regex = /^[a-zA-Z0-9, ]+$/;
                if (this.value.trim() === "") {
                    setError(this, "nama_uk_error", true);
                    setError(this, "nama_uk_error_invalid", false);
                } else if (!regex.test(this.value.trim())) {
                    setError(this, "nama_uk_error", false);
                    setError(this, "nama_uk_error_invalid", true);
                } else {
                    setError(this, "nama_uk_error", false);
                    setError(this, "nama_uk_error_invalid", false);
                }
            }

            if (this.id === "induk") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

        });
    });

    // Fungsi untuk menampilkan dan menghilangkan error
    function setError(element, errorId, isError) {
        const errorElement = document.getElementById(errorId);

        if (isError) {
            element.classList.add("is-invalid"); // Tambahkan kelas is-invalid
            errorElement.style.display = "block"; // Tampilkan pesan error

            // Timer untuk menyembunyikan error setelah 5 detik
            setTimeout(() => {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }, 5000); // 5000 ms = 5 detik
        } else {
            element.classList.remove("is-invalid"); // Hapus kelas is-invalid
            errorElement.style.display = "none"; // Sembunyikan pesan error
        }
    }
</script> -->

<!-- <script>
    document.getElementById("eunitKerjaForm").addEventListener("submit", function(event) {
        let valid = true;

        // Fungsi untuk menampilkan dan menyembunyikan error
        function setError(element, errorId, isError) {
            const errorElement = document.getElementById(errorId);

            if (isError) {
                element.classList.add("is-invalid");
                errorElement.style.display = "inline";

                // Timer untuk menyembunyikan error setelah 5 detik
                setTimeout(() => {
                    element.classList.remove("is-invalid");
                    errorElement.style.display = "none";
                }, 5000); // 5000 ms = 5 detik
            } else {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }
        }

        let nama_unit_kerja = document.getElementById("enama_unit_kerja");
        let regex = /^[a-zA-Z0-9, ]+$/; // Hanya huruf, angka, tanda koma, dan spasi

        if (nama_unit_kerja.value.trim() === "") {
            setError(nama_unit_kerja, "enama_uk_error", true); // Tampilkan error "Kolom tidak boleh kosong"
            setError(nama_unit_kerja, "enama_uk_error_invalid", false);
            valid = false;
        } else if (!regex.test(nama_unit_kerja.value.trim())) {
            setError(nama_unit_kerja, "enama_uk_error", false);
            setError(nama_unit_kerja, "enama_uk_error_invalid", true); // Tampilkan error jika tidak sesuai aturan
            valid = false;
        } else {
            setError(nama_unit_kerja, "enama_uk_error", false);
            setError(nama_unit_kerja, "enama_uk_error_invalid", false);
        }


        let parent_id = document.getElementById("einduk");
        if (parent_id.value.trim() === "") {
            setError(parent_id, "eparent_id_error", true);
            valid = false;
        } else {
            setError(parent_id, "eparent_id_error", false);
        }


        // Jika validasi gagal, cegah pengiriman form
        if (!valid) {
            event.preventDefault();
            return false;
        }
    });

    // Event listener untuk validasi real-time pada input
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function() {
            const errorId1 = this.id + "_error";

            // Validasi untuk setiap field input
            if (this.id === "nama_unit_kerja") {
                let regex = /^[a-zA-Z0-9, ]+$/;
                if (this.value.trim() === "") {
                    setError(this, "nama_uk_error", true);
                    setError(this, "nama_uk_error_invalid", false);
                } else if (!regex.test(this.value.trim())) {
                    setError(this, "nama_uk_error", false);
                    setError(this, "nama_uk_error_invalid", true);
                } else {
                    setError(this, "nama_uk_error", false);
                    setError(this, "nama_uk_error_invalid", false);
                }
            }

            if (this.id === "induk") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

        });
    });

    // Fungsi untuk menampilkan dan menghilangkan error
    function setError(element, errorId, isError) {
        const errorElement = document.getElementById(errorId);

        if (isError) {
            element.classList.add("is-invalid"); // Tambahkan kelas is-invalid
            errorElement.style.display = "block"; // Tampilkan pesan error

            // Timer untuk menyembunyikan error setelah 5 detik
            setTimeout(() => {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }, 5000); // 5000 ms = 5 detik
        } else {
            element.classList.remove("is-invalid"); // Hapus kelas is-invalid
            errorElement.style.display = "none"; // Sembunyikan pesan error
        }
    }
</script> -->

<style>
    .custom-action-buttons .btn {
        margin-right: 5px;
    }

    .custom-search-btn {
        margin-left: 5px;
    }

    .custom-add-unitkerja-btn {
        margin-left: 10px;
    }
</style>

<?= $this->endSection(); ?>