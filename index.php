<?php
$page_title = "Beranda Dashboard";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

// Inisialisasi statistik default
$total_peserta = 0;
$total_laki = 0;
$total_perempuan = 0;
$total_kelompok = 0;
$total_desa = 0;

if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM tb_peserta");
        $total_peserta = $stmt->fetchColumn();

        $stmt = $pdo->query("SELECT COUNT(*) FROM tb_peserta WHERE jenis_kelamin = 'Laki-laki'");
        $total_laki = $stmt->fetchColumn();

        $stmt = $pdo->query("SELECT COUNT(*) FROM tb_peserta WHERE jenis_kelamin = 'Perempuan'");
        $total_perempuan = $stmt->fetchColumn();

        $stmt = $pdo->query("SELECT COUNT(DISTINCT kelompok) FROM tb_peserta");
        $total_kelompok = $stmt->fetchColumn();

        $stmt = $pdo->query("SELECT COUNT(DISTINCT desa) FROM tb_peserta");
        $total_desa = $stmt->fetchColumn();
    } catch (PDOException $e) {
        // Abaikan error jika DB belum di-import
    }
}
?>

<!-- Header / Hero Banner -->
<section class="brand-header">
    <div class="container text-center text-md-start">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="brand-badge mb-3">
                    <i class="fas fa-certificate me-1"></i> Program Usia Mandiri
                </span>
                <h1 class="fw-extrabold display-6 text-white mb-2">
                    Sistem Informasi Data Peserta <br class="d-none d-md-block">
                    <span style="color: var(--accent-yellow);">Usia Mandiri Medan Barat</span>
                </h1>
                <p class="text-white-50 lead fs-6 mb-4">
                    Kelola, cari, dan input data peserta secara praktis, cepat, dan ramah pengguna di seluruh perangkat mobile.
                </p>
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                    <a href="form_tambah.php" class="btn btn-accent-yellow px-4 py-2-5 shadow-sm d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle fs-5"></i> Input Peserta Baru
                    </a>
                    <a href="#menu-pilihan" class="btn btn-outline-light px-4 py-2-5 border-2 rounded-3">
                        <i class="fas fa-compass me-1"></i> Pilih Tampilan Data
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center position-relative">
                <div class="bg-white bg-opacity-10 backdrop-blur rounded-4 p-4 text-white border border-white border-opacity-25 shadow-lg">
                    <i class="fas fa-user-shield display-1 text-warning mb-3"></i>
                    <h5 class="fw-bold text-white mb-1">Kecamatan Medan Barat</h5>
                    <p class="small text-white-50 mb-0">Pendataan Terintegrasi & Akses WhatsApp Direct</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Container -->
<div class="container my-4">

    <!-- Flash Notification -->
    <?php display_flash(); ?>

    <?php if (isset($db_error)): ?>
        <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4">
            <h5 class="fw-bold"><i class="fas fa-database me-2"></i>Database Belum Siap</h5>
            <p class="mb-2">Pastikan MySQL server berjalan dan database <code>db_usia_mandiri</code> telah di-import.</p>
            <small class="text-muted">Pesan Error: <?= htmlspecialchars($db_error) ?></small>
        </div>
    <?php endif; ?>

    <!-- Summary Statistics Grid -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-4 col-lg-2-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon icon-green">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Total Peserta</span>
                    <h3 class="fw-bold text-dark mb-0"><?= number_format($total_peserta) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon icon-blue">
                    <i class="fas fa-mars"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Laki-laki</span>
                    <h3 class="fw-bold text-dark mb-0"><?= number_format($total_laki) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-lg-2-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon icon-pink">
                    <i class="fas fa-venus"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Perempuan</span>
                    <h3 class="fw-bold text-dark mb-0"><?= number_format($total_perempuan) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-lg-2-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon icon-yellow">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Kelompok</span>
                    <h3 class="fw-bold text-dark mb-0"><?= number_format($total_kelompok) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-2-4">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon icon-green">
                    <i class="fas fa-map-location-dot"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold d-block">Kelurahan/Desa</span>
                    <h3 class="fw-bold text-dark mb-0"><?= number_format($total_desa) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Dua Menu Utama Pilihan (Card Menu Besar & Menarik) -->
    <div id="menu-pilihan" class="mb-5">
        <div class="text-center mb-4">
            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill mb-2">MODUL TAMPILAN</span>
            <h2 class="fw-bold text-dark">Pilih Tampilan Data Peserta</h2>
            <p class="text-muted">Silakan pilih jenis moda tampilan data yang paling nyaman bagi Anda</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Menu 1: Tampilan Tabel -->
            <div class="col-md-6 col-lg-5">
                <div class="choice-card choice-card-table text-center" onclick="window.location.href='tabel_peserta.php'">
                    <div class="choice-icon-wrapper bg-success bg-opacity-10 text-success mx-auto">
                        <i class="fas fa-table-list"></i>
                    </div>
                    <span class="badge bg-success px-3 py-1 rounded-pill mb-2">MENU 1</span>
                    <h3 class="fw-bold text-dark mb-2">Tampilan Tabel Data</h3>
                    <p class="text-muted mb-4">
                        Format data ringkas dalam bentuk tabel responsif. Cocok untuk analisis data lengkap, sorting cepat, dan melihat banyak data sekaligus.
                    </p>
                    <a href="tabel_peserta.php" class="btn btn-primary-green w-100 py-2-5 shadow-sm">
                        <i class="fas fa-arrow-right me-1"></i> Buka Tampilan Tabel
                    </a>
                </div>
            </div>

            <!-- Menu 2: Tampilan Kartu / Grid -->
            <div class="col-md-6 col-lg-5">
                <div class="choice-card choice-card-grid text-center" onclick="window.location.href='kartu_peserta.php'">
                    <div class="choice-icon-wrapper bg-warning bg-opacity-20 text-warning-emphasis mx-auto" style="background-color: var(--accent-yellow-light); color: var(--accent-yellow-hover);">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2">MENU 2</span>
                    <h3 class="fw-bold text-dark mb-2">Tampilan Kartu Profil</h3>
                    <p class="text-muted mb-4">
                        Format kartu profil visual dengan foto peserta, badge usia, detail lokasi, dan tombol shortcut chat WhatsApp interaktif.
                    </p>
                    <a href="kartu_peserta.php" class="btn btn-accent-yellow w-100 py-2-5 shadow-sm">
                        <i class="fas fa-arrow-right me-1"></i> Buka Tampilan Kartu
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
