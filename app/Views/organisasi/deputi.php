<?php foreach ($organisasi as $index => $item): ?>
    <?php if ($item['id'] == 5): ?>
        <li class="mb-1 <?= ($currentUnitId == $item['id']) ? 'active' : '' ?>">
            <button class="btn btn-toggle align-items-center rounded collapsed fs-4 ps-4 <?= ($currentUnitId == $item['id']) ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse<?= $item['id'] ?>" aria-expanded="<?= ($currentUnitId == $item['id']) ? 'true' : 'false' ?>">
                <?= $item['nama_unit_kerja'] ?>
            </button>
            <div class="collapse <?= ($currentUnitId == $item['id']) ? 'show' : '' ?>" id="dashboard-collapse<?= $item['id'] ?>">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_hukum_persidangan_organisasi_dan_komunikasi">Biro Hukum, Persidangan, Organisasi, dan Komunikasi</a></li>
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_perencanaan_dan_kerjasama">Biro Perencanaan dan Kerjasama</a></li>
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_sistem_informasi_dan_pengelolaan_data">Biro Sistem Informasi dan Pengelolaan Data</a></li>
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_umum_dan_sumber_daya_manusia">Biro Umum dan Sumber Daya Manusia</a></li>
                </ul>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach; ?>