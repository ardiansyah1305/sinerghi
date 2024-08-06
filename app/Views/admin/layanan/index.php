<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="p-4 mb-4" style="background-color: #e9f7ef; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h1 class="mb-4">Kelola Layanan</h1>
        <div class="d-flex justify-content-end mb-3">
            <a href="<?= site_url('admin/layanan/create') ?>" class="btn btn-success">Tambah Layanan</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead style="background-color: #4CAF50; color: white;">
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Warna</th>
                    <th>Icon</th>
                    <th>Link</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($layanan as $item): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $item['kategori_name']; ?></td>
                    <td><?= $item['title']; ?></td>
                    <td style="background-color: <?= $item['color']; ?>;"></td>
                    <td><i class="fa <?= $item['icon']; ?>"></i></td>
                    <td>
                        <?php $links = json_decode($item['links'], true); ?>
                        <?php if (is_array($links)): ?>
                            <?php foreach ($links as $link): ?>
                                <div><?= $link['name']; ?>: <a href="<?= $link['url']; ?>" target="_blank"><?= $link['url']; ?></a></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('admin/layanan/edit/' . $item['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                        <form action="<?= site_url('admin/layanan/delete/' . $item['id']); ?>" method="post" style="display:inline-block;">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="p-4" style="background-color: #fffde7; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 class="mb-4">Kelola Kategori</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="<?= site_url('admin/layanan/createKategori') ?>" class="btn btn-info">Tambah Kategori</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead style="background-color: #2196F3; color: white;">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($kategori as $item): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $item['name']; ?></td>
                    <td>
                        <a href="<?= site_url('admin/layanan/editKategori/' . $item['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
                        <form action="<?= site_url('admin/layanan/deleteKategori/' . $item['id']); ?>" method="post" style="display:inline-block;">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

<!-- Success Alert -->
<script>
    <?php if(session()->getFlashdata('success')): ?>
        swal({
            title: "Good job!",
            text: "<?= session()->getFlashdata('success') ?>",
            icon: "success",
            button: "Aww yiss!",
        });
    <?php endif; ?>

    // Confirm Delete
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>
