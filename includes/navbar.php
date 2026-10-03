<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center me-3" href="index.php">
            <span class="bg-emerald-100 text-emerald-700 p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" style="background-color: var(--light-green); width: 40px; height: 40px;">
                <i class="fas fa-users-line text-success fs-5"></i>
            </span>
            <div>
                <span class="d-block fw-bold text-success lh-1">USIA MANDIRI</span>
                <small class="text-muted fs-8 fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Medan Barat</small>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars-staggered fs-4 text-success"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'index.php' ? 'active' : '' ?>" href="index.php">
                        <i class="fas fa-house me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'tabel_peserta.php' ? 'active' : '' ?>" href="tabel_peserta.php">
                        <i class="fas fa-table-list me-1"></i> Tampilan Tabel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'kartu_peserta.php' ? 'active' : '' ?>" href="kartu_peserta.php">
                        <i class="fas fa-address-card me-1"></i> Tampilan Kartu
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <a href="form_tambah.php" class="btn btn-primary-green px-3 py-2 w-100 w-lg-auto d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Tambah Peserta</span>
                </a>
            </div>
        </div>
    </div>
</nav>
