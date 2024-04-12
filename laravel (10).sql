-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2023 at 05:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_admin` varchar(255) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `password`, `nama_admin`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin', 'Azizah', NULL, NULL),
(2, 'rendy@gmail.cm', '123456', 'Rendy Hendra Prasetya', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cuti_non`
--

CREATE TABLE `cuti_non` (
  `id_cuti_non` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `lama_cuti` int(11) DEFAULT 1 COMMENT 'dalam hari',
  `keterangan` enum('Cuti sakit dengan surat keterangan dokter','Cuti bersalin','Cuti gugur kandungan dengan surat keterangan dokter','Cuti melangsungkan pernikahan (3 hari)','Mengkhitankan anak (2 hari)','Membaptis anak (2 hari)','Menikahkan anak (2 hari)','Ibu/Bapak, Istri/Suami, anak, kakak/adik, mertua/menantu menderita sakit keras atau istri gugur kandungan (2 hari)','Ibu/Bapak, Istri/Suami, anak, kakak/adik, mertua/menantu meninggal dunia (2 hari)','Istri melahirkan (2 hari)','Menunaikan ibadah haji (45 hari)','Istirahat panjang selama 6 (enam) bulan') DEFAULT NULL,
  `divisi` enum('Direktur Utama','Direktur Keuangan & Umum','General Manager Finance & HCGA','General Manager Operation & Maintenance','Finance Manager','Human Capital General Affair & Manager','Operation Manager','Maintenance Manager') DEFAULT NULL,
  `ttd_karyawan` varchar(255) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('verifikasi','disetujui','ditolak') DEFAULT 'verifikasi',
  `verifikasi_oleh` varchar(255) DEFAULT NULL,
  `jabatan_verifikasi` varchar(255) DEFAULT NULL,
  `catatan` varchar(255) NOT NULL,
  `ttd` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuti_non`
--

INSERT INTO `cuti_non` (`id_cuti_non`, `id_karyawan`, `tanggal_pengajuan`, `tanggal_akhir`, `lama_cuti`, `keterangan`, `divisi`, `ttd_karyawan`, `image`, `status`, `verifikasi_oleh`, `jabatan_verifikasi`, `catatan`, `ttd`, `created_at`, `updated_at`) VALUES
(15, 1, '2023-05-09', '2023-05-11', 2, 'Menikahkan anak (2 hari)', NULL, 'pak kadek.png', 'Elegant Initial Jewelry Logo.png', 'disetujui', 'Angga', 'Direktur', 'gaada', 'pak kadek.png', '2023-05-08 20:39:39', '2023-05-08 20:43:34'),
(16, 7, '2023-05-25', '2023-05-26', 2, 'Ibu/Bapak, Istri/Suami, anak, kakak/adik, mertua/menantu menderita sakit keras atau istri gugur kandungan (2 hari)', '', 'Azizah.png', 'sssfefr.jpg', 'disetujui', 'Brahmo W. Sudibyo', 'HRD', '', 'ttd pak kadek.png', '2023-05-23 03:27:18', '2023-05-23 03:32:14'),
(17, 8, '2023-05-24', '2023-05-25', 2, 'Cuti sakit dengan surat keterangan dokter', '', 'WhatsApp_Image_2023-05-23_at_10.37.27-removebg-preview.png', 'IMG_20220327_160928.jpg', 'disetujui', 'M. Rifqi Ramadhan', 'Maintenance Manager', '', 'WhatsApp Image 2023-05-22 at 19.29.27 (1).jpeg', '2023-05-23 03:44:32', '2023-05-23 04:20:08'),
(18, 9, '2023-05-25', '2023-05-26', 2, 'Cuti sakit dengan surat keterangan dokter', '', 'Ara-removebg-preview.png', 'sssfefr.jpg', 'disetujui', 'kaazizah', 'HRD', '', 'Azizah.png', '2023-05-23 07:19:30', '2023-05-23 09:35:02'),
(19, 7, '2023-05-25', '2023-11-24', 180, 'Istirahat panjang selama 6 (enam) bulan', '', 'Azizah.png', 'Aziz.jpg', 'disetujui', 'Brahmo W. Sudibyo', 'HRD', 'Ga usah pulang lagi yaaaa', 'ttd pak kadek.png', '2023-05-25 06:48:39', '2023-05-25 06:53:58'),
(20, 13, '2023-05-31', '2023-06-01', 2, 'Cuti sakit dengan surat keterangan dokter', '', 'Azizah.png', 'sssfefr.jpg', 'verifikasi', NULL, NULL, '', NULL, '2023-05-31 02:40:27', '2023-05-31 02:40:27'),
(21, 13, '2023-05-31', '2023-06-01', 2, 'Cuti sakit dengan surat keterangan dokter', '', 'Azizah.png', 'sssfefr.jpg', 'verifikasi', NULL, NULL, '', NULL, '2023-05-31 02:40:28', '2023-05-31 02:40:28'),
(23, 11, '2023-06-08', '2023-06-09', 2, 'Cuti sakit dengan surat keterangan dokter', 'Human Capital General Affair & Manager', 'Azizah.png', 'WhatsApp Image 2023-06-13 at 09.54.57.jpeg', 'disetujui', 'Brahmo W. Sudibyo', 'Direktur Utama', '', 'ttd pak kadek.png', '2023-06-13 03:20:46', '2023-06-13 03:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_karyawan` varchar(255) DEFAULT NULL,
  `nik` int(9) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `posisi` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `email`, `password`, `nama_karyawan`, `nik`, `tanggal_lahir`, `posisi`, `unit`, `created_at`, `updated_at`) VALUES
