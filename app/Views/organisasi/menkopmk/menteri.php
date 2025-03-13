<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi Kemenko PMK</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
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
    <!-- <div class="container">
        <h1 class="org-title">Struktur Organisasi Kemenko PMK</h1>
        <div class="org-info">
            <img src="images/pratikno.jpg" alt="FOTO MENKO PMK">
            <div>
                <h2>Menteri Koordinator Bidang Manusia dan Kebudayaan</h2>
                <p>Prof. Dr. Pratikno, M.Soc.Sc adalah Menteri Koordinator Bidang Pembangunan Manusia dan Kebudayaan sejak 21 Oktober 2024 pada Kabinet Indonesia Maju Prabowo-Gibran. Beliau lahir di Bojonegoro, tanggal 13 Februari 1962.</p>
            </div>
        </div>
    </div> -->

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

<?= $this->section('content'); ?>

<style>
    .sidebar {
        border-right: 1px solid #ccc;
        height: 100vh;
    }

    .main-content {
        text-align: center;
    }

    .content-title {
        margin-top: 30px;
    }

    .image-placeholder {
        width: 100%;
        height: 400px;
        border: 1px solid #ccc;
        background: url('path-to-image-placeholder') no-repeat center center;
        background-size: cover;
    }

    .menu-list {
        list-style-type: none;
        padding: 0;
    }

    .menu-list li {
        padding: 5px 0;
    }

    .menu-list a {
        text-decoration: none;
        color: black;
    }

    .menu-list a:hover {
        color: blue;
    }
</style>


<div class="container-fluid p-0" style="margin-top: 20px;">
    <div class="row no-gutters">

        <!-- Sidebar Kiri -->
        <div class="col-md-3">
            <?= $this->include('organisasi/sidebarkiri'); ?>

            <div class="card shadow-sm mb-3 mr-md-3 flex-shrink-0 referensi-sidebar animate__animated animate__fadeInLeft">


                <div class="row">
                    <?= $this->include('organisasi/menkopmk'); ?>
                    <?= $this->include('organisasi/sesmenko'); ?>
                    <?= $this->include('organisasi/staffahli'); ?>
                    <?= $this->include('organisasi/inspektorat'); ?>
                    <?= $this->include('organisasi/deputi'); ?>
                </div>
            </div>
        </div>

        <!-- Konten Kanan -->
        <div class="col-md-9 p-4">
            <div class="card mx-auto" style="width: 18rem;">

                <div class="card-body" style="text-align: center;">
                    <p class="card-text">Menteri Koordinator Bidang Pembangunan Manusia dan Kebudayaan</p>
                </div>
                <img src="<?= base_url('images/pratikno.jpg'); ?>" class="card-img-top" alt="..." style="width: 280px; height: 370px; object-fit: cover;">
                <div class="card-body" style="text-align: center;">
                    <p class="card-text">Prof. Dr. Pratikno, M.Soc.Sc.</p>
                </div>

            </div>
            <br>
            <div class="p-3 text-emphasis bg-subtle">
                Lahir : Bojonegoro, 13 Februari 1962 <br>
                Agama : Islam<br>
                Istri : Siti Faridah<br>
                Berdasarkan Permenko PMK nomor tahun 2021 tentang Perubahan atas Permenko PMK nomor 4 tahun 2020 tentang Organisasi dan Tata Kerja Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan<br>
                <br><br>
                <p><u>Pendidikan</u></p>
                <p>Desember 2008: Professor in Political Science, Universitas Gadjah Mada, Indonesia</p>
                <p>1992 - 1996: S3-Political Science, Flinders University, Australia</p>
                <p>1989 - 1991: S2-Development Administration University of Birmingham, Inggris</p>
                <p>1980 - 1985: S1 (Drs.) Ilmu Pemerintahan, Fak. Ilmu Sosial dan Ilmu Politik, Universitas Gajah Mada</p>
                <br><br>

                <p><u>Pengalaman Pekerjaan</u></p>
                <p>2014 - Sekarang: Menteri Sekretaris Negara</p>
                <p>2012 - 2014: Rektor Universitas Gadjah Mada</p>
                <p>2003: Direktur dan Pengajar di Program Pascasarjana Prodi Ilmu Politik Konsentrasi Politik Lokal dan Otonomi Daerah, Universitas Gadjah Mada</p>
            </div>

            <br>




        </div>
    </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.unit-kerja-btn').forEach(button => {
        button.addEventListener('click', function() {
            const namaUnitKerja = this.getAttribute('data-nama');
            const parentId = this.getAttribute('data-parent-id');

            // Tampilkan detail di div sebelah kanan
            document.getElementById('nama_unit_kerja').innerText = 'Nama Unit Kerja: ' + namaUnitKerja;
            document.getElementById('parent_id').innerText = 'Parent ID: ' + parentId;
        });
    });
</script>

<!-- Script untuk Mengelola Pencarian dan Tombol Back -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const organisasiLinks = document.querySelectorAll('.list-group-item');
        const organisasiContents = document.querySelectorAll('.organisasi-content');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const backButton = document.getElementById('backButton');

        if (organisasiContents.length > 0) {
            organisasiContents[0].style.display = 'block';
        }

        organisasiLinks.forEach(link => {
            link.addEventListener('click', function() {
                const organisasiId = this.getAttribute('data-organisasi-id');

                organisasiContents.forEach(content => {
                    if (content.getAttribute('data-organisasi-id') === organisasiId) {
                        content.style.display = 'block';
                        content.classList.add('animate__animated', 'animate__fadeIn');
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate__animated', 'animate__fadeIn');
                    }
                });

                organisasiLinks.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            });
        });

        searchButton.addEventListener('click', function() {
            const query = searchInput.value.toLowerCase();

            if (query === '') {
                organisasiContents.forEach(content => {
                    content.style.display = 'block';
                    content.classList.add('animate__animated', 'animate__fadeIn');
                    const cards = content.querySelectorAll('.referensi-card');
                    cards.forEach(card => {
                        card.style.display = 'block';
                    });
                });
                organisasiLinks.forEach((link, index) => {
                    link.classList.toggle('active', index === 0);
                });
            } else {
                let found = false;

                organisasiContents.forEach(content => {
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

                organisasiLinks.forEach(link => {
                    link.style.display = 'block';
                    link.classList.remove('active');
                });

                if (!found) {
                    alert('No results found');
                }
            }
        });

        backButton.addEventListener('click', function() {
            searchInput.value = '';
            organisasiContents.forEach(content => {
                content.style.display = 'block';
                content.classList.add('animate__animated', 'animate__fadeIn');
                const cards = content.querySelectorAll('.referensi-card');
                cards.forEach(card => {
                    card.style.display = 'block';
                });
            });
            organisasiLinks.forEach((link, index) => {
                link.classList.toggle('active', index === 0);
            });
        });

        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                searchButton.click();
            }
        });
    });
</script>

<?= $this->endSection(); ?>
>>>>>>> 7091ed28588df9ca991977d7821057aba70b15db