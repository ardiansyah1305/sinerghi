<form action="<?= site_url('admin/kalender/store'); ?>" method="post" id="formKalender" onsubmit="return validateForm()">
    <?= csrf_field(); ?>

        <div class="form-group">
            <label for="title">Judul <span class="fs-5 text-danger">*</span></label>
            <input type="text" class="form-control" name="title" id="title">
            <small id="titleError" class="text-danger" style="display:none;"></small>
            <!-- Ikon error menggunakan icon bootstrap -->
            <div id="titleIcon" class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-35%); display: none; font-size: 20px;">
                <i class="bi bi-exclamation-circle text-danger"></i>                    
            </div>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi <span class="fs-5 text-danger">*</span></label>
            <textarea class="form-control" name="description" id="description"></textarea>
            <div class="invalid-feedback">-</div>
        </div>
        <div class="form-group">
            <label for="start">Tanggal Mulai <span class="fs-5 text-danger">*</span></label>
            <input type="date" class="form-control" name="start" id="start">
            <div class="invalid-feedback">-</div>
        </div>
        <div class="form-group">
            <label for="end">Tanggal Selesai <span class="fs-5 text-danger">*</span></label>
            <input type="date" class="form-control" name="end" id="end">
            <div class="invalid-feedback">-</div>
        </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>

</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function validateForm() {
            var title = document.getElementById("title").value;
            var titleError = document.getElementById("titleError");
            var titleInput = document.getElementById("title");
            var titleIcon = document.getElementById("titleIcon");
            var valid = true;
    
            // Menyembunyikan pesan error dan border sebelumnya
            titleError.style.display = "none";
            titleInput.style.border = "";
            titleIcon.style.display = "none";
    
            // Validasi title
            if (title == "") {
                titleError.textContent = "title harus diisi.";
                titleError.style.display = "block";
                titleInput.style.border = "1px solid red";
                titleIcon.style.display = "block";
                valid = false;
            }
    
            // Menghilangkan pesan error dan border setelah 5 detik
            if (!valid) {
                setTimeout(function() {
                    titleError.style.display = "none";
                    titleInput.style.border = "";
                    titleIcon.style.display = "none";
                }, 5000); // 5 detik
            }
    
            return valid;
        }
    </script>
</script>

