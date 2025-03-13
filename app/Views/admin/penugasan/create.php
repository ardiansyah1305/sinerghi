<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Usulan Jadwal Kerja</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Pilih Pegawai dan Atur Jadwal</h5>
        </div>
        <div class="card-body">

            <form id="formJadwal">
                <div class="card shadow rounded-4 mt-3 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Periode Pengajuan</h5>
                            <label for="bulan">Bulan:</label>
                            <select id="bulan" class="form-control">
                                <?php
                                $bulanSekarang = date('m');
                                $bulanDepan = date('m', strtotime('+1 month'));
                                ?>
                                <option value="" disabled selected>Pilih Bulan</option>
                                <option value="<?= $bulanSekarang; ?>" <?= $bulanSekarang == date('m') ? 'disabled' : ''; ?>><?= date('F'); ?></option>
                                <option value="<?= $bulanDepan; ?>"><?= date('F', strtotime('+1 month')); ?></option>
                            </select>

                            <label for="tahun" class="mt-2">Tahun:</label>
                            <input type="text" id="tahun" class="form-control" value="<?= date('Y'); ?>" readonly>

                            <label for="file_surat" class="mt-3">Upload Surat (PDF, max 2MB):</label>
                            <input type="file" id="file_surat" class="form-control" accept=".pdf">
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-primary me-2" id="btnSave">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-success me-2" id="btnSubmit">
                                    <i class="fas fa-paper-plane"></i> Ajukan Usulan
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow rounded-4 mt-3 p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Daftar Pegawai</h5>
                            <ul class="list-group" id="pegawaiList">
                                <?php foreach ($data_pegawai_unit as $pegawai) : ?>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="pegawai-checkbox me-2"
                                                data-id="<?= $pegawai['id']; ?>" id="pegawai_<?= $pegawai['id']; ?>" disabled>
                                            <label for="pegawai_<?= $pegawai['id']; ?>">
                                                <?= $pegawai['nama']; ?>
                                            </label>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="col-md-8">
                            <div id="calendarContainer" class="d-none">
                                <div class="card p-3">
                                    <h6>Jadwal WFA</h6>
                                    <div class="calendar" id="calendarWFA"></div>
                                    <h6 class="mt-3">Jadwal WFO</h6>
                                    <div class="calendar" id="calendarWFO"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
