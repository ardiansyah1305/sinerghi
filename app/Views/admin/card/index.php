<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Calendar Section -->
 <div class="container py-4 px-5">
    <h2 class="fw-semibold text-uppercase mb-4">Kelola Pengumuman</h2>
    <div class="card shadow rounded-4 mb-2 mt-4">
        
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3 mt-2">
                <div class="d-flex">
                    <a href="<?= base_url('admin/card/create'); ?>" class="btn btn-success"><span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i></a>
                    <!-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addcardModal">
                        
                    </button> -->
                </div>
            </div>

            
        <div class="table-responsive">
            <table class="table ref-table table-striped table-bordered" style="max-width: 100%;">
                <thead class="table bg-light">
                    <tr>
                        <th class="text-center text-white bg-dark">No</th>
                        <th class="text-center text-white bg-dark" style="width: 160px;">Judul</th>
                        <!-- <th class="text-center text-white bg-dark">Deskripsi</th> -->
                        <th class="text-center text-white bg-dark" style="width: 300px;">Pengumuman</th>
                        <th class="text-center text-white bg-dark">Gambar</th>
                        <th class="text-center text-white bg-dark">Mulai</th>
                        <th class="text-center text-white bg-dark">Selesai</th>
                        <th class="text-center text-white bg-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                    <?php foreach ($cards as $card): ?>
                        <tr>
                            <td class="text-center border align-middle"><?= $i++; ?></td>
                            <td class="border align-middle"><?= $card['title']; ?></td>
                            <td class="border align-middle"><?= $card['short_description']; ?></td>
                            <td class="text-center border align-middle"><img src="<?= base_url('img/' . $card['image']); ?>" alt="Card Image" width="100"></td>
                            <td class="text-center border align-middle"><?= $card['start']; ?></td>
                            <td class="text-center border align-middle"><?= $card['end']; ?></td>
                            <td class="text-center border align-middle">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCardModal<?= $card['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDeleteCard(<?= $card['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Edit Card Modal -->
                        <div class="modal fade" id="editCardModal<?= $card['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCardModalLabel<?= $card['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title text-center text-black w-100" id="editCardModalLabel<?= $card['id']; ?>">Edit Pengumuman</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= view('admin/card/edit', ['cards' => $card]); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Add Card Modal -->
                        <!-- <div class="modal fade" id="addcardModal" tabindex="-1" aria-labelledby="addcardModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title text-center text-white w-100" id="addcardModalLabel">Tambah Pengumuman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div> -->

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
 </div>

 


<!-- Include SweetAlert library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDeleteCard(cardId) {
        Swal.fire({
            title: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Berhasil Terhapus!",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    window.location.href = "<?= site_url('admin/card/delete/'); ?>" + cardId;
                });
            }
        });
    }
    
</script>

<?php if (session()->getFlashdata('success_card')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: "<?= session()->getFlashdata('success_card'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php elseif (session()->getFlashdata('error_card')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: "<?= session()->getFlashdata('error_card'); ?>",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });
    </script>
<?php endif; ?>


<?= $this->endSection(); ?>
