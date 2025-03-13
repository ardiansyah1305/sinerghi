<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    .sidebar {
        border-right: 1px solid #ccc;
        height: 100vh;
    }

    .main-content {
        text-align: center;
    }

    .content-title {
        margin-top: 30px;
    }

    .image-placeholder {
        width: 100%;
        height: 400px;
        border: 1px solid #ccc;
        background: url('path-to-image-placeholder') no-repeat center center;
        background-size: cover;
    }

    .menu-list {
        list-style-type padding: 0;
    }

    .menu-list li {
        padding: 5px 0;
    }

    .menu-list a {
        text-decoration color: black;
    }

    .menu-list a:hover {
        color: blue;
    }

    .table {
        font-family: "Inter", sans-serif;
        font-style: normal;
        /* border-collapse: collapse; */
        width: 100%;
    }

    .th {
        text-align: center;
        padding: 8px;
        border: 1px solid;
        border-top: 1px solid;
        border-left: 1px solid;
    }

    .te {
        text-align: center;
        border-left: 1px solid;
    }

    .td {
        padding: 8px;
    }

    .th {
        background-color: #f2f2f2;
    }
</style>



<div class="container-fluid p-0" style="margin-top: 20px;">
    <div class="row no-gutters">
        <?= $this->include('organisasi/sidebarkiri'); ?>
        <div class="card shadow-sm mb-3 mr-md-3 flex-shrink-0 referensi-sidebar animate__animated animate__fadeInLeft">

            <div class="row">
                <?= $this->include('organisasi/menkopmk'); ?>
                <?= $this->include('organisasi/sesmenko'); ?>
                <?= $this->include('organisasi/staffahli'); ?>
                <?= $this->include('organisasi/inspektorat'); ?>
                <?= $this->include('organisasi/deputi'); ?>
            </div>
        </div>
    </div>

    <!-- Konten Kanan -->
    <div class="col-md-9 p-4">
        <div class="card mx-auto" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Kepala Biro Hukum, Persidangan, Organisasi, dan Komunikasi</p>
            </div>
            <img src="<?= base_url('images/pratikno.jpg'); ?>" class="card-img-top" alt="..." style="width: 280px; height: 230px; object-fit: cover;">
            <div class="card-body">
                <p class="card-text">Dyah Tri Kumolosari</p>
            </div>
        </div>
        <br>
        <div class="p-3 text-emphasis bg-subtle">
            <table class="table border 1px">
                <tr>
                    <th style="border-right: 1px solid;" class="text-center th">No</th>
                    <th style="border-right: 1px solid;" class="text-center th">Nama</th>
                    <th style="border-right: 1px solid;" class="text-center th">Jabatan</th>
                    <th style="border-right: 1px solid;" class="text-center th">Tipe Pegawai</th>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">1</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">2</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">3</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">4</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">5</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">6</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">7</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">8</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">9</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid;" class="text-center te">10</td>
                    <td style="border-right: 1px solid;" class="text-center te">Nama</td>
                    <td style="border-right: 1px solid;" class="text-center te">Jabatan</td>
                    <td style="border-right: 1px solid;" class="text-center te">Tipe Pegawai</td>
                </tr>
            </table>

        </div>

        <br>




    </div>
</div>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.unit-kerja-btn').forEach(button => {
        button.addEventListener('click', function() {
            const namaUnitKerja = this.getAttribute('data-nama');
            const parentId = this.getAttribute('data-parent-id');

            // Tampilkan detail di div sebelah kanan
            document.getElementById('nama_unit_kerja').innerText = 'Nama Unit Kerja: ' + namaUnitKerja;
            document.getElementById('parent_id').innerText = 'Parent ID: ' + parentId;
        });
    });
</script>

<!-- Script untuk Mengelola Pencarian dan Tombol Back -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const organisasiLinks = document.querySelectorAll('.list-group-item');
        const organisasiContents = document.querySelectorAll('.organisasi-content');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const backButton = document.getElementById('backButton');

        if (organisasiContents.length > 0) {
            organisasiContents[0].style.display = 'block';
        }

        organisasiLinks.forEach(link => {
            link.addEventListener('click', function() {
                const organisasiId = this.getAttribute('data-organisasi-id');

                organisasiContents.forEach(content => {
                    if (content.getAttribute('data-organisasi-id') === organisasiId) {
                        content.style.display = 'block';
                        content.classList.add('animate__animated', 'animate__fadeIn');
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate__animated', 'animate__fadeIn');
                    }
                });

                organisasiLinks.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
            });
        });

        searchButton.addEventListener('click', function() {
            const query = searchInput.value.toLowerCase();

            if (query === '') {
                organisasiContents.forEach(content => {
                    content.style.display = 'block';
                    content.classList.add('animate__animated', 'animate__fadeIn');
                    const cards = content.querySelectorAll('.referensi-card');
                    cards.forEach(card => {
                        card.style.display = 'block';
                    });
                });
                organisasiLinks.forEach((link, index) => {
                    link.classList.toggle('active', index === 0);
                });
            } else {
                let found = false;

                organisasiContents.forEach(content => {
                    const cards = content.querySelectorAll('.referensi-card');
                    let cardFound = false;

                    cards.forEach(card => {
                        const title = card.getAttribute('data-title');
                        if (title.includes(query)) {
                            card.style.display = 'block';
                            cardFound = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (cardFound) {
                        content.style.display = 'block';
                        content.classList.add('animate__animated', 'animate__fadeIn');
                        found = true;
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate__animated', 'animate__fadeIn');
                    }
                });

                organisasiLinks.forEach(link => {
                    link.style.display = 'block';
                    link.classList.remove('active');
                });

                if (!found) {
                    alert('No results found');
                }
            }
        });

        backButton.addEventListener('click', function() {
            searchInput.value = '';
            organisasiContents.forEach(content => {
                content.style.display = 'block';
                content.classList.add('animate__animated', 'animate__fadeIn');
                const cards = content.querySelectorAll('.referensi-card');
                cards.forEach(card => {
                    card.style.display = 'block';
                });
            });
            organisasiLinks.forEach((link, index) => {
                link.classList.toggle('active', index === 0);
            });
        });

        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                searchButton.click();
            }
        });
    });
</script>

<?= $this->endSection(); ?>