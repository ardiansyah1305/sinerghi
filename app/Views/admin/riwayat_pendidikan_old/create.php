<form action="<?= site_url('admin/riwayat_pendidikan/store'); ?>" method="post" enctype="multipart/form-data" id="riwayatPendidikanForm">
    <?= csrf_field(); ?>

    <div class="form-group mb-3">
        <label for="pegawai_id">Pegawai 
            <span class="invalid-feedback" id="pegawai_id_error" style="display:none; color: red;">*</span>
        </label>
        <select name="pegawai_id" class="form-control" id="pegawai_id">
            <option value="">Select Pegawai</option>
            <?php if (!empty($pegawai)) : ?>
                <?php foreach ($pegawai as $pgw) : ?>
                    <option value="<?= $pgw['id']; ?>"><?= $pgw['nama']; ?></option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">Data Pegawai tidak ditemukan</option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="jenjang">Jenjang 
            <span class="invalid-feedback" id="jenjang_error" style="display:none; color: red;">*</span>
        </label>
        <input type="text" name="jenjang" class="form-control" id="jenjang">
    </div>

    <div class="form-group mb-3">
        <label for="jurusan">Jurusan 
            <span class="invalid-feedback" id="jurusan_error" style="display:none; color: red;">*</span>
        </label>
        <input type="text" name="jurusan" class="form-control" id="jurusan">
    </div>

    <div class="form-group mb-3">
        <label for="universitas">Universitas 
            <span class="invalid-feedback" id="universitas_error" style="display:none; color: red;">*</span>
        </label>
        <input type="text" name="universitas" class="form-control" id="universitas">
    </div>

    <div class="form-group mb-3">
        <label for="tahun_masuk">Tahun Masuk 
            <span class="invalid-feedback" id="tahun_masuk_error" style="display:none; color: red;">*</span>
        </label>
        <input type="date" name="tahun_masuk" class="form-control" id="tahun_masuk">
    </div>

    <div class="form-group mb-3">
        <label for="tahun_lulus">Tahun Lulus 
            <span class="invalid-feedback" id="tahun_lulus_error" style="display:none; color: red;">*</span>
        </label>
        <input type="date" name="tahun_lulus" class="form-control" id="tahun_lulus">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>


