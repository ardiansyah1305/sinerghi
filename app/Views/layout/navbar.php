<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Site Meta Tags -->
    <title>PMK</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/responsive.css'); ?>">

    <!-- Additional CSS for Custom Scrollbar and Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('css/jquery.mCustomScrollbar.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
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
</head>

<main>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 contact-info">
                    <i class="fas fa-envelope"></i> test@testing.go.id
                    <i class="fas fa-phone-alt"></i> (+62) 21 345 9444
                </div>
                <div class="col-md-6 social-icons">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light main-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="<?= base_url('images/logokmk.png'); ?>" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard'); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('organisasi'); ?>">Organisasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('layanan'); ?>">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('referensi'); ?>">Pustaka</a>
                    </li>
                </ul>
                <div class="d-none d-lg-flex align-items-center ms-auto">
                    <div class="user-box me-3">
                        <span>Holaa, <?= esc(session()->get('nama')) ?></span>
                    </div>
                    <a href="<?= site_url('logout'); ?>" class="btn btn-outline-danger ms-3">Logout</a>
                </div>
            </div>
        </div>
    </nav>
</main>

<!-- Additional Scripts -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>

</html>
