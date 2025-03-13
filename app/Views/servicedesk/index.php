<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    .rounded-table {
        border-radius: 15px;
        /* Ganti dengan radius sesuai preferensi */
        overflow: hidden;
        /* Pastikan elemen yang melampaui border tidak terlihat */
    }

    /* Membuat baris tabel lebih rounded */
    .rounded-table th,
    .rounded-table td {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    /* Styling untuk modal yang juga lebih rounded */
    .modal-content.rounded-table {
        border-radius: 15px;
    }

    /* Jika ingin border tabel lebih halus */
    .table-borderless {
        border: 0;
    }

    /* Styling untuk tombol filter */
    .btn-outline-secondary {
        border-radius: 30px;
        /* Sudut lebih bulat */
    }
</style>

<div class="container my-5">
    <!-- Filter & Statistics -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Pencarian">
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTicketModal">Buat Tiket</button>
        </div>
    </div>

    <div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTicketModalLabel">BUAT TIKET</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('/servicedesk/insert'); ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <!-- Pemohon -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Pemohon</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control" value="<?= esc($pegawai['nama']) ?>" readonly>
                                <input type="hidden" name="id_pegawai" value="<?= esc($pegawai['id']) ?>">
                            </div>
                        </div>

                        <!-- Unit Kerja -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Unit Kerja</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="unit_kerja_id" value="<?= esc($pegawai['unit_kerja_id']) ?>">
                                <input type="text" name="unit_kerja" class="form-control" value="<?= esc($pegawai['unit_kerja']) ?>" readonly>
                            </div>
                        </div>

                        <!-- Jenis Layanan -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select id="select-data" name="layanan" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <?php foreach ($layanan as $data): ?>
                                        <option value="<?= esc($data['id']) ?>" <?= old('layanan') == $data['id'] ? 'selected' : '' ?>>
                                            <?= esc($data['jenis_layanan']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="layanan-error"></div>
                            </div>
                        </div>

                        <!-- Detail Permohonan -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Detail Permohonan <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <textarea name="detail_permohonan" class="form-control" rows="4" placeholder="Tuliskan detail permohonan di sini..."><?= old('detail_permohonan') ?></textarea>
                                <div class="invalid-feedback" id="detail_permohonan-error"></div>
                            </div>
                        </div>

                        <!-- Dokumen Tambahan -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Dokumen Tambahan <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="file" name="dokumen_tambahan" class="form-control">
                                <div class="invalid-feedback" id="dokumen_tambahan-error"></div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('errors')): ?>
                let errors = <?= json_encode(session()->getFlashdata('errors')) ?>;

                // Show errors below input fields
                for (let field in errors) {
                    let errorMsg = errors[field];
                    let errorField = document.getElementById(field + '-error');
                    if (errorField) {
                        errorField.innerText = errorMsg;
                        errorField.style.display = 'block';

                        // Hide error message after 10 seconds
                        setTimeout(function() {
                            errorField.style.display = 'none';
                        }, 10000); // 10000ms = 10 seconds
                    }
                }
            <?php endif; ?>
        });
    </script>

</div>


<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <div class="icon"><i class="fas fa-ticket"></i></div>
                <h5 class="card-title"><?= esc($totalTiket) ?></h5>
                <p class="card-text">Jumlah Tiket</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <div class="icon"><i class="fas fa-ticket"></i></div>
                <h5 class="card-title text-primary"><?= esc($totalTiketbaru) ?></h5>
                <p class="card-text">Tiket Baru</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <div class="icon"><i class="fas fa-hourglass"></i></div>
                <h5 class="card-title text-warning"><?= esc($totalTiketproses) ?></h5>
                <p class="card-text">Tiket Diproses</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <div class="icon"><i class="fas fa-lock"></i></div>
                <h5 class="card-title text-success"><?= esc($totalTiketDone) ?></h5>
                <p class="card-text">Tiket Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <div class="icon"><i class="fas fa-trash"></i></div>
                <h5 class="card-title text-danger"><?= esc($totalTiketcancel) ?></h5>
                <p class="card-text">Tiket Dibatalkan</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel dalam Card -->
