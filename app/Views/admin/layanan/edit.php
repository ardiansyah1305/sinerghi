<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <h2>Edit Layanan</h2>
    <form action="<?= site_url('admin/layanan/update/' . $layanan['id']); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control">
                <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['id']; ?>" <?= $kat['id'] == $layanan['kategori_id'] ? 'selected' : ''; ?>><?= $kat['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title" class="form-control" value="<?= $layanan['title']; ?>">
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Warna</label>
            <input type="text" name="color" id="color" class="form-control" value="<?= $layanan['color']; ?>">
        </div>
        <div class="mb-3">
            <label for="icon" class="form-label">Ikon</label>
            <input type="text" name="icon" id="icon" class="form-control" value="<?= $layanan['icon']; ?>">
        </div>
        <div class="mb-3">
            <label for="links" class="form-label">Link</label>
            <div id="link-fields">
                <?php 
                $links = json_decode($layanan['links'], true);
                if (is_array($links)) {
                    foreach ($links as $link): 
                ?>
                <div class="input-group mb-2">
                    <input type="text" name="link_names[]" class="form-control" placeholder="Nama Link" value="<?= $link['name']; ?>">
                    <input type="url" name="link_urls[]" class="form-control" placeholder="URL Link" value="<?= $link['url']; ?>">
                    <button type="button" class="btn btn-danger remove-link">Hapus</button>
                </div>
                <?php endforeach; } else { ?>
                <div class="input-group mb-2">
                    <input type="text" name="link_names[]" class="form-control" placeholder="Nama Link">
                    <input type="url" name="link_urls[]" class="form-control" placeholder="URL Link">
                    <button type="button" class="btn btn-danger remove-link">Hapus</button>
                </div>
                <?php } ?>
            </div>
            <button type="button" id="add-link" class="btn btn-primary">Tambah Link</button>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('add-link').addEventListener('click', function() {
        const linkFields = document.getElementById('link-fields');
        const newField = document.createElement('div');
        newField.classList.add('input-group', 'mb-2');
        newField.innerHTML = `
            <input type="text" name="link_names[]" class="form-control" placeholder="Nama Link">
            <input type="url" name="link_urls[]" class="form-control" placeholder="URL Link">
            <button type="button" class="btn btn-danger remove-link">Hapus</button>
        `;
        linkFields.appendChild(newField);

        newField.querySelector('.remove-link').addEventListener('click', function() {
            newField.remove();
        });
    });

    document.querySelectorAll('.remove-link').forEach(function(button) {
        button.addEventListener('click', function() {
            button.parentElement.remove();
        });
    });
</script>

<?= $this->endSection(); ?>
