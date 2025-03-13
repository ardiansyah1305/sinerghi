<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <h3 class="fw-bold mb-4 text-uppercase">List Jabatan</h3>
    <div class="card shadow rounded-4 mb-4">
        <!-- Card Body -->
        <div class="card-body">
            
            <!-- Table Pegawai -->
            <div class="table-responsive">
                 <table id="example" class="table table-striped table-hover" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center border align-middle text-white bg-dark">No</th>
                    <th class="text-center border align-middle text-white bg-dark">Nama Jabatan</th>
                </tr>
            </thead>
            <tbody>  
            <?php foreach ($jabatan as $key => $jbt): ?>
                
                        <tr>
                            <td class="text-center border align-middle"><?= $key + 1; ?></td>
                            <td class="text-center border align-middle"><?= esc($jbt['nama_jabatan']); ?></td>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
        
                </table>
            <!-- End Table -->
            </div>

            </div>
    </div>
  </div>

            <hr>

            <div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <h3 class="fw-bold mb-4 text-uppercase">List Unit Kerja</h3>
    <div class="card shadow rounded-4 mb-4">
        <!-- Card Body -->
        <div class="card-body">
            
            <!-- Table Pegawai -->
            <div class="table-responsive">
                 <table id="example2" class="table table-striped table-hover" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center border align-middle text-white bg-dark">No</th>
                    <th class="text-center border align-middle text-white bg-dark">Nama Unit Kerja</th>
                </tr>
            </thead>
            <tbody>  
            <?php foreach ($unit_kerja as $key => $uk): ?>
                
                        <tr>
                            <td class="text-center border align-middle"><?= $key + 1; ?></td>
                            <td class="text-center border align-middle"><?= esc($uk['nama_unit_kerja']); ?></td>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
        
                </table>
            <!-- End Table -->
            </div>

            </div>
    </div>
  </div>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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