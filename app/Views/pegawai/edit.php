<!-- edit.php -->

<form action="<?= site_url('pegawai/pegawai/update/'); ?><?= esc($pegawai['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <!-- Input NIP -->
    <div class="form-group mb-3">
        <label for="nip">NIP</label>
        <input type="text" name="nip" class="form-control" value="<?= esc($pegawai['nip']); ?>" required>
    </div>

    <!-- Input Gelar Depan -->
    <div class="form-group mb-3">
        <label for="gelar_depan">Gelar Depan</label>
        <input type="text" name="gelar_depan" class="form-control" value="<?= esc($pegawai['gelar_depan']); ?>" required>
    </div>

    <!-- Input Nama -->
    <div class="form-group mb-3">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= esc($pegawai['nama']); ?>" required>
    </div>

    <!-- Input Gelar Belakang -->
    <div class="form-group mb-3">
        <label for="gelar_belakang">Gelar Belakang</label>
        <input type="text" name="gelar_belakang" class="form-control"  value="<?= esc($pegawai['gelar_belakang']); ?>" required>
    </div>
    
    <!-- Input Tempat Lahir -->
    <div class="form-group mb-3">
        <label for="tempat_lahir">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control" value="<?= esc($pegawai['tempat_lahir']); ?>" required>
    </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tanggal_lahir">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="<?= esc($pegawai['tanggal_lahir']); ?>" required>
    </div>

    <!-- Input Pangkat -->
    <div class="form-group mb-3">
        <label for="pangkat">Pangkat</label>
        <input type="text" name="pangkat" class="form-control" value="<?= esc($pegawai['pangkat']); ?>" required>
    </div>

    <!-- Input Golongan Ruang -->
    <div class="form-group mb-3">
        <label for="golongan_ruang">Golongan Ruang</label>
        <input type="text" name="golongan_ruang" class="form-control" value="<?= esc($pegawai['golongan_ruang']); ?>" required>
    </div>

    <div class="form-group mb-3">
    <label for="jabatan_id">Jabatan</label>
    <select name="jabatan_id" class="form-control" required>
    <option value="">Select Jabatan</option>
        
        <?php if (!empty($jabatan)) : ?>
            <?php foreach ($jabatan as $jbt) : ?>
                
                <option value="<?= $jbt['id']; ?>"><?= $jbt['nama_jabatan']; ?></option>
            <?php endforeach; ?>
        <?php else : ?>
            <option value="">Data jabatan tidak ditemukan</option>
        <?php endif; ?>
    </select>
</div>

<div class="form-group mb-3">
    <label for="unit_kerja_id">Unit Kerja</label>
    <select name="unit_kerja_id" class="form-control" required>
        <option value="">Select Unit Kerja</option>
        <?php if (!empty($unit_kerja)) : ?>
            <?php foreach ($unit_kerja as $uk) : ?>
                <option value="<?= $uk['id']; ?>"><?= $uk['nama_unit_kerja']; ?></option>
            <?php endforeach; ?>
        <?php else : ?>
            <option value="">Data unit kerja tidak ditemukan</option>
        <?php endif; ?>
    </select>
</div>


    <!-- Input Kelas Jabatan -->
    <div class="form-group mb-3">
        <label for="kelas_jabatan">Kelas Jabatan</label>
        <input type="text" name="kelas_jabatan" class="form-control" value="<?= esc($pegawai['kelas_jabatan']); ?>" required>
    </div>

    <!-- Input Jenis Kelamin -->
    <div class="form-group mb-3">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <input type="text" name="jenis_kelamin" class="form-control" value="<?= esc($pegawai['jenis_kelamin']); ?>" required>
    </div>

    <!-- Input Status Aktif -->
    <div class="form-group mb-3">
        <label for="is_active">Is Active</label>
        <input type="text" name="is_active" class="form-control" value="<?= esc($pegawai['is_active']); ?>" required>
    </div>

    <!-- Input Total Angka Kredit -->
    <div class="form-group mb-3">
        <label for="total_angka_kredit">Total Angka Kredit</label>
        <input type="text" name="total_angka_kredit" class="form-control" value="<?= esc($pegawai['total_angka_kredit']); ?>" required>
    </div>

    <!-- Input Status Pernikahan -->
    <div class="form-group mb-3">
        <label for="status_pernikahan">Status Pernikahan</label>
        <input type="text" name="status_pernikahan" class="form-control" value="<?= esc($pegawai['status_pernikahan']); ?>" required>
    </div>

    <!-- Input Jumlah Anak -->
    <div class="form-group mb-3">
        <label for="jumlah_anak">Jumlah Anak</label>
        <input type="text" name="jumlah_anak" class="form-control" value="<?= esc($pegawai['jumlah_anak']); ?>" required>
    </div>

    <!-- Input Foto -->
    <div class="form-group mb-3">
        <label for="foto">Foto</label>
        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png" required>
    </div>

    <!-- Input Saldo Cuti -->
    <div class="form-group mb-3">
        <label for="saldo_cuti">Saldo Cuti</label>
        <input type="text" name="saldo_cuti" class="form-control" value="<?= esc($pegawai['saldo_cuti']); ?>" required>
    </div>

    <!-- Input Agama -->
    <div class="form-group mb-3">
        <label for="agama">Agama</label>
        <input type="text" name="agama" class="form-control" value="<?= esc($pegawai['agama']); ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning">Save Changes</button>
    </div>
</form>
