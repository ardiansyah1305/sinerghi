<div class="card shadow-sm mb-3 mr-md-3 flex-shrink-0 referensi-sidebar animate_animated animate_fadeInLeft">



    <div class="row">

        <!-- Sidebar Unit Kerja -->

        <?php foreach ($organisasi as $index => $item): ?>
            <!-- Untuk Parent ID 1 (atau root level) -->
            <?php if ($item['id'] == 1): ?>

                <li class="mb-1 pt-3 align-items-center rounded collapsed fs-4 ps-4 "><a href="<?= site_url('organisasi'); ?>" style="color: black; text-decoration:none">
                        Beranda
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- Bagian Detail yang akan muncul di sebelah kanan -->

    </div>
</div>