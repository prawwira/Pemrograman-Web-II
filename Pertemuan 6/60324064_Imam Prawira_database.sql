-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2026 at 01:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kategori` enum('Programming','Database','Web Design','Networking') NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` int NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0',
  `id_kategori` int DEFAULT NULL,
  `id_penerbit` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul`, `kategori`, `pengarang`, `penerbit`, `tahun_terbit`, `isbn`, `harga`, `stok`, `deskripsi`, `created_at`, `updated_at`, `is_deleted`, `id_kategori`, `id_penerbit`) VALUES
(1, 'BK-001', 'Pemrograman PHP untuk Pemula', 'Programming', 'Budi Raharjo', 'Informatika', 2023, '978-602-1234-56-1', '98175.00', 15, 'Buku panduan PHP terbaru edisi revisi', '2026-04-27 02:56:26', '2026-04-28 01:04:32', 0, 1, 1),
(2, 'BK-002', 'Mastering MySQL Database', 'Database', 'Andi Nugroho', 'Graha Ilmu', 2022, '978-602-1234-56-2', '104500.00', 5, 'Panduan komprehensif administrasi dan optimasi MySQL', '2026-04-27 02:56:26', '2026-04-28 01:18:44', 0, 2, 2),
(3, 'BK-003', 'Laravel Framework Advanced', 'Programming', 'Siti Aminah', 'Informatika', 2024, '978-602-1234-56-3', '131250.00', 8, 'Teknik advanced development dengan Laravel framework', '2026-04-27 02:56:26', '2026-04-28 01:04:32', 0, 1, 1),
(4, 'BK-004', 'Web Design Principles', 'Web Design', 'Dedi Santoso', 'Andi', 2023, '978-602-1234-56-4', '93500.00', 15, 'Prinsip dan best practice dalam desain web modern', '2026-04-27 02:56:26', '2026-04-28 01:18:53', 0, 4, 3),
(6, 'BK-006', 'PHP Web Services', 'Programming', 'Budi Raharjo', 'Informatika', 2024, '978-602-1234-56-6', '94500.00', 12, 'Membangun RESTful API dengan PHP', '2026-04-27 02:56:26', '2026-04-28 01:04:32', 0, 1, 1),
(7, 'BK-007', 'PostgreSQL Advanced', 'Database', 'Ahmad Yani', 'Graha Ilmu', 2024, '978-602-1234-56-7', '115000.00', 7, 'Teknik advanced PostgreSQL untuk enterprise', '2026-04-27 02:56:26', '2026-04-28 01:18:44', 0, 2, 2),
(9, 'BK-008', 'JavaScript Modern', 'Programming', 'Siti Aminah', 'Informatika', 2023, '970-602-1234-56-7', '84000.00', 5, 'Buku ini membahas materi secara lengkap dan mudah dipahami', '2026-04-27 03:10:52', '2026-04-28 01:20:53', 1, 1, 1),
(10, 'BK-009', 'React Native Development', 'Programming', 'Ahmad Yani', 'Informatika', 2024, '970-602-1874-56-7', '141750.00', 10, 'Buku ini membahas materi secara lengkap dan mudah dipahami', '2026-04-27 03:10:52', '2026-04-28 01:21:05', 0, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`),
  ADD KEY `fk_buku_kategori` (`id_kategori`),
  ADD KEY `fk_buku_penerbit` (`id_penerbit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_buku` (`id_kategori`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buku_penerbit` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
