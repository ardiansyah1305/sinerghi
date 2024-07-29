// app/Views/dashboard/dashboard.php
<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="slider_section">
    <div id="main_slider" class="carousel slide banner-main" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($sliders as $index => $slider): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <img class="img-fluid d-block w-100" src="<?= base_url('img/' . $slider['image']); ?>" alt="Slide Image">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= $slider['title']; ?></h5>
                        <p><?= isset($slider['description']) ? $slider['description'] : 'Description not available'; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
            <i class='fa fa-angle-left'></i>
        </a>
        <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
            <i class='fa fa-angle-right'></i>
        </a>
    </div>
</section>

<section class="announcement_section">
    <div class="container">
        <div class="text-center mb-4">
            <h2>Berita Terbaru</h2>
            <p>Berita terkini berkaitan dengan Produk Hukum dari Kemenko PMK.</p>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($cards as $announcement): ?>
                <div class="col-md-4 mb-5">
                    <a class="small register-link" href="<?= site_url('dashboard/detail_pengumuman/' . $announcement['id']); ?>">
                        <div class="card custom-card shadow">
                            <img class="card-img-top" src="<?= base_url('img/' . $announcement['image']); ?>" alt="Announcement Image">
                            <div class="card-body text-left">
                                <h5 class="card-title"><?= $announcement['title']; ?></h5>
                                <p class="card-text keterangan"><?= $announcement['description']; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Pop-up yang berisi carousel gambar -->
<div class="popup-background" id="popupBackground"></div>
<div class="popup" id="popup">
    <span class="close-btn" id="closePopup">&times;</span>
    <div class="popup-content">
        <div id="popupCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($popups as $index => $popup): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                        <img src="<?= base_url('img/' . $popup['image']); ?>" alt="Popup Image" class="d-block w-100">
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#popupCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#popupCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <button id="closePopupButton" class="btn btn-primary floating-button">Tutup</button>
    </div>
</div>

<!-- Menambahkan Bootstrap dan jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- JavaScript untuk mengatur pop-up -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popupBackground = document.getElementById('popupBackground');
        const popup = document.getElementById('popup');
        const closePopupButton = document.getElementById('closePopupButton');

        function showPopup() {
            popupBackground.style.display = 'block';
            popup.style.display = 'block';
        }

        function hidePopup() {
            popupBackground.style.display = 'none';
            popup.style.display = 'none';
        }

        closePopupButton.addEventListener('click', hidePopup);
        popupBackground.addEventListener('click', hidePopup);

        showPopup();
    });
</script>

<?= $this->endSection(); ?>
