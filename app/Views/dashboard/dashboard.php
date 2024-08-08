<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>


<section class="slider_section full-width-section">
    <div id="main_slider" class="carousel slide banner-main" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($sliders as $index => $slider): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <img class="img-fluid d-block w-100" src="<?= base_url('img/' . $slider['image']); ?>" alt="Slide Image">
                    <div class="carousel-caption d-none d-md-block">
                        
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
                    <h5 class="card-title"><?= $announcement['title']; ?></h5> <!-- Pastikan judul ada di sini -->
                    <div class="card-body">
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
