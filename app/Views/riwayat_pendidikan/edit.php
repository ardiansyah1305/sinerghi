<!-- edit.php -->

<form action="<?= site_url('pegawai/riwayat_pendidikan/update/'); ?><?= esc($riwayat_pendidikan['id']); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
    <label for="pegawai_id">Pegawai</label>
    <select name="pegawai_id" class="form-control" required>
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

    <!-- Input Jenjang -->
    <div class="form-group mb-3">
        <label for="jenjang">Jenjang</label>
        <input type="text" name="jenjang" class="form-control" value="<?= esc($riwayat_pendidikan['jenjang']); ?>" required>
    </div>

    <!-- Input Jurusan -->
    <div class="form-group mb-3">
        <label for="jurusan">Jurusan</label>
        <input type="text" name="jurusan" class="form-control" value="<?= esc($riwayat_pendidikan['jurusan']); ?>">
    </div>


    <!-- Input Universitas -->
    <div class="form-group mb-3">
        <label for="universitas">Universitas</label>
        <input type="text" name="universitas" class="form-control" value="<?= esc($riwayat_pendidikan['universitas']); ?>" required>
    </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tahun_masuk">Tahun Masuk</label>
        <input type="date" name="tahun_masuk" class="form-control" value="<?= esc($riwayat_pendidikan['tahun_masuk']); ?>" required>
    </div>

    <!-- Input Tanggal Lahir -->
    <div class="form-group mb-3">
        <label for="tahun_lulus">Tahun Lulus</label>
        <input type="date" name="tahun_lulus" class="form-control" value="<?= esc($riwayat_pendidikan['tahun_lulus']); ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Simpan</button>
    </div>
</form>
