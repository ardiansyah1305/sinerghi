<!-- edit.php -->

<form action="<?= site_url('pegawai/riwayat_pendidikan/update/'); ?><?= esc($riwayat_pendidikan['id']); ?>" method="post" enctype="multipart/form-data" id="editriwayatPendidikanForm" class="needs-validation" novalidate>
    <?= csrf_field(); ?>

<div class="modal-body">
	<div class="form-group mb-3">
    <label for="pegawai_id">Pegawai</label>
    <select name="pegawai_id" class="form-select" id="epegawai_id">
        <option value="" selected disabled>-- Pilih Pegawai --</option>
        <?php foreach ($pegawai as $pgw) : ?>
            <option value="<?= esc($pgw['id']); ?>" <?= (isset($riwayat_pendidikan['pegawai_id']) == $pgw['id']) ? 'selected' : ''; ?>>
                <?= esc($pgw['nama']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div id="pegawai_id_error" class="invalid-feedback">
            		Pilih salah satu pegawai.
        	</div>
</div>

    <!-- Input Jenjang -->
    <div class="form-group mb-3">
        <label for="jenjang">Jenjang</label>
        <input type="text" id="ejenjang" name="jenjang" class="form-control" value="<?= esc($riwayat_pendidikan['jenjang']); ?>">
        <div id="jenjang_error" class="invalid-feedback">Kolom Jenjang tidak boleh kosong.</div>
    		<div id="jenjang_error_invalid" class="invalid-feedback">Kolom Jenjang hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
    	</div>

    <!-- Input Jurusan -->
    <div class="form-group mb-3">
        <label for="jurusan">Jurusan</label>
        <input type="text" id="ejurusan" name="jurusan" class="form-control" value="<?= esc($riwayat_pendidikan['jurusan']); ?>">
        <div id="jurusan_error" class="invalid-feedback">Kolom Jurusan tidak boleh kosong.</div>
    		<div id="jurusan_error_invalid" class="invalid-feedback">Kolom Jurusan hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
	</div>


    <!-- Input Universitas -->
    <div class="form-group mb-3">
        <label for="universitas">Universitas</label>
        <input type="text" id="euniversitas" name="universitas" class="form-control" value="<?= esc($riwayat_pendidikan['universitas']); ?>">
        <div id="universitas_error" class="invalid-feedback">Kolom Universitas tidak boleh kosong.</div>
    		<div id="universitas_error_invalid" class="invalid-feedback">Kolom Universitas hanya boleh berisi huruf, angka, spasi, dan tanda koma.</div>
	</div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tahun_masuk">Tahun Masuk</label>
        <input type="number" id="etahun_masuk" name="tahun_masuk" class="form-control" value="<?= esc($riwayat_pendidikan['tahun_masuk']); ?>">
        <div id="tahun_masuk_error" class="invalid-feedback">Kolom Tahun Lulus tidak boleh kosong.</div>
        <div id="tahun_masuk_error_invalid" class="invalid-feedback">Kolom Tahun Masuk hanya boleh berisi 4 digit angka.</div>
        </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tahun_lulus">Tahun Lulus</label>
        <input type="number" id="etahun_lulus" name="tahun_lulus" class="form-control" value="<?= esc($riwayat_pendidikan['tahun_lulus']); ?>">
        <div id="tahun_lulus_error" class="invalid-feedback">Kolom Tahun Lulus tidak boleh kosong.</div>
    		<div id="tahun_lulus_error_invalid" class="invalid-feedback">Kolom Tahun Lulus hanya boleh berisi 4 digit angka.</div>
	</div>                         
</div>

    
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning fw-semibold" style="margin-right: 22px;">Simpan</button>
    </div>

</form>
