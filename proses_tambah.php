<?php
/**
 * Script Proses Tambah Peserta Baru
 */
require_once __DIR__ . '/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap       = trim($_POST['nama_lengkap'] ?? '');
    $nama_panggilan     = trim($_POST['nama_panggilan'] ?? '');
    $tanggal_lahir      = trim($_POST['tanggal_lahir'] ?? '');
    $usia               = !empty($_POST['usia']) ? (int)$_POST['usia'] : hitung_usia_otomatis($tanggal_lahir);
    $no_wa              = trim($_POST['no_wa'] ?? '');
    $kelompok           = trim($_POST['kelompok'] ?? '');
    $desa               = trim($_POST['desa'] ?? '');
    $jenis_kelamin      = trim($_POST['jenis_kelamin'] ?? '');
    $pendidikan_terakhir = trim($_POST['pendidikan_terakhir'] ?? 'SMA/K');

    // Validasi Field Wajib
    if (empty($nama_lengkap) || empty($nama_panggilan) || empty($tanggal_lahir) || empty($no_wa) || empty($kelompok) || empty($desa) || empty($jenis_kelamin)) {
        set_flash('danger', 'Semua kolom bertanda bintang (*) wajib diisi!');
        header('Location: form_tambah.php');
        exit;
    }

    // Process Upload Foto
    $nama_foto = 'default-avatar.png';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_tmp   = $_FILES['foto']['tmp_name'];
        $file_name  = $_FILES['foto']['name'];
        $file_size  = $_FILES['foto']['size'];
        $ext        = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed_ext)) {
            set_flash('danger', 'Format foto tidak valid! Gunakan format JPG, PNG, atau WEBP.');
            header('Location: form_tambah.php');
            exit;
        }

        if ($file_size > 2 * 1024 * 1024) { // Max 2MB
            set_flash('danger', 'Ukuran foto maksimal 2MB!');
            header('Location: form_tambah.php');
            exit;
        }

        $upload_dir = __DIR__ . '/uploads/peserta/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $nama_foto = 'peserta_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
        move_uploaded_file($file_tmp, $upload_dir . $nama_foto);
    }

    // Insert to Database via PDO Prepared Statement
    try {
        $sql = "INSERT INTO tb_peserta 
                (nama_lengkap, nama_panggilan, tanggal_lahir, usia, no_wa, kelompok, desa, jenis_kelamin, pendidikan_terakhir, foto) 
                VALUES 
                (:nama_lengkap, :nama_panggilan, :tanggal_lahir, :usia, :no_wa, :kelompok, :desa, :jenis_kelamin, :pendidikan_terakhir, :foto)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama_lengkap'       => $nama_lengkap,
            ':nama_panggilan'     => $nama_panggilan,
            ':tanggal_lahir'      => $tanggal_lahir,
            ':usia'               => $usia,
            ':no_wa'              => $no_wa,
            ':kelompok'           => $kelompok,
            ':desa'               => $desa,
            ':jenis_kelamin'      => $jenis_kelamin,
            ':pendidikan_terakhir' => $pendidikan_terakhir,
            ':foto'               => $nama_foto
        ]);

        set_flash('success', 'Data peserta "' . htmlspecialchars($nama_panggilan) . '" berhasil ditambahkan!');
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        set_flash('danger', 'Gagal menyimpan data: ' . $e->getMessage());
        header('Location: form_tambah.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
