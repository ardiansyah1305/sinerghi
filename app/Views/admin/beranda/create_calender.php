<form action="<?= site_url('admin/beranda/calender/createKalender'); ?>" method="post">
    <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="start">Tanggal Mulai</label>
        <input type="date" class="form-control" id="start" name="start" required>
    </div>
    <div class="form-group">
        <label for="end">Tanggal Selesai</label>
        <input type="date" class="form-control" id="end" name="end">
    </div>
    <button type="submit" class="btn btn-primary">Tambah Event</button>
</form>
