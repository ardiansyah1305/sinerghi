<!-- edit.php -->
<form id="editpegawaiiForm" action="<?= site_url('pegawai/pegawai/update/'); ?><?= esc($pegawai['id']); ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field(); ?>

    <!-- Input NIP -->
    <div class="modal-body">
        <div class="form-group mb-3">
        <label for="nip">NIP</label>
        <input type="text" name="nip" id="enip" class="form-control" value="<?= esc($pegawai['nip']); ?>">
        <div id="nip_error" class="invalid-feedback">Kolom NIP tidak boleh kosong.</div>
    <div id="nip_error_invalid" class="invalid-feedback">NIP harus minimal 10 Angka.</div>
    </div>

    <!-- Input Gelar Depan -->
    <div class="form-group mb-3">
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" class="form-control" value="<?= esc($pegawai['gelar_depan']); ?>">
    </div>

    <!-- Input Nama -->
    <div class="form-group mb-3">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="enama" class="form-control" value="<?= esc($pegawai['nama']); ?>">
        <div id="nama_error" class="invalid-feedback">Kolom Nama tidak boleh kosong.</div>
    </div>

    <!-- Input Gelar Belakang -->
    <div class="form-group mb-3">
        <label for="gelar_belakang">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" class="form-control"  value="<?= esc($pegawai['gelar_belakang']); ?>">
    </div>
    
    <!-- Input Tempat Lahir -->
    <div class="form-group mb-3">
        <label for="tempat_lahir">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" id="etempat_lahir" class="form-control" value="<?= esc($pegawai['tempat_lahir']); ?>">
        <div id="tempat_lahir_error" class="invalid-feedback">Kolom Tempat Lahir tidak boleh kosong.</div>
    </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tanggal_lahir">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="etanggal_lahir" class="form-control" value="<?= esc($pegawai['tanggal_lahir']); ?>">
        <div id="tanggal_lahir_error" class="invalid-feedback">Kolom Tanggal Lahir tidak boleh kosong.</div>
    </div>

    <!-- Input Pangkat -->
