<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PMK</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/responsive.css'); ?>">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Custom Scrollbar CSS -->
    <link rel="stylesheet" href="<?= base_url('css/jquery.mCustomScrollbar.min.css'); ?>">
</head>
<body class="main-layout">
    <?= $this->include('layout/navbar'); ?>
    <div class="container mt-4">
        <?= $this->renderSection('content'); ?>
    </div>
    <?= $this->include('layout/footer'); ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS files -->
    <script src="<?= base_url('js/custom.js'); ?>"></script>
    <script src="<?= base_url('js/popup.js'); ?>"></script>
</body>
</html>
