<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi Kemenko PMK</title>

    <!-- Include Splide CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .org-title {
            text-align: center;
            color: #3a595c;
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .org-info {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .org-info img {
            width: 200px;
            height: 200px;
            margin-right: 40px;
            border: 1px solid #ccc;
            padding: 10px;
            object-fit: cover;
            border-radius: 8px;
        }

        .org-info div {
            max-width: 700px;
        }

        .org-info h2 {
            margin: 0;
            color: #3a595c;
            font-size: 28px;
            font-weight: bold;
        }

        .org-info p {
            color: #2c3e50;
            font-size: 18px;
            line-height: 1.6;
            margin-top: 20px;
            text-align: justify;
        }

        .splide__slide {
            margin: 0 10px;
            /* Add margin to create space between cards */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .splide__slide img {
            display: block;
            margin: 20px auto 10px auto;
            /* Add margin-top and center the image */
            width: 100%;
            max-height: 120px;
            max-width: 80px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .splide__slide .card-body {
            padding: 10px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 0 0 8px 8px;
            margin-top: 5px;
        }

        .splide__slide .card-text {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
            word-wrap: break-word;
            display: block;
            text-align: center;
        }

        .splide__slide:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .org-info {
                flex-direction: column;
                text-align: center;
            }

            .org-info img {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .org-info div {
                max-width: 100%;
            }

            .org-info h2 {
                font-size: 24px;
            }

            .org-info p {
                font-size: 16px;
            }

            .splide__slide .card-text {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .org-title {
                font-size: 24px;
            }

            .org-info h2 {
                font-size: 20px;
            }

            .org-info p {
                font-size: 14px;
            }

            .splide__slide .card-text {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="org-title">Struktur Organisasi Kemenko PMK</h1>
        <div class="org-info">
            <img src="images/muhadjir-effendy.jpg" alt="FOTO MENKO PMK">
            <div>
                <h2>Menteri Koordinator Bidang Manusia dan Kebudayaan</h2>
                <p>Prof. Dr. Muhadjir Effendy, M.A.P. adalah Menteri Koordinator Bidang Pembangunan Manusia dan Kebudayaan sejak 23 Oktober 2019 pada Kabinet Indonesia Maju Jokowi-Ma'ruf Amin. Beliau lahir di Madiun, tanggal 29 Juli 1956.</p>
            </div>
        </div>
        <div id="splide" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <!-- <a href="<?= base_url('deputi_empat') ?>" class="card"> -->
                        <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                        <div class="card-body">
                            <p class="card-text">Sesmenko PMK</p>
                        </div>
                        </a>
                    </li>
                    <li class="splide__slide">
                        <a href="<?= base_url('deputi_satu') ?>" class="card">
                            <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                            <div class="card-body">
                                <p class="card-text">Deputi I</p>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide">
                        <a href="<?= base_url('deputi_dua') ?>" class="card">
                            <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                            <div class="card-body">
                                <p class="card-text">Deputi II</p>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide">
                        <a href="<?= base_url('deputi_tiga') ?>" class="card">
                            <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                            <div class="card-body">
                                <p class="card-text">Deputi III</p>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide">
                        <a href="<?= base_url('deputi_empat') ?>" class="card">
                            <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                            <div class="card-body">
                                <p class="card-text">Deputi IV</p>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide">
                        <a href="<?= base_url('deputi_lima') ?>" class="card">
                            <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                            <div class="card-body">
                                <p class="card-text">Deputi V</p>
                            </div>
                        </a>
                    </li>
                    <li class="splide__slide">
                        <a href="<?= base_url('deputi_enam') ?>" class="card">
                            <img src="images/andie_megantara.png" alt="Sekretariat Kementerian Koordinator">
                            <div class="card-body">
                                <p class="card-text">Deputi VI</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Include Splide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Splide('#splide', {
                type: 'loop',
                perPage: 5,
                perMove: 1,
                autoplay: true,
                interval: 1500,
                arrows: true,
                pagination: false,
                breakpoints: {
                    1200: {
                        perPage: 4,
                    },
                    768: {
                        perPage: 2,
                    },
                    480: {
                        perPage: 1,
                    },
                },
            }).mount();
        });
    </script>
</body>

</html>

<?= $this->endSection() ?>