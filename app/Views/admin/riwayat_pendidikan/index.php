<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-2 py-4 px-sm-5 py-sm-4">
    <h3 class="fw-bold text-uppercase mb-4">Kelola Riwayat Pendidikan</h3>
    <!-- Card -->
    <div class="card shadow rounded-4">
        <div class="card-body mb-2">
            <div class="d-flex justify-content-between mb-3 mt-2">
                <div class="d-flex">
                <button class="btn btn-success-add px-1 py-1 px-md-2 py-md-2" style="margin-left: 12px;" data-bs-toggle="modal" data-bs-target="#addRiwayatPendidikanModal">
                    Tambah
                    <i class="bi bi-plus-circle"></i>
                </button>

                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
		<table id="example" class="table table-bordered table-striped table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center align-middle bg-dark text-white">No</th>
                        <th class="text-center align-middle bg-dark text-white">Nama Pegawai</th>
                        <th class="text-center align-middle bg-dark text-white">Jenjang</th>
                        <th class="text-center align-middle bg-dark text-white">Jurusan</th>
                        <th class="text-center align-middle bg-dark text-white">Universitas</th>
                        <th class="text-center align-middle bg-dark text-white" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; foreach ($riwayat_pendidikan as $rp): ?>
                    <tr>
                        <td class="text-center align-middle"><?= $i++; ?></td>
                        <td class="text-center align-middle"><?= isset($rp['nama_pegawai']) ? $rp['nama_pegawai'] : 'Tidak Diketahui'; ?></td>
                        <td class="text-center align-middle"><?= $rp['jenjang']; ?></td>
                        <td class="text-center align-middle"><?= $rp['jurusan']; ?></td>
                        <td class="text-center align-middle"><?= $rp['universitas']; ?></td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-center custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editRiwayatPendidikanModal<?= $rp['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDeleteRp(<?= $rp['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Riwayat Pendidikan Modal -->
                    <div class="modal fade" id="editRiwayatPendidikanModal<?= $rp['id']; ?>" tabindex="-1" aria-labelledby="editRiwayatPendidikanModalLabel<?= $rp['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-center w-100" id="editRiwayatPendidikanModalLabel<?= $rp['id']; ?>">Edit Riwayat Pendidikan</h5>
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <?= view('admin/riwayat_pendidikan/edit', ['riwayat_pendidikan' => $rp]); ?>
                            </div>
                        </div>
                    </div>
                   <!-- End Edit Riwayat Pendidikan Modal -->

			<!-- Add Riwayat Pendidikan Modal -->
		<div class="modal fade" id="addRiwayatPendidikanModal" tabindex="-1" aria-labelledby="addRiwayatPendidikanModalLabel" aria-hidden="true">
    			<div class="modal-dialog modal-dialog-scrollable modal-lg">
        			<div class="modal-content">
            				<div class="modal-header bg-success text-white">
                				<h5 class="modal-title text-center w-100" id="addRiwayatPendidikanModalLabel">Tambah Riwayat Pendidikan</h5>
                				<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            				</div>
					<?= view('admin/riwayat_pendidikan/create'); ?>      
        			</div>
    			</div>
		</div>

                <?php endforeach; ?>
                </tbody>
            </table>
	    <!-- End Table -->
            </div>
            


        </div>
    </div>
    <!-- End Card -->
    

    <style>
        .custom-search-btn,
        .custom-add- RiwayatPendidikan-btn {
            margin-left: 10px;
        }

        .custom-add- RiwayatPendidikan-btn {
            white-space: nowrap;
        }

        /* Optional: Jika butuh padding lebih untuk memperbaiki posisi */
        .d-flex.align-items-center {
            justify-content: flex-end;
        }
    </style>

</div>


<!-- Modal Upload Excel-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title fw-semibold" id="uploadModalLabel">Unggah Berkas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/riwayat_pendidikan/uploadXlsx') ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <!-- Link untuk mengunduh template -->
                                <!-- <a href="<?= base_url('templates/Template_Riwayat_Pendidikan.xlsx') ?>" class="text-primary-custom text-decoration-none">
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteRp(rpId) {
        Swal.fire({
            title: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            cancelButtonText: "Batal",
	    confirmButtonText: "Hapus"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    // width: "400px",
                    // background: "#ccffcc",
                    // toast: true,
                    // position: 'top-end',
                    title: "Berhasil Terhapus!",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    window.location.href = "<?= site_url('admin/riwayat_pendidikan/delete/'); ?>" + rpId;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_rp')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_rp'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_rp')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_rp'); ?>",
            showConfirmButton: false,
            timer: 5000, 
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<script>
    function confirmDelete(RiwayatPendidikanId) {
        swal({
                title: "Apa kamu yakin?",
                text: "Setelah dihapus, Anda tidak akan dapat memulihkan Riwayat Pendidikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('admin/riwayat_pendidikan/delete/'); ?>" + RiwayatPendidikanId;
                } else {
                    swal("Data kamu aman!");
                }
            });
    }
</script>

<script>
    document.getElementById("riwayatPendidikanForm").addEventListener("submit", function (event) {
        let valid = true;

        // Fungsi untuk menampilkan error dan menghapusnya setelah timer
        function setError(element, errorId, isError) {
            const errorElement = document.getElementById(errorId);

            if (isError) {
                element.classList.add("is-invalid");
                errorElement.style.display = "inline";

                // Timer untuk menghapus error setelah 5 detik
                setTimeout(() => {
                    element.classList.remove("is-invalid");
                    errorElement.style.display = "none";
                }, 5000); // 5000 ms = 5 detik
            } else {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }
        }

        // Validasi dropdown Pegawai
        let pegawaiDropdown = document.getElementById("pegawai_id");
        if (!pegawaiDropdown.value) {
            setError(pegawaiDropdown, "pegawai_id_error", true);
            valid = false;
        } else {
            setError(pegawaiDropdown, "pegawai_id_error", false);
        }

        // Validasi input Jenjang
        let jenjang = document.getElementById("jenjang");
        const jenjangRegex = /^[a-zA-Z0-9,\s]+$/;
        if (jenjang.value.trim() === "") {
            setError(jenjang, "cjenjang_error", true);
            setError(jenjang, "cjenjang_error_invalid", false);
            valid = false;
        } else if (!jenjangRegex.test(jenjang.value.trim())) {
            setError(jenjang, "cjenjang_error", false);
            setError(jenjang, "cjenjang_error_invalid", true);
            valid = false;
        } else {
            setError(jenjang, "cjenjang_error", false);
            setError(jenjang, "cjenjang_error_invalid", false);
        }

        // Validasi input Jurusan
        let jurusan = document.getElementById("jurusan");
        const jurusanRegex = /^[a-zA-Z0-9,\s]+$/;
        if (jurusan.value.trim() === "") {
            setError(jurusan, "cjurusan_error", true);
            setError(jurusan, "cjurusan_error_invalid", false);
            valid = false;
        } else if (!jurusanRegex.test(jurusan.value.trim())) {
            setError(jurusan, "cjurusan_error", false);
            setError(jurusan, "cjurusan_error_invalid", true);
            valid = false;
        } else {
            setError(jurusan, "cjurusan_error", false);
            setError(jurusan, "cjurusan_error_invalid", false);
        }

        // Validasi input Universitas
        let universitas = document.getElementById("universitas");
        const universitasRegex = /^[a-zA-Z0-9,\s]+$/;
        if (universitas.value.trim() === "") {
            setError(universitas, "cuniversitas_error", true);
            setError(universitas, "cuniversitas_error_invalid", false);
            valid = false;
        } else if (!universitasRegex.test(universitas.value.trim())) {
            setError(universitas, "cuniversitas_error", false);
            setError(universitas, "cuniversitas_error_invalid", true);
            valid = false;
        } else {
            setError(universitas, "cuniversitas_error", false);
            setError(universitas, "cuniversitas_error_invalid", false);
        }

        // Validasi Tahun Masuk
        let tahun_masuk = document.getElementById("ctahun_masuk");
        const tahunMasukRegex = /^\d{4}$/;
        if (tahun_masuk.value.trim() === "") {
            setError(tahun_masuk, "ctahun_masuk_error", true);
            setError(tahun_masuk, "ctahun_masuk_error_invalid", false);
            valid = false;
        } else if (!tahunMasukRegex.test(tahun_masuk.value.trim())) {
            setError(tahun_masuk, "ctahun_masuk_error", false);
            setError(tahun_masuk, "ctahun_masuk_error_invalid", true);
            valid = false;
        } else {
            setError(tahun_masuk, "ctahun_masuk_error", false);
            setError(tahun_masuk, "ctahun_masuk_error_invalid", false);
        }

        // Validasi Tahun Lulus
        let tahun_lulus = document.getElementById("tahun_lulus");
        const tahunLulusRegex = /^\d{4}$/;
        if (tahun_lulus.value.trim() === "") {
            setError(tahun_lulus, "ctahun_lulus_error", true);
            setError(tahun_lulus, "ctahun_lulus_error_invalid", false);
            valid = false;
        } else if (!tahunLulusRegex.test(tahun_lulus.value.trim())) {
            setError(tahun_lulus, "ctahun_lulus_error", false);
            setError(tahun_lulus, "ctahun_lulus_error_invalid", true);
            valid = false;
        } else if (parseInt(tahun_lulus.value) < parseInt(tahun_masuk.value)) {
            setError(tahun_lulus, "ctahun_lulus_error", true);
            alert("Tahun Lulus tidak boleh lebih kecil dari Tahun Masuk.");
            valid = false;
        } else {
            setError(tahun_lulus, "ctahun_lulus_error", false);
            setError(tahun_lulus, "ctahun_lulus_error_invalid", false);
        }

        // Cegah submit jika tidak valid
        if (!valid) {
            event.preventDefault();
        }
    });

    // Real-time validasi untuk semua input
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function () {
            const errorId1 = this.id + "_error";
            const errorId2 = this.id + "_error_invalid";

            // Validasi text input seperti Jenjang, Jurusan, Universitas
            if (this.id === "cjenjang" || this.id === "cjurusan" || this.id === "cuniversitas") {
                const regex = /^[a-zA-Z0-9,\s]+$/;
                if (regex.test(this.value)) {
                    this.classList.remove("is-invalid");
                    document.getElementById(errorId2).style.display = "none";
                } else {
                    this.classList.add("is-invalid");
                    document.getElementById(errorId2).style.display = "inline";
                }
            }

            // Validasi angka seperti Tahun Masuk dan Tahun Lulus
            if (this.id === "ctahun_masuk" || this.id === "ctahun_lulus") {
                const regex = /^\d{4}$/;
                if (regex.test(this.value)) {
                    this.classList.remove("is-invalid");
                    document.getElementById(errorId1).style.display = "none";
                } else {
                    this.classList.add("is-invalid");
                    document.getElementById(errorId1).style.display = "inline";
                }
            }

            // Hapus error jika kolom mulai diisi
            if (this.value.trim() !== "") {
                document.getElementById(errorId1).style.display = "none";
                document.getElementById(errorId2).style.display = "none";
            }
        });
    });

    // Validasi real-time untuk dropdown Pegawai
    document.getElementById("pegawai_id").addEventListener("change", function () {
        if (this.value) {
            this.classList.remove("is-invalid");
            document.getElementById("pegawai_id_error").style.display = "none";
        }
    });
