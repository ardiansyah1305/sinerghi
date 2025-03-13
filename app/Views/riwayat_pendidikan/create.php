<form action="<?= site_url('pegawai/riwayat_pendidikan/store'); ?>" method="post" enctype="multipart/form-data" id="riwayatPendidikanForm" class="needs-validation" novalidate>
    <?= csrf_field(); ?>
    
    <div class="form-group mb-3">
        <label for="pegawai_id">Pegawai 
            <span class="fs-5 text-danger">*</span>
        </label>
        <select name="pegawai_id" class="form-select" id="pegawai_id">
            <option value="">Pilih Pegawai</option>
            <?php if (!empty($pegawai)) : ?>
                <?php foreach ($pegawai as $pgw) : ?>
                    <option value="<?= $pgw['id']; ?>"><?= $pgw['nama']; ?></option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">Data Pegawai tidak ditemukan</option>
            <?php endif; ?>
        </select>
        <div id="pegawai_id_error" class="invalid-feedback">
            Pilih salah satu id pegawai.
        </div>
    </div>

    <div class="form-group mb-3">
    <label for="jenjang">Jenjang <span class="fs-5 text-danger">*</span></label>
    <input type="text" name="jenjang" class="form-control" id="jenjang">
    <div id="jenjang_error" class="invalid-feedback">Kolom Jenjang tidak boleh kosong.</div>
    <div id="jenjang_error_invalid" class="invalid-feedback">Kolom Jenjang hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
</div>

<div class="form-group mb-3">
    <label for="jurusan">Jurusan <span class="fs-5 text-danger">*</span></label>
    <input type="text" name="jurusan" class="form-control" id="jurusan">
    <div id="jurusan_error" class="invalid-feedback">Kolom Jurusan tidak boleh kosong.</div>
    <div id="jurusan_error_invalid" class="invalid-feedback">Kolom Jurusan hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
</div>

<div class="form-group mb-3">
    <label for="universitas">Universitas <span class="fs-5 text-danger">*</span></label>
    <input type="text" name="universitas" class="form-control" id="universitas">
    <div id="universitas_error" class="invalid-feedback">Kolom Universitas tidak boleh kosong.</div>
    <div id="universitas_error_invalid" class="invalid-feedback">Kolom Universitas hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
</div>

<div class="form-group mb-3">
    <label for="tahun_masuk">Tahun Masuk <span class="fs-5 text-danger">*</span></label>
    <input type="number" name="tahun_masuk" class="form-control" id="tahun_masuk">
    <div id="tahun_masuk_error" class="invalid-feedback">Kolom Tahun Masuk tidak boleh kosong.</div>
    <div id="tahun_masuk_error_invalid" class="invalid-feedback">Kolom Tahun Masuk hanya boleh berisi 4 digit angka.</div>
</div>

<div class="form-group mb-3">
    <label for="tahun_lulus">Tahun Lulus <span class="fs-5 text-danger">*</span></label>
    <input type="number" name="tahun_lulus" class="form-control" id="tahun_lulus">
    <div id="tahun_lulus_error" class="invalid-feedback">Kolom Tahun Lulus tidak boleh kosong.</div>
    <div id="tahun_lulus_error_invalid" class="invalid-feedback">Kolom Tahun Lulus hanya boleh berisi 4 digit angka.</div>
</div>


    <div class="modal-footer mb-3 p-0" style="border-top: none;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary-add">Simpan</button>
    </div>
</form>