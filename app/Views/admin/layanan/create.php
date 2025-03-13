<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container px-5 py-5">
    <div class="card shadow">
        <div class="card-header">
            <h2>Tambah Layanan</h2>
        </div>
        <div class="card-body mx-5 my-4">

<form action="<?= site_url('admin/layanan/store'); ?>" method="post" enctype="multipart/form-data">

                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select">
                        
			<?php foreach ($kategori as $kat): ?>
                            <option value="<?= $kat['id'] ?>"><?= $kat['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Judul <span class="text-danger fs-5">*</span></label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Warna</label>
                    <input type="color" class="form-control" id="color" name="color">
                </div>
                <div class="mb-3">
                    <label for="links" class="form-label">Links <span class="text-danger fs-5">*</span></label>
                    <div id="links">
                        <div class="link-item mb-2">
                            <input type="text" class="form-control mb-1" name="link_names[]" placeholder="Nama Link">
                            <input type="url" class="form-control" name="link_urls[]" placeholder="URL Link">
                        </div>
                    </div>
                    <button type="button" id="addLink" class="btn btn-success mt-2">Tambah Link</button>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('success_layanan')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_layanan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_layanan')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_layanan'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>

<script>
document.getElementById('addLink').addEventListener('click', function() {
    var linkItem = document.querySelector('.link-item').cloneNode(true);
    document.getElementById('links').appendChild(linkItem);
});
</script>

<?= $this->endSection(); ?>
