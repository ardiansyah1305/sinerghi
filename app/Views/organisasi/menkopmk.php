<!-- Sidebar Unit Kerja -->
<ul class="list-unstyled ps-0">
    <?php foreach ($organisasi as $index => $item): ?>
        <!-- Untuk Parent ID 1 (atau root level) -->
        <?php if ($item['id'] == 1): ?>
            <li class="mb-1 pt-3 align-items-center rounded collapsed fs-4 ps-4 "><a href="<?= site_url('organisasi/menkopmk/menteri'); ?>" style="color: black; text-decoration:none">
                    <?= $item['nama_unit_kerja'] ?>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>