<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
    <!-- Pencarian -->
    <div class="input-group mb-4" style="max-width: 800px; margin: auto;">
        <input type="search" id="searchInput" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <button type="button" class="btn btn-outline-primary" id="searchButton">Search</button>
    </div>

    <div class="row">
        <!-- Konten Utama -->
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row">
                <!-- Sidebar Kiri -->
                <div class="card shadow-sm mb-3 mr-md-3 flex-shrink-0" style="width: 300px;">
                    <div class="card-header bg-custom text-white">
                        <h4 class="card-title mb-0">Daftar Referensi</h4>
                    </div>
                    <div class="list-group list-group-flush" id="temaList">
                        <a class="list-group-item list-group-item-action" data-target="#content1">Peningkatan Kesejahteraan Nasional</a>
                        <a class="list-group-item list-group-item-action" data-target="#content2">Pemerataan Pembangunan Wilayah Dan Penanggulangan Bencana</a>
                        <a class="list-group-item list-group-item-action" data-target="#content3">Peningkatan Kualitas Kesehatan Dan Pembangunan Kependudukan</a>
                        <a class="list-group-item list-group-item-action" data-target="#content4">Pengembangan Infrastruktur dan Teknologi</a>
                    </div>
                </div>
                <!-- Konten Kanan -->
                <div class="flex-grow-1">
                    <div class="content-wrapper">
                        <?php foreach ($contents as $contentId => $cards): ?>
                            <div id="<?= $contentId ?>" class="content-section <?= $contentId == 'content1' ? 'active' : '' ?>">
                                <?php foreach ($cards as $card): ?>
                                    <div class="card mb-3 shadow-sm content-card" data-title="<?= strtolower($card['title']) ?>" data-description="<?= strtolower($card['description']) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $card['title'] ?></h5>
                                            <p class="card-text"><?= $card['description'] ?></p>
                                            <p class="card-text"><small class="text-muted"><?= $card['meta'] ?></small></p>
                                            <p class="card-text"><small class="text-muted"><?= $card['date'] ?></small></p>
                                            <a href="<?= $card['file'] ?>" class="btn btn-primary" target="_blank">Lihat</a>
                                            <a href="<?= $card['file'] ?>" class="btn btn-danger" download>Download</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
