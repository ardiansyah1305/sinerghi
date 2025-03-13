<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-uppercase">Edit Profil</h3>
                <a href="<?= base_url('profile'); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow rounded-4 mb-4">
                <div class="card-body p-4">
                    <form action="<?= base_url('profile/update'); ?>" method="post">
                        <?= csrf_field(); ?>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold mb-3">Informasi Pribadi</h5>
                                <hr>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <!-- Left Column -->
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($pegawai['nama']); ?>" readonly>
                                    <small class="text-muted">Nama tidak dapat diubah</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" value="<?= esc($pegawai['nip']); ?>" readonly>
                                    <small class="text-muted">NIP tidak dapat diubah</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= esc($pegawai['tempat_lahir'] ?? ''); ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= esc($pegawai['tanggal_lahir'] ?? ''); ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" <?= ($pegawai['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="P" <?= ($pegawai['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <select class="form-select" id="agama" name="agama">
                                        <option value="">-- Pilih Agama --</option>
                                        <?php foreach ($agama as $a): ?>
                                            <option value="<?= $a['kode']; ?>" <?= ($pegawai['agama'] ?? '') == $a['kode'] ? 'selected' : ''; ?>>
                                                <?= esc($a['nama_agama']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                    <select class="form-select" id="status_pernikahan" name="status_pernikahan">
                                        <option value="">-- Pilih Status Pernikahan --</option>
                                        <?php foreach ($status_pernikahan as $sp): ?>
                                            <option value="<?= $sp['kode']; ?>" <?= ($pegawai['status_pernikahan'] ?? '') == $sp['kode'] ? 'selected' : ''; ?>>
                                                <?= esc($sp['status']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= esc($pegawai['alamat'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= esc($pegawai['no_telp'] ?? ''); ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($pegawai['email'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold mb-3">Informasi Kepegawaian</h5>
                                <hr>
                                <p class="text-muted">Informasi kepegawaian tidak dapat diubah. Hubungi administrator untuk perubahan data kepegawaian.</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <!-- Left Column -->
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" value="<?= esc($pegawai['nama_jabatan'] ?? '-'); ?>" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="unit_kerja" class="form-label">Unit Kerja</label>
                                    <input type="text" class="form-control" id="unit_kerja" value="<?= esc($pegawai['nama_unit_kerja'] ?? '-'); ?>" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="eselon" class="form-label">Eselon</label>
                                    <input type="text" class="form-control" id="eselon" value="<?= esc($pegawai['eselon'] ?? '-'); ?>" readonly>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label for="pangkat" class="form-label">Pangkat/Golongan</label>
                                    <input type="text" class="form-control" id="pangkat" value="<?= esc($pegawai['nama_pangkat'] ?? '-'); ?>" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status_pegawai" class="form-label">Status Pegawai</label>
                                    <input type="text" class="form-control" id="status_pegawai" value="<?= esc($pegawai['status_pegawai_nama'] ?? '-'); ?>" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tmt" class="form-label">TMT</label>
                                    <input type="text" class="form-control" id="tmt" value="<?= esc($pegawai['tmt_formatted'] ?? '-'); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="<?= base_url('profile'); ?>" class="btn btn-outline-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 500;
    }
</style>

<?= $this->endSection(); ?>
