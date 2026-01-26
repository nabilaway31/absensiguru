-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 19, 2026 at 04:20 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint UNSIGNED NOT NULL,
  `guru_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Telat','Izin','Sakit','Alfa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_datang` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approval_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `guru_id`, `tanggal`, `status`, `jam_datang`, `jam_pulang`, `keterangan`, `bukti`, `approval_status`, `approval_note`, `created_at`, `updated_at`) VALUES
(3, 1, '2026-01-19', 'Telat', '10:06:54', '10:07:00', NULL, NULL, 'pending', NULL, '2026-01-19 03:06:54', '2026-01-19 03:07:17'),
(4, 2, '2026-01-05', 'Hadir', '06:20:00', '15:14:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:39:44', '2026-01-19 06:39:44'),
(5, 8, '2026-01-05', 'Hadir', '06:08:00', '15:50:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:40:46', '2026-01-19 06:40:46'),
(6, 10, '2026-01-05', 'Hadir', '06:20:00', '15:24:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:42:29', '2026-01-19 06:42:29'),
(7, 4, '2026-01-05', 'Hadir', '06:30:00', '15:38:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:44:10', '2026-01-19 06:44:10'),
(8, 7, '2026-01-05', 'Hadir', '06:39:00', '03:30:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:45:23', '2026-01-19 06:45:23'),
(9, 3, '2026-01-05', 'Hadir', '06:06:00', '15:50:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:46:17', '2026-01-19 06:46:17'),
(10, 6, '2026-01-05', 'Hadir', '06:21:00', '15:10:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:47:12', '2026-01-19 06:47:12'),
(11, 5, '2026-01-05', 'Hadir', '06:06:00', '15:18:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:49:34', '2026-01-19 06:49:34'),
(12, 1, '2026-01-06', 'Hadir', '06:20:00', '15:50:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:50:27', '2026-01-19 06:50:27'),
(13, 2, '2026-01-06', 'Hadir', '06:20:00', '15:30:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:51:08', '2026-01-19 06:51:08'),
(14, 3, '2026-01-06', 'Hadir', '06:20:00', '15:30:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:51:58', '2026-01-19 06:51:58'),
(15, 4, '2026-01-06', 'Hadir', '06:20:00', '15:30:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:52:55', '2026-01-19 06:52:55'),
(16, 5, '2026-01-06', 'Hadir', '06:20:00', '15:30:00', NULL, NULL, 'pending', NULL, '2026-01-19 06:53:54', '2026-01-19 06:53:54'),
(18, 1, '2026-01-05', 'Hadir', '06:11:00', '15:20:00', NULL, NULL, 'pending', NULL, '2026-01-19 14:43:06', '2026-01-19 14:43:06'),
(19, 10, '2026-01-06', 'Hadir', '06:30:00', '15:41:00', NULL, NULL, 'pending', NULL, '2026-01-19 14:44:10', '2026-01-19 14:44:10'),
(20, 6, '2025-12-16', 'Hadir', '06:34:00', '15:12:00', NULL, NULL, 'pending', NULL, '2026-01-19 14:45:43', '2026-01-19 14:45:43'),
(21, 2, '2025-12-16', 'Hadir', '06:21:00', '15:50:00', NULL, NULL, 'pending', NULL, '2026-01-19 14:46:42', '2026-01-19 14:46:42'),
(22, 3, '2025-12-16', 'Hadir', '06:24:00', '15:47:00', NULL, NULL, 'pending', NULL, '2026-01-19 14:47:36', '2026-01-19 14:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `user_id`, `nip`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 3, '1987654321', 'Guru Satu', 'L', 'Mojokerto', '08123456789', '2026-01-18 18:59:24', '2026-01-18 18:59:24'),
(2, 2, '0078965784', 'Danang Teguh Santoso', 'Laki-laki', 'Mojokerto', '0897658970900', '2026-01-19 02:25:34', '2026-01-19 02:25:34'),
(3, 2, '00978546776', 'Indah Chodijah', 'Perempuan', 'Jombang', '089765897453', '2026-01-19 06:30:11', '2026-01-19 06:32:25'),
(4, 2, '119875648930', 'Leni Dewi Kristiana', 'Perempuan', 'Surabaya', '089546735423', '2026-01-19 06:30:58', '2026-01-19 06:30:58'),
(5, 2, '1890846785908', 'Indah Tri Utami', 'Perempuan', 'Magersari', '085432719745', '2026-01-19 06:32:00', '2026-01-19 06:32:00'),
(6, 2, '1987563098', 'Sri Wahyuni', 'Perempuan', 'Jl. Raya Jabon No. 32', '089567498723', '2026-01-19 06:33:21', '2026-01-19 06:33:21'),
(7, 2, '1278564038', 'Sugianto', 'Laki-laki', 'Gedeg', '089756834456', '2026-01-19 06:34:43', '2026-01-19 06:34:43'),
(8, 2, '0089456387', 'Tedjo', 'Laki-laki', 'Balongkrai', '082345657825', '2026-01-19 06:35:34', '2026-01-19 06:35:34'),
(9, 2, '1198756093', 'Sri Mulyati', 'Perempuan', 'Gedeg', '081764556300', '2026-01-19 06:36:38', '2026-01-19 06:36:38'),
(10, 2, '1195647008', 'Supriati', 'Perempuan', 'Magersari', '081233760087', '2026-01-19 06:37:29', '2026-01-19 06:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_04_130822_create_gurus_table', 1),
(5, '2026_01_05_014417_create_absensis_table', 1),
(6, '2026_01_12_042541_add_user_id_to_gurus_table', 1);

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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RvS2qgalDmOXTRxOXBSKxfCuarkJJyeSrBfiBwfL', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoianZISTdxWDdTOFNTU21mNlZWOWQ4RFBVRzNQU2FhTnhRaWZodHhLQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sYXBvcmFuL2NldGFrP2Zyb209MjAyNS0xMi0xNiZ0bz0yMDI2LTAxLTE5IjtzOjU6InJvdXRlIjtzOjEzOiJsYXBvcmFuLmNldGFrIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1768834110);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','guru') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guru',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-01-18 18:59:23', '$2y$12$cQT4kxcySdVIkY76tS9j9eZLB7rWll09aZKLbU3IotdJidq.pNVbm', 'guru', 'DoDT2JKAjr', '2026-01-18 18:59:23', '2026-01-18 18:59:23'),
(2, 'nabila', 'nabila@gmail.com', NULL, '$2y$12$Y7fJX6n4wav45KNk..bU1u4BOOuuOMXGbruGdb4yBoS72WXtXbN9y', 'admin', NULL, '2026-01-18 18:59:24', '2026-01-18 18:59:24'),
(3, 'Guru Satu', 'guru@absensi.test', NULL, '$2y$12$D81xaWwstJjRyptq0MY61.3YBbImChM/VE6hDLDxcQmfMdB9xTtwa', 'guru', NULL, '2026-01-18 18:59:24', '2026-01-18 18:59:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensis_guru_id_tanggal_unique` (`guru_id`,`tanggal`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gurus_user_id_foreign` (`user_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