</script>

<script>
    document.getElementById("editriwayatPendidikanForm").addEventListener("submit", function (event) {
        let valid = true;

        // Fungsi untuk menampilkan error dan menghapusnya setelah timer
        function setError(element, errorId, isError) {
            const errorElement = document.getElementById(errorId);

            if (isError) {
                element.classList.add("is-invalid");
                errorElement.style.display = "inline";

                // Timer untuk menghapus error setelah 5 detik
                setTimeout(() => {
                    element.classList.remove("is-invalid");
                    errorElement.style.display = "none";
                }, 5000); // 5000 ms = 5 detik
            } else {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }
        }

        // Validasi dropdown Pegawai
        let pegawaiDropdown = document.getElementById("epegawai_id");
        if (!pegawaiDropdown.value) {
            setError(pegawaiDropdown, "pegawai_id_error", true);
            valid = false;
        } else {
            setError(pegawaiDropdown, "pegawai_id_error", false);
        }

        // Validasi input Jenjang
        let jenjang = document.getElementById("ejenjang");
        const jenjangRegex = /^[a-zA-Z0-9,\s]+$/;
        if (jenjang.value.trim() === "") {
            setError(jenjang, "jenjang_error", true);
            setError(jenjang, "jenjang_error_invalid", false);
            valid = false;
        } else if (!jenjangRegex.test(jenjang.value.trim())) {
            setError(jenjang, "jenjang_error", false);
            setError(jenjang, "jenjang_error_invalid", true);
            valid = false;
        } else {
            setError(jenjang, "jenjang_error", false);
            setError(jenjang, "jenjang_error_invalid", false);
        }

        // Validasi input Jurusan
        let jurusan = document.getElementById("ejurusan");
        const jurusanRegex = /^[a-zA-Z0-9,\s]+$/;
        if (jurusan.value.trim() === "") {
            setError(jurusan, "jurusan_error", true);
            setError(jurusan, "jurusan_error_invalid", false);
            valid = false;
        } else if (!jurusanRegex.test(jurusan.value.trim())) {
            setError(jurusan, "jurusan_error", false);
            setError(jurusan, "jurusan_error_invalid", true);
            valid = false;
        } else {
            setError(jurusan, "jurusan_error", false);
            setError(jurusan, "jurusan_error_invalid", false);
        }

        // Validasi input Universitas
        let universitas = document.getElementById("euniversitas");
        const universitasRegex = /^[a-zA-Z0-9,\s]+$/;
        if (universitas.value.trim() === "") {
            setError(universitas, "universitas_error", true);
            setError(universitas, "universitas_error_invalid", false);
            valid = false;
        } else if (!universitasRegex.test(universitas.value.trim())) {
            setError(universitas, "universitas_error", false);
            setError(universitas, "universitas_error_invalid", true);
            valid = false;
        } else {
            setError(universitas, "universitas_error", false);
            setError(universitas, "universitas_error_invalid", false);
        }

        // Validasi Tahun Masuk
        let tahun_masuk = document.getElementById("etahun_masuk");
        const tahunMasukRegex = /^\d{4}$/;
        if (tahun_masuk.value.trim() === "") {
            setError(tahun_masuk, "tahun_masuk_error", true);
            setError(tahun_masuk, "tahun_masuk_error_invalid", false);
            valid = false;
        } else if (!tahunMasukRegex.test(tahun_masuk.value.trim())) {
            setError(tahun_masuk, "tahun_masuk_error", false);
            setError(tahun_masuk, "tahun_masuk_error_invalid", true);
            valid = false;
        } else {
            setError(tahun_masuk, "tahun_masuk_error", false);
            setError(tahun_masuk, "tahun_masuk_error_invalid", false);
        }

        // Validasi Tahun Lulus
        let tahun_lulus = document.getElementById("etahun_lulus");
        const tahunLulusRegex = /^\d{4}$/;
        if (tahun_lulus.value.trim() === "") {
            setError(tahun_lulus, "tahun_lulus_error", true);
            setError(tahun_lulus, "tahun_lulus_error_invalid", false);
            valid = false;
        } else if (!tahunLulusRegex.test(tahun_lulus.value.trim())) {
            setError(tahun_lulus, "tahun_lulus_error", false);
            setError(tahun_lulus, "tahun_lulus_error_invalid", true);
            valid = false;
        } else if (parseInt(tahun_lulus.value) < parseInt(tahun_masuk.value)) {
            setError(tahun_lulus, "tahun_lulus_error", true);
            alert("Tahun Lulus tidak boleh lebih kecil dari Tahun Masuk.");
            valid = false;
        } else {
            setError(tahun_lulus, "tahun_lulus_error", false);
            setError(tahun_lulus, "tahun_lulus_error_invalid", false);
        }

        // Cegah submit jika tidak valid
        if (!valid) {
            event.preventDefault();
        }
    });

    // Real-time validasi untuk semua input
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function () {
            const errorId1 = this.id + "_error";
            const errorId2 = this.id + "_error_invalid";

            // Validasi text input seperti Jenjang, Jurusan, Universitas
            if (this.id === "ejenjang" || this.id === "ejurusan" || this.id === "euniversitas") {
                const regex = /^[a-zA-Z0-9,\s]+$/;
                if (regex.test(this.value)) {
                    this.classList.remove("is-invalid");
                    document.getElementById(errorId2).style.display = "none";
                } else {
                    this.classList.add("is-invalid");
                    document.getElementById(errorId2).style.display = "inline";
                }
            }

            // Validasi angka seperti Tahun Masuk dan Tahun Lulus
            if (this.id === "etahun_masuk" || this.id === "etahun_lulus") {
                const regex = /^\d{4}$/;
                if (regex.test(this.value)) {
                    this.classList.remove("is-invalid");
                    document.getElementById(errorId1).style.display = "none";
                } else {
                    this.classList.add("is-invalid");
                    document.getElementById(errorId1).style.display = "inline";
                }
            }

            // Hapus error jika kolom mulai diisi
            if (this.value.trim() !== "") {
                document.getElementById(errorId1).style.display = "none";
                document.getElementById(errorId2).style.display = "none";
            }
        });
    });

    // Validasi real-time untuk dropdown Pegawai
    document.getElementById("pegawai_id").addEventListener("change", function () {
        if (this.value) {
            this.classList.remove("is-invalid");
            document.getElementById("pegawai_id_error").style.display = "none";
        }
    });
