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
                            <button type="button" id="btnBatalkan" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Batalkan Pengajuan
                            </button>
                            <button type="button" id="btnTolak" class="btn btn-warning">
                                <i class="bi bi-x-circle"></i> Tolak
                            </button>
                            <button type="button" id="btnTerima" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Terima Permohonan
                            </button>
                        <?php elseif ($status_approval == 2): ?>
                            <a href="<?= site_url('admin/penugasan') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-back"></i> Kembali
                            </a>
                            <button type="button" id="btnBatalkan" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Batalkan
                            </button>
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

        let usulanBulan = $('#usulan_bulan').val();
        let usulanTahun = $('#usulan_tahun').val();
        let defaultDate = `${usulanTahun}-${usulanBulan}-01`;

        let roleId = parseInt('<?= $role_id ?>');
        let statusApproval = parseInt('<?= $status_approval ?>');

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
                            title: 'Pilih Pegawai!',
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

                    let existingIndex = jadwalArray.findIndex(j => j.pegawai_id === selectedPegawai && j.tanggal_kerja === info.dateStr);
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
                                let icon = jenisAlokasi === 'WFO' ? '🏢' : '🏠';

                                jadwalArray.push({
                                    pegawai_id: selectedPegawai,
                                    tanggal_kerja: info.dateStr,
                                    jenis_alokasi: jenisAlokasi
                                });

                                calendar.addEvent({
                                    title: icon + ' ' + jenisAlokasi,
                                    start: info.dateStr,
                                    allDay: true
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

        function loadJadwalPegawai(pegawaiId) {
            console.log(`🔍 Memuat jadwal pegawai ID: ${pegawaiId}`);
            selectedPegawai = pegawaiId;
            jadwalArray = [];
            deletedJadwalArray = [];
            hasCalendarChanges = false;

            calendar.removeAllEvents();

            $.ajax({
                url: `<?= base_url('admin/penugasan/get-jadwal-tersedia/') ?>${pegawaiId}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success' && response.tanggal_terisi) {
                        Object.entries(response.tanggal_terisi).forEach(([tanggal, jenis]) => {
                            let icon = jenis === 'WFO' ? '🏢' : '🏠';

                            calendar.addEvent({
                                title: icon + ' ' + jenis,
                                start: tanggal,
                                allDay: true
                            });

                            jadwalArray.push({
                                pegawai_id: pegawaiId,
                                tanggal_kerja: tanggal,
                                jenis_alokasi: jenis
                            });
                        });
                    }
                }
            });
        }

        $('#pegawaiList button').click(function() {
            let pegawaiId = $(this).data('id');
            loadJadwalPegawai(pegawaiId);
        });

        $('#btnSubmit').click(function() {
            saveJadwal(0);
        });

        $('#btnAjukan').click(function() {
            if (!selectedPegawai) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Pegawai!',
                    text: 'Silakan pilih pegawai terlebih dahulu!',
                    showConfirmButton: true
                });
                return;
            }

            // Jika ada perubahan pada kalender, minta user untuk menyimpan dulu
            if (hasCalendarChanges) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Tersimpan',
                    text: 'Ada perubahan jadwal yang belum disimpan. Simpan perubahan terlebih dahulu!',
                    showConfirmButton: true
                });
                return;
            }

            // Jika tidak ada perubahan kalender, langsung ajukan
            Swal.fire({
                title: 'Konfirmasi Pengajuan',
                text: "Apakah anda yakin ingin mengajukan usulan jadwal ini? Anda tidak dapat mengubah usulan yang telah diajukan",
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
                            usulan_id: '<?= $usulan_id ?>' // Add this to your data array in controller
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
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghubungi server.',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });

        function saveJadwal(statusApproval) {
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
                        hasCalendarChanges = false; // Reset setelah berhasil simpan
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            location.reload();
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

        $('#btnBatalkan').click(function() {
            Swal.fire({
                title: 'Konfirmasi Pembatalan',
                text: "Apakah Anda yakin ingin membatalkan pengajuan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatusApproval(4, 'Pengajuan berhasil dibatalkan');
                }
            });
        });

        $('#btnTolak').click(function() {
            Swal.fire({
                title: 'Konfirmasi Penolakan',
                text: "Apakah Anda yakin ingin menolak pengajuan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatusApproval(3, 'Pengajuan berhasil ditolak');
                }
            });
        });

        $('#btnTerima').click(function() {
            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Apakah Anda yakin ingin menyetujui pengajuan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setuju',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatusApproval(2, 'Pengajuan berhasil disetujui');
                }
            });
        });

        function updateStatusApproval(status, successMessage) {
            $.ajax({
                url: "<?= base_url('admin/penugasan/update-status') ?>",
                type: 'POST',
                data: {
                    usulan_id: '<?= $usulan_id ?>',
                    status: status
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: successMessage,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat memproses pengajuan.',
                            showConfirmButton: true
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menghubungi server.',
                        showConfirmButton: true
                    });
                }
            });
        }

        initCalendar();
    });
</script>

<?= $this->endSection(); ?>