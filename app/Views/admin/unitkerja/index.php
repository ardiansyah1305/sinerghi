<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Unit Kerja</h2>
    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <a href="<?= base_url('admin/unitkerja/create')?>" class="btn btn-success-add"> Tambah <i class="bi bi-plus-circle"></i></a>
                    <!-- <button class="btn btn-success-add" data-bs-toggle="modal" data-bs-target="#addUnitkerjaModal">
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
                        <th class="text-center align-middle text-white bg-dark">Nama Unit Kerja</th>
                        <th class="text-center align-middle text-white bg-dark">Induk Unit Kerja</th>
                        <th class="text-center align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>

                    <?php foreach ($unitkerja as $unitkerja): ?>
                        <tr>
                            <td class="text-center align-middle"><?= $i++; ?></td>
                            <td class="text-center align-middle"><?= esc($unitkerja['nama_unit_kerja']); ?></td>
                            <td class="text-center align-middle">
                                <?= esc($unitkerja['parent_name']); ?>
                            </td>
                            <td class="text-center align-middle">
                            <div class="d-flex justify-content-center custom-action-buttons">
                                    <!-- Edit button directs to edit page -->
                                    <a href="<?= site_url('admin/unitkerja/edit/' . $unitkerja['id']); ?>" class="btn btn-warning btn-sm custom-edit-btn">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- Delete button with confirmation -->
                                    <button onclick="confirmDeleteUnitKerja(<?= $unitkerja['id']; ?>)" class="btn btn-danger btn-sm custom-delete-btn">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit unitkerja Modal -->
                        <!-- <div class="modal fade" id="editUnitkerjaModal<//?= $unitkerja['id']; ?>" tabindex="-1" aria-labelledby="editUnitkerjaModalLabel<?= $unitkerja['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title" id="editUnitkerjaModalLabel<//?= $unitkerja['id']; ?>">Edit Unit Kerja</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <//?= view('admin/unitkerja/edit', ['unitkerja' => $unitkerja]); ?>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- End Edit Unit Kerja Modal -->
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bagian Pencarian dan Tombol Add Pegawai -->

    <!-- Pagination -->
</div>



<!-- Add Unit Kerja Modal -->
<div class="modal fade" id="addUnitkerjaModal" role="dialog" aria-labelledby="addUnitkerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="addUnitkerjaModalLabel">Tambah Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<!--  -->


<!-- Bootstrap JS -->
<script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<!-- SweetAlert JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    // Inisialisasi Select2 pada elemen select
    $(document).ready(function() {
        // Inisialisasi select2 untuk semua elemen select yang memiliki kelas 'select2'
        $(".select2").select2({
            placeholder: "Pilih Induk Unit Kerja", // Menambahkan placeholder
            allowClear: true // Memungkinkan untuk menghapus pilihan
        });
    });
</script>
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

<script>
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
</script>

<script>
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
</script>

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