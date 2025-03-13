<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-5 py-4">
    <h2 class="fw-semibold mb-4">Kelola Pengumuman</h2>
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top">
            <h5 class="mb-0">Tambah Pengumuman</h5>
        </div>
        <div class="card-body"></div>
        <form action="<?= site_url('admin/card/store'); ?>" method="post" enctype="multipart/form-data"
            id="addcardForm">
            <?= csrf_field(); ?>

            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Judul <span class="fs-5 text-danger">*</span></label></label>
                    <input type="text" class="form-control" id="title" name="title">
                    <small id="title-error" style="color: red; display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi <span class="fs-5 text-danger">*</span></label></label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                    <small id="description-error" style="color: red; display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="short_description">Deskripsi Singkat <span
                            class="fs-5 text-danger">*</span></label></label>
                    <textarea class="form-control" id="short_description" name="short_description"></textarea>
                    <small id="short_description-error" style="color: red; display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="image">Foto</label>
                    <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png">
                    <small id="image-error" style="color: red; display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="start">Tanggal Mulai <span class="fs-5 text-danger">*</span></label>
                    <input type="date" name="start" class="form-control" id="start">
                    <small id="start-error" style="color: red; display: none;"></small>
                </div>
                <div class="form-group">
                    <label for="end">Tanggal Selesai <span class="fs-5 text-danger">*</span></label>
                    <input type="date" name="end" class="form-control" id="end">
                    <small id="end-error" style="color: red; display: none;"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary fw-semibold text-black"
                    data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success fw-semibold" style="margin-right: 22px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('addcardForm').addEventListener('submit', function (event) {
        let isValid = true;

        // Elemen input
        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const shortDescription = document.getElementById('short_description');
        const image = document.getElementById('image');
        const start = document.getElementById('start');
        const end = document.getElementById('end');

        // Elemen pesan error
        const titleError = document.getElementById('title-error');
        const descriptionError = document.getElementById('description-error');
        const shortDescriptionError = document.getElementById('short_description-error');
        const imageError = document.getElementById('image-error');
        const startError = document.getElementById('start-error');
        const endError = document.getElementById('end-error');

        // Reset pesan error
        clearError(title, titleError);
        clearError(description, descriptionError);
        clearError(shortDescription, shortDescriptionError);
        clearError(image, imageError);
        clearError(start, startError);
        clearError(end, endError);

        // Validasi title
        if (title.value.trim() === '' || title.value.length < 3) {
            showError(title, titleError, 'Judul wajib diisi dan minimal 3 karakter.');
            isValid = false;
        }

        // Validasi description
        if (description.value.trim() === '') {
            showError(description, descriptionError, 'Deskripsi wajib diisi.');
            isValid = false;
        }

        // Validasi short_description
        if (shortDescription.value.trim() === '') {
            showError(shortDescription, shortDescriptionError, 'Deskripsi singkat wajib diisi.');
            isValid = false;
        }

        // Validasi image


        // Validasi tanggal mulai
        if (start.value.trim() === '') {
            showError(start, startError, 'Tanggal Mulai wajib diisi.');
            isValid = false;
        }

        // Validasi tanggal selesai
        if (end.value.trim() === '') {
            showError(end, endError, 'Tanggal Selesai wajib diisi.');
            isValid = false;
        }

        // Cegah submit jika tidak valid
        if (!isValid) {
            event.preventDefault();
        }
    });

    function showError(input, errorElement, message) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        input.style.border = '2px solid red';

        // Hilangkan error setelah 5 detik
        setTimeout(() => {
            clearError(input, errorElement);
        }, 5000);
    }

    function clearError(input, errorElement) {
        errorElement.style.display = 'none';
        if (input.type !== 'file') {
            input.style.border = '1px solid #ced4da';
        }
    }

</script>
<?= $this->endSection(); ?>