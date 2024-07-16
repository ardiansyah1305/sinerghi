<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .list-group-item {
            cursor: pointer;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar Kiri -->
            <div class="col-md-4">
                <div class="list-group" id="temaList">
                    <a class="list-group-item list-group-item-action" data-target="#content1">Peningkatan Kesejahteraan Nasional</a>
                    <a class="list-group-item list-group-item-action" data-target="#content2">Pemerataan Pembangunan Wilayah Dan Penanggulangan Bencana</a>
                    <a class="list-group-item list-group-item-action" data-target="#content3">Peningkatan Kualitas Kesehatan Dan Pembangunan Kependudukan</a>
                    <!-- Tambahkan lebih banyak item sesuai kebutuhan -->
                </div>
            </div>
            <!-- Konten Kanan -->
            <div class="col-md-8">
                <div id="content1" class="content-section active">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Surat Keputusan Bersama Nomor 236, 1, 2 Tahun 2024</h5>
                            <p class="card-text">SKB Perubahan tentang Hari Libur Nasional dan Cuti Bersama 2024</p>
                            <p class="card-text"><small class="text-muted">PMK Lainnya</small></p>
                            <p class="card-text"><small class="text-muted">2024-02-26</small></p>
                            <a href="path_to_pdf1.pdf" class="btn btn-primary" target="_blank">Lihat</a>
                            <a href="path_to_pdf1.pdf" class="btn btn-danger" download>Download</a>
                        </div>
                    </div>
                    <!-- Tambahkan lebih banyak kartu sesuai kebutuhan -->
                </div>
                <div id="content2" class="content-section">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Surat Keputusan Bersama Nomor 855, 3, 4 Tahun 2023</h5>
                            <p class="card-text">SKB Hari Libur Nasional dan Cuti Bersama 2023</p>
                            <p class="card-text"><small class="text-muted">PMK Lainnya</small></p>
                            <p class="card-text"><small class="text-muted">2023-09-12</small></p>
                            <a href="path_to_pdf2.pdf" class="btn btn-primary" target="_blank">Lihat</a>
                            <a href="path_to_pdf2.pdf" class="btn btn-danger" download>Download</a>
                        </div>
                    </div>
                    <!-- Tambahkan lebih banyak kartu sesuai kebutuhan -->
                </div>
                <div id="content3" class="content-section">
                    <!-- Konten untuk bagian Peningkatan Kualitas Kesehatan Dan Pembangunan Kependudukan -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Judul Dokumen</h5>
                            <p class="card-text">Deskripsi dokumen</p>
                            <p class="card-text"><small class="text-muted">PMK Lainnya</small></p>
                            <p class="card-text"><small class="text-muted">2023-xx-xx</small></p>
                            <a href="path_to_pdf3.pdf" class="btn btn-primary" target="_blank">Lihat</a>
                            <a href="path_to_pdf3.pdf" class="btn btn-danger" download>Download</a>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan lebih banyak konten sesuai kebutuhan -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#temaList .list-group-item').click(function() {
                var target = $(this).data('target');
                $('.content-section').removeClass('active');
                $(target).addClass('active');
            });
        });
    </script>
</body>

</html>


<?= $this->endSection() ?>