<?php
/**
 * File Configuration & Database Connection (PDO)
 * Aplikasi Web Usia Mandiri Medan Barat
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host     = 'sql106.infinityfree.com';
$db_name  = 'if0_43075724_usman_medan';
$username = 'if0_43075724 ';
$password = 'KM8MHdDNcAR0u';
$port     = 3306;

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db_name};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Fallback koneksi tanpa database jika DB belum dibuat
    try {
        $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e_root) {
        $db_error = "Gagal terhubung ke MySQL Server: " . $e_root->getMessage();
    }
}

/**
 * Format Nomor WhatsApp ke Format Internasional (628...)
 */
function format_wa_url($nomor, $nama = '') {
    $clean_no = preg_replace('/[^0-9]/', '', $nomor);
    if (substr($clean_no, 0, 1) === '0') {
        $clean_no = '62' . substr($clean_no, 1);
    }
    
    $pesan = urlencode("Halo " . $nama . ", saya menghubungi dari Pengelola Program Usia Mandiri Medan Barat.");
    return "https://wa.me/" . $clean_no . "?text=" . $pesan;
}

/**
 * Format Tanggal Indonesia (contoh: 12 April 1995)
 */
function format_tanggal_indo($tanggal) {
    if (empty($tanggal) || $tanggal === '0000-00-00') return '-';
    
    $bulan_indo = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $split = explode('-', $tanggal);
    if (count($split) !== 3) return $tanggal;
    
    return (int)$split[2] . ' ' . $bulan_indo[(int)$split[1]] . ' ' . $split[0];
}

/**
 * Hitung Usia dari Tanggal Lahir
 */
function hitung_usia_otomatis($tanggal_lahir) {
    if (empty($tanggal_lahir)) return 0;
    $tgl = new DateTime($tanggal_lahir);
    $sekarang = new DateTime();
    return $sekarang->diff($tgl)->y;
}

/**
 * Flash Message Notifications
 */
function set_flash($tipe, $pesan) {
    $_SESSION['flash_message'] = [
        'tipe'  => $tipe, // 'success', 'danger', 'warning', 'info'
        'pesan' => $pesan
    ];
}

function display_flash() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        $icon = $flash['tipe'] === 'success' ? 'check-circle' : 'exclamation-triangle';
        echo '
        <div class="alert alert-' . htmlspecialchars($flash['tipe']) . ' alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-' . $icon . ' me-2 fs-5"></i>
                <div>' . htmlspecialchars($flash['pesan']) . '</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['flash_message']);
    }
}
