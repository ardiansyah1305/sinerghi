<?= $this->extend('pegawai/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <h2 class="fw-semibold mb-4">Kelola Data Kepegawaian</h2>
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4>Kepegawaian</h4>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPegawaiModal">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <span class="btn-text">Unggah Data</span>
                        <i class="bi bi-filetype-xlsx"></i>
                    </button>
                    <!-- <button class="btn btn-success custom-add-pegawai-btn ml-1" data-bs-toggle="modal" data-bs-target="#addFilterModal">
                        <span class="btn-text">Tambah</span>
                    Filter
                        <i class="bi bi-filter"></i>
                    </button> -->
                    
                </div>
            </div>

            <!-- Alert -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success my-3" role="alert"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger my-3" role="alert"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <!-- End Alert -->

            <!-- Table Pegawai -->
            <table id="example" class="table border table-responsive" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center border">No</th>
                    <th class="text-center border">NIP</th>
                    <th class="text-center border">Gelar Depan</th>
                    <th class="text-center border">Nama Pegawai</th>
                    <th class="text-center border">Gelar Belakang</th>
                    <th class="text-center border">Pangkat</th>
                    <th class="text-center border">Agama</th>
                    <th class="text-center border" style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>  
            
            <?php if (!empty($pegawai)): ?>
            <?php $i = 1; foreach ($pegawai as $pgw): ?>
                <tr>
                    <td class="text-center border"><?= $i++; ?></td>
                    <td class="text-center border"><?= esc($pgw['nip']); ?></td>
                    <td class="text-center border"><?= esc($pgw['gelar_depan']); ?></td>
                    <td class="text-center border"><?= esc($pgw['nama']); ?></td>
                    <td class="text-center border"><?= esc($pgw['gelar_belakang']); ?></td>
                    <td class="text-center border"><?= isset($pgw['pangkat_pegawai']) ? esc($pgw['pangkat_pegawai']) : 'Tidak ada pangkat'; ?></td>
                    <td class="text-center border"><?= isset($pgw['agama_nama']) ? esc($pgw['agama_nama']) : 'Tidak ada Agama'; ?></td>
                    <td class="text-center border">
                        <div class="d-flex justify-content-center gap-3 custom-action-buttons">
                            <button class="btn btn-warning btn-sm custom-edit-btn border" data-bs-toggle="modal" data-bs-target="#editPegawaiModal<?= $pgw['id']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button onclick="confirmDelete(<?= $pgw['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
            </tr>
            
                    <!-- Edit Pegawai Modal -->
                    <div class="modal fade" id="editPegawaiModal<?= $pgw['id']; ?>" tabindex="-1" aria-labelledby="editPegawaiModalLabel<?= $pgw['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-black border-bottom">
                                    <h5 class="modal-title" id="editPegawaiModalLabel<?= $pgw['id']; ?>">Edit Pegawai</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('pegawai/pegawai/edit', ['pegawai' => $pgw]); ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Pegawai Modal -->
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pegawai yang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- End Table -->

            <!-- Add User Modal -->
            <div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addPegawaiModalLabel">Tambah Pegawai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?= view('pegawai/pegawai/create'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Upload Excel-->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: none;">
                            <h5 class="modal-title fw-semibold" id="uploadModalLabel">Unggah Berkas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('pegawai/pegawai/uploadXlsx') ?>" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <!-- Link untuk mengunduh template -->
                                <a href="<?= base_url('templates/Template_Pegawai.xlsx') ?>" class="text-primary-custom text-decoration-none">
                                    <i class="bi bi-download"></i> Download Template
                                </a>
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

        </div>
        <!-- End Card Body -->

    </div>
    <!-- End Card -->
    
</div>


<script>
    document.getElementById("pegawaiiForm").addEventListener("submit", function (event) {
        let valid = true;

        // Fungsi untuk menampilkan dan menyembunyikan error
        function setError(element, errorId, isError) {
            const errorElement = document.getElementById(errorId);

            if (isError) {
                element.classList.add("is-invalid");
                errorElement.style.display = "inline";
            } else {
                element.classList.remove("is-invalid");
                errorElement.style.display = "none";
            }
        }

        // Validasi NIP
        let nip = document.getElementById("nip");
        if (nip.value.trim() === "") {
            setError(nip, "nip_error", true);
            setError(nip, "nip_error_invalid", false);
            valid = false;
        } else if (nip.value.trim().length < 10) {
            setError(nip, "nip_error", false);
            setError(nip, "nip_error_invalid", true);
            valid = false;
        } else {
            setError(nip, "nip_error", false);
            setError(nip, "nip_error_invalid", false);
        }

        let gelar_depan = document.getElementById("gelar_depan");
        if (gelar_depan.value.trim() === "") {
            setError(gelar_depan, "gelar_depan_error", true);
            valid = false;
        } else {
            setError(gelar_depan, "gelar_depan_error", false);
        }

        // Validasi Nama
        let nama = document.getElementById("nama");
        if (nama.value.trim() === "") {
            setError(nama, "nama_error", true);
            valid = false;
        } else {
            setError(nama, "nama_error", false);
        }

        // Tambahkan validasi untuk field lainnya di sini...

        // Cegah form submit jika validasi gagal
        if (!valid) {
            event.preventDefault();
            return false;
        }
    });

    // Event listener untuk validasi real-time
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function () {
            const errorId1 = this.id + "_error";
            const errorId2 = this.id + "_error_invalid";

            // Validasi NIP
            if (this.id === "nip") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                    setError(this, errorId2, false);
                } else if (this.value.trim().length < 10) {
                    setError(this, errorId1, false);
                    setError(this, errorId2, true);
                } else {
                    setError(this, errorId1, false);
                    setError(this, errorId2, false);
                }
            }

            // Validasi Nama
            if (this.id === "nama") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "gelar_depan") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }
        });
    });

    // Fungsi untuk menampilkan/menghilangkan error
    function setError(element, errorId, isError) {
        const errorElement = document.getElementById(errorId);

        if (isError) {
            element.classList.add("is-invalid");
            errorElement.style.display = "inline";
        } else {
            element.classList.remove("is-invalid");
            errorElement.style.display = "none";
        }
    }
</script>

    <style>
        .custom-search-btn,
        .custom-add-pegawai-btn {
            margin-left: 10px;
        }

        .custom-add-pegawai-btn {
            white-space: nowrap;
        }

        /* Optional: Jika butuh padding lebih untuk memperbaiki posisi */
        .d-flex.align-items-center {
            justify-content: flex-end;
        }

        @media (max-width: 576px) {
            .btn-text {
                display: none; /* Sembunyikan teks */
            }
            .btn {
                padding: 0.25rem 1.5rem; /* Ukuran padding lebih kecil */
                font-size: 1rem; /* Ukuran font lebih kecil */
            }
        }

        .is-invalid { border-color: #dc3545 !important; }

    </style>
    

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function confirmDelete(id) {
        swal({
                title: "Apa kamu yakin?",
                content: {
                    element: "p",
                    attributes: {
                        innerHTML: "<p>Setelah dihapus, Anda tidak akan dapat memulihkan pegawai!</p>",
                        style: "text-align: center; display: block;"
                    }
                },
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Batal",
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Hapus",
                        closeModal: false,
                    },
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('pegawai/pegawai/delete/'); ?>" + id;
                } else {
                    swal("Data kamu aman!");
                }
            });
    }
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

    .custom-add-pegawai-btn {
        margin-left: 10px;
    }
</style>

<?= $this->endSection(); ?>