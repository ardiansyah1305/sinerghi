<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Roboto', sans-serif;
    }

    .full-width-section {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    .slider_section {
        padding-top: 0;
        margin-top: 0;
        background-color: #000957; /* Warna latar belakang slider */
    }

    .slider_section img {
        max-height: 70vh;
        width: 100%;
        object-fit: cover;
    }

    .announcement_section {
        background-color: white;
        padding: 20px 0;
    }

    .announcement_section .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px; /* Mengurangi jarak antar card */
        justify-content: center;
    }

    .announcement_section .card {
        background-color: #fff;
        border: 1px solid #ddd;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        width: 18rem; /* Menyesuaikan lebar card */
        height: 22rem; /* Menyesuaikan tinggi card */
        transition: transform 0.3s ease-in-out;
        margin: 5px; /* Mengurangi margin antar card */
    }

    .announcement_section .card img {
        width: 100%;
        height: 60%; /* Menyesuaikan tinggi gambar dalam card */
        object-fit: cover;
        border-radius: 0;
    }

    .announcement_section .card-title {
        padding: 5px 10px; /* Mengurangi padding untuk lebih rapat */
        font-size: 16px;
        font-weight: bold;
        color: #344CB7; /* Warna teks card title */
        transition: opacity 0.3s ease-in-out;
    }

    .announcement_section .card-body {
        padding: 10px;
        background: rgba(255, 255, 255, 0.9);
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40%; /* Menyesuaikan tinggi body dalam card */
        transform: translateY(100%);
        transition: transform 0.5s ease-in-out;
        text-align: center;
    }

    .announcement_section .card:hover .card-body {
        transform: translateY(-30%);
    }

    .announcement_section .card:hover .card-title {
        opacity: 0;
    }

    .announcement_section .card-body h5,
    .announcement_section .card-body p,
    .announcement_section .card-body .read-more {
        color: #000957; /* Warna teks dalam card */
    }

    .announcement_section .card-body h5 {
        font-size: 16px; /* Menyesuaikan ukuran font */
        font-weight: bold;
        margin-bottom: 5px;
    }

    .announcement_section .card-body p {
        font-size: 14px; /* Menyesuaikan ukuran font */
        margin-bottom: 5px;
    }

    .announcement_section .read-more {
        display: inline-block;
        background-color: #344CB7; /* Warna tombol read more */
        color: #fff;
        font-size: 14px; /* Menyesuaikan ukuran font */
        font-weight: bold;
        text-transform: uppercase;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        text-align: center;
    }

    .announcement_section .read-more:hover {
        background-color: #577BC1; /* Warna hover tombol read more */
        color: #fff;
    }

    .calendar_section {
        background-color: #f1f1f1; /* Warna latar belakang kalender yang lebih tipis */
        padding: 20px 0;
        color: black;
        text-align: center; /* Pusatkan teks */
    }

    .calendar_section h2 {
        font-size: 32px; /* Ukuran font lebih besar */
        font-weight: bold; /* Membuat teks tebal */
        color: white; /* Warna teks kalender */
        margin-bottom: 20px; /* Menambahkan sedikit jarak di bawah teks */
    }

    .announcement_section .text-white {
        color: white;
    }

    .announcement_section h2 {
        font-size: 28px; /* Mengatur ukuran font */
        font-weight: bold; /* Membuat teks tebal */
        color: #000957; /* Warna hitam untuk kontras */
    }

    .announcement_section p {
        color: #6c757d; /* Warna abu-abu untuk teks deskripsi */
        font-size: 16px; /* Mengatur ukuran font deskripsi */
    }

    .top-bar {
        background-color: #0E185F;
        color: white;
        padding: 10px 0;
    }

    .top-bar .contact-info {
        margin: 0;
    }

    .top-bar .social-icons {
        text-align: right;
    }

    .top-bar .social-icons a {
        color: white;
        margin-left: 10px;
    }

    .main-navbar {
        background-color: #F5F5F5;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-weight: bold;
        padding: 10px 0;
    }

    .main-navbar .navbar-nav {
        margin-left: auto;
        margin-right: auto;
    }

    .main-navbar .nav-link {
        color: #000000;
        font-size: 14px;
        transition: color 0.2s ease-in-out;
        position: relative;
        margin-left: 15px;
        margin-right: 15px;
    }

    .main-navbar .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        display: block;
        margin-top: 5px;
        right: 0;
        background: #344CB7;
        transition: width 0.2s ease, background-color 0.2s ease;
    }

    .main-navbar .nav-link:hover::after {
        width: 100%;
        left: 0;
        background: #344CB7;
    }

    .main-navbar .nav-link:hover {
        color: #344CB7;
        background: none;
    }

    .main-navbar .dropdown-menu {
        background-color: #f8f9fa;
        border: none;
    }

    .btn-outline-danger {
        background-color: #344CB7; /* Warna tombol logout */
        color: #fff;
        border-color: #344CB7;
        font-weight: bold;
        font-size: 14px;
        padding: 5px 10px;
    }

    .btn-outline-danger:hover {
        background-color: #577BC1; /* Warna hover tombol logout */
        color: white;
    }

    .navbar-brand,
    .navbar-nav .nav-item {
        background: none !important;
    }

    @media (max-width: 991.98px) {
        .top-bar .contact-info,
        .top-bar .social-icons {
            text-align: center;
            padding-bottom: 5px;
        }

        .user-box {
            text-align: center;
            margin-bottom: 5px;
        }

        .navbar-collapse {
            text-align: center;
        }

        .navbar-collapse .btn-outline-danger {
            width: 100%;
            margin-top: 5px;
        }

        .navbar-collapse .nav-link {
            font-size: 12px;
        }

        .navbar-collapse .nav-item {
            margin-bottom: 5px;
        }
    }

    /* Custom CSS for FullCalendar */
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 20px;
        color: #333; /* Warna teks toolbar */
    }

    .fc .fc-daygrid-day-number {
        color: #000957; /* Warna nomor hari */
        font-weight: bold;
    }

    .fc .fc-event {
        background-color: #344CB7;
        color: #fff;
        border: none;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px; /* Ukuran font event lebih kecil */
    }

    .fc .fc-daygrid-day-frame {
        border: 1px solid #ddd;
        background-color: #f8f9fa; /* Warna latar belakang yang lebih lembut */
    }

    .fc-theme-standard td, .fc-theme-standard th {
        border: 1px solid #ddd;
    }

    .fc-day-today {
        background-color: #e0e0e0 !important; /* Warna latar belakang hari ini */
    }

    .fc .fc-highlight {
        background: #344CB7;
        opacity: 0.3;
    }

    .swal2-popup {
        font-size: 1rem !important; /* Ukuran font lebih kecil */
        font-family: 'Roboto', sans-serif;
    }
</style>

<section class="slider_section full-width-section">
    <div id="main_slider" class="carousel slide banner-main" data-bs-ride="carousel">
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
        <button class="carousel-control-prev" type="button" data-bs-target="#main_slider" data-bs-slide="prev">
            <span class='carousel-control-prev-icon' aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#main_slider" data-bs-slide="next">
            <span class='carousel-control-next-icon' aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<section class="announcement_section full-width-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2>Berita Terbaru</h2>
            <p>Berita terkini berkaitan dengan Produk Hukum dari Kemenko PMK.</p>
        </div>
        <div class="card-container">
            <?php foreach ($cards as $announcement): ?>
                <div class="card custom-card shadow">
                    <img class="card-img-top" src="<?= base_url('img/' . $announcement['image']); ?>" alt="Announcement Image">
                    <h5 class="card-title"><?= $announcement['title']; ?></h5>
                    <div class="card-body text-left">
                        <h5><?= $announcement['title']; ?></h5>
                        <p class="card-text"><?= $announcement['short_description']; ?></p>
                        <a href="<?= site_url('dashboard/detail_pengumuman/' . $announcement['id']); ?>" class="read-more">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="calendar_section full-width-section">
    <div class="container">
        <h2>Kalender Penting</h2>
        <div id="calendar"></div>
    </div>
</section>

<!-- Pop-up yang berisi carousel gambar -->
<div class="popup-background" id="popupBackground"></div>
<div class="popup" id="popup">
    <span class="close-btn" id="closePopup">&times;</span>
    <div class="popup-content">
        <div id="popupCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($popups as $index => $popup): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                        <img src="<?= base_url('img/' . $popup['image']); ?>" alt="Popup Image" class="d-block w-100">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#popupCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#popupCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <button id="closePopupButton" class="btn btn-primary floating-button">Tutup</button>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- Menambahkan FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

<!-- Menambahkan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript untuk mengatur pop-up dan kalender -->
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

        // Inisialisasi Kalender
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap', // Menambahkan tema Bootstrap
            events: <?= json_encode($calenders) ?>,
            eventClick: function(info) {
                Swal.fire({
                    title: info.event.title,
                    text: info.event.extendedProps.description,
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            }
        });
        calendar.render();

        // Tambahkan log untuk memeriksa data calenders di browser
        console.log('Calenders: ', <?= json_encode($calenders) ?>);
    });
</script>

<?= $this->endSection(); ?>
