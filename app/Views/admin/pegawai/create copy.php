<form action="<?= site_url('pegawai/pegawai/store'); ?>" method="post" id="pegawaiForm" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field(); ?>

    <!-- Input NIP -->
    <div class="form-group mb-3">
        <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
        <input type="text" name="nip" class="form-control" id="nip" required>
        <div class="invalid-feedback">Kolom NIP tidak boleh kosong.</div>
    </div>

    <!-- Input Gelar Depan -->
    <div class="form-group mb-3">
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" class="form-control" id="gelar_depan">
    </div>

    <!-- Input Nama -->
    <div class="form-group mb-3">
        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" name="nama" class="form-control" id="nama" required>
        <div class="invalid-feedback">Kolom Nama tidak boleh kosong.</div>
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
        <div class="invalid-feedback">Kolom Tempat Lahir tidak boleh kosong.</div>
    </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
        <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
        <div class="invalid-feedback">Kolom Tanggal Lahir tidak boleh kosong.</div>
    </div>

    <!-- Input Pangkat -->
    <div class="form-group mb-3">
        <label for="pangkat" class="form-label">Pangkat <span class="text-danger">*</span></label>
        <select name="pangkat" id="pangkat" class="form-control">
            <option value="">-- Pilih Pangkat --</option>
            <?php foreach ($jenjangpangkat as $jp): ?>
                <option value="<?= $jp['kode']; ?>"><?= esc($jp['nama_pangkat']); ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Kolom pangkat tidak boleh kosong.</div>
    </div>

    <!-- Input Golongan Ruang -->
    <div class="form-group mb-3">
        <label for="golongan_ruang" class="form-label">Golongan Ruang <span class="text-danger">*</span></label>
        <select name="golongan_ruang" id="golongan_ruang" class="form-control">
            <option value="">-- Pilih Golongan Ruang --</option>
            <?php foreach ($jenjangpangkat as $jp): ?>
                <option value="<?= $jp['kode']; ?>"><?= esc($jp['golongan']); ?>/<?= esc($jp['ruang']); ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Kolom golongan ruang tidak boleh kosong.</div>
    </div>

    <!-- Input Jabatan -->
    <div class="form-group mb-3">
        <label for="jabatan_id" class="form-label">Jabatan <span class="text-danger">*</span></label>
        <select name="jabatan_id" class="form-select" id="jabatan_id">
            <option value="" selected disabled>Pilih Jabatan</option>
            <?php if (!empty($jabatan)) : ?>
                <?php foreach ($jabatan as $jbt) : ?>
                    <option value="<?= $jbt['id']; ?>"><?= $jbt['nama_jabatan']; ?></option>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="">Data jabatan tidak ditemukan</option>
            <?php endif; ?>
        </select>
        <div class="invalid-feedback">Pilih jabatan terlebih dahulu.</div>
    </div>

    <!-- Input Unit Kerja Parent -->
    <div class="form-group mb-3">
        <label for="unit_kerja_id">Unit Kerja<span class="text-danger">*</span></label>
        <select name="unit_kerja_id" class="form-select" id="unit_kerja_id">
            <option value="" selected disabled>Pilih Unit Kerja</option>
            <?php foreach ($unit_kerja as $uk): ?>
                <option value="<?= $uk['id']; ?>"><?= esc($uk['nama_unit_kerja']); ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Pilih unit kerja terlebih dahulu.</div>
    </div>

    <!-- Input Kelas Jabatan -->
    <div class="form-group mb-3">
        <label for="kelas_jabatan" class="form-label">Kelas Jabatan <span class="text-danger">*</span></label>
        <input type="text" name="kelas_jabatan" class="form-control" id="kelas_jabatan">
        <div class="invalid-feedback">Kolom Kelas Jabatan tidak boleh kosong.</div>
    </div>

    <!-- Input Jenis Kelamin -->
    <div class="form-group mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
        <select name="jenis_kelamin" class="form-select" id="jenis_kelamin">
            <option value="" selected disabled>Pilih Jenis Kelamin</option>
            <option value="laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <div class="invalid-feedback">Pilih jenis kelamin terlebih dahulu.</div>
    </div>

    <!-- Input Status Aktif -->
    <div class="form-group mb-3">
    <label for="status_pegawai_id">Status Pegawai</label>
    <select name="status_pegawai_id" id="status_pegawai_id" class="form-control">
            <option value="">-- Pilih Status Pegawai --</option>
            <?php foreach ($statuspegawai as $sp): ?>
                <option value="<?= $sp['kode']; ?>"><?= esc($sp['nama_status']); ?></option>
            <?php endforeach; ?>
        </select>
    
        <div class="invalid-feedback">Status pegawai tidak boleh kosong.</div>
    </div>

    <!-- Input Total Angka Kredit -->

    <!-- Input Status Pernikahan -->
    <div class="form-group mb-3">
        <label for="status_pernikahan" class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
        <select name="status_pernikahan" id="status_pernikahan" class="form-control">
            <option value="">-- Pilih Status Pernikahan --</option>
            <?php foreach ($statuspernikahan as $sp): ?>
                <option value="<?= $sp['kode']; ?>"><?= esc($sp['status']); ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Pilih status pernikahan terlebih dahulu.</div>
    </div>

    <!-- Input Jumlah Anak -->
    <div class="form-group mb-3">
        <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
        <input type="text" name="jumlah_anak" class="form-control" id="jumlah_anak">
    </div>

    <!-- Input Foto -->
    <div class="form-group mb-3">
        <label for="foto" class="form-label">Foto <span class="text-danger">*</span><br>
        <small class="text-muted">Format ukuran 198 x 198</small>
        </label>
        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png" id="foto">
        <div class="invalid-feedback">Tidak ada foto.</div>
    </div>


    <!-- Input Agama -->
    <div class="form-group mb-3">
        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
        <select name="agama" id="agama" class="form-control">
            <option value="">-- Pilih Agama --</option>
            <?php foreach ($agama as $a): ?>
                <option value="<?= $a['kode']; ?>"><?= esc($a['nama_agama']); ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Pilih agama terlebih dahulu.</div>
    </div>  
    <!-- Tombol Simpan dan Tutup -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary-add">Simpan</button>
    </div>
</form>