<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="referensi-container mt-4">
    <!-- Pencarian -->
    <div class="input-group mb-4 referensi-search">
        <input type="search" id="searchInput" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <button type="button" class="btn btn-outline-primary referensi-btn-search" id="searchButton">Search</button>
    </div>

    <div class="row">
        <!-- Konten Utama -->
        <div class="col-12 d-flex flex-column flex-md-row">
            <!-- Sidebar Kiri -->
            <div class="card shadow-sm mb-3 mr-md-3 flex-shrink-0 referensi-sidebar">
                <div class="card-header bg-referensi text-white">
                    <h4 class="card-title mb-0">Daftar Referensi</h4>
                </div>
                <div class="list-group list-group-flush" id="temaList">
                    <?php $firstCategoryId = $categories[0]['id']; ?>
                    <?php foreach ($categories as $index => $category): ?>
                        <a class="list-group-item list-group-item-action<?= $index === 0 ? ' active' : '' ?>" data-category-id="<?= $category['id'] ?>"><?= $category['judul'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Konten Kanan -->
            <div class="flex-grow-1 referensi-content">
                <?php foreach ($groupedContents as $parentId => $group): ?>
                    <div class="category-content" data-category-id="<?= $parentId ?>" style="<?= $parentId == $firstCategoryId ? 'display: block;' : 'display: none;' ?>">
                        <?php foreach ($group as $card): ?>
                            <div class="card mb-3 shadow-sm referensi-card" data-title="<?= strtolower($card['judul']) ?>" data-description="<?= strtolower($card['deskripsi']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $card['judul'] ?></h5>
                                    <p class="card-text"><?= $card['deskripsi'] ?></p>
                                    <p class="card-text"><small class="text-muted"><?= $card['unit_terkait'] ?></small></p>
                                    <p class="card-text"><small class="text-muted"><?= $card['tanggal'] ?></small></p>
                                    <div class="d-flex">
                                        <a href="<?= site_url('referensi/viewFile/' . $card['file_upload']); ?>" class="btn btn-referensi-primary me-2" target="_blank">Lihat</a>
                                        <a href="<?= site_url('referensi/downloadFile/' . $card['file_upload']); ?>" class="btn btn-referensi-danger">Download</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryLinks = document.querySelectorAll('.list-group-item');
        const categoryContents = document.querySelectorAll('.category-content');

        // Display the content of the first category by default
        if (categoryContents.length > 0) {
            categoryContents[0].style.display = 'block';
        }

        categoryLinks.forEach(link => {
            link.addEventListener('click', function () {
                const categoryId = this.getAttribute('data-category-id');

                categoryContents.forEach(content => {
                    if (content.getAttribute('data-category-id') === categoryId) {
                        content.style.display = 'block';
                    } else {
                        content.style.display = 'none';
                    }
                });

                categoryLinks.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>

<?= $this->endSection(); ?>
