<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<!-- Banner -->
<div class="announcement-banner">
    <img src="<?= base_url('images/beritaback.jpg'); ?>" alt="Banner Image" class="banner-image">
    <div class="banner-content">
        <span class="banner-text">Daftar Pustaka</span>
    </div>
</div>

<div class="container-fluid p-0">
    <div class="row no-gutters">
        <div class="col-12 referensi-container">
            <!-- Pencarian -->
            <div class="input-group mb-4 referensi-search">
                <button type="button" class="btn btn-outline-secondary referensi-btn-back" id="backButton">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <input type="search" id="searchInput" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="button" class="btn btn-outline-primary referensi-btn-search" id="searchButton">Search</button>
            </div>

            <div class="d-flex flex-column flex-md-row">
                <!-- Sidebar Kiri -->
                <div class="card shadow-sm mb-3 mr-md-3 flex-shrink-0 referensi-sidebar animate__animated animate__fadeInLeft">
                    <div class="card-header bg-referensi text-white">
                        <h4 class="card-title mb-0">Daftar Pustaka</h4>
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
                        <div class="category-content animate__animated animate__fadeInUp" data-category-id="<?= $parentId ?>" style="<?= $parentId == $firstCategoryId ? 'display: block;' : 'display: none;' ?>">
                            <?php foreach ($group as $card): ?>
                                <div class="card mb-3 shadow-sm referensi-card animate__animated animate__fadeInUp" data-title="<?= strtolower($card['judul']) ?>" data-description="<?= strtolower($card['deskripsi']) ?>">
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
</div>

<!-- Script untuk Mengelola Pencarian dan Tombol Back -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryLinks = document.querySelectorAll('.list-group-item');
        const categoryContents = document.querySelectorAll('.category-content');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const backButton = document.getElementById('backButton');

        if (categoryContents.length > 0) {
            categoryContents[0].style.display = 'block';
        }

        categoryLinks.forEach(link => {
            link.addEventListener('click', function () {
                const categoryId = this.getAttribute('data-category-id');

                categoryContents.forEach(content => {
                    if (content.getAttribute('data-category-id') === categoryId) {
                        content.style.display = 'block';
                        content.classList.add('animate__animated', 'animate__fadeIn');
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate__animated', 'animate__fadeIn');
                    }
                });

                categoryLinks.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            });
        });

        searchButton.addEventListener('click', function () {
            const query = searchInput.value.toLowerCase();

            if (query === '') {
                categoryContents.forEach(content => {
                    content.style.display = 'block';
                    content.classList.add('animate__animated', 'animate__fadeIn');
                    const cards = content.querySelectorAll('.referensi-card');
                    cards.forEach(card => {
                        card.style.display = 'block';
                    });
                });
                categoryLinks.forEach((link, index) => {
                    link.classList.toggle('active', index === 0);
                });
            } else {
                let found = false;

                categoryContents.forEach(content => {
                    const cards = content.querySelectorAll('.referensi-card');
                    let cardFound = false;

                    cards.forEach(card => {
                        const title = card.getAttribute('data-title');
                        if (title.includes(query)) {
                            card.style.display = 'block';
                            cardFound = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (cardFound) {
                        content.style.display = 'block';
                        content.classList.add('animate__animated', 'animate__fadeIn');
                        found = true;
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate__animated', 'animate__fadeIn');
                    }
                });

                categoryLinks.forEach(link => {
                    link.style.display = 'block';
                    link.classList.remove('active');
                });

                if (!found) {   
                    alert('No results found');
                }
            }
        });

        backButton.addEventListener('click', function () {
            searchInput.value = '';
            categoryContents.forEach(content => {
                content.style.display = 'block';
                content.classList.add('animate__animated', 'animate__fadeIn');
                const cards = content.querySelectorAll('.referensi-card');
                cards.forEach(card => {
                    card.style.display = 'block';
                });
            });
            categoryLinks.forEach((link, index) => {
                link.classList.toggle('active', index === 0);
            });
        });

        searchInput.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                searchButton.click();
            }
        });
    });
</script>

<?= $this->endSection(); ?>
