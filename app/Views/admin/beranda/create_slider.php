<form action="<?= site_url('admin/beranda/storeSlider'); ?>" method="post" enctype="multipart/form-data" class="mb-4">
    <?= csrf_field(); ?>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png" required>
    </div>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Slider</button>
</form>