</script>

<!-- validasi unggah file excel -->
<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const feedback = document.getElementById('feedback');
    let selectedFile;

    // Fungsi untuk menambahkan event drag & drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-primary');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary');
        selectedFile = e.dataTransfer.files[0];
        validateFile(selectedFile);
    });

    // Fungsi untuk menangani ketika file dipilih melalui tombol
    fileInput.addEventListener('change', () => {
        selectedFile = fileInput.files[0];
        validateFile(selectedFile);
    });

    // Fungsi untuk validasi file
    function validateFile(file) {
        if (file && file.name.endsWith('.xlsx')) {
            dropZone.classList.remove('is-invalid');
            feedback.style.display = 'none';
            dropZone.querySelector('p').textContent = 'Berkas: ' + file.name;
        } else {
            dropZone.classList.add('is-invalid');
            feedback.style.display = 'block';
            feedback.textContent = 'Ekstensi yang diperbolehkan: .xlsx';
            fileInput.value = '';
            selectedFile = null;
            dropZone.querySelector('p').textContent = 'Letakkan berkas disini atau pilih berkas';
        }
    }

    // Fungsi Simpan
    function submitFile() {
        if (selectedFile) {
            // Proses penyimpanan file dapat ditambahkan di sini
            alert(`File "${selectedFile.name}" akan disimpan.`);
        } else {
            dropZone.classList.add('is-invalid');
            feedback.style.display = 'block';
        }
    }
</script>


<style>
    .custom-action-buttons .btn {
        margin-right: 5px;
    }

    .custom-search-btn {
        margin-left: 5px;
    }

    .custom-add- RiwayatPendidikan-btn {
        margin-left: 10px;
    }
.is-invalid { border-color: #dc3545 !important; }
</style>

<?= $this->endSection(); ?>