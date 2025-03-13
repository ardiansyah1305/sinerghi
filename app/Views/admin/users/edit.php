<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola User</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-warning text-white rounded-top">
            <h5 class="mb-0">Edit User</h5>
        </div>
        <div class="card-body">
            <form id="usersForm" action="<?= site_url('admin/users/update/' . $user['id']); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="form-group mb-3">
                    <label for="pegawai_name">Nama <span class="text-danger">*</span></label>
                    <input type="hidden" class="form-control" id="pegawai_id" name="pegawai_id" value="<?= $user['pegawai_id']; ?>">
                    <input type="text" id="pegawai_name" name="pegawai_name" class="form-control" value="<?= $pegawai['nama']; ?>" disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="password_lama">Password Lama <span class="text-danger">*</span></label>
                    <input type="password" id="old_password" name="old_password" class="form-control" required>
                    <small id="error-old_password" class="text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password Baru <span class="text-danger">*</span></label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small id="error-password" class="text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label for="confirm_password">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    <small id="error-confirm_password" class="text-danger"></small>
                </div>

                <div class="form-group mb-3">
                    <label for="role_id">Role <span class="text-danger">*</span></label>
                    <select id="role_id" name="role_id" class="form-select select2" required>
                        <option value="" selected disabled>-- Pilih Role --</option>
                        <?php foreach ($role as $r): ?>
                            <option value="<?= $r['id']; ?>" <?= $user['role_id'] == $r['id'] ? 'selected' : ''; ?>><?= esc($r['nama_role']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="error-role_id" class="text-danger"></small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary fw-semibold text-black" onclick="window.location.href='<?= base_url('admin/users'); ?>'">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold">Simpan</button>
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
        // Initialize select2 for the role select dropdown
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: "-- Pilih --",
            allowClear: true
        });

        // Form submit event using AJAX
        $('#usersForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form submission

            // Clear previous error messages
            $('small.text-danger').text('');
            $('input, select').removeClass('is-invalid');

            // Get the password and confirm password values
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            // Validate if the passwords match
            if (password !== confirmPassword) {
                $('#error-confirm_password').text('Konfirmasi password tidak cocok dengan password.');
                $('#confirm_password').addClass('is-invalid');
                return; // Prevent form submission if passwords do not match
            }

            // If validation passes, submit the form using AJAX
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
                        // Display errors if response contains errors
                        for (const field in response.errors) {
                            $(`#error-${field}`).text(response.errors[field]);
                            $(`#${field}`).addClass('is-invalid');
                        }
                    } else if (response.status === 'success') {
                        // Show success alert if the operation is successful
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
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>
