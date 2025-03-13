<?php 
helper(['encrypt']);
?>
<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4"><?= $title; ?></h2>
    <?php if(session()->get('role_id') == 1 || session()->get('role_id') == 2) : ?>
    <?php if (!empty($new_proposals)): ?>
    <div class="card shadow rounded-4 mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0 text-dark"><i class="bi bi-bell-fill"></i> Usulan Baru yang Memerlukan Perhatian</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center align-middle" style="width: 50px;">No</th>
                            <th class="text-center align-middle">Unit ES 1</th>
                            <th class="text-center align-middle">Unit Pengusul</th>
                            <th class="text-center align-middle">Nama Pengusul</th>
                            <th class="text-center align-middle">Bulan</th>
                            <th class="text-center align-middle" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($new_proposals as $proposal) : ?>
                            <tr>
                                <td class="text-center align-middle"><?= $i++; ?></td>
                                <td class="align-middle"><?= $proposal['parent_unit_name']; ?></td>
                                <td class="align-middle"><?= $proposal['nama_unit']; ?></td>
                                <td class="align-middle"><?= $proposal['nama_pengusul']; ?></td>
                                <td class="text-center align-middle">
                                <?php
                                $bulan = date('m', strtotime($proposal['bulan']));
                                $tahun = date('Y', strtotime($proposal['bulan']));
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
                                    <div class="d-flex justify-content-center">
                                        <?php if($proposal['parent_unit_id'] == 2) : ?>
                                        <a href="<?= site_url('admin/penugasan/daftar-usulan/' . encrypt_url($proposal['unit_kerja_id'])); ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php else: ?>
                                        <a href="<?= site_url('admin/penugasan/daftar-usulan/' . encrypt_url($proposal['parent_unit_id'])); ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-building"></i> Daftar Unit Eselon 1</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center align-middle" style="width: 80px;">No</th>
                        <th class="text-center align-middle">Nama Unit Eselon 1</th>
                        <th class="text-center align-middle" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($unit_eselon_1 as $unit) : ?>
                        <tr>
                            <td class="text-center align-middle"><?= $i++; ?></td>
                            <td class="align-middle"><?= $unit['nama_unit_kerja']; ?></td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    <?php if ($unit['id'] == 2) : ?>
                                        <a href="<?= site_url('admin/penugasan/daftar-unit/' . encrypt_url($unit['id'])); ?>" class="btn btn-success btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= site_url('admin/penugasan/daftar-usulan/' . encrypt_url($unit['id'])); ?>" class="btn btn-success btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($unit_eselon_1)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-3">Tidak ada unit yang tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>