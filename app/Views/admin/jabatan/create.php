<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Jabatan</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Jabatan</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/jabatan/store'); ?>" method="post" enctype="multipart/form-data" id="jabatanForm" class="needs-validation" novalidate>
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="nama_jabatan">Nama Jabatan
                        <span class="fs-5 text-danger">*</span>
                    </label>
                    <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control">
                    <small id="error-jabatan" class="text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label for="tipe_jabatan">Tipe Jabatan <br>
                        <small class="text-muted fst-italic">Apabila jabatan merupakan Eselon, silakan pilih jenis Eselon</small>
                    </label>
                    <select name="tipe_jabatan" id="tipe_jabatan" class="form-select select2">
                        <option value="" selected disabled>-- Pilih Tipe Jabatan --</option>
                        <option value="Struktural">Struktural</option>
                        <option value="Fungsional">Fungsional</option>
                        <option value="PPPK">PPPK</option>
                        <option value="Pelaksana">Pelaksana</option>
                        <option value="NonAsn">Non Asn</option>
                    </select>
                    <small id="error-tipe-jabatan" class="text-danger"></small>
                </div>

                <div class="form-group mb-3" id="eselon-group" style="display: none;">
                    <label for="eselon">Eselon <br>
                        <small class="text-muted fst-italic">Apabila jabatan merupakan Eselon, silakan pilih jenis Eselon</small>
                    </label>
                    <select name="eselon" id="eselon" class="form-select select2">
                        <option value="" selected>-- Pilih Eselon --</option>
                        <?php foreach ($eselons as $eselon): ?>
                            <option value="<?= $eselon['kode']; ?>"><?= esc($eselon['nama_eselon']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-eselon" class="text-danger"></small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-semibold" style="margin-right: 22px;">Simpan</button>
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

        // Tampilkan atau sembunyikan field eselon berdasarkan tipe jabatan
        $('#tipe_jabatan').on('change', function() {
            const selectedTipe = $(this).val();
            if (selectedTipe === 'Struktural') {
                $('#eselon-group').show();
                $('#eselon').prop('disabled', false);
            } else {
                $('#eselon-group').hide();
                $('#eselon').prop('disabled', true);
                $('#eselon').val(null).trigger('change'); // Reset pilihan eselon
            }
        });

        // Saat form disubmit
        $('#jabatanForm').on('submit', function(e) {
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
                        if (response.errors) {
                            for (const field in response.errors) {
                                // Menampilkan error pada elemen small dengan id yang sesuai
                                $(`#error-${field}`).text(response.errors[field]);

                                // Fokus pada input yang terkait dengan error (jika hanya error pertama)
                                $(`#${field}`).addClass('is-invalid');
                            }
                        }
                    } else if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                        }).then(() => {
                            // Redirect menggunakan base_url()
                            window.location.href = '<?php echo base_url('admin/jabatan'); ?>';
                        });
                    }
                },
                error: function(xhr, status, error) {
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