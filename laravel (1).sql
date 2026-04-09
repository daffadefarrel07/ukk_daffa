-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 09, 2026 at 09:02 AM
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
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aspirasis`
--

CREATE TABLE `aspirasis` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Menunggu','Proses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `input_pelaporan_id` bigint UNSIGNED DEFAULT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aspirasis`
--

INSERT INTO `aspirasis` (`id`, `created_at`, `updated_at`, `status`, `feedback`, `input_pelaporan_id`, `kategori_id`) VALUES
(1, '2026-04-09 01:14:20', '2026-04-09 01:14:20', 'Menunggu', NULL, 1, 2),
(2, '2026-04-09 01:15:25', '2026-04-09 01:15:25', 'Menunggu', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasis`
--

CREATE TABLE `input_aspirasis` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL,
  `siswa_id` bigint UNSIGNED DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `input_aspirasis`
--

INSERT INTO `input_aspirasis` (`id`, `created_at`, `updated_at`, `kategori_id`, `siswa_id`, `lokasi`, `ket`, `foto`) VALUES
(1, '2026-04-09 01:14:20', '2026-04-09 01:14:20', 2, 3, 'LAPANGAN', 'BANYAK LUMPURR', 'fotos/d7dd840c-5193-4589-a56d-341f4f60093d.png'),
(2, '2026-04-09 01:15:24', '2026-04-09 01:15:24', 1, 3, 'C2', 'BANYAK MEJA DAN KURSI YANG PATAH', 'fotos/e607ed78-d03a-48c9-b586-098712c0cc0e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ket_kategori` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `created_at`, `updated_at`, `ket_kategori`) VALUES
(1, '2026-04-09 01:03:06', '2026-04-09 01:03:06', 'Sarana Kelas'),
(2, '2026-04-09 01:03:32', '2026-04-09 01:03:32', 'lingkungan');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_07_040329_create_admin_table', 1),
(6, '2026_04_07_040536_create_siswas_table', 1),
(7, '2026_04_07_040551_create_kategoris_table', 1),
(8, '2026_04_07_040630_create_input_aspirasis_table', 1),
(9, '2026_04_07_040648_create_aspirasis_table', 1),
(10, '2026_04_07_050000_add_user_id_to_siswas_table', 1),
(11, '2026_04_07_090000_add_ket_kategori_to_kategoris_table', 1),
(12, '2026_04_07_100000_add_is_admin_to_users_table', 1),
(13, '2026_04_07_100500_add_kategori_id_to_input_aspirasis_table', 1),
(14, '2026_04_07_101000_add_siswa_id_to_input_aspirasis_table', 1),
(15, '2026_04_09_120000_add_status_to_aspirasis_table', 1),
(16, '2026_04_09_121500_modify_feedback_to_text_in_aspirasis', 1),
(17, '2026_04_09_123000_add_nis_kelas_to_siswas_table', 1),
(18, '2026_04_09_124500_add_lokasi_ket_to_input_aspirasis_table', 1),
(19, '2026_04_09_130000_add_input_relation_to_aspirasis_table', 1),
(20, '2026_04_09_131500_add_kategori_id_to_aspirasis_table', 1),
(21, '2024_10_28_100000_add_foto_to_input_aspirasis_table', 2),
(22, '2024_10_28_200000_add_nis_to_users_table', 3),
(23, '2024_10_28_210000_make_users_email_nullable', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswas`
--

CREATE TABLE `siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswas`
--

INSERT INTO `siswas` (`id`, `nis`, `kelas`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'fagan@gmail.com', '-', '2026-04-08 20:47:13', '2026-04-08 20:47:13', 1),
(2, 'dafffa@gmail.com', '-', '2026-04-09 01:04:48', '2026-04-09 01:04:48', 3),
(3, '1234567899', '-', '2026-04-09 01:14:20', '2026-04-09 01:14:20', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nis`, `email`, `email_verified_at`, `password`, `remember_token`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'fagan', NULL, 'fagan@gmail.com', NULL, '$2y$12$XICseWJ3FJ/dDoDWsDnvY.9bdRK0.RjjCCzEKA7DSFsvb2SnZ7CfG', NULL, 0, '2026-04-08 20:47:10', '2026-04-08 20:47:10'),
(2, 'gilang Pradana', NULL, 'gilangpradana672@gmail.com', NULL, '$2y$12$QCd88QcbbxsrxO3SnpvUeeMFwKr0Ffsnzm5SdkXZgw4GuEsXJHM7u', NULL, 0, '2026-04-09 00:58:18', '2026-04-09 00:58:18'),
(3, 'daffa', NULL, 'dafffa@gmail.com', NULL, '$2y$12$KNjPRAaGqNg.pdf171cgW.X8UpmN5qDKaJELc1Outoiimanjv8RDy', NULL, 0, '2026-04-09 01:04:46', '2026-04-09 01:04:46'),
(7, 'Admin', NULL, 'admin@ukk.local', NULL, '$2y$12$AdyB/c/wkea4rVzgo7KZAupDqrACCTCbVk98zea.lsAKkwaoLEkXS', NULL, 1, '2026-04-09 01:35:34', '2026-04-09 01:35:34'),
(9, 'Admin', 'admin', NULL, NULL, '$2y$12$zAAHpCUXfUJn0/dJbaWnkO4rklO6Y/64dzwnxVm1DAaHs5PYX0dPS', NULL, 1, '2026-04-09 01:48:28', '2026-04-09 01:48:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aspirasis`
--
ALTER TABLE `aspirasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `input_aspirasis`
--
ALTER TABLE `input_aspirasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `input_aspirasis_kategori_id_foreign` (`kategori_id`),
  ADD KEY `input_aspirasis_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswas_nis_unique` (`nis`),
  ADD KEY `siswas_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nis_unique` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aspirasis`
--
ALTER TABLE `aspirasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `input_aspirasis`
--
ALTER TABLE `input_aspirasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswas`
--
ALTER TABLE `siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `input_aspirasis`
--
ALTER TABLE `input_aspirasis`
  ADD CONSTRAINT `input_aspirasis_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `input_aspirasis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswas`
--
ALTER TABLE `siswas`
  ADD CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
