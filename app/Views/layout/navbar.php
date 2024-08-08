<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="<?= base_url('images/logokmk.png'); ?>" alt="logo" style="max-height: 50px; margin-right: 10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= site_url('dashboard'); ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('organisasi'); ?>">Organisasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('layanan'); ?>">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('referensi'); ?>">Pustaka</a>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center">
            <span class="navbar-text me-3">Holaa, <?= esc(session()->get('nama')) ?></span>
            <a href="<?= site_url('logout'); ?>" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>
