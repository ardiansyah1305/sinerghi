<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4">
    <h2>Manage Beranda</h2>

    <!-- Slider Section -->
    <h3>Slider</h3>
    <?= $this->include('admin/beranda/create_slider'); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sliders as $slider): ?>
                <tr>
                    <td><?= $slider['id']; ?></td>
                    <td><img src="<?= base_url('img/' . $slider['image']); ?>" alt="Slider Image" width="100"></td>
                    <td><?= $slider['title']; ?></td>
                    <td><?= $slider['description']; ?></td>
                    <td>
                        <a href="<?= site_url('admin/beranda/deleteSlider/' . $slider['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this slider?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Popup Section -->
    <h3>Popup</h3>
    <?= $this->include('admin/beranda/create_popup'); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($popups as $popup): ?>
                <tr>
                    <td><?= $popup['id']; ?></td>
                    <td><img src="<?= base_url('img/' . $popup['image']); ?>" alt="Popup Image" width="100"></td>
                    <td>
                        <a href="<?= site_url('admin/beranda/deletePopup/' . $popup['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this popup?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Card Section -->
    <h3>Card</h3>
    <?= $this->include('admin/beranda/create_card'); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $card): ?>
                <tr>
                    <td><?= $card['id']; ?></td>
                    <td><?= $card['title']; ?></td>
                    <td><?= $card['description']; ?></td>
                    <td><img src="<?= base_url('img/' . $card['image']); ?>" alt="Card Image" width="100"></td>
                    <td>
                        <a href="<?= site_url('admin/beranda/detail_pengumuman/' . $card['id']); ?>" class="btn btn-info">View</a>
                        <a href="<?= site_url('admin/beranda/deleteCard/' . $card['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this card?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
