<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">

  <title>Admin Dashboard</title>

  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('images/pmklogo.png'); ?>">


  <!-- Custom styles for this template-->
  <link href="<?= base_url('css/sb-admin-2.min.css'); ?>" rel="stylesheet">

  <link href="<?= base_url('css/index.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('css/bootstrap.css'); ?>" rel="stylesheet" />
  <link href="<?= base_url('css/dataTables.bootstrap5.css'); ?>" rel="stylesheet" />

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <!-- CDN memuat Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

  

  <!-- Style Custom Sidebar Admin -->

  <style>
    /* style custome */

    /* body {
        background-color: #f7f9fa;
      } */

    /* Navbar Style */
    .logo-custome:hover {
      background-color: #d9d9d9;
    }

    /* Sidebar Style Custome */
    .nav-item:hover {
      background-color: #d9d9d9;
    }

    .nav-item.active {
      background-color: #d9d9d9;
      /* Warna background untuk item aktif */
      /* color: white; */
      font-weight: 600;
    }


    /* custome card border kiri */

    /* --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545; */

    .border-left-users-custom {
      border-left: 4px solid #5B878E;
    }

    .border-left-danger-custom {
      border-left: 4px solid #dc3545;
    }

    .border-left-warning-custom {
      border-left: 4px solid #ffc107;
    }

    .border-left-success-custom {
      border-left: 4px solid #198754;
    }

    .border-left-info-custom {
      border-left: 4px solid #0dcaf0;
    }

    .border-left-purple-custom {
      border-left: 4px solid #6f42c1;
    }

    .border-left-orange-custom {
      border-left: 4px solid #fd7e14;
    }



    .card-custom-size {
      height: 175px;
      width: 100%;
    }

    /* Button */

    .btn-primary-custom {
      width: 100%;
      background-color: #1687a6;
      color: #FFFFFF;
    }

    .btn-primary-custom:hover {
      background-color: #126e87;
      color: #FFFFFF;
    }

    .btn-danger-custom {
      width: 100%;
      background-color: #dc3545;
      color: #FFFFFF;
    }

    .btn-danger-custom:hover {
      background-color: #c32232;
      color: #FFFFFF;
    }

    .btn-warning-custom {
      width: 100%;
      background-color: #ffc107;
      color: #000000;
    }

    .btn-warning-custom:hover {
      background-color: #e6ac00;
      color: #000000;
    }

    .btn-success-custom {
      width: 100%;
      background-color: #198754;
      color: #FFFFFF;
    }

    .btn-success-custom:hover {
      background-color: #146c43;
      color: #FFFFFF;
    }

    .btn-info-custom {
      width: 100%;
      background-color: #0dcaf0;
    }

    .btn-info-custom:hover {
      background-color: #0aa3c2;
      color: #FFFFFF;
    }

    .btn-purple-custom {
      width: 100%;
      background-color: #6f42c1;
      color: #FFFFFF;
    }

    .btn-purple-custom:hover {
      background-color: #6138ad;
      color: #FFFFFF;
    }

    .btn-orange-custom {
      width: 100%;
      background-color: #fd7e14;
      color: #FFFFFF;
    }

    .btn-orange-custom:hover {
      background-color: #e36802;
      color: #FFFFFF;
    }

    /* Style dashboard */
    .btn-users-custom {
      width: 100%;
      background-color: #5B878E;
      color: #FFFFFF;
    }

    .btn-users-custom:hover {
      background-color: #50767c;
      color: #FFFFFF;
    }

    .btn-slider-custom {
      width: 100%;
      background-color: #78A980;
      color: #FFFFFF;
    }

    .btn-slider-custom:hover {
      background-color: #639c6d;
      color: #FFFFFF;
    }

    .btn-popup-custom {
      width: 100%;
      background-color: #D07046;
      color: #FFFFFF;
    }

    .btn-popup-custom:hover {
      background-color: #b6582f;
      color: #FFFFFF;
    }

    .btn-pengumuman-custom {
      width: 100%;
      background-color: #4692D0;
      color: #FFFFFF;
    }

    .btn-pengumuman-custom:hover {
      background-color: #2f7ab6;
      color: #FFFFFF;
    }

    .btn-kalender-custom {
      width: 100%;
      background-color: #D04649;
      color: #FFFFFF;
    }

    .btn-kalender-custom:hover {
      background-color: #b62f31;
      color: #FFFFFF;
    }

    .btn-unit-kerja-custom {
      width: 100%;
      background-color: #DCBC46;
      color: #FFFFFF;
    }

    .btn-unit-kerja-custom:hover {
      background-color: #d6b129;
      color: #FFFFFF;
    }

    .btn-referensi-custom {
      width: 100%;
      background-color: #EE5F62;
      color: #FFFFFF;
    }

    .btn-referensi-custom:hover {
      background-color: #ec4649;
      color: #FFFFFF;
    }

    .btn-layanan-custom {
      width: 100%;
      background-color: #46D0A9;
      color: #FFFFFF;
    }

    .btn-layanan-custom:hover {
      background-color: #2fb690;
      color: #FFFFFF;
    }

    .btn-jabatan-custom {
      width: 100%;
      background-color: #cc0099;
      color: #FFFFFF;
    }

    .btn-jabatan-custom:hover {
      background-color: #990073;
      color: #FFFFFF;
    }

    .btn-rp-custom {
      width: 100%;
      background-color: #cc33ff;
      color: #FFFFFF;
    }

    .btn-rp-custom:hover {
      background-color: #bf00ff;
      color: #FFFFFF;
    }

    .btn-pustaka-custom {
      width: 100%;
      background-color: #76b833;
      color: #FFFFFF;
    }

    .btn-pustaka-custom:hover {
      background-color: #66a02c;
      color: #FFFFFF;
    }

    /* border left */
    .border-left-users-custom {
      border-left: 4px solid #5B878E;
    }

    .border-left-slider-custom {
      border-left: 4px solid #78A980;
    }

    .border-left-popup-custom {
      border-left: 4px solid #D07046;
    }

    .border-left-pengumuman-custom {
      border-left: 4px solid #4692D0;
    }

    .border-left-kalender-custom {
      border-left: 4px solid #D04649;
    }

    .border-left-unit-kerja-custom {
      border-left: 4px solid #DCBC46;
    }

    .border-left-referensi-custom {
      border-left: 4px solid #EE5F62;
    }

    .border-left-layanan-custom {
      border-left: 4px solid #46D0A9;
    }

    .border-left-jabatan-custom {
      border-left: 4px solid #cc0099;
    }

    .border-left-rp-custom {
      border-left: 4px solid #cc33ff;
    }

    .border-left-pustaka-custom {
      border-left: 4px solid #76b833;
    }

    /* text color */
    .text-users-custom {
      color: #5B878E;
      font-size: 16px;
    }

    .text-slider-custom {
      color: #78A980;
      font-size: 16px;
    }

    .text-popup-custom {
      color: #D07046;
      font-size: 16px;
    }

    .text-pengumuman-custom {
      color: #4692D0;
      font-size: 16px;
    }

    .text-kalender-custom {
      color: #D04649;
      font-size: 16px;
    }

    .text-unit-kerja-custom {
      color: #DCBC46;
      font-size: 16px;
    }

    .text-referensi-custom {
      color: #EE5F62;
      font-size: 16px;
    }

    .text-pustaka-custom {
      color: #76b833;
      font-size: 16px;
    }

    .text-layanan-custom {
      color: #46D0A9;
      font-size: 16px;
    }

    .text-jabatan-custom {
      color: #cc0099;
      font-size: 16px;
    }

    .text-rp-custom {
      color: #cc33ff;
      font-size: 16px;
    }

    /* Style dashboard */

    /* Buton Halaman Utama */
    .btn-haluta-custom {
      background-color: #1687a6;
      color: #FFFFFF;
    }

    .btn-haluta-custom:hover {
      background-color: #126e87;
      color: #FFFFFF;
    }

    /* Button add */
    .btn-success-add {
      background-color: #198754;
      color: #FFFFFF;
    }

    .btn-success-add:hover {
      background-color: #146c43;
      color: #FFFFFF;
    }

    .btn-info-add {
      background-color: #0dcaf0;
    }

    .btn-info-add:hover {
      background-color: #0aa3c2;
    }

    .btn-orange-add {
      background-color: #fd7e14;
      color: #FFFFFF;
    }

    .btn-orange-add:hover {
      background-color: #e36802;
      color: #FFFFFF;
    }

    .btn-purple-add {
      background-color: #6f42c1;
      color: #FFFFFF;
    }

    .btn-purple-add:hover {
      background-color: #6138ad;
      color: #FFFFFF;
    }

    .btn-search-custom {
      background-color: #1687a6;
      color: #FFFFFF;
    }

    .btn-search-custom:hover {
      background-color: #126e87;
      color: #FFFFFF;
    }


    /* Style button card */
    /* .btn-success-custom-pegawai {
        width: 100%;
        background-color: #32ba49;
        color: #FFFFFF;
      }
      .btn-success-custom-pegawai:hover {
        background-color: #2ba13f;
        color: #FFFFFF;
      } */


    /* Color Text */

    .fs-custome {
      font-size: 18px;
    }

    .text-primary-custom {
      color: #126e87;
      font-size: 16px;
    }

    .text-danger-custom {
      color: #dc3545;
      font-size: 16px;
    }

    .text-success-custom {
      color: #198754;
      font-size: 16px;
    }

    .text-warning-custom {
      color: #ffc107;
      font-size: 16px;
    }

    .text-info-custom {
      color: #0dcaf0;
      font-size: 16px;
    }

    .text-purple-custom {
      color: #6f42c1;
      font-size: 16px;
    }

    .text-orange-custom {
      color: #fd7e14;
      font-size: 16px;
    }

    /* Text custome card dashboard pegawai */
    .text-pegawai-custom {
      font-size: 18px;
    }

    .text-jabatan-custom {
      font-size: 16px;
    }

    .text-penpeg-custom {
      font-size: 18px;
    }

    .text-riwpen-custom {
      font-size: 18px;
    }

    .text-induk-unit-kerja-custom {
      font-size: 18px;
    }


    /* Style Icon */
    .fa-arrow-right {
      padding-top: 6px;
      font-size: 14px;
    }

    .btn-link-custom i {
      font-weight: 600;
      font-size: 20px;
      color: #000000;
    }

    .font-size-custom {
      font-size: 120px;
    }


    /* Scroll top */
    .btn-scroll-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      display: none;
      /* Awalnya disembunyikan */
      z-index: 99;
      opacity: 0.8;
    }

    .btn-scroll-top:hover {
      opacity: 1;
    }

    .bi-arrow-up-circle {
      font-size: 26px;
    }

    /* .calendar-container {
            display: none;
            margin-top: 10px;
        } */
  </style>

