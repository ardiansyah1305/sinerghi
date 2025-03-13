<form action="<?= site_url('admin/beranda/updateSlider/' . $sliders['id']); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="form-group">
            <label for="image">Foto</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="<?= base_url('img/' . $sliders['image']); ?>" alt="Current Image" class="mt-2 border border-secondary-subtle p-1" style="max-width: 100px;">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
                                            
</form>