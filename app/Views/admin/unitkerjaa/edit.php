<!-- edit.php -->

<form action="<?= site_url('admin/unitkerjaa/update/'); ?><?= esc($unitkerjaa['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <!-- Input NIP -->
    <div class="form-group mb-3">
        <label for="nama_unit_kerja">Unit Kerja</label>
        <input type="text" name="nama_unit_kerja" class="form-control" value="<?= esc($unitkerjaa['nama_unit_kerja']); ?>" required>
    </div>

    <!-- Input Gelar Depan -->
    <div class="form-group mb-3">
        <label for="parent_id">Induk ID</label>
        <input type="text" name="parent_id" class="form-control" value="<?= esc($unitkerjaa['parent_id']); ?>" required>
    </div>

    <div class="form-group mb-3">
        <label for="unit_kerja_id">Induk Unit Kerja</label>
        <select name="unit_kerja_id" class="form-control" required>
            <option value="">Pilih Induk Unit Kerja</option>
            <?php if (!empty($unit_kerja)) : ?>
                <?php foreach ($unit_kerja as $uk) : ?>
                    <option value="<?= $uk['id']; ?>"><?= $uk['nama_unit_kerja']; ?></option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">Data Parent Unit Kerja tidak ditemukan</option>
            <?php endif; ?>
        </select>
    </div>


    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>
