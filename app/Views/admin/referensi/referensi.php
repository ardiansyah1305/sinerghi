<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
    <h1>Referensi Management</h1>

    <!-- Form Tambah Kategori -->
    <h2>Tambah Kategori</h2>
    <form action="<?= site_url('admin/referensi/addCategory'); ?>" method="post">
        <div class="mb-3">
            <label for="judul_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="judul_kategori" name="judul" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
    </form>

    <hr>

    <!-- Tabel Konten -->
    <h2>Daftar Konten</h2>
    <a href="<?= site_url('admin/referensi/create'); ?>" class="btn btn-primary mb-3">Tambah Konten</a>
    <table class="table table-striped">
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
                <td><a href="<?= base_url('uploads/pdf/' . $content['file_upload']); ?>" target="_blank">Lihat File</a></td>
                <td><?= $categories[$content['parent_id']] ?? 'Tanpa Kategori'; ?></td>
                <td>
                    <a href="<?= site_url('admin/referensi/edit/' . $content['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('admin/referensi/delete/' . $content['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus konten ini?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>