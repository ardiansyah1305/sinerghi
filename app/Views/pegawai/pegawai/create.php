<form action="<?= site_url('pegawai/pegawai/store'); ?>" method="post" id="pegawaiiForm" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="form-group mb-3">
    <label for="nip">NIP <span class="text-danger">*</span></label>
    <input type="number" id="cnip" name="nip" class="form-control">
    <div id="cnip_error" class="invalid-feedback">Kolom NIP tidak boleh kosong.</div>
    <div id="cnip_error_invalid" class="invalid-feedback">NIP harus minimal 10 Angka.</div>
    <div id="nip_error_duplicate" class="invalid-feedback">NIP sudah terdaftar di database.</div>
</div>

     <!-- Input Gelar Depan -->
     <div class="form-group mb-3">
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" class="form-control" id="gelar_depan">
    </div>

    <div class="form-group mb-3">
        <label for="nama">Nama <span class="text-danger">*</span></label>
        <input type="text" id="nama" class="form-control" name="nama">
        <div id="nama_error" class="invalid-feedback">Kolom Nama tidak boleh kosong.</div>
    </div>

    <!-- Input Gelar Belakang -->
    <div class="form-group mb-3">
        <label for="gelar_belakang">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" class="form-control" id="gelar_belakang">
    </div>

    <!-- Input Tempat Lahir -->
    <div class="form-group mb-3">
        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
        <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" required>
        <div id="tempat_lahir_error" class="invalid-feedback">Kolom Tempat Lahir tidak boleh kosong.</div>
    </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
        <div id="tanggal_lahir_error" class="invalid-feedback">Kolom Tanggal Lahir tidak boleh kosong.</div>
    </div>

    <!-- Input Pangkat -->
    <div class="form-group mb-3">
    <label for="pangkat" class="form-label">Pangkat <span class="text-danger">*</span></label>
    <select name="pangkat" id="pang" class="form-select">
    <option value="" selected disabled>-- Pilih Pangkat --</option>
    <?php foreach ($jenjangpangkat as $jp): ?>
        <option value="<?= $jp['kode']; ?>"><?= esc($jp['nama_pangkat']); ?></option>
    <?php endforeach; ?>
</select>
<div id="pang_error" class="invalid-feedback">Pilih Pangkat terlebih dahulu.</div>

    </div>

    <!-- Input Golongan Ruang -->
    <div class="form-group mb-3">
        <label for="golongan_ruang" class="form-label">Golongan Ruang <span class="text-danger">*</span></label>
        <select name="golongan_ruang" id="gol_ruang" class="form-select">
            <option value="" selected disabled>-- Pilih Golongan Ruang --</option>
            <?php foreach ($jenjangpangkat as $jp): ?>
                <option value="<?= $jp['golongan']; ?><?= $jp['ruang']; ?>"><?= esc($jp['golongan']); ?>/<?= esc($jp['ruang']); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="gol_error" class="invalid-feedback">Pilih Golongan ruang terlebih dahulu.</div>
    </div>
    
    <!-- Input Jabatan -->
    <div class="form-group mb-3">
        <label for="jabatan_id" class="form-label">Jabatan <span class="text-danger">*</span></label>
        <select name="jabatan_id" class="form-select" id="jabatan_id">
            <option value="" selected disabled>-- Pilih Jabatan --</option>
            <?php if (!empty($jabatan)) : ?>
                <?php foreach ($jabatan as $jbt) : ?>
                    <option value="<?= $jbt['id']; ?>"><?= $jbt['nama_jabatan']; ?></option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">Data jabatan tidak ditemukan</option>
            <?php endif; ?>
        </select>
        <div id="jabatan_id_error" class="invalid-feedback">Pilih jabatan terlebih dahulu.</div>
    </div>

    <!-- Input Unit Kerja Parent -->
    <div class="form-group mb-3">
        <label for="unit_kerja_id">Unit Kerja<span class="text-danger">*</span></label>
        <select name="unit_kerja_id" class="form-select" id="uk">
            <option value="" selected disabled>-- Pilih Unit Kerja --</option>
            <?php foreach ($unit_kerja as $uk): ?>
                <option value="<?= $uk['id']; ?>"><?= esc($uk['nama_unit_kerja']); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="uk_error" class="invalid-feedback">Pilih unit kerja terlebih dahulu.</div>
    </div>

     <!-- Input Kelas Jabatan -->
     <div class="form-group mb-3">
        <label for="kelas_jabatan" class="form-label">Kelas Jabatan <span class="text-danger">*</span></label>
	<select name="kelas_jabatan" class="form-select" id="kj">
            <option value="" selected disabled>-- Pilih Kelas Jabatan --</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
</select>

        <div id="kj_error" class="invalid-feedback">Kolom Kelas Jabatan tidak boleh kosong.</div>
    </div>

    <!-- Input Jenis Kelamin -->
    <div class="form-group mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
        <select name="jenis_kelamin" class="form-select" id="jk">
            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
            <option value="laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <div id="jenis_kelamin_error" class="invalid-feedback">Pilih jenis kelamin terlebih dahulu.</div>
    </div>

    <!-- Input Status Pegawai -->
    <div class="form-group mb-3">
    <label for="status_pegawai">Status Pegawai <span class="text-danger">*</span></label>
    <select name="status_pegawai" class="form-select" id="status_peg">
            <option value="" selected disabled>-- Pilih Status Pegawai --</option>
            <?php foreach ($statuspegawai as $sp): ?>
                <option value="<?= $sp['kode']; ?>"><?= esc($sp['nama_status']); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="status_pegawai_error" class="invalid-feedback">Pilih Status pegawai terlebih dahulu.</div>
    </div>

     <!-- Input Status Pernikahan -->
    <div class="form-group mb-3">
        <label for="status_pernikahan" class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
        <select name="status_pernikahan" class="form-select" id="status_perni">
            <option value="" selected disabled>-- Pilih Status Pernikahan --</option>
            <?php foreach ($statuspernikahan as $sp): ?>
                <option value="<?= $sp['kode']; ?>"><?= esc($sp['status']); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="status_pernikahan_error" class="invalid-feedback">Pilih status pernikahan terlebih dahulu.</div>
    </div>

    <!-- Input Jumlah Anak -->
    <div class="form-group mb-3">
        <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
        <input type="text" name="jumlah_anak" class="form-control" id="jumlah_anak">
    </div>

    <!-- Input Foto -->
    <div class="form-group mb-3">
        <label for="foto" class="form-label">Foto <br>
        <small class="text-muted">Format foto jpg,jpeg,png</small>
        </label>
        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png" id="foto">
        
    </div>

    <!-- Input Agama -->
    <div class="form-group mb-3">
        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
        <select name="agama" id="agamaa" class="form-select">
            <option value="" selected disabled>-- Pilih Agama --</option>
            <?php foreach ($agama as $a): ?>
                <option value="<?= $a['kode']; ?>"><?= esc($a['nama_agama']); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="agama_error" class="invalid-feedback">Pilih agama terlebih dahulu.</div>
    </div>
    </div>
      

    <!-- Tombol Simpan dan Tutup -->
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success fw-semibold" style="margin-right: 22px;">Simpan</button>
    </div>
</form>