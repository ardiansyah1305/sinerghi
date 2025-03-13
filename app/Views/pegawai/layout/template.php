<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pegawai Dashboard</title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('images/pmklogo.png'); ?>">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('css/index.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('css/bootstrap.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('css/dataTables.bootstrap5.css'); ?>" rel="stylesheet" />
    

    <!-- CDN memuat Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Style Custom -->
    <style>
    
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
        background-color: #d9d9d9; /* Warna background untuk item aktif */
        /* color: white; */
        font-weight: 600;
      }


      /* custome card border kiri */

      /* --bs-secondary: #6c757d;
        --bs-success: #198754;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545; */
        
      .border-left-primary-custom {
        border-left: 4px solid #1687a6;
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
      .btn-primary-add {
        background-color: #1687a6;
        color: #FFFFFF;
      }
      .btn-primary-add:hover {
        background-color: #126e87;
        color: #FFFFFF;
      }
      .btn-danger-add {
        background-color: #dc3545;
        color: #FFFFFF;
      }
      .btn-danger-add:hover {
        background-color: #c32232;
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
        font-size: 18px;
      }
      .text-penpeg-custom {
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

      /* btn actions */
      /* .btn-actions-danger {

      }
      .btn-actions-warning {

      } */

      .font-size-custom {
        font-size: 120px;
      }

      /* Scroll top */
      .btn-scroll-top {
        position: fixed;
        bottom: 40px;
        right: 20px;
        display: none; /* Awalnya disembunyikan */
        z-index: 99;
        opacity: 0.8;
      }

      .btn-scroll-top:hover {
        opacity: 1;
      }
      .bi-arrow-up-circle {
        font-size: 24px;
      }

      /* div.dt-info {
        text-align: center;
      }

      div.dt-length {
          float: left;
      }
      
      div.dt-paging {
          clear: both;
          text-align: center;
          margin-top: 0.5em;
      } */

    </style>

</head>

<body class="sb-nav-fixed">

    <!-- Navbar dan Sidebar-->
    <?= $this->include('pegawai/layout/navbar'); ?>
    
            <div id="layoutSidenav_content">
            <main>
                <?= $this->renderSection('content'); ?>
            </main>
            
            <!-- Footer -->
            <?= $this->include('pegawai/layout/footer'); ?>
            
        </div>
    </div>
    
    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?= base_url('js/sb-admin-2.min.js'); ?>"></script>
    <script src="<?= base_url('js/scripts.js'); ?>"></script>

    <script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('js/dataTables.js'); ?>"></script>
    <script src="<?= base_url('js/dataTables.bootstrap5.js'); ?>"></script>
    <script src="<?= base_url('js/jquery-3.7.1.js'); ?>"></script>
    

    <script>
      document.addEventListener("DOMContentLoaded", function () {
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


  

<!-- Scroll Top -->
<script>
  // Ambil elemen tombol
  const scrollTopButton = document.getElementById("scrollTopButton");

  // Fungsi untuk menunjukkan tombol saat scroll ke bawah
  window.onscroll = function () {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      scrollTopButton.style.display = "block";
    } else {
      scrollTopButton.style.display = "none";
    }
  };

  // Fungsi untuk scroll ke atas saat tombol diklik
  scrollTopButton.onclick = function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };
</script>

</body>

</html>