<div class="card card-table">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-borderless mb-0 rounded-table">
                <thead class="table-light">
                    <tr>
                        <th>Kode Tiket</th>
                        <th>Jenis Layanan</th>
                        <th>Penerima Tugas</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tiketallunit as $data): ?>
                        <tr>
                            <td><?= $data['kode_tiket']; ?></td>
                            <td><?= $data['jenis_layanan']; ?></td>
                            <td><?= $data['id_pegawai_penerima_tugas']; ?></td>
                            <td>
                                <?php
                                $status_tiket = $data['status'];
                                if ($status_tiket == 0) :
                                ?>
                                    <span class="badge-status badge-baru">Baru</span>
                                <?php elseif ($status_tiket == 1) : ?>
                                    <span class="badge-status badge-diproses">Diproses</span>
                                <?php elseif ($status_tiket == 2) : ?>
                                    <span class="badge-status badge-selesai">Selesai</span>
                                <?php elseif ($status_tiket == 3) : ?>
                                    <span class="badge-status badge-dibatalkan">Dibatalkan</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $data['tanggal_status_terkini']; ?></td>
                            <td>-</td>
                            <td><a href="<?= base_url('/servicedesk/detail_ticket/') ?><?= $data['kode_tiket']; ?>" class="btn btn-outline-secondary btn-sm">💬</a></td>
                            <td class="star-rating">★★★★★</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-3 table-pagination">
    <div>
        <label for="showEntries">Tampilkan</label>
        <select id="showEntries" class="form-select form-select-sm w-auto d-inline">
            <option value="10" <?= ($limit == 10) ? 'selected' : '' ?>>10</option>
            <option value="20" <?= ($limit == 20) ? 'selected' : '' ?>>20</option>
            <option value="50" <?= ($limit == 50) ? 'selected' : '' ?>>50</option>
        </select>
    </div>
    <nav>
        <ul class="pagination pagination-sm mb-0">
            <!-- Tombol Previous -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= site_url('servicedesk/page/' . ($currentPage - 1)) ?>">&#171;</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#">&#171;</a>
                </li>
            <?php endif; ?>

            <!-- Link Halaman -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= site_url('servicedesk/page/' . $i) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= site_url('servicedesk/page/' . ($currentPage + 1)) ?>">&#187;</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#">&#187;</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const myModal = new bootstrap.Modal(document.getElementById('createTicketModal'), {
            keyboard: true
        });
        myModal.show();

        // Tunda tampilan SweetAlert 1 detik setelah modal muncul
        setTimeout(function() {
            // Cek jika ada flash data untuk sukses
            <?php if (session()->getFlashdata('success')): ?>
                // Mengambil kode tiket dari session dan menampilkan SweetAlert
                let kodeTiket = "<?= session()->getFlashdata('kodeTiket'); ?>"; // Mengambil kode tiket dari session

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Tiket berhasil dibuat dengan kode ' + kodeTiket,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    confirmButtonColor: '#007bff',
                    cancelButtonText: 'Kembali',
                    iconColor: '#007bff', // Warna ceklis (biru)
                    customClass: {
                        confirmButton: 'btn btn-primary' // Menambahkan kelas Bootstrap untuk tombol
                    }
                }).then((result) => {
                    // Jika tombol 'Lanjutkan' ditekan
                    if (result.isConfirmed) {
                        // Lakukan redirect ke halaman detail tiket
                        window.location.href = '<?= base_url('/servicedesk/detail_ticket/') ?>' + kodeTiket;
                    } else {
                        // Jika tombol 'Kembali' ditekan, kembali ke halaman sebelumnya
                        window.location.href = '<?= base_url('/servicedesk') ?>';
                    }
                });
            <?php endif; ?>

            // Cek jika ada flash data untuk error
            <?php if (session()->getFlashdata('errors')): ?>
                let errors = <?= json_encode(session()->getFlashdata('errors')) ?>;
                let errorMsg = '';
                for (let field in errors) {
                    errorMsg += `${errors[field]}\n`;
                }

                Swal.fire({
                    title: 'Gagal!',
                    text: errorMsg,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        }, 1000); // Delay 1 detik untuk menunggu modal muncul
    });
</script>
<?= $this->endSection(); ?>