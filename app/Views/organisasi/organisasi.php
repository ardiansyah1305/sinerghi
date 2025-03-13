<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    .container {
        padding-top: 20px;
    }

    .card {
        text-align: center;
        width: 170px; /* Atur lebar kartu */
        height: auto; /* Sesuaikan tinggi dengan konten */
        margin: 5px; /* Jarak antar kartu */
        font-size: 12px; /* Ukuran font default untuk seluruh card */
    }

    .card-title {
        font-size: 10px; /* Perkecil ukuran font judul */
        font-weight: bold;
        line-height: 1.2; /* Sesuaikan jarak antar baris */
    }

    .card-text {
        font-size: 10px; /* Ukuran font deskripsi */
        line-height: 1.2;
        margin: 0; /* Hilangkan margin tambahan */
    }

    .card-img-top {
        height: 220px; /* Sesuaikan tinggi gambar */
        object-fit: cover; /* Gambar tetap proporsional */
    }

    .card-footer {
        padding: 5px; /* Perkecil padding footer */
        font-size: 10px; /* Ukuran font footer */
    }

    .card-body {
        padding: 5px; /* Perkecil padding body */
    }
.equal-height-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 75%;
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
</style>

<div class="container-fluid">
    <!-- Row untuk elemen-elemen di dalam container -->
    <div class="row justify-content-between p-2" style="height: 55px;">
        <!-- Tombol arrow kiri di pojok kiri atas -->
        <div class="col-4">
            <a href="#" class="btn btn-primary-custom px-2 py-1">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
        </div>

        <!-- Tombol search di pojok kanan atas -->
        <div class="col-4">
            <!-- Field pencarian dengan event oninput untuk memicu pencarian -->
            <input class="form-control ms-2 me-2" type="text" id="searchInput" placeholder="Pencarian" oninput="searchPegawai()" aria-label="Search">
        </div>
    </div>
    
    <!-- Card utama di atas -->
    <div id="menteri" class="row justify-content-center">
    <?php foreach ($pegawai as $emp): ?>
        <?php if ($emp['unit_kerja_id'] == 1): ?>
            <div class="col-auto"> 
                <div class="card shadow">
                    <div class="card-body">
                        <small class="card-title"><?= esc($emp['nama_pangkat'] ?? 'Tidak Ada Pangkat') ?></small>
                    </div>
                    <img src="<?= base_url('img/' . esc($emp['foto'])) ?>" class="card-img-top" alt="Gambar Atasan">
                    <div class="card-footer">
                        <p class="card-text fw-bold"><?= esc($emp['gelar_depan']) ?> <?= esc($emp['nama']) ?>, <?= esc($emp['gelar_belakang']) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

    <!-- Elemen untuk menampilkan hasil pencarian -->
    <div id="pegawaiResults" class="row justify-content-center mt-3">
        <!-- Hasil pencarian akan muncul di sini -->
    </div>

<div class="container">
        <div class="position-relative">

            <!-- Slideshow -->
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <?php
                        $counter = 0;
                        $isActive = true; // Menandai slide pertama sebagai aktif
                        foreach ($pegawaieselon1 as $index => $ps1):
                            // Mulai slide baru setiap 5 kartu
                            if ($counter % 4 == 0): ?>
                                <div class="carousel-item <?= $isActive ? 'active' : '' ?> p-5">
                        <div class="row">
                        <?php
                            $isActive = false; // Setelah slide pertama, set ke false
                            endif; ?>
                            <div class="col">
                                <div class="card h-100 shadow" style="width: 175px; height: 50px">
                                <div class="card-body">
                                <small class="card-title"><?= esc($ps1['nama_jabatan'] ?? 'Tidak Ada Pangkat') ?></small>
                                
                            </div>
                            <a href="<?= base_url('organisasi/pegawai/' . urlencode(esc($ps1['nama']))) ?>" class="text-decoration-none">
    <img class="img-fluid" alt="Foto" src="<?= base_url('img/' . esc($ps1['foto'])) ?>">
    <div class="card-footer">
        </a>
        
        <p class="card-text fw-bold"><?= esc($ps1['gelar_depan']) ?> <?= esc($ps1['nama']) ?>, <?= esc($ps1['gelar_belakang']) ?></p>
                            
        
    </div>
                                    
                                </div>
                            </div>
                            <?php
                            $counter++;
                            // Tutup slide saat sudah mencapai 5 kartu atau data habis
                            if ($counter % 4 == 0 || $index == count($pegawaieselon1) - 1): ?>
                             
                        </div>
                    </div>
                    <?php endif;
                        endforeach; ?>
                </div>
            </div>

            <!-- Tombol Next -->
            <button id="b-prev" class="btn btn-primary position-absolute end-0 top-50 translate-middle-y" data-bs-target="#carouselExample" data-bs-slide="next">
                <i class="bi bi-arrow-right"></i>
            </button>
            <!-- Tombol Previous -->
            <button id="b-next" class="btn btn-primary position-absolute start-0 top-50 translate-middle-y" data-bs-target="#carouselExample" data-bs-slide="prev">
                <i class="bi bi-arrow-left"></i>
            </button>

        </div>
    </div>

    </div></div>
    
<style>
    .carousel-control-prev,
.carousel-control-next {
    top: 50%; /* Tombol berada di tengah secara vertikal */
    transform: translateY(-50%); /* Untuk menyelaraskan posisi */
    z-index: 10; /* Pastikan tombol di atas konten lainnya */
}

.carousel-control-prev {
    left: 10px; /* Atur jarak dari tepi kiri */
}

.carousel-control-next {
    right: 10px; /* Atur jarak dari tepi kanan */
}

  /* Mengatur tinggi card */
  </style>



   <!-- card -->
    
</div>
            </div>
            
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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




<?= $this->endSection(); ?>