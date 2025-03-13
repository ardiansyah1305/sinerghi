<?= $this->extend('pegawai/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <h3 class="fw-bold mb-4 text-uppercase">Kelola Pegawai</h3>
    <div class="card shadow rounded-4 mb-4">
        <!-- Card Body -->
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 mt-3">
                <div class="d-flex">
                    <button class="btn btn-success" style="margin-left: 12px;" data-bs-toggle="modal" data-bs-target="#addPegawaiModal">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown-center">
                        <button class="btn btn-primary dropdown-toggle" style="margin-right: 12px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Unggah Data
                            <i class="bi bi-filetype-xlsx"></i>
                        </button>

                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item text-primary" href="<?= base_url('templates/template_pegawai.xlsx') ?>"><i class="bi bi-download"></i> Download Template</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-primary" href="UnggahData" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-upload"></i> Unggah</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <!-- Table Pegawai -->
            <div class="table-responsive">
                 <table id="example" class="table table-striped table-hover" style="width: 100%;">
            <thead>
                <tr>
                    <th class="text-center border align-middle text-white bg-dark">No</th>
                    <th class="text-center border align-middle text-white bg-dark">NIP</th>
                    <th class="text-center border align-middle text-white bg-dark">Nama Pegawai</th>
		    <th class="text-center border align-middle text-white bg-dark">Status</th>
                    <th class="text-center border align-middle text-white bg-dark" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>  
            
            <?php if (!empty($pegawai)): ?>
            <?php $i = 1; foreach ($pegawai as $pgw): ?>
                <tr>
                    <td class="text-center border align-middle"><?= $i++; ?></td>
                    <td class="text-center border align-middle"><?= esc($pgw['nip']); ?></td>
                    <td class="text-center border align-middle"><?= esc($pgw['nama']); ?></td>
                   <td class="text-center border align-middle"><?= esc($pgw['nama_status']); ?></td> 
		   <td class="text-center border align-middle">
                        <div class="d-flex justify-content-center custom-action-buttons">
                            <button class="btn btn-warning btn-sm custom-edit-btn border" data-bs-toggle="modal" data-bs-target="#editPegawaiModal<?= $pgw['id']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button onclick="confirmDeletePegawai(<?= $pgw['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
            </tr>
            
                    <!-- Edit Pegawai Modal -->
                    <div class="modal fade" id="editPegawaiModal<?= $pgw['id']; ?>" tabindex="-1" aria-labelledby="editPegawaiModalLabel<?= $pgw['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-center w-100" id="editPegawaiModalLabel<?= $pgw['id']; ?>">Edit Pegawai</h5>
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <?= view('pegawai/pegawai/edit', ['pegawai' => $pgw]); ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Pegawai Modal -->

                    <!-- Add User Modal -->
                    <div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                 <div class="modal-header bg-success">
                                      <h5 class="modal-title text-center text-white w-100" id="addPegawaiModalLabel">Tambah Pegawai</h5>
                                      <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                 </div>
                                 
                                 <?= view('pegawai/pegawai/create'); ?>
                                 
                            </div>
                       </div>
                    </div>

                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pegawai yang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- End Table -->
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
                                <a href="<?= base_url('templates/template_pegawai.xlsx') ?>" class="text-primary-custom text-decoration-none">
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
document.getElementById("foto").addEventListener("change", function () {
    const allowedExtensions = ["jpg", "jpeg", "png"];
    const fileInput = this;
    const fileName = fileInput.value.split("\\").pop();
    const fileExtension = fileName.split(".").pop().toLowerCase();
    const errorElement = document.createElement("div");
    errorElement.className = "invalid-feedback";
    errorElement.id = "foto_error";
    errorElement.textContent = "Hanya format file jpg, jpeg, dan png yang diizinkan.";

    // Hapus error jika sudah ada sebelumnya
    const existingError = document.getElementById("foto_error");
    if (existingError) {
        existingError.remove();
        fileInput.classList.remove("is-invalid");
    }

    // Validasi ekstensi file
    if (!allowedExtensions.includes(fileExtension)) {
        fileInput.classList.add("is-invalid");
        fileInput.parentNode.appendChild(errorElement);
        fileInput.value = ""; // Reset nilai input
    }
});

</script>


<script>
     document.getElementById("pegawaiiForm").addEventListener("submit", function (event) {
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

        // Validasi NIP
        let nip = document.getElementById("cnip");
        if (nip.value.trim() === "") {
            setError(nip, "cnip_error", true); // Tampilkan error "Kolom NIP tidak boleh kosong"
        setError(nip, "cnip_error_invalid", false); // Sembunyikan error "NIP harus minimal 10 karakter"
        valid = false;
        } else if (nip.value.trim().length < 10) {
        setError(nip, "cnip_error", false); // Sembunyikan error "Kolom NIP tidak boleh kosong"
        setError(nip, "cnip_error_invalid", true); // Tampilkan error "NIP harus minimal 10 karakter"
        valid = false;
        } else {
            setError(nip, "cnip_error", false); // Sembunyikan semua error
            setError(nip, "cnip_error_invalid", false);
        }

        // Validasi Nama
        let nama = document.getElementById("nama");
        if (nama.value.trim() === "") {
            setError(nama, "nama_error", true);
            valid = false;
        } else {
            setError(nama, "nama_error", false);
        }

        // Validasi Tempat Lahir
        let tempatLahir = document.getElementById("tempat_lahir");
        if (tempatLahir.value.trim() === "") {
            setError(tempatLahir, "tempat_lahir_error", true);
            valid = false;
        } else {
            setError(tempatLahir, "tempat_lahir_error", false);
        }

        // Validasi Tanggal Lahir
        let tanggalLahir = document.getElementById("tanggal_lahir");
        if (tanggalLahir.value.trim() === "") {
            setError(tanggalLahir, "tanggal_lahir_error", true);
            valid = false;
        } else {
            setError(tanggalLahir, "tanggal_lahir_error", false);
        }

        // Validate Pangkat (only if not empty)
        let pangkat = document.getElementById("pang");
        if (pangkat.value.trim() === "") {
    setError(pangkat, "pang_error", true);
    valid = false;
} else {
    setError(pangkat, "pang_error", false);
}
             // Validate Pangkat (only if not empty)
        let golongan_ruang = document.getElementById("gol_ruang");
    if (golongan_ruang.value.trim() === "") {
        setError(golongan_ruang, "gol_error", true);
        valid = false;
    } else {
        setError(golongan_ruang, "gol_error", false);
    }

    let jabatan_id = document.getElementById("jabatan_id");
    if (jabatan_id.value.trim() === "") {
        setError(jabatan_id, "jabatan_id_error", true);
        valid = false;
    } else {
        setError(jabatan_id, "jabatan_id_error", false);
    }
    
    let unit_kerja_id = document.getElementById("uk");
    if (unit_kerja_id.value.trim() === "") {
        setError(unit_kerja_id, "uk_error", true);
        valid = false;
    } else {
        setError(unit_kerja_id, "uk_error", false);
    }

    let kelas_jabatan = document.getElementById("kj");
    if (kelas_jabatan.value.trim() === "") {
        setError(kelas_jabatan, "kj_error", true);
        valid = false;
    } else {
        setError(kelas_jabatan, "kj_error", false);
    }

    let jenis_kelamin = document.getElementById("jk");
    if (jenis_kelamin.value.trim() === "") {
        setError(jenis_kelamin, "jenis_kelamin_error", true);
        valid = false;
    } else {
        setError(jenis_kelamin, "jenis_kelamin_error", false);
    }

    let status_pegawai = document.getElementById("status_peg");
    if (status_pegawai.value.trim() === "") {
        setError(status_pegawai, "status_pegawai_error", true);
        valid = false;
    } else {
        setError(status_pegawai, "status_pegawai_error", false);
    }

    let status_pernikahan = document.getElementById("status_perni");
    if (status_pernikahan.value.trim() === "") {
        setError(status_pernikahan, "status_pernikahan_error", true);
        valid = false;
    } else {
        setError(status_pernikahan, "status_pernikahan_error", false);
    }

    let agama = document.getElementById("agamaa");
    if (agama.value.trim() === "") {
        setError(agama, "agama_error", true);
        valid = false;
    } else {
        setError(agama, "agama_error", false);
    }

    
        // Jika validasi gagal, cegah pengiriman form
        if (!valid) {
            event.preventDefault();
            return false;
        }
    });

    // Event listener untuk validasi real-time pada input
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function () {
            const errorId1 = this.id + "_error";

            // Validasi untuk setiap field input
            if (this.id === "cnip") {
    if (this.value.trim() === "") {
        setError(this, "cnip_error", true); // Tampilkan error "Kolom NIP tidak boleh kosong"
        setError(this, "cnip_error_invalid", false); // Sembunyikan error minimal karakter
    } else if (this.value.trim().length < 10) {
        setError(this, "cnip_error", false); // Sembunyikan error "Kolom NIP tidak boleh kosong"
        setError(this, "cnip_error_invalid", true); // Tampilkan error minimal karakter
    } else {
        setError(this, "cnip_error", false); // Sembunyikan semua error
        setError(this, "cnip_error_invalid", false);
    }
}


            if (this.id === "nama") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "tempat_lahir") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "tanggal_lahir") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "pang") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "gol_ruang") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "jabatan_id") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "unit_kerja_id") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "unit_kerja_id") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "jk") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "status_peg") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "status_perni") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        
        if (this.id === "agamaa") {
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
     document.getElementById("editpegawaiiForm").addEventListener("submit", function (event) {
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

        // Validasi NIP
        let nip = document.getElementById("enip");
        if (nip.value.trim() === "") {
            setError(nip, "nip_error", true); // Tampilkan error "Kolom NIP tidak boleh kosong"
        setError(nip, "nip_error_invalid", false); // Sembunyikan error "NIP harus minimal 10 karakter"
        valid = false;
        } else if (nip.value.trim().length < 10) {
        setError(nip, "nip_error", false); // Sembunyikan error "Kolom NIP tidak boleh kosong"
        setError(nip, "nip_error_invalid", true); // Tampilkan error "NIP harus minimal 10 karakter"
        valid = false;
        } else {
            setError(nip, "nip_error", false); // Sembunyikan semua error
            setError(nip, "nip_error_invalid", false);
        }

        // Validasi Nama
        let nama = document.getElementById("enama");
        if (nama.value.trim() === "") {
            setError(nama, "nama_error", true);
            valid = false;
        } else {
            setError(nama, "nama_error", false);
        }

        // Validasi Tempat Lahir
        let tempatLahir = document.getElementById("etempat_lahir");
        if (tempatLahir.value.trim() === "") {
            setError(tempatLahir, "tempat_lahir_error", true);
            valid = false;
        } else {
            setError(tempatLahir, "tempat_lahir_error", false);
        }

        // Validasi Tanggal Lahir
        let tanggalLahir = document.getElementById("etanggal_lahir");
        if (tanggalLahir.value.trim() === "") {
            setError(tanggalLahir, "tanggal_lahir_error", true);
            valid = false;
        } else {
            setError(tanggalLahir, "tanggal_lahir_error", false);
        }

        // Validate Pangkat (only if not empty)
        let pangkat = document.getElementById("epang");
        if (pangkat.value.trim() === "") {
    setError(pangkat, "pang_error", true);
    valid = false;
} else {
    setError(pangkat, "pang_error", false);
}
             // Validate Pangkat (only if not empty)
        let golongan_ruang = document.getElementById("egol_ruang");
    if (golongan_ruang.value.trim() === "") {
        setError(golongan_ruang, "gol_error", true);
        valid = false;
    } else {
        setError(golongan_ruang, "gol_error", false);
    }

    let jabatan_id = document.getElementById("ejabatan_id");
    if (jabatan_id.value.trim() === "") {
        setError(jabatan_id, "jabatan_id_error", true);
        valid = false;
    } else {
        setError(jabatan_id, "jabatan_id_error", false);
    }
    
    let unit_kerja_id = document.getElementById("euk");
    if (unit_kerja_id.value.trim() === "") {
        setError(unit_kerja_id, "uk_error", true);
        valid = false;
    } else {
        setError(unit_kerja_id, "uk_error", false);
    }

    let kelas_jabatan = document.getElementById("ekj");
    if (kelas_jabatan.value.trim() === "") {
        setError(kelas_jabatan, "kj_error", true);
        valid = false;
    } else {
        setError(kelas_jabatan, "kj_error", false);
    }

    let jenis_kelamin = document.getElementById("ejk");
    if (jenis_kelamin.value.trim() === "") {
        setError(jenis_kelamin, "jenis_kelamin_error", true);
        valid = false;
    } else {
        setError(jenis_kelamin, "jenis_kelamin_error", false);
    }

    let status_pegawai = document.getElementById("estatus_peg");
    if (status_pegawai.value.trim() === "") {
        setError(status_pegawai, "status_pegawai_error", true);
        valid = false;
    } else {
        setError(status_pegawai, "status_pegawai_error", false);
    }

    let status_pernikahan = document.getElementById("estatus_perni");
    if (status_pernikahan.value.trim() === "") {
        setError(status_pernikahan, "status_pernikahan_error", true);
        valid = false;
    } else {
        setError(status_pernikahan, "status_pernikahan_error", false);
    }

    let agama = document.getElementById("eagamaa");
    if (agama.value.trim() === "") {
        setError(agama, "agama_error", true);
        valid = false;
    } else {
        setError(agama, "agama_error", false);
    }

    
        // Jika validasi gagal, cegah pengiriman form
        if (!valid) {
            event.preventDefault();
            return false;
        }
    });

    // Event listener untuk validasi real-time pada input
    document.querySelectorAll(".form-control").forEach((element) => {
        element.addEventListener("input", function () {
            const errorId1 = this.id + "_error";

            // Validasi untuk setiap field input
            if (this.id === "enip") {
    if (this.value.trim() === "") {
        setError(this, "nip_error", true); // Tampilkan error "Kolom NIP tidak boleh kosong"
        setError(this, "nip_error_invalid", false); // Sembunyikan error minimal karakter
    } else if (this.value.trim().length < 10) {
        setError(this, "nip_error", false); // Sembunyikan error "Kolom NIP tidak boleh kosong"
        setError(this, "nip_error_invalid", true); // Tampilkan error minimal karakter
    } else {
        setError(this, "nip_error", false); // Sembunyikan semua error
        setError(this, "nip_error_invalid", false);
    }
}


            if (this.id === "enama") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "etempat_lahir") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "etanggal_lahir") {
                if (this.value.trim() === "") {
                    setError(this, errorId1, true);
                } else {
                    setError(this, errorId1, false);
                }
            }

            if (this.id === "epang") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "egol_ruang") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "ejabatan_id") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "eunit_kerja_id") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "eunit_kerja_id") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "ejk") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "estatus_peg") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        if (this.id === "estatus_perni") {
            if (this.value.trim() === "") {
                setError(this, errorId1, true);
            } else {
                setError(this, errorId1, false);
            }
        }

        
        if (this.id === "eagamaa") {
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
    function confirmDeletePegawai(pegawaiid) {
        Swal.fire({
            title: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil Terhapus!",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    window.location.href = "<?= site_url('pegawai/pegawai/delete/'); ?>" + pegawaiid;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_pegawai')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_pegawai'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_pegawai')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_pegawai'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

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

<script>
    const baseURL = "<?php echo base_url(); ?>";
</script>

<script>
document.getElementById('nip').addEventListener('input', function () {
    const nipInput = this;
    const nip = nipInput.value.trim();
    const nipErrorDuplicate = document.getElementById('nip_error_duplicate');

    if (nip.length >= 10) {
        fetch('<?= site_url("pegawai/pegawai/check_nip"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            body: JSON.stringify({ nip: nip })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error_pegawai') {
                nipInput.classList.add('is-invalid');
                nipErrorDuplicate.style.display = 'block';
            } else {
                nipInput.classList.remove('is-invalid');
                nipErrorDuplicate.style.display = 'none';
            }
        });
    } else {
        nipErrorDuplicate.style.display = 'none';
    }
});
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