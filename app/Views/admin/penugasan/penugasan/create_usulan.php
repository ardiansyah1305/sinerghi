<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4 py-4">
    <h2 class="fw-semibold mb-4">Kelola Usulan Jadwal Kerja</h2>

    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white rounded-top py-3">
            <h5 class="mb-0 text-center"><i class="bi bi-calendar-check"></i> Form Pengajuan Jadwal Kerja</h5>
        </div>
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <form id="usulanForm" action="<?= base_url('admin/penugasan/store-usulan'); ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="bi bi-calendar"></i> Periode Pengajuan</h5>

                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select id="bulan" name="bulan" class="form-select">
                                        <option value="" disabled selected>Pilih Bulan</option>
                                        <?php
                                        $bulanSekarang = date('m');
                                        $bulanDepan = date('m', strtotime('+1 month'));

                                        // Array nama bulan dalam bahasa Indonesia
                                        $namaBulan = [
                                            '01' => 'Januari',
                                            '02' => 'Februari',
                                            '03' => 'Maret',
                                            '04' => 'April',
                                            '05' => 'Mei',
                                            '06' => 'Juni',
                                            '07' => 'Juli',
                                            '08' => 'Agustus',
                                            '09' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'Desember'
                                        ];
                                        ?>
                                        <option value="<?= $bulanSekarang; ?>"><?= $namaBulan[$bulanSekarang]; ?></option>
                                        <option value="<?= $bulanDepan; ?>"><?= $namaBulan[$bulanDepan]; ?></option>
                                    </select>
                                    <div class="invalid-feedback" id="bulanError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="text" id="tahun" name="tahun" class="form-control" value="<?= date('Y'); ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="bi bi-upload"></i> Upload Dokumen</h5>

                                <div class="mb-3">
                                    <label for="file_surat" class="form-label">Surat Pengajuan (PDF, max 2MB)</label>
                                    <input type="file" id="file_surat" name="file_surat" class="form-control" accept=".pdf">
                                    <div class="invalid-feedback" id="suratError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="file_excel" class="form-label">
                                        Jadwal Kerja (Excel, .xlsx, max 2MB)
                                        <a href="<?= base_url('uploads/template/template_jadwal.xlsx'); ?>" class="btn btn-link p-0 text-decoration-none">
                                            <i class="bi bi-file-earmark-excel"></i> Download Template Excel
                                        </a>
                                    </label>
                                    <input type="file" id="file_excel" name="file_excel" class="form-control" accept=".xlsx">
                                    <div class="invalid-feedback" id="fileError"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="position-fixed top-50 start-50 translate-middle" style="display: none; z-index: 9999;">
                            <div class="bg-white p-4 rounded shadow-lg text-center">
                                <div class="spinner-border text-primary mb-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mb-0">Sedang memproses data...</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                <i class="bi bi-save"></i> Simpan Jadwal
                            </button>
                        </div>
                    </form>

                    <!-- Tabel error validasi -->
                    <div id="validationErrors" class="mt-3" style="display: none;">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title mb-0">Daftar Error</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-danger">
                                            <tr>
                                                <th class="text-center" style="width: 5%">No</th>
                                                <th class="text-center">Pesan Kesalahan</th>

                                            </tr>
                                        </thead>
                                        <tbody id="errorList">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