</head>

<!-- <body id="page-top"> -->

<body class="sb-nav-fixed">

  <!-- Navbar dan Sidebar-->
  <?= $this->include('admin/layout/navbar'); ?>

  <div id="layoutSidenav_content">
    <main>
      <?= $this->renderSection('content'); ?>
    </main>

    <!-- Footer -->
    <?= $this->include('admin/layout/footer'); ?>

  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Kode inisialisasi Select2 -->
  <script>
    $(document).ready(function() {
      // Inisialisasi Select2 pada elemen dengan kelas 'select2'
      $('.select2').select2({
        width: '100%' // Agar Select2 mengambil lebar penuh
      });
    });
  </script>
  <!-- jQuery and Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script> -->
  <!-- <script src="<?= base_url('vendor/fontawesome-free/js/all.min.js'); ?>"></script> -->
  <script src="<?= base_url('js/sb-admin-2.min.js'); ?>"></script>
  <script src="<?= base_url('js/scripts.js'); ?>"></script>

  <script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('js/dataTables.js'); ?>"></script>
  <script src="<?= base_url('js/dataTables.bootstrap5.js'); ?>"></script>
  <!-- <script src="<//?= base_url('js/jquery-3.7.1.js'); ?>"></script> -->


  <?= $this->renderSection('scripts'); ?>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Mendapatkan URL saat ini
      const currentUrl = window.location.href;

      // Mendapatkan semua elemen nav-item
      const navItems = document.querySelectorAll('.nav-item');

      navItems.forEach(navItem => {
        // Mendapatkan link dalam nav-item
        const link = navItem.querySelector('a');
        if (link && link.href === currentUrl) {
          // Menambahkan kelas "active" ke nav-item yang sesuai
          navItem.classList.add('active');
        } else {
          // Menghapus kelas "active" jika tidak sesuai
          navItem.classList.remove('active');
        }
      });
    });
  </script>


  <script>
    new DataTable('#example');
  </script>



  <script>
    document.getElementById("unitKerjaForm").addEventListener("submit", function(event) {
      let valid = true;

      // Cek input Nama Unit Kerja
      let namaUnitKerja = document.getElementById("nama_unit_kerja");
      if (namaUnitKerja.value.trim() === "") {
        document.getElementById("nama_unit_kerja_error").style.display = "inline";
        namaUnitKerja.classList.add("is-invalid");
        valid = false;
      } else {
        document.getElementById("nama_unit_kerja_error").style.display = "none";
        namaUnitKerja.classList.remove("is-invalid");
      }

      // Cek input Induk Unit Kerja
      let parentId = document.getElementById("parent_id");
      if (parentId.value.trim() === "") {
        document.getElementById("parent_id_error").style.display = "inline";
        parentId.classList.add("is-invalid");
        valid = false;
      } else {
        document.getElementById("parent_id_error").style.display = "none";
        parentId.classList.remove("is-invalid");
      }

      // Jika ada field yang kosong, jangan lanjutkan proses submit
      if (!valid) {
        event.preventDefault();
      }
    });
  </script>

  <!-- Scroll Top -->
  <script>
    // Ambil elemen tombol
    const scrollTopButton = document.getElementById("scrollTopButton");

    // Fungsi untuk menunjukkan tombol saat scroll ke bawah
    window.onscroll = function() {
      if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollTopButton.style.display = "block";
      } else {
        scrollTopButton.style.display = "none";
      }
    };

    // Fungsi untuk scroll ke atas saat tombol diklik
    scrollTopButton.onclick = function() {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    };
  </script>



</body>

</html>