(8, 'fanny@gmail.com', '123456', 'fanny', 1232131, '2023-02-15', 'magang', '', '2023-05-23 02:51:48.000000', '2023-06-13 06:27:42.000000'),
(9, 'ara@gmail.com', 'ara123', 'Ara', 123743, '2023-03-20', 'magang', '', '2023-05-23 03:12:51.000000', '2023-05-23 03:12:51.000000'),
(10, 'hartoyo@gmail.com', 'hartoyo1234', 'hartoyo', 231312, '2015-08-24', 'logistic', '', '2023-05-23 03:55:11.000000', '2023-05-23 03:55:11.000000'),
(11, 'aziz@gmail.com', '1234567', 'Aziz', 23124, '2023-02-14', 'manager', '', '2023-05-29 06:16:16.000000', '2023-05-29 06:16:16.000000'),
(12, 'tedy@gmail.com', '12345678', 'tedy', 23568, '2020-03-30', 'finance', '', '2023-05-29 09:48:35.000000', '2023-05-29 09:48:35.000000'),
(14, 'rendy@gmail.com', '123456', 'Rendy', 10053, '2023-05-08', 'HC Officer', '', '2023-05-31 02:04:50.000000', '2023-05-31 02:04:50.000000');

-- --------------------------------------------------------

--
-- Table structure for table `konfig_cuti`
--

