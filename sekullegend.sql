-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2025 at 03:37 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekullegend`
--

-- --------------------------------------------------------

--
-- Table structure for table `diskusi_kelas`
--

CREATE TABLE `diskusi_kelas` (
  `id` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_user` int NOT NULL,
  `pesan` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diskusi_kelas`
--

INSERT INTO `diskusi_kelas` (`id`, `id_kelas`, `id_user`, `pesan`, `created_at`) VALUES
(25, 15, 5, 'Silakan unduh 2 materi artikel yang sudah saya tambahkan', '2025-05-18 14:42:54'),
(26, 15, 11, 'Baik pak, siap terima kasih', '2025-05-18 15:01:04'),
(31, 17, 8, 'Silakan unduh materi artikel yang sudah saya upload', '2025-05-18 15:32:06'),
(32, 17, 9, 'Baik pak Gojo', '2025-05-18 15:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `kode_kelas` varchar(10) NOT NULL,
  `id_guru` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `kode_kelas`, `id_guru`) VALUES
(15, 'Penelitian Sistem Pakar', 'S-PK01', 5),
(17, 'Pendidikan Kewarganegaraan', 'PKN001', 8);

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id` int NOT NULL,
  `id_kelas` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text,
  `file` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id`, `id_kelas`, `judul`, `deskripsi`, `file`, `created_at`, `updated_at`) VALUES
(21, 15, 'Artikel Penyakit Skizofrenia', 'Sistem Pakar Menggunakan Forward Chaining dalam Mendeteksi Tingkat Keparahan Skizofrenia', '1747579189_22bcad7819aac2939082.pdf', '2025-05-18 14:39:49', '2025-05-18 14:39:49'),
(22, 15, 'Artikel Penyakit ISPA', 'Sistem Pakar Diagnosa Penyakit Ispa Menggunakan Metode Naive Bayes Classifier Berbasis Web', '1747579334_4b55df189b0f27c205a5.pdf', '2025-05-18 14:42:14', '2025-05-18 14:42:14'),
(24, 17, 'Kehidupan Bernegara', 'IDENTITAS NASIONAL SUATU BANGSA DAN NEGARA SERTA PERANAN PENTING\r\nKONSTITUSI DALAM KEHIDUPAN BERNEGARA', '1747582193_e448d30a4eb8cd6215f6.pdf', '2025-05-18 15:29:53', '2025-05-18 15:29:53');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_kelas`
--

CREATE TABLE `siswa_kelas` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_kelas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa_kelas`
--

INSERT INTO `siswa_kelas` (`id`, `id_user`, `id_kelas`) VALUES
(6, 11, 15),
(9, 9, 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`) VALUES
(4, 'Super Admin', 'admin', '$2y$10$iqHWh7nIdx7/.u5XHmWa/eami0ZxoxxulfnvigLubcTvS6CEIrmuS', 'admin'),
(5, 'Levi Ackerman', 'levi', '$2y$10$5t5VmTp/od03ocWKmiRhFuYPjSAgg5qzoNpGLFqnCAB2O.P1AKevy', 'guru'),
(6, 'Itachi Uchiha', 'itachi', '$2y$10$j6Zln10viLNvMqFB8g8VBOSicmgHlVf3SAVXlwoQgNO7bSfOwxjw2', 'guru'),
(7, 'Naruto Uzumaki', 'naruto', '$2y$10$SqWTVXLPkl0l2HfLVvQTTeYyfTATV4Uv.UDckHrfAqHfTxByBBAs2', 'siswa'),
(8, 'Gojo Satorou', 'gojo', '$2y$10$I11I15Notwe/4pYg.g8rZuv6phWvtF2uX9gecZA9w2JYWg1NHiJ/G', 'guru'),
(9, 'Geto Suguru', 'geto', '$2y$10$SwO6FFLUIZ4IIYKWtQsDU./syEJBXeDMUOgWrpx6PurEOS67Qf.Jm', 'siswa'),
(11, 'Mikasa Ackerman', 'mikasa', '$2y$10$Qdchl.kZ74LyxvKGKs5cDOCLLEJ6EnM3.174usB0STc2d6Hfyx26K', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diskusi_kelas`
--
ALTER TABLE `diskusi_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `diskusi_kelas_ibfk_1` (`id_kelas`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kelas` (`kode_kelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`id_user`),
  ADD KEY `fk_kelas` (`id_kelas`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diskusi_kelas`
--
ALTER TABLE `diskusi_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diskusi_kelas`
--
ALTER TABLE `diskusi_kelas`
  ADD CONSTRAINT `diskusi_kelas_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `diskusi_kelas_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
