<form action="<?= site_url('admin/kalender/update/' . $calender['id']); ?>" method="post">
    <?= csrf_field(); ?>

    <div class="modal-body">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $calender['title']; ?>" required>
        </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea class="form-control" id="description" name="description" required><?= $calender['description']; ?></textarea>
    </div>
    <div class="form-group">
        <label for="start">Tanggal Mulai</label>
        <input type="date" class="form-control" id="start" name="start" value="<?= $calender['start']; ?>" required>
    </div>
    <div class="form-group">
        <label for="end">Tanggal Akhir</label>
        <input type="date" class="form-control" id="end" name="end" value="<?= $calender['end']; ?>" required>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>

</form>