CREATE TABLE `konfig_cuti` (
  `id_konfig_cuti` int(11) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `jumlah_cuti` int(11) DEFAULT NULL,
  `cuti_bersama` int(11) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `konfig_cuti`
--

INSERT INTO `konfig_cuti` (`id_konfig_cuti`, `tahun`, `jumlah_cuti`, `cuti_bersama`, `created_at`, `updated_at`) VALUES
(4, 2023, 5, 9, '2021-09-09 05:49:24.000000', '2023-05-23 02:55:43.000000'),
(5, 2022, 10, 4, '2023-05-03 19:14:47.000000', '2023-05-03 19:14:47.000000'),
(6, 2024, 6, 8, '2023-05-31 02:31:20.000000', '2023-05-31 02:31:20.000000');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pejabat_struktural`
--

CREATE TABLE `pejabat_struktural` (
  `id_pejabat_struktural` int(11) NOT NULL,
  `nama_pejabat_struktural` varchar(255) DEFAULT NULL,
  `jabatan` enum('Direktur Utama','Direktur Keuangan & Umum','General Manager Finance & HCGA','General Manager Operation & Maintenance','Finance Manager','Human Capital General Affair & Manager','Operation Manager','Maintenance Manager') DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pejabat_struktural`
--

INSERT INTO `pejabat_struktural` (`id_pejabat_struktural`, `nama_pejabat_struktural`, `jabatan`, `email`, `password`, `image`, `created_at`, `updated_at`) VALUES
(17, 'kaazizah', 'Direktur Utama', 'kaazizah@gmail.com', '1234567', 'Azizah.png', NULL, NULL),
(18, 'Brahmo W. Sudibyo', 'Direktur Utama', 'brahmo@gmail.com', '12345678', 'ttd pak kadek.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_cuti`
--

CREATE TABLE `pengajuan_cuti` (
  `id_pengajuan_cuti` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `lama_cuti` int(11) DEFAULT 1 COMMENT 'dalam hari',
  `keterangan` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `divisi` enum('Direktur Utama','Direktur Keuangan & Umum','General Manager Finance & HCGA','General Manager Operation & Maintenance','Finance Manager','Human Capital General Affair & Manager','Operation Manager','Maintenance Manager') DEFAULT NULL,
  `ttd_karyawan` varchar(255) DEFAULT NULL,
  `status` enum('verifikasi','disetujui','ditolak') DEFAULT 'verifikasi',
  `verifikasi_oleh` varchar(255) DEFAULT NULL,
  `jabatan_verifikasi` varchar(255) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pengajuan_cuti`
--

INSERT INTO `pengajuan_cuti` (`id_pengajuan_cuti`, `id_karyawan`, `tanggal_pengajuan`, `lama_cuti`, `keterangan`, `alamat`, `divisi`, `ttd_karyawan`, `status`, `verifikasi_oleh`, `jabatan_verifikasi`, `catatan`, `image`, `created_at`, `updated_at`) VALUES
(19, 1, '2023-05-09', 4, 'ada', 'Probolinggo', NULL, 'pak kadek.png', 'disetujui', 'Angga', 'Direktur', 'gaada', 'Azizah-removebg-preview.png', '2023-05-08 19:47:12.000000', '2023-05-09 20:58:13.000000'),
(20, 7, '2023-05-24', 1, 'keperluan keluarga', 'surabaya', '', 'Azizah.png', 'disetujui', 'Brahmo W. Sudibyo', 'HRD', 'tidak ada', 'ttd pak kadek.png', '2023-05-23 03:23:27.000000', '2023-05-23 03:31:43.000000'),
(21, 8, '2023-05-26', 1, 'mudik', 'surabaya', '', 'WhatsApp_Image_2023-05-23_at_10.37.27-removebg-preview.png', 'disetujui', 'M. Rifqi Ramadhan', 'Maintenance Manager', 'cepet balik ya mbak', 'WhatsApp Image 2023-05-22 at 19.29.27 (1).jpeg', '2023-05-23 03:38:35.000000', '2023-05-23 04:05:35.000000'),
(22, 9, '2023-05-31', 1, 'sakit', 'ponorogo', '', 'Ara-removebg-preview.png', 'disetujui', 'kaazizah', 'HRD', NULL, 'Azizah.png', '2023-05-23 07:13:02.000000', '2023-05-23 09:34:34.000000'),
(23, 9, '2023-06-05', 1, 'bimbingan dospem', 'ponorogo', '', 'Ara-removebg-preview.png', 'disetujui', 'kaazizah', 'HRD', NULL, 'Azizah.png', '2023-05-23 07:14:39.000000', '2023-05-23 09:33:55.000000'),
(25, 7, '2023-05-26', 1, 'keperluan keluarga', 'surabaya', '', 'Aziz-removebg-preview.png', 'disetujui', 'kaazizah', 'HRD', NULL, 'Azizah.png', '2023-05-25 01:53:08.000000', '2023-05-25 01:53:58.000000'),
(26, 7, '2023-05-30', 1, 'sakit', 'surabaya', '', 'Foto_Khoirun Arining Azizah_20051214018_Universitas Negeri Surabaya.jpg', 'disetujui', 'kaazizah', 'HRD', NULL, 'Azizah.png', '2023-05-25 06:36:36.000000', '2023-05-25 06:39:32.000000'),
(27, 7, '2023-06-06', 1, 'sakit', 'surabaya', '', NULL, 'verifikasi', NULL, NULL, NULL, NULL, '2023-05-26 12:46:37.000000', '2023-05-26 12:46:37.000000'),
(31, 13, '2023-06-01', 1, 'keperluan keluarga', 'malang', '', 'Azizah.png', 'disetujui', 'Brahmo W. Sudibyo', 'HRD', NULL, 'ttd pak kadek.png', '2023-05-31 02:38:23.000000', '2023-05-31 02:42:32.000000'),
(32, 8, '2023-06-01', 1, 'sakit', 'surabaya', '', 'Azizah.png', 'verifikasi', NULL, NULL, NULL, NULL, '2023-05-31 03:22:44.000000', '2023-05-31 03:22:44.000000'),
(33, 13, '2023-06-06', 1, 'keperluan keluarga', 'malang', '', 'Azizah.png', 'verifikasi', NULL, NULL, NULL, NULL, '2023-05-31 03:24:14.000000', '2023-05-31 03:24:14.000000'),
(35, 11, '2023-06-12', 1, 'sakit', 'surabaya', 'Human Capital General Affair & Manager', 'Azizah.png', 'disetujui', 'Brahmo W. Sudibyo', 'Direktur Utama', NULL, 'ttd pak kadek.png', '2023-06-13 03:17:08.000000', '2023-06-13 03:18:15.000000');

-- --------------------------------------------------------

--
-- Stand-in structure for view `sisa_cuti`
-- (See below for the actual view)
--
CREATE TABLE `sisa_cuti` (
`id_karyawan` int(11)
,`nama_karyawan` varchar(255)
,`tahun` int(11)
,`cuti_bersama` int(11)
,`jumlah_cuti` int(11)
,`cuti_terpakai` decimal(32,0)
,`sisa_cuti` decimal(33,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `sisa_cuti`
--
DROP TABLE IF EXISTS `sisa_cuti`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sisa_cuti`  AS SELECT `karyawan`.`id_karyawan` AS `id_karyawan`, `karyawan`.`nama_karyawan` AS `nama_karyawan`, `konfig_cuti`.`tahun` AS `tahun`, `konfig_cuti`.`cuti_bersama` AS `cuti_bersama`, `konfig_cuti`.`jumlah_cuti` AS `jumlah_cuti`, (select ifnull(sum(`pc`.`lama_cuti`),0) from `pengajuan_cuti` `pc` where `pc`.`id_karyawan` = `karyawan`.`id_karyawan` and substr(`pc`.`tanggal_pengajuan`,1,4) = `konfig_cuti`.`tahun` and `pc`.`status` = 'disetujui') AS `cuti_terpakai`, `konfig_cuti`.`jumlah_cuti`- (select ifnull(sum(`pc`.`lama_cuti`),0) from `pengajuan_cuti` `pc` where `pc`.`id_karyawan` = `karyawan`.`id_karyawan` and substr(`pc`.`tanggal_pengajuan`,1,4) = `konfig_cuti`.`tahun` and `pc`.`status` = 'disetujui') AS `sisa_cuti` FROM ((`karyawan` left join `pengajuan_cuti` on(`karyawan`.`id_karyawan` = `pengajuan_cuti`.`id_karyawan`)) join `konfig_cuti`) GROUP BY `karyawan`.`id_karyawan`, `konfig_cuti`.`tahun` ORDER BY `karyawan`.`nama_karyawan` ASC, `konfig_cuti`.`tahun` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`) USING BTREE;

--
-- Indexes for table `cuti_non`
--
ALTER TABLE `cuti_non`
  ADD PRIMARY KEY (`id_cuti_non`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`) USING BTREE;

--
-- Indexes for table `konfig_cuti`
--
ALTER TABLE `konfig_cuti`
  ADD PRIMARY KEY (`id_konfig_cuti`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pejabat_struktural`
--
ALTER TABLE `pejabat_struktural`
  ADD PRIMARY KEY (`id_pejabat_struktural`);

--
-- Indexes for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  ADD PRIMARY KEY (`id_pengajuan_cuti`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cuti_non`
--
ALTER TABLE `cuti_non`
  MODIFY `id_cuti_non` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `konfig_cuti`
--
ALTER TABLE `konfig_cuti`
  MODIFY `id_konfig_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pejabat_struktural`
--
ALTER TABLE `pejabat_struktural`
  MODIFY `id_pejabat_struktural` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pengajuan_cuti`
--
ALTER TABLE `pengajuan_cuti`
  MODIFY `id_pengajuan_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
