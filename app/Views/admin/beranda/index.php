<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<style>
/* Gaya untuk merapikan tampilan */
.container {
    padding: 20px;
}

/* Section Styles */
.section-wrapper {
    margin-bottom: 40px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Slider Section */
.slider-section {
    background-color: #E8F0FE; /* Warna latar belakang untuk slider */
}

/* Popup Section */
.popup-section {
    background-color: #FFF3CD; /* Warna latar belakang untuk popup */
}

/* Card Section */
.card-section {
    background-color: #D1E7DD; /* Warna latar belakang untuk card */
}

/* Calendar Section */
.calendar-section {
    background-color: #F8D7DA; /* Warna latar belakang untuk kalender */
}

h2, h3 {
    color: #343a40;
    margin-bottom: 20px;
}

.form-wrapper {
    margin-bottom: 20px;
}

.table-responsive {
    margin-bottom: 40px;
}

.table {
    background-color: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    background-color: #007bff;
    color: #fff;
    border: none;
}

.table tbody tr {
    transition: background-color 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table tbody td {
    vertical-align: middle;
}

.table img {
    border-radius: 5px;
}

.btn {
    border-radius: 5px;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
    color: #fff;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: #fff;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
    color: #fff;
}
</style>

<div class="container mt-4">
    <h2>Manage Beranda</h2>

    <!-- Slider Section -->
    <div class="section-wrapper slider-section">
        <h3>Slider</h3>
        <div class="form-wrapper">
            <?= $this->include('admin/beranda/create_slider'); ?>
        </div>
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
    </div>

    <!-- Popup Section -->
    <div class="section-wrapper popup-section">
        <h3>Popup</h3>
        <div class="form-wrapper">
            <?= $this->include('admin/beranda/create_popup'); ?>
        </div>
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
    </div>

    <!-- Card Section -->
    <div class="section-wrapper card-section">
        <h3>Card</h3>
        <div class="form-wrapper">
            <?= $this->include('admin/beranda/create_card'); ?>
        </div>
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
                        <td><?= $card['short_description']; ?></td>
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

    <!-- Calendar Section -->
    <div class="section-wrapper calendar-section">
        <h3>Kalender Penting</h3>
        <div class="form-wrapper">
            <?= $this->include('admin/beranda/create_calender'); ?>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($calenders as $calender): ?>
                    <tr>
                        <td><?= $calender['id']; ?></td>
                        <td><?= $calender['title']; ?></td>
                        <td><?= $calender['description']; ?></td>
                        <td><?= $calender['start']; ?></td>
                        <td><?= $calender['end']; ?></td>
                        <td>
                            <a href="<?= site_url('admin/beranda/calender/deleteKalender/' . $calender['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
