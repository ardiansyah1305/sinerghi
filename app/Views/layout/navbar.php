<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Site Meta Tags -->
    <title>PMK</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- Favicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />

    <!-- Additional CSS for Custom Scrollbar and Font Awesome -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <style>
        .user-box {
            text-align: right;
            font-size: 16px;
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
            max-height: 50px;
        }

        .top-bar {
            background-color: #32C2B8;
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
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Menambahkan shadow pada navbar */
        }

        .main-navbar .nav-link {
            color: #000;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.2s ease-in-out;
            position: relative;
        }

        .main-navbar .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            display: block;
            margin-top: 5px;
            right: 0;
            background: #32C2B8;
            transition: width 0.2s ease, background-color 0.2s ease;
        }

        .main-navbar .nav-link:hover::after {
            width: 100%;
            left: 0;
            background: #32C2B8;
        }

        .main-navbar .nav-link:hover {
            color: #32C2B8;
            background: none;
        }

        .main-navbar .dropdown-menu {
            background-color: #f8f9fa;
            border: none;
        }

        .btn-outline-danger {
            background-color: #32C2B8;
            color: #000;
            border-color: #32C2B8;
            font-weight: bold;
        }

        .btn-outline-danger:hover {
            background-color: #32C2B8;
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
                padding-bottom: 10px;
            }

            .user-box {
                text-align: center;
                margin-bottom: 10px;
            }

            .navbar-collapse {
                text-align: center;
            }

            .navbar-collapse .btn-outline-danger {
                width: 100%;
                margin-top: 10px;
            }

            .navbar-collapse .nav-link {
                font-size: 16px;
            }

            .navbar-collapse .nav-item {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body class="main-layout">
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
                <img src="images/logokmk.png" alt="logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item d-lg-none">
                        <span class="nav-link">Holaa, <?= esc(explode('@', $username)[0]) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= site_url('dashboard'); ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('organisasi'); ?>">Organisasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('layanan'); ?>">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('referensi'); ?>">Referensi</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="<?= site_url('logout'); ?>">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="d-none d-lg-flex align-items-center">
                <div class="user-box me-3">
                    <span>Holaa, <?= esc(explode('@', $username)[0]) ?></span>
                </div>
                <a href="<?= site_url('logout'); ?>" class="btn btn-outline-danger ms-3">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
