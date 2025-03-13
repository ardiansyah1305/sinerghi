<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

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
                        <h5 class="mb-3 text-center"><i class="bi bi-calendar3"></i> Kalender Jadwal</h5>
                        <div id="calendar"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <?php if ($role_id == 1 || $role_id == 2): ?>
                        <?php if ($status_approval == 0): ?>
                            <!-- No buttons and calendar not clickable -->
                        <?php elseif ($status_approval == 1): ?>
                            <a href="<?= site_url('admin/penugasan') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-back"></i> Kembali
                            </a>
                            <button type="button" id="btnTolak" class="btn btn-warning">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                            <button type="button" id="btnTerima" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Terima
                            </button>
                        <?php elseif ($status_approval == 2): ?>
                            <a href="<?= site_url('admin/penugasan') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-back"></i> Kembali
                            </a>
                        <?php elseif ($status_approval == 3 || $status_approval == 4): ?>
                            <a href="<?= site_url('admin/penugasan') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-back"></i> Kembali
                            </a>
                        <?php endif; ?>
                    <?php elseif ($role_id == 3): ?>
                        <?php if ($status_approval == 0 || $status_approval == 4): ?>
                            <a href="<?= site_url('admin/penugasan') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-back"></i> Kembali
                            </a>
                            <button type="button" id="btnSubmit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Jadwal
                            </button>
                            <button type="button" id="btnAjukan" class="btn btn-success">
                                <i class="bi bi-send"></i> Ajukan Permohonan
                            </button>
                        <?php else: ?>
                            <a href="<?= site_url('admin/penugasan') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-back"></i> Kembali
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
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
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="catatan" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanCatatan">Simpan & Tolak</button>
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
        let selectedPegawai = null;
        let calendar;
        let jadwalArray = [];
        let deletedJadwalArray = [];
        let hasCalendarChanges = false;
        let jadwalPerPegawai = {};  // Menyimpan jadwal untuk setiap pegawai
        let deletedJadwalPerPegawai = {};  // Menyimpan jadwal yang dihapus per pegawai

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
                    showCancelButton: true,
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
                let icon = jadwal.jenis_alokasi === 'WFO' ? '🏢' : '🏠';
                calendar.addEvent({
                    title: icon + ' ' + jadwal.jenis_alokasi,
                    start: jadwal.tanggal_kerja,
                    allDay: true,
                    color: jadwal.jenis_alokasi === 'WFO' ? '#0d6efd' : '#198754'
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
                    url: '<?= base_url('admin/penugasan/get-jadwal-tersedia/') ?>' + usulanId,
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
                    url: '<?= base_url('admin/penugasan/get-jadwal-tersedia/') ?>' + usulanId,
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

                                let icon = jadwal.jenis_alokasi === 'WFO' ? '🏢' : '🏠';
                                calendar.addEvent({
                                    title: icon + ' ' + jadwal.jenis_alokasi,
                                    start: jadwal.tanggal_kerja,
                                    allDay: true,
                                    color: jadwal.jenis_alokasi === 'WFO' ? '#0d6efd' : '#198754'
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

        // Inisialisasi calendar
        function initCalendar() {
            let calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                selectable: roleId === 3 && (statusApproval === 0 || statusApproval === 4),
                contentHeight: 'auto',
                initialDate: defaultDate,
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                dayCellClassNames: function(info) {
                    let day = new Date(info.date).getDay();
                    if (day === 0) return ['bg-danger', 'text-white'];
                    if (day === 6) return ['bg-warning', 'text-dark'];
                    return [];
                },
                dateClick: function(info) {
                    if (!selectedPegawai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Pilih pegawai terlebih dahulu!',
                            showConfirmButton: true
                        });
                        return;
                    }

                    if (roleId !== 3 || (statusApproval !== 0 && statusApproval !== 4)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Dapat Memilih Tanggal',
                            text: 'Kalender tidak dapat diubah pada status ini.',
                            showConfirmButton: true
                        });
                        return;
                    }

                    let clickedDate = new Date(info.date);
                    let dayOfWeek = clickedDate.getDay();
                    if (dayOfWeek === 0 || dayOfWeek === 6) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Hari Libur!',
                            text: 'Tidak bisa memilih hari Sabtu atau Minggu!',
                            showConfirmButton: true
                        });
                        return;
                    }

                    let existingIndex = jadwalArray.findIndex(j => 
                        j.pegawai_id === selectedPegawai && 
                        j.tanggal_kerja === info.dateStr
                    );

                    if (existingIndex !== -1) {
                        Swal.fire({
                            title: 'Hapus Jadwal?',
                            text: 'Apakah Anda ingin menghapus jadwal pada tanggal ' + info.dateStr + '?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let removedData = jadwalArray.splice(existingIndex, 1)[0];
                                if (removedData.id) {
                                    deletedJadwalArray.push(removedData.id);
                                }
                                removeCalendarEvent(info.dateStr);
                                hasCalendarChanges = true;
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Pilih Jenis Alokasi',
                            text: 'Tanggal: ' + info.dateStr,
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: '🏢 WFO',
                            denyButtonText: '🏠 WFA',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDenied) {
                                let jenisAlokasi = result.isConfirmed ? 'WFO' : 'WFA';
                                let icon = result.isConfirmed ? '🏢' : '🏠';

                                jadwalArray.push({
                                    pegawai_id: selectedPegawai,
                                    tanggal_kerja: info.dateStr,
                                    jenis_alokasi: jenisAlokasi
                                });

                                calendar.addEvent({
                                    title: icon + ' ' + jenisAlokasi,
                                    start: info.dateStr,
                                    allDay: true,
                                    color: jenisAlokasi === 'WFO' ? '#0d6efd' : '#198754'
                                });

                                hasCalendarChanges = true;
                            }
                        });
                    }
                }
            });

            calendar.render();
        }

        function removeCalendarEvent(dateStr) {
            let events = calendar.getEvents();
            events.forEach(event => {
                if (event.startStr === dateStr) event.remove();
            });
        }

        function saveJadwal(statusApproval, callback = null) {
            if (!selectedPegawai) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Pilih pegawai terlebih dahulu!',
                    showConfirmButton: true
                });
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/penugasan/store-jadwal') ?>",
                type: 'POST',
                data: {
                    jadwal: JSON.stringify(jadwalArray),
                    deleted_jadwal: JSON.stringify(deletedJadwalArray),
                    status_approval: statusApproval
                },
                success: function(response) {
                    if (response.status === 'success') {
                        hasCalendarChanges = false;
                        deletedJadwalArray = [];
                        
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
                }
            });
        }

        // Event handler untuk btnAjukan
        $('#btnAjukan').click(function() {
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

        function ajukanUsulan() {
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

        // Event handler untuk btnSubmit
        $('#btnSubmit').click(function() {
            if (hasCalendarChanges) {
                saveJadwal(0);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: 'Tidak ada perubahan yang perlu disimpan.',
                    showConfirmButton: true
                });
            }
        });

        // Fungsi-fungsi lainnya...
    });
</script>

<?= $this->endSection(); ?>