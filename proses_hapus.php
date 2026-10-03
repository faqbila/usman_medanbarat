<?php
/**
 * Script Proses Hapus Data Peserta
 */
require_once __DIR__ . '/config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0 && isset($pdo)) {
    try {
        // Ambil info data peserta & foto sebelum dihapus
        $stmt = $pdo->prepare("SELECT * FROM tb_peserta WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $peserta = $stmt->fetch();

        if ($peserta) {
            // Hapus file foto dari server jika ada & bukan default avatar
            if (!empty($peserta['foto']) && $peserta['foto'] !== 'default-avatar.png') {
                $foto_path = __DIR__ . '/uploads/peserta/' . $peserta['foto'];
                if (file_exists($foto_path)) {
                    @unlink($foto_path);
                }
            }

            // Hapus baris dari database
            $deleteStmt = $pdo->prepare("DELETE FROM tb_peserta WHERE id = :id");
            $deleteStmt->execute([':id' => $id]);

            set_flash('success', 'Data peserta "' . htmlspecialchars($peserta['nama_panggilan']) . '" berhasil dihapus!');
        } else {
            set_flash('warning', 'Data peserta tidak ditemukan.');
        }
    } catch (PDOException $e) {
        set_flash('danger', 'Gagal menghapus data: ' . $e->getMessage());
    }
} else {
    set_flash('danger', 'ID peserta tidak valid.');
}

// Redirect ke halaman pengirim (referrer) atau index.php
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: " . $referer);
exit;
