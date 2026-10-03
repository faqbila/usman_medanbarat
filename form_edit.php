<?php
$page_title = "Edit Data Peserta";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$peserta = null;

if (isset($pdo) && $id > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM tb_peserta WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $peserta = $stmt->fetch();
    } catch (PDOException $e) {
        $db_error = $e->getMessage();
    }
}

if (!$peserta) {
    set_flash('danger', 'Data peserta tidak ditemukan.');
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$foto_path = (!empty($peserta['foto']) && file_exists(__DIR__ . '/uploads/peserta/' . $peserta['foto'])) 
    ? 'uploads/peserta/' . $peserta['foto'] 
    : 'assets/images/default-avatar.svg';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <a href="javascript:history.back()" class="btn btn-sm btn-light border me-2 text-muted">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h3 class="fw-bold text-dark d-inline align-middle">Edit Data Peserta</h3>
                </div>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">Update Data</span>
            </div>

            <?php display_flash(); ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $peserta['id'] ?>">
                        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($peserta['foto']) ?>">

                        <div class="row g-3">

                            <!-- Section: Data Diri -->
                            <div class="col-12">
                                <h6 class="fw-bold text-success border-bottom pb-2 mb-3">
                                    <i class="fas fa-user-edit me-2"></i> Data Identitas Diri
                                </h6>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($peserta['nama_lengkap']) ?>" required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-semibold text-dark">Nama Panggilan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_panggilan" class="form-control" value="<?= htmlspecialchars($peserta['nama_panggilan']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="input_tanggal_lahir" class="form-control" value="<?= htmlspecialchars($peserta['tanggal_lahir']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Usia (Tahun)</label>
                                <input type="number" name="usia" id="input_usia" class="form-control bg-light" value="<?= (int)$peserta['usia'] ?>" readonly>
                                <small class="text-muted fs-8">*Terhitung otomatis dari tanggal lahir</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="Laki-laki" <?= $peserta['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= $peserta['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">No. WhatsApp <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="no_wa" class="form-control" value="<?= htmlspecialchars($peserta['no_wa']) ?>" required>
                                </div>
                            </div>

                            <!-- Section: Data Alamat & Kelompok -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-success border-bottom pb-2 mb-3">
                                    <i class="fas fa-map-location-dot me-2"></i> Data Kelompok & Kelurahan
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Kelompok <span class="text-danger">*</span></label>
                                <input type="text" name="kelompok" class="form-control" value="<?= htmlspecialchars($peserta['kelompok']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Desa / Kelurahan <span class="text-danger">*</span></label>
                                <select name="desa" class="form-select" required>
                                    <?php 
                                    $kelurahan_list = [
                                        'Kelurahan Silalas', 'Kelurahan Glugur Kota', 'Kelurahan Sei Agul',
                                        'Kelurahan Karang Berombak', 'Kelurahan Pulo Brayan Kota', 'Kelurahan Kesawan'
                                    ];
                                    foreach ($kelurahan_list as $kel):
                                    ?>
                                        <option value="<?= $kel ?>" <?= $peserta['desa'] === $kel ? 'selected' : '' ?>><?= $kel ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" class="form-select">
                                    <?php
                                    $pendidikan_list = ['SD', 'SMP', 'SMA/K', 'D3', 'S1', 'S2/S3'];
                                    foreach ($pendidikan_list as $pdk):
                                    ?>
                                        <option value="<?= $pdk ?>" <?= $peserta['pendidikan_terakhir'] === $pdk ? 'selected' : '' ?>><?= $pdk ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Section: Upload Foto Replacement -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Ganti Foto Diri (Opsional)</label>
                                <input type="file" name="foto" id="input_foto" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted fs-8">Biarkan kosong jika tidak ingin mengubah foto</small>
                            </div>

                            <!-- Preview Foto -->
                            <div class="col-12 text-center my-2">
                                <small class="text-muted d-block mb-1">Foto Saat Ini / Preview Baru:</small>
                                <img id="preview_foto" src="<?= $foto_path ?>" alt="Preview Foto" class="rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover; border: 3px solid var(--accent-yellow);">
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-light px-4">Batal</a>
                                <button type="submit" name="btn_update" class="btn btn-primary-green px-4 shadow-sm">
                                    <i class="fas fa-check-circle me-1"></i> Update Data
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