<div class="form-group mb-3">
    <label for="pangkat">Pangkat</label>
    <select name="pangkat" id="epang" class="form-select">
        <?php foreach ($jenjangpangkat as $jp): ?>
            <option value="<?= esc($jp['kode']); ?>" 
                <?= (isset($pegawai['pangkat']) && $pegawai['pangkat'] == $jp['kode']) ? 'selected' : ''; ?>>
                <?= esc($jp['nama_pangkat']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div id="pang_error" class="invalid-feedback">Pilih Pangkat terlebih dahulu.</div>
</div>


    <!-- Input Golongan Ruang -->
<div class="form-group mb-3">
    <label for="golongan_ruang">Golongan Ruang</label>
    <select name="golongan_ruang" id="egol_ruang" class="form-select">
        <?php foreach ($jenjangpangkat as $jp): ?>
            <option value="<?= esc($jp['kode']); ?>" 
                <?= (isset($pegawai['golongan_ruang']) && $pegawai['golongan_ruang'] == $jp['kode']) ? 'selected disabled' : ''; ?>>
                <?= esc($jp['golongan']); ?>/<?= esc($jp['ruang']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div id="gol_error" class="invalid-feedback">Pilih Golongan ruang terlebih dahulu.</div>
</div>

    <div class="form-group mb-3">
    <label for="jabatan_id">Jabatan</label>
    <select name="jabatan_id" class="form-select" id="ejabatan_id">
    <?php if (isset($pegawai['nama_jabatan']) && !empty($pegawai['nama_jabatan'])) : ?>
            <option value="<?= esc($pegawai['jabatan_id']); ?>"><?= esc($pegawai['nama_jabatan']); ?></option>
        <?php else : ?>
            <option value="">Pilih Jabatan</option>
        <?php endif; ?>
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

<div class="form-group mb-3">
    <label for="unit_kerja_id">Unit Kerja</label>
    <select name="unit_kerja_id" class="form-select" id="euk">
        <!-- Pilihan default -->
        <?php if (isset($pegawai['nama_unit_kerja']) && !empty($pegawai['nama_unit_kerja'])) : ?>
            <option value="<?= esc($pegawai['unit_kerja_id']); ?>"><?= esc($pegawai['nama_unit_kerja']); ?></option>
        <?php else : ?>
            <option value="">Pilih Unit Kerja</option>
        <?php endif; ?>

        <!-- Iterasi data unit kerja -->
        <?php if (!empty($unit_kerja)) : ?>
            <?php foreach ($unit_kerja as $uk) : ?>
                <option value="<?= esc($uk['id']); ?>" <?= (isset($pegawai['unit_kerja_id']) && $pegawai['unit_kerja_id'] == $uk['id']) ? 'selected' : ''; ?>>
                    <?= esc($uk['nama_unit_kerja']); ?>
                </option>
            <?php endforeach; ?>
        <?php else : ?>
            <option value="">Data unit kerja tidak ditemukan</option>
        <?php endif; ?>
    </select>
    <div id="uk_error" class="invalid-feedback">Pilih unit kerja terlebih dahulu.</div>
</div>


    <div class="form-group mb-3">
    <label for="kelas_jabatan" class="form-label">Kelas Jabatan <span class="text-danger">*</span></label>
    <select name="kelas_jabatan" class="form-select" id="ekj">
        <!-- Pilihan default -->
        <?php if (isset($pegawai['kelas_jabatan']) && !empty($pegawai['kelas_jabatan'])) : ?>
            <option value="<?= esc($pegawai['kelas_jabatan']); ?>"><?= esc($pegawai['kelas_jabatan']); ?></option>
        <?php else : ?>
            <option value="" selected disabled>-- Pilih Kelas Jabatan --</option>
        <?php endif; ?>

        <!-- Opsi kelas jabatan -->
        <?php for ($i = 1; $i <= 17; $i++) : ?>
            <option value="<?= $i; ?>" <?= (isset($pegawai['kelas_jabatan']) && $pegawai['kelas_jabatan'] == $i) ? 'selected' : ''; ?>>
                <?= $i; ?>
            </option>
        <?php endfor; ?>
    </select>
    <div id="kj_error" class="invalid-feedback">Kolom Kelas Jabatan tidak boleh kosong.</div>
</div>

    <!-- Input Jenis Kelamin -->
<div class="form-group mb-3">
    <label for="jenis_kelamin">Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-select" id="ejk">
        <?php if (isset($pegawai['jenis_kelamin']) && !empty($pegawai['jenis_kelamin'])) : ?>
            <option value="<?= esc($pegawai['jenis_kelamin']); ?>"><?= ucfirst(esc($pegawai['jenis_kelamin'])); ?></option>
        <?php else : ?>
            <option value="" selected disabled>Pilih Jenis Kelamin</option>
        <?php endif; ?>
        <option value="laki-laki" <?= (isset($pegawai['jenis_kelamin']) && $pegawai['jenis_kelamin'] === 'laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
        <option value="perempuan" <?= (isset($pegawai['jenis_kelamin']) && $pegawai['jenis_kelamin'] === 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
    </select>
    <div id="jenis_kelamin_error" class="invalid-feedback">Pilih jenis kelamin terlebih dahulu.</div>
</div>

    <!-- Input Status Pegawai -->
<div class="form-group mb-3">
    <label for="status_pegawai">Status Pegawai</label>
    <select name="status_pegawai" class="form-select" id="estatus_peg">
        <?php if (isset($pegawai['status_pegawai']) && !empty($pegawai['status_pegawai'])) : ?>
            <option value="<?= esc($pegawai['status_pegawai']); ?>"><?= esc($pegawai['status_pegawai']); ?></option>
        <?php else : ?>
            <option value="" selected disabled>Pilih Status Pegawai</option>
        <?php endif; ?>
        <?php foreach ($statuspegawai as $sp): ?>
            <option value="<?= $sp['kode']; ?>" <?= (isset($pegawai['status_pegawai']) && $pegawai['status_pegawai'] === $sp['kode']) ? 'selected' : ''; ?>>
                <?= esc($sp['nama_status']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div id="status_pegawai_error" class="invalid-feedback">Pilih Status pegawai terlebih dahulu.</div>
</div>


    <!-- Input Status Pernikahan -->
<div class="form-group mb-3">
    <label for="status_pernikahan">Status Pernikahan</label>
    <select name="status_pernikahan" class="form-select" id="estatus_perni">
        <?php if (isset($pegawai['status_pernikahan']) && !empty($pegawai['status_pernikahan'])) : ?>
            <option value="<?= esc($pegawai['status_pernikahan']); ?>"><?= esc($pegawai['status_pernikahan']); ?></option>
        <?php else : ?>
            <option value="" selected disabled>Pilih Status Pernikahan</option>
        <?php endif; ?>
        <?php foreach ($statuspernikahan as $sp): ?>
            <option value="<?= $sp['kode']; ?>" <?= (isset($pegawai['status_pernikahan']) && $pegawai['status_pernikahan'] === $sp['kode']) ? 'selected' : ''; ?>>
                <?= esc($sp['status']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div id="status_pernikahan_error" class="invalid-feedback">Pilih status pernikahan terlebih dahulu.</div>
</div>

    <!-- Input Jumlah Anak -->
    <div class="form-group mb-3">
        <label for="jumlah_anak">Jumlah Anak</label>
        <input type="text" name="jumlah_anak" class="form-control" value="<?= esc($pegawai['jumlah_anak']); ?>">
    </div>

    <!-- Input Foto -->
    <div class="form-group mb-3">
        <label for="foto">Foto</label><br>
        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
        <?php if (!empty($pegawai['foto'])): ?>
        <?php endif; ?>
    </div>


    <!-- Input Agama -->
<div class="form-group mb-3">
    <label for="agama">Agama</label>
    <select name="agama" id="eagamaa" class="form-select">
        <?php if (isset($pegawai['agama']) && !empty($pegawai['agama'])) : ?>
            <option value="<?= esc($pegawai['agama']); ?>"><?= esc($pegawai['agama']); ?></option>
        <?php else : ?>
            <option value="" selected disabled>Pilih Agama</option>
        <?php endif; ?>
        <?php foreach ($agama as $a): ?>
            <option value="<?= $a['kode']; ?>" <?= (isset($pegawai['agama']) && $pegawai['agama'] === $a['kode']) ? 'selected' : ''; ?>>
                <?= esc($a['nama_agama']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div id="agama_error" class="invalid-feedback">Pilih agama terlebih dahulu.</div>
</div>                    
    </div>
    

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning fw-semibold" style="margin-right: 22px;">Simpan</button>
    </div>
    
</form>
