<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="slider_section">
    <div id="main_slider" class="carousel slide banner-main" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img-fluid d-block w-100" src="images/announ1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="img-fluid d-block w-100" src="images/announ2.jpg" alt="Second slide">
            </div>
        </div>
        <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
            <i class='fa fa-angle-left'></i>
        </a>
        <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
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
            <div class="col-md-3 mb-4">
                <a class="small register-link" href="<?= site_url('dashboard/detail_pengumuman1'); ?>">
                    <div class="card custom-card shadow">
                        <img class="card-img-top" src="images/figure1.png" alt="Announcement Image">
                        <div class="card-body text-left">
                            <h5 class="card-title">Pengumuman</h5>
                            <p class="card-text keterangan">Ini adalah keterangan teks yang berisi informasi penting.......</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a class="small register-link" href="<?= site_url('dashboard/detail_pengumuman2'); ?>">
                    <div class="card custom-card shadow">
                        <img class="card-img-top" src="images/figure2.png" alt="Announcement Image">
                        <div class="card-body text-left">
                            <h5 class="card-title">Pengumuman</h5>
                            <p class="card-text keterangan">Ini adalah keterangan teks yang berisi informasi penting.......</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a class="small register-link" href="<?= site_url('dashboard/detail_pengumuman3'); ?>">
                    <div class="card custom-card shadow">
                        <img class="card-img-top" src="images/figure2.png" alt="Announcement Image">
                        <div class="card-body text-left">
                            <h5 class="card-title">Pengumuman</h5>
                            <p class="card-text keterangan">Ini adalah keterangan teks yang berisi informasi penting.......</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Pop-up yang berisi carousel gambar -->
<div class="popup-background" id="popupBackground"></div>
<div class="popup" id="popup">
    <span class="close-btn" id="closePopup">&times;</span>
    <div class="carousel">
        <div class="carousel-image-wrapper">
            <img src="images/popup1.png" class="carousel-slide" alt="Logo 1">
            <img src="images/popup2.png" class="carousel-slide" alt="Logo 2">
        </div>
        <a class="prev" id="prevSlide">&#10094;</a>
        <a class="next" id="nextSlide">&#10095;</a>
    </div>
</div>

<?= $this->endSection(); ?>
