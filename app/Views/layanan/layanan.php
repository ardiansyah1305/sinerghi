<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

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
    <div class="full-width-section <?= $sectionClass ?>">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="custom-text"><?= $sectionName ?></h6>
            </div>
            <div class="row g-4 justify-content-center">
                <?php foreach ($filteredLayanan as $index => $card): ?>
                    <div class="col-md-6 col-lg-3 wow fadeInUp mb-4" data-wow-delay="0.1s">
                        <div class="service-item rounded overflow-hidden shadow-sm" data-bs-toggle="modal" data-bs-target="#serviceModal-<?= $card['id'] ?>" style="height: 210px;">
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
                                    <ul class="modal-text list-unstyled">
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
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.tooltip-test').tooltip();
    });
</script>

<?= $this->endSection() ?>
