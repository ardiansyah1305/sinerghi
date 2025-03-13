<?= $this->extend('layouts/admin'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Backup & Restore Database</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-4">
                        <h5>Buat Backup Baru</h5>
                        <p>Backup akan menyimpan seluruh data aplikasi saat ini untuk dapat dikembalikan di masa mendatang jika diperlukan.</p>
                        <form action="<?= base_url('admin/backup/create'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download mr-1"></i> Buat Backup Baru
                            </button>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <h5>Daftar File Backup</h5>
                        <?php if (empty($backupFiles)) : ?>
                            <div class="alert alert-info">
                                Belum ada file backup yang tersedia.
                            </div>
                        <?php else : ?>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama File</th>
                                        <th>Ukuran</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($backupFiles as $file) : ?>
                                        <tr>
                                            <td><?= esc($file['name']); ?></td>
                                            <td><?= esc($file['size']); ?></td>
                                            <td><?= esc($file['date']); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('admin/backup/download/' . esc($file['name'], 'url')); ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-success restore-btn" data-filename="<?= esc($file['name']); ?>">
                                                        <i class="fas fa-undo"></i> Restore
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-filename="<?= esc($file['name']); ?>">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Restore Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">Konfirmasi Restore</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin melakukan restore dari file <span id="restore-filename" class="font-weight-bold"></span>?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Perhatian: Proses restore akan menimpa seluruh data yang ada saat ini. Data yang telah ditimpa tidak dapat dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('admin/backup/restore'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="backup_file" id="restore-file-input">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Restore Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus file backup <span id="delete-filename" class="font-weight-bold"></span>?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Perhatian: File yang telah dihapus tidak dapat dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('admin/backup/delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="backup_file" id="delete-file-input">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus File</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Restore button click
        $('.restore-btn').click(function() {
            var filename = $(this).data('filename');
            $('#restore-filename').text(filename);
            $('#restore-file-input').val(filename);
            $('#restoreModal').modal('show');
        });
        
        // Delete button click
        $('.delete-btn').click(function() {
            var filename = $(this).data('filename');
            $('#delete-filename').text(filename);
            $('#delete-file-input').val(filename);
            $('#deleteModal').modal('show');
        });
    });
</script>
<?= $this->endSection(); ?>
