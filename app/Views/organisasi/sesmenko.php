<?php foreach ($organisasi as $index => $item): ?>
    <?php if ($item['id'] == 2): ?>
        <li class="mb-1 align-items-center rounded collapsed fs-4 ps-4" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse<?= $item['id'] ?>" aria-expanded="<?= ($currentUnitId == $item['id']) ? 'true' : 'false' ?>">
            <?= $item['nama_unit_kerja'] ?>
            <div class="collapse <?= ($currentUnitId == $item['id']) ? 'show' : '' ?>" id="dashboard-collapse<?= $item['id'] ?>">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">

                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_hukum_persidangan_organisasi_dan_komunikasi">Biro Hukum, Persidangan, Organisasi, dan Komunikasi</a></li>
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_perencanaan_dan_kerjasama">Biro Perencanaan dan Kerjasama</a></li>
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_sistem_informasi_dan_pengelolaan_data">Biro Sistem Informasi dan Pengelolaan Data</a></li>
                    <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="<?= site_url('organisasi/sesmenko/') ?>biro_umum_dan_sumber_daya_manusia">Biro Umum dan Sumber Daya Manusia</a></li>

                    <?php foreach ($organisasi as $index => $item): ?>
                        <!-- Untuk Parent ID 1 (atau root level) -->
                        <?php if ($item['parent_id'] == 3): ?>

                            <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="#"><?= $item['nama_unit_kerja'] ?>
                            <li class="link-dark align-items-center rounded collapsed fs-5 ps-4 mb-2"><a href="menkopmk/<?= $item['nama_unit_kerja'] ?>"><?= $item['nama_unit_kerja'] ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </ul>
            </div>
        </li>
    <?php endif; ?>
<?php endforeach; ?>