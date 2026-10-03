# Usia Mandiri Medan Barat - Mobile Web Application

Aplikasi Web Mobile-Responsive untuk Pengelolaan, Pencarian, dan Input Data Peserta Program **"Usia Mandiri Medan Barat"**.

---

## 🌟 Fitur Utama

1. **Desain Mobile-First & Modern (Green-Yellow Theme):**
   - Kombinasi warna Hijau (`#059669`), Kuning (`#f59e0b`), Putih, dan Kontras Hitam.
   - Menggunakan Bootstrap 5.3, FontAwesome 6, dan Google Fonts *Plus Jakarta Sans*.
2. **Dua Pilihan Mode Tampilan Utama:**
   - **Tampilan Tabel Data (`tabel_peserta.php`):** Tampilan tabel responsif dengan opsi detail, edit, dan hapus.
   - **Tampilan Kartu Profil (`kartu_peserta.php`):** Grid kartu profil interaktif lengkap dengan avatar foto, badge usia, dan shortcut WhatsApp.
3. **Filter & Live Search Real-Time:**
   - Pencarian berdasarkan Nama Lengkap / Panggilan.
   - Filter berdasarkan Kelompok, Desa/Kelurahan, dan Jenis Kelamin tanpa reload halaman.
4. **Perhitungan Usia Otomatis:**
   - Usia peserta terhitung otomatis secara real-time saat pengguna memasukkan tanggal lahir pada form tambah/edit.
5. **Aksi Direct WhatsApp:**
   - Tombol shortcut langsung membuka aplikasi/web WhatsApp (`https://wa.me/...`) dengan pesan otomatis.
6. **Upload & Validasi Foto Diri:**
   - Fitur upload foto peserta dengan preview gambar live client-side dan validasi ekstensi gambar (JPG, PNG, WEBP).

---

## 📁 Struktur Direktori Project

```
usia_mandiri_medan_barat/
├── assets/
│   ├── css/
│   │   └── style.css           # Custom CSS tema Hijau, Kuning, Putih & Hitam
│   ├── js/
│   │   └── main.js            # JavaScript live filter, hitung usia & preview foto
│   └── images/
│       └── default-avatar.svg # Avatar default jika foto belum diupload
├── config/
│   └── koneksi.php            # Koneksi PDO MySQL & Helper Functions
├── includes/
│   ├── header.php             # Template Header & CDN Imports
│   ├── navbar.php             # Navigasi Responsive
│   └── footer.php             # Template Footer & FAB Mobile
├── uploads/
│   └── peserta/               # Direktori penyimpanan foto peserta
├── database.sql               # Skrip SQL untuk Import Database & Seed Data
├── index.php                  # Halaman Beranda / Dashboard
├── tabel_peserta.php          # Menu 1: Tampilan Tabel Data
├── kartu_peserta.php          # Menu 2: Tampilan Kartu Profil Grid
├── form_tambah.php            # Form Input Data Peserta Baru
├── form_edit.php              # Form Edit Data Peserta
├── proses_tambah.php          # Backend Processing Tambah Data
├── proses_edit.php            # Backend Processing Edit Data
├── proses_hapus.php           # Backend Processing Hapus Data
└── README.md                  # Dokumentasi Cara Menjalankan Aplikasi
```

---

## 🛠️ Cara Menjalankan Aplikasi

### Persyaratan Sistem:
- PHP >= 7.4 (dengan ekstensi `pdo_mysql` aktif).
- Database MySQL / MariaDB (via XAMPP, Laragon, atau MySQL Standalone).

---

### Langkah 1: Setup Database MySQL
1. Buka **phpMyAdmin** (biasanya di `http://localhost/phpmyadmin`) atau aplikasi SQL Client (HeidiSQL/DBeaver).
2. Buat database baru dengan nama `db_usia_mandiri`.
3. Import file `database.sql` yang ada di dalam folder proyek ini.
4. Skrip SQL akan otomatis membuat tabel `tb_peserta` dan mengisinya dengan data awal (seed data).

> **Catatan Pengaturan Database:**
> Jika username/password MySQL Anda berbeda dari default (`root` tanpa password), sesuaikan di file `config/koneksi.php`:
> ```php
> $host     = '127.0.0.1';
> $db_name  = 'db_usia_mandiri';
> $username = 'root';
> $password = ''; // Masukkan password jika ada
> $port     = 3306;
> ```

---

### Langkah 2: Menjalankan Server PHP

#### Opsi A: Menggunakan Built-in Web Server PHP (Rekomendasi Cepat)
1. Buka Terminal / Command Prompt / PowerShell.
2. Arahkan ke folder proyek ini:
   ```bash
   cd C:\Users\LENOVO\.gemini\antigravity\scratch\usia_mandiri_medan_barat
   ```
3. Jalankan command server lokal:
   ```bash
   php -S localhost:8000
   ```
4. Buka browser (Chrome / Edge / Safari Mobile) dan akses URL:
   ```text
   http://localhost:8000
   ```

#### Opsi B: Menggunakan XAMPP / Laragon
1. Pindahkan atau salin folder `usia_mandiri_medan_barat` ke folder web server Anda:
   - XAMPP: `C:\xampp\htdocs\usia_mandiri_medan_barat`
   - Laragon: `C:\laragon\www\usia_mandiri_medan_barat`
2. Buka browser dan akses:
   ```text
   http://localhost/usia_mandiri_medan_barat
   ```

---

## 📱 Uji Coba Tampilan Mobile
Untuk menguji tampilan di Smartphone:
1. Pada Google Chrome, tekan `F12` atau `Ctrl + Shift + I` untuk membuka **Developer Tools**.
2. Klik ikon **Toggle Device Toolbar** (`Ctrl + Shift + M`).
3. Pilih perangkat mobile seperti **iPhone 14 Pro**, **Samsung Galaxy S20**, atau **Pixel 7**.