<script>
    // ===== KONFIGURASI PERIODE PENGAJUAN =====
    // Ubah nilai konstanta ini untuk mengubah periode pengajuan
    const TANGGAL_MULAI_PENGAJUAN = 15; // Tanggal mulai pengajuan setiap bulan
    const TANGGAL_AKHIR_PENGAJUAN = 20; // Tanggal berakhir pengajuan setiap bulan
    const BATAS_PERPANJANGAN = 2; // Jumlah hari perpanjangan jika jatuh di weekend
    // =========================================

    $(document).ready(function() {
        // Handle file excel upload dan validasi
        $('#file_excel').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Reset error sebelumnya
                clearErrors();

                // Validasi ekstensi
                const allowedExtensions = /(\.xlsx)$/i;
                if (!allowedExtensions.exec(file.name)) {
                    $(this).addClass('is-invalid');
                    $('#fileError').text('File harus berformat .xlsx');
                    return;
                }

                // Validasi ukuran (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    $(this).addClass('is-invalid');
                    $('#fileError').text('Ukuran file maksimal 2MB');
                    return;
                }

                // Validasi bulan dipilih
                const bulan = $('#bulan').val();
                if (!bulan) {
                    $('#bulan').addClass('is-invalid');
                    $('#bulanError').text('Pilih bulan terlebih dahulu');
                    $(this).val(''); // Reset file input
                    return;
                }

                // Kirim file untuk validasi
                var formData = new FormData();
                formData.append('file_excel', file);
                formData.append('bulan', bulan);

                $.ajax({
                    url: '<?= base_url('admin/penugasan/validate-excel'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#loadingSpinner').fadeIn();
                        $('#validationErrors').fadeOut();
                    },
                    success: function(response) {
                        if (response.status === 'error') {
                            // Debug: Tampilkan response lengkap di console
                            console.log('Full response:', response);

                            // Tampilkan SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Terdapat kesalahan dalam file Excel. Silahkan periksa detail error di bawah.',
                                showConfirmButton: false,
                                timer: 2500
                            }).then(() => {
                                // Scroll ke tabel error setelah user klik OK
                                $('html, body').animate({
                                    scrollTop: $('#validationErrors').offset().top - 100
                                }, 500);
                            });

                            // Parse error messages dan tampilkan dalam tabel
                            let errors = response.message.split('<br>');
                            let errorHtml = '';
                            errors.forEach((error, index) => {
                                if (error.trim()) { // Hanya tampilkan jika ada isi
                                    errorHtml += `
                                        <tr>
                                            <td class="text-center align-middle" style="width: 5%">${index + 1}</td>
                                            <td class="align-middle text-danger">${error}</td>
                                        </tr>
                                    `;
                                }
                            });

                            // Tampilkan tabel error dengan animasi
                            $('#errorList').html(errorHtml);
                            $('#validationErrors').hide().fadeIn(500);

                            // Reset file input
                            $('#file_excel').val('');
                        } else {
                            // Validasi berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Validasi Berhasil',
                                text: 'File Excel valid dan siap diproses',
                                showConfirmButton: false,
                                timer: 2500
                            });
                            $('#validationErrors').fadeOut(500);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memvalidasi file. Silakan coba lagi.',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    },
                    complete: function() {
                        $('#loadingSpinner').fadeOut();
                    }
                });
            }
        });

        function validateForm() {
            let isValid = true;
            let errorMessage = '';

            // Validasi bulan
            const bulan = $('#bulan').val();
            if (!bulan) {
                $('#bulan').addClass('is-invalid');
                $('#bulanError').text('Bulan harus diisi');
                isValid = false;
            }

            // Validasi file surat
            const fileSurat = $('#file_surat').val();
            if (!fileSurat) {
                $('#file_surat').addClass('is-invalid');
                $('#suratError').text('File surat harus diupload');
                isValid = false;
            } else {
                const pdfExtension = /(\.pdf)$/i;
                if (!pdfExtension.exec(fileSurat)) {
                    $('#file_surat').addClass('is-invalid');
                    $('#suratError').text('File harus berformat PDF');
                    isValid = false;
                }
            }

            // Validasi file excel
            const fileExcel = $('#file_excel').val();
            if (!fileExcel) {
                $('#file_excel').addClass('is-invalid');
                $('#fileError').text('File Excel harus diupload');
                isValid = false;
            }

            return isValid;
        }

        function clearErrors() {
            $('#bulan, #file_surat, #file_excel').removeClass('is-invalid');
            $('#bulanError, #suratError, #fileError').text('');
            $('#errorList').empty();
            $('#validationErrors').hide();
        }

        $('#usulanForm').on('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return false;
            }

            var formData = new FormData(this);
            var submitBtn = $('#btnSubmit');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loadingSpinner').fadeIn();
                    submitBtn.prop('disabled', true);
                    clearErrors();
                },
                success: function(response) {
                    if (response.status === 'error') {
                        // Tampilkan pesan error tanpa tombol konfirmasi
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: response.errors || response.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    } else {
                        // Tampilkan pesan sukses tanpa tombol konfirmasi
                        Swal.fire({
                            icon: 'success',
                            title: 'Validasi Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2500
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal melakukan validasi file',
                        showConfirmButton: false,
                        timer: 2500
                    });
                },
                complete: function() {
                    $('#loadingSpinner').fadeOut();
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>