<form action="<?= site_url('admin/beranda/updateSlider/' . $sliders['id']); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="form-group">
            <label for="image">Foto</label>
            <input type="file" class="form-control" id="image" name="image">
            <div class="d-block mt-2">
                <img src="<?= base_url('img/' . $sliders['image']); ?>" alt="Current Image" class="border border-secondary-subtle" style="max-width: 100px;">
                <small class="text-muted"><span><?= $sliders['image'] ?? 'Tidak ada file' ?></span></small>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
                                            
</form>