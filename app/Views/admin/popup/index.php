<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Calendar Section -->
 <div class="container py-4 px-5">
    <h2 class="fw-semibold mb-4">Kelola Popup</h2>
    <div class="card shadow mb-2 mt-4">
        <div class="card-header">
            <h4 class="fw-normal">Popup</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
                <div class="d-flex">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addpopup">
                        <span class="btn-text">Tambah</span>
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>
            </div>
            
        <div class="table-responsive">
            <table class="table ref-table table-striped table-bordered" style="max-width: 100%;">
                <thead class="table bg-light">
                    <tr>
                        <th class="text-center text-white bg-dark">No</th>
                        <th class="text-center text-white bg-dark">Foto</th>
                        <th class="text-center text-white bg-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 1; foreach ($popups as $popup): ?>
                        <tr>
                            <td class="text-center border align-middle"><?= $i++; ?></td>
                            <td class="text-center border align-middle"><img src="<?= base_url('img/' . $popup['image']); ?>" alt="Popup Image" width="100"></td>
                            <td class="text-center border align-middle">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPopupModal<?= $popup['id']; ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button onclick="confirmDelete(<?= $popup['id']; ?>)" class="btn btn-danger border-danger btn-sm custom-delete-btn border">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Edit Card Modal -->
                        <div class="modal fade" id="editPopupModal<?= $popup['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPopupModalLabel<?= $popup['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title" id="editPopupModalLabel<?= $popup['id']; ?>">Edit Popup</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= view('admin/popup/edit', ['popups' => $popup]); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Add Card Modal -->
                        <div class="modal fade" id="addpopup" tabindex="-1" aria-labelledby="addpopupLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="addpopupLabel">Tambah Popup</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <?= view('admin/popup/create'); ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
 </div>

 


<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function confirmDelete(popupId) {
        swal({
                title: "Apa kamu yakin?",
                content: {
                    element: "p",
                    attributes: {
                        innerHTML: "<p>Setelah dihapus, Anda tidak akan dapat memulihkan Popup!</p>",
                        style: "text-align: center; display: block;"
                    }
                },
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Batal",
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Hapus",
                        closeModal: false,
                    },
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = "<?= site_url('admin/popup/delete/'); ?>" + popupId;
                } else {
                    swal("Data kamu aman!");
                }
            });
    }
</script>

<?= $this->endSection(); ?>
