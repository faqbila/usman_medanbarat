<?php
$page_title = "Tambah Peserta Baru";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <a href="javascript:history.back()" class="btn btn-sm btn-light border me-2 text-muted">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h3 class="fw-bold text-dark d-inline align-middle">Form Input Peserta Baru</h3>
                </div>
                <span class="badge bg-success px-3 py-2 rounded-pill">Usia Mandiri Medan Barat</span>
            </div>

            <?php display_flash(); ?>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">

                            <!-- Section: Data Diri -->
                            <div class="col-12">
                                <h6 class="fw-bold text-success border-bottom pb-2 mb-3">
                                    <i class="fas fa-user-check me-2"></i> Data Identitas Diri
                                </h6>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: " required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-semibold text-dark">Nama Panggilan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_panggilan" class="form-control" placeholder="Contoh: " required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="input_tanggal_lahir" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Usia (Tahun)</label>
                                <input type="number" name="usia" id="input_usia" class="form-control bg-light" placeholder="Otomatis terisi dari tgl lahir" readonly>
                                <small class="text-muted fs-8">*Terhitung otomatis setelah tanggal lahir diisi</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">No. WhatsApp <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" name="no_wa" class="form-control" placeholder="Contoh: 081260112233" required>
                                </div>
                            </div>

                            <!-- Section: Data Alamat & Domisili -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold text-success border-bottom pb-2 mb-3">
                                    <i class="fas fa-map-location-dot me-2"></i> Data Kelompok & Desa
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Kelompok <span class="text-danger">*</span></label>
                                <input type="text" name="kelompok" class="form-control" placeholder="Contoh: Kelompok Sambung" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Desa <span class="text-danger">*</span></label>
                               <select name="desa" class="form-select" required>
                                 <option value="">-- Pilih Kelurahan --</option>
                                 <option value="Gaperta">Gaperta</option>
                                 <option value="Medan Baru">Medan Baru</option>
                                 <option value="Kampung Baru">Kampung Baru</option>
                                 <option value="Sunggal">Sunggal</option>
                                 <option value="Binjai Barat">Binjai Barat</option>
                                 <option value="Binjai Utara">Binjai Utara</option>
                                 <option value="Glugur">Glugur</option>
                                 <option value="Medan Deli">Medan Deli</option>
                               </select>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" class="form-select">
                                    <option value="SD">SD/Sederajat</option>
                                    <option value="SMP">SMP/Sederajat</option>
                                    <option value="SMA/K" selected>SMA/SMK/Sederajat</option>
                                    <option value="D3">Diploma 3 (D3)</option>
                                    <option value="S1">Sarjana (S1)</option>
                                    <option value="S2/S3">Magister/Doktor (S2/S3)</option>
                                </select>
                            </div>

                            <!-- Section: Upload Foto -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Foto Diri Peserta</label>
                                <input type="file" name="foto" id="input_foto" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                                <small class="text-muted fs-8">Format: JPG, PNG, WEBP (Max 2MB)</small>
                            </div>

                            <!-- Preview Foto -->
                            <div class="col-12 text-center my-2">
                                <small class="text-muted d-block mb-1">Preview Foto:</small>
                                <img id="preview_foto" src="assets/images/default-avatar.svg" alt="Preview Foto" class="rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover; border: 3px solid var(--primary-green);">
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-light px-4">Batal</a>
                                <button type="submit" name="btn_simpan" class="btn btn-primary-green px-4 shadow-sm">
                                    <i class="fas fa-save me-1"></i> Simpan Data Peserta
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
