<form action="<?= site_url('pegawai/beranda/storeSlider'); ?>" method="post" enctype="multipart/form-data" class="mb-4">
    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Slider</button>
</form>
