<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-4 py-3 px-md-5 py-md-4">
    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-4 text-uppercase">Profil Pegawai</h3>
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Profile Photo Column -->
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="profile-photo-container mb-3">
                                <?php if (!empty($pegawai['foto']) && file_exists(FCPATH . 'uploads/pegawai/' . $pegawai['foto'])): ?>
                                    <img src="<?= base_url('uploads/pegawai/' . $pegawai['foto']); ?>" class="img-fluid rounded-circle profile-photo" alt="Foto Profil">
                                <?php else: ?>
                                    <div class="profile-photo-placeholder rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-fill" style="font-size: 5rem;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4 class="fw-bold mb-1"><?= esc($pegawai['nama']); ?></h4>
                            <p class="text-muted mb-2"><?= esc($pegawai['nip']); ?></p>
                            <div class="badge bg-primary mb-3 text-wrap" style="max-width: 200px; white-space: normal; text-align: center; display: inline-block; line-height: 1.5;"><?= esc($pegawai['nama_jabatan'] ?? '-'); ?></div>
                        </div>
                        
                        <!-- Profile Details Column -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Tempat, Tanggal Lahir</h6>
                                        <p class="mb-0 fw-medium">
                                            <?= esc($pegawai['tempat_lahir'] ?? '-'); ?>, 
                                            <?= esc($pegawai['tanggal_lahir_formatted'] ?? '-'); ?>
                                        </p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Jenis Kelamin</h6>
                                        <p class="mb-0 fw-medium">
                                            <?php if ($pegawai['jenis_kelamin'] == 'L'): ?>
                                                Laki-laki
                                            <?php elseif ($pegawai['jenis_kelamin'] == 'P'): ?>
                                                Perempuan
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Agama</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['nama_agama'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Status Pernikahan</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['status_pernikahan_nama'] ?? '-'); ?></p>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Alamat</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['alamat'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">No. Telepon</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['no_telp'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Email</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['email'] ?? '-'); ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-12 mb-4">
                                    <h5 class="fw-bold mb-3">Informasi Kepegawaian</h5>
                                    <hr>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Jabatan</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['nama_jabatan'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Unit Kerja</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['nama_unit_kerja'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Eselon</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['eselon'] ?? '-'); ?></p>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Pangkat/Golongan</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['nama_pangkat'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">Status Pegawai</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['status_pegawai_nama'] ?? '-'); ?></p>
                                    </div>
                                    
                                    <div class="profile-info-item mb-3">
                                        <h6 class="text-muted mb-1">TMT</h6>
                                        <p class="mb-0 fw-medium"><?= esc($pegawai['tmt_formatted'] ?? '-'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-photo-container {
        width: 150px;
        height: 150px;
        margin: 0 auto;
    }
    
    .profile-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .profile-photo-placeholder {
        width: 100%;
        height: 100%;
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    .profile-info-item h6 {
        font-size: 0.8rem;
    }
    
    .profile-info-item p {
        font-size: 1rem;
    }
    
    .fw-medium {
        font-weight: 500;
    }
</style>

<?= $this->endSection(); ?>
