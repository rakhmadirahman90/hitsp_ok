-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 24, 2026 at 04:59 AM
-- Server version: 8.0.46-cll-lve
-- PHP Version: 8.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hitspbiz_hitsp`
--
CREATE DATABASE IF NOT EXISTS `hitspbiz_hitsp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `hitspbiz_hitsp`;

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_operator`
--

CREATE TABLE `aktivitas_operator` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akun_email_pribadi`
--

CREATE TABLE `akun_email_pribadi` (
  `id` bigint UNSIGNED NOT NULL,
  `permohonan_id` bigint UNSIGNED NOT NULL,
  `nama_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anggotas`
--

CREATE TABLE `anggotas` (
  `id` bigint UNSIGNED NOT NULL,
  `divisi_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggotas`
--

INSERT INTO `anggotas` (`id`, `divisi_id`, `nama`, `peran`, `foto`, `aktif`, `created_at`, `updated_at`) VALUES
(17, 3, 'Ahmad Fauzan, S.Kom., M.Kom.', 'Ketua', 'uploads/FVgqn0gMopkDcxHIALmshrEYRdoXRiEXaWk6HzqB.jpg', 1, '2026-07-08 23:46:30', '2026-07-08 23:46:30'),
(18, 4, 'Rahmat Hidayat, A.Md.', 'Koordinator', 'uploads/mYN3fFcSw7JeoXRsK2D00P7Ggvw69TZ6p7hwaN6a.jpg', 1, '2026-07-08 23:50:26', '2026-07-08 23:50:26'),
(19, 4, 'Ade Putri Bustan', 'Sekretaris UPT TIK', 'uploads/lqySZUAx68GCJjFjVTXFI8V4ZdD79tMsNPfvfV8X.jpg', 1, '2026-07-08 23:51:54', '2026-07-08 23:51:54'),
(20, 5, 'Muhammad Rizky, S.T.', 'Anggota', 'uploads/te8y2Am5lzxtgRy6qjCkGHMXKzy7slZ0nK9xe7yc.webp', 1, '2026-07-08 23:53:30', '2026-07-08 23:53:30'),
(21, 5, 'Andi Pratama, S.Kom.', 'Koordinator', 'uploads/Z09NKIHrOMwOyZUAaWbvHDyxFTzTwVGOIU2XuqBk.jpg', 1, '2026-07-08 23:54:47', '2026-07-08 23:54:47'),
(22, 6, 'Dwi Cahyo, S.Kom., M.Kom.', 'Koordinator', 'uploads/0E2W7zokMa6T59QxKYvMI4uSEJtzdI977nHaliyH.jpg', 1, '2026-07-09 00:05:25', '2026-07-09 00:05:25'),
(23, 6, 'Fitriani Putri, S.Kom.', 'Anggota', 'uploads/3QWBXGgEfJxhZmCMrh769pHd4mRAaodHdCnFPytv.jpg', 1, '2026-07-09 00:07:12', '2026-07-09 00:07:12'),
(24, 7, 'Rina Marlina, S.Kom.', 'Koordinator', 'uploads/sMFbvM0Sn9do3pCdsy1cf3LLXNDSLnTn2B164IFb.jpg', 1, '2026-07-09 00:08:26', '2026-07-09 00:08:26'),
(26, 7, 'Fajar Nugroho, S.Kom.', 'Anggota', 'uploads/KkUDGDi5Tl1VzON087RRuyiw99CkRUMudHNPnHPf.webp', 1, '2026-07-09 00:09:58', '2026-07-09 00:09:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisis`
--

CREATE TABLE `divisis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisis`
--

INSERT INTO `divisis` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(3, 'Kepala UPT TIK', '2026-03-31 10:52:32', '2026-03-31 10:52:32'),
(4, 'Subbagian Administrasi', '2026-03-31 10:53:34', '2026-03-31 10:53:34'),
(5, 'Divisi Infrastruktur & Jaringan', '2026-03-31 10:53:42', '2026-03-31 10:53:42'),
(6, 'Divisi Sistem Informasi', '2026-03-31 10:53:52', '2026-03-31 10:53:52'),
(7, 'Divisi Layanan & Helpdesk', '2026-03-31 10:54:00', '2026-03-31 10:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `emails_lembaga`
--

CREATE TABLE `emails_lembaga` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_pemohon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Disetujui','Ditolak','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emails_lembaga`
--

INSERT INTO `emails_lembaga` (`id`, `jenis_akun`, `nama_akun`, `password_hash`, `email_pemohon`, `status`, `created_at`, `updated_at`) VALUES
(25, 'Institusi', 'ilmukomputer', '$2y$12$9dkSerXYoqSNDzeytJbn/uHDnvXGVs.UdrHruYndpdsbIoA5NLboq', 'ade@gmail.com', 'Disetujui', '2026-06-15 06:33:35', '2026-06-15 06:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `email_requests`
--

CREATE TABLE `email_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('panduan','faq') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `type`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(7, 'faq', 'Apa itu UPT TIK?', 'UPT TIK adalah unit di perguruan tinggi yang bertugas mengelola layanan teknologi informasi dan komunikasi, seperti jaringan internet, sistem akademik, dan layanan digital kampus.', '2026-03-31 11:00:18', '2026-03-31 11:00:18'),
(8, 'faq', 'Layanan apa saja yang tersedia di UPT TIK?', 'Internet & WiFi kampus\r\nEmail institusi\r\nHosting & domain kampus\r\nBantuan teknis (helpdesk)\r\nAjukan Pembuatan Link Zoom', '2026-03-31 11:01:41', '2026-03-31 11:01:41'),
(9, 'faq', 'Bagaimana cara mengajukan layanan?', 'Pengguna dapat mengajukan layanan melalui:\r\n\r\nWebsite resmi UPT TIK\r\nSistem layanan online\r\nAtau datang langsung ke kantor UPT TIK', '2026-03-31 11:02:02', '2026-03-31 11:02:02'),
(10, 'faq', 'Bagaimana cara melaporkan gangguan internet?', 'Laporkan melalui:\r\n\r\nHelpdesk UPT TIK\r\nForm pengaduan di website\r\nAtau kontak admin', '2026-03-31 11:02:43', '2026-03-31 11:02:43'),
(11, 'faq', 'Siapa saja yang bisa menggunakan layanan UPT TIK?', 'Semua civitas akademika:\r\n\r\nMahasiswa\r\nDosen\r\nTenaga kependidikan', '2026-03-31 11:03:04', '2026-03-31 11:03:04'),
(12, 'panduan', 'Panduan Login Sistem', 'Buka website kampus\r\nKlik menu login\r\nMasukkan username & password\r\nKlik masuk', '2026-03-31 11:03:28', '2026-03-31 11:03:28'),
(13, 'panduan', 'Panduan Pengajuan Email Kampus', 'Login ke sistem layanan\r\nPilih menu “Permohonan Email”\r\nIsi data lengkap\r\nSubmit permohonan\r\nTunggu verifikasi admin', '2026-03-31 11:03:45', '2026-03-31 11:03:45'),
(14, 'panduan', 'Panduan Akses WiFi Kampus', 'Hubungkan ke jaringan WiFi kampus\r\nMasukkan username & password\r\nJika gagal, hubungi helpdesk', '2026-03-31 11:04:06', '2026-03-31 11:04:06');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(17, 'Ruangan Lab', '2026-06-09 04:32:05', '2026-06-09 04:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_gambar`
--

CREATE TABLE `fasilitas_gambar` (
  `id` bigint UNSIGNED NOT NULL,
  `fasilitas_id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fasilitas_gambar`
--

INSERT INTO `fasilitas_gambar` (`id`, `fasilitas_id`, `gambar`, `created_at`, `updated_at`) VALUES
(38, 17, '1781004725_6a27f9b54d7b4.jpeg', '2026-06-09 04:32:05', '2026-06-09 04:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `hosting_access`
--

CREATE TABLE `hosting_access` (
  `id` bigint UNSIGNED NOT NULL,
  `sub_domain_id` bigint UNSIGNED NOT NULL,
  `ip_server` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssh_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssh_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotspot_credentials`
--

CREATE TABLE `hotspot_credentials` (
  `id` bigint UNSIGNED NOT NULL,
  `hotspot_user_id` bigint UNSIGNED NOT NULL,
  `username_hotspot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hotspot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotspot_users`
--

CREATE TABLE `hotspot_users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `akses` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun_hotspot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_hotspot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pj_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pj_nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pj_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pj_telepon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `persetujuan` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username_hotspot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hotspot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotspot_users`
--

INSERT INTO `hotspot_users` (`id`, `user_id`, `akses`, `nama_lengkap`, `jabatan`, `nip`, `akun_hotspot`, `no_telepon`, `email`, `nama_hotspot`, `pj_nama`, `pj_nip`, `pj_jabatan`, `pj_telepon`, `persetujuan`, `status`, `created_at`, `updated_at`, `username_hotspot`, `password_hotspot`) VALUES
(74, 121, 'Dosen', 'Sitti Aisyah', 'Dosen', '787329835178546153', 'Pengguna Baru', '089783468632', 'sittiaisyah@gmail.com', 'Nama institusi/kampus', 'Budi Santoso', '199008172014041001', 'Admin TIK', '082112345678', 0, 'pending', '2026-07-08 09:08:57', '2026-07-08 09:08:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatans`
--

INSERT INTO `kegiatans` (`id`, `judul`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(9, 'UPT TIK Tingkatkan Layanan dengan Upgrade Sistem Akademik', 'Makassar – UPT TIK kampus terus berkomitmen meningkatkan kualitas layanan digital dengan melakukan upgrade sistem akademik (SIAKAD), Senin (1/4/2026).\r\n\r\nUpgrade ini dilakukan untuk meningkatkan kecepatan akses, keamanan data, serta kenyamanan pengguna, baik mahasiswa maupun dosen.\r\n\r\nKepala UPT TIK menyampaikan bahwa pembaruan ini merupakan bagian dari transformasi digital kampus.\r\n\r\n“Dengan sistem yang lebih modern, diharapkan seluruh proses akademik dapat berjalan lebih efektif dan efisien,” ujarnya.\r\n\r\nFitur baru yang ditambahkan antara lain:\r\n\r\nTampilan antarmuka yang lebih user-friendly\r\nAkses melalui perangkat mobile\r\nPeningkatan keamanan login\r\n\r\nUPT TIK juga menyediakan layanan helpdesk untuk membantu pengguna yang mengalami kendala selama masa transisi.', 'kegiatan/H5IKvEvI2EZPkRvSysWqQ0WndMKc2oysg5UDF7ms.jpg', '2026-03-31 10:37:02', '2026-03-31 10:37:02'),
(10, 'UPT TIK Sosialisasikan Penggunaan Email Akademik', 'UPT TIK mengadakan kegiatan sosialisasi penggunaan email akademik bagi mahasiswa baru.\r\n\r\nKegiatan ini bertujuan agar mahasiswa memahami pentingnya email kampus sebagai sarana komunikasi resmi dan akses ke berbagai layanan digital.\r\n\r\nPeserta diberikan panduan:\r\n\r\nCara aktivasi email\r\nPenggunaan untuk e-learning\r\nTips menjaga keamanan akun\r\n\r\nKegiatan berlangsung dengan antusias dan diikuti oleh ratusan mahasiswa.', 'kegiatan/GS4DQodxCGaGFy8DId56nrzV586y5iaOh4WhxLpq.jpg', '2026-03-31 10:45:02', '2026-03-31 10:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat_urgensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `ticket_no`, `user_id`, `nama_pengirim`, `status_pengirim`, `judul`, `kategori`, `tingkat_urgensi`, `lokasi`, `deskripsi`, `bukti`, `tanggal`, `status`, `created_at`, `updated_at`) VALUES
(43, 'TKT-20260709-001', 121, 'Sitti Aisyah', 'dosen', 'Wifi kampus bermasalah', 'Wifi', 'Rendah', 'Kampus 2', 'Jaringan dikampus 2 bermasalah', NULL, '2026-07-09', 'Menunggu', '2026-07-09 00:48:57', '2026-07-09 00:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `layanans`
--

CREATE TABLE `layanans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanans`
--

INSERT INTO `layanans` (`id`, `nama`, `icon`, `created_at`, `updated_at`) VALUES
(8, 'Request Pembuatan Email', 'fa-solid fa-envelope', '2026-04-22 06:30:21', '2026-04-25 04:21:00'),
(9, 'Request Hosting Web', 'fa-solid fa-globe', '2026-04-22 06:30:32', '2026-04-22 06:30:32'),
(10, 'Request Pembuatan Link Zoom', 'fa-solid fa-video', '2026-04-22 06:30:47', '2026-04-30 06:20:58'),
(11, 'Request Pembuatan  Hotspot', 'fa-solid fa-server', '2026-04-22 06:31:04', '2026-04-22 06:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `master_plans`
--

CREATE TABLE `master_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_plans`
--

INSERT INTO `master_plans` (`id`, `judul`, `file`, `created_at`, `updated_at`) VALUES
(5, 'MASTER PLAN TIK - ITH 2026-2031', '1774979954_master_plan_upt_tik.pdf', '2026-03-31 10:59:14', '2026-03-31 10:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_12_07_124337_create_users_table', 1),
(4, '2025_12_07_125422_create_sessions_table', 1),
(5, '2025_12_14_134838_create_zoom_requests_table', 1),
(6, '2025_12_18_130534_create_visi_misi_table', 1),
(7, '2025_12_25_123506_create_sejarah_table', 1),
(8, '2025_12_25_123631_create_sejarah_gambar_table', 1),
(9, '2025_12_25_153305_create_divisis_table', 1),
(10, '2025_12_25_153316_create_anggotas_table', 1),
(11, '2025_12_25_153329_create_struktur_organisasi_table', 1),
(12, '2025_12_27_035136_create_layanans_table', 1),
(13, '2025_12_27_035210_create_pengumumans_table', 1),
(14, '2025_12_27_035348_create_kegiatans_table', 1),
(15, '2025_12_27_071854_create_faqs_table', 1),
(16, '2026_01_04_152233_create_fasilitas_table', 1),
(17, '2026_01_04_152347_create_fasilitas_gambar_table', 1),
(18, '2026_01_04_162501_create_laporans_table', 1),
(19, '2026_01_06_134501_create_master_plans_table', 1),
(20, '2026_01_07_100227_create_email_requests_table', 1),
(21, '2026_01_07_101653_create_zoom_requests_table', 2),
(22, '2026_01_08_044753_create_hotspot_users_table', 2),
(23, '2026_01_08_074810_create_sub_domains_table', 2),
(24, '2026_01_08_151524_create_hosting_accesses_table', 3),
(25, '2026_01_08_163036_create_permohonan_email_pribadi_table', 4),
(26, '2026_01_08_170455_create_permohonan_email_lembaga_table', 5),
(27, '2026_01_08_172203_create_permohonan_email_lembaga_table', 6),
(28, '2026_01_08_192846_create_emails_lembaga_table', 7),
(29, '2026_01_09_053953_create_akun_email_pribadi_table', 8),
(30, '2026_01_09_101330_add_password_hotspot_to_hotspot_users_table', 9),
(31, '2026_01_09_103054_drop_old_hotspot_columns_from_hotspot_users_table', 10),
(32, '2026_01_09_103340_add_hotspot_columns_to_hotspot_users_table', 11),
(33, '2026_01_09_103556_drop_hotspot_columns_from_hotspot_users_table', 12),
(34, '2026_01_09_104042_create_hotspot_users_table', 13),
(35, '2026_01_09_113407_create_hotspot_users_table', 14),
(36, '2026_01_10_091101_add_name_to_users_table', 15),
(37, '2026_01_11_061850_change_akses_column_on_hotspot_users', 16),
(38, '2026_01_11_064727_create_hotspot_credentials_table', 17),
(39, '2026_01_11_120849_create_hosting_access_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `is_read` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Permintaan Zoom Baru', 'cdcbjhsbdcjh mengajukan permintaan Zoom pada tanggal 2026-05-17', 1, '2026-05-16 05:52:47', '2026-05-16 06:17:33'),
(2, NULL, 'Permintaan Zoom Baru', 'cdcbjhsbdcjh mengajukan permintaan Zoom pada tanggal 2026-05-22', 1, '2026-05-16 06:25:14', '2026-05-16 06:25:32'),
(3, NULL, 'Laporan Baru Masuk', 'cdcbjhsbdcjh mengirim laporan dengan tiket TKT-20260516-001', 1, '2026-05-16 06:30:34', '2026-05-16 06:30:56'),
(4, NULL, 'Laporan Baru Masuk', 'cdcbjhsbdcjh mengirim laporan dengan tiket TKT-20260516-002', 1, '2026-05-16 06:30:41', '2026-05-16 06:30:56'),
(5, NULL, 'Laporan Baru Masuk', 'cdcbjhsbdcjh mengirim laporan dengan tiket TKT-20260516-003', 1, '2026-05-16 06:31:33', '2026-05-16 06:31:50'),
(6, NULL, 'Laporan Baru Masuk', 'cdcbjhsbdcjh mengirim laporan dengan tiket TKT-20260516-004', 1, '2026-05-16 06:31:39', '2026-05-16 06:31:50'),
(7, NULL, 'Laporan Baru Masuk', 'cdcbjhsbdcjh mengirim laporan dengan tiket TKT-20260516-015', 1, '2026-05-16 06:52:25', '2026-05-16 06:52:41'),
(8, NULL, 'Permintaan Subdomain Baru', 'cdcbjhsbdcjh mengajukan request subdomain: kkjn', 1, '2026-05-16 06:55:46', '2026-05-16 06:55:52'),
(9, NULL, 'Permohonan Hotspot Baru', 'cdcbjhsbdcjh mengajukan hotspot: Nama institusi/kampus', 1, '2026-05-16 06:58:58', '2026-05-16 06:59:10'),
(10, 100, 'Logout', 'cdcbjhsbdcjh telah logout', 1, '2026-05-16 07:03:33', '2026-05-16 07:04:41'),
(11, NULL, 'User Baru Mendaftar', 'ghdghsd melakukan registrasi akun', 1, '2026-05-16 07:04:11', '2026-05-16 07:04:41'),
(12, NULL, 'Pendaftaran User Baru', 'kjd baru saja mendaftar', 1, '2026-05-16 07:09:08', '2026-05-16 07:09:20'),
(13, NULL, 'Pendaftaran User Baru', 'jsh baru saja mendaftar', 1, '2026-05-16 07:15:29', '2026-05-16 07:30:20'),
(14, NULL, 'Permohonan Email Pribadi', 'cdcbjhsbdcjh mengajukan permohonan email baru', 1, '2026-05-16 07:32:10', '2026-05-16 07:32:44'),
(15, NULL, 'Permintaan Subdomain Baru', 'dsffdf mengajukan request subdomain: C', 1, '2026-05-16 08:50:33', '2026-05-16 09:47:06'),
(16, NULL, 'Permintaan Subdomain Baru', 'dsffdf mengajukan request subdomain: JBJ', 1, '2026-05-16 09:10:31', '2026-05-16 09:47:06'),
(17, NULL, 'Permintaan Subdomain Baru', 'dsffdf mengajukan request subdomain: JBJHBH', 1, '2026-05-16 09:16:24', '2026-05-16 09:47:06'),
(18, NULL, 'Permintaan Subdomain Baru', 'dsffdf mengajukan request subdomain: jbjhj', 1, '2026-05-16 09:18:32', '2026-05-16 09:47:06'),
(19, NULL, 'Permintaan Subdomain Baru', 'dsffdf mengajukan request subdomain: dsdvv', 1, '2026-05-16 09:24:05', '2026-05-16 09:47:06'),
(20, NULL, 'Pendaftaran User Baru', 'aksjndjkd baru saja mendaftar', 1, '2026-05-16 21:49:55', '2026-05-17 07:22:33'),
(21, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-18', 1, '2026-05-16 21:52:45', '2026-05-17 07:22:33'),
(22, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: dsfsd', 1, '2026-05-16 22:26:37', '2026-05-17 07:22:33'),
(23, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: sdfsdg', 1, '2026-05-16 23:23:00', '2026-05-17 07:22:33'),
(24, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: gf', 1, '2026-05-16 23:27:14', '2026-05-17 07:22:33'),
(25, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: kjnskjnds', 1, '2026-05-17 00:07:32', '2026-05-17 07:22:33'),
(26, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: bjbjkb', 1, '2026-05-17 00:33:28', '2026-05-17 07:22:33'),
(27, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: kjnkj', 1, '2026-05-17 00:35:12', '2026-05-17 07:22:33'),
(28, NULL, 'Permintaan Subdomain Baru', 'aksjndjkd mengajukan request subdomain: vbvvb', 1, '2026-05-17 00:40:36', '2026-05-17 07:22:33'),
(29, NULL, 'Permohonan Email Lembaga', 'testes mengajukan permohonan email lembaga', 1, '2026-05-17 07:44:43', '2026-05-17 07:47:25'),
(30, NULL, 'Permohonan Email Lembaga', 'aksjndjkd mengajukan permohonan email lembaga', 1, '2026-05-17 07:48:45', '2026-05-17 08:09:49'),
(31, NULL, 'Permohonan Email Lembaga', 'testes mengajukan permohonan email lembaga', 1, '2026-05-17 07:53:57', '2026-05-17 08:09:49'),
(32, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 08:04:07', '2026-05-17 08:09:49'),
(33, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 08:22:05', '2026-05-17 08:23:31'),
(34, NULL, 'Permohonan Email Pribadi', 'testes mengajukan permohonan email baru', 1, '2026-05-17 08:29:05', '2026-05-17 08:37:31'),
(35, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-18', 1, '2026-05-17 08:54:51', '2026-06-09 04:12:40'),
(36, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-20', 1, '2026-05-17 08:55:18', '2026-06-09 04:12:40'),
(37, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-21', 1, '2026-05-17 08:55:39', '2026-06-09 04:12:40'),
(38, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-21', 1, '2026-05-17 08:56:23', '2026-06-09 04:12:40'),
(39, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-20', 1, '2026-05-17 08:56:41', '2026-06-09 04:12:40'),
(40, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-29', 1, '2026-05-17 08:57:03', '2026-06-09 04:12:40'),
(41, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-21', 1, '2026-05-17 08:57:39', '2026-06-09 04:12:40'),
(42, NULL, 'Permintaan Zoom Baru', 'aksjndjkd mengajukan permintaan Zoom pada tanggal 2026-05-28', 1, '2026-05-17 08:58:00', '2026-06-09 04:12:40'),
(43, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 09:00:15', '2026-06-09 04:12:40'),
(44, NULL, 'Permohonan Email Pribadi', 'testes mengajukan permohonan email baru', 1, '2026-05-17 09:08:55', '2026-06-09 04:12:40'),
(45, NULL, 'Permohonan Email Pribadi', 'testes mengajukan permohonan email baru', 1, '2026-05-17 09:11:38', '2026-06-09 04:12:40'),
(46, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 09:12:10', '2026-06-09 04:12:40'),
(47, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 09:15:37', '2026-06-09 04:12:40'),
(48, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 09:18:00', '2026-06-09 04:12:40'),
(49, 1, 'Permohonan Email Pribadi Disetujui', 'Akun email pribadi atas nama aksjndjkd (ilkom2@institusi.ac.id) berhasil diaktifkan.', 1, '2026-05-17 09:21:49', '2026-06-09 04:12:40'),
(50, NULL, 'Permohonan Email Pribadi', 'aksjndjkd mengajukan permohonan email baru', 1, '2026-05-17 09:29:22', '2026-06-09 04:12:40'),
(51, NULL, 'Permohonan Email Pribadi', 'jsh mengajukan permohonan email baru', 1, '2026-05-17 23:48:18', '2026-06-09 04:12:40'),
(52, NULL, 'Permohonan Email Pribadi', 'jsh mengajukan permohonan email baru', 1, '2026-05-17 23:51:03', '2026-06-09 04:12:40'),
(53, NULL, 'Permohonan Email Pribadi', 'testes mengajukan permohonan email baru', 1, '2026-05-18 00:19:19', '2026-06-09 04:12:40'),
(54, NULL, 'Permohonan Email Pribadi', 'testes mengajukan permohonan email baru', 1, '2026-05-18 00:25:07', '2026-06-09 04:12:40'),
(55, NULL, 'Permohonan Email Pribadi', 'testes mengajukan permohonan email baru', 1, '2026-05-18 00:34:19', '2026-06-09 04:12:40'),
(56, NULL, 'Permohonan Email Pribadi', 'test mengajukan permohonan email baru', 1, '2026-05-18 03:34:44', '2026-06-09 04:12:40'),
(57, NULL, 'Permohonan Email Pribadi', 'test mengajukan permohonan email baru', 1, '2026-05-18 03:46:04', '2026-06-09 04:12:40'),
(58, NULL, 'Permohonan Email Pribadi', 'test mengajukan permohonan email baru', 1, '2026-05-18 03:50:11', '2026-06-09 04:12:40'),
(59, NULL, 'Permohonan Email Pribadi', 'test mengajukan permohonan email baru', 1, '2026-05-18 03:51:38', '2026-06-09 04:12:40'),
(60, NULL, 'Permohonan Email Pribadi', 'test mengajukan permohonan email baru', 1, '2026-05-18 03:58:54', '2026-06-09 04:12:40'),
(61, NULL, 'Permohonan Email Pribadi', 'test mengajukan permohonan email baru', 1, '2026-05-18 04:00:27', '2026-06-09 04:12:40'),
(62, NULL, 'Pendaftaran User Baru', 'Ade Putri baru saja mendaftar', 1, '2026-06-09 04:05:47', '2026-06-09 04:12:40'),
(63, NULL, 'Pendaftaran User Baru', 'Ade Putri Bustan baru saja mendaftar', 1, '2026-06-09 04:08:52', '2026-06-09 04:12:40'),
(64, NULL, 'Permintaan Zoom Baru', 'Ade Putri Bustan mengajukan permintaan Zoom pada tanggal 2026-06-10', 1, '2026-06-09 04:11:18', '2026-06-09 04:12:40'),
(65, NULL, 'Permohonan Hotspot Baru', 'Ade Putri Bustan mengajukan hotspot: Nama institusi/kampus', 1, '2026-06-09 04:20:20', '2026-06-15 05:31:20'),
(66, NULL, 'Laporan Baru Masuk', 'Ade Putri Bustan mengirim laporan dengan tiket TKT-20260609-001', 1, '2026-06-09 04:28:21', '2026-06-15 05:31:20'),
(67, NULL, 'Permohonan Email Pribadi', 'Ade Putri mengajukan permohonan email baru', 1, '2026-06-15 05:54:28', '2026-06-15 05:55:22'),
(68, NULL, 'Permohonan Email Lembaga', 'Ade Putri mengajukan permohonan email lembaga', 1, '2026-06-15 06:19:01', '2026-07-07 05:56:00'),
(69, NULL, 'Permintaan Subdomain Baru', 'Ade Putri mengajukan request subdomain: email@ith.ac.id', 1, '2026-06-15 06:58:25', '2026-07-07 05:56:00'),
(70, NULL, 'Permohonan Hotspot Baru', 'Ade Putri mengajukan hotspot: Nama institusi/kampus', 1, '2026-06-15 07:03:11', '2026-07-07 05:56:00'),
(71, NULL, 'Permintaan Zoom Baru', 'Ade Putri Bustan mengajukan permintaan Zoom pada tanggal 2026-06-16', 1, '2026-06-15 07:14:09', '2026-07-07 05:56:00'),
(72, NULL, 'Permohonan Email Pribadi', 'Ade Putri Bustan mengajukan permohonan email baru', 1, '2026-06-15 07:55:10', '2026-07-07 05:56:00'),
(73, NULL, 'Permohonan Email Lembaga', 'Ade Putri Bustan mengajukan permohonan email lembaga', 1, '2026-06-15 07:57:24', '2026-07-07 05:56:00'),
(74, NULL, 'Permohonan Email Lembaga', 'test mengajukan permohonan email lembaga', 1, '2026-06-15 08:21:27', '2026-07-07 05:56:00'),
(75, NULL, 'Permintaan Subdomain Baru', 'test mengajukan request subdomain: dsdvviii', 1, '2026-06-15 08:31:17', '2026-07-07 05:56:00'),
(76, NULL, 'Permintaan Subdomain Baru', 'Ade Putri Bustan mengajukan request subdomain: email', 1, '2026-06-15 08:33:16', '2026-07-07 05:56:00'),
(77, NULL, 'Permintaan Subdomain Baru', 'Ade Putri mengajukan request subdomain: Tes', 1, '2026-06-16 03:44:10', '2026-07-07 05:56:00'),
(78, NULL, 'Permintaan Zoom Baru', 'Ade Putri Bustan mengajukan permintaan Zoom pada tanggal 2026-06-17', 1, '2026-06-16 03:45:20', '2026-07-07 05:56:00'),
(79, NULL, 'Pendaftaran User Baru', 'Putri baru saja mendaftar', 1, '2026-06-16 08:53:23', '2026-07-07 05:56:00'),
(80, NULL, 'Permohonan Email Pribadi', 'Putri mengajukan permohonan email baru', 1, '2026-06-16 08:54:56', '2026-07-07 05:56:00'),
(81, NULL, 'Pendaftaran User Baru', 'Put baru saja mendaftar', 1, '2026-06-16 08:58:08', '2026-07-07 05:56:00'),
(82, NULL, 'Permohonan Email Pribadi', 'Put mengajukan permohonan email baru', 1, '2026-06-16 09:00:03', '2026-07-07 05:56:00'),
(83, NULL, 'Permohonan Email Pribadi', 'Put mengajukan permohonan email baru', 1, '2026-06-16 09:01:34', '2026-07-07 05:56:00'),
(84, NULL, 'Permohonan Email Lembaga', 'Put mengajukan permohonan email lembaga', 1, '2026-06-16 09:02:43', '2026-07-07 05:56:00'),
(86, NULL, 'Permohonan Email Lembaga', 'Put mengajukan permohonan email lembaga', 1, '2026-06-16 09:06:14', '2026-07-07 05:56:00'),
(87, NULL, 'Permintaan Zoom Baru', 'Put mengajukan permintaan Zoom pada tanggal 2026-06-18', 1, '2026-06-16 09:08:00', '2026-07-07 05:56:00'),
(88, NULL, 'Permintaan Subdomain Baru', 'Put mengajukan request subdomain: Kiw', 1, '2026-06-16 09:09:48', '2026-07-07 05:56:00'),
(89, NULL, 'Permintaan Subdomain Baru', 'Put mengajukan request subdomain: Pui', 1, '2026-06-16 09:11:10', '2026-07-07 05:56:00'),
(90, NULL, 'Permohonan Hotspot Baru', 'Put mengajukan hotspot: Nama institusi/kampus', 1, '2026-06-16 09:17:05', '2026-07-07 05:56:00'),
(91, NULL, 'Permohonan Hotspot Baru', 'Put mengajukan hotspot: Nama institusi/kampus', 1, '2026-06-16 09:18:51', '2026-07-07 05:56:00'),
(92, NULL, 'Laporan Baru Masuk', 'Put mengirim laporan dengan tiket TKT-20260616-001', 1, '2026-06-16 09:30:50', '2026-07-07 05:56:00'),
(93, NULL, 'Pendaftaran User Baru', 'Ade baru saja mendaftar', 1, '2026-06-16 19:02:54', '2026-07-07 05:56:00'),
(94, NULL, 'Pendaftaran User Baru', 'Ade baru saja mendaftar', 1, '2026-07-07 07:25:09', '2026-07-07 11:12:39'),
(95, NULL, 'Permohonan Email Pribadi', 'Ade mengajukan permohonan email baru', 1, '2026-07-07 07:29:23', '2026-07-07 11:12:39'),
(96, NULL, 'Permohonan Email Lembaga', 'Ade mengajukan permohonan email lembaga', 1, '2026-07-07 08:18:18', '2026-07-07 11:12:39'),
(97, NULL, 'Permohonan Hotspot Baru', 'Ade mengajukan hotspot: Nama institusi/kampus', 0, '2026-07-07 11:13:48', '2026-07-07 11:13:48'),
(98, NULL, 'Laporan Baru Masuk', 'Ade mengirim laporan dengan tiket TKT-20260707-001', 0, '2026-07-07 11:15:14', '2026-07-07 11:15:14'),
(99, NULL, 'Pendaftaran User Baru', 'tess baru saja mendaftar', 0, '2026-07-07 12:58:34', '2026-07-07 12:58:34'),
(100, NULL, 'Pendaftaran User Baru', 'saya baru saja mendaftar', 0, '2026-07-07 13:02:18', '2026-07-07 13:02:18'),
(101, NULL, 'Laporan Baru Masuk', 'saya mengirim laporan dengan tiket TKT-20260707-002', 0, '2026-07-07 13:09:44', '2026-07-07 13:09:44'),
(102, NULL, 'Pendaftaran User Baru', 'Dosen baru saja mendaftar', 0, '2026-07-07 20:53:56', '2026-07-07 20:53:56'),
(103, NULL, 'Permintaan Zoom Baru', 'Dosen mengajukan permintaan Zoom pada tanggal 2026-07-09', 0, '2026-07-07 21:40:40', '2026-07-07 21:40:40'),
(104, NULL, 'Permohonan Email Pribadi', 'Ade Putri Bustan mengajukan permohonan email baru', 0, '2026-07-08 08:55:22', '2026-07-08 08:55:22'),
(105, NULL, 'Permohonan Email Lembaga', 'Sitti Aisyah mengajukan permohonan email lembaga', 0, '2026-07-08 09:03:40', '2026-07-08 09:03:40'),
(106, NULL, 'Permintaan Subdomain Baru', 'Sitti Aisyah mengajukan request subdomain: hitsp.biz.id', 0, '2026-07-08 09:07:10', '2026-07-08 09:07:10'),
(107, NULL, 'Permohonan Hotspot Baru', 'Sitti Aisyah mengajukan hotspot: Nama institusi/kampus', 0, '2026-07-08 09:08:57', '2026-07-08 09:08:57'),
(108, NULL, 'Laporan Baru Masuk', 'Sitti Aisyah mengirim laporan dengan tiket TKT-20260709-001', 0, '2026-07-09 00:48:57', '2026-07-09 00:48:57'),
(109, NULL, 'Permohonan Email Pribadi', 'Sitti Aisyah mengajukan permohonan email baru', 0, '2026-07-09 00:52:18', '2026-07-09 00:52:18'),
(110, NULL, 'Permintaan Zoom Baru', 'Sitti Aisyah mengajukan permintaan Zoom pada tanggal 2026-07-10', 0, '2026-07-09 01:53:15', '2026-07-09 01:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `pengumumans`
--

CREATE TABLE `pengumumans` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `isi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengumumans`
--

INSERT INTO `pengumumans` (`id`, `tanggal`, `isi`, `created_at`, `updated_at`) VALUES
(5, '2026-04-22', 'Dihimbau kepada seluruh pengguna sistem untuk:\n\nTidak membagikan password\nMengganti password secara berkala\nMenghindari akses dari perangkat umum', '2026-04-22 06:32:07', '2026-04-22 06:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_email_lembaga`
--

CREATE TABLE `permohonan_email_lembaga` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_institusi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_akun` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_alternatif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip_nik_nim_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telp_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `alasan_tolak` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_email_lembaga`
--

INSERT INTO `permohonan_email_lembaga` (`id`, `nama_institusi`, `nama_kegiatan`, `nama_akun`, `email_alternatif`, `nama_teknis`, `nip_nik_nim_teknis`, `jabatan_teknis`, `status_teknis`, `telp_teknis`, `created_at`, `updated_at`, `status`, `catatan`, `alasan_tolak`) VALUES
(39, 'Institut teknologi bachruddiin jusuf habibie', 'ada', 'ilmukomputer', 'ade@gmail.com', 'Ade Putri', '221011039', 'mahasiswa', 'Mahasiswa', '089097878676', '2026-06-15 06:19:01', '2026-06-15 06:33:35', 'disetujui', NULL, NULL),
(40, 'Institut teknologi bachruddiin jusuf habibie', 'seminar', 'ilmukomputer', 'dosen@gmail.com', 'Ade Putri Bustan', '222222222222222222', 'dosen', 'pegawai tetap', '089898786765', '2026-06-15 07:57:24', '2026-06-15 08:18:43', 'ditolak', 'ulangi', 'ulangi'),
(46, 'Institut teknologi bachruddiin jusuf habibie', 'seminar', 'sittiaisyah', 'sittiaisyah@gmail.com', 'Sitti Aisyah', '787329835178546153', 'Dosen', 'Dosen', '089778678523', '2026-07-08 09:03:40', '2026-07-08 09:03:40', 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_email_pribadi`
--

CREATE TABLE `permohonan_email_pribadi` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pemohon` enum('pegawai','mahasiswa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_alternatif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rek_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rek_identitas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rek_fakultas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rek_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `alasan_tolak` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permohonan_email_pribadi`
--

INSERT INTO `permohonan_email_pribadi` (`id`, `user_id`, `nama_lengkap`, `jenis_pemohon`, `fakultas`, `jurusan`, `jabatan`, `nomor_identitas`, `no_telp`, `email_alternatif`, `file_identitas`, `email_name`, `email_domain`, `rek_nama`, `rek_identitas`, `rek_fakultas`, `rek_email`, `status`, `alasan_tolak`, `created_at`, `updated_at`) VALUES
(71, 121, 'Sitti Aisyah', 'pegawai', 'Ilmu komputer', 'Teknologi produksi dan industri', 'Dosen', '787329835178546153', '028726263535', 'sittiaisyah@gmail.com', 'uploads/identitas/m8Nhk5UqntK0t2GnknjFuBjOGEZFsmRv6He8f1vF.jpg', 'sitiaisyah', '@ith.ac.id', NULL, NULL, NULL, NULL, 'pending', NULL, '2026-07-09 00:52:18', '2026-07-09 00:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `sejarah`
--

CREATE TABLE `sejarah` (
  `id` bigint UNSIGNED NOT NULL,
  `isi_sejarah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sejarah`
--

INSERT INTO `sejarah` (`id`, `isi_sejarah`, `created_at`, `updated_at`) VALUES
(1, 'Unit Pelaksana Teknis Teknologi Informasi dan Komunikasi (UPT TIK) merupakan unit pendukung di lingkungan perguruan tinggi yang bertugas dalam pengelolaan dan pengembangan sistem teknologi informasi.\r\n\r\nUPT TIK didirikan sebagai respon terhadap kebutuhan akan layanan teknologi yang semakin berkembang di dunia pendidikan, khususnya dalam mendukung kegiatan akademik, administrasi, dan komunikasi digital.\r\n\r\nSejak awal berdirinya, UPT TIK berfokus pada penyediaan infrastruktur jaringan internet, pengelolaan sistem informasi akademik (SIAKAD), serta layanan email institusi bagi civitas akademika.\r\n\r\nSeiring dengan perkembangan teknologi, UPT TIK terus melakukan inovasi dengan mengembangkan berbagai sistem digital, seperti:\r\n\r\nSistem informasi akademik berbasis web\r\nE-learning untuk proses pembelajaran daring\r\nLayanan hotspot kampus\r\nSistem manajemen data terintegrasi\r\n\r\nSelain itu, UPT TIK juga berperan aktif dalam menjaga keamanan data dan jaringan kampus, serta memberikan layanan bantuan teknis (helpdesk) kepada mahasiswa, dosen, dan tenaga kependidikan.\r\n\r\nHingga saat ini, UPT TIK terus berkomitmen untuk meningkatkan kualitas layanan teknologi informasi guna mendukung terwujudnya kampus berbasis digital yang modern, efektif, dan efisien.', '2026-01-11 06:59:54', '2026-03-31 10:47:37');

-- --------------------------------------------------------

--
-- Table structure for table `sejarah_gambar`
--

CREATE TABLE `sejarah_gambar` (
  `id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sejarah_gambar`
--

INSERT INTO `sejarah_gambar` (`id`, `gambar`, `created_at`, `updated_at`) VALUES
(7, '1783579182.jpeg', '2026-07-08 23:39:42', '2026-07-08 23:39:42'),
(8, '1783579248.jpeg', '2026-07-08 23:40:48', '2026-07-08 23:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `layanan` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan_admin` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JMj8lFEDuNkgMcDUzXXHCmTotdbVZji3csGCKuln', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkd3RkFTMWJRekZqR2tNeVZtTG1rTVA0SnFjMzR0VlljYjEwSG5URCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9oaXRzcC50ZXN0L2FkbWluL2ZhcSI7czo1OiJyb3V0ZSI7czo5OiJrZWxvbGFmYXEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1768190601),
('xMyg5XdF3LxOrpocF1v5EME9Joyh7Yq3jG8eX9fT', 21, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN21vZXhIQ1Q4WU5WZGJCTzlUTjMxUVNuZFZ3WW9DNURrbTB4SDJYSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9oaXRzcC50ZXN0L2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMTt9', 1768190492);

-- --------------------------------------------------------

--
-- Table structure for table `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `struktur_organisasi`
--

INSERT INTO `struktur_organisasi` (`id`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'struktur/Mpq9JbWAn8FfUq8OWUSRpeufBYRKxGYp6ZAurENE.png', '2026-01-11 07:02:51', '2026-07-08 23:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `sub_domains`
--

CREATE TABLE `sub_domains` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jenis_domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_organisasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_rumah_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp_kantor_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp_rumah_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_nim_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_rumah_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp_kantor_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_teknis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sub_domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `alasan_tolak` text COLLATE utf8mb4_unicode_ci,
  `ip_server` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssh_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssh_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_domains`
--

INSERT INTO `sub_domains` (`id`, `user_id`, `jenis_domain`, `nama_organisasi`, `nama_admin`, `nip_admin`, `alamat_kantor_admin`, `alamat_rumah_admin`, `telp_kantor_admin`, `telp_rumah_admin`, `email_admin`, `nama_teknis`, `nip_nim_teknis`, `alamat_kantor_teknis`, `alamat_rumah_teknis`, `telp_kantor_teknis`, `email_teknis`, `nama_sub_domain`, `status`, `alasan_tolak`, `ip_server`, `ssh_user`, `ssh_password`, `db_name`, `db_user`, `db_password`, `app_path`, `created_at`, `updated_at`) VALUES
(47, 121, 'Lembaga/Fakultas/Jurusan', 'Ilmu Komputer', 'Budi Santoso', '199008172014041001', 'Jl. Bau Massepe', 'Andi Makassau', '042127899', '089876789898', 'budisantoso@gmail.com', 'Sitti Aisyah', '787329835178546153', 'jalan bau massepe', 'jalan bau massepe', '089273896876', 'sittiaisyah@gmail.com', 'hitsp.biz.id', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-08 09:07:10', '2026-07-08 09:07:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution_domain` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `institution`, `institution_domain`, `password`, `role`, `created_at`, `updated_at`, `status`) VALUES
(1, '101010', 'Superadmin', 'tik@ith.ac.id', NULL, NULL, '$2y$12$m4Gfy6zbibWuWrLix/JgXOFJT4yI1huhxEuOA/Aj6xemKiv3P.gFO', 'admin', '2026-01-08 05:42:20', '2026-01-10 01:20:29', 'approved'),
(119, '737298976756756456', 'Budi Santoso', 'operator2@gmail.com', NULL, NULL, '$2y$12$6CWejLC.5ALvC5o6YyXfoutdjeWyz5wTTqi21PgD/rzINjb8a8MmG', 'operator', '2026-07-08 08:50:50', '2026-07-08 08:50:56', 'approved'),
(121, '787329835178546153', 'Sitti Aisyah', 'sittiaisyah@gmail.com', 'Institut Teknologi Bachruddin Jusuf Habibie', 'ith', '$2y$12$EdCVMAwOAB65PCDCIeOpwOxN2VjbJw9sCJbE86QwjtqHwEDuDuqbG', 'dosen', '2026-07-08 08:58:18', '2026-07-08 09:02:48', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `visi_misi`
--

CREATE TABLE `visi_misi` (
  `id` bigint UNSIGNED NOT NULL,
  `visi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visi_misi`
--

INSERT INTO `visi_misi` (`id`, `visi`, `misi`, `created_at`, `updated_at`) VALUES
(1, 'Menjadi unit layanan teknologi informasi dan komunikasi yang unggul, inovatif, dan terpercaya dalam mendukung transformasi digital di lingkungan perguruan tinggi.', '\"[\\\"Menyediakan layanan teknologi informasi yang cepat, aman, dan handal.\\\",\\\"Mengembangkan dan mengelola sistem informasi akademik yang terintegrasi.\\\",\\\"Memberikan dukungan teknis dan layanan helpdesk kepada civitas akademika.\\\",\\\"Mendorong pemanfaatan teknologi informasi dalam kegiatan pendidikan, penelitian, dan pengabdian kepada masyarakat.\\\"]\"', '2026-01-10 02:10:13', '2026-04-25 04:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `zoom_requests`
--

CREATE TABLE `zoom_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','approved','rejected','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `link_zoom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoom_requests`
--

INSERT INTO `zoom_requests` (`id`, `user_id`, `nama`, `nip`, `unit`, `jenis_kegiatan`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `email`, `keterangan`, `status`, `link_zoom`, `created_at`, `updated_at`) VALUES
(51, 121, 'Sitti Aisyah', '787329835178546153', 'Ilmu Komputer', 'Webinar', '2026-07-10', '16:55:00', '19:53:00', 'sittiaisyah@gmail.com', NULL, 'pending', NULL, '2026-07-09 01:53:15', '2026-07-09 01:53:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_operator`
--
ALTER TABLE `aktivitas_operator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akun_email_pribadi`
--
ALTER TABLE `akun_email_pribadi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akun_email_pribadi_permohonan_id_foreign` (`permohonan_id`);

--
-- Indexes for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggotas_divisi_id_foreign` (`divisi_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `divisis`
--
ALTER TABLE `divisis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails_lembaga`
--
ALTER TABLE `emails_lembaga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_requests`
--
ALTER TABLE `email_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas_gambar`
--
ALTER TABLE `fasilitas_gambar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fasilitas_gambar_fasilitas_id_foreign` (`fasilitas_id`);

--
-- Indexes for table `hosting_access`
--
ALTER TABLE `hosting_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hosting_access_sub_domain_id_foreign` (`sub_domain_id`);

--
-- Indexes for table `hotspot_credentials`
--
ALTER TABLE `hotspot_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotspot_credentials_hotspot_user_id_foreign` (`hotspot_user_id`);

--
-- Indexes for table `hotspot_users`
--
ALTER TABLE `hotspot_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotspot_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `laporans_ticket_no_unique` (`ticket_no`),
  ADD KEY `laporans_user_id_foreign` (`user_id`);

--
-- Indexes for table `layanans`
--
ALTER TABLE `layanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_plans`
--
ALTER TABLE `master_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumumans`
--
ALTER TABLE `pengumumans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_email_lembaga`
--
ALTER TABLE `permohonan_email_lembaga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan_email_pribadi`
--
ALTER TABLE `permohonan_email_pribadi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permohonan_email_pribadi_user_id_foreign` (`user_id`);

--
-- Indexes for table `sejarah`
--
ALTER TABLE `sejarah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sejarah_gambar`
--
ALTER TABLE `sejarah_gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_requests_user` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_domains`
--
ALTER TABLE `sub_domains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_domains_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `visi_misi`
--
ALTER TABLE `visi_misi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zoom_requests`
--
ALTER TABLE `zoom_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zoom_requests_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_operator`
--
ALTER TABLE `aktivitas_operator`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akun_email_pribadi`
--
ALTER TABLE `akun_email_pribadi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `anggotas`
--
ALTER TABLE `anggotas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `divisis`
--
ALTER TABLE `divisis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `emails_lembaga`
--
ALTER TABLE `emails_lembaga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `email_requests`
--
ALTER TABLE `email_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `fasilitas_gambar`
--
ALTER TABLE `fasilitas_gambar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `hosting_access`
--
ALTER TABLE `hosting_access`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `hotspot_credentials`
--
ALTER TABLE `hotspot_credentials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `hotspot_users`
--
ALTER TABLE `hotspot_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `layanans`
--
ALTER TABLE `layanans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `master_plans`
--
ALTER TABLE `master_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `pengumumans`
--
ALTER TABLE `pengumumans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permohonan_email_lembaga`
--
ALTER TABLE `permohonan_email_lembaga`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `permohonan_email_pribadi`
--
ALTER TABLE `permohonan_email_pribadi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `sejarah`
--
ALTER TABLE `sejarah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sejarah_gambar`
--
ALTER TABLE `sejarah_gambar`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_domains`
--
ALTER TABLE `sub_domains`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `visi_misi`
--
ALTER TABLE `visi_misi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zoom_requests`
--
ALTER TABLE `zoom_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun_email_pribadi`
--
ALTER TABLE `akun_email_pribadi`
  ADD CONSTRAINT `akun_email_pribadi_permohonan_id_foreign` FOREIGN KEY (`permohonan_id`) REFERENCES `permohonan_email_pribadi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD CONSTRAINT `anggotas_divisi_id_foreign` FOREIGN KEY (`divisi_id`) REFERENCES `divisis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fasilitas_gambar`
--
ALTER TABLE `fasilitas_gambar`
  ADD CONSTRAINT `fasilitas_gambar_fasilitas_id_foreign` FOREIGN KEY (`fasilitas_id`) REFERENCES `fasilitas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hosting_access`
--
ALTER TABLE `hosting_access`
  ADD CONSTRAINT `hosting_access_sub_domain_id_foreign` FOREIGN KEY (`sub_domain_id`) REFERENCES `sub_domains` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotspot_credentials`
--
ALTER TABLE `hotspot_credentials`
  ADD CONSTRAINT `hotspot_credentials_hotspot_user_id_foreign` FOREIGN KEY (`hotspot_user_id`) REFERENCES `hotspot_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotspot_users`
--
ALTER TABLE `hotspot_users`
  ADD CONSTRAINT `hotspot_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporans`
--
ALTER TABLE `laporans`
  ADD CONSTRAINT `laporans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permohonan_email_pribadi`
--
ALTER TABLE `permohonan_email_pribadi`
  ADD CONSTRAINT `permohonan_email_pribadi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD CONSTRAINT `fk_service_requests_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_domains`
--
ALTER TABLE `sub_domains`
  ADD CONSTRAINT `sub_domains_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `zoom_requests`
--
ALTER TABLE `zoom_requests`
  ADD CONSTRAINT `zoom_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
