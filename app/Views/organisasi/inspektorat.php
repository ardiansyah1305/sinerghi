<?php foreach ($organisasi as $index => $item): ?>
    <?php if ($item['id'] == 4): ?>
        <li class="mb-1 pt-3 align-items-center rounded collapsed fs-4 ps-4">
            <a href="<?= site_url('menkopmk/inspektorat'); ?>" style="color: black; text-decoration:none">
                <?= $item['nama_unit_kerja'] ?>
            </a>
        </li>
    <?php endif; ?>
<?php endforeach; ?>