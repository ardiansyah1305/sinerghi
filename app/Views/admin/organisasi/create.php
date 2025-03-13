<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4">
    <h2>Tambah Layanan</h2>
    <form action="/admin/layanan/store" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control">
                <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['id'] ?>"><?= $kat['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Warna</label>
            <input type="color" class="form-control" id="color" name="color" required>
        </div>
        <div class="mb-3">
            <label for="links" class="form-label">Links</label>
            <div id="links">
                <div class="link-item mb-2">
                    <input type="text" class="form-control mb-1" name="link_names[]" placeholder="Nama Link" required>
                    <input type="url" class="form-control" name="link_urls[]" placeholder="URL Link" required>
                </div>
            </div>
            <button type="button" id="addLink" class="btn btn-success mt-2">Tambah Link</button>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
document.getElementById('addLink').addEventListener('click', function() {
    var linkItem = document.querySelector('.link-item').cloneNode(true);
    document.getElementById('links').appendChild(linkItem);
});
</script>

<?= $this->endSection(); ?>
