<?= $this->extend('pegawai/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-2 py-4 px-sm-5 py-sm-4">
    <h2 class="fw-semibold mb-4 fs-5 fs-md-2">Kelola Data Riwayat Pendidikan</h2>

    <!-- Card -->
    <div class="card shadow">
        <div class="card-header">
            <h4 class="fs-5 fs-md-4">Riwayat Pendidikan</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                <button class="btn btn-success-add px-1 py-1 px-md-2 py-md-2" data-bs-toggle="modal" data-bs-target="#addRiwayatPendidikanModal">
                    Tambah
                    <i class="bi bi-plus-circle"></i>
                </button>

                </div>
                <div class="d-flex align-items-center">
                    <a href="<?= base_url('pegawai/riwayat_pendidikan/downloadTemplateCsv') ?>" class="btn btn-secondary">
                        Template CSV
                        <i class="bi bi-download"></i>
                    </a>
                    <button class="btn btn-secondary ml-1" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                        Unggah Data
                        <i class="bi bi-filetype-xlsx"></i>
                    </button>
                </div>
            </div>

            <!-- Alert -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success my-3" role="alert"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger my-3" role="alert"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <!-- End Alert -->

            <!-- Table -->
            <table id="example" class="table table-bordered ms-auto table-responsive-lg" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Pegawai ID</th>
                        <th class="text-center">Jenjang</th>
                        <th class="text-center">Jurusan</th>
                        <th class="text-center">Universitas</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; foreach ($riwayat_pendidikan as $rp): ?>
                    <tr>
                        <td class="text-center"><?= $i++; ?></td>
                        <td class="text-center"><?= $rp['pegawai_id']; ?></td>
                        <td class="text-center"><?= $rp['jenjang']; ?></td>
                        <td class="text-center"><?= $rp['jurusan']; ?></td>
                        <td class="text-center"><?= $rp['universitas']; ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center custom-action-buttons">
                                <button class="btn btn-warning btn-sm custom-edit-btn" data-bs-toggle="modal" data-bs-target="#editRiwayatPendidikanModal<?= $rp['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $rp['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Edit Riwayat Pendidikan Modal -->
                    <div class="modal fade" id="editRiwayatPendidikanModal<?= $rp['id']; ?>" tabindex="-1" aria-labelledby="editRiwayatPendidikanModalLabel<?= $rp['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editRiwayatPendidikanModalLabel<?= $rp['id']; ?>">Edit Riwayat Pendidikan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= view('pegawai/riwayat_pendidikan/edit', ['riwayat_pendidikan' => $rp]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                            <!-- End Edit Riwayat Pendidikan Modal -->
                <?php endforeach; ?>
                </tbody>
            </table>
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

<!-- Add Riwayat Pendidikan Modal -->
<div class="modal fade" id="addRiwayatPendidikanModal" tabindex="-1" aria-labelledby="addRiwayatPendidikanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addRiwayatPendidikanModalLabel">Tambah Riwayat Pendidikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= view('pegawai/riwayat_pendidikan/create'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload CSV -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="uploadCsvModalLabel">Unggah Data Riwayat Pendidikan dari CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pegawai/riwayat_pendidikan/uploadCsv') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Pilih File CSV:</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv, .xlsx" required>
                    </div>
                    <small class="text-muted">Unggah dengan format .csv</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Unggah</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

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
                    window.location.href = "<?= site_url('pegawai/riwayat_pendidikan/delete/'); ?>" + RiwayatPendidikanId;
                } else {
                    swal("Data kamu aman!");
                }
            });
    }
</script>

<script>
    document.getElementById("riwayatPendidikanForm").addEventListener("submit", function (event) {
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

    // Validate text inputs for Jenjang, Jurusan, and Universitas
    function validateTextInput(value) {
        const regex = /^[a-zA-Z0-9,\s]+$/;
        return regex.test(value);
    }

    // Check Jenjang
    let jenjang = document.getElementById("jenjang");
    const jenjangRegex = /^[a-zA-Z0-9,\s]+$/; // Only letters, numbers, spaces, and commas
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

    // Check Jurusan
    let jurusan = document.getElementById("jurusan");
    const jurusanRegex = /^[a-zA-Z0-9,\s]+$/; // Only letters, numbers, spaces, and commas
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

    // Check Universitas
    let universitas = document.getElementById("universitas");
    const universitasRegex = /^[a-zA-Z0-9,\s]+$/; // Only letters, numbers, spaces, and commas
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

    // Check Tahun Masuk
    let tahun_masuk = document.getElementById("tahun_masuk");
    const tahunMasukRegex = /^\d{4}$/; // 4 digit number
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

    // Check Tahun Lulus
    let tahun_lulus = document.getElementById("tahun_lulus");
    const tahunLulusRegex = /^\d{4}$/; // 4 digit number
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
        alert("Tahun Lulus cannot be earlier than Tahun Masuk.");
        valid = false;
    } else {
        setError(tahun_lulus, "tahun_lulus_error", false);
        setError(tahun_lulus, "tahun_lulus_error_invalid", false);
    }

    // Prevent form submission if any field is invalid
    if (!valid) {
        event.preventDefault();
    }
});

// Real-time error handling while typing
document.querySelectorAll(".form-control").forEach((element) => {
    element.addEventListener("input", function () {
        const errorId1 = this.id + "_error";
        const errorId2 = this.id + "_error_invalid";
        const errorElement1 = document.getElementById(errorId1);
        const errorElement2 = document.getElementById(errorId2);

        // Validate Jenjang, Jurusan, and Universitas
        if (this.id === "jenjang" || this.id === "jurusan" || this.id === "universitas") {
            const regex = /^[a-zA-Z0-9,\s]+$/;
            if (regex.test(this.value)) {
                this.classList.remove("is-invalid");
                if (errorElement2) errorElement2.style.display = "none";
            } else {
                this.classList.add("is-invalid");
                if (errorElement2) errorElement2.style.display = "inline";
            }
        }

        // Validate Tahun Masuk and Tahun Lulus (4 digits)
        if (this.id === "tahun_masuk" || this.id === "tahun_lulus") {
            const regex = /^\d{4}$/;
            if (regex.test(this.value)) {
                this.classList.remove("is-invalid");
                if (errorElement1) errorElement1.style.display = "none";
            } else {
                this.classList.add("is-invalid");
                if (errorElement1) errorElement1.style.display = "inline";
            }
        }

        // Remove "Kolom tidak boleh kosong" errors if the user starts typing
        if (this.id === "tahun_masuk" || this.id === "tahun_lulus") {
            if (this.value.trim() !== "") {
                const errorElement1 = document.getElementById(this.id + "_error");
                if (errorElement1) errorElement1.style.display = "none";
            }
        }

        // Only show "Kolom tidak boleh kosong" if the field is empty
        if (this.value.trim() === "") {
            const errorElement1 = document.getElementById(this.id + "_error");
            if (errorElement1) {
                errorElement1.style.display = "inline"; // Show empty field error
            }
        }

        // Timer to remove error after input is cleared
        setTimeout(() => {
            if (this.value.trim() === "") {
                this.classList.remove("is-invalid");  // Remove is-invalid class when input is cleared
                if (errorElement1) errorElement1.style.display = "none";
                if (errorElement2) errorElement2.style.display = "none";
            }
        }, 5000); 
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

    .custom-add- RiwayatPendidikan-btn {
        margin-left: 10px;
    }
</style>

<?= $this->endSection(); ?>