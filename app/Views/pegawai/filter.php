<form action="<?= site_url('pegawai/pegawai'); ?>" method="get" class="d-flex">
<?= csrf_field(); ?>
   
    <div class="form-group mb-3">
        <!-- Dropdown filter jabatan -->
    <select name="jabatan" class="form-control" style="width: 150px; margin-right: 5px;">
        <option value="">Pilih Jabatan</option>
        <?php foreach ($jabatan as $j): ?>
            <option value="<?= $j['id']; ?>" <?= $j['id'] == $filterJabatan ? 'selected' : ''; ?>>
                <?= esc($j['nama_jabatan']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-group mb-3">
        <select name="unit_kerja" class="form-control" style="width: 150px; margin-right: 5px;">
        <option value="">Pilih Unit Kerja</option>
        <?php foreach ($unit_kerja as $uk): ?>
            <option value="<?= $uk['id']; ?>" <?= $uk['id'] == $filterUnitKerja ? 'selected' : ''; ?>>
                <?= esc($uk['nama_unit_kerja']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    </div>

    <div class="form-group mb-3">
        <select name="unit_kerja" class="form-control" style="width: 150px; margin-right: 5px;">
        <option value="">Pilih Unit Kerja</option>
        <?php foreach ($unit_kerjaa as $uka): ?>
            <option value="<?= $uka['id']; ?>" <?= $uka['id'] == $filterUnitKerjaa ? 'selected' : ''; ?>>
                <?= esc($uka['nama_unit_kerja']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    </div>
    
    <div class="modal-footer">
    <button type="submit" class="btn btn-primary ml-2 custom-search-btn">Cari</button>
    </div>
</form>
