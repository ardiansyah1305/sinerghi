<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<style>
    .container {
        padding-top: 40px;
    }

    .card {
    }
    .card-title {
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

    
    <div id="menteri" class="row justify-content-center">
    <!-- Tampilan Pegawai Utama -->
    <?php if (isset($pegawaiUtama)): ?>
    
    <div class="col-md-3"> 
                    <div class="cards h-100 shadow" style="width: 205px;">
                        <div class="cards-body">
                    <h5 class="cards-title"><?= esc($pegawaiUtama['nama_unit_kerja']) ?></h5>
                    </div>
                <img src="<?= base_url('img/' . esc($pegawaiUtama['foto'])) ?>" class="cards-img-top" alt="Foto <?= esc($pegawaiUtama['nama']) ?>">
                <div class="card-footer">
                   <p class="card-text fw-bold"><?= esc($pegawaiUtama['gelar_depan']) ?> <?= esc($pegawaiUtama['nama']) ?>, <?= esc($pegawaiUtama['gelar_belakang']) ?></p>
                    </div>
                    </div>
                </div>
    </div>
<?php else: ?>
    <p class="text-center text-danger">Pegawai utama tidak ditemukan.</p>
<?php endif; ?>

<div id="staffResults" class="row justify-content-center mt-3">
        <!-- Hasil pencarian akan muncul di sini -->
    </div>

    <!-- Tampilan Pegawai Terkait -->
    <div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (!empty($relatedPegawai)): ?>
            <?php foreach ($relatedPegawai as $emp): ?>
                <div class="card mb-4 mt-2 w-100 shadow" style="max-width: 100%;">
                    <div class="row g-0 align-items-center"> <!-- Tambahkan align-items-center untuk vertical alignment -->
                        <div class="col-md-3 mt-2 mb-3" style="padding-left: 65px;"> <!-- Sesuaikan padding dan tambahkan justify-content-center -->
                            <img src="<?= base_url('img/' . esc($emp['foto'])) ?>" class="img-fluid rounded" alt="Foto <?= esc($emp['nama']) ?>" style="max-height: 100px; max-width: 100px;"> <!-- Tambahkan max-height jika perlu -->
                        </div>                        <div class="col-md-9 mt-2 mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($emp['gelar_depan']) ?> <?= esc($emp['nama']) ?> <?= esc($emp['gelar_belakang']) ?></h5>
                                <p class="card-text"><?= esc($emp['nama_unit_kerja']) ?></p> <!-- Display 'unit_kerja' -->
                                <a data-bs-toggle="collapse" href="#collapse<?= esc($emp['id']) ?>" role="button" aria-expanded="false" aria-controls="collapse<?= esc($emp['id']) ?>">
                                    Lihat Pegawai
                                </a>
                            </div>
                        </div>
                    </div>
                </div> <!-- Card end -->

                <!-- Tabel bawahan hanya akan tampil saat tombol 'Lihat Pegawai' diklik -->
                <div class="card-body" style="max-width: 100%;">
                    <div class="collapse" style="max-width: 100%;" id="collapse<?= esc($emp['id']) ?>">

                        <?php if (!empty($relateddPegawai[$emp['nama']])): ?>
                            <table id="example" class="table table-responsive" style="width: 100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border align-middle text-center">No</th>
                                        <th class="border">Nama</th>
                                        <th class="border">Jabatan</th>
                                        <th class="border">Golongan</th>
                                        <th class="border">Ruang</th>
                                        <th class="border">Tipe Pegawai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($relateddPegawai[$emp['nama']] as $re): ?>
                                        <tr>
                                            <td class="border align-middle text-center"><?= $i++; ?></td>
                                            <td class="border"><?= esc($re['nama']) ?></td>
                                            <td class="border"><?= esc($re['nama_jabatan']) ?></td>
                                            <td class="border"><?= isset($re['golongan']) ? esc($re['golongan']) : 'N/A' ?></td>
                                            <td class="border"><?= isset($re['ruang']) ? esc($re['ruang']) : 'N/A' ?></td>
                                            <td class="border"><?= isset($re['tipe_pegawai']) ? esc($re['tipe_pegawai']) : 'N/A' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-center">Tidak ada bawahan untuk pegawai ini.</p>
                        <?php endif; ?>

                    </div>
                </div> <!-- Tabel div end -->

            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-warning">Pegawai terkait tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</div>

</div>

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
    width: 100% !important; /* Menggunakan lebar 100% agar lebih fleksibel */
    margin-bottom: 15px;
}

.card-body img {
    width: 100%;
    height: auto;
    object-fit: cover;
  }

.card-body {
    padding: 10px;
    margin-top: 0; /* Mengurangi jarak atas */
}

.card-body .collapse {
    margin-top: 0; /* Mengurangi margin pada collapse */
}

.card img {
    width: auto; /* Agar gambar menyesuaikan secara proporsional */
    max-width: 100%; /* Agar gambar tidak melampaui card */
    max-height: 100px; /* Membatasi tinggi gambar */
    height: auto; /* Menjaga proporsi gambar */
    object-fit: cover; /* Ensure proper scaling for images */
}
@media (min-width: 768px) {
    .col {
        flex: 0 0 auto;
        width: 33.333333%;
    }
}

.card-title {
    font-size: 1rem; /* Ukuran font lebih kecil */
    margin-bottom: 5px; /* Mengurangi margin bawah */
}

.card-titles {
    font-size: 1rem; /* Ukuran font lebih kecil */
    margin-bottom: 5px; /* Mengurangi margin bawah */
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

  /* pembatas */
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

  .table {
    margin-top: 0; /* Mengurangi margin atas pada tabel */
    border-radius: 8px;
}
</style>




   <!-- card -->
    
</div>
            </div>


<?= $this->endSection(); ?>