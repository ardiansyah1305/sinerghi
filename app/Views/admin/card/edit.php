<form action="<?= site_url('admin/card/update/' . $cards['id']); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $cards['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="short_description">Deskripsi Singkat</label>
            <textarea class="form-control" id="short_description" name="short_description" required><?= $cards['short_description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" required><?= $cards['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Foto</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="<?= base_url('img/' . $cards['image']); ?>" alt="Current Image" class="mt-2 border border-secondary-subtle p-1" style="max-width: 100px; border-radius: 4px;">
        </div>
	<div class="form-group">
            <label for="start">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start" name="start" value="<?= $cards['start']; ?>" required>
        </div>
        <div class="form-group">
            <label for="end">Tanggal Akhir</label>
            <input type="date" class="form-control" id="end" name="end" value="<?= $cards['end']; ?>" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary fw-semibold text-black" data-dismiss="modal">Batal</button>
	<button type="submit" class="btn btn-warning fw-semibold text-black" style="margin-right: 22px;">Simpan</button>
    </div>

</form>