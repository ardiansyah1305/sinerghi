<!-- Index.php -->
<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- User Management -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                User Management</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Users</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/users'); ?>" class="btn btn-primary mt-3">Go to User Management</a>
                </div>
            </div>
        </div>

        <!-- Referensi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Referensi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Referensi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/referensi'); ?>" class="btn btn-success mt-3">Go to Referensi</a>
                </div>
            </div>
        </div>

        <!-- Layanan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Layanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Layanan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/layanan'); ?>" class="btn btn-info mt-3">Go to Layanan</a>
                </div>
            </div>
        </div>

        <!-- Organisasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Organisasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Manage Organisasi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sitemap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="<?= site_url('admin/organisasi'); ?>" class="btn btn-warning mt-3">Go to Organisasi</a>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>
