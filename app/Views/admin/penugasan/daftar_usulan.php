<?php
helper(['encrypt']);
?>

<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4"><?= $title; ?></h2>
    <div class="card shadow rounded-4">
        <div class="card-body">
            <?php if (($role_id == 3)): ?>
                <div class="d-flex justify-content-end mb-3">
                    <a href="<?= site_url('admin/penugasan/create-usulan'); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Buat Usulan
                    </a>
                </div>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center align-middle" style="width: 5%;">No</th>
                        <th class="text-center align-middle" style="width: 15%;">Nama Pengusul</th>
                        <th class="text-center align-middle" style="width: 20%;">Unit Kerja</th>
                        <th class="text-center align-middle" style="width: 10%;">Bulan</th>
                        <th class="text-center align-middle" style="width: 10%;">Status</th>
                        <th class="text-center align-middle" style="width: 30%;">Catatan</th>
                        <th class="text-center align-middle" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($usulan as $item) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $i++; ?></td>
                            <td class="align-middle"><?= $item['nama_pengusul']; ?></td>
                            <td class="align-middle"><?= $item['nama_unit']; ?></td>
                            <td class="text-center align-middle">
                                <?php
                                $bulan = date('m', strtotime($item['bulan']));
                                $tahun = date('Y', strtotime($item['bulan']));
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
                                echo $namaBulan[$bulan] . ' ' . $tahun;
                                ?>
                            </td>
                            <td class="text-center align-middle">
                                <?php
                                $status_label = '';
                                $status_class = '';
                                switch ($item['status_approval']) {
                                    case 0:
                                        $status_label = 'Draft';
                                        $status_class = 'bg-secondary';
                                        break;
                                    case 1:
                                        $status_label = 'Menunggu Persetujuan';
                                        $status_class = 'bg-warning';
                                        break;
                                    case 2:
                                        $status_label = 'Disetujui';
                                        $status_class = 'bg-success';
                                        break;
                                    case 3:
                                        $status_label = 'Ditolak';
                                        $status_class = 'bg-danger';
                                        break;
                                    case 4:
                                        $status_label = 'Dibatalkan';
                                        $status_class = 'bg-info';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $status_class; ?>"><?= $status_label; ?></span>
                            </td>
                            <td class="text-center align-middle">
                                <?php if ($item['status_approval'] == 3 && !empty($item['catatan_penolakan'])): ?>
                                    <span class="text-start d-block"><?= $item['catatan_penolakan']; ?></span>
                                <?php elseif ($item['status_approval'] == 3): ?>
                                    <span class=""><em>Tidak ada catatan</em></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?= site_url('admin/penugasan/edit-usulan/' . encrypt_url($item['id'])); ?>"
                                        class="btn btn-outline-info btn-sm"
                                        data-bs-toggle="tooltip"
                                        title="Lihat Usulan">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                    
                                    <?php 
                                    // Kondisi untuk menampilkan tombol edit jadwal berdasarkan role dan status approval
                                    $canEditJadwal = false;
                                    
                                    if ($role_id == 1) {
                                        // Admin bisa edit semua status
                                        $canEditJadwal = true;
                                    } else if ($role_id == 2) {
                                        // Kepala Unit bisa edit kecuali status_approval = 3 (ditolak)
                                        $canEditJadwal = $item['status_approval'] != 3;
                                    } else if ($role_id == 3) {
                                        // Koordinator bisa edit jika status_approval = 0 (draft) atau 3 (ditolak)
                                        $canEditJadwal = $item['status_approval'] == 0 || $item['status_approval'] == 3;
                                    }
                                    
                                    if ($canEditJadwal) {
                                        // Tampilkan tombol edit jadwal jika diizinkan
                                        echo '<a href="' . site_url('admin/penugasan/editjadwal/' . encrypt_url($item['id'])) . '"
                                            class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Edit Jadwal">
                                            <i class="bi bi-calendar"></i>
                                        </a>';
                                    } else {
                                        // Tampilkan tombol lihat jadwal saja (tidak bisa edit)
                                        echo '<a href="' . site_url('admin/penugasan/editjadwal/' . encrypt_url($item['id'])) . '"
                                            class="btn btn-outline-secondary btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Lihat Jadwal">
                                            <i class="bi bi-calendar"></i>
                                        </a>';
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($usulan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-3">Tidak ada data usulan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Penolakan -->
<div class="modal fade" id="modalPenolakan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPenolakan">
                    <input type="hidden" id="usulan_id" name="usulan_id">
                    <div class="mb-3">
                        <label for="catatan_penolakan" class="form-label">Catatan Penolakan</label>
                        <textarea class="form-control" id="catatan_penolakan" name="catatan_penolakan" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="submitPenolakan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    // Setup AJAX CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function approveUsulan(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyetujui usulan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create form data with CSRF token
                var formData = new FormData();
                formData.append('usulan_id', id);
                formData.append('status', 2);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                $.ajax({
                    url: '<?= site_url('admin/penugasan/update-status'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Berhasil', 'Usulan telah disetujui', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                    }
                });
            }
        });
    }

    function rejectUsulan(id) {
        $('#usulan_id').val(id);
        $('#modalPenolakan').modal('show');
    }

    function submitPenolakan() {
        const usulanId = $('#usulan_id').val();
        const catatan = $('#catatan_penolakan').val();

        if (!catatan) {
            Swal.fire('Error', 'Catatan penolakan harus diisi', 'error');
            return;
        }

        // Create form data with CSRF token
        var formData = new FormData();
        formData.append('usulan_id', usulanId);
        formData.append('status', 3);
        formData.append('catatan_penolakan', catatan);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        $.ajax({
            url: '<?= site_url('admin/penugasan/update-status'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#modalPenolakan').modal('hide');
                    Swal.fire('Berhasil', 'Usulan telah ditolak', 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });
    }

    function revisiUsulan(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin merevisi usulan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Revisi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create form data with CSRF token
                var formData = new FormData();
                formData.append('usulan_id', id);
                formData.append('status', 0);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                $.ajax({
                    url: '<?= site_url('admin/penugasan/update-status'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Berhasil', 'Usulan telah direvisi', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                    }
                });
            }
        });
    }

    // Aktifkan tooltips
    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<?= $this->endSection(); ?>