<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Usulan Jadwal Kerja</h2>
    <div class="card shadow rounded-4">
        <div class="card-body">
            <form id="formJadwal" enctype="multipart/form-data">
                <div class="row">
                    <!-- Daftar Pegawai -->
                    <div class="col-md-4">
                        <h5>Daftar Pegawai</h5>
                        <ul class="list-group" id="pegawaiList">
                            <?php foreach ($data_pegawai_unit as $pegawai) : ?>
                                <li class="list-group-item pegawai-item" data-id="<?= $pegawai['id']; ?>">
                                    <?= $pegawai['nama']; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Kalender dengan Checkbox -->
                    <div class="col-md-8">
                        <div class="calendar-container">
                            <h5 id="pegawaiTitle">Jadwal Kerja</h5>
                            <div id="calendar"></div>
                            <button class="btn btn-primary mt-3" id="btnSimpan">Simpan</button>
                        </div>
                    </div>
                </div>

                <br>
                <label for="file">Unggah File (PDF):</label>
                <input type="file" id="file" name="file" accept=".pdf" required>

                <br><br>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-warning" id="btnAjukan">Ajukan Permohonan</button>
                <button type="reset" class="btn btn-secondary">Batal</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- <script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4', 
            placeholder: "-- Pilih --",
            dropdownParent: $('#modalJadwal')
        });
    });
</script> -->
<!-- <script>
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
</script> -->

<?= $this->endSection(); ?>