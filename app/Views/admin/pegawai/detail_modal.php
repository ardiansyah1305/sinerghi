<div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-3 text-center">
                <?php if (!empty($pegawai['foto']) && file_exists(ROOTPATH . 'public/uploads/foto_pegawai/' . $pegawai['foto'])): ?>
                    <img src="<?= base_url('uploads/foto_pegawai/' . $pegawai['foto']); ?>" alt="Foto <?= esc($pegawai['nama']); ?>" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    <img src="<?= base_url('images/default-profile.jpg'); ?>" alt="Default Profile" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <h4 class="fw-bold"><?= esc($pegawai['gelar_depan'] ? $pegawai['gelar_depan'] . ' ' : '') . esc($pegawai['nama']) . ($pegawai['gelar_belakang'] ? ', ' . $pegawai['gelar_belakang'] : ''); ?></h4>
                <p class="text-muted mb-1">NIP: <?= esc($pegawai['nip']); ?></p>
                <p class="text-muted mb-1"><?= esc($pegawai['nama_jabatan']); ?></p>
                <p class="text-muted mb-1"><?= esc($pegawai['nama_unit_kerja']); ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Tempat, Tanggal Lahir</strong></td>
                                <td><?= esc($pegawai['tempat_lahir'] ?? '-') . ($pegawai['tempat_lahir'] ? ', ' : '') . esc($pegawai['tanggal_lahir_formatted']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td><?= esc($pegawai['jenis_kelamin'] == '1' ? 'Laki-laki' : 'Perempuan'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Agama</strong></td>
                                <td><?= esc($pegawai['nama_agama'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status Pernikahan</strong></td>
                                <td><?= esc($pegawai['status_pernikahan_nama'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Anak</strong></td>
                                <td><?= esc($pegawai['jumlah_anak'] ?? '0'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td><?= esc($pegawai['alamat'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td><?= esc($pegawai['email'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>No. Telepon</strong></td>
                                <td><?= esc($pegawai['no_telepon'] ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Kepegawaian</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Status Pegawai</strong></td>
                                <td><?= esc($pegawai['status_pegawai_nama']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pangkat/Golongan</strong></td>
                                <td><?= esc($pegawai['nama_pangkat'] ?? '-'); ?> (<?= esc($pegawai['golongan_ruang'] ?? '-'); ?>)</td>
                            </tr>
                            <tr>
                                <td><strong>Jabatan</strong></td>
                                <td><?= esc($pegawai['nama_jabatan']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Unit Kerja</strong></td>
                                <td><?= esc($pegawai['nama_unit_kerja']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Unit Eselon 1</strong></td>
                                <td><?= esc($pegawai['parent_unit_name'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Kelas Jabatan</strong></td>
                                <td><?= esc($pegawai['kelas_jabatan'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>TMT</strong></td>
                                <td><?= esc($pegawai['tmt_formatted'] ?? '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
