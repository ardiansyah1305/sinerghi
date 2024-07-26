<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="slider_section">
    <div id="main_slider" class="carousel slide banner-main" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img-fluid d-block w-100" src="<?= base_url('images/announ1.jpg'); ?>" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="img-fluid d-block w-100" src="<?= base_url('images/announ2.jpg'); ?>" alt="Second slide">
            </div>
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
            <div class="col-md-4 mb-5">
                <a class="small register-link" href="<?= site_url('dashboard/detail_pengumuman1'); ?>">
                    <div class="card custom-card shadow">
                        <img class="card-img-top" src="<?= base_url('images/figure1.png'); ?>" alt="Announcement Image">
                        <div class="card-body text-left">
                            <h5 class="card-title">Pengumuman</h5>
                            <p class="card-text keterangan">Pengumuman APEL PEGAWAI Kemenko PMK....</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-5">
                <a class="small register-link" href="<?= site_url('dashboard/detail_pengumuman2'); ?>">
                    <div class="card custom-card shadow">
                        <img class="card-img-top" src="<?= base_url('images/figure2.png'); ?>" alt="Announcement Image">
                        <div class="card-body text-left">
                            <h5 class="card-title">Pengumuman</h5>
                            <p class="card-text keterangan">Pawai Budaya Kemenko PMK.......</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Pop-up yang berisi carousel gambar -->
<!-- <div class="popup-background" id="popupBackground"></div>
<div class="popup" id="popup">
    <span class="close-btn" id="closePopup">&times;</span>
    <div class="carousel">
        <div class="carousel-image-wrapper">
            <img src="<?= base_url('images/popup1.png'); ?>" class="carousel-slide" alt="Logo 1">
            <img src="<?= base_url('images/popup2.png'); ?>" class="carousel-slide" alt="Logo 2">
        </div>
        <a class="prev" id="prevSlide">&#10094;</a>
        <a class="next" id="nextSlide">&#10095;</a>
    </div>
</div> -->

<div class="popup-background" id="popupBackground"></div>
<div class="popup" id="popup">
    <span class="close-btn" id="closePopup">&times;</span>
    <div class="popup-content">
        <div id="popupCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= base_url('images/popup1.png'); ?>" alt="Survey Digital Image 1" class="d-block w-100">
                </div>
                <div class="carousel-item">
                    <img src="<?= base_url('images/popup2.png'); ?>" alt="Survey Digital Image 2" class="d-block w-100">
                </div>
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



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- JavaScript untuk mengatur pop-up -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popupBackground = document.getElementById('popupBackground');
        const popup = document.getElementById('popup');
        const closePopup = document.getElementById('closePopup');
        const nextSlide = document.getElementById('nextSlide');
        const prevSlide = document.getElementById('prevSlide');
        const slides = document.querySelectorAll('.carousel-slide');
        let currentSlide = 0;

        function showPopup() {
            popupBackground.style.display = 'block';
            popup.style.display = 'block';
        }

        function hidePopup() {
            popupBackground.style.display = 'none';
            popup.style.display = 'none';
        }

        function showSlide(index) {
            slides[currentSlide].style.display = 'none';
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].style.display = 'block';
        }

        nextSlide.addEventListener('click', () => showSlide(currentSlide + 1));
        prevSlide.addEventListener('click', () => showSlide(currentSlide - 1));
        closePopup.addEventListener('click', hidePopup);
        popupBackground.addEventListener('click', hidePopup);

        showPopup();
        showSlide(currentSlide);
    });
</script>

<?= $this->endSection(); ?>
