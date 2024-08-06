<!-- app/Views/admin/layanan/kategoriLayanan.php -->
<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container mt-5">
    <h2>Kelola Kategori Layanan</h2>
    <a href="<?= base_url('admin/layanan/createKategori') ?>" class="btn btn-primary mb-3">Tambah Kategori</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kategori as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td>
                        <a href="<?= base_url('admin/layanan/editKategori/' . $item['id']) ?>" class="btn btn-warning">Edit</a>
                        <form action="<?= base_url('admin/layanan/deleteKategori/' . $item['id']) ?>" method="post" style="display:inline;">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>
