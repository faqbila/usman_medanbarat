<?php
$page_title = "Tampilan Kartu Profil Peserta";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$peserta_list = [];
$kelompok_options = [];
$desa_options = [];

if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM tb_peserta ORDER BY created_at DESC");
        $peserta_list = $stmt->fetchAll();

        $stmt = $pdo->query("SELECT DISTINCT kelompok FROM tb_peserta WHERE kelompok IS NOT NULL AND kelompok != '' ORDER BY kelompok ASC");
        $kelompok_options = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $stmt = $pdo->query("SELECT DISTINCT desa FROM tb_peserta WHERE desa IS NOT NULL AND desa != '' ORDER BY desa ASC");
        $desa_options = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        $db_error = $e->getMessage();
    }
}
?>

<div class="container my-4">
    <!-- Header Page -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">MENU 2</span>
                <span class="text-muted small">Usia Mandiri Medan Barat</span>
            </div>
            <h2 class="fw-bold text-dark mb-1">Kartu Profil Peserta</h2>
            <p class="text-muted mb-0">Tampilan visual kartu profil interaktif dengan akses cepat kontak WhatsApp</p>
        </div>
        <div class="d-flex gap-2">
            <a href="form_tambah.php" class="btn btn-primary-green px-3 py-2 shadow-sm d-flex align-items-center gap-2">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Peserta</span>
            </a>
            <a href="tabel_peserta.php" class="btn btn-outline-success px-3 py-2">
                <i class="fas fa-table-list me-1"></i> Mode Tabel
            </a>
        </div>
    </div>

    <!-- Flash Notification -->
    <?php display_flash(); ?>

    <!-- Live Search & Filter Bar -->
    <div class="filter-box">
        <div class="row g-2 align-items-end">
            <!-- Search Input -->
            <div class="col-12 col-md-4">
                <label class="form-label small fw-bold text-muted"><i class="fas fa-search me-1"></i> Cari Nama Peserta</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" id="filter_search" class="form-control border-start-0 ps-0" placeholder="Ketik nama panggilan / lengkap...">
                </div>
            </div>

            <!-- Filter Kelompok -->
            <div class="col-6 col-md-2-5">
                <label class="form-label small fw-bold text-muted"><i class="fas fa-users me-1"></i> Kelompok</label>
                <select id="filter_kelompok" class="form-select">
                    <option value="">Semua Kelompok</option>
                    <?php foreach ($kelompok_options as $k): ?>
                        <option value="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Desa -->
            <div class="col-6 col-md-2-5">
                <label class="form-label small fw-bold text-muted"><i class="fas fa-map-marker-alt me-1"></i> Desa/Kelurahan</label>
                <select id="filter_desa" class="form-select">
                    <option value="">Semua Desa</option>
                    <?php foreach ($desa_options as $d): ?>
                        <option value="<?= htmlspecialchars($d) ?>"><?= htmlspecialchars($d) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter Gender -->
            <div class="col-6 col-md-2">
                <label class="form-label small fw-bold text-muted"><i class="fas fa-venus-mars me-1"></i> Gender</label>
                <select id="filter_gender" class="form-select">
                    <option value="">Semua</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="col-6 col-md-1 text-end">
                <button type="button" id="btn_reset_filter" class="btn btn-light w-100 border text-muted" title="Reset Filter">
                    <i class="fas fa-rotate-left"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="row g-4" id="peserta_cards_container">
        <?php if (!empty($peserta_list)): ?>
            <?php foreach ($peserta_list as $p): 
                $foto_path = (!empty($p['foto']) && file_exists(__DIR__ . '/uploads/peserta/' . $p['foto'])) 
                    ? 'uploads/peserta/' . $p['foto'] 
                    : 'assets/images/default-avatar.svg';
                $gender_class = $p['jenis_kelamin'] === 'Laki-laki' ? 'badge-gender-male' : 'badge-gender-female';
            ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 item-peserta-card"
                     data-nama="<?= htmlspecialchars($p['nama_lengkap'] . ' ' . $p['nama_panggilan']) ?>"
                     data-kelompok="<?= htmlspecialchars($p['kelompok']) ?>"
                     data-desa="<?= htmlspecialchars($p['desa']) ?>"
                     data-gender="<?= htmlspecialchars($p['jenis_kelamin']) ?>">
                    
                    <div class="profile-card p-3 text-center h-100 d-flex flex-column justify-content-between">
                        <div>
                            <!-- Header Action Dropdown -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge <?= $gender_class ?> px-2 py-1 rounded-pill small">
                                    <i class="fas fa-<?= $p['jenis_kelamin'] === 'Laki-laki' ? 'mars' : 'venus' ?> me-1"></i>
                                    <?= htmlspecialchars($p['jenis_kelamin']) ?>
                                </span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v text-muted"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                        <li>
                                            <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#modalDetailKartu<?= $p['id'] ?>">
                                                <i class="fas fa-eye text-info me-2"></i> Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="form_edit.php?id=<?= $p['id'] ?>">
                                                <i class="fas fa-edit text-warning me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item py-2 text-danger" href="javascript:void(0)" onclick="konfirmasiHapus(<?= $p['id'] ?>, '<?= htmlspecialchars($p['nama_panggilan']) ?>')">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Photo Avatar -->
                            <div class="profile-avatar-wrapper">
                                <img src="<?= $foto_path ?>" alt="Foto" class="profile-avatar">
                            </div>

                            <!-- Name & Age -->
                            <h5 class="fw-bold text-dark mb-0 text-truncate" title="<?= htmlspecialchars($p['nama_panggilan']) ?>">
                                <?= htmlspecialchars($p['nama_panggilan']) ?>
                            </h5>
                            <small class="text-muted d-block mb-2 text-truncate" style="font-size: 0.85rem;">
                                <?= htmlspecialchars($p['nama_lengkap']) ?>
                            </small>

                            <!-- Badges -->
                            <div class="d-flex justify-content-center gap-1 mb-3 flex-wrap">
                                <span class="badge bg-warning bg-opacity-20 text-dark fw-bold px-2 py-1 rounded-2">
                                    <i class="fas fa-birthday-cake me-1 text-warning"></i> <?= (int)$p['usia'] ?> Thn
                                </span>
                                <span class="badge bg-light text-secondary border px-2 py-1 rounded-2">
                                    <?= htmlspecialchars($p['pendidikan_terakhir']) ?>
                                </span>
                            </div>

                            <!-- Location Info -->
                            <div class="bg-light p-2 rounded-3 text-start small mb-3">
                                <div class="text-truncate mb-1">
                                    <i class="fas fa-users text-success me-1"></i>
                                    <strong class="text-dark"><?= htmlspecialchars($p['kelompok']) ?></strong>
                                </div>
                                <div class="text-truncate">
                                    <i class="fas fa-location-dot text-danger me-1"></i>
                                    <span class="text-muted"><?= htmlspecialchars($p['desa']) ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button WhatsApp -->
                        <a href="<?= format_wa_url($p['no_wa'], $p['nama_panggilan']) ?>" target="_blank" class="btn btn-whatsapp w-100 d-flex align-items-center justify-content-center gap-2 mt-2">
                            <i class="fab fa-whatsapp fs-5"></i>
                            <span>Chat WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- Modal Detail Peserta (Kartu View) -->
                <div class="modal fade" id="modalDetailKartu<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 shadow">
                            <div class="modal-header border-0 bg-success text-white rounded-top-4">
                                <h5 class="modal-title fw-bold"><i class="fas fa-id-card me-2"></i> Profile Lengkap</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center p-4">
                                <img src="<?= $foto_path ?>" alt="Foto" class="rounded-circle shadow mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #ffffff;">
                                <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($p['nama_lengkap']) ?></h4>
                                <p class="text-success fw-semibold mb-3">"<?= htmlspecialchars($p['nama_panggilan']) ?>"</p>

                                <div class="row text-start g-3 bg-light p-3 rounded-3 mb-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Tanggal Lahir & Usia</small>
                                        <span class="fw-bold text-dark"><?= format_tanggal_indo($p['tanggal_lahir']) ?> (<?= $p['usia'] ?> thn)</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Jenis Kelamin</small>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($p['jenis_kelamin']) ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Kelompok</small>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($p['kelompok']) ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Desa/Kelurahan</small>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($p['desa']) ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Pendidikan Terakhir</small>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($p['pendidikan_terakhir']) ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">No. WhatsApp</small>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($p['no_wa']) ?></span>
                                    </div>
                                </div>

                                <a href="<?= format_wa_url($p['no_wa'], $p['nama_panggilan']) ?>" target="_blank" class="btn btn-whatsapp w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fab fa-whatsapp fs-5"></i>
                                    <span>Kirim Pesan WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Message Jika Filter Tidak Menemukan Hasil -->
    <div id="no_data_message" class="text-center py-5 <?= !empty($peserta_list) ? 'd-none' : '' ?>">
        <i class="fas fa-folder-open display-4 text-muted mb-3"></i>
        <h5 class="fw-bold text-secondary">Tidak ada kartu peserta ditemukan</h5>
        <p class="text-muted small">Coba ubah kata kunci pencarian atau reset filter di atas</p>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
