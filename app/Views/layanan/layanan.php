<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Service Start -->
<div class="background-dark-section1">
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-4">Kementrian Pembudayaan dan Kemanusiaan</h1>
                <h6 class="custom-text">Layanan ASN</h6>
            </div>

            <!-- Layanan ASN -->
            <div class="row g-4 justify-content-center">
                <?php 
                $cards = [
                    ["color" => "#8B0000", "icon" => "fa-users", "title" => "KEPEGAWAIAN", "links" => [
                        ["name" => "SIPK", "url" => "https://sipkv2.kemenkopmk.go.id"],
                        ["name" => "SIAP", "url" => "https://example.com/siiii"],
                        ["name" => "REALTEAM", "url" => "https://example.com/siof"],
                    ]],
                    ["color" => "#8B0000", "icon" => "fa-users", "title" => "ABSENSI", "links" => [
                        ["name" => "Financial Management", "url" => "https://example.com/keuangan"]
                    ]],
                    ["color" => "#8B0000", "icon" => "fa-users", "title" => "CUTI", "links" => [
                        ["name" => "HR Development", "url" => "https://example.com/sdm"]
                    ]],
                    ["color" => "#8B0000", "icon" => "fa-users", "title" => "CATATAN HARIAN", "links" => [
                        ["name" => "Health Services", "url" => "https://example.com/kesehatan"]
                    ]]
                ];
                foreach ($cards as $index => $card) {
                    $delay = ($index % 4 == 0) ? "0.1s" : (($index % 4 == 1) ? "0.3s" : (($index % 4 == 2) ? "0.5s" : "0.7s"));
                ?>
                    <div class="col-md-6 col-lg-3 wow fadeInUp mb-4" data-wow-delay="<?= $delay ?>">
                        <div class="service-item rounded overflow-hidden" data-toggle="modal" data-target="#serviceModal<?= $index ?>" style="height: 210px;">
                            <div style="background-color: <?= $card['color'] ?>; height: 100px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa <?= $card['icon'] ?> fa-3x text-white"></i>
                            </div>
                            <div class="position-relative p-4 pt-2 text-center">
                                <h4 class="mb-0 font-weight-bold"><?= $card['title'] ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="serviceModal<?= $index ?>" tabindex="-1" aria-labelledby="serviceModalLabel<?= $index ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="serviceModalLabel<?= $index ?>"><?= $card['title'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="modal-text">Link Terkait</h5>
                                    <ul class="modal-text">
                                        <?php foreach($card['links'] as $link): ?>
                                            <li><a href="<?= $link['url'] ?>" class="tooltip-test modal-text" title="Tooltip"><?= $link['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="background-dark-section2">
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="custom-text">Administrasi Layanan ASN</h6>
            </div>

            <!-- Administrasi Layanan ASN -->
            <div class="row g-4 justify-content-center">
                <?php 
                $cards = [
                    ["color" => "#0000FF", "icon" => "fa-book", "title" => "Layanan Pendidikan", "links" => [
                        ["name" => "Educational Services", "url" => "https://example.com/pendidikan"]
                    ]],
                    ["color" => "#0000FF", "icon" => "fa-book", "title" => "Pelayanan Sosial", "links" => [
                        ["name" => "Social Services", "url" => "https://example.com/sosial"]
                    ]],
                    ["color" => "#0000FF", "icon" => "fa-book", "title" => "Layanan Kebudayaan", "links" => [
                        ["name" => "Cultural Services", "url" => "https://example.com/kebudayaan"]
                    ]]
                ];
                foreach ($cards as $index => $card) {
                    $delay = ($index % 4 == 0) ? "0.1s" : (($index % 4 == 1) ? "0.3s" : (($index % 4 == 2) ? "0.5s" : "0.7s"));
                ?>
                    <div class="col-md-6 col-lg-3 wow fadeInUp mb-4" data-wow-delay="<?= $delay ?>">
                        <div class="service-item rounded overflow-hidden" data-toggle="modal" data-target="#serviceModal<?= $index + 4 ?>" style="height: 210px;">
                            <div style="background-color: <?= $card['color'] ?>; height: 100px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa <?= $card['icon'] ?> fa-3x text-white"></i>
                            </div>
                            <div class="position-relative p-4 pt-2 text-center">
                                <h4 class="mb-0 font-weight-bold"><?= $card['title'] ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="serviceModal<?= $index + 4 ?>" tabindex="-1" aria-labelledby="serviceModalLabel<?= $index + 4 ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="serviceModalLabel<?= $index + 4 ?>"><?= $card['title'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="modal-text">Link Terkait</h5>
                                    <ul class="modal-text">
                                        <?php foreach($card['links'] as $link): ?>
                                            <li><a href="<?= $link['url'] ?>" class="tooltip-test modal-text" title="Tooltip"><?= $link['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="background-dark-section3">
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="custom-text">Layanan IT</h6>
            </div>

            <!-- Layanan IT -->
            <div class="row g-4 justify-content-center">
                <?php 
                $cards = [
                    ["color" => "#e88504", "icon" => "fa-leaf", "title" => "Lingkungan Hidup", "links" => [
                        ["name" => "Environmental Services", "url" => "https://example.com/lingkungan"]
                    ]],
                    ["color" => "#e88504", "icon" => "fa-leaf", "title" => "Transportasi", "links" => [
                        ["name" => "Transportation Services", "url" => "https://example.com/transportasi"]
                    ]],
                    ["color" => "#e88504", "icon" => "fa-leaf", "title" => "Komunikasi dan Informasi", "links" => [
                        ["name" => "Communication Services", "url" => "https://example.com/komunikasi"]
                    ]],
                    ["color" => "#e88504", "icon" => "fa-leaf", "title" => "Sistem Informasi", "links" => [
                        ["name" => "Information Systems", "url" => "https://example.com/informasi"]
                    ]],
                    ["color" => "#e88504", "icon" => "fa-leaf", "title" => "Pengolahan Data", "links" => [
                        ["name" => "Data Processing", "url" => "https://example.com/pengolahan"]
                    ]],
                    ["color" => "#e88504", "icon" => "fa-leaf", "title" => "Pengelolaan IT", "links" => [
                        ["name" => "IT Management", "url" => "https://example.com/management"]
                    ]]
                ];
                foreach ($cards as $index => $card) {
                    $delay = ($index % 3 == 0) ? "0.1s" : (($index % 3 == 1) ? "0.3s" : "0.5s");
                ?>
                    <div class="col-md-6 col-lg-3 wow fadeInUp mb-4" data-wow-delay="<?= $delay ?>">
                        <div class="service-item rounded overflow-hidden" data-toggle="modal" data-target="#serviceModal<?= $index + 7 ?>" style="height: 210px;">
                            <div style="background-color: <?= $card['color'] ?>; height: 100px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa <?= $card['icon'] ?> fa-3x text-white"></i>
                            </div>
                            <div class="position-relative p-4 pt-2 text-center">
                                <h4 class="mb-0 font-weight-bold"><?= $card['title'] ?></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="serviceModal<?= $index + 7 ?>" tabindex="-1" aria-labelledby="serviceModalLabel<?= $index + 7 ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="serviceModalLabel<?= $index + 7 ?>"><?= $card['title'] ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5 class="modal-text">Link Terkait</h5>
                                    <ul class="modal-text">
                                        <?php foreach($card['links'] as $link): ?>
                                            <li><a href="<?= $link['url'] ?>" class="tooltip-test modal-text" title="Tooltip"><?= $link['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->

<style>
    .background-dark-section1 {
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

    .background-dark-section3 {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        font-size: 18px; /* Ukuran teks heading dalam modal */
    }

    .modal-body a {
        font-size: 25px; /* Ukuran teks link */
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
</style>

<script>
    $(document).ready(function() {
        // Activate tooltips and popovers
        $('.tooltip-test').tooltip();
        $('.popover-test').popover();
    });
</script>

<?= $this->endSection() ?>
