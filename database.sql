
-- ------------------------------------------------------------
-- Struktur Tabel `tb_peserta`
-- ------------------------------------------------------------
DROP TABLE IF EXISTS `tb_peserta`;
CREATE TABLE `tb_peserta` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `nama_panggilan` VARCHAR(50) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `usia` INT(3) NOT NULL,
  `no_wa` VARCHAR(20) NOT NULL,
  `kelompok` VARCHAR(50) NOT NULL,
  `desa` VARCHAR(50) NOT NULL,
  `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
  `pendidikan_terakhir` VARCHAR(50) DEFAULT 'SMA/K',
  `foto` VARCHAR(255) DEFAULT 'default-avatar.png',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Data Sampel / Initial Seed Data
-- ------------------------------------------------------------
INSERT INTO `tb_peserta` (`nama_lengkap`, `nama_panggilan`, `tanggal_lahir`, `usia`, `no_wa`, `kelompok`, `desa`, `jenis_kelamin`, `pendidikan_terakhir`, `foto`) VALUES
('Ahmad Subagja', 'Ahmad', '1995-04-12', 31, '081260112233', 'Kelompok Mandiri 01', 'Kelurahan Silalas', 'Laki-laki', 'S1 Teknik', 'default-avatar.png'),
('Siti Rahmawati', 'Siti', '1998-08-25', 28, '085270998877', 'Kelompok Mandiri 02', 'Kelurahan Glugur Kota', 'Perempuan', 'SMA/K', 'default-avatar.png'),
('Budi Santoso', 'Budi', '1992-11-03', 33, '082165443322', 'Kelompok Mandiri 01', 'Kelurahan Sei Agul', 'Laki-laki', 'D3 Manajemen', 'default-avatar.png'),
('Dewi Lestari', 'Dewi', '2000-01-15', 26, '081398776655', 'Kelompok Mandiri 03', 'Kelurahan Karang Berombak', 'Perempuan', 'S1 Akuntansi', 'default-avatar.png'),
('Muhammad Rasyid', 'Rasyid', '1997-06-30', 29, '085361224488', 'Kelompok Mandiri 02', 'Kelurahan Pulo Brayan Kota', 'Laki-laki', 'SMA/K', 'default-avatar.png'),
('Nurul Hidayah', 'Nurul', '1999-09-18', 27, '081277889900', 'Kelompok Mandiri 03', 'Kelurahan Silalas', 'Perempuan', 'D3 Keperawatan', 'default-avatar.png');
