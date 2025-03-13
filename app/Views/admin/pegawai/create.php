<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Pegawai</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Pegawai</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/pegawai/store'); ?>" method="post" id="pegawaiiForm" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?= csrf_field(); ?>

                <!-- NIP -->
                <div class="form-group mb-3">
                    <label for="nip">NIP <span class="text-danger">*</span></label>
                    <input type="number" id="nip" name="nip" class="form-control" required>
                    <small id="error-nip" class="text-danger"></small>
                </div>

                <!-- Gelar Depan -->
                <div class="form-group mb-3">
                    <label for="gelar_depan">Gelar Depan</label>
                    <input type="text" id="gelar_depan" name="gelar_depan" class="form-control">
                </div>

                <!-- Nama -->
                <div class="form-group mb-3">
                    <label for="nama">Nama <span class="text-danger">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                    <small id="error-nama" class="text-danger"></small>
                </div>

                <!-- Gelar Belakang -->
                <div class="form-group mb-3">
                    <label for="gelar_belakang">Gelar Belakang</label>
                    <input type="text" id="gelar_belakang" name="gelar_belakang" class="form-control">
                </div>

                <!-- Tempat Lahir -->
                <div class="form-group mb-3">
                    <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required>
                    <small id="error-tempat_lahir" class="text-danger"></small>
                </div>

                <!-- Tanggal Lahir -->
                <div class="form-group mb-3">
                    <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
                    <small id="error-tanggal_lahir" class="text-danger"></small>
                </div>

                <!-- Pangkat -->
                <div class="form-group mb-3">
                    <label for="pangkat">Pangkat <span class="text-danger">*</span></label>
                    <select id="pangkat" name="pangkat" class="form-select select2" required>
                        <option value="" disabled selected>-- Pilih Pangkat --</option>
                        <?php foreach ($jenjangpangkat as $jp): ?>
                            <option value="<?= $jp['kode']; ?>"><?= esc($jp['nama_pangkat']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-pangkat" class="text-danger"></small>
                </div>

                <!-- Golongan Ruang -->
                <div class="form-group mb-3">
                    <label for="golongan_ruang">Golongan Ruang <span class="text-danger">*</span></label>
                    <select id="golongan_ruang" name="golongan_ruang" class="form-select select2" required>
                        <option value="" disabled selected>-- Pilih Golongan Ruang --</option>
                        <?php foreach ($jenjangpangkat as $jp): ?>
                            <option value="<?= $jp['golongan']; ?><?= $jp['ruang']; ?>"><?= esc($jp['golongan']); ?>/<?= esc($jp['ruang']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-golongan_ruang" class="text-danger"></small>
                </div>

                <!-- Jabatan -->
                <div class="form-group mb-3">
                    <label for="jabatan_id">Jabatan <span class="text-danger">*</span></label>
                    <select id="jabatan_id" name="jabatan_id" class="form-select select2" required>
                        <option value="" disabled selected>-- Pilih Jabatan --</option>
                        <?php foreach ($jabatan as $jbt): ?>
                            <option value="<?= $jbt['id']; ?>"><?= esc($jbt['nama_jabatan']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-jabatan_id" class="text-danger"></small>
                </div>

                <!-- Unit Kerja -->
                <div class="form-group mb-3">
                    <label for="unit_kerja_id">Unit Kerja <span class="text-danger">*</span></label>
                    <select id="unit_kerja_id" name="unit_kerja_id" class="form-select select2" required>
                        <option value="" disabled selected>-- Pilih Unit Kerja --</option>
                        <?php foreach ($unit as $uk): ?>
                            <option value="<?= $uk['id']; ?>"><?= esc($uk['nama_unit_kerja']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-unit_kerja_id" class="text-danger"></small>
                </div>

                <!-- Input Kelas Jabatan -->
                <div class="form-group mb-3">
                    <label for="kelas_jabatan" class="form-label">Kelas Jabatan <span class="text-danger">*</span></label>
                    <select name="kelas_jabatan" class="form-select select2">
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

                    <!-- Jenis Kelamin -->
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select select2" required>
                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                        <small id="error-jenis_kelamin" class="text-danger"></small>
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
                        <small id="error-status_pegawai" class="text-danger"></small>
                    </div>

                    <!-- Input Agama -->
                    <div class="form-group mb-3">
                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agamaa" class="form-select select2">
                            <option value="" selected disabled>-- Pilih Agama --</option>
                            <?php foreach ($agama as $a): ?>
                                <option value="<?= $a['kode']; ?>"><?= esc($a['nama_agama']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small id="error-agama" class="text-danger"></small>
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
                        <small id="error-status_pernikahan" class="text-danger"></small>
                    </div>

                    <!-- Input Jumlah Anak -->
                    <div class="form-group mb-3">
                        <label for="jumlah_anak" class="form-label">Jumlah Anak</label>
                        <input type="text" name="jumlah_anak" class="form-control" id="jumlah_anak">
                        <small id="error-jumlah_anak" class="text-danger"></small>
                    </div>

                    <!-- Foto -->
                    <div class="form-group mb-3">
                        <label for="foto">Foto <small class="text-muted">(Format: jpg, jpeg, png)</small></label>
                        <input type="file" id="foto" name="foto" class="form-control" accept="image/jpeg, image/png">
                        <small id="error-foto" class="text-danger"></small>
                    </div>

                    <!-- Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4', // Gunakan tema Bootstrap 4
            placeholder: "-- Pilih --",
            allowClear: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Saat form disubmit
        $('#pegawaiiForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form secara default

            const form = $(this);
            const url = form.attr('action');
            $('small.text-danger').text(''); // Reset pesan error

            $.ajax({
                url: url,
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'error') {
                        // Menampilkan pesan error secara dinamis
                        for (const field in response.errors) {
                            // Menampilkan error pada elemen small dengan id yang sesuai
                            $(`#error-${field}`).text(response.errors[field]);

                            // Fokus pada input yang terkait dengan error
                            $(`#${field}`).focus();

                            // Menghilangkan pesan error setelah 20 detik
                            setTimeout(function() {
                                $(`#error-${field}`).text('');
                            }, 20000); // 20000 ms = 20 detik
                        }
                    } else if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                        }).then(() => {
                            // Redirect menggunakan base_url()
                            window.location.href = '<?php echo base_url('admin/pegawai'); ?>';
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Tampilkan error di log console
                    console.error('Status:', status); // Status request
                    console.error('Error:', error); // Pesan error
                    console.error('Response:', xhr.responseText); // Detail response dari server

                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan server.',
                        icon: 'error',
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>