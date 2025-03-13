
<form action="<?= site_url('admin/jabatan/store'); ?>" method="post">
    <?= csrf_field(); ?>
    <div class="form-group mb-3">
                <label for="nama_jabatan" class="required-label">Nama Jabatan</label>
                <input type="text" id="nama_jabatan" name="nama_jabatan" class="form-control" required>
            </div>
    <div class="form-group mb-3">
        <label for="is_fungsional">Fungsional</label>
        <input type="text" name="is_fungsional" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="is_pelaksana">Pelaksana</label>
        <input type="text" name="is_pelaksana" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="eselon">Eselon</label>
        <input type="text" name="eselon" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="is_pjp">Pjp</label>
        <input type="text" name="is_pjp" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="is_pppk">Pppk</label>
        <input type="text" name="is_pppk" class="form-control">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script>
        // Menambahkan pesan validasi kustom pada elemen input
        document.getElementById("nama_jabatan").addEventListener("invalid", function(e) {
            // Hanya tampilkan pesan jika input kosong
            if (e.target.value === "") {
                e.target.setCustomValidity("Field ini harus diisi");
            } else {
                e.target.setCustomValidity("");
            }
        });

        document.getElementById("nama_jabatan").addEventListener("input", function(e) {
            e.target.setCustomValidity(""); // Hapus pesan saat pengguna mulai mengetik
        });
    </script>