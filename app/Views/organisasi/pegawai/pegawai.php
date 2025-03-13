<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    .container {
        padding-top: 40px;
    }

    .card {
      text-align: center;
    }
    .card-title {
    word-break: break-word;
    white-space: normal;
    
}
.cards {
      text-align: center;
    }
    .cards-title {
    word-break: break-word;
    white-space: normal;
    
}
.equal-height-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.scroll-item {
    display: flex;
    align-items: stretch;
}
.scroll-container {
    display: flex;
    overflow-x: auto;
    padding: 10px;
    gap: 10px; /* Jarak antar-kartu */
}

.card-body h8 {
    word-break: break-word;
    white-space: normal;
}
.cards-body h8 {
    word-break: break-word;
    white-space: normal;
}
    .scroll-container {
      overflow-x: hidden;
      white-space: nowrap;
      padding: 1rem;
      scroll-behavior: smooth;
      display: flex;
      align-items: center;
    }
    .scroll-container::-webkit-scrollbar {
      display: none;
    }
    .scroll-item {
      display: inline-block;
      margin-right: 10px;
    }
    .arrow-icon {
      font-size: 24px;
      cursor: pointer;
      padding: 10px;
      user-select: none;
    }

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
        list-style-type: none;
        padding: 0;
    }

    .menu-list li {
        padding: 5px 0;
    }

    .menu-list a {
        text-decoration: none;
        color: black;
    }

    .menu-list a:hover {
        color: blue;
    }
    .btn-primary-custom {
        background-color: #1687a6;
        color: #FFFFFF;
      }
      .btn-primary-custom:hover {
        background-color: #126e87;
        color: #FFFFFF;
      }
</style>
<div class="container-fluid">
    <!-- Row untuk elemen-elemen di dalam container -->
    <div class="row justify-content-between p-2" style="height: 55px;">
        <!-- Tombol arrow kiri di pojok kiri atas -->
        <div class="col-4">
        <a href="<?= base_url('organisasi') ?>" class="btn btn-primary-custom px-2 py-1">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
        </div>
       

        <!-- Tombol search di pojok kanan atas -->
        <div class="col-4">
            <!-- Field pencarian dengan event oninput untuk memicu pencarian -->
            <input class="form-control ms-2 me-2" type="text" id="searchInput" placeholder="Pencarian" oninput="searchStaff()" aria-label="Search">
        </div>
    </div>
    <!-- Pesan error jika pegawai tidak ditemukan -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    
    <div class="container mt-4">
    <!-- Tampilan Pegawai Utama -->
    <?php if (isset($pegawaiUtama)): ?>
      <!-- Debugging with var_dump() -->
      <div class="row">
      <div class="card mb-4 mt-4 w-100 shadow">
        <div class="row g-0">
            <div class="col-md-3">
                <div class="card-body">
                <img src="<?= base_url('img/' . esc($pegawaiUtama['foto'])) ?>" class="card-img-top" alt="Gambar Atasan">
                </div>
            </div>
            <div class="col-md-9">
                <div class="card-body">
                <h5 class="card-title"><?= esc($pegawaiUtama['gelar_depan']) ?> <?= esc($pegawaiUtama['nama']) ?> <?= esc($pegawaiUtama['gelar_belakang']) ?></h5>
                                    <p class="card-text"><?= esc($pegawaiUtama['pangkat']) ?></p>
                                    </div>
            </div>
        </div>
    </div>
                </div>
<?php else: ?>
    <p>Pegawai utama tidak ditemukan.</p>
<?php endif; ?>

<table id="example" class="table ms-auto border table-responsive-lg shadow" style="max-width: 100%;">
            <thead>
                <tr>
                    <th class="text-center border">No</th>
                    <th class="text-center border">Nama</th>
                    <th class="text-center border">Jabatan</th>
                    <th class="text-center border">Golongan</th>
                    <th class="text-center border">Tipe Pegawai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                </tr>
                <?php if (!empty($relatedPegawaies2)): ?>
    <?php $i = 1; foreach ($relatedPegawaies2 as $pgw): ?>
        <tr>
            <td class="text-center border"><?= $i++; ?></td>
            <td class="text-center border"><?= esc($pgw['nama']); ?></td>
            <td class="text-center border"><?= esc($pgw['nama_jabatan'] ?? 'No Jabatan Available'); ?></td>
            <td class="text-center border"><?= esc($pgw['golongan_ruang']); ?></td>
            <td class="text-center border"><?= esc($pgw['tipe_pegawai']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="text-center border">Tidak ada data pegawai terkait</td>
    </tr>
<?php endif; ?>

                </tbody>
            </table>

    

<style>
/* Mengatur tinggi card */
.d-flex {
    display: flex;
    flex-wrap: nowrap; /* Menjaga card tetap dalam satu baris */
    justify-content: flex-start; /* Agar card berada di kiri, bisa diganti dengan 'center' jika ingin di tengah */
    overflow-x: auto; /* Memungkinkan scrolling horizontal jika card melebihi lebar layar */
    width: 100%; /* Memastikan kontainer mengisi lebar penuh */
}

.card {
    flex-grow: 1; /* Agar card mengisi ruang yang tersisa */
    margin-right: 10px; /* Jarak antar card */
    max-width: 100%; /* Pastikan card bisa melebar */
    height: auto; /* Agar card menyesuaikan tinggi konten */
}
.card-body img {
    width: 100%;
    height: auto;
    object-fit: cover;
  }

.card-body {
    padding: 10px; /* Mengurangi padding untuk menurunkan tinggi card */
}

.card img {
    width: auto; /* Agar gambar menyesuaikan secara proporsional */
    max-width: 100%; /* Agar gambar tidak melampaui card */
    max-height: 100px; /* Membatasi tinggi gambar */
    height: auto; /* Menjaga proporsi gambar */
}
.card-title {
    font-size: 1rem; /* Ukuran font lebih kecil */
    margin-bottom: 5px; /* Mengurangi margin bawah */
    word-wrap: break-word; /* Untuk menangani teks panjang */
}

.card-titles {
    font-size: 1rem; /* Ukuran font lebih kecil */
    margin-bottom: 5px; /* Mengurangi margin bawah */
    word-wrap: break-word; /* Untuk menangani teks panjang */
}

.card-text {
    font-size: 0.9rem; /* Ukuran font lebih kecil */
    margin: 0; /* Menghilangkan margin untuk teks pangkat */
}

.col-md-4, .col-md-8 {
    padding: 0; /* Menjaga jarak antar kolom di dalam card */
}
.cards {
    height: 100%;
  }

  /* Posisi gambar di tengah dan menyesuaikan ukuran */
  .cards-body img {
    width: 100%;
    height: auto;
    object-fit: cover;
  }

  /* Memastikan card-footer selalu berada di bagian bawah */
  .cards-footer {
    border-top: none;
    background-color: #fff;
    font-size: small;
  }
  
  /* Mengatur header agar tidak memiliki border */
  .cards-header {
    /* border-bottom: none;
    background-color: #fff; */
    font-size: small;
  }
</style>




   <!-- card -->
    
</div>
            </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                        content.classList.add('animate_animated', 'animate_fadeIn');
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate_animated', 'animate_fadeIn');
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
                    content.classList.add('animate_animated', 'animate_fadeIn');
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
                        content.classList.add('animate_animated', 'animate_fadeIn');
                        found = true;
                    } else {
                        content.style.display = 'none';
                        content.classList.remove('animate_animated', 'animate_fadeIn');
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
                content.classList.add('animate_animated', 'animate_fadeIn');
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