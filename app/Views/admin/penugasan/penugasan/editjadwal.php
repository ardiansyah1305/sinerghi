<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    /* Style for holiday cells */
    .holiday-cell {
        position: relative;
        background-color: #dc3545 !important;
        /* Solid red for holidays */
        color: white !important;
        font-weight: bold;
    }

    .holiday-cell::after {
        content: "🏖️";
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 12px;
    }

    /* Style for weekend cells */
    .weekend-cell {
        background-color: rgba(220, 53, 69, 0.05) !important;
        /* Light red transparent for weekends */
    }

    /* Style for holiday events */
    .fc-event-title {
        font-weight: bold;
    }

    /* Override FullCalendar default styles */
    .fc-day-today {
        background-color: rgba(255, 220, 40, 0.15) !important;
        /* Light yellow for today */
    }

    /* Make sure holiday cell color takes precedence */
    .fc .fc-daygrid-day.holiday-cell {
        background-color: #dc3545 !important;
    }

    /* Make sure weekend cell color takes precedence */
    .fc .fc-daygrid-day.weekend-cell {
        background-color: rgba(220, 53, 69, 0.2) !important;
    }

    /* Style for text in holiday cells */
    .holiday-cell .fc-daygrid-day-number {
        color: white !important;
        font-weight: bold;
    }

    /* Style for text in weekend cells */
    .weekend-cell .fc-daygrid-day-number {
        color: #dc3545 !important;
        font-weight: bold;
    }
</style>

<div class="container-fluid px-4 py-4">
    <h2 class="fw-semibold mb-4">Kelola Usulan Jadwal Kerja</h2>

    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white rounded-top py-3">
            <h5 class="mb-0 text-center">
                <i class="bi bi-calendar-check"></i> Pengaturan Jadwal Kerja
                <span class="badge <?= $status_class ?>"><?= $status_label ?></span>
            </h5>
        </div>
        <div class="card-body">
            <form id="formJadwal">
                <?= csrf_field(); ?>

                <input type="hidden" id="usulan_bulan" value="<?= $bulan; ?>">
                <input type="hidden" id="usulan_tahun" value="<?= $tahun; ?>">

                <div class="row">
                    <div class="col-md-4">
                        <h5 class="mb-3"><i class="bi bi-person-lines-fill"></i> Pilih Pegawai</h5>
                        <div class="list-group" id="pegawaiList">
                            <?php foreach ($data_pegawai_unit as $pegawai) : ?>
                                <button type="button" class="list-group-item list-group-item-action pegawai-tab"
                                    data-id="<?= $pegawai['id']; ?>">
                                    <?= $pegawai['nama']; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Jadwal Kerja</h5>
                                        <div>
                                            <!-- Tombol kembali selalu ditampilkan di semua kondisi -->
                                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-left"></i> Kembali
                                            </a>

                                            <?php if ($role_id == 1): ?>
                                                <?php if ($status_approval == 0): ?>
                                                    <button type="button" id="btnSubmit" class="btn btn-warning">
                                                        <i class="bi bi-save"></i> Simpan Jadwal
                                                    </button>
                                                    <button type="button" id="btnAjukan" class="btn btn-success">
                                                        <i class="bi bi-send"></i> Ajukan Permohonan
                                                    </button>
                                                <?php elseif ($status_approval == 1 || $status_approval == 2 || $status_approval == 3): ?>
                                                    <button type="button" id="btnTolak" class="btn btn-danger">
                                                        <i class="bi bi-x-circle"></i> Tolak
                                                    </button>
                                                    <button type="button" id="btnTerima" class="btn btn-success">
                                                        <i class="bi bi-check-circle"></i> Terima
                                                    </button>
                                                <?php endif; ?>
                                            <?php elseif ($role_id == 2): ?>
                                                <?php if ($status_approval == 0 || $status_approval == 1 || $status_approval == 2): ?>
                                                    <button type="button" id="btnTolak" class="btn btn-danger">
                                                        <i class="bi bi-x-circle"></i> Tolak
                                                    </button>
                                                    <button type="button" id="btnTerima" class="btn btn-success">
                                                        <i class="bi bi-check-circle"></i> Terima
                                                    </button>
                                                <?php endif; ?>
                                            <?php elseif ($role_id == 3): ?>
                                                <?php if ($status_approval == 0 || $status_approval == 3): ?>
                                                    <button type="button" id="btnSubmit" class="btn btn-warning ">
                                                        <i class="bi bi-save"></i> Simpan Jadwal
                                                    </button>
                                                    <button type="button" id="btnAjukan" class="btn btn-success">
                                                        <i class="bi bi-send"></i> Ajukan Permohonan
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>

<!-- Modal Catatan Penolakan -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTolakLabel">Catatan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan Penolakan <small class="text-danger"> *</small></label>
                    <textarea class="form-control" id="catatan" rows="4" placeholder="Masukkan alasan penolakan usulan jadwal"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnSimpanCatatan" class="btn btn-primary">Simpan & Tolak</button>
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
    $(document).ready(function() {
        // Global AJAX setup for CSRF protection
        $.ajaxSetup({
            headers: {
                'X-SINERGHI-CSRF-TOKEN': $('meta[name="<?= csrf_token() ?>"]').attr('content')
            },
            data: {
                '<?= csrf_token() ?>': $('meta[name="<?= csrf_token() ?>"]').attr('content')
            },
            complete: function(xhr, status) {
                // Update CSRF token after each request if it's in the response
                var newToken = xhr.getResponseHeader('X-SINERGHI-CSRF-TOKEN');
                if (newToken) {
                    $('meta[name="<?= csrf_token() ?>"]').attr('content', newToken);
                }
            }
        });

        let selectedPegawai = null;
        let calendar;
        let jadwalArray = [];
        let deletedJadwalArray = [];
        let hasCalendarChanges = false;
        let jadwalPerPegawai = {}; // Menyimpan jadwal untuk setiap pegawai
        let deletedJadwalPerPegawai = {}; // Menyimpan jadwal yang dihapus per pegawai

        let usulanBulan = $('#usulan_bulan').val();
        let usulanTahun = $('#usulan_tahun').val();
        let defaultDate = `${usulanTahun}-${usulanBulan}-01`;

        let roleId = parseInt('<?= $role_id ?>');
        let statusApproval = parseInt('<?= $status_approval ?>');
        let usulanId = parseInt('<?= $usulan_id ?>');

        // Inisialisasi calendar
        initCalendar();

        // Load pegawai pertama secara default
        const firstPegawaiButton = $('.pegawai-tab').first();
        if (firstPegawaiButton.length > 0) {
            firstPegawaiButton.addClass('active');
            loadPegawaiJadwal(firstPegawaiButton.data('id'));
        }

        // Event handler untuk klik pada pegawai
        $('.pegawai-tab').click(function() {
            let newPegawaiId = $(this).data('id');

            // Jika ada perubahan yang belum disimpan
            if (hasCalendarChanges) {
                // Simpan jadwal pegawai saat ini ke memory
                saveCurrentJadwalToMemory();

                Swal.fire({
                    title: 'Perubahan Belum Disimpan',
                    text: 'Ada perubahan yang belum disimpan. Simpan perubahan?',
                    icon: 'warning',
                    showDenyButton: true,
                    confirmButtonText: 'Simpan',
                    denyButtonText: 'Abaikan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveJadwal(0, function() {
                            switchToPegawai(newPegawaiId);
                        });
                    } else if (result.isDenied) {
                        switchToPegawai(newPegawaiId);
                    }
                });
            } else {
                switchToPegawai(newPegawaiId);
            }
        });

        // Event handler untuk btnSubmit
        $('#btnSubmit').click(function() {
            // Simpan jadwal pegawai saat ini ke memory
            saveCurrentJadwalToMemory();

            // Langsung simpan tanpa konfirmasi
            saveJadwal(0);
        });

        // Event handler untuk btnTerima
        $('#btnTerima').click(function() {
            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Apakah anda yakin ingin menyetujui usulan jadwal ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin/penugasan/update-status') ?>",
                        type: 'POST',
                        data: {
                            usulan_id: usulanId,
                            status: 2
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Usulan jadwal berhasil disetujui.',
                                    timer: 3000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "<?= base_url('admin/penugasan') ?>";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat menyetujui usulan.',
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan sistem',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });

        // Event handler untuk btnTolak
        $('#btnTolak').click(function() {
            $('#modalTolak').modal('show');
        });

        // Event handler untuk btnSimpanCatatan
        $('#btnSimpanCatatan').click(function() {
            const catatan = $('#catatan').val();
            if (!catatan.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Catatan penolakan tidak boleh kosong.',
                    showConfirmButton: true
                });
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/penugasan/update-status') ?>",
                type: 'POST',
                data: {
                    usulan_id: usulanId,
                    status: 3,
                    catatan_penolakan: catatan
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#modalTolak').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Usulan jadwal berhasil ditolak.',
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "<?= base_url('admin/penugasan') ?>";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat menolak usulan.',
                            showConfirmButton: true
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan sistem',
                        showConfirmButton: true
                    });
                }
            });
        });

        // Event handler untuk btnAjukan
        $('#btnAjukan').click(function() {
            // Check if current status allows submission
            if (statusApproval !== 0 && statusApproval !== 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak dapat mengajukan',
                    text: 'Usulan hanya dapat diajukan saat status draft atau ditolak.',
                    showConfirmButton: true
                });
                return;
            }

            if (hasCalendarChanges) {
                Swal.fire({
                    title: 'Perubahan Belum Disimpan',
                    text: 'Ada perubahan yang belum disimpan. Simpan perubahan terlebih dahulu?',
                    icon: 'warning',
                    showDenyButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    denyButtonText: 'Tidak, Lanjutkan',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveJadwal(0, () => ajukanUsulan());
                    } else if (result.isDenied) {
                        ajukanUsulan();
                    }
                });
            } else {
                ajukanUsulan();
            }
        });

        function saveCurrentJadwalToMemory() {
            if (selectedPegawai) {
                jadwalPerPegawai[selectedPegawai] = [...jadwalArray];
                deletedJadwalPerPegawai[selectedPegawai] = [...deletedJadwalArray];
            }
        }

        function loadJadwalFromMemory(pegawaiId) {
            if (jadwalPerPegawai[pegawaiId]) {
                jadwalArray = [...jadwalPerPegawai[pegawaiId]];
                deletedJadwalArray = [...(deletedJadwalPerPegawai[pegawaiId] || [])];
                displayJadwal(jadwalArray);
                return true;
            }
            return false;
        }

        function displayJadwal(jadwalData) {
            calendar.getEvents().forEach(event => event.remove());

            jadwalData.forEach(jadwal => {
                let icon;
                let color;

                if (jadwal.jenis_alokasi === 'LKK') {
                    icon = '🏢';
                    color = '#0d6efd'; // Blue
                } else if (jadwal.jenis_alokasi === 'LKL') {
                    icon = '🏠';
                    color = '#198754'; // Green
                } else if (jadwal.jenis_alokasi === 'CT') {
                    icon = '📚';
                    color = '#9370DB'; // Light purple
                }

                calendar.addEvent({
                    title: icon + ' ' + jadwal.jenis_alokasi,
                    start: jadwal.tanggal_kerja,
                    allDay: true,
                    color: color
                });
            });

            calendar.render();
        }

        function switchToPegawai(pegawaiId) {
            $('.pegawai-tab').removeClass('active');
            $(`.pegawai-tab[data-id="${pegawaiId}"]`).addClass('active');

            // Coba load dari memory dulu
            if (!loadJadwalFromMemory(pegawaiId)) {
                // Jika tidak ada di memory, ambil dari server
                $.ajax({
                    url: '<?= base_url('api/penugasan/get-jadwal-tersedia/') ?>' + usulanId,
                    type: 'GET',
                    data: {
                        pegawai_id: pegawaiId,
                        bulan: usulanBulan,
                        tahun: usulanTahun
                    },
                    success: function(response) {
                        if (response.success) {
                            jadwalArray = response.data.map(j => ({
                                id: j.id,
                                pegawai_id: pegawaiId,
                                tanggal_kerja: j.tanggal_kerja,
                                jenis_alokasi: j.jenis_alokasi
                            }));
                            deletedJadwalArray = [];
                            displayJadwal(jadwalArray);

                            // Simpan ke memory
                            jadwalPerPegawai[pegawaiId] = [...jadwalArray];
                            deletedJadwalPerPegawai[pegawaiId] = [];
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal mengambil data jadwal.',
                            showConfirmButton: true
                        });
                    }
                });
            }

            selectedPegawai = pegawaiId;
            hasCalendarChanges = false;
        }

        function loadPegawaiJadwal(pegawaiId) {
            selectedPegawai = pegawaiId;
            calendar.getEvents().forEach(event => event.remove());

            if (selectedPegawai) {
                $.ajax({
                    url: '<?= base_url('api/penugasan/get-jadwal-tersedia/') ?>' + usulanId,
                    type: 'GET',
                    data: {
                        pegawai_id: selectedPegawai,
                        bulan: usulanBulan,
                        tahun: usulanTahun
                    },
                    success: function(response) {
                        if (response.success) {
                            jadwalArray = [];
                            deletedJadwalArray = [];

                            response.data.forEach(jadwal => {
                                jadwalArray.push({
                                    id: jadwal.id,
                                    pegawai_id: selectedPegawai,
                                    tanggal_kerja: jadwal.tanggal_kerja,
                                    jenis_alokasi: jadwal.jenis_alokasi
                                });

                                let icon;
                                let color;

                                if (jadwal.jenis_alokasi === 'LKK') {
                                    icon = '🏢';
                                    color = '#0d6efd'; // Blue
                                } else if (jadwal.jenis_alokasi === 'LKL') {
                                    icon = '🏠';
                                    color = '#198754'; // Green
                                } else if (jadwal.jenis_alokasi === 'CT') {
                                    icon = '📚';
                                    color = '#9370DB'; // Purple
                                }

                                calendar.addEvent({
                                    title: icon + ' ' + jadwal.jenis_alokasi,
                                    start: jadwal.tanggal_kerja,
                                    allDay: true,
                                    color: color
                                });
                            });

                            calendar.render();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal mengambil data jadwal.',
                            showConfirmButton: true
                        });
                    }
                });
            }
        }

        function saveJadwal(statusApproval, callback = null) {
            if (!selectedPegawai) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Pegawai!',
                    text: 'Silakan pilih pegawai terlebih dahulu!',
                    showConfirmButton: true
                });
                return;
            }

            // Tampilkan loading
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            console.log('Saving jadwal with usulan_id:', usulanId);
            console.log('Jadwal data:', jadwalArray);
            console.log('Deleted jadwal:', deletedJadwalArray);

            $.ajax({
                url: "<?= base_url('admin/penugasan/store-jadwal') ?>",
                type: 'POST',
                data: {
                    usulan_id: usulanId,
                    jadwal: JSON.stringify(jadwalArray),
                    deleted_jadwal: JSON.stringify(deletedJadwalArray),
                    status_approval: statusApproval
                },
                success: function(response) {
                    console.log('Response from server:', response);
                    Swal.close();

                    if (response.status === 'success') {
                        hasCalendarChanges = false;
                        deletedJadwalArray = [];

                        // Reload jadwal untuk memastikan data yang ditampilkan sesuai dengan database
                        loadPegawaiJadwal(selectedPegawai);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            if (callback) callback();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            showConfirmButton: true
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('Error saving jadwal:', error);
                    console.error('Response:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyimpan jadwal: ' + error,
                        showConfirmButton: true
                    });
                }
            });
        }

        function ajukanUsulan() {
            // Validasi tanggal pengajuan (hanya dapat dilakukan pada tanggal 20-30)
            // const tanggalSekarang = new Date().getDate();
            // const tanggalMulaiPengajuan = 20;
            // const tanggalAkhirPengajuan = 30;

            // // Cek apakah tanggal saat ini berada di luar rentang 20-30
            // if (tanggalSekarang < tanggalMulaiPengajuan || tanggalSekarang > tanggalAkhirPengajuan) {
            //     // Cek apakah hari ini Senin (kode 1) dan masih dalam batas perpanjangan
            //     const hariSekarang = new Date().getDay(); // 0 (Minggu) sampai 6 (Sabtu)
            //     const selisihHari = tanggalSekarang - tanggalAkhirPengajuan;

            //     // Jika bukan Senin atau selisih hari lebih dari 2 hari, tampilkan pesan error
            //     if (hariSekarang !== 1 || selisihHari > 2) {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Periode Pengajuan',
            //             html: `Pengajuan hanya dapat dilakukan dari tanggal <strong>${tanggalMulaiPengajuan}</strong> hingga <strong>${tanggalAkhirPengajuan}</strong> setiap bulannya.<br><br>
            //                   Jika tanggal ${tanggalAkhirPengajuan} jatuh pada hari Sabtu atau Minggu, pengajuan dapat dilakukan hingga hari Senin berikutnya.`,
            //             confirmButtonText: 'Mengerti'
            //         });
            //         return;
            //     }
            // }

            Swal.fire({
                title: 'Konfirmasi Pengajuan',
                text: "Apakah anda yakin ingin mengajukan usulan jadwal ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('admin/penugasan/ajukan-usulan') ?>",
                        type: 'POST',
                        data: {
                            usulan_id: usulanId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Usulan jadwal berhasil diajukan.',
                                    timer: 3000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat mengajukan usulan.',
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        }

        // Inisialisasi calendar
        function initCalendar() {
            let calendarEl = document.getElementById('calendar');

            // Fetch holidays from the database
            let holidays = [];

            $.ajax({
                url: '<?= base_url('admin/hari-libur/get-holidays'); ?>',
                type: 'GET',
                dataType: 'json',
                async: false,
                success: function(response) {
                    if (response.status === 'success') {
                        holidays = response.holidays;
                    }
                }
            });

            let calendarEditable = false;

            if (roleId === 1) {
                // Admin bisa mengedit semua status
                calendarEditable = true;
                // calendarEditable = statusApproval === 0
            } else if (roleId === 2) {
                // Kepala Unit tidak bisa mengedit sama sekali
                calendarEditable = false;
            } else if (roleId === 3) {
                // Koordinator bisa mengedit hanya jika status_approval = 0 (Draft) atau 3 (Ditolak)
                calendarEditable = parseInt(statusApproval) === 0 || parseInt(statusApproval) === 3;
            }

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                initialDate: defaultDate,
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                events: [],
                selectable: calendarEditable,
                editable: calendarEditable,
                contentHeight: 'auto',
                fixedWeekCount: false,
                showNonCurrentDates: false,
                validRange: {
                    start: `${usulanTahun}-${usulanBulan}-01`,
                    end: new Date(usulanTahun, usulanBulan, 0) // Last day of the month
                },
                dayCellClassNames: function(info) {
                    let day = new Date(info.date).getDay();
                    let dateStr = info.dateStr;


                    // Check if it's a holiday from the database
                    let isHoliday = holidays.some(holiday => holiday.tanggal === dateStr);

                    if (isHoliday) {
                        return ['holiday-cell']; // Holiday takes precedence
                    } else if (day === 0 || day === 6) {
                        return ['weekend-cell']; // Weekend styling
                    }

                    return [];
                },
                eventDidMount: function(info) {
                    // Add tooltips for holidays
                    if (info.event.extendedProps.isHoliday) {
                        $(info.el).tooltip({
                            title: info.event.extendedProps.description,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                },
                eventClick: function(info) {
                    // Skip for holiday events
                    if (info.event.extendedProps.isHoliday) {
                        return;
                    }

                    // Check if the calendar is editable based on status_approval
                    if (statusApproval !== 0 && statusApproval !== 3) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak dapat mengedit',
                            text: 'Jadwal tidak dapat diubah karena status usulan bukan draft atau ditolak.',
                            showConfirmButton: true
                        });
                        return;
                    }

                    // Handle event click (remove the event)
                    //     Swal.fire({
                    //         title: 'Hapus Jadwal?',
                    //         text: 'Apakah Anda ingin menghapus jadwal pada tanggal ' + info.event.startStr + '?',
                    //         icon: 'warning',
                    //         showCancelButton: true,
                    //         confirmButtonText: 'Ya, Hapus!',
                    //         cancelButtonText: 'Batal'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             let existingIndex = jadwalArray.findIndex(j =>
                    //                 j.pegawai_id === selectedPegawai &&
                    //                 j.tanggal_kerja === info.event.startStr
                    //             );

                    //             if (existingIndex !== -1) {
                    //                 let removedData = jadwalArray.splice(existingIndex, 1)[0];
                    //                 if (removedData.id) {
                    //                     deletedJadwalArray.push(removedData.id);
                    //                 }
                    //                 info.event.remove();
                    //                 hasCalendarChanges = true;
                    //             }
                    //         }
                    //     });
                },
                dateClick: function(info) {
                    // Check if the calendar is editable based on role and status_approval
                    if (!calendarEditable) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak dapat mengedit',
                            text: 'Anda tidak memiliki izin untuk mengedit jadwal ini.',
                            showConfirmButton: true
                        });
                        return;
                    }

                    if (!selectedPegawai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih Pegawai!',
                            text: 'Silakan pilih pegawai terlebih dahulu!',
                            showConfirmButton: true
                        });
                        return;
                    }

                    // Get the clicked date
                    const clickedDate = new Date(info.dateStr);

                    // Get the current month from the usulanBulan variable
                    const currentMonth = parseInt(usulanBulan);

                    // Check if the clicked date is in the same month as usulanBulan
                    if ((clickedDate.getMonth() + 1) !== currentMonth) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tidak Diizinkan',
                            text: 'Anda hanya dapat memilih tanggal dalam bulan yang sama dengan bulan pengajuan.'
                        });
                        return;
                    }

                    // Check if the selected date is a weekend
                    const selectedDate = new Date(info.dateStr);
                    const isWeekend = selectedDate.getDay() === 0 || selectedDate.getDay() === 6;

                    if (isWeekend) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Hari Libur!',
                            text: 'Tidak bisa memilih hari Sabtu atau Minggu!',
                            showConfirmButton: true
                        });
                        return;
                    }

                    // Check if it's a holiday from the database
                    let isHoliday = holidays.some(holiday => holiday.tanggal === info.dateStr);

                    if (isHoliday) {
                        // Find the holiday details
                        let holiday = holidays.find(h => h.tanggal === info.dateStr);

                        Swal.fire({
                            icon: 'warning',
                            title: 'Hari Libur!',
                            text: 'Tanggal ' + info.dateStr + ' adalah hari libur: ' + holiday.tentang,
                            showConfirmButton: true
                        });
                        return;
                    }

                    // For status_approval = 0, we'll check holidays directly from the API as well
                    // This ensures we have the most up-to-date holiday information
                    if (statusApproval === 0 || statusApproval === 3) {
                        $.ajax({
                            url: '<?= base_url('admin/hari-libur/is-holiday'); ?>',
                            type: 'POST',
                            data: {
                                tanggal: info.dateStr
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success' && response.is_holiday) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Hari Libur!',
                                        text: 'Tanggal ' + info.dateStr + ' adalah hari libur: ' + response.holiday_info,
                                        showConfirmButton: true
                                    });
                                } else {
                                    // Continue with the existing logic for non-holiday dates
                                    // Check if the date already has an event
                                    let existingIndex = jadwalArray.findIndex(j =>
                                        j.pegawai_id === selectedPegawai &&
                                        j.tanggal_kerja === info.dateStr
                                    );

                                    if (existingIndex !== -1) {
                                        // If event exists, show confirmation to change allocation type
                                        Swal.fire({
                                            title: 'Ubah Jenis Alokasi?',
                                            text: 'Tanggal ini sudah memiliki jadwal. Apakah Anda ingin mengubah jenis alokasi?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'Ya, Ubah',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                showJenisAlokasiSelection(info.dateStr, existingIndex);
                                            }
                                        });
                                    } else {
                                        showJenisAlokasiSelection(info.dateStr, existingIndex);
                                    }

                                    function showJenisAlokasiSelection(dateStr, existingIndex) {
                                        Swal.fire({
                                            title: 'Pilih Jenis Alokasi',
                                            html: `
                                                    <p class="mb-3">Tanggal: ${dateStr}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <button type="button" class="btn btn-primary px-3" id="btn-lkk">
                                                            🏢 LKK
                                                        </button>
                                                        <button type="button" class="btn btn-success px-3" id="btn-lkl">
                                                            🏠 LKL
                                                        </button>
                                                        <button type="button" class="btn btn-purple px-3" id="btn-ct" style="background-color: #9370DB; color: white; border-color: #9370DB;">
                                                            📚 CT
                                                        </button>
                                                    </div>
                                                `,
                                            showConfirmButton: false,
                                            showCancelButton: false,
                                            didOpen: () => {
                                                document.getElementById('btn-lkk').addEventListener('click', () => {
                                                    Swal.close();
                                                    updateJadwal(dateStr, 'LKK', existingIndex);
                                                });
                                                document.getElementById('btn-lkl').addEventListener('click', () => {
                                                    Swal.close();
                                                    updateJadwal(dateStr, 'LKL', existingIndex);
                                                });
                                                document.getElementById('btn-ct').addEventListener('click', () => {
                                                    Swal.close();
                                                    updateJadwal(dateStr, 'CT', existingIndex);
                                                });
                                            }
                                        });
                                    }

                                }
                            }
                        });
                    } else {
                        // For other status_approval values, proceed without additional API check
                        // Show warning that editing is not allowed
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak dapat mengedit',
                            text: 'Jadwal tidak dapat diubah karena status usulan bukan draft.',
                            showConfirmButton: true
                        });
                    }
                }
            });

            // Add holiday events to the calendar
            holidays.forEach(holiday => {
                calendar.addEvent({
                    title: '🏖️ ' + holiday.tentang,
                    start: holiday.tanggal,
                    allDay: true,
                    color: '#dc3545', // Red color for holidays
                    textColor: '#ffffff', // White text
                    borderColor: '#ffffff', // White border
                    extendedProps: {
                        isHoliday: true,
                        description: holiday.tentang
                    }
                });
            });

            // Add CSS for holiday cells
            $('head').append(`
                <style>
                    .holiday-cell {
                        background-color: rgba(220, 53, 69, 0.15) !important; /* Light red for holidays */
                    }
                    .fc-event-title {
                        white-space: normal !important;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }
                </style>
            `);

            // Function to update jadwal when a button is clicked
            function updateJadwal(dateStr, jenisAlokasi, existingIndex = -1) {
                let icon;
                let color;

                if (jenisAlokasi === 'LKK') {
                    icon = '🏢';
                    color = '#0d6efd'; // Blue for LKK
                } else if (jenisAlokasi === 'LKL') {
                    icon = '🏠';
                    color = '#198754'; // Green for LKL
                } else if (jenisAlokasi === 'CT') {
                    icon = '📚';
                    color = '#9370DB'; // Purple for CT
                }

                // Find the event index if it wasn't provided or is -1
                if (existingIndex === -1) {
                    existingIndex = jadwalArray.findIndex(j =>
                        j.pegawai_id === selectedPegawai &&
                        j.tanggal_kerja === dateStr
                    );
                }

                if (existingIndex !== -1) {
                    // Update existing jadwal
                    jadwalArray[existingIndex].jenis_alokasi = jenisAlokasi;

                    // Remove existing event and add updated one
                    calendar.getEvents().forEach(event => {
                        if (event.startStr === dateStr) {
                            event.remove();
                        }
                    });
                } else {
                    // Add new jadwal
                    jadwalArray.push({
                        pegawai_id: selectedPegawai,
                        tanggal_kerja: dateStr,
                        jenis_alokasi: jenisAlokasi
                    });
                }

                // Add event to calendar
                calendar.addEvent({
                    title: icon + ' ' + jenisAlokasi,
                    start: dateStr,
                    allDay: true,
                    color: color
                });

                hasCalendarChanges = true;
                
                // Save changes to memory
                if (jadwalPerPegawai[selectedPegawai]) {
                    jadwalPerPegawai[selectedPegawai] = [...jadwalArray];
                }
                
                console.log('Updated jadwal array:', jadwalArray);
            };

            calendar.render();
        }
    });
</script>

<?= $this->endSection(); ?>