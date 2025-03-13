<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola User</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah User</h5>
        </div>
        <div class="card-body"><!-- create.php -->
            <form action="<?= site_url('admin/users/store'); ?>" method="post" enctype="multipart/form-data" id="usersForm" class="needs-validation" novalidate>
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="pegawai_id">Nama <span class="text-danger">*</span></label>
                    <select id="pegawai_id" name="pegawai_id" class="form-select select2" required>
                        <option value="" selected disabled>-- Pilih Nama Pegawai --</option>
                        <?php foreach ($pegawai as $p): ?>
                            <option value="<?= $p['id']; ?>"><?= esc($p['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-pegawai_id" class="text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label for="user_ldap">USERNAME LDAP <span class="text-danger">*</span></label>
                    <input type="text" id="username_ldap" name="username_ldap" class="form-control" required>
                    <small id="error-user_ldap" class="text-danger"></small>
                </div>

                <!-- <div class="form-group mb-3">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small id="error-password" class="text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label for="confirm_password">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    <small id="error-confirm_password" class="text-danger"></small>
                </div> -->

                <div class="form-group mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select id="role_id" name="role_id" class="form-select select2" required>
                        <option value="" selected disabled>-- Pilih Role --</option>
                        <?php foreach ($role as $r): ?>
                            <option value="<?= $r['id']; ?>"><?= esc($r['nama_role']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-role_id" class="text-danger"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary fw-semibold text-black" onclick="window.location.href='<?= base_url('admin/users'); ?>'">Batal</button>
                    <button type="submit" class="btn btn-success fw-semibold">Simpan</button>
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
        $('#usersForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form

            // Ambil nilai password dan confirm_password
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            // Reset pesan error sebelumnya
            $('small.text-danger').text('');
            $('input').removeClass('is-invalid');

            // Validasi password dan confirm_password
            // if (password !== confirmPassword) {
            //     $('#error-confirm_password').text('Konfirmasi password tidak cocok dengan password.');
            //     $('#confirm_password').addClass('is-invalid');

            //     // Menghilangkan pesan error setelah 15 detik
            //     setTimeout(function() {
            //         $('#error-confirm_password').text('');
            //         $('#confirm_password').removeClass('is-invalid');
            //     }, 15000); // 15000 ms = 15 detik

            //     return; // Hentikan pengiriman form
            // }

            // Jika validasi lolos, lanjutkan dengan pengiriman form
            const form = $(this);
            const url = form.attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'error') {
                        for (const field in response.errors) {
                            $(`#error-${field}`).text(response.errors[field]);
                            $(`#${field}`).addClass('is-invalid');

                            // Menghilangkan pesan error setelah 15 detik
                            setTimeout(function() {
                                $(`#error-${field}`).text('');
                                $(`#${field}`).removeClass('is-invalid');
                            }, 15000); // 15000 ms = 15 detik
                        }
                    } else if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                        }).then(() => {
                            window.location.href = '<?= base_url('admin/users'); ?>';
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan server.',
                        icon: 'error',
                    });
                },
            });
        });
    });
</script>

<?= $this->endSection(); ?>