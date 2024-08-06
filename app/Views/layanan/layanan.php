<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    /* CSS untuk tampilan halaman layanan */
    .background-dark-section1, .background-dark-section3 {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .background-dark-section2 {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
    }

    .service-item {
        cursor: pointer;
        transition: transform 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .service-item:hover {
        transform: scale(1.05);
    }

    .modal-content {
        background-color: rgba(255, 255, 255, 0.9);
    }

    .modal-title {
        color: #000000 !important;
        font-size: 35px;
    }

    .modal-body h5 {
        font-size: 18px;
    }

    .modal-body a {
        font-size: 25px;
    }

    .fa-3x {
        font-size: 3em;
    }

    .font-weight-bold {
        font-weight: bold;
    }

    .custom-text {
        color: #000000 !important;
        font-weight: bold;
        font-size: 24px;
    }

    @media (max-width: 767px) {
        .service-item {
            margin-bottom: 20px;
        }
    }

    /* CSS untuk tampilan navbar */
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Roboto', sans-serif;
    }

    .user-box {
        font-size: 14px;
        color: #000;
        background: none !important;
        margin-right: 10px;
    }

    .user-box a {
        color: #000;
        text-decoration: none;
        background: none !important;
    }

    .navbar-brand img {
        max-height: 40px;
    }

    .top-bar {
        background-color: #000957; /* Warna latar belakang top bar */
        color: white;
        padding: 5px 0;
    }

    .top-bar .contact-info {
        margin: 0;
        color: white; /* Warna teks contact info */
    }

    .top-bar .social-icons {
        text-align: right;
    }

    .top-bar .social-icons a {
        color: #EBE645; /* Warna ikon social media */
        margin-left: 10px;
    }

    .main-navbar {
        background-color: #344CB7; /* Warna latar belakang navbar */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-weight: bold;
        padding: 10px 0;
    }

    .main-navbar .navbar-nav {
        margin-left: auto;
        margin-right: auto;
    }

    .main-navbar .nav-link {
        color: #FFFFFF; /* Warna teks link navbar */
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
        background: #EBE645; /* Warna garis bawah link navbar */
        transition: width 0.2s ease, background-color 0.2s ease;
    }

    .main-navbar .nav-link:hover::after {
        width: 100%;
        left: 0;
        background: #EBE645; /* Warna garis bawah link navbar saat hover */
    }

    .main-navbar .nav-link:hover {
        color: #EBE645; /* Warna teks link navbar saat hover */
        background: none;
    }

    .main-navbar .dropdown-menu {
        background-color: #f8f9fa;
        border: none;
    }

    .btn-outline-danger {
        background-color: #577BC1; /* Warna tombol logout */
        color: #fff;
        border-color: #577BC1;
        font-weight: bold;
        font-size: 14px;
        padding: 5px 10px;
    }

    .btn-outline-danger:hover {
        background-color: #344CB7; /* Warna hover tombol logout */
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
</style>

<?php
$sections = [
    'Layanan ASN' => 'background-dark-section1',
    'Administrasi Layanan ASN' => 'background-dark-section2',
    'Layanan IT' => 'background-dark-section3',
];
foreach ($sections as $sectionName => $sectionClass): 
    $filteredLayanan = array_filter($layanan, function($item) use ($sectionName) {
        return $item['kategori_name'] === $sectionName;
    });
?>
    <div class="<?= $sectionClass ?>">
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h6 class="custom-text"><?= $sectionName ?></h6>
                </div>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($filteredLayanan as $index => $card): ?>
                        <div class="col-md-6 col-lg-3 wow fadeInUp mb-4" data-wow-delay="0.1s">
                            <div class="service-item rounded overflow-hidden" data-bs-toggle="modal" data-bs-target="#serviceModal-<?= $card['id'] ?>" style="height: 210px;">
                                <div style="background-color: <?= $card['color'] ?>; height: 100px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa <?= $card['icon'] ?> fa-3x text-white"></i>
                                </div>
                                <div class="position-relative p-4 pt-2 text-center">
                                    <h4 class="mb-0 font-weight-bold"><?= $card['title'] ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="serviceModal-<?= $card['id'] ?>" tabindex="-1" aria-labelledby="serviceModalLabel-<?= $card['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="serviceModalLabel-<?= $card['id'] ?>"><?= $card['title'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5 class="modal-text">Link Terkait</h5>
                                        <ul class="modal-text">
                                            <?php $links = json_decode($card['links'], true); ?>
                                            <?php if (is_array($links)): ?>
                                                <?php foreach ($links as $link): ?>
                                                    <li><a href="<?= $link['url'] ?>" class="tooltip-test modal-text" title="<?= $link['name'] ?>"><?= $link['name'] ?></a></li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('.tooltip-test').tooltip();
    });
</script>

<?= $this->endSection() ?>
