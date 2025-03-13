<form action="<?= site_url('pegawai/pegawai/uploadCSV'); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <label for="csv_file">File :</label> <br>
    <input type="file" name="csv_file" accept=".csv, .xlsx" required>
    
    <!-- Tombol Simpan dan Tutup -->
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary-add">Upload CSV</button>
    </div>
</form>