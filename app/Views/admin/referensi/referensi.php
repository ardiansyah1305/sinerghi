<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<style>
/* Styles for the main container */
.ref-container {
    padding: 20px;
    font-family: 'Arial', sans-serif;
}

.ref-header, .ref-subheader {
    color: #333;
    margin-bottom: 20px;
}

.ref-subheader {
    font-size: 1.2rem;
    margin-top: 40px;
}

/* Form Styles */
.ref-form {
    margin-bottom: 20px;
}

.ref-form-label {
    font-weight: bold;
    color: #555;
}

.ref-form-control {
    border-radius: 5px;
    box-shadow: none;
    border: 1px solid #ced4da;
}

.ref-form-control:focus {
    border-color: #6c757d;
    box-shadow: 0 0 5px rgba(108, 117, 125, 0.25);
}

.ref-btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff !important; /* Teks warna putih dengan !important */
    padding: 10px 20px;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.ref-btn-primary:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

/* Table Styles */
.ref-table {
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.ref-table th {
    background-color: #343a40;
    color: #fff;
    border: none;
}

.ref-table td, .ref-table th {
    vertical-align: middle;
}

.ref-table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

.ref-table-striped tbody tr:hover {
    background-color: #e9ecef;
}

.ref-table a {
    text-decoration: none;
    color: #007bff;
}

.ref-table a:hover {
    text-decoration: underline;
}

.ref-btn-sm {
    padding: 5px 10px;
    font-size: 0.875rem;
    border-radius: 5px;
}

.ref-btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #fff !important; /* Teks warna putih dengan !important */
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.ref-btn-warning:hover {
    background-color: #e0a800;
    transform: translateY(-2px);
}

.ref-btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff !important; /* Teks warna putih dengan !important */
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.ref-btn-danger:hover {
    background-color: #c82333;
    transform: translateY(-2px);
}
</style>

<div class="ref-container mt-4">
    <h1 class="ref-header">Referensi Management</h1>

    <!-- Form Tambah Kategori -->
    <h2 class="ref-subheader">Tambah Kategori</h2>
    <form action="<?= site_url('admin/referensi/storeCategory'); ?>" method="post" class="ref-form">
        <div class="mb-3">
            <label for="judul_kategori" class="ref-form-label">Nama Kategori</label>
            <input type="text" class="ref-form-control" id="judul_kategori" name="judul" required>
        </div>
        <button type="submit" class="btn ref-btn-primary">Tambah Kategori</button>
    </form>

    <hr>

    <!-- Tabel Kategori -->
    <h2 class="ref-subheader">Daftar Kategori</h2>
    <table class="table ref-table ref-table-striped mb-4">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $id => $judul): ?>
            <tr>
                <td><?= $judul; ?></td>
                <td>
                    <a href="<?= site_url('admin/referensi/editCategory/' . $id); ?>" class="btn ref-btn-warning ref-btn-sm">Edit</a>
                    <a href="<?= site_url('admin/referensi/deleteCategory/' . $id); ?>" class="btn ref-btn-danger ref-btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <!-- Tabel Konten -->
    <h2 class="ref-subheader">Daftar Konten</h2>
    <a href="<?= site_url('admin/referensi/create'); ?>" class="btn ref-btn-primary mb-3">Tambah Konten</a>
    <table class="table ref-table ref-table-striped">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Unit Terkait</th>
                <th>Tanggal</th>
                <th>File Upload</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contents as $content): ?>
            <tr>
                <td><?= $content['judul']; ?></td>
                <td><?= $content['deskripsi']; ?></td>
                <td><?= $content['unit_terkait']; ?></td>
                <td><?= $content['tanggal']; ?></td>
                <td><a href="<?= site_url('admin/referensi/viewFile/' . $content['file_upload']); ?>" target="_blank">Lihat File</a></td>
                <td><?= $categories[$content['parent_id']] ?? 'Tanpa Kategori'; ?></td>
                <td>
                    <a href="<?= site_url('admin/referensi/edit/' . $content['id']); ?>" class="btn ref-btn-warning ref-btn-sm">Edit</a>
                    <a href="<?= site_url('admin/referensi/delete/' . $content['id']); ?>" class="btn ref-btn-danger ref-btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus konten ini?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