<script>
    $(document).ready(function() {
        let pegawaiJadwal = {};
        let calendarInstances = {};
        let tanggalTerisi = {};

        // Menonaktifkan pegawai sampai bulan dipilih
        $('#bulan').on('change', function() {
            let bulanSelected = $(this).val();

            // Pastikan bulan tidak sama dengan bulan berjalan
            if (bulanSelected === '<?= date('m'); ?>') {
                Swal.fire('Peringatan!', 'Bulan yang sedang berjalan tidak dapat dipilih.', 'warning');
                return;
            }

            // Mengaktifkan checkbox pegawai setelah bulan dipilih
            if (bulanSelected) {
                $('.pegawai-checkbox').prop('disabled', false);
            }

            // Reset pegawai yang dipilih jika bulan diubah
            $('.pegawai-checkbox').prop('checked', false);
            $('#calendarContainer').addClass('d-none'); // Menyembunyikan kalender ketika pegawai direset
        });

        // Validasi bahwa bulan harus dipilih sebelum memilih pegawai
        $('.pegawai-checkbox').on('change', function() {
            let pegawaiId = $(this).data('id');

            if ($('#bulan').val() === '') {
                // Jika bulan belum dipilih
                Swal.fire('Peringatan!', 'Pilih bulan terlebih dahulu!', 'warning');
                $(this).prop('checked', false); // Batalkan pilihan pegawai
                return;
            }

            if ($(this).is(':checked')) {
                $('#calendarContainer').removeClass('d-none');

                if (!pegawaiJadwal[pegawaiId]) {
                    pegawaiJadwal[pegawaiId] = {
                        WFA: [],
                        WFO: []
                    };
                }

                // Menyesuaikan kalender berdasarkan bulan yang dipilih
                updateCalendarMonth(pegawaiId);
            } else {
                $('#calendarContainer').addClass('d-none');
                delete pegawaiJadwal[pegawaiId]; // Menghapus pegawai yang tidak dipilih
            }
        });

        // Fungsi untuk menyesuaikan kalender dengan bulan yang dipilih
        function updateCalendarMonth(pegawaiId) {
            let bulanPengajuan = $('#bulan').val();
            let tahunPengajuan = $('#tahun').val();
            let bulanTahun = tahunPengajuan + '-' + bulanPengajuan;

            $.ajax({
                url: `<?= base_url("api/penugasan/get-jadwal-tersedia/"); ?>${pegawaiId}?bulan=${bulanTahun}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        tanggalTerisi = response.tanggal_terisi || {};
                        pegawaiJadwal[pegawaiId].WFA = [];
                        pegawaiJadwal[pegawaiId].WFO = [];

                        for (const [tanggal, jenis] of Object.entries(tanggalTerisi)) {
                            if (jenis === 'WFA') {
                                pegawaiJadwal[pegawaiId].WFA.push(tanggal);
                            } else if (jenis === 'WFO') {
                                pegawaiJadwal[pegawaiId].WFO.push(tanggal);
                            }
                        }

                        // Render kalender sesuai dengan data yang ada
                        if (pegawaiJadwal[pegawaiId]) {
                            initCalendar('calendarWFA', pegawaiJadwal[pegawaiId].WFA, 'WFA', pegawaiId);
                            initCalendar('calendarWFO', pegawaiJadwal[pegawaiId].WFO, 'WFO', pegawaiId);
                        }
                    } else {
                        console.warn('⚠ Tidak ada jadwal ditemukan.');
                    }
                },
                error: function(xhr) {
                    console.error("🔴 Error fetching jadwal:", xhr.responseText);
                    initCalendar('calendarWFA', [], 'WFA', pegawaiId);
                    initCalendar('calendarWFO', [], 'WFO', pegawaiId);
                }
            });
        }

        // Inisialisasi kalender dengan data yang sudah ada
        function initCalendar(calendarId, selectedDates, jenisAlokasi, pegawaiId) {
            let calendarEl = document.getElementById(calendarId);
            if (!calendarEl) return;

            if (calendarInstances[calendarId]) {
                calendarInstances[calendarId].destroy();
            }

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                locale: 'id',
                firstDay: 1, // Mulai dari hari Senin
                contentHeight: 'auto',
                initialDate: $('#tahun').val() + '-' + $('#bulan').val() + '-01',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                // Menyesuaikan tanggal awal kalender
                select: function(info) {
                    let dateStr = info.startStr;

                    // For WFA calendar, disable Monday selection
                    if (jenisAlokasi === 'WFA') {
                        const selectedDate = new Date(dateStr);
                        if (selectedDate.getDay() === 1) { // Monday
                            Swal.fire({
                                icon: 'info',
                                title: 'Tidak Tersedia',
                                text: 'Hari Senin hanya tersedia untuk WFO, tidak untuk WFA.'
                            });
                            return;
                        }
                    }

                    if (jenisAlokasi === 'WFO' && pegawaiJadwal[pegawaiId].WFA.includes(dateStr)) {
                        Swal.fire('Error!', 'Tanggal ini sudah dipilih sebagai WFA. Harap hapus WFA terlebih dahulu.', 'error');
                        return;
                    }

                    if (jenisAlokasi === 'WFA' && pegawaiJadwal[pegawaiId].WFO.includes(dateStr)) {
                        Swal.fire('Error!', 'Tanggal ini sudah dipilih sebagai WFO. Harap hapus WFO terlebih dahulu.', 'error');
                        return;
                    }

                    let index = selectedDates.indexOf(dateStr);
                    if (index === -1) {
                        selectedDates.push(dateStr);
                    } else {
                        selectedDates.splice(index, 1);
                    }

                    // Update status jenis alokasi di jadwal
                    if (jenisAlokasi === 'WFO') {
                        pegawaiJadwal[pegawaiId].WFO = selectedDates;
                    } else {
                        pegawaiJadwal[pegawaiId].WFA = selectedDates;
                    }

                    // Debug: Lihat hasil perubahan jadwal
                    console.log('Updated jadwal for pegawai ' + pegawaiId + ' (WFO):', pegawaiJadwal[pegawaiId].WFO);
                    console.log('Updated jadwal for pegawai ' + pegawaiId + ' (WFA):', pegawaiJadwal[pegawaiId].WFA);

                    updateCalendarEvents(calendar, selectedDates);
                },
                dayCellDidMount: function(info) {
                    let day = new Date(info.date).getDay();
                    if (day === 0 || day === 6) {
                        info.el.style.backgroundColor = "#f8d7da";
                    }
                }
            });

            calendar.render();
            updateCalendarEvents(calendar, selectedDates);
            calendarInstances[calendarId] = calendar;
        }

        function updateCalendarEvents(calendar, selectedDates) {
            calendar.removeAllEvents();
            selectedDates.forEach(date => {
                calendar.addEvent({
                    title: calendar.el.id.includes('WFO') ? '🏢 WFO' : '🏠 WFA',
                    start: date,
                    allDay: true
                });
            });
        }

        // Event handler untuk tombol Simpan
        $('#btnSave').on('click', function() {

            let bulan = $('#bulan').val();
            let tahun = $('#tahun').val();

            if (!bulan || !tahun) {
                Swal.fire('Peringatan!', 'Pastikan bulan dan tahun sudah dipilih!', 'warning');
                return;
            }

            let jadwalArray = [];
            let hapusWFA = [];

            for (let pegawaiId in pegawaiJadwal) {
                let jadwal = pegawaiJadwal[pegawaiId];

                // Menambahkan WFO
                jadwal.WFO.forEach(tanggal => {
                    jadwalArray.push({
                        pegawai_id: pegawaiId,
                        tanggal_kerja: tanggal,
                        jenis_alokasi: 'WFO' // Pastikan WFO dikirim
                    });

                    // Cek dan hapus WFA jika ada
                    if (tanggalTerisi[tanggal] === 'WFA') {
                        hapusWFA.push({
                            pegawai_id: pegawaiId,
                            tanggal_kerja: tanggal
                        });
                    }
                });

                // Menambahkan WFA
                jadwal.WFA.forEach(tanggal => {
                    jadwalArray.push({
                        pegawai_id: pegawaiId,
                        tanggal_kerja: tanggal,
                        jenis_alokasi: 'WFA' // Pastikan WFA dikirim
                    });
                });
            }

            if (jadwalArray.length === 0) {
                Swal.fire('Peringatan!', 'Tidak ada data jadwal untuk disimpan.', 'warning');
                return;
            }

            // Kirim data jadwal melalui AJAX
            $.ajax({
                url: '<?= base_url("admin/penugasan/store-jadwal"); ?>',
                type: 'POST',
                data: {
                    jadwal: JSON.stringify(jadwalArray),
                    hapusWFA: JSON.stringify(hapusWFA),
                    bulan: bulan, // Kirim bulan yang dipilih
                    tahun: tahun,
                    _csrf: '<?= csrf_token() ?>'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Sukses!', 'Jadwal berhasil disimpan.', 'success').then(() => {
                            // Redirect ke halaman penugasan setelah sukses
                            window.location.href = '<?= base_url("admin/penugasan"); ?>';
                        });
                    } else {
                        Swal.fire('Error!', 'Gagal menyimpan jadwal.', 'error');
                    }
                },
                error: function(xhr) {
                    console.error("🔴 Error saving data:", xhr.responseText);
                    Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan jadwal.', 'error');
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>