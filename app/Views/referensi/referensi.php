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
                        <?php foreach ($contents as $key => $group): ?>
                            <?php if (!empty($group)): ?>
                                <a class="list-group-item list-group-item-action" data-target="#<?= $key ?>"><?= $group[0]['judul'] ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Konten Kanan -->
                <div class="flex-grow-1">
                    <div class="content-wrapper">
                        <?php foreach ($contents as $key => $group): ?>
                            <?php if (!empty($group)): ?>
                                <div id="<?= $key ?>" class="content-section <?= $key == 'content1' ? 'active' : '' ?>">
                                    <?php foreach ($group as $card): ?>
                                        <div class="card mb-3 shadow-sm content-card" data-title="<?= strtolower($card['judul']) ?>" data-description="<?= strtolower($card['deskripsi']) ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $card['judul'] ?></h5>
                                                <p class="card-text"><?= $card['deskripsi'] ?></p>
                                                <p class="card-text"><small class="text-muted"><?= $card['unit_terkait'] ?></small></p>
                                                <p class="card-text"><small class="text-muted"><?= $card['tanggal'] ?></small></p>
                                                <div class="d-flex">
                                                    <a href="<?= base_url('uploads/pdf/' . $card['file_upload']) ?>" class="btn btn-primary me-2" target="_blank">Lihat</a>
                                                    <a href="<?= base_url('uploads/pdf/' . $card['file_upload']) ?>" class="btn btn-danger" download>Download</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
