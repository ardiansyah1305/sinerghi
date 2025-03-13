<form action="<?= site_url('admin/popup/store'); ?>" method="post"  enctype="multipart/form-data" id="addpopupForm">
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="form-group">
            <label for="image">Foto</label>
            <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png">
            <small id="error-message" style="color: red; display: none;"></small>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>

</form>

<!-- <script>
    document.getElementById('addpopupForm').addEventListener('submit', function(event) {
        const imageInputt = document.getElementById('image');
        const errorMessagee = document.getElementById('error-message');
        const file = imageInputt.files[0];

        // Reset pesan error dan border
        errorMessagee.style.display = 'none';
        errorMessagee.textContent = '';
        imageInputt.style.border = '2px solid #ff0000';

        // Validasi apakah file telah dipilih
        if (!file) {
            showError('Silakan pilih file gambar.', imageInputt, errorMessagee);
            event.preventDefault();
            return;
        }

        // Validasi ukuran file (maksimal 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            showError('Ukuran file tidak boleh lebih dari 2MB.', imageInputt, errorMessagee);
            event.preventDefault();
            return;
        }

        // Validasi format file
        const allowedExtensions = ['image/jpeg', 'image/png'];
        if (!allowedExtensions.includes(file.type)) {
            showError('Format file tidak valid. Hanya .jpg, .jpeg, atau .png yang diperbolehkan.', imageInputt, errorMessagee);
            event.preventDefault();
            return;
        }
    });

    function showError(message, inputElement, errorElement) {
        // Menampilkan pesan error
        errorElement.textContent = message;
        errorElement.style.display = 'block';

        // Menambahkan border merah pada input
        inputElement.style.border = '2px solid red';

        // Menghilangkan error setelah 5 detik
        setTimeout(() => {
            errorElement.style.display = 'none';
            inputElement.style.border = '2px solid #ff0000';
        }, 5000);
    }
</script> -->