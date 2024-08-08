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
    background-color: #f8f9fa; /* Warna latar belakang netral */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Slider Section */
.slider-section h3,
.popup-section h3,
.card-section h3,
.calendar-section h3 {
    color: #343a40;
    margin-bottom: 20px;
    border-bottom: 2px solid #e3e3e3; /* Garis bawah untuk judul section */
    padding-bottom: 10px;
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
    background-color: #343a40;
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

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    color: #fff;
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
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4">Manage Beranda</h2>

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
                        <th>No</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sliders as $slider): ?>
                    <tr>
                        <td><?= $slider['id']; ?></td>
                        <td><img src="<?= base_url('img/' . $slider['image']); ?>" alt="Slider Image" width="100"></td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editSliderModal<?= $slider['id']; ?>">Edit</button>
                            <a href="<?= site_url('admin/beranda/deleteSlider/' . $slider['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this slider?');">Delete</a>
                        </td>
                    </tr>
                    <!-- Edit Slider Modal -->
                    <div class="modal fade" id="editSliderModal<?= $slider['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editSliderModalLabel<?= $slider['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editSliderModalLabel<?= $slider['id']; ?>">Edit Slider</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('admin/beranda/updateSlider/' . $slider['id']); ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            <img src="<?= base_url('img/' . $slider['image']); ?>" alt="Current Image" style="max-width: 100px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                        <th>No</th>
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
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editPopupModal<?= $popup['id']; ?>">Edit</button>
                            <a href="<?= site_url('admin/beranda/deletePopup/' . $popup['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this popup?');">Delete</a>
                        </td>
                    </tr>
                    <!-- Edit Popup Modal -->
                    <div class="modal fade" id="editPopupModal<?= $popup['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPopupModalLabel<?= $popup['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPopupModalLabel<?= $popup['id']; ?>">Edit Popup</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('admin/beranda/updatePopup/' . $popup['id']); ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            <img src="<?= base_url('img/' . $popup['image']); ?>" alt="Current Image" style="max-width: 100px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                        <th>No</th>
                        <th>Title</th>
                        <th>Short Description</th>
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
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editCardModal<?= $card['id']; ?>">Edit</button>
                            <a href="<?= site_url('admin/beranda/deleteCard/' . $card['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this card?');">Delete</a>
                        </td>
                    </tr>
                    <!-- Edit Card Modal -->
                    <div class="modal fade" id="editCardModal<?= $card['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCardModalLabel<?= $card['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCardModalLabel<?= $card['id']; ?>">Edit Card</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('admin/beranda/updateCard/' . $card['id']); ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?= $card['title']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="short_description">Short Description</label>
                                            <textarea class="form-control" id="short_description" name="short_description" required><?= $card['short_description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" required><?= $card['description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                            <img src="<?= base_url('img/' . $card['image']); ?>" alt="Current Image" style="max-width: 100px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                        <th>No</th>
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
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editCalendarModal<?= $calender['id']; ?>">Edit</button>
                            <a href="<?= site_url('admin/beranda/deleteKalender/' . $calender['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                        </td>
                    </tr>
                    <!-- Edit Calendar Modal -->
                    <div class="modal fade" id="editCalendarModal<?= $calender['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCalendarModalLabel<?= $calender['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCalendarModalLabel<?= $calender['id']; ?>">Edit Event</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= site_url('admin/beranda/updateCalendar/' . $calender['id']); ?>" method="post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?= $calender['title']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" required><?= $calender['description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="start">Start Date</label>
                                            <input type="date" class="form-control" id="start" name="start" value="<?= $calender['start']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="end">End Date</label>
                                            <input type="date" class="form-control" id="end" name="end" value="<?= $calender['end']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
