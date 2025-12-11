-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 02:47 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resource_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accreditations`
--

CREATE TABLE `accreditations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rstbl_id` bigint(20) UNSIGNED NOT NULL,
  `field_of_expertise` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_title_rs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `education` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seminar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `award` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accreditation_averages`
--

CREATE TABLE `accreditation_averages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rstbl_id` bigint(20) UNSIGNED NOT NULL,
  `field_of_expertise` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avg_education` decimal(8,2) NOT NULL DEFAULT '0.00',
  `avg_work` decimal(8,2) NOT NULL DEFAULT '0.00',
  `avg_seminar` decimal(8,2) NOT NULL DEFAULT '0.00',
  `avg_experience` decimal(8,2) NOT NULL DEFAULT '0.00',
  `avg_award` decimal(8,2) NOT NULL DEFAULT '0.00',
  `avg_total` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `division`, `created_at`, `updated_at`) VALUES
(1, 'ORD', '2024-10-11 00:38:07', '2024-10-11 00:38:07'),
(2, 'TSD', '2024-10-11 00:39:02', '2025-07-06 23:20:23'),
(3, 'FAS', '2024-10-11 00:40:43', '2024-10-14 00:53:33'),
(4, 'PSTO-Abra', '2024-10-11 00:43:16', '2024-10-14 00:55:13'),
(6, 'PSTO-Benguet', '2024-10-14 00:55:36', '2024-10-14 00:55:36'),
(7, 'PSTO-Kalinga', '2025-02-13 22:29:31', '2025-02-13 22:29:31'),
(8, 'PSTO- Mountain Province', '2025-07-08 18:36:11', '2025-07-08 18:36:11'),
(9, 'PSTO- Apayao', '2025-07-08 18:36:36', '2025-07-08 18:36:36'),
(10, 'PSTO- Ifugao', '2025-07-08 18:37:18', '2025-07-08 18:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `expertis`
--

CREATE TABLE `expertis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `expertis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expertis`
--

INSERT INTO `expertis` (`id`, `rs_id`, `expertis`, `created_at`, `updated_at`) VALUES
(53, 60, 'Psychology/Counseling', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(79, 55, 'Coffee Quality Assessment and Cupping', '2025-10-21 23:52:31', '2025-10-21 23:52:31'),
(80, 55, 'Sustainable Coffee Farming Practices', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(81, 55, 'Postharvest Technology and Processing', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(83, 57, 'Apparel Production', '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(92, 61, 'English - Professional working proficiency', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(93, 61, 'Filipino - Native or bilingual proficiency', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(94, 61, 'Autocad Software', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(97, 40, 'Biology and Research Education', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(106, 62, 'English - professional working proficiency', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(107, 62, 'Filipino - Native or bilingual proficiency', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(108, 62, 'Cebuano - Native or bilingual proficiency', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(115, 41, 'Plan and Framework Formulation', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(116, 41, 'Capacity Development', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(117, 41, 'Leadership', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(118, 42, 'Urban Management and Environmental Management', '2025-10-23 19:07:46', '2025-10-23 19:07:46'),
(121, 63, 'OUTDOOR RECREATION', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(125, 45, 'Investment Programming', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(126, 64, 'N/A', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(127, 66, 'Map Reading', '2025-10-23 22:10:58', '2025-10-23 22:10:58'),
(128, 66, 'Driving', '2025-10-23 22:10:58', '2025-10-23 22:10:58'),
(129, 66, 'Farming', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(132, 67, 'N/A', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(135, 68, 'TRAVELING', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(143, 49, 'Digital Transformation', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(154, 51, 'Food Product Research and Development (R&D)', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(155, 70, 'Traveling', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(156, 70, 'Community Organizing', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(157, 70, 'Training Facilitation', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(158, 70, 'Public Speaking', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(162, 53, 'N/A', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(163, 39, 'N/A', '2025-10-24 00:42:30', '2025-10-24 00:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_24_014223_create_rstbl_table', 1),
(6, '2024_09_24_014232_create_rs_educational_table', 1),
(7, '2024_09_24_014240_create_rs_work_experiences_table', 1),
(8, '2024_09_24_014247_create_office_table', 1),
(9, '2024_09_24_014253_create_rs_training_table', 1),
(10, '2024_09_24_014301_create_rs_experience_trainer_table', 1),
(11, '2024_09_24_014308_create_rs_publications_table', 1),
(12, '2024_09_24_014316_create_rs_references_trainings_table', 1),
(13, '2024_10_11_074008_create_divisions_table', 2),
(14, '2024_10_11_074125_create_positions_table', 2),
(15, '2024_10_11_074138_create_provinces_table', 2),
(16, '2024_10_11_074144_create_units_table', 2),
(17, '2025_02_14_013514_create_trainings_table', 3),
(19, '2025_02_14_023739_create_trainings_table', 4),
(20, '2025_02_18_021032_create_trainings_table', 5),
(21, '2025_02_18_081635_create_trainings_table', 6),
(22, '2025_03_05_031129_create_rs_training_table', 7),
(23, '2025_03_05_034927_create_rs_experience_trainer_table', 8),
(24, '2025_03_05_060543_create_rs_training_table', 9),
(25, '2025_03_05_064944_create_rs_publications_table', 10),
(26, '2025_05_16_053115_create_request_resource_speakers_table', 11),
(27, '2025_05_21_065142_create_accreditations_table', 12),
(28, '2025_05_21_070817_create_accreditations_table', 13),
(29, '2025_06_25_011650_create_expertis_table', 14),
(30, '2025_08_28_013720_create_accreditation_averages_table', 15),
(31, '2025_08_28_031121_create_accreditation_averages_table', 16),
(32, '2025_08_28_054842_create_accreditation_averages_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `office_organization` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipality` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cell_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`id`, `rs_id`, `office_organization`, `position`, `address`, `building_no`, `barangay`, `municipality`, `province`, `zip_code`, `tel_no`, `cell_no`, `fax_no`, `created_at`, `updated_at`) VALUES
(38, 39, 'N/A', 'N/A', NULL, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-19 20:05:43', '2025-10-19 21:59:09'),
(39, 40, 'N/A', 'N/A', NULL, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-19 21:37:53', '2025-10-23 18:14:49'),
(40, 41, 'N/A', 'N/A', NULL, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-19 21:58:10', '2025-10-23 18:46:50'),
(41, 42, 'N/A', 'N/A', NULL, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-19 22:16:24', '2025-10-23 19:07:46'),
(44, 45, 'N/A', 'Economic Development Specialist II', NULL, 'N/A', 'N/A', 'BaguioCity', 'N/A', '2600', 'N/A', '09632453108', '(074) 619 6627', '2025-10-19 22:40:23', '2025-10-23 19:10:47'),
(48, 49, 'Department of Education Division of Abra', 'Teacher III', NULL, 'N/A', 'Zone 3', 'Bangued', 'Abra', '2800', 'N/A', '09177081553', 'N/A', '2025-10-19 23:41:11', '2025-10-23 22:41:13'),
(50, 51, 'N/A', 'N/A', NULL, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '09166390562', 'N/A', '2025-10-20 00:38:41', '2025-10-23 17:25:14'),
(52, 53, 'DOST-ITDI', 'Quality and CPD Manager, and PNS ISO/IEC 17025:2017 Management and Technical (Chemical Testing) Assessor', NULL, 'No.8', 'Pagkakaisa St., Purok 6-B, General Santos Ave., Lower Bicutan', 'Taguig City', 'Metro Manila', '1631', 'N/A', '09171843110', 'N/A', '2025-10-20 18:23:44', '2025-10-23 17:30:46'),
(53, 54, 'Department of Agriculture - PhilMech', 'Science Research Assistant', NULL, 'N/A', 'N/A', 'Muñoz', 'Nueva Ecija', '3119', '(044) 456-0110', 'N/A', 'N/A', '2025-10-20 18:47:13', '2025-10-21 22:38:49'),
(54, 55, 'Casiklan Wheels Farmers Association Inc.', 'Trainer for Coffee Production Level II', NULL, 'N/A', 'N/A', 'Las Nieves', 'Agusan Del Norte', '8610', 'N/A', '0920-325-3200', 'N/A', '2025-10-20 19:02:10', '2025-10-21 23:27:03'),
(55, 56, 'Department of Agriculture - PhilMech', 'Science Research Specialist II', NULL, 'N/A', 'N/A', 'Muñoz', 'Nueva Ecija', '3119', '(044)456-0110', 'N/A', 'N/A', '2025-10-21 17:12:13', '2025-10-22 00:09:19'),
(56, 57, 'Technological University of the Philippines - Manila', 'Program Coordinator/Faculty', NULL, 'N/A', 'Ayala Blvd. Ermita', 'Manila', 'Metro Manila', '1000', '(02) 301 3001 loc 207', 'N/A', 'N/A', '2025-10-21 17:56:25', '2025-10-22 00:48:01'),
(59, 60, 'Saint Louis University', 'Director, Center for Counseling and Wellness', NULL, 'N/A', 'ABCR Barangay', 'Baguio City', 'Benguet', '2600', 'N/A', 'N/A', 'N/A', '2025-10-21 18:58:57', '2025-10-21 19:45:16'),
(60, 61, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(61, 62, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(62, 63, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 19:27:32', '2025-10-23 19:27:32'),
(63, 64, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(64, 65, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(65, 66, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 22:10:58', '2025-10-23 22:10:58'),
(66, 67, 'University of Baguio', 'School Relations Office (SRO)', NULL, 'N/A', 'N/A', 'Baguio City', 'N/A', '2600', 'N/A', 'N/A', 'N/A', '2025-10-23 22:14:25', '2025-10-23 22:25:59'),
(67, 68, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(68, 69, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(69, 70, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-24 00:04:18', '2025-10-24 00:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Project Technical Assistant I', '2024-10-15 18:11:35', '2024-10-15 18:22:43'),
(3, 'Project Technical Assistant II', '2024-10-15 21:46:16', '2024-10-15 21:46:16'),
(4, 'Project Technical Aide V', '2024-10-15 21:46:32', '2024-10-15 21:46:42'),
(5, 'Science Research Specialist II', '2025-10-01 16:31:36', '2025-10-01 16:31:36');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `province`, `created_at`, `updated_at`) VALUES
(1, 'ABRA', '2024-10-15 19:12:10', '2024-10-15 23:51:06'),
(2, 'Mountain Province', '2025-01-12 21:20:52', '2025-01-12 21:20:52'),
(3, 'Benguet', '2025-02-25 18:03:20', '2025-02-25 18:03:20'),
(4, 'Kalinga', '2025-02-25 18:03:34', '2025-02-25 18:03:34'),
(5, 'Ifugao', '2025-02-25 18:03:45', '2025-02-25 18:03:45'),
(6, 'Apayao', '2025-02-25 18:03:54', '2025-02-25 18:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `request_resource_speakers`
--

CREATE TABLE `request_resource_speakers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rstbl_id` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_directory` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `venue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `no_hours` int(11) DEFAULT NULL,
  `no_participants` int(11) DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rstbl`
--

CREATE TABLE `rstbl` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ext_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expertise` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_building_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_barangay` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_municipality` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_province` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_zip_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_tel_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_cell_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_fax_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rstbl`
--

INSERT INTO `rstbl` (`id`, `last_name`, `img`, `given_name`, `middle_name`, `ext_name`, `date_of_birth`, `place_of_birth`, `age`, `gender`, `email`, `expertise`, `building_no`, `home_address`, `home_building_no`, `home_barangay`, `home_municipality`, `home_province`, `home_zip_code`, `home_tel_no`, `home_cell_no`, `home_fax_no`, `created_at`, `created_by`, `updated_at`) VALUES
(39, 'Lopez', 'uploads/images/1760933143_68f5b51753ff8.jpg', 'Jason Rommel', 'Lagasca', NULL, '1976-01-18', 'Laoag City', 48, 'Male', 'jasonrommellopez@gmail.com', NULL, '#63', 'Purok 20, San Carlos Heightsm', '#63', 'Irisan', 'Baguio City', 'Benguet', '2600', '(074) 446-9596', NULL, NULL, '2025-10-19 20:05:43', '12', '2025-10-19 21:59:09'),
(40, 'Dacumos', 'uploads/images/1760938673_68f5cab1274b7.jpg', 'Leo Peter', 'Narciza', 'N/A', '1991-06-14', 'Baguio City', 33, 'Male', 'ldacumos@carc.pshs.edu.ph', NULL, '#13', 'N/A', '#13', 'Palma-urbano', 'Baguio City', 'N/A', '2600', '074 620 3312', NULL, NULL, '2025-10-19 21:37:53', '12', '2025-10-23 18:14:48'),
(41, 'Duagan', 'uploads/images/1760939890_68f5cf7218c95.jpg', 'Gerald', 'Bayo', 'N/A', '1988-07-09', 'Baguio City', 35, 'Male', 'geraldbduagan@gmail.com', NULL, 'N/A', NULL, 'N/A', 'Tiptop, Pacdal', 'Baguio City', 'Benguet', '2600', 'N/A', NULL, NULL, '2025-10-19 21:58:10', '12', '2025-10-23 18:46:50'),
(42, 'Calvelo', 'uploads/images/1760940984_68f5d3b829d76.jpg', 'Janssen Andrew', 'Santalisis', 'N/A', '1996-06-07', 'Manila, Philippines', 27, 'Male', 'jscalvelo@up.edu.ph', NULL, 'B7, L7, Ph2B', 'N/A', 'B7, L7, Ph2B', 'Franc St. Brgy. Banlic', 'Cabuyao', 'Laguna', '4025', 'N/A', NULL, NULL, '2025-10-19 22:16:24', '12', '2025-10-23 19:07:46'),
(45, 'Balaki', 'uploads/images/1760942423_68f5d9577bbe2.jpg', 'Marinette', 'Ramirez', 'N/A', '1981-12-29', 'Baguio City', 42, 'Female', 'mrbalaki@neda.gov.ph', NULL, 'N/A', 'N/A', 'N/A', '585 Magsaysay Avenue', 'Baguio City', 'Benguet', '2600', 'N/A', NULL, NULL, '2025-10-19 22:40:23', '12', '2025-10-23 19:10:47'),
(49, 'Gasmen', 'uploads/images/1760946071_68f5e79716122.jpg', 'Jephunneh', 'Alvarez', 'N/A', '1994-08-31', 'Lagangilang, Abra', 29, 'Male', 'gjephunneh@gmail.com', NULL, 'N/A', 'N/A', 'N/A', 'Angad', 'Bangued', 'Abra', '2800', 'N/A', NULL, NULL, '2025-10-19 23:41:11', '12', '2025-10-23 22:41:13'),
(51, 'Prospero', 'uploads/images/1760949521_68f5f51159e85.jpg', 'Rogelio', 'B', 'N/A', '1957-09-22', 'Tondo, Manila', 67, 'Male', 'Prospero@gmail.com', NULL, 'Lot 8, Block 4, John St., Annex', 'N/A', 'Lot 8, Block 4, John St., Annex', 'Better Living Subdivision', 'Paranaque', 'N/A', '1711', 'N/A', NULL, NULL, '2025-10-20 00:38:41', '12', '2025-10-23 17:18:09'),
(53, 'Dablio', 'uploads/images/1761013424_68f6eeb07bc31.jpg', 'Admer Rey', 'N/A', 'N/A', '1989-10-31', 'Cagayan de Oro City, Misamis Oriental', 34, 'Male', 'admerdablio@yahoo.com', NULL, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', NULL, NULL, '2025-10-20 18:23:44', '12', '2025-10-23 17:30:46'),
(54, 'Espiritu', 'uploads/images/1761014833_68f6f431bda60.jpg', 'Ivy', 'Villanueva', 'N/A', '1993-07-29', 'San Jose City', 32, 'Female', 'ivyespiritu.philmech@gmail.com', NULL, 'N/A', 'N/A', 'N/A', 'Damian', 'Muñoz', 'Nueva Ecija', '3114', '(044)940-5112', NULL, NULL, '2025-10-20 18:47:13', '12', '2025-10-21 22:38:49'),
(55, 'Buntag', 'uploads/images/1761015730_68f6f7b2826a6.jpg', 'Anthony', 'Malapad', 'N/A', '1996-10-18', 'Casiklan Las Nieves Agusan Del Norte', 28, 'Male', 'anthonybuntag123@gmail.com', NULL, 'N/A', 'N/A', 'N/A', 'Purok 8', 'Las Nieves', 'Agusan Del Norte', '8610', 'N/A', NULL, NULL, '2025-10-20 19:02:10', '12', '2025-10-21 23:27:03'),
(56, 'Briones', 'uploads/images/1761095533_68f82f6d85339.jpg', 'Danilo', 'Acosta', 'N/A', '1992-07-29', 'Bical, Muñoz, Nuva Ecija', 32, 'Male', 'dabriones0729@gmail.com', NULL, 'N/A', 'N/A', 'N/A', 'Sto. Tomas', 'San Jose City', 'Nueva Ecija', '3121', 'N/A', NULL, NULL, '2025-10-21 17:12:13', '12', '2025-10-22 00:09:19'),
(57, 'Gebe', 'uploads/images/1761098185_68f839c91998d.jpg', 'Annalyn', 'Nolasco', 'N/A', '1974-12-20', 'Manila', 50, 'Female', 'annalyn_gebe@tup.edu.ph', NULL, 'N/A', '.Blk 30 Lot 31 Holiday Homes Phase 3 Subd.', 'N/A', 'Brgy. Biclatan', 'Gen. Trias City', 'Cavite', '4107', '(02) 301 3001 loc 207', NULL, NULL, '2025-10-21 17:56:25', '12', '2025-10-22 00:48:01'),
(60, 'Refuerzo', 'uploads/images/1761101937_68f848714f58c.png', 'Marie Ellami', 'Solis', 'N/A', '1972-09-30', 'Dagupan, Pangasinan', 52, 'Female', 'mesrefuerzo@slu.edu.ph', NULL, 'N/A', 'New Site Bakakeng', 'N/A', 'SLU-SVP Housing Village', 'Baguio City', 'Benguet', '2600', 'N/A', NULL, NULL, '2025-10-21 18:58:57', '12', '2025-10-21 19:45:16'),
(61, 'Sotoridona', 'uploads/images/1761273041_68fae4d1ab31f.jpg', 'Ralph', 'Claveria', 'N/A', '1987-07-14', 'PASIG CITY', 38, 'Male', 'arcs.planning@gmail.com', NULL, NULL, 'N/A', '34', 'arcs.planning@gmail.com', 'PASIG', 'METRO MANILA', '1600', 'N/A', '0908-3811808', NULL, '2025-10-23 18:30:41', '12', '2025-10-23 18:30:41'),
(62, 'PATARLAS', 'uploads/images/1761274230_68fae976c1770.jpg', 'LEE', 'MAGHINAY', 'N/A', '1979-12-20', 'ENRIQUE VILLANUEVA, SIQUIJOR', 46, 'Female', 'lotpatarlas@gmail.com', NULL, NULL, 'N/A', '7351 San Benissa Garden Villas', 'KALIGAYAHAN', 'QUEZON CITY', 'METRO MANILA', '1124', 'N/A', '+63 917 512 6167', NULL, '2025-10-23 18:50:30', '12', '2025-10-23 18:50:30'),
(63, 'MEJICO', 'uploads/images/1761276452_68faf224cff23.jpg', 'MUSSAENDA SIRIKIT', 'FERNANDEZ', 'N/A', '1995-05-23', 'MANILA', 30, 'Female', 'msfmejico@gmail.com', NULL, NULL, 'N/A', '4030', 'MAAHAS', 'LOS BANOS', 'LOS BANOS', '4030', 'N/A', '0906 313 3169', NULL, '2025-10-23 19:27:32', '12', '2025-10-23 19:27:32'),
(64, 'Geluz', 'uploads/images/1761278945_68fafbe166a86.png', 'Francine', 'Serrano', 'N/A', '2000-10-04', 'Cavite City', 25, 'Female', 'fsgeluz@up.edu.ph', NULL, NULL, 'B8 L2, Talisay St., Narra Homes, Pag-asa 1, Imus City, Cavite', 'B8 L2', 'Pag-asa 1', 'Imus City', 'Cavite', '4103', '046 471 1726', '09338531847', NULL, '2025-10-23 20:09:05', '12', '2025-10-23 20:09:05'),
(65, 'MAYO', 'uploads/images/1761283262_68fb0cbeba9a9.jpg', 'GERARD PATRICK', 'JAO', 'N/A', '1989-01-09', 'TAPIAN, STA. CRUZ, MARINDUQUE', 36, 'Male', 'gerardpatrickmayo@gmail.com', NULL, NULL, 'N/A', '194', 'LIPA', 'MANILA', 'METRO MANILA', '4902', 'N/A', '09337200489', NULL, '2025-10-23 21:21:02', '12', '2025-10-23 21:21:02'),
(66, 'LIWAG', 'uploads/images/1761286258_68fb187291728.jpg', 'CARMELITA ROSARIO EVA', 'UNDEVILLA', 'N/A', '1959-10-09', 'Cavinti, Laguna', 66, 'Female', 'culiwag@up.edu.ph', NULL, NULL, NULL, 'AA2-102', 'U.P. Campus', 'Diliman, Quezon City', 'Metro Manila', '1101', '85595241', '0917 5855388', NULL, '2025-10-23 22:10:58', '12', '2025-10-23 22:10:58'),
(67, 'Cachero', 'uploads/images/1761286465_68fb1941472ac.png', 'Sherida Mae', 'Mapalo', 'N/A', '1986-05-07', 'Baguio City', 39, 'Female', 'smcachero@neda.gov.ph', NULL, '32', '32 Zarate Street, Middle Quezon Hill, Baguio City', '32', 'N/A', 'Baguio City', 'N/A', '2600', '(074)443-7354', NULL, NULL, '2025-10-23 22:14:25', '12', '2025-10-23 22:25:59'),
(68, 'GRAVADOR', 'uploads/images/1761288445_68fb20fd4abfe.jpg', 'CLARIZZE JOY', 'ELEFANTE', 'N/A', '1996-05-06', 'PASIG CITY', 29, 'Female', 'CLARIZZEGRAVADOR@GMAIL.COM', NULL, NULL, 'N/A', 'BLOCK 2 LOT 39', 'SANTA CRUZ', 'ANTIPOLO CITY', 'RIZAL', '1870', 'N/A', '09173059755', NULL, '2025-10-23 22:47:25', '12', '2025-10-23 22:47:25'),
(69, 'Antonio', 'uploads/images/1761291279_68fb2c0f695d4.jpg', 'Marjian', 'Alzate', 'N/A', '1993-02-08', 'Pasig City', 32, 'Female', 'enp.antonio@gmail.com', NULL, NULL, 'N/A', 'Lot 11, Block 6', 'San Juan', 'Cainta', 'Rizal', '1900', '(02) 8656-0127', '+63-917-550-1336', NULL, '2025-10-23 23:34:39', '12', '2025-10-23 23:34:39'),
(70, 'MALWAGAY', 'uploads/images/1761293057_68fb3301f0436.jpg', 'JONES', 'GAL', 'N/A', '1978-05-09', 'Poblacion, Bontoc, Mountain Province', 47, 'Male', 'JonesGalMalwagay@dti.gov.ph', NULL, NULL, 'N/A', 'N/A', 'Poblacion', 'Bontoc', 'Mountain Province', '2616', 'N/A', '09105725128', NULL, '2025-10-24 00:04:17', '12', '2025-10-24 00:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `rs_educational`
--

CREATE TABLE `rs_educational` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_graduated` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `awards` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rs_educational`
--

INSERT INTO `rs_educational` (`id`, `rs_id`, `level`, `school`, `from_year`, `to_year`, `year_graduated`, `awards`, `created_at`, `updated_at`) VALUES
(378, 60, 'Elementary', 'Saint Louis School Center', 'N/A', 'N/A', '1985', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(379, 60, 'Secondary', 'Saint Louis Girls\' High School', 'N/A', 'N/A', '1989', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(380, 60, 'Under-graduate', 'Saint Louis University', 'N/A', 'N/A', '1993', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(381, 60, 'MS', 'Saint Louis University, MS Psychology', 'N/A', 'N/A', '2001', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(382, 60, 'MS', 'Benguet State University, MAEd in Guidance & Counseling', 'N/A', 'N/A', '2010', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(383, 60, 'Doctorate', 'Philippine Normal University', 'N/A', 'N/A', 'Ongoing', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(412, 54, 'Elementary', 'JDS Montessori School DepEd CLSU Elementary (Lab). School', '1996', '2003', '2003', 'N/A', '2025-10-21 22:57:12', '2025-10-21 22:57:12'),
(413, 54, 'Secondary', 'Central Luzon State University Science School', '2005', '2009', '2009', 'N/A', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(414, 54, 'Under-graduate', 'Central Luzon State University', '2009', '2014', '2014', 'Collage Scholar', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(415, 54, 'Under-graduate', 'Central Luzon State University', '2014', '2015', '2015', '3 Semester', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(416, 54, 'MS', 'Nueva Ecija University of Science and Technology', '2019', '2022', '2022', 'N/A', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(441, 55, 'Elementary', 'Casiklan Elementary School', '2003', '2009', '2009', 'N/A', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(442, 55, 'Secondary', 'Casiklan National High School', '2009', '2013', '2013', 'N/A', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(443, 55, 'Under-graduate', 'Caraga State University', '2013', '2018', '2018', 'CHED-TD 02', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(476, 56, 'Elementary', 'Bical Elementary School', '1979', '1985', '1985', 'Valedictorian', '2025-10-22 00:42:27', '2025-10-22 00:42:27'),
(477, 56, 'Secondary', 'Muñoz National High School', '1985', '1989', '1989', 'N/A', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(478, 56, 'Under-graduate', 'Central Luzon State University', '1989', '1994', '1994', 'N/A', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(479, 56, 'MS', 'Central Luzon State University', '2007', '2012', '2012', 'DOST PCAARRD', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(481, 57, 'Under-graduate', 'Technological University of the Philippines', '1996', '1999', '1999', 'N/A', '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(517, 61, 'ELEMENTARY', 'STA. ROSA CATHOLIC SCHOOL', '1994', '2000', '2000', 'FIRST HONORABLE MENTION', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(518, 61, 'SECONDARY', 'STA. ROSA CATHOLIC SCHOOL', '2000', '2004', '2004', 'SALUTATORIAN', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(519, 61, 'COLLEGE', 'UNIVERSITY OF SANTO TOMAS', '2004', '2009', '2009', 'CUM LAUDE', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(520, 61, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES - DILIMAN SCHOOL OF URBAN AND REGIONAL PLANNING', '2017', '2025', 'ONGOING', 'N/A', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(533, 40, 'Elementary', 'Baguio Central School', '1997', '2003', '2003', 'N/A', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(534, 40, 'Secondary', 'Pines City National High School - Main', '2003', '2007', '2007', '3rd Honorable Mention', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(535, 40, 'Under-graduate', 'Saint Louis University', '2007', '2012', '2012', 'Cum Laude', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(536, 40, 'MS', 'University of the Cordilleras', '2013', '2015', '2015', 'Magna Cum Laude', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(537, 40, 'Doctorate', 'Saint Louis University', '2016', '2025', '(Expected graduation in January 2025)', 'N/A', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(538, 40, 'Post-Doctorate', 'Okayama University (Japan)', '2019', '2021', '2021', 'N/A', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(553, 62, 'ELEMENTARY', 'LIBO ELEMENTARY SCHOOL', '1986', '1992', '1992', '4th Honor', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(554, 62, 'SECONDARY', 'SIQUIJOR STATE COLLEGE', '1992', '1996', '1996', 'N/A', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(555, 62, 'COLLEGE', 'ST. PAUL UNIVERSITY', '1996', '2000', '2000', 'N/A', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(556, 62, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES', '2014', '2019', '2019', 'Dean\'s Medallion', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(565, 41, 'Elementary', 'Dona Aurora H. Bueno Elementary School, Camp 8, Baguio City', '1995', '2001', '2001', 'N/A', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(566, 41, 'Secondary', 'Baguio City Natioonal Highschool, San Vicente, Baguio City', '2001', '2005', '2005', 'N/A', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(567, 41, 'Under-graduate', 'University of Baguio', '2005', '2009', '2009', 'Cum Laude, Leadership Award', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(568, 41, 'MS', 'University of the Cordilleras', '2018', '2020', '2025', 'Orange Knowledge Program', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(569, 42, 'Elementary', 'Infant Jesus Montessori Center', '2000', '2009', '2009', 'Salutatorian', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(570, 42, 'Secondary', 'Don Bosco College', '2009', '2013', '2013', 'Academic Distinction', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(571, 42, 'under-graduate', 'University of the Philippines Los Baños', '2013', '2017', '2017', 'N/A', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(572, 42, 'MS', 'Erasmus Universitiet Rotterdam', '2019', '2020', '2020', 'N/A', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(581, 63, 'ELEMENTARY', NULL, '2001', '2007', '2007', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(582, 63, 'SECONDARY', 'MAQUILING SCHOOL INCORPORATED', '2007', '2011', '2011', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(583, 63, 'COLLEGE', 'CHRISTIAN SCHOOL INTERNATIONAL', '2011', '2016', '2016', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(584, 63, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES LOS BANOS', '2018', '2020', '2020', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(585, 63, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES DILIMAN', '2022', '2025', 'N/A', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(586, 63, 'GRADUATE STUDIES', 'TECHNISCHE UNIVERSITÄT DORTMUND, GERMANY', '2022', '2023', '2024', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(587, 63, 'GRADUATE STUDIES', 'UNIVERSIDADE FEDERAL DO ABC, BRAZIL', '2023', '2024', '2024', 'DAAD', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(600, 45, 'Elementary', 'Pines City Educational Center (now Pines City Colleges)', '1987', '1994', '1994', 'Salutatorian', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(601, 45, 'Secondary', 'San Jose High School', '1994', '1998', '1998', '2nd Honourable Mention', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(602, 45, 'Under-graduate', 'Saint Louis University', '1998', '2002', '2002', 'SLU-SSP', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(603, 45, 'MS', 'University of the Philippines Baguio', '2013', '2018', '2019', 'N/A', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(604, 64, 'Elementary', 'Benedictine Institute of Learning', '2008', '2013', '2013', 'N/A', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(605, 64, 'Secondary', 'St. Scholastica\'s College Manila', '2013', '2018', '2018', '2nd Honors', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(606, 64, 'Under-graduate', 'University of the Philippines Los Banos', '2018', '2023', '2023', 'Magna Cum Laude', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(607, 65, 'ELEMENTARY', 'MARCOPPER ELEMENTARY SCHOOL', '1992', '1998', '1998', 'N/A', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(608, 65, 'SECONDARY', 'MARCOPPER HIGH SCHOOL', '1998', '2002', '2002', 'SALUTATORIAN', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(609, 65, 'COLLEGE', 'DE LA SALLE UNIVERSITY', '2002', '2007', '2007', 'N/A', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(610, 65, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES - DILIMAN', '2011', '2019', '2019', 'N/A', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(611, 66, 'ELEMENTARY', 'Cavinti Central', '1967', '1972', '1972', 'Outstanding', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(612, 66, 'SECONDARY', 'University of the Philippines', '1972', '1976', '1976', 'N/A', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(613, 66, 'COLLEGE', 'University of the Philippines - Diliman', '1976', '1980', '1980', 'UP Vanguard Scholar', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(614, 66, 'GRADUATE STUDIES', 'University of the Philippines - Diliman', '1981', '1986', '1986', 'N/A', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(615, 66, 'GRADUATE STUDIES', 'University of Otago - New Zealand', '1985', '1988', '1988', 'Colombo Scholarship', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(616, 66, 'GRADUATE STUDIES', 'Technische Universitaat Dortmund - Germany', '2010', '2024', '2025', 'N/A', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(627, 67, 'Elementary', 'Saint Louis School Center', '1992', '1999', '1999', 'Consistent Honor Student', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(628, 67, 'Secondary', 'University of Baguio Science High School', '1999', '2003', '2003', '1st Honorable Mention', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(629, 67, 'Vocational', 'Center for Technical Excellence Integrated School, Inc.', '2007', '2007', 'N/A', 'N/A', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(630, 67, 'Under-graduate', 'University of the Philippines Baguio', '2003', '2008', '2008', 'None', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(631, 67, 'MS', 'Development Academy of the Philippines', '2021', '2022', 'N/A', 'None', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(640, 68, 'ELEMENTARY', 'ST. CLARE MONTESSORI SCHOOL', '2003', '2009', '2009', 'SALUTATORIAN', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(641, 68, 'SECONDARY', 'ST. CLARE MONTESSORI SCHOOL', '2009', '2013', '2013', 'VALEDICTORIAN', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(642, 68, 'COLLEGE', 'UNIVERSITY OF THE PHILIPPINES DILIMAN', '2013', '2017', '2017', 'GAWAD TAMBULI', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(643, 68, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES DILIMAN', '2017', '2018', '2018', 'DEAN\'S MEDALLION', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(644, 68, 'GRADUATE STUDIES', 'UNIVERSITY OF THE PHILIPPINES DILIMAN', '2018', '2025', 'N/A', 'N/A', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(673, 49, 'Elementary', 'Tagodtod National High School', '2000', '2006', '2006', 'N/A', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(674, 49, 'Secondary', 'Tagodtod National High School', '2006', '2010', '2010', 'N/A', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(675, 49, 'Undergraduate', 'University of Northern Philippines', '2010', '2014', '2014', 'Cum Laude', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(676, 49, 'MS', 'University of Northern Philippines', '2018', 'PRESENT', 'PRESENT', 'N/A', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(683, 69, 'ELEMENTARY', 'Colegio Sto. Domingo', '1999', '2005', '2005', 'N/A', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(684, 69, 'SECONDARY', 'San Beda College-Rizal', '2005', '2009', '2009', 'N/A', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(685, 69, 'COLLEGE', 'San Beda College-Manila', '2009', '2013', '2013', 'N/A', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(686, 69, 'GRADUATE STUDIES', 'University of the Philippines', '2013', '2025', '2025', 'N/A', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(701, 51, 'Under-graduate', 'Featin University Sta Cruz, Manila', '1973', '1980', '1980', 'N/A', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(702, 51, 'MS', 'University of New South Wales, Kenshington, NSW, Australia', '1990', '1993', '1993', 'N/A', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(703, 70, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(713, 53, 'Secondary', 'Liceo de Cagayan University', '2002', '2006', '2006', 'Class Valedictorian and with recognitions', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(714, 53, 'Under-graduate', 'Xavier University - Ateneo de Cagayan', '2006', '2010', '2010', 'With honors and recognitions', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(715, 53, 'MS', 'University of the Philippines – Diliman', '2016', '2025', '2025', 'With recognitions', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(716, 39, 'Elementary', 'University of Baguio (UB) Laboratory Elementary School', '1982', '1989', '1989', 'N/A', '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(717, 39, 'Secondary', 'University of Baguio (UB) Prep High School', '1989', '1993', '1993', 'N/A', '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(718, 39, 'Under-graduate', 'University of Baguio (UB)', '1993', '1997', '1997', 'N/A', '2025-10-24 00:42:31', '2025-10-24 00:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `rs_experience_trainer`
--

CREATE TABLE `rs_experience_trainer` (
  `id` int(11) NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `rst_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rst_venue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rst_date` date DEFAULT NULL,
  `rst_no_hours` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rs_experience_trainer`
--

INSERT INTO `rs_experience_trainer` (`id`, `rs_id`, `rst_title`, `rst_venue`, `rst_date`, `rst_no_hours`, `created_at`, `updated_at`) VALUES
(275, 60, 'Understanding NSSI and Predictive Factors for Suicide', 'Zoom Meet', '2024-05-17', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(276, 60, 'Torture and the Role of the Psychology Profession', 'Zoom Meet', '2023-09-26', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(277, 60, 'School-wide Suicide Protocol: From Assessment, Prevention and Intervention to Postvention', 'Zoom Meet', '2023-07-03', 40, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(278, 60, 'Anak, Di ka Nag-iisa, Pagkalingang Walang Kapantay', 'Google Meet', '2023-05-20', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(279, 60, 'Psychotherapy Essentials', 'Zoom Meet', '2022-11-21', 32, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(280, 60, 'Play as a Time and Place for Healing with Dr. Honey Carandang', 'Zoom Meet', '2022-11-05', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(281, 60, 'Mental Health Research in the Philippines: Developing a Competitive Research Proposal and Writing an Impactful Policy Brief', 'SLU', '2022-10-14', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(282, 60, 'Research Ethics Training', 'Zoom Meet', '2022-05-26', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(283, 60, 'PGCA 57th Virtual Annual National and 2022 International Conference', 'Zoom Meet', '2022-05-18', 24, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(284, 60, 'SINAG: Innovations in the Global Landscape', 'Zoom Meet', '2022-05-05', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(285, 60, 'Boys are Abused 2: Finding the Courage to Heal', 'SLU Sunflower Children\'s Center', '2021-11-11', 16, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(286, 60, '57TH Annual National PAP Convention: Recalibrating Philippine Psychology towards a More Responsive Discipline in the Challenging Times', 'Zoom Meet', '2021-09-30', 16, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(287, 60, 'Qualitative Data Analysis Using NVivo', 'Zoom Meet', '2021-09-27', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(288, 60, 'Webinar on Continuing Professional Development during Covid19 Pandemic and CPDAS Enhancement', 'Zoom Meet', '2021-08-27', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(289, 60, 'Online Natural Responders Program Response', 'Zoom Meet', '2021-05-28', 16, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(290, 60, 'PGCA 56th Annual National Convention: The Filipino Counselor amidst the Challenges of the Times', 'Zoom Meet', '2021-05-19', 16, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(291, 60, 'Brain-Behavior-Immune System Interaction', 'Zoom Meet', '2021-05-01', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(292, 60, '20th EdukCircle International Convention on Psychology', 'Zoom Meet', '2021-03-20', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(293, 60, 'Enhancing Teachers’ Well-Being in this Covid19 Pandemic Time', 'Zoom Meet', '2020-12-07', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(294, 60, 'Ethics Research Process in the Social Sciences', 'Zoom Meet', '2020-11-25', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(295, 60, 'Orientation and Revisiting of the Ethics Research Process', 'Zoom Meet', '2020-09-24', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(296, 60, 'Distance Learning Education', 'Zoom Meet', '2020-05-06', 24, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(297, 60, 'Learning Continues: Making Distance Learning, Open Education Resources, and Online Resources Matter during Covid 19 Education', 'YouTube', '2020-04-30', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(298, 60, 'Emotional and Psychosocial Health during Covid 19 Pandemic', 'Zoom Meet', '2020-04-29', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(299, 60, 'Establishing Personal and Professional Boundaries', 'Zoom Meet', '2020-04-25', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(300, 60, 'Transforming for Impact', 'Zoom Meet', '2020-04-24', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(301, 60, 'Covid19 and TeleBehavioral Health Ethics during this Public Health Emergency', 'Zoom Meet', '2020-04-20', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(302, 60, 'Ethical Issues on the Practice of Online Clinical Supervision', 'Zoom Meet', '2020-04-12', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(303, 60, 'Understanding TelePsychology', 'Zoom Meet', '2020-04-01', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(397, 54, 'Managing Change and Humanizing Technology', 'N/A', '2021-05-29', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(398, 54, 'Business Analytic for Non-Finance Graduates', 'N/A', '2021-04-10', 4, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(399, 54, 'Training on Workshop of the 2020 GAD Tagged Projects Using Harmonized GAD Guidelines- Projects Implementation and Management, and Monitoring and Evaluation (HGDG-PIMME)', 'N/A', '2021-02-09', 24, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(400, 54, 'Digital Photography Webinar', 'N/A', '2021-02-08', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(401, 54, 'Training Workshop on the Business Model Canvas and its Relevance to EDD-ECCES Projects', 'N/A', '2021-01-13', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(402, 54, 'DTI SME Roving Academy (SMERA) Webinar: Greening the MSME\'s on Sustainable Development', 'N/A', '2020-09-22', 4, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(403, 54, 'Online Training Workshop on the use and Application of Hormonize Gender and Development Guidelines to Program Development', 'N/A', '2020-06-15', 35, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(404, 54, 'Learning Session: Production of Improve Quality Coffee Beans through Proper Postharvest and Processing of Robusta Coffee', 'N/A', '2020-03-03', 24, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(405, 54, '5th National Coffee Expo and Annual Project Assesment', 'N/A', '2019-11-27', 24, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(406, 54, 'Learning Session on Financial Management for Coffee Farmers of CGUMC Integrating Postharvest Thecnologies/System', 'N/A', '2019-09-10', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(407, 54, 'Training on Gender Analysis and Gender Tools for PHilMech GAD Focal Point System', 'N/A', '2019-09-25', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(408, 54, 'Research Capacity Building Toward a Sustainable Community Extention Service', 'N/A', '2019-09-21', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(409, 54, 'Agr-Chain Analysis: Discovering the GAPS', 'N/A', '2019-11-09', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(410, 54, 'Planning-Workshop on Business Model Canvas', 'N/A', '2019-06-27', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(411, 54, 'In-House Training on Financial Analysis of Technologies and Enterprises in Agriculture', 'N/A', '2019-04-22', 32, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(412, 54, 'In-House News Letter Training-Writeshop', 'N/A', '2019-03-22', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(413, 54, 'Annual Project Assessment and Coffee Expo 2018', 'N/A', '2018-09-10', 24, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(414, 54, 'learning Session on Greening the Gender Responsive Value Chain Analysis (GGRCVCA) OF Selected MCSTD-Based Enterprises', 'N/A', '2018-07-16', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(415, 54, 'Annual Project Assessment and Coffee Expo 2017', 'N/A', '2017-08-11', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(416, 54, 'Women in Coffee learning Session', 'N/A', '2017-07-11', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(417, 54, '10th National Coffee Summit', 'N/A', '2017-10-24', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(418, 54, 'Agribusiness Investment Forum on Coffee', 'N/A', '2017-06-09', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(419, 54, 'Business Management Training and Action Planning Workshop', 'N/A', '2017-08-14', 10, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(420, 54, 'Training Course on Financial Viability and Profitability Analysis of New Technologies and Enterprises Under High Value Crop Development Program', 'N/A', '2017-06-27', 32, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(421, 54, 'Action Planning Workshop', 'N/A', '2017-01-02', 16, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(595, 55, 'Coffee Appriciation and Quality Cuppers Training Course and Assessment', 'N/A', '2024-01-20', 40, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(596, 55, 'CSP Roasting-Foundation, CSP Intermidiate', 'N/A', '2024-08-16', 40, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(597, 55, 'TESDA-Recognized Trainer of Coffee Production', 'N/A', '2024-05-16', 0, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(598, 55, 'Animal Production (Poultry Chicken) NCII', 'N/A', '2023-05-22', 265, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(599, 55, 'Training on Good Agricultural Practices on Coffee', 'N/A', '2023-03-27', 32, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(600, 55, 'Hour of Code (Programming for Women)', 'N/A', '2021-03-19', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(601, 55, 'Digital Poetry: A Collaborative Performance Project', 'N/A', '2021-03-19', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(602, 55, 'Creating Interactive Materials Using Animation', 'N/A', '2021-03-19', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(603, 55, 'Mobille Apps in Education', 'N/A', '2021-03-18', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(604, 55, 'Many Chat: Developing Online-Offline Learning (MCDOO)', 'N/A', '2021-03-18', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(605, 55, 'Interactive Instruction Materials', 'N/A', '2021-03-18', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(606, 55, 'Etulay-Break Rough in Teaching', 'N/A', '2021-03-18', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(607, 55, 'Solving People Puzzle', 'N/A', '2021-03-17', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(608, 55, 'Poster Design in Adobe Photoshot', 'N/A', '2021-03-17', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(609, 55, 'Overview of R.AA 10173, The Date Privacy Act of 2012', 'N/A', '2021-03-17', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(610, 55, 'Google Workspace for Education Fundamentals', 'N/A', '2021-03-17', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(611, 55, 'Video Editing Techniques in Producing Quality Vedio Lesson', 'N/A', '2021-03-16', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(612, 55, 'Effective Utilization of Multimedia Materials: DepEd TV', 'N/A', '2021-03-16', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(613, 55, 'A New Normal: The Critical Role of Assesment in Online Learning', 'N/A', '2021-03-16', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(614, 55, 'Effective Diliveryof Syncronous/ Asyncronous Teaching', 'N/A', '2021-03-15', 1, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(615, 55, 'Regional Webinar on Basic Vedio Production for Television-Based Instruction', 'N/A', '2020-08-25', 32, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(616, 55, 'Basic Occupational Safety and Health Course for SO1(Safety Officer 1)', 'N/A', '2019-06-20', 10, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(617, 55, 'Good Agricultural Practices (GAP) for Coffee Production', 'N/A', '2019-07-17', 24, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(618, 55, 'Heavy Equipment Operations-Wheel LoaderNCII', 'N/A', '2019-04-30', 156, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(619, 55, 'Shielded Metal Arc Welding (SMAW) NCII', 'N/A', '2015-07-13', 268, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(859, 56, 'DOST-PCAARRD Agribusiness Mentorship Serles (ABMS)', 'N/A', '2024-04-24', 80, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(860, 56, 'Environmental Aspect and Impact Analysis', 'N/A', '2023-10-21', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(861, 56, 'Enhancing the Technical capability of the Industry Stakeholders on the Operation of Selected CFIDP-Shared Processing Facilities', 'N/A', '2023-10-23', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(862, 56, 'Learning Session on Business Model Canvas', 'N/A', '2023-04-10', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(863, 56, 'Learning Session on the Operation and Maintance of PhilMech Brown Impeller Rice Mill and Basic Gender and Development Awareness for the Sustainable Brown Rice Processing Enterprices', 'N/A', '2023-09-29', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(864, 56, 'Basic Gender Development (GAD) Awarness: Workshop on the Identification of the Differences between Sex and Gender', 'N/A', '2023-04-04', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(865, 56, 'Learning Session on Business Model Canvas', 'N/A', '2023-11-03', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(866, 56, 'Learning Session on Community-Level Gender Analysis', 'N/A', '2022-11-17', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(867, 56, 'Supervisor Development Course (SDC) Track 2', 'N/A', '2022-07-27', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(868, 56, 'Learning Session on Business Model Canvas', 'N/A', '2022-07-24', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(869, 56, 'Training on the Cacao  Pod Husks Briquetting Processing System', 'N/A', '2022-04-05', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(870, 56, 'Climate Change: Risks, Mitigation and Adaption', 'N/A', '2022-01-21', 2, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(871, 56, 'Application of Multi-Commodity Solar Tunnel Dryer for Other Seafood Commodities', 'N/A', '2022-05-10', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(872, 56, 'GAD-Attributed Project Assessment and Gender analysis Training Workshop', 'N/A', '2022-08-30', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(873, 56, 'Use of the Harmonized Gender and Development Guidelines (HGDG) Tool Training', 'N/A', '2021-07-22', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(874, 56, 'ISO 9001-2015 Quality Management Sytem Internal Audit Training Course', 'N/A', '2021-07-15', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(875, 56, 'The Learning Curve Series: On-line  Permitting', 'N/A', '2021-05-14', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(876, 56, 'Training Workshop of the 2020 GAD Tagged Project Using Harmonized GAD Guidelines-Project Implementation and Management, and Monitoring and Evaluatio (HGDG-PIMME)', 'N/A', '2021-09-02', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(877, 56, 'ISO 45001:2018 Workshop and Audit Overview Seminar', 'N/A', '2021-01-26', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(878, 56, 'ISO 45001:2018 Awareness and Transition Seminar', 'N/A', '2021-01-18', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(879, 56, 'Training Workshop on Business Model Canvas and its Relevance to EDD-ECES Project', 'N/A', '2021-01-13', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(880, 56, 'Online Basic Training Course for Pollution Control Officers', 'N/A', '2020-10-06', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(881, 56, 'Mandatory 8-Hours Safety and healthy Seminar', 'N/A', '2020-01-10', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(882, 56, 'Time Management and Work life Blance in  Time of COVID-19', 'N/A', '2020-09-23', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(883, 56, 'DTI SME Roving Acadey (SMERA) Webinar:Greening the MSMEs on Sustainable Development', 'N/A', '2020-09-22', 4, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(884, 56, 'Training Workshop on the Use and Application of Harmonized Gender and Development Guidline to Program Development (Batch2)', 'N/A', '2020-07-20', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(885, 56, 'Supervisory Development Course (SDC)Track 3', 'N/A', '2019-12-14', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(886, 56, 'Supervisory Development Course (SDC)Track 1', 'N/A', '2019-11-27', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(887, 56, 'Resource Person Development Course on  the Operation and Maintenance of Rice', 'N/A', '2019-09-18', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(888, 56, 'Training Course on RCEF Mechanization Componet for Program', 'N/A', '2019-06-27', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(889, 56, 'Training Workshop on Sustainable Mechanization for Smallholder Farmers in Asia', 'N/A', '2019-12-05', 96, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(890, 56, 'In House Training on Climate Change: Carbon Footprint Assessment', 'N/A', '2019-03-04', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(891, 56, 'Trainer\'s Methodology TM Level I (Trainer/Assessor)', 'N/A', '2019-03-26', 120, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(892, 56, 'Capability Building for Drying and Milling plant Servicing NCII', 'N/A', '2017-11-20', 48, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(893, 56, 'Technical Capability Enhancement on Mechanization and Postharvest Handling of High Value Fruits and Vagetables', 'N/A', '2017-10-15', 112, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(894, 56, 'Agribusiness Investment Forum on Coffee', 'N/A', '2017-09-06', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(895, 56, 'Training on Rapair and Maintance of Small Farm Engines (NCII)', 'N/A', '2017-03-20', 48, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(896, 56, 'Landsape  Planning: Zonal SWOT Workshop', 'N/AV', '2015-10-08', 32, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(897, 56, 'Integrating  Climate Change Adaptation into Policies, Plans and Program in Agriculture: A Training-Workshop', 'N/A', '2015-04-08', 32, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(898, 56, 'Workshop on Concept Note Preparation and Development of Projects for PPP Pipeline', 'N/A', '2014-10-27', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(899, 56, 'Training on High Impact Presentation for the Middile Level Managers of the Deparment of Agriculture Bureaus and Attached Agencies', 'N/A', '2014-05-08', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(900, 56, 'In House Training on the Philippines Technology Transfer Act and Technology Disclosure and Basic Patent Drafting', 'N/A', '2014-04-29', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(901, 56, 'International Training Course on Postharves of Perishable Horticultural Crops', 'N/A', '2009-11-29', 104, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(902, 56, 'Seminar on Gender and Development', 'N/A', '2006-04-12', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(903, 56, 'Technical Training of Postharvest Rice Processing Course at Satake Corporation', 'N/A', '2004-10-25', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(904, 56, 'Group Training Course: PostharvestRice Processing II (Japan)', 'N/A', '2004-08-31', 376, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(905, 56, 'Seminar on Public Accountability and Graft Preventation', 'N/A', '2001-10-10', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(906, 56, 'Capability Building and Delivery Service Enhancement in Technology Commercialization and Protocol', 'N/A', '2004-07-08', 32, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(907, 56, 'Echo Seminar on Statistical Analysis of Qualitative Data, Method for Research, Report Writing, and Project System Development', 'N/A', '2001-06-20', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(908, 56, 'Strategic Planning and Team-Building Workshop', 'N/A', '2000-11-21', 32, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(909, 56, 'Resource Person Development Course on Grains Postharvest Technology', 'N/A', '2000-09-25', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(910, 56, 'Retoolling of Postharvest Specialist Network in Region IX, X and CARAGA', 'N/A', '2000-08-21', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(911, 56, 'Statistical Report Writing', 'N/A', '2000-05-06', 30, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(912, 56, 'Training Workshop on Gender Integration and Application of Socio-econamic and Gender Research methods and Analysis Tools for BPRE Staff', 'N/A', '1999-08-12', 24, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(913, 56, 'Course on Project Proposal  Preparation and Packaging', 'N/A', '1999-07-19', 40, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(922, 57, 'Project 101 - Basic Sewing (Phase 2)', 'Angono Rizal', '2023-09-23', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(923, 57, 'Project 101 - Basic Fashion Design (Phase 1)', 'Angono Rizal', '2022-09-24', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(924, 57, 'Training & Orientation on Power Loom Weaving', 'DOST PTRI', '2022-09-14', 16, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(925, 57, 'Basic Sewing Machine Operation Training-Workshop', 'CIT & DOST PAMAMAZON', '2019-08-24', 24, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(926, 57, 'Fashion Designing Workshop', 'TUP Manila', '2009-01-01', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(927, 57, 'Fabric and Textile Evaluation Seminar Workshop', 'TUP Manila', '2011-01-01', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(928, 57, '1st National Symposium on Apparel and Jewelry Technology', '\'The Pearl Manila Hotel', '2013-01-01', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(929, 57, 'In-house Training on Textile Analysis and Testing', 'TUP Manila', '2018-01-01', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(975, 61, 'Authorized Managing Officer Course (Participant)', 'N/A', '2013-07-29', 16, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(976, 61, 'Construction Occupational Safety and Health Training (Participant)', 'Construction Safety Foundation, Inc.', '2016-04-19', 40, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(977, 61, 'Environmental Planning Exam Coaching Session (Participant)', 'UP Planners Organization', '2019-03-31', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(978, 61, 'Climathon: A Climate Reality Webinar Marathon (Participant)', 'The Climate Reality Project Philippines', '2020-10-11', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(979, 61, 'Basic Incident Command System (BICS) Training Course (Participant)', 'Office of Civil Defense', '2021-02-19', 24, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(980, 61, 'Sustainable Architecture (Participant)', 'UGreen – Green Building School', '2021-10-24', 10, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(981, 61, 'Workshop on the Formulation of the Pasig City Executive-Legislative Agenda (ELA) 2023-2025 (Resource Person)', 'City of Pasig', '2022-10-03', 24, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(982, 61, 'Towards Sustainable Recovery: The Challenges and Opportunities for Planners (PIEP Blended National Convention 2022) (Participant)', 'DHSUD', '2022-11-11', 16, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(983, 61, '2nd International Conference on Project Management (Participant)', 'Polytechnic University of the Philippines – Open University System', '2023-02-03', 16, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(984, 61, 'Comprehensive Land Use Plan 2023 Visioning, Planning Workshop, and Input for CDRA of Ozamiz City (Resource Person)', 'City of Ozamiz', '2023-03-20', 24, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(985, 61, 'Planning Workshop on the Formulation of Concept/Structure Plan for Polloc Freeport and Economic Zone (Resource Person)', 'Bangsamoro Economic Zone Authority (BEZA) and Polloc Freeport Economic Zone', '2023-08-02', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(986, 61, 'Formulation of the Land Use Development and Infrastructure Plan of Tarlac Agricultural University (Resource Person)', 'Tarlac Agricultural University', '2024-10-19', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(987, 61, 'Social Preparation and Impact Assessment Workshop of Polloc Informal Settlers Project (Resource Person)', 'Bangsamoro Economic Zone Authority (BEZA)', '2024-04-24', 16, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(988, 61, 'v-PULSE Webinar on Disaster Resilience in Informal Settlements: Climate and Disaster Risk Assessment (CDRA) (Resource Person)', 'UP School of Urban and Regional Planning', '2024-07-18', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(989, 61, 'Workshops on Data Analytics, Infographics: Updating of Pasig City Ecological Profile (Resource Person)', 'City of Pasig', '2024-07-26', 24, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(990, 61, '12th Episode of Resilience Live (Participant)', 'UP Resilience Institute', '2024-08-29', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(991, 61, 'Land Use in the Philippines: Training Seminar on the Comprehensive Land Use Plan (Participant)', 'Department of Human Settlements and Urban Development (DHSUD) – XIII (Caraga Region)', '2024-10-16', 8, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(992, 61, '5th International Conference in Urban and Regional Planning (ICURP) and the 18th PASCAL International Conference on Learning Cities (Participant)', 'UP School of Urban and Regional Planning', '2024-11-12', 16, '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(1009, 40, 'Upskilling Activity on Biosafety, Biosecurity and Chemical Safety', 'Online', '2023-02-15', 12, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1010, 40, 'WIPO Webinar O-Primer on the Patent Cooperation Treaty and Related WIPO-IP Services', 'Online', '2022-10-25', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1011, 40, 'Training of Basic Operation and Maintenance for Ultra Low Freezer (DW-HL528S)', 'PSHS', '2022-06-13', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1012, 40, 'Reimagining Pisay: Research Workshops 1 to 7', 'Online', '2022-07-03', 28, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1013, 40, 'Soil, Wastewater, and Plant Sample Preparations and Analysis for PinAAcle 900F Atomic Absorption Spectrometer (FAAS) with Autosampler', 'PSHS', '2022-02-23', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1014, 40, 'STEM-STELR Training: SEAMEO Regional Center for Quality Improvement of Teachers and Education Personnel (QITEP) in Science', 'Bandung, West Java, Indonesia', '2018-10-06', 40, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1015, 40, '104th National Convention of the Japan Society for Biological Education', 'Hokkaido, Japan', '2020-01-11', 16, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1016, 40, 'National Training of Trainers on Applied Subjects (Academic Track), Practical Research 2 Strand', 'DepEd Central Office Tagaytay International Convention Center', '2017-05-15', 40, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(1045, 62, 'Symposium on Disaster Education Capacity Building in Southeast Asia', 'University of the Philippines - School of Urban and Regional Planning', '2016-11-23', 8, '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(1046, 62, 'Training on Managing Complex Crisis and Disaster Risk Reduction and Management', 'DSWD KALAHI:CIDSS Central Office', '2014-12-02', 3, '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(1047, 62, 'Project Management Training', 'DSWD KALAHI:CIDSS Central Office', '2012-02-19', 80, '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(1048, 62, 'Basic Incident Command System (BICS) Training Course', 'Quezon City LGU', '2021-02-19', 24, '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(1049, 62, 'Spanish Language', 'Instituto Cervantes', '2025-04-05', 1462, '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(1075, 41, 'Regional Training of Trainers for Barangay Development Planning', 'N/A', '2023-07-02', 56, '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(1076, 41, 'Cordillera Autonomy IEC Speakers Training', 'N/A', '2023-05-18', 24, '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(1077, 41, 'Capacity Enhancement on LGU Devolution Transition Plan (DTP) Analytics', 'N/A', '2023-10-17', 16, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1078, 41, 'Regional Training on the Retooled Community Support Program Field Immersion Module', 'N/A', '2022-09-13', 36, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1079, 41, 'ISO:9001-2015 Standard Mindset, Principles, Awareness, with Root Cause and Corrective Action (RCCA) Orientation', 'N/A', '2022-06-20', 16, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1080, 41, 'Psycho-social Support Activity and Continuing Legal Education', 'N/A', '2022-06-07', 16, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1081, 41, 'Special M&E Conference: RBME Manual and Validation Workshop', 'N/A', '2022-03-17', 16, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1082, 41, 'Continuing Legal Education for DILG-CAR Personnel', 'N/A', '2022-12-01', 12, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1083, 41, 'Webinar Series on Futures Thinking for Enhancing Public Sector Productivity', 'N/A', '2021-11-08', 16, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1084, 41, 'FY 2021 E-Learning Session: Transition to Full Devolution Redirecting Priorities  and Shaping Local Strategies', 'N/A', '2021-10-01', 4, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1085, 41, 'Agile Development and Organizations', 'N/A', '2020-07-25', 4, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1086, 41, 'Design Thinking Principles and Application', 'N/A', '2020-11-07', 4, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1087, 41, 'Orientation on Processing of Copyright, Patent, and NCIP Clearance for Researches', 'N/A', '2019-07-05', 8, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1088, 41, 'Training on Cultural Documentation', 'N/A', '2019-05-31', 8, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1089, 41, 'Results-Based Monitoring and Evaluation (RbME) Training', 'N/A', '2017-05-17', 24, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(1090, 42, 'Writing and Editing: Word Choice and Word Order', 'N/A', '2021-04-15', 30, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1091, 42, 'Initiating and Planning Project', 'N/A', '2020-10-15', 30, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1092, 42, 'Project Management: The Basics for Success', 'N/A', '2020-10-15', 30, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1093, 42, 'Climate Reality Leadership Program', 'N/A', '2020-09-10', 6, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1094, 42, 'Studying Cities: Social Science Methods for Urban Research', 'N/A', '2019-11-20', 30, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1095, 42, 'Advance Training Module for Trainor\'s Training on Environmental Management for Small and Medium Enterprises (SMEs)', 'N/A', '2019-03-12', 32, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1096, 42, 'Urabn Environmental Education', 'N/A', '2018-02-10', 20, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(1099, 63, 'PROJECT MANAGEMENT COURSE', 'DEVELOPMENT ACADEMY OF THE PHILIPPINES', '2021-02-01', 48, '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(1100, 63, 'BUILDING SMART AND GREEN CITIES AND TOWNS IN A POST-PANDEMIC WORLD', 'JESSE ROBREDO INSTITUTE OF GOVERNANCE', '2021-12-02', 30, '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(1116, 45, 'Capacitation on Impact Evaluation Course', 'N/A', '2024-04-24', 72, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1117, 45, 'Workshop on Innovative Transformation in the Lifestyle and Services Sector', 'N/A', '2024-04-25', 9, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1118, 45, 'Training on Urban Carrying Capacity Assessment', 'N/A', '2023-09-26', 28, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1119, 45, 'R&D Comprehensive Workshop on Futures Thinking and Design Thinking, Terms of Reference Preparation and Introduction to NEDA Knowledge Management', 'N/A', '2023-07-10', 24, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1120, 45, 'Training on Geographic Information System', 'N/A', '2023-04-10', 100, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1121, 45, 'Investment Appraisal Course', 'N/A', '2022-10-17', 80, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1122, 45, 'Climate Change Adaptation: Pathways to Sustainability', 'N/A', '2022-05-02', 50, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(1123, 64, 'ePraxis Webinar - Human Ecology and Planetary Health: Old Wine in a New Bottle?', 'Zoom Meet', '2020-06-11', 1, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1124, 64, 'ePraxis Webinar - Why Data Matters? The Role of Geospatial Data Science Technologies for Social Service Delivery in a Global Pandemic', 'Zoom Meet', '2020-06-18', 2, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1125, 64, 'ePraxis Webinar - What’s next for Philippine Tourism: Challenges and Prospects beyond the COVID-19 Pandemic', 'Zoom Meet', '2020-08-27', 2, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1126, 64, 'Supervised Field Experience (Practicum): Situational Analysis for Disaster Risk Reduction Management Plan of Ormoc City, Leyte', 'Remote', '2022-03-30', 568, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1127, 64, 'iSTART: Mainstreaming of STI in Local Development Planning Workshop for the city of Carmona, Cavite', 'Carmona, Cavite', '2023-10-04', 32, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1128, 64, 'iSTART: Mainstreaming of Science, Technology, and Innovation to the PDPFP of PLGU-Benguet', 'N/A', '2023-10-27', 24, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1129, 64, 'iSTART: Mainstreaming of STI in Local Development Planning Workshop for the city of Santa Rosa, Laguna', 'Santa Rosa, Laguna', '2023-11-22', 28, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1130, 64, 'iSTART: Regional Stakeholders Analysis Workshop - CALABARZON', 'Los Banos, Laguna', '2024-03-12', 16, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1131, 65, 'Transit-Oriented Development and Local Planning', 'Planning and Development Research and Foundation Inc. (PLANADES)', '2024-02-03', 8, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1132, 65, 'Seminar / Workshop on the eBudget System for LGUs', 'Department of Budget and Management - MIMAROPA', '2022-03-16', 24, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1133, 65, 'The Ecological Solid Waste Management Act of 2000', 'Municipality of Sta. Cruz, Marinduque', '2020-09-17', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1134, 65, 'Flood Control Design with Computer Application (using HEC-HMS & HECRAS)', 'Department of Public Works and Highways', '2017-09-10', 40, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1135, 65, 'National Sewerage and Septage Management Program (NSSMP) Promotional Campaign and Training Workshop', 'Department of Public Works and Highways', '2017-06-04', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1136, 65, 'Feasibility Study Preparation of Roads and Bridges', 'Department of Public Works and Highways', '2016-10-05', 32, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1137, 65, 'Retooling Activity for the EMB MIMAROPA Region for the Improvement of Experts on Solid Waste Management', 'Environmental Management Bureau - MIMAROPA Region / National Solid Waste Management Commission Secretariat', '2015-07-20', 24, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1138, 65, 'Training on Highway Design with Computer Application (Using Civil 3D)', 'Department of Public Works and Highways', '2015-11-05', 40, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1139, 65, 'Trainer Skills Training Program (Instructional Techniques)', 'Department of Public Works and Highways', '2015-04-13', 40, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1140, 65, 'Infrastructure Road Right of Way (IRROW) Training', 'Department of Public Works and Highways', '2015-03-03', 24, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1141, 65, 'Seminar / Training on Bridge Management System (BMS)', 'Department of Public Works and Highways', '2014-12-03', 24, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1142, 65, 'Orientation-Workshop for the National Ecotourism Strategy (NES)', 'Department of Tourism / Department of Envrionment and Natural Resources', '2014-09-22', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1143, 65, 'Survey and Site Investigation Training', 'Department of Public Works and Highways', '2014-04-23', 24, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1144, 65, 'Bridge Management Systems Training', 'Department of Public Works and Highways', '2013-06-18', 32, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1145, 65, 'Training on Principles of Bridge Design', 'Department of Public Works and Highways', '2013-01-07', 40, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1146, 65, 'Local Infrastructure Feasibility Expert (LIFE) Training on Infrastructure Project Preparation', 'Asian Development Bank', '2013-10-06', 40, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1147, 65, 'DPWH Training Workshop on Community-Based Employment Program (CBEP) On-Line Monitoring and Reporting System', 'Department of Public Works and Highways', '2013-10-05', 8, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1148, 65, 'Orientation Seminar for New Employees', 'Department of Public Works and Highways', '2013-08-05', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1149, 65, 'Regional Physical Framework Plan (RPFP) Updating Writeshop', 'National Economic Development Authority / MIMAROPA Regional Development Council', '2013-05-03', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1150, 65, 'Seminar / Workshop on Principles of Highway Design', 'Department of Public Works and Highways', '2013-02-25', 40, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1151, 65, 'Philippine Rural Development Program Appraisal Mission Luzon B Cluster Workshop', 'Department of Agriculture', '2013-02-20', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1152, 65, 'The Project for Study on Improvement of Bridges thru Disaster Mitigating Measures for LargeScale Earthquakes in the Republic of the Philippines', 'Department of Environment and Natural Resources - Protected Areas and Wildlife Bureau', '2013-01-17', 14, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1153, 65, 'Seminar on Latest Water Related Technology in the Philippines', 'Department of Environment and Natural Resources - Protected Areas and Wildlife Bureau', '2012-11-20', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1154, 65, 'Southern Luzon Cluster Consultation / Workshop on the Review and Updating on the National Ecotourism Strategy (NES) and Action Plan', 'Department of Environment and Natural Resources - Protected Areas and Wildlife Bureau', '2012-11-15', 16, '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(1155, 66, '5th International Conference in Urban and Regional Planning (ICURP) and 18th PASCAL International Conference on Learning Cities', 'UP SURP', '2024-11-12', 1, '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(1156, 66, 'The 3rd International Symposium on Disaster Resilience and Sustainable Development 2023', 'Asian Institute of Technology', '2023-12-07', 1, '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(1187, 67, 'Supervisory Development Course Track 2 & 3', 'N/A', '2023-08-14', 40, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1188, 67, 'Supervisory Development Course Track 1', 'N/A', '2023-04-11', 32, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1189, 67, 'Training on Data Visualization For NEDA-CAR Staff', 'N/A', '2022-08-10', 7, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1190, 67, 'Building Your Digital Economy', 'N/A', '2021-04-14', 2, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1191, 67, 'Webinar Series for BLISTT Inter-Local Cooperation and Urban Planning for Mountainous, Smart, and Green Cities and Municipalities', 'N/A', '2021-02-09', 9, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1192, 67, 'Training for NEDA Regional Offices PPP Knowledge Corner Focal Persons', 'N/A', '2020-09-17', 5, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1193, 67, 'Introduction to Digital Learning', 'N/A', '2020-08-04', 2, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1194, 67, 'Seminar Cum Training On Culture Mapping', 'N/A', '2019-03-28', 16, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1195, 67, 'Basic Geographic Information System (GIS) Training for Regional Development Office Personnel', 'N/A', '2018-11-19', 40, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1196, 67, 'Training on Neda Writing and Style', 'N/A', '2018-10-10', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1197, 67, 'Training Workshop on Control of Documented Information', 'N/A', '2018-05-17', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1198, 67, 'Training Workshop on Internal Quality Audit', 'N/A', '2018-05-15', 16, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1199, 67, 'Investment Appraisal Course', 'N/A', '2018-05-29', 71, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1200, 67, 'NEDA Staff Development Training on Newswriting', 'N/A', '2017-12-27', 4, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1201, 67, 'UP Baguio Knowledge Festival: Design Thinking Workshop', 'N/A', '2017-11-29', 4, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1202, 67, 'Governance: Cultivating Exemplary Service', 'N/A', '2017-10-24', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1203, 67, 'QMS Documentation Based on ISO 9001:2015', 'N/A', '2017-05-12', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1204, 67, 'ASEAN/EU GSP+ Multistakeholder Briefing', 'N/A', '2017-02-18', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1205, 67, 'Media Training for Key Officials and Stakeholders', 'N/A', '2017-02-17', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1206, 67, 'Forum on Fiscal Autonomy', 'N/A', '2017-01-05', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1207, 67, 'One Day Training On Lobbying and Alliance Building', 'N/A', '2016-07-22', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1208, 67, 'Introduction to ISO 31000:2009 Risk Management', 'N/A', '2016-08-09', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1209, 67, 'Regional Executive Forum on Federalism and Autonomy', 'N/A', '2016-07-20', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1210, 67, 'Financial Programming and Policies (Macroeconomic Accounts and Analysis', 'Online', '2016-04-04', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1211, 67, 'NEDA Forum on Regional Spatial And Socio-Economic Planning: Strengthening Roles and Sustaining Networks', 'N/A', '2016-01-28', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1212, 67, 'Orientation on Migration and Development', 'N/A', '2016-01-05', 8, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1213, 67, 'Sampling Process and Quantitative & Qualitative Data Analysis Training', 'N/A', '2015-11-18', 24, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1214, 67, 'Training on ISO 9001:2008 QMS on Root Cause Analysis and Corrective Action, Effective Internal Audit Report Writing Workshop and Orientation on ISO 9001:2015 QMS', 'N/A', '2015-07-29', 24, '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(1217, 68, 'RISK ANALYSIS FOR PROJECT MANAGEMENT', 'UNIVERSITY OF THE PHILIPPINES OPEN UNIVERSITY - MASSIVE OPEN DISTANCE Elearning', '2025-02-17', 16, '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(1218, 68, 'BASICS OF RESILIENCE', 'UNIVERSITY OF THE PHILIPPINES OPEN UNIVERSITY - MASSIVE OPEN DISTANCE Elearning', '2025-01-20', 16, '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(1219, 68, 'TRAINING COURSE ON STOCHASTIC FRONTIER MODELING, GIS ANALYSIS, LAND USE SIMULATION, ESTIMATION OF HOUSING DEMAND AND', 'PLANNING AND DEVELOPMENT RESEARCH FOUNDATION, INC (PLANADES), IN COLLABORATION', '2020-10-08', 1, '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(1220, 68, 'FINANCING, AND APPLICATIONS IN URBAN AND REGIONAL PLANNING', 'WITH DEPARTMENT OF SCIENCE AND TECHNOLOGY (DOST), DOST PHILIPPINE COUNCIL FOR INDUSTRY', '0001-01-01', 1, '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(1284, 49, '1st Philippine Nuclear Science Olympiad during the 51st Atomic Energy Week', 'DOST-PNRI', '2023-12-04', 32, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1285, 49, '2023 Northern Luzon Cluster Regional Invention Contest and Exhibit -Sibol HS Finalist', '\'DepEd - CAR', '2023-09-27', 16, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1286, 49, 'Division Capacity Building of Teachers and School Heads on the Implementation of National Learning Camp', 'DEPED-CAR', '2023-09-20', 24, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1287, 49, 'FIRA Roboworld Cup Philippine', '\'UP-Diliman', '2023-04-15', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1288, 49, 'Technical Working Group during the Mid-Year In-service Training on Capacitating Teachers with the Pedagogical Approaches in the Improvement of Curriulum and Instruction', '\'DepEd-ABRA', '2023-02-06', 32, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1289, 49, 'National Science & Technology Fair 2022 - Physical Science (Team Category)', 'DepEd-CO', '2022-05-08', 40, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1290, 49, 'GURO21 Course 1 (Facilutating the Development of 21st Century Skills for SouthEasr Asian Teachers)', 'Southeast Asian Ministers of Education Organization', '2021-12-09', 40, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1291, 49, 'World Robot Games 2021', '\'Bangkok, Thailand', '2021-03-25', 24, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1292, 49, 'Webinar to Introduction to Artificial Intelligence', 'DICT-CAR', '2020-06-30', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1293, 49, 'Webinar to Robotics Programming Introduction', '\'Pinoy Robot', '2020-04-30', 24, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1294, 49, 'Instabright International Guild of Researchs and Educators', '\'Instabright Publication', '2020-06-02', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(1312, 69, 'Sharing Lessons, Advancing Collective Action in Community Forestry of Asia', 'University of the Philippines, Los Banos', '2021-09-15', 1, '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(1313, 69, 'Basic Incident Command System (BICS) Training Course', 'U.P. School of Urban and Regional Planning, Quezon City', '2021-02-19', 1, '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(1548, 51, 'The Role of Risk Assessment in Public Health', 'N/A', '2021-02-04', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1549, 51, 'Risk Assessment: An Overview', 'N/A', '2021-02-03', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1550, 51, 'Food Fraud Prevention Strategy -A Global Perspective on Testing, Monitoring and Verification', 'N/A', '2021-01-27', 2, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1551, 51, 'Training on Halal Perspective in the Industry', 'N/A', '2020-11-19', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1552, 51, 'Stakeholders\' Verification Workshop for the Food Processing Sector', 'N/A', '2020-10-27', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1553, 51, 'Food Defense and Fraud Prevention', 'N/A', '2019-10-16', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1554, 51, '\'Unlocking the Values of Your Kitchen\'\'', 'N/A', '2018-05-28', 72, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1555, 51, 'Learn Manufacturing', 'N/A', '2017-11-28', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1556, 51, 'ASEAN Packaging Conference', 'N/A', '2017-10-26', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1557, 51, '2nd OUR Food National Conference on Food Safety', 'N/A', '2017-07-17', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1558, 51, 'Attainding Sustainable Development Goals: Philippine Fisheries and Other Aquatic Resources', 'N/A', '2017-05-15', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1559, 51, 'ServSafe Certification for Food Protection Managers', 'N/A', '2017-02-23', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1560, 51, 'Awareness Seminar on Risk Management (Based on ISO 31000:2009)', 'N/A', '2016-12-20', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1561, 51, 'Awareness Seminar on ISO 9001:2015', 'N/A', '2016-12-19', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1562, 51, 'Awareness Seminar on ISO 9001:2015', 'N/A', '2016-12-19', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1563, 51, 'Statistical Data Management and Analysis Using MS Excel', 'N/A', '2016-12-10', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1564, 51, '\'\'Bridging Product Development form Prototyping to Market\'\' with Sub- project entitled: Establishment of FIC-based Technology Business Incubators', 'N/A', '2016-09-30', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1565, 51, 'Regional Workshop on Enchanching Innovation and Competitiveness of MSMEs in Response to ASEAN Integration for Agro-enterprises', 'N/A', '2016-09-29', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1566, 51, 'Food Safety Summit 2016: Updates on International and Local Food Safety Standards', 'N/A', '2016-07-09', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1567, 51, 'ASEAN Food Conference 2015 cum 54th PAFT Annual Covention', 'N/A', '2015-06-24', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1568, 51, 'DOST National Conference of Regional Food Safety Coordinators: Briefing and Discussion Session with Nanyang Polytechnic and Temasek Foundation, Singapore', 'N/A', '2015-06-23', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1569, 51, 'Philippine Halal Assembly International Conference and Expo', 'N/A', '2015-03-06', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1570, 51, 'Emergency Food Reserve (EFR) Technology', 'N/A', '2015-05-28', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1571, 51, 'Roundtable Discussion On Livestock Nutritional Biotechnology: Pre and Pro-Biotics in Food Animals', 'N/A', '2015-11-05', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1572, 51, 'Overview of Food Preservation and Packaging Methods for Product Development', 'N/A', '2014-08-20', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1573, 51, 'Enhancement Training for DOST-NCR Energy Audit Team', 'N/A', '2014-12-08', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1574, 51, 'DOST -NCR GMP/HACCP Training', 'N/A', '2013-10-09', 32, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1575, 51, 'Competency Development Training on the Verification of Wooden Height Boards Weighing Scales', 'N/A', '2013-06-16', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1576, 51, 'Seminar Workshop on Upgrading the Quality of Science Journals', 'N/A', '2012-11-28', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1577, 51, 'Efficient Use of Standards for Competitives and Consumer Protection', 'N/A', '2012-06-26', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56');
INSERT INTO `rs_experience_trainer` (`id`, `rs_id`, `rst_title`, `rst_venue`, `rst_date`, `rst_no_hours`, `created_at`, `updated_at`) VALUES
(1578, 51, 'Foundation Course on IP', 'N/A', '2012-11-10', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1579, 51, 'ISO 22000 Food Safety Management Systems Awareness-raising Seminar', 'N/A', '2008-09-15', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1580, 51, 'Seminar -Worshop on Documenting the QMS on ISO 9001:2000', 'N/A', '2008-11-09', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1581, 51, 'Orentation Seminar on ISO 9001:2000', 'N/A', '2008-10-09', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1582, 51, 'Surviving a Food Safety Audit', 'N/A', '2007-03-17', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1583, 51, 'Technology Transfer and Management Forum: Patents, Technology Assessment and Licenses', 'N/A', '2007-08-31', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1584, 51, 'Statistical Methods in The Development of Quality Criteria for Fish and Fishery Products', 'N/A', '2001-11-26', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1585, 51, '7th ASEAN Food Conference', 'N/A', '2001-11-19', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1586, 51, 'Management of Food Industry Wastes', 'N/A', '2001-06-13', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1587, 51, 'Instrumentation for Food Safety Monitoring', 'N/A', '2001-03-29', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1588, 51, 'National Symposium-Workshop cum Techno-Fair on Postharvest Fisheries Technologies', 'N/A', '1999-07-06', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1589, 51, 'Workshop on the Administration of the National Codex Organization (Codex Alimentarius)', 'N/A', '1999-05-18', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1590, 51, 'Strategic Technology Management', 'N/A', '1998-02-03', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1591, 51, 'Strategic Planning Workshop for the Food Industry, Subic, Zambales', 'N/A', '1997-11-06', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1592, 51, 'Strategic Planning Workshop for the Food Industry, Baguio City', 'N/A', '1996-12-13', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1593, 51, 'Group Training Course in Packaging and Logistics', 'N/A', '1996-04-02', 80, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1594, 51, 'Supervisory Effectiveness for Improved Quality and Productivity', 'N/A', '1994-07-18', 40, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1595, 51, 'International Conference on Food Preservation and Security', 'N/A', '1993-11-17', 24, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1596, 51, 'Quality Assurance in Fish and Fishery Products', 'N/A', '1993-10-23', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1597, 51, 'Tracking the Fungal Foes in Food and Pharmaceuticals', 'N/A', '1992-07-23', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1598, 51, 'Modified Atmosphere Packaging- Theory, Application and Microbiological Safety', 'N/A', '1992-12-05', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1599, 51, 'An Introduction to the Use of Response Surface Methodology as Tool for Product Optimization', 'N/A', '1992-03-20', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1600, 51, 'Group Training Course in Packaging Engineering', 'N/A', '1989-01-25', 424, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1601, 51, 'Conference on Coco Based Agribusiness Opportunities in Small Scale Industries', 'N/A', '1987-11-26', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1602, 51, 'The Problem of Filth Contaminants in Food for Export (Nature, Analysis and Control)', 'N/A', '1985-10-28', 8, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1603, 51, 'Food Conference \'85', 'N/A', '1985-02-18', 40, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(1604, 70, NULL, NULL, NULL, NULL, '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(1908, 53, '13th International Training Program on Competence of Laboratories and Their Management Systems', 'National Institute of Training for Standardization (NITS), Bureau of Indian Standards (BIS), ITEC Program, Noida, India', '2023-02-06', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1909, 53, 'Nanotechnologies in Taiwan', 'Benchmarked at the Industrial Technology Research Institute (ITRI), Academia Sinica, and National Cheng Kung University (NCKU), Taiwan', '2019-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1910, 53, 'Japan Internship Program 2018 on Air and Water Measurement Technology for Environmentally Sustainable Development', 'Kyoto, Japan', '2018-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1911, 53, 'Asia-Pacific Regional Forum on Health and Environment', 'Manila, Philippines', '2018-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1912, 53, 'Seminar-Workshop on Chemical Weapons Convention and Chemical Safety and Security Management of Asian Member States Conducted by the Organization on the Prohibition of Chemical Weapons (OPCW)', 'Siem Reap, Kingdom of Cambodia', '2018-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1913, 53, 'Training-Workshop on Validation of Chemical Methods of Analysis', 'Cagayan de Oro City, Philippines', '2014-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1914, 53, 'Training-Workshop on Measurement Uncertainty of Microbiological Results', 'Cagayan de Oro City, Philippines', '2014-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1915, 53, 'Training-Workshop on Internal Quality Control in the Analytical Laboratory', 'Cagayan de Oro City, Philippines', '2013-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1916, 53, 'Training-Workshop on Measurement Uncertainty of Analytical Results', 'Cagayan de Oro City, Philippines', '2013-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1917, 53, 'Training Course on Techniques and Operation of Microwave Plasma – Atomic Emission Spectrophotometer (MP-AES)', 'Customer Education and Training Centre, Yishun Avenue, Singapore', '2013-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1918, 53, 'Training Course on the Use of the Direct Mercury Analyzer (DMA-80)', 'Sorisole, Bergamo, Italy', '2012-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1919, 53, 'Understanding Nutrition Labeling', 'ZOOM', '2020-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1920, 53, 'The Role of Metrology in Integrated Approach to Water Resources Management', 'ZOOM', '2020-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1921, 53, 'Intermediate Check of Balances', 'ZOOM', '2020-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1922, 53, 'Standards Stakeholders Conference 2020', 'ZOOM', '2020-09-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1923, 53, '69th Annual Convention of the Philippine Association for the Advancement of Science and Technology (PhilAAST)', 'ZOOM', '2020-09-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1924, 53, 'Environmental Monitoring as a Food Safety Strategy and Components of an Effective Pathogen Environmental Monitoring Program', 'ZOOM', '2020-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1925, 53, 'An Overview on the Proper Selection of Personal Protective Equipment (PPE) for the Laboratory', 'ZOOM', '2020-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1926, 53, 'Online Assessors and Experts’ Forum', 'ZOOM', '2020-07-02', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1927, 53, 'Computational Approaches to COVID-19 Drug Discovery', 'ZOOM', '2020-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1928, 53, 'Minimizing the Risks of Corruption in Developing Countries: Towards Prevention Policies for Private and Public Entities', 'ZOOM', '2020-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1929, 53, 'Conformity Assessment and Accreditation Activities in a Virtual World', 'ZOOM', '2020-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1930, 53, 'FS-CoVID-19: “Ensuring Food Safety for Food Pick-up and Delivery in the New Normal', 'ZOOM', '2020-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1931, 53, 'Training Course on LC-MS Proteomics, Philippine Genome Center (PGC)', 'University of the Philippines – Diliman', '2023-04-11', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1932, 53, 'Philippine Accreditation Bureau (PAB) – DTI Assessors and Experts’ Forum', 'N/A', '2022-04-04', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1933, 53, 'Philippine Accreditation Bureau (PAB) – DTI Assessors and Experts’ Forum', 'N/A', '2019-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1934, 53, 'Training on Gender Mainstreaming Evaluation Framework (GMEF) for ITDI, Gender Analysis and Gender Sensitivity', 'N/A', '2019-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1935, 53, 'International Conference on Nanotechnology in the Philippines 2019', 'N/A', '2019-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1936, 53, '3rd Philippine Solid and Hazardous Waste Management Conference', 'DENR Regional Office No. 7 and Bohol Provincial Government', '2018-12-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1937, 53, '18th Regional Chemistry Congress', 'N/A', '2018-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1938, 53, 'Orientation/Awareness Seminar-Workshop on Fire and Safety Procedure', 'N/A', '2018-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1939, 53, 'Awareness Training on PNS ISO/IEC 17025:2017', 'N/A', '2018-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1940, 53, '1st National Conference of Chemical Laboratories', 'N/A', '2017-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1941, 53, 'Training-Writeshop on Business Continuity Plan (based on ISO 22301:2012)', 'N/A', '2017-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1942, 53, 'Training-Writeshop on Business Continuity Plan (based on ISO 22301:2012)', 'N/A', '2017-09-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1943, 53, '46th Annual Convention of the Kapisanang Kimika ng Pilipinas', 'N/A', '0017-09-02', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1944, 53, 'Control Charts in the Analytical Laboratory and Overview of Transition to ISO/IEC 17025:2017', 'N/A', '2017-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1945, 53, '1st International Symposium and 8th Annual Scientific Convention', 'N/A', '2017-05-02', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1946, 53, 'Training for Gas Chromatography – PID with Headspace Sampling System', 'N/A', '2017-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1947, 53, 'Good Weighing Practice Pocket Seminar', 'N/A', '2017-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1948, 53, 'Basic Training on Operation and Troubleshooting of Agilent Cary 60 UV-Vis Spectrophotometer with Fiber Optic Accessory', 'N/A', '2017-01-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1949, 53, 'Assessors and Experts’ Forum 2016', 'N/A', '2016-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1950, 53, 'Training-Workshop on the Principles and Framework of the Risk-based Approach', 'N/A', '2015-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1951, 53, 'Milestone New Microwave Systems, Ethos, and Clean Chemistry Lines', 'N/A', '2015-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1952, 53, '30th Philippine Chemistry Congress', 'N/A', '2015-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1953, 53, 'Challenges and Essential Applications of Densitometry, Refractometry and Polarimetry in Quality Assurance and Research Laboratory', 'N/A', '2014-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1954, 53, 'Consultative Workshop on the Development of Draft Provisions for the Revision of Administrative Order No. 2005-003', 'N/A', '2014-09-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1955, 53, 'Training-Workshop on ISO/IEC 17025:2005 Internal Quality Audit', 'N/A', '2014-09-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1956, 53, 'Training-Workshop on ISO 9001:2008 Internal Quality Audit', 'N/A', '2014-09-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1957, 53, 'Achieving Regulatory Balance: Regulatory Requirements on Importation, Procurement and Usage of Chemicals', 'N/A', '2014-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1958, 53, 'Chemistry Lecture Series: “Bio-based Polyols and Polyurethanes”', 'N/A', '2014-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1959, 53, 'Training-Workshop on Chemical Safety and Security', 'N/A', '2014-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1960, 53, 'Values Orientation-Workshop', 'N/A', '2013-12-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1961, 53, 'Agilent Spectroscopic Solution', 'N/A', '2013-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1962, 53, 'Asset Uptime – Proactive versus Reactive Preventive Maintenance', 'N/A', '2013-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1963, 53, 'Post-PT Meeting for the FNRI-Proficiency Testing (PT) 12-01 Milk Powder', 'N/A', '2013-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1964, 53, 'DOST-Industrial Technology Development Institute (ITDI) Pre-Proficiency Testing Seminar for the ITDI PT Round 1 Lead in Water', 'N/A', '2013-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1965, 53, 'Basic Microscopy, General Overview on Fume Hoods, Canopy Hoods, Clean Benches, and Biological Safety Cabinets, Pipette Clinic, and Good Plastic, Bad Plastic', 'N/A', '2013-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1966, 53, 'ISO 9001:2008', 'N/A', '2013-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1967, 53, 'Commission on Higher Education Chemistry Forum 2013', 'N/A', '2013-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1968, 53, '28th Philippine Chemistry Congress', 'N/A', '2013-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1969, 53, 'Maintenance and Troubleshooting of Basic Laboratory Equipment', 'N/A', '2013-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1970, 53, 'Quality Measurement in the Analytical Laboratory: A Microbiological Analysis Approach', 'N/A', '2012-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1971, 53, 'DOST-X RSTL Quality Lecture 4: Control Chart and Root Cause Investigation', 'N/A', '2012-12-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1972, 53, 'Operation, Calibration, Method Development and Maintenance of Milestone Direct Mercury Analyzer (DMA-80) Tri-cell', 'N/A', '2012-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1973, 53, 'ISO/IEC 17025 Awareness Enhancement and Reorientation on the RSTL QMS', 'N/A', '2012-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1974, 53, 'Training-Workshop on Credit Administration with Focus on Loan and Insurance Premium Computation', 'N/A', '2012-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1975, 53, 'Artist’s Packaging and Labeling Orientation', 'N/A', '2012-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1976, 53, 'Isotope Sampling for the Groundwater Resource Vulnerability Assessment', 'N/A', '2012-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1977, 53, '4th Annual Merck Safety Summit', 'N/A', '2012-06-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1978, 53, 'Post PT-Meeting on the FNRI Proficiency Testing (PT) on Proximates and Mineral Analyses of Infant Formula', 'N/A', '2012-03-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1979, 53, 'Launching of the Direct Mercury Analyzer-80 of Milestone SRL, Inc.', 'N/A', '2012-03-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1980, 53, 'DOST-X RSTL Quality Lecture 3: Civil Service Rules and Regulations related to RSTL QMS, Customer Feedback and SERVQUAL Dimensions', 'N/A', '2012-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1981, 53, 'Validation of Chemical Methods of Analysis', 'N/A', '2012-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1982, 53, 'DOST-X RSTL Quality Lecture 2: Filling Up of Data Sheets, NCAR, PAR and Other QMS Forms Regional Standards and Testing Laboratories', 'N/A', '2012-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1983, 53, 'DOST-X RSTL Quality Lecture 1: Reading and Recording of Weights and Volumes', 'N/A', '2012-01-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1984, 53, 'Analysis of Nitrites in Meat Products', 'N/A', '2011-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1985, 53, 'Measurement Uncertainty', 'N/A', '2011-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1986, 53, '15th Regional Chemistry Congress', 'N/A', '2011-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1987, 53, 'New Trends in Laboratory Analysis', 'N/A', '2011-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1988, 53, 'Volume Calibration', 'N/A', '2011-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1989, 53, 'Technical Review of Shelf-Life Evaluation Results', 'N/A', '2011-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1990, 53, 'Food Microbiology and Biotechnology: Hand-in-Hand on Food Safety', 'N/A', '2011-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1991, 53, 'Laboratory Equipment Update 2011', 'N/A', '2011-07-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1992, 53, 'Chemical Management and Waste Management: Best Practices', 'N/A', '2011-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1993, 53, 'Basics of Mass Calibration', 'N/A', '2011-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1994, 53, 'Environmental Management in the Food Industry', 'N/A', '2011-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1995, 53, 'Good Laboratory Practices, Safety and Waste Management and Internal Quality Control in Chemical Analysis', 'N/A', '2011-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1996, 53, 'Chemistry Lecture Series: “What’s with 12?” A Molecular Dynamics Story', 'N/A', '2011-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1997, 53, '14th Regional Chemistry Congress', 'N/A', '2010-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1998, 53, 'Molecularly Imprinted Polymers (MIP): Their Synthesis and Characterization', 'N/A', '2010-01-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(1999, 53, 'Wonders of Microbes in Agriculture and Veterinary Science', 'N/A', '2009-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2000, 53, 'Calibration of Laboratory Electronic Balances, Glassware, Measurement Uncertainty, Laboratory Safety and MSDS Preparation', 'N/A', '2009-05-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2001, 53, 'ISO 9001:2000', 'N/A', '2009-04-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2002, 53, 'The Profile of the Filipino Youth: McCann Youth Studies', 'N/A', '2009-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2003, 53, 'Chemistry Lecture Series: “Lungs are Clear?” The Rapid Detection of TB', 'N/A', '2008-11-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2004, 53, '13th Regional Chemistry Congress', 'N/A', '2007-10-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2005, 53, 'International Humanitarian Law (IHL) and the Red Cross Movement', 'N/A', '2007-08-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2006, 53, 'Chemistry Lecture Series: Beautifully Toxic', 'N/A', '2007-02-01', 8, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(2007, 39, 'Reorientation on Ease of Doing Business and Efficient Government Service Delivery Act of 2018', 'PRC-CAR, Baguio City', '2023-12-07', 4, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2008, 39, '12th Philippine Professional Summit, The Filipino Glocal Professionals: Riding through the Crest of Change', 'Fiesta Pavilion, The Manila Hotel', '2023-08-17', 16, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2009, 39, 'Disaster Preparedness Orientation', 'PRC Cental Office, Sampaloc, Manila', '2023-08-07', 3, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2010, 39, 'Basic Occupational Safety and Health Training', 'Prince Plaza Hotel, Baguio City', '2023-06-01', 10, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2011, 39, '3-Day First Aid Training', 'CDRRMO, Baguio City', '2022-12-16', 24, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2012, 39, 'Completed Staff Work', 'Citylight Hotel Function Hall, Baguio City', '2022-12-07', 8, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2013, 39, 'Data Privacy Act Awareness Seminar', 'ZOOM', '2022-11-25', 3, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2014, 39, 'Mental Health Awareness', 'Travelite Hotel Function Hall, Baguio City', '2022-10-25', 4, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2015, 39, 'Basic Life Support Training', 'CDRRMO, Baguio City', '2022-10-24', 8, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2016, 39, '7s of Good Housekeeping', 'PRC-CAR, Baguio City', '2022-06-02', 4, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2017, 39, 'Relevance of Gender Statistics to Development', 'PRC-CAR, Baguio City', '2022-03-28', 4, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2018, 39, 'ISO 9001:2015 Trainings on Risk Management and Internal Quality Audit', 'Eurotel Function Hall, Baguio City', '2021-07-27', 24, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2019, 39, 'Fire and Earthquake Drills, LPG  Management, and Use of Fire Extinguisher', 'Baguio City Sunshine Park', '2021-07-09', 2, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2020, 39, 'Webinar on Thriving on a Flexible Work Environment', 'ZOOM', '2021-06-22', 3, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2021, 39, 'Introductory Course on Disaster Risk Reduction and Management', 'Office of Civil Defense-CAR, Baguio City', '2021-05-11', 11, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(2022, 39, 'Webinar on Kalakihang Tapat sa Responsibilidad at Obligasyon sa Pamilya (Katropa)', 'ZOOM', '2021-03-25', 2, '2025-10-24 00:42:31', '2025-10-24 00:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `rs_publications`
--

CREATE TABLE `rs_publications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `p_title` text COLLATE utf8mb4_unicode_ci,
  `p_nature` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_date` date DEFAULT NULL,
  `p_venue` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rs_publications`
--

INSERT INTO `rs_publications` (`id`, `rs_id`, `p_title`, `p_nature`, `p_date`, `p_venue`, `created_at`, `updated_at`) VALUES
(1186, 39, NULL, NULL, NULL, NULL, '2025-10-19 20:05:43', '2025-10-19 20:05:43'),
(1187, 40, 'STEM education and the project-based learning: A review article', 'Publication (Int)', '2023-08-01', 'N/A', '2025-10-19 21:37:53', '2025-10-19 21:37:53'),
(1188, 40, 'Reflections beyond implementation: Evaluation of the project-based learning in the research curriculum of the Philippine Science High School - Luzon campuses', 'Publication (Int)', '2023-08-01', 'N/A', '2025-10-19 21:37:54', '2025-10-19 21:37:54'),
(1189, 41, 'N/A', 'N/A', '2025-10-20', 'N/A', '2025-10-19 21:58:10', '2025-10-19 21:58:10'),
(1190, 42, 'N/A', 'N/A', '2025-10-20', 'N/A', '2025-10-19 22:16:24', '2025-10-19 22:16:24'),
(1191, 45, 'N/A', 'N/A', '2025-10-20', 'N/A', '2025-10-19 22:40:23', '2025-10-19 22:40:23'),
(1225, 49, 'Partuat dagiti managsirarak.', 'Publication', '2020-02-20', 'ISSN National Centre of the Philippines', '2025-10-19 23:41:11', '2025-10-19 23:41:11'),
(1229, 51, 'Emergency Food Reserve and Preparation Thereof', 'Invention Publication IPO', '2022-01-01', 'N/A', '2025-10-20 00:38:41', '2025-10-20 00:38:41'),
(1230, 53, '2023 Most Outstanding Professional for Chemistry, First Most Outstanding Chemist of Northern Mindanao', 'Recognition', '2023-06-18', 'Professional Regulation Commission (PRC) Regional Office No. 10 and the Council of Accredited and Integrated Professional Organizations (CAIPO) 10, Mallberry Business Suites, Cagayan de Oro City', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1231, 53, 'Outstanding Productivity and Quality Management Study', 'Recognition', '2021-12-13', 'Major Final Output of the Certificate Course on Productivity and Quality Management, Graduate School of Public and Development Management, Development Academy of the Philippines (DAP)', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1232, 53, '2020 Model Employee for Senior Staff', 'Recognition', '2020-12-16', 'Standards and Testing Division, Industrial Technology Development Institute', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1233, 53, 'OneLab Best Practice Award: Preparation of In-house Reference Materials from Chemical Wastes, Inorganic Chemistry Section, Chemistry Laboratory, STD-ITDI, OneLab Best Practice Day', 'Recognition', '2019-12-11', 'Dusit Thani', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1234, 53, 'Most Outstanding Alumnus for Professional Service in the field of Chemistry', 'Recognition', '2014-12-01', 'Xavier University-Ateneo de Cagayan Alumni Association', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1235, 53, 'Certificate of Recognition (as a member of DOST-X RSTL), Outstanding in Service Delivery Group Category for DOST-X Regional Standards and Testing Laboratories (RSTL)', 'Recognition', '2014-09-01', 'Civil Service Commission Region X', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1236, 53, 'Recognition for showing commendable motivation and exemplary initiative in building up capability and competence in the conduct of food shelf-life evaluation', 'Recognition', '0211-08-01', 'DOST-X', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1237, 53, 'First Place, Industrial Technology Development Institute (ITDI) Institute Tagline Contest: “Inspired by Technology, Driven by Innovation,”', 'Award', '2021-01-06', 'N/A', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1238, 53, 'Third Place, Metro Manila Health Research and Development Consortium (MMHRDC) Photography Contest, 11th Annual MMHRDC Scientific Conference, with the theme “The Road to Super Seniors,”', 'Award', '2020-10-21', 'N/A', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1239, 53, 'DOST-SEI ICONS Award for 2013 for the field of Chemistry during the National Science and Technology Week (NSTW) Celebration of the Department of Science and Technology, together with other five awardees in the field of geology, physics, stem cell research and molecular medicine, computer science and information technology, and engineering', 'Award', '2013-07-23', 'N/A', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1240, 53, 'First Place, DOST-Science and Technology Information Institute DOST-wide Photo Journalism Contest, with the theme “Science Technology and Innovation: Working Together for Growth and Development”', 'Award', '2012-12-12', 'N/A', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1241, 53, 'One of the 25 Most Outstanding DOST Scholar Graduates of the Philippines', 'Recognition', '2012-09-19', 'N/A', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1242, 53, 'Third Place, 4th Annual Merck Safety Summit Photo Contest, with the theme “Your Safety. Our Priority. Be Safe with Merck!”', 'Award', '2012-06-01', 'N/A', '2025-10-20 18:23:45', '2025-10-20 18:23:45'),
(1243, 54, '2nd Best Paper (Development Category); CLAARRDEC 30th Regional Symposium on Research and Development Highlights', 'N/A', '2019-09-27', 'Magalang, Pampanga', '2025-10-20 18:47:14', '2025-10-20 18:47:14'),
(1244, 54, 'Best Paper Award; PhilMech 40th Agency In-House Review; for the project entitled \"Utilization and Promotion of Developed Postharvest Technology for Sustainable Community-Based Coffee Processing Enterprise', 'N/A', '2019-07-31', 'DA-PhilMech, Science City of Muñoz', '2025-10-20 18:47:14', '2025-10-20 18:47:14'),
(1245, 54, 'Central Luzon State University Loyalty Awardee', 'N/A', '0001-01-01', NULL, '2025-10-20 18:47:14', '2025-10-20 18:47:14'),
(1246, 56, 'PhilMech Natatanging Kawani for Support Services (Junior Category), 2013', 'N/A', '2013-01-01', 'CLSU Compound, Science City of Muñoz, Nueva Ecija', '2025-10-21 17:12:13', '2025-10-21 17:12:13'),
(1247, 56, 'PhilMech Natatanging Kawani for Support Services (Junior Category), 2015', 'N/A', '2015-01-01', 'CLSU Compound, Science City of Muñoz, Nueva Ecija', '2025-10-21 17:12:13', '2025-10-21 17:12:13'),
(1248, 56, 'PhilMech Natatanging Kawani for Support Services (Junior Category), 2022', 'N/A', '2023-05-31', 'CLSU Compound, Science City of Muñoz, Nueva Ecija', '2025-10-21 17:12:14', '2025-10-21 17:12:14'),
(1249, 56, '2023 PhilMech Hall of Fame Award', 'N/A', '2013-09-06', 'N/A', '2025-10-21 17:12:14', '2025-10-21 17:12:14'),
(1250, 57, 'Stitch Off 2024 Design Competition - PTRI DOST', 'Finalist', '2021-09-19', 'PICC', '2025-10-21 17:56:25', '2025-10-21 17:56:25'),
(1251, 60, NULL, NULL, NULL, NULL, '2025-10-21 18:58:57', '2025-10-21 18:58:57'),
(1252, 51, 'The Pilot Production and Product Evaluation of Smoked Hasa-hasa and Dried Hasa-Hasa', 'Philippine-Elib', '2020-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1253, 51, 'The Product and Process Evaluation of Dried Acidified Bisugo using Recycled Brine', 'Philippine-Elib', '2018-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1254, 51, 'DOST Representative to the Special Order No. 1096 s.2017, updating the Membership of the Technical Committee, Codex Contact Point, Management Support Office, Sub-Committees and Task Forces of the National Codex Organization', 'Sub-committees on Processed Fruits and Vegetables (SCPFV) National Codex Organization', '2017-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1255, 51, 'Water Retort machine for Processing Food Packed in Flexible Retort Pouches', 'Utility Model-IPO', '2010-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1256, 51, 'Development of Standards: Establishment of Food Standard: Sub Project A: Canton Noodles', 'ITDI R&D Projects', '2006-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1257, 51, 'Development of Standards: SubProject B: Smoked Fish', 'ITDI R&D Projects', '2006-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1258, 51, 'Recommended Code of Practice for the Processing and Handling of Flour Sticks (Pancit Canton)', 'Commodity working group-Philippine National Standard Publication', '2008-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1259, 51, 'Ethnic Food Products- Dry Base Mixes for Soups and Sauces - Philippine National Standard-DTI Bureau of Product Standards', 'Technical Committee on Food Standards--Philippine National Standard Publication', '2005-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1260, 51, NULL, NULL, NULL, NULL, '2025-10-23 17:18:09', '2025-10-23 17:18:09'),
(1261, 51, 'The Product and Process Evaluation of Dried Acified Bisugo using Recycled Brine', 'Philippine Technology Journal', '1995-01-01', 'N/A', '2025-10-23 17:18:09', '2025-10-23 17:25:14'),
(1262, 40, 'Through the teacher\'s lens: Evaluation of the project-based curricula of Philippine and Japanese science high schools', 'Publication (Int)', '2021-12-01', 'N/A', '2025-10-23 18:36:29', '2025-10-23 18:38:05'),
(1263, 40, 'Improving the Science Process Skills of STEM Students through Personality-based Approach', 'Publication (Int)', '2021-12-01', 'N/A', '2025-10-23 18:36:29', '2025-10-23 18:38:05'),
(1264, 40, 'Perspective of secondary teachers in the utilization of science strategic intervention material (SIM) in increasing learning proficiency of students in science education', 'Publication (Int)', '2016-01-01', 'N/A', '2025-10-23 18:36:29', '2025-10-23 18:38:05'),
(1265, 40, 'Gawad San Luis 2024 for Creativity', 'Recognition (School)', '2024-05-08', 'SLU', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1266, 40, 'Sinagtala Science, Technology, and Innovation (STI) Award', 'Recognition (Nat\'l)', '2024-02-09', 'PSHS', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1267, 40, 'Outstanding Employee – Level 2 (Teaching)', 'Recognition (School)', '2023-09-30', 'CARC', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1268, 40, 'Outstanding Teacher of the Year (Grade 10)', 'Recognition (School)', '2023-09-30', 'CARC', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1269, 40, 'Sinagtala STI Award', 'Recognition (School)', '2023-09-30', 'CARC', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1270, 40, 'Siglat Award', 'Recognition (School)', '2023-09-30', 'CARC', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1271, 40, 'Gantimpala Agad Award (Group Award)', 'Recognition (School)', '2023-09-30', 'CARC', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1272, 40, 'Gawad San Luis 2023 for Creativity', 'Recognition (School)', '2023-07-31', 'SLU', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1273, 40, 'National Achievement in ICT', 'Recognition (Nat\'l)', '2019-03-13', 'PICC', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1274, 40, '2018 Regional Most Outstanding Science Teacher in CAR', 'Recognition (Reg\'l)', '2018-11-03', 'Mt. Province', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1275, 40, '2018 Most Outstanding Science Teacher in Baguio City', 'Recognition (Division)', '2018-09-01', 'Baguio', '2025-10-23 18:36:29', '2025-10-23 18:39:06'),
(1276, 64, 'Graduated Magna Cum Laude', 'Academic Honor/Distinction', '2023-08-05', 'UPLB', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(1277, 49, 'Concretizing Physical Laws in Light Phenomenon Using Low-cost Improvised Refraction Tank', 'Publication', '2025-10-24', 'Instabright e-Gazette', '2025-10-23 22:59:56', '2025-10-23 22:59:56'),
(1278, 49, 'Winning Coach of the 1st Place in Robotics and Intelligent Machine (Team Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 22:59:56', '2025-10-23 22:59:56'),
(1279, 49, 'Winning Coach of the 3rd Place in Robotics and Intelligent Machine (Individual Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 22:59:56', '2025-10-23 23:06:43'),
(1280, 49, 'Winning Coach of the 1st Place in Physical Science Research (Team Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 23:06:43', '2025-10-23 23:06:43'),
(1281, 49, 'Winning Coach of the 2nd Place in Mathematical and Computational Science Research (Team Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 23:06:43', '2025-10-23 23:06:43'),
(1282, 49, 'Winning Coach of the 3rd Place in Innovation Expo  (Team Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 23:06:43', '2025-10-23 23:06:43'),
(1283, 49, 'Winning Coach of the 3rd Place in Innovation Expo  (Individual Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 23:06:43', '2025-10-23 23:06:43'),
(1284, 49, 'Winning Coach of the 3rd Place in Innovation Expo  (Team Category) Regional Science & Technology Fair 2023, Lagawe Central School, Ifugao', 'Awards', '2023-12-06', 'Lagawe, Ifugao', '2025-10-23 23:06:43', '2025-10-23 23:06:43'),
(1285, 49, 'Winning Coach of the First Place in Robotics Invention Machine (Team & Individual Categories) Division Science & Technology Fair, Penarrubia Integrated School, Poblacion,Penarrubia, Abra', 'Awards', '2023-11-25', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1286, 49, 'Winning Coach of the First Place in Physical Science Research Investigatory Project (Team) Division Science & Technology Fair, Penarrubia Integrated School, Poblacion,Penarrubia, Abra', 'Awards', '2023-11-25', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1287, 49, 'Winning Coach of the First Place in Innovation Research Investigatory Project (Team & Individual Categories) Division Science & Technology Fair, Penarrubia Integrated School, Poblacion,Penarrubia, Abra', 'Awards', '2023-11-25', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1288, 49, 'School-Community Educational Channel Award', 'Awards', '2023-12-16', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1289, 49, 'Noble Excellence Award', 'Awards', '2023-12-16', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1290, 49, 'Outstanding Proficient Teacher Award', 'Awards', '2023-12-16', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1291, 49, 'Innovative Teacher Award', 'Awards', '2023-12-16', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1292, 49, 'Coaching Prowess Award', 'Awards', '2023-12-16', 'DepEd-CAR', '2025-10-23 23:06:44', '2025-10-23 23:06:44'),
(1293, 49, 'Coach of the National Science & Technology Fair 2022 Finalist- Physical Science (Team Category)', 'Awards', '2022-01-08', 'DepEd-CO', '2025-10-23 23:06:44', '2025-10-23 23:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `rs_references_trainings`
--

CREATE TABLE `rs_references_trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `name_agency` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_no` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cell_no` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_no` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rs_references_trainings`
--

INSERT INTO `rs_references_trainings` (`id`, `rs_id`, `name_agency`, `address`, `contact_person`, `position`, `tel_no`, `cell_no`, `fax_no`, `created_at`, `updated_at`) VALUES
(108, 60, 'Saint Louis University', 'Bonifacio St., Baguio City', 'Marie Ellami S. Refuerzo', 'Director', 'N/A', '09209007360', 'N/A', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(125, 54, 'Central Luzon State University', 'Bagong Sikat, Bantug, Muñoz, Nueva Ecija', 'Prof. Winnie DC. Villanueva', 'N/A', '456-5191', 'N/A', 'N/A', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(126, 54, 'Central Luzon State University', 'Toiasville, Bantug, Muñoz, Nueva Ecija', 'Dr. Helen F. Martinez', 'N/A', '456-0213', 'N/A', 'N/A', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(127, 54, 'Central Luzon State University', 'Poblacion South, Muñoz, Nueva Ecija', 'Engr. Rogelio L. Miguel', 'N/A', '456-0599', 'N/A', 'N/A', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(149, 55, 'N/A', 'Tungao, Butuan City', 'Allan V. Lorico', 'N/A', 'N/A', '0910-678-8146', 'N/A', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(150, 55, 'N/A', 'Maningalao, Las Nieves, Agusan Del Norte', 'Denicer D. Dogmoc', 'N/A', 'N/A', '0960-837-6561', 'N/A', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(151, 55, 'DA-PhilMech', 'Science City of Muñoz, Nueva Ecija', 'Ivy Espiritu', 'SRA', 'N/A', '0928-520-2725', 'N/A', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(176, 56, 'DA-PhilMech', 'Science City of Muñoz, Nueva Ecija', 'Dr. Normita A. Pasalo', 'N/A', 'N/A', '0998-572-0307', 'N/A', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(177, 56, 'Central Luzon State University', 'Lanany, Davao City', 'Dr. Apolinario V. Yambot', 'N/A', 'N/A', '0919-802-8624', 'N/A', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(178, 56, 'DA-PhilMech', 'Science City of Muñoz, Nueva Ecija', 'Raymundo S. Dela Cruz', 'N/A', 'N/A', '0950-602-6584', 'N/A', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(180, 57, 'DOST-NCR PAMAMAZON CASTO', 'Phillippine Scince Highschool', 'Daniel A. Germino', 'Project Technical Assistant I', 'N/A', '0915 068 8130', 'N/A', '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(203, 61, 'N/A', 'Quezon City', 'Carmelita Rosario Eva U. Liwag', 'N/A', 'N/A', '0917-5855388', 'N/A', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(204, 61, 'N/A', 'Quezon City', 'Dina C. Magnaye', 'N/A', 'N/A', '0916-7116165', 'N/A', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(211, 40, 'Saint Louis University', 'STELA-Saint Louis University', 'Dorothy D. Silva', 'Department Head, SLU-STELA', 'N/A', '09175689002', 'N/A', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(212, 40, 'Saint Louis University', 'A. Bonifacio St., Brgy. ABCR, Baguio City', 'Felina P. Espique', 'VP of Academic Affairs', '074444824648', 'N/A', 'N/A', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(213, 40, 'N/A', 'PSHS-CARC', 'Edward C. Albaracin', 'Campus Director', '(074) 423 0126', 'N/A', 'N/A', '2025-10-23 18:39:06', '2025-10-23 18:39:06'),
(218, 62, 'N/A', 'AA2-102 Hardin ng Rosas, UP Campus, Diliman, Quezon City', 'PROF. CARMELITA ROSARIO EVA LIWAG', 'N/A', 'N/A', '0917 585 5388', 'N/A', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(219, 62, 'N/A', 'Filinvest Homes, Quezon City', 'DESEREE D. FAJARDO', 'N/A', 'N/A', '0916 428 6509', 'N/A', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(220, 62, 'N/A', '622A Anahaw St., Amparo Subdivision, Caloocan City', 'LALAINE C. ENCARNACION', 'N/A', 'N/A', '0920 9148 567', 'N/A', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(223, 41, 'DOST-CAR', NULL, 'DOST-CAR. Km6, BSU Compound, La Trinidad, Benguet', 'Project Technical Assistant I', 'N/A', '09487799460', 'N/A', '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(224, 42, 'DOST CAR', 'DOST-CAR, Km6, BSU Compound, La Trinidad, Benguet (iSTART-Technical Service Devision)', 'Marjolly G. Sanchez', 'Project Technical Assistant I', 'N/A', '09487799460', 'N/A', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(227, 63, 'N/A', 'SAN PABLO CITY', 'EDGAR REYES JR', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(228, 63, 'N/A', 'QUEZON CITY', 'CARMELITA LIWAG', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(229, 63, 'N/A', 'SAO PAULO, BRAZIL', 'JOHANNES KLINK', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(233, 45, 'DOST-CAR', 'DOST-CAR. Km6, BSU Compound, La Trinidad, Benguet (iSTART-Technical Services Division)', 'Marjolly G. Sanchez', 'Project Technical Assistant II', 'N/A', '09487799460', 'N/A', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(234, 45, 'PLGU-Kalinga', 'PPDO Kalinga, Provincial Capitol, Bulanao, Tabuk City', 'Flordeliza Moldero', 'PPDC', 'N/A', 'N/A', 'N/A', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(235, 45, 'PLGU-Mt. Province', 'PPDO Mt. Province, Provincial Capitol, Bontoc, Mt. Province', 'Judy Nguslab', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(236, 64, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(237, 65, 'N/A', 'QUEZON CITY', 'MA. SHEILAH GAABUCAYAN-NAPALANG, DEng', 'N/A', 'N/A', '9178927123', 'N/A', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(238, 65, 'N/A', 'QUEZON CITY', 'Engr. RENATO ESCUADRO', 'N/A', 'N/A', '9178477398', 'N/A', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(239, 65, 'N/A', 'PASIG CITY', 'Arch. RALPH SOTORIDONA', 'N/A', 'N/A', '9173251121', 'N/A', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(246, 67, 'Intercontinental Hotels Group', 'CJHEZ, Loakan Road, Baguio City', 'Anna Camille Morte', 'N/A', '(074) 300-8040', 'N/A', 'N/A', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(247, 67, 'DTI-CAR', 'Jesnor Building, Carino Street, Baguio City', 'Atty. Samuel B. Gallardo', 'N/A', '(074) 442-8954', 'N/A', 'N/A', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(248, 67, 'PAGASA', 'PAGASA Compound, Baguio City', 'Dr. Jedidia L. Aquino', 'N/A', 'N/A', '(63) 917678082', 'N/A', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(251, 68, 'N/A', 'AA2-102 HARDIN NG ROSAS, DILIMAN, QUEZON CITY', 'CARMELITA ROSARIO EVA U. LIWAG', 'N/A', 'N/A', '639175855388', 'N/A', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(252, 68, 'N/A', 'HAMPSTEAD, MARIKINA CITY', 'ATTY. ANGELICO DELOS REYES', 'N/A', 'N/A', '639152633733', 'N/A', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(253, 68, 'N/A', '#177 SUMULONG HIGHWAY, ANTIPOLO CITY, RIZAL', 'ATTY. JETTER JONES MEJIA', 'N/A', 'N/A', '639955590786', 'N/A', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(263, 49, 'DepEd-Abra', 'Bangued, Abra', 'Bhenjoo Agaloos', 'Education Program Supervisor', 'N/A', 'N/A', 'N/A', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(264, 49, 'DTI-Abra', 'Brgy. Zone 7, Bangued, Abra', 'Rodel B. Bolante', 'N/A', 'N/A', 'N/A', 'N/A', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(265, 49, 'DepEd-Abra', 'Bangued, Abra', 'Rodel Rifareal', 'Education Program Supervisor', 'N/A', 'N/A', 'N/A', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(290, 51, 'DOST-National Capital Region', 'DOST Compound, Bicutan, Taguig City', 'Engr. Romelen T. Trevalles', 'Regional Director', 'N/A', 'N/A', 'N/A', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(291, 51, 'Pamantasan ng Lungsod ng Muntinlupa', 'University Rd. Poblacion, Muntinlupa', 'Dr. Teresita C. Fortuna', 'President', 'N/A', 'N/A', 'N/A', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(292, 51, 'PCCI -NCR', 'N/A', 'Ms. Teresita S. Ngan Tian', 'Vice President', 'N/A', 'N/A', 'N/A', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(302, 53, 'DOST-ITDI', 'NML & Administrative Offices Building, DOST Compound, General Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Annabelle V. Briones, PhD, CESO III', 'Director (2019 - Present) / Scientist I', '(+632) 8-683-7750', 'N/A', 'N/A', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(303, 53, 'DOST-ITDI', 'NML & Administrative Offices Building, DOST Compound, General Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Maria Patricia V. Azanza, PhD', 'Director (2014-2017)', 'N/A', 'N/A', 'N/A', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(304, 53, 'DOST-ITDI', 'NML & Administrative Offices Building, DOST Compound, General Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Ma. Rachel V. Parcon, RCh, MSc', 'Chief Science Research Specialist', '(+632) 8-683-7750', 'N/A', 'N/A', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(305, 39, 'DOST-CAR', 'BSU Compound, Km.6, La Trinidad, Benguet', 'Grangery M. Agtulao', 'Project Technical Specialist I', '(074) 422 0979', 'N/A', 'N/a', '2025-10-24 00:42:31', '2025-10-24 00:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `rs_training`
--

CREATE TABLE `rs_training` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `rt_title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt_venue` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt_date` date DEFAULT NULL,
  `rt_no_hours` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rs_training`
--

INSERT INTO `rs_training` (`id`, `rs_id`, `rt_title`, `rt_venue`, `rt_date`, `rt_no_hours`, `created_at`, `updated_at`) VALUES
(266, 60, 'Mental Health and Wellbeing in the Community', 'Guisad, Baguio City', '2025-05-10', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(267, 60, 'Thriving with P.E.A.C.E. and Compassion for freshmen SLU-DOST Scholars', 'SIRIB Center, SLU', '2024-11-14', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(268, 60, 'Career Orientation to Grade 12 Learners', 'SLU', '2024-10-18', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(269, 60, 'Creating a Sense of Psychological Safety', 'SLU Gevers Hall', '2024-06-11', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(270, 60, 'Biyaheng Paghilom: Sa Paglago ng Kalusugan at Kaisipan para sa Lahat, Kasama Ako – Panel Discussan', 'SLU', '2024-05-03', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(271, 60, 'Positive Discipline', 'SLU', '2023-11-06', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(272, 60, 'Mental Health Talk for Families', 'Holy Family Parish, Bakakeng, Baguio City', '2023-04-30', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(273, 60, 'Upskilling on Online Counseling for Guidance Counselor Volunteers', 'Zoom Meet', '2022-05-27', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(274, 60, 'Wounded Healer: Reflections and Insights', 'Zoom Meet', '2022-04-22', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(275, 60, 'Harnessing Our Emotional Agility', 'Zoom Meet', '2022-04-22', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(276, 60, 'Panelist-Discussant in the 20th EdukCircle International Convention in Psychology', 'Zoom Meet', '2021-03-20', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(277, 60, 'Strength-Based Counseling Techniques (Faculty In-Service)', 'Zoom Meet, SLU', '2021-02-22', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(278, 60, 'Rising Above Chaos: Mental Health Care for Children & Adolescents in Covid19 Pandemic Time', 'Zoom Meet, BSU', '2020-12-17', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(279, 60, 'Positive Discipline', 'BCNHS', '2019-05-15', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(280, 60, 'Understanding Stress and Anxiety', 'Magsaysay NHS, Lucban, Baguio City', '2019-05-01', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(281, 60, 'Management of Millennials and Differentiated Instruction', 'Mt. Data NHS, Bauko, Mt. Province', '2018-10-06', 8, '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(299, 54, 'Learning Session on Coffee Postharvest', 'N/A', '2024-11-12', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(300, 54, 'Training on Records Management', 'N/A', '2024-12-13', 8, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(301, 54, 'Rambak Ti Siyensya: Science, Technology and Innovation Caravan', 'Ilocos Sur', '2023-11-28', 24, '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(316, 55, 'Training on Coconut-Coffee Farming System', 'DA-Agricultural Training Institute', '2024-07-29', 24, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(317, 55, 'Trainer for Coffee Production Level II Under Tulong Trabaho Scholarship Program of Tesda', 'CAWFAI, Casiklan, Las Nieves, Agusan Del Norte', '2024-05-16', 640, '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(342, 56, 'Training on Operation and Maintenance of MCSTD', 'Labi, Bongabon, Nueva Ecija', '2020-10-17', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(343, 56, 'Business Model Development for Sugarcane Silage Production', 'Victoria City, Tarlac', '2021-11-29', 8, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(344, 56, 'Agribusiness Investment Forum on Coffee', 'DAP, Brgy. Sungay East, Tagaytay City', '2017-09-06', 16, '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(346, 57, 'As Judge: SMS Skills Competition', 'Sisters of Mary Bannuex, Cavite', '2021-03-20', 8, '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(516, 40, 'SLU Seminar for 4th Year Students on Action Research', 'Saint Luis University', '2024-02-17', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(517, 40, 'Smart Mobile Lab (Teacher Training on Educational Research)', 'Luna, Apayao', '2023-12-09', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(518, 40, 'PAFTE Seminar Series: Session 5: Creating High Impact Learning Plans', 'Online', '2023-08-08', 1, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(519, 40, 'LET Review on Action Research', 'Online', '2023-10-21', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(520, 40, 'Laguna University BAC Student Research Colloquium', 'Online', '2023-05-23', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(521, 40, 'PSHSxBCNHS Personnel Research Colloquium', 'PSHS-CARC', '2023-05-04', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(522, 40, 'Research Writing Seminar-Workshop 2022', 'Online', '2022-08-17', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(523, 40, 'HHNHS InSET (Basics of Educational Research)', 'HHNHS', '2022-08-19', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(524, 40, 'Project WAR 3 (Writing Action Research in District III)', 'DepEd Naga', '2021-11-05', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(525, 40, 'Research Writing Course', 'DepEd Baguio', '2021-11-20', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(526, 40, 'Pisay Agapay (Talk on Educational Research)', 'Online', '2021-12-04', 2, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(527, 40, 'Project WAR 3 (Writing Action Research in District III)', 'DepEd Naga', '2021-11-05', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(528, 40, 'Research Writing Course', 'DepEd Baguio', '2021-11-20', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(529, 40, 'Academic Webinar for Science and Engineering (Japan)', 'Okayama, JP', '2020-02-15', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(530, 40, 'PADECO Webinar: Pathways to Building Back Better in Education', 'Okayama, JP', '2020-10-15', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(531, 40, 'Okayama University\'s SDG Virtual Café: Basic Education in the New Normal', 'Okayama, JP', '2020-09-24', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(532, 40, 'Webinar on Quantitative Methods in Educational Research', 'Online', '2020-05-02', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(533, 40, '1st Gener and Development Conference in Research and Education', 'Baguio City', '2020-09-12', 4, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(534, 40, 'West Baguio-Baguio Central District Research Seminar', 'PCNHS', '2019-08-01', 16, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(535, 40, 'Lucban-Mabini Science Invesitgatory Project Making', 'Easter College', '2019-02-01', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(536, 40, 'Evaluation Training on Basics of Research Writing', 'DepEd Baguio', '2018-08-01', 8, '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(549, 41, 'Training of Cordillera Autonomy IEC Speakers', 'Baguio City', '2023-08-15', 6, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(550, 41, 'In-Depth Workplace Learning and Performance (WLP): The Definitive Guide for Documenters in Public Service as Governance Model for Devolution', 'Baguio City', '2023-06-13', 4, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(551, 41, 'Training on the Implementation of the DILG-CAR Retooled Community Support Program Field Immersion Module for Potential SBDP Target Barangays and Establishment of Peoples Council', 'Baguio City', '2023-03-22', 32, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(552, 41, 'Capacity Development Program for Civil Society Organizations (CSO) in Local Development Council (LDC)', 'Baguio City', '2023-02-22', 8, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(553, 41, 'Usapang Pangkalusugan ng Mga Kabataan (Adolescent Forum)', 'Mt. Province', '2019-10-14', 8, '2025-10-23 18:57:40', '2025-10-23 18:57:40'),
(554, 42, 'Planning Workshop Series for the Mainstreaming of Science, Technology, and Innovation for the Local Development Planning of the Cordillera Administrative Region', 'Tuba, Benguet', '2023-10-27', 16, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(555, 42, 'iSTART: Mainstreaming of STI in Local Development Planning of Carmona, Cavite', 'Carmona, Cavite', '2023-04-10', 16, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(556, 42, 'iSTART: Mainstreaming of STI in Local Development Planning of Sta. Rosa, Laguna', 'Sta. Rosa, Laguna', '2023-12-23', 8, '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(563, 45, 'Capacitation on Project Development and Fund Sourcing for PLGU-Mt. Province', 'N/A', '2022-11-08', 32, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(564, 45, 'Training on Project Development for Planning Officers of the Province of Kalinga', 'N/A', '2021-12-14', 32, '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(565, 64, 'Planning Workshop Series for the Mainstreaming of Science, Technology, and Innovation for the Local Development Planning of the Cordillera Administrative Region', 'Tuba, Benguet', '2023-10-27', 32, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(566, 64, 'iSTART: Mainstreaming of STI in Local Development Planning Workshop of Carmona, Cavite', 'Carmona, Cavite', '2023-10-04', 16, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(567, 64, 'iSTART: Mainstreaming of STI in Local Development Planning Workshop of Sta. Rosa, Laguna', 'Sta. Rosa, Laguna', '2023-11-23', 24, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(568, 64, 'iSTART: Regional Stakeholders Analysis Workshop - CALABARZON', 'Los Banos, Laguna', '2024-03-12', 16, '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(598, 49, 'Resource Speaker on School-based Learning Action Cell  on Exploring the Fundamentals of Robotics', 'DepEd-Abra', '2023-06-23', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(599, 49, 'Resource Speaker on School-based Learning Action Cell on Capacitatitng Teachers in Science Research', 'DepEd-Abra', '2023-03-15', 40, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(600, 49, 'Resource Speaker on Mental Health and Psychosocial Suport and Psychological First Aid for Selected Learners', 'DepEd-Abra', '2023-12-13', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(601, 49, 'Resource Speaker on Seminar Workshop on Science Investigatory Project', 'DepEd-Ilocos Sur', '2021-04-22', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(602, 49, 'Resource Speaker on 2021 DEPED-CAR Research Congress', 'DepEd-CAR', '2021-04-22', 8, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(603, 49, 'Investigation', 'DepEd-Apayao', '2025-12-31', 24, '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(644, 51, 'DOST NCR and DOST -ITDI on-call Resource Person and Consultant', 'N/A', '2023-10-01', 480, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(645, 51, 'DTI-NCR Kapatid Mentor Me Trainor', 'N/A', '2019-01-01', 72, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(646, 51, 'Philippine Chamber of Commerce and Industry resource speaker (on-call)', 'N/A', '2018-01-01', 16, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(647, 51, 'State Universities and Colleges (SUCs) and Local Universities and Colleges (PUP, TUP, PWU, Pamantasang ng Lungsod ng Muntinlupa)', 'N/A', '2012-01-01', 180, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(648, 51, 'OneExpert', 'N/A', '2018-01-01', 36, '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(868, 53, 'Training Course on Internal Quality Audit for PNS ISO/IEC 17025:2017', 'Via Zoom', '2023-05-15', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(869, 53, 'Training Course on the Establishment of Decision Rules and Statement of Conformity in Testing and Calibration', 'Via Zoom', '2023-05-08', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(870, 53, 'Training Course on Root Cause Analysis and Effective Corrective Action', 'Quezon City', '2023-04-28', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(871, 53, 'Training Course on Internal Quality Audit for Quality Management System', 'DOST Regional Office No. XIII Caraga, Butuan City', '2023-04-18', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(872, 53, 'Preparation of Internal Quality Control Material (IQCM) based on ISO Guide 80', 'Via Zoom', '2023-03-30', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(873, 53, 'Training Course on “Understanding Requirements of ISO/IEC 17043:2010”', 'Via Zoom', '2021-01-22', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(874, 53, 'Training Course on PNS ISO/IEC 17025:2017', 'Via Zoom', '2021-01-13', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(875, 53, 'Training Course on “Proficiency Testing and Interlaboratory Comparison', 'Via Zoom', '2020-10-28', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(876, 53, 'Decision Rules in Calibration and Testing', 'Via Zoom', '2020-10-26', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(877, 53, 'Training Course on PNS ISO/IEC 17025:2017', 'Via Zoom', '2020-09-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(878, 53, 'Training Course on “Internal Quality Audit for PNS ISO/IEC 17025:2017', 'Via Zoom', '2020-09-17', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(879, 53, 'Essential How to Convert Chemical Wastes into Useful Internal Quality Control Materials', 'Via Zoom', '2020-08-28', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(880, 53, 'Essential Components of Proficiency Testing or Interlaboratory Comparison', 'Via Zoom', '2020-08-07', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(881, 53, 'Drinking Water: Regulations, Testing and Consumer Responsibility,” Philippine Metrology, Standards, testing and Quality, Inc. (PhilMSTQ)', 'Via Zoom', '2020-07-23', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(882, 53, 'Training Course on Uncertainty of Measurement in Analytical Testing, Food and Nutrition Research Institute (FNRI)', 'Via Jetsi', '2020-06-29', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(883, 53, 'Training Course on Internal Quality Audit for PNS ISO/IEC 17025:2017', 'Via Zoom', '2020-06-24', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(884, 53, 'Training Course on Intermediate Check of Volumetric Glassware', 'Via Bluejeans', '2020-06-20', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(885, 53, 'Training Course on Measurement Uncertainty in Analytical Testing', 'Via Zoom and Bluejeans', '2020-06-06', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(886, 53, 'Echo Webinar for Management and Technical Assessors of PAB-DTI on Remote Assessment/Auditing', 'Via Zoom', '2020-05-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(887, 53, 'Awareness Webinar on RA 11032 Ease of Doing Business and Efficient Delivery of Government Services Act of 2018', 'Via Zoom', '2020-05-05', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(888, 53, 'Training-Workshop on Internal Quality Audit for PNS ISO/IEC 17025:2017', 'DOST IVB, Puerto Princesa City, Palawan', '2020-02-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(889, 53, 'Training-Workshop on Method Validation and Measurement Uncertainty in Routine Chemical Analysis', 'FNRI, Bicutan, Taguig City', '2019-12-03', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(890, 53, 'Awareness Seminar on PNS ISO/IEC 17025:2017, Material Science Division', 'ITDI-DOST, Bicutan, Taguig City', '2019-11-20', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(891, 53, 'How to Assess Electronic Management System?', 'Bo’s Coffee, Glorietta 5, Makati City', '2019-10-26', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(892, 53, 'Training Course on Measurement Uncertainty, Advanced Device and Materials Testing Laboratory (ADMATEL)', 'ITDI-DOST, Bicutan, Taguig City', '2019-06-27', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(893, 53, 'Training Course on Transition to PNS ISO/IEC 17025:2017', 'DOST-II, Tuguegarao City, Cagayan', '2019-09-05', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(894, 53, 'Training-Workshop on Measurement Uncertainty for Chemical Testing', 'FNRI, Bicutan, Taguig City', '2019-08-22', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(895, 53, 'Training-Workshop on Risk Management in PNS ISO/IEC 17025:2017', 'National Metrology Laboratory, ITDI-DOST', '2019-08-14', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(896, 53, 'Training-Workshop on Basic Metrology, Calibration and Measurement', 'Mines and Geosciences Bureau (MGB-DENR), Diliman, Quezon City', '2019-08-05', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(897, 53, 'Training-Workshop on Internal Quality Audit for PNS ISO/IEC 17025:2017, Root Cause Analysis and Corrective Action', 'DOST-I, La Union', '2019-08-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(898, 53, 'In-house Training on the Analysis of Arsenic in Water', 'DOST-I', '2019-08-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(899, 53, '(Presenter) New Testing Services of OneLab, DOST-ITDI Technical Services: Supporting SMEs for Sustainable Growth and Development', 'NSTW, World Trade Center, Manila', '2019-07-19', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(900, 53, 'Role of measurement uncertainty in conformity assessment', 'Bo’s Coffee, Glorietta 5, Makati City', '2019-07-13', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(901, 53, 'Training Workshop on Uncertainty of Analytical Measurement', 'Aquaculture Department, Southeast Asian Fisheries Development Center (SEAFDEC)Tigbauan, Iloilo City', '2019-06-30', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(902, 53, 'Training Course on Transition to PNS ISO/IEC 17025:2017', 'DOST-III, City of San Fernando, Pampanga', '2019-05-20', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(903, 53, 'Training Course on Transition to PNS ISO/IEC 17025:2017 and Risk Management', 'DOST-X, Cagayan de Oro City', '2019-05-20', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(904, 53, 'In-house Training on the Analysis of Arsenic and Manganese in Water', 'DOST-X, Cagayan de Oro City', '2019-05-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(905, 53, 'Awareness Seminar on PNS ISO/IEC 17025:2017', 'Packaging Technology Division, ITDI-DOST, Bicutan, Taguig City', '2019-05-09', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(906, 53, 'Training Course on Transition to PNS ISO/IEC 17025:2017 and Risk Management', 'DOST-III, Caraga, Butuan City', '2019-04-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(907, 53, 'In-house Training on the Analysis of Arsenic in Water', 'DOST-VIII, Caraga, Butuan City', '2019-04-02', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(908, 53, 'In-house Training on Uncertainty of Measurement', 'ATLAS Fertilizer Corporation, Toledo City, Cebu', '2019-05-16', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(909, 53, 'Training Course on Validation of Chemical Methods of Analysis', 'Technological Services Division, ITDI', '2019-05-13', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(910, 53, 'Productivity and Efficiency through Better Laboratory Practices, Seminar on 360° Approach to Health, Environment, Safety and Quality', 'PALEU', '2019-05-06', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(911, 53, 'In-house Training on the Analysis of Arsenic in Food and Heavy Metals in Water', 'DOST-IX, Zamboanga City', '2019-02-20', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(912, 53, 'Training Course on Transition to PNS ISO/IEC 17025:2017', 'DOST-IX, Zamboanga City', '2019-02-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(913, 53, 'Training Course on Transition to PNS ISO/IEC 17025:2017', 'DOST-CAR, La Trinidad, Benguet', '2018-11-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(914, 53, 'DOST Programs on Food and Water Safety, Food and Waterborne Diseases (FWBD) Prevention and Control Program Orientation and Updates', 'DOH Center for Health Development MIMAROPA, Manila', '2018-11-16', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(915, 53, 'Training Course on Method Development and Validation of Analytical Procedures for the Analysis of Geological and Environmental Samples', 'MGB-DENR, Diliman, Quezon City', '2018-09-18', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(916, 53, 'In-house Training on the Analysis of Arsenic in Water using Graphite Furnace Atomic Absorption Spectrophotometric Method', 'DOST-CAR, La Trinidad, Benguet', '2018-08-29', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(917, 53, 'Training Course on Measurement Uncertainty and Internal Quality Control in the Analytical Laboratory', 'MGB-DENR', '2018-04-10', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(918, 53, 'How to Effectively Close Nonconformities', 'PALEU, Quezon City', '2018-03-15', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(919, 53, 'Industrial Technology Development Institute Technical Services, Laboratory Summit', 'DOST-II, Cauayan City, Isabela', '2017-08-14', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(920, 53, 'Seminar-Workshop on Conformance to ISO 17025 Technical Requirements (Method Selection and Validation, Measurement of Uncertainty and QA/QC Control Charts)', 'Analytical Solutions & Technical Services', '2016-10-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(921, 53, 'Seminar-Workshop on Measurement Uncertainty in Routine Chemical Analysis', 'FNRI', '2016-09-08', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(922, 53, 'Training-Workshop on Method Validation and Measurement Uncertainty', 'FNRI', '2016-07-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(923, 53, 'A Special Lecture on Introduction to Shelf-life Testing of Food Products', 'Chemistry Department, Xavier University-Ateneo de Cagayan', '2015-01-05', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(924, 53, 'Freshmen Orientation and General Assembly', 'Polytechnic University of the Philippines Chemical Society', '2015-06-25', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(925, 53, 'Careers in Science and Research, 7th DOST Scholars’ Summit (NCR)', 'UP Diliman', '2015-05-28', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(926, 53, 'National Chemistry Students’ Congress, Philippine Association of Chemistry Students (PACS)', 'De La Salle University', '2015-05-21', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(927, 53, 'Orientation and Training on Sample Receiving and Preparation for Referral to DOST- RDI’s Testing Laboratories', 'Taguig City and Cebu City', '2014-12-03', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(928, 53, 'Testimony on the Use of the Microwave Plasma-Atomic Emission Spectrophotometer, Agilent Spectroscopic Solution Seminar', 'Molave Trading, Inc., Quezon City', '2014-04-23', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(929, 53, 'Uban Kauban: Region X DOST-SEI Scholars’ Fellowship', 'Misamis Oriental', '2014-02-16', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(930, 53, 'Testimony on the Use of the Microwave Plasma-Atomic Emission Spectrophotometer, Agilent Spectroscopic Solution Seminar', 'Molave Trading, Inc., Cagayan de Oro City', '2013-10-04', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(931, 53, 'Career Orientation on Scholarship Grants and Job Opportunities', 'St. Mary’s Academy of Jasaan, Misamis Oriental', '2013-07-18', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(932, 53, 'Seniors’ Career Orientation, Corpus Christi School High School Department', 'Cagayan de Oro City', '2013-07-11', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(933, 53, 'Youth Expectation: Second Northern Mindanao Career Advocacy Congress', 'DOLE, Cagayan de Oro City', '2013-05-24', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(934, 53, 'Experiences as DOST Scholar-Graduate, DOST-SEI Region X Scholarship Orientation Oath Taking, and Signing of Scholarship Contract', 'Cagayan de Oro City', '2013-04-30', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(935, 53, 'Guest Speaker in Juniors and Seniors Prom', 'Liceo de Cagayan University High School, Cagayan de Oro City', '2013-02-15', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(936, 53, 'Orientation/Briefing on DOST-X and Its Projects, Programs and Services', 'DOST-X, Cagayan de Oro City', '2012-04-25', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(937, 53, 'Career Guidance Seminar', 'Philippine Science High School-Central Mindanao Campus, Lanao del Norte', '2013-03-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(938, 53, 'Inspirational Speaker at Xavier University Chemistry Society General Assembly', 'Cagayan de Oro City', '2011-06-29', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(939, 53, 'Experiences as DOST Scholar-Graduate', 'DOST-SEI Region X Scholarship Orientation Oath Taking, and Signing of Scholarship Contract, Cagayan de Oro City', '2011-04-26', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(940, 53, 'Guest Speaker in the 65th Graduation Exercises', 'Iponan Elementary School, Cagayan de Oro City', '2011-04-01', 0, '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(941, 39, '2024 Job Hunting and Exit Conference', 'New Town Plaza, Baguio City', '2024-06-20', 3, '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(942, 39, 'Career Guidance Orientation', 'Easter College, Inc.', '2024-05-06', 2, '2025-10-24 00:42:31', '2025-10-24 00:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `rs_work_experiences`
--

CREATE TABLE `rs_work_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rs_id` bigint(20) UNSIGNED NOT NULL,
  `date_started` date DEFAULT NULL,
  `date_ended` date DEFAULT NULL,
  `name_company` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rs_work_experiences`
--

INSERT INTO `rs_work_experiences` (`id`, `rs_id`, `date_started`, `date_ended`, `name_company`, `address`, `division`, `position`, `created_at`, `updated_at`) VALUES
(202, 60, '2023-01-01', '2025-10-22', 'Saint Louis University', 'Bonifacio Street,  Baguio City', 'Center for Counseling and Wellness', 'Director', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(203, 60, '2018-01-01', '2023-01-01', 'Saint Louis University', 'Bonifacio Street,  Baguio City', 'Department of Psychology', 'Department Head', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(204, 60, '2013-01-01', '2017-01-01', 'Saint Louis University', 'Bonifacio Street,  Baguio City', 'Guidance Center (now Center for Counseling & Wellness', 'Guidance Counselor', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(205, 60, '1999-01-01', '2013-01-01', 'Saint Louis School Center', 'Naguilian Road,  Baguio City', 'Guidance Office', 'Guidance Coordinator', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(206, 60, '1994-01-01', '1999-01-01', 'Saint Louis School Center', 'Assumption Road, Baguio City', 'Directress Office', 'Executive Secretary to the Directress', '2025-10-21 22:21:31', '2025-10-21 22:21:31'),
(257, 54, '2024-01-01', '2025-10-21', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Assistant', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(258, 54, '2023-01-01', '2023-12-31', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Assistant', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(259, 54, '2022-02-21', '2022-12-31', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Assistant', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(260, 54, '2022-01-02', '2022-02-20', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Specialist I', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(261, 54, '2018-01-03', '2021-12-22', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Specialist I', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(262, 54, '2017-06-01', '2017-12-27', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Specialist I', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(263, 54, '2017-01-03', '2017-05-21', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Analyst', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(264, 54, '2016-02-09', '2016-12-27', 'PhilMech', 'Nueva Ecija', 'Engineering and Development Division', 'Science Research Analyst', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(265, 54, '2013-01-01', '2013-10-31', 'Padilona Rockworld Corporation', 'N/A', 'N/A', 'Administrative and Finance Officer', '2025-10-21 22:57:13', '2025-10-21 22:57:13'),
(306, 55, '2024-06-27', '2024-12-12', 'Casiklan Wheels Farmers Association Inc./ Tesda', 'Casiklan Las Nieves Agusan Del Norte', 'N/A', 'Trainer for Coffee Production Level II Under Tulong Trabaho Scholarship Program of Tesda', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(307, 55, '2024-07-29', '2024-07-31', 'Agricultural Training Institute', 'Marcius Ave, Trece Martires, Cavite', 'N/A', 'Resource Person  for Training on Coconut-Coffee Farming System', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(308, 55, '2020-04-01', '2023-02-15', 'Simbalan National High School', 'Buenavista Agusan Del Norte', 'N/A', 'Substitute Teacher', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(309, 55, '2020-10-01', '2022-07-31', 'Lawan-Lawan National High School', 'Buenavista Agusan Del Norte', 'N/A', 'Assistant Teacher', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(310, 55, '2019-06-10', '2020-09-30', 'Casiklan National High School', 'Casiklan Las Nieves Agusan Del Norte', 'N/A', 'Teacher', '2025-10-21 23:52:32', '2025-10-21 23:52:32'),
(351, 56, '2023-01-01', '2025-10-22', 'Deparment of Agriculture-Philippine Center for Postharvest Development and Merchanization (PhilMech)', 'Science City of Muñoz, Nueva Ecija', 'Engineering and Development Division', 'Science Research Specialist II', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(352, 56, '2017-07-02', '2022-12-31', 'Deparment of Agriculture-Philippine Center for Postharvest Development and Merchanization (PhilMech)', 'Science City of Muñoz, Nueva Ecija', 'Engineering and Development Division', 'Science Research Specialist II', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(353, 56, '2010-03-23', '2017-07-01', 'Deparment of Agriculture-Philippine Center for Postharvest Development and Merchanization (PhilMech)', 'Science City of Muñoz, Nueva Ecija', 'Engineering and Development Division', 'Planning Officer II', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(354, 56, '1998-03-24', '2010-03-22', 'Department of Agriculture-Bureau of Postharvest Research and Extension', 'Science City of Muñoz, Nueva Ecija', 'Engineering and Development Division', 'Project Development Officer I', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(355, 56, '1996-04-15', '1998-03-28', 'Department of Agriculture-Bureau of Postharvest Research and Extension', 'Science City of Muñoz, Nueva Ecija', 'Engineering and Development Division', 'Research Analyst', '2025-10-22 00:42:28', '2025-10-22 00:42:28'),
(357, 57, '2021-01-01', '2025-10-22', 'TUP Manila', 'Manila', 'Food and Apparel Technology Dept.', 'Program Coordinator', '2025-10-22 00:48:58', '2025-10-22 00:48:58'),
(424, 61, '2009-01-01', '2011-01-01', 'V.V. Soliven Group of Companies', 'N/A', 'N/A', 'Senior Architect', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(425, 61, '2014-01-01', '2025-10-24', 'Basconcept Construction Co.', 'N/A', 'N/A', 'Principal Architect / Owner', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(426, 61, '2018-01-01', '2025-10-24', 'Sustainable Planning Initiative Corp', 'N/A', 'N/A', 'Planning Specialist / Owner', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(427, 61, '2018-01-01', '2022-01-01', 'N/A', 'City of General Trias, Cavite', 'N/A', 'Environmental Sector and CDRA Specialist (Updating of the EP and CDRA)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(428, 61, '2019-01-01', '2019-01-01', 'DILG-UP SURP', 'N/A', 'N/A', 'Economic Sector Documenter (Expanding Capacities for CDP Through SUC and LRI)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(429, 61, '2019-01-01', '2020-01-01', 'N/A', 'Municipality of Famy, Laguna', 'RSDPI', 'Infrastructure Sector Specialist (Updating of the EP, CLUP, and CDP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(430, 61, '2020-01-01', '2020-01-01', 'N/A', 'Municipality of Taytay, Riza', 'N/A', 'Technical Assistant on CDRA Formulation (Updating of CDRA)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(431, 61, '2020-01-01', '2021-01-01', 'N/A', 'Municipality of General Luna, Quezon', 'RSDPI', 'Infrastructure Sector and CDRA Specialist (Updating of EP, CDRA, and CLUP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(432, 61, '2020-01-01', '2022-01-01', 'N/A', 'City of General Trias, Cavite', 'RSDPI', 'Assistant Team Leader for Contingency Planning (Updating of the CDP, DRRMP, and CP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(433, 61, '2020-01-01', '2022-01-01', 'N/A', 'Municipality of Abra de Ilog, Occidental Mindoro', 'RSDPI', 'Infrastructure Sector and CDRA Specialist (Updating of EP, CDRA, and CLUP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(434, 61, '2020-01-01', '2022-01-01', 'N/A', 'City of Borongan, Eastern Samar', 'RSDPI', 'Infrastructure Sector and Transport Planning Specialist (Updating of EP, CLUP, CDP, TrDP, TDP, LCCAP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(435, 61, '2020-01-01', '2022-01-01', 'Urban Engineers', 'N/A', 'N/A', 'RAP Specialist (MRRB Project)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(436, 61, '2020-01-01', '2023-01-01', 'N/A', 'Municipality of Ragay, Camarines Sur', 'RSDPI', 'Team Leader and CDRA Specialist (Updating of EP, CDRA, and CLUP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(437, 61, '2021-01-01', '2022-01-01', 'Urban Engineers', 'N/A', 'N/A', 'RAP Specialist (Luzon Eastern Seaboard Project)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(438, 61, '2021-01-01', '2022-01-01', 'Urban Engineers', 'N/A', 'N/A', 'RAP Specialist (Bacolod-Victorias Project)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(439, 61, '2021-01-01', '2022-01-01', 'N/A', 'City of Pasig', 'PLANADES', 'Social Development Sector Senior Planning Specialist (Updating of CDP and CLUP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(440, 61, '2021-01-01', '2022-01-01', 'UP Open University', 'N/A', 'N/A', 'Lecturer 2', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(441, 61, '2022-01-01', '2023-01-01', 'UP Open University', 'N/A', 'N/A', 'Lecturer 2', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(442, 61, '2022-01-01', '2023-01-01', 'Nickel Asia Corporation', 'N/A', 'RSDPI', 'Physical and Land Use Planning Specialist (Sustainable Master Development Plan)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(443, 61, '2022-01-01', '2023-01-01', 'UP SURP', 'N/A', 'N/A', 'Documenter (Professional Development Towards Post-Graduate Studies for State Universities and Colleges: Training on the Preparation of the Land Use Development and Infrastructure Plan)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(444, 61, '2022-01-01', '2023-01-01', 'N/A', 'City of Pasig', 'N/A', 'LCCAP Specialist (Updating of LCCAP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(445, 61, '2022-01-01', '2024-01-01', 'N/A', 'City of Ozamiz', 'PLANADES', 'Social Development Planning Specialist (Updating of CLUP and CDP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(446, 61, '2023-01-01', '2023-01-01', 'BEZA', 'N/A', 'RSDPI', 'Physical and Land Use Specialist (Master Development Plan of PFEZ)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(447, 61, '2023-01-01', '2025-01-01', 'N/A', 'City of Makati', 'RSDPI', 'Junior CDRA Associate (Updating of CLUP, ZO, CDP, and LDIP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(448, 61, '2023-01-01', '2023-01-01', 'N/A', 'City of Pasig', 'N/A', 'Social Development Sector Resource Person and Facilitator (Updating of EP and LDIP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(449, 61, '2023-01-01', '2025-01-01', 'N/A', 'City of Makati', 'RSDPI', 'Shelter Needs Specialist (Makati Shelter Plan)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(450, 61, '2023-01-01', '2025-10-24', 'Philippine Navy', 'N/A', 'UICI', 'Land Use Planner / Architect (Master Development Planning)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(451, 61, '2024-01-01', '2024-01-01', 'BEZA', 'N/A', 'RSDPI', 'RAP Specialist (Social Preparation and Impact Assessment)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(452, 61, '2024-01-01', '2025-10-24', 'N/A', 'City of Pasig', 'RSDPI', 'Environmental Sector Deputy Team Leader (Updating of EP, CDP, and LDIP)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(453, 61, '2025-01-01', '2025-10-24', 'MMDA', 'N/A', 'RSDPI', 'CDRA and Environmental Management Specialist (Metro Manila Regional Physical Framework Plan)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(454, 61, '2025-01-01', '2025-10-24', 'LLDA', 'N/A', 'RSDPI', 'Land Use Planner (Comprehensive Master Development Plan of Laguna Lake)', '2025-10-23 18:30:41', '2025-10-23 18:30:41'),
(471, 40, '2021-08-01', '2025-10-20', 'DOST PSHS-CARC', 'Irisan, Baguio City', 'Biology/Research', 'SST IV', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(472, 40, '2020-04-01', '2021-02-01', 'Kurashiki Amaki Senior High School', 'Kurashiki, Okoyama, Japan', 'Super Science High Designated', 'Assistant Research Teacher', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(473, 40, '2020-01-01', '2020-03-01', 'Hayashima Junior High School', 'Hayashima, Okoyama, Japan', 'N/A', 'Assistant Language Teacher (ALT)', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(474, 40, '2016-06-01', '2019-09-01', 'Baguio City National High School (BCNSHS)', 'Governor Pack Road, Baguio City', 'N/A', 'Junior/Senior High School Science Teacher', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(475, 40, '2014-06-01', '2016-05-01', 'Happy Hollow National High School', 'Baguio City', 'N/A', 'Junior High School Science Teacher', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(476, 40, '2013-06-01', '2014-03-01', 'Berkeley School', 'Baguio City', 'N/A', 'Junior High School Science Teacher', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(477, 40, '2013-01-01', '2013-03-01', 'University of Baguio Science High School', 'Baguio City', 'N/A', 'Laboratory Technician', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(478, 40, '2012-06-01', '2012-10-01', 'University of Pangasinan', 'Dagupan City', 'College of Arts and Sciences', 'University Instructor for Natural Science Subjects', '2025-10-23 18:39:05', '2025-10-23 18:39:05'),
(499, 62, '2002-01-01', '2003-05-30', 'Globalink Employment Services, Incorporated', 'N/A', 'N/A', 'Accountant', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(500, 62, '2003-06-01', '2004-05-30', 'DSWD FO VII-KALAHI-CIDSS', 'N/A', 'N/A', 'Municipal Roving Bookkeeper', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(501, 62, '2004-06-14', '2016-10-30', 'DSWD CO-KALAHI-CIDSS', 'N/A', 'N/A', 'Community Financial Analyst', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(502, 62, '2016-11-01', '2018-06-30', 'DSWD CO-KALAHI-CIDSS', 'N/A', 'N/A', 'National Financial Analyst', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(503, 62, '2018-01-01', '2018-09-30', 'Certeza Infosys Corporation', 'N/A', 'N/A', 'Sectoral Planner', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(504, 62, '2017-06-30', '2018-07-30', 'Comtechmart Enterprises', 'N/A', 'N/A', 'Economic and Institutional Sectors Planner', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(505, 62, '2018-08-10', '2019-06-30', 'TAM Planners', 'N/A', 'N/A', 'Junior Consultant for the Environmental Impact Study (EIS)', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(506, 62, '2018-10-01', '2019-03-31', 'Provincial Government of Aurora', 'N/A', 'N/A', 'Statistician', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(507, 62, '2018-12-12', '2018-12-31', 'Asian Development Bank (ADB)', 'N/A', 'N/A', 'CDD Financial Management Specialist', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(508, 62, '2019-04-01', '2020-05-31', 'Provincial Government of Camarines Norte', 'N/A', 'N/A', 'Planning Staff', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(509, 62, '2020-11-23', '2021-04-23', 'Urban Engineers', 'N/A', 'N/A', 'RAP Specialist', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(510, 62, '2021-03-31', '2024-12-31', 'Planning and Development Research Foundation, Inc. (PLANADES)', 'N/A', 'N/A', 'Project Coordinator and Junior Institutional Planner', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(511, 62, '2021-02-15', '2023-05-31', 'UP Open University', 'N/A', 'N/A', 'Senior Lecturer 1', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(512, 62, '2016-09-01', '2025-10-24', 'RURBAN Strategic Development Planners Inc', 'N/A', 'N/A', 'On Call Consultant (Sectoral Planner)', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(513, 62, '2021-08-01', '2025-10-24', 'UP Diliman', 'N/A', 'N/A', 'Senior Lecturer 1', '2025-10-23 18:50:30', '2025-10-23 18:50:30'),
(524, 41, '2024-03-16', '2025-10-20', 'Department of the Interior and Local Government - CAR', 'N/A', 'LGCDD', 'Development Management Officer IV', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(525, 41, '2023-11-01', '2024-03-15', 'Crimson Education Company', 'N/A', 'N/A', 'Academic Advisor for the Philippines', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(526, 41, '2021-10-16', '2023-10-31', 'Department of the Interior and Local Government - CAR', 'N/A', 'LGCDD', 'Development Management Officer IV', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(527, 41, '2013-01-16', '2021-09-30', 'University of Baguio', 'N/A', 'Political Science Dept.', 'College Instructor', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(528, 41, '2011-06-06', '2013-05-30', 'University of Baguio', 'N/A', 'STELA', 'Secretary to the Dean', '2025-10-23 18:57:39', '2025-10-23 18:57:39'),
(529, 42, '2022-08-16', '2023-08-16', 'Zero Waste Asia (Global Alliance for Incineration Alternatives)', 'Quezon City, PH', 'Asia Pacific team', 'Regional CB&T Officer', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(530, 42, '2020-08-30', '2022-01-10', 'Break Free from Plastic Movement', 'Quezon City, PH', 'Asia Pacific team', 'Network Organizer for Southeast Asia', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(531, 42, '2021-09-30', '2022-01-20', 'University of the Philippines Open University', 'Lagjuna, PH', 'Faculty of Education', 'Tutor', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(532, 42, '2021-05-10', '2021-09-20', 'Planbureau voor de Leefomgeving (PBL Netherlands Environmental Assessment Agency)', 'Hague, Netherlands', 'Nature, Landscapes, Diversity', 'Graduate Trainee', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(533, 42, '2017-07-20', '2019-06-16', 'Environmental Counselors Inc.', 'Pasig, PH', 'Environmental Services', 'Technical Services Manager', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(534, 42, '2017-09-20', '2019-06-16', 'Environmental Training Institute, Environmental Councelors Inc.', 'Pasig, PH', 'Environmental Training', 'Team Leader', '2025-10-23 19:07:47', '2025-10-23 19:07:47'),
(546, 63, NULL, NULL, 'DEVELOPMENT ACADEMY OF THE PHILIPPINES', 'N/A', 'N/A', 'PROJECT MANAGER', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(547, 63, NULL, NULL, 'CPYANGA ENVIRONMENTAL PLANNER', 'N/A', 'N/A', 'PROJECT COORDINATOR', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(548, 63, NULL, NULL, 'RURBAN STRATEGIC DEVELOPMENT PLANNERS INC', 'N/A', 'N/A', 'PLANNING ASSISTANT/ ASSOCIATE', '2025-10-23 19:27:33', '2025-10-23 19:27:33'),
(579, 45, '2022-07-22', '2025-10-20', 'National Economic and Development Authority-Cordillera Administrative Region (NEDA-CAR)', 'Leonard Wood Road, Baguio City', 'Project Development, Investment Programming and Budgeting Division', 'Economic Develoment Specialist II', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(580, 45, '2020-03-27', '2021-07-21', 'National Economic and Development Authority-Cordillera Administrative Region (NEDA-CAR)', 'Leonard Wood Road, Baguio City', 'Project Development, Investment Programming and Budgeting Division', 'Economic Develoment Specialist I', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(581, 45, '2015-08-12', '2020-03-26', 'National Economic and Development Authority-Cordillera Administrative Region (NEDA-CAR)', 'Leonard Wood Road, Baguio City', 'Finance and Administrative Division', 'Administrative Assistant III (Supply Officer)', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(582, 45, '2013-06-01', '2015-07-31', 'BSBT College, Inc.', 'Magsaysay Avenue, Baguio City', 'Administartive Department', 'Assistant Registrat', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(583, 45, '2012-08-01', '2013-05-31', 'BSBT College, Inc.', 'Magsaysay Avenue, Baguio City', 'Administartive Department', 'Acting HRM Officer', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(584, 45, '2011-08-01', '2012-07-31', 'BSBT College, Inc.', 'Magsaysay Avenue, Baguio City', 'Administartive Department', 'Executive Assistant', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(585, 45, '2010-06-16', '2011-07-31', 'BSBT College, Inc.', 'Magsaysay Avenue, Baguio City', 'Administartive Department', 'Assistant Registrat', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(586, 45, '2008-04-28', '2010-06-15', 'BSBT College, Inc.', 'Magsaysay Avenue, Baguio City', 'Administartive Department', 'Records Clerk', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(587, 45, '2003-03-23', '2007-03-23', 'DO & C Lending Services', 'Magsaysay Avenue, Baguio City', 'N/A', 'Administrative Assistant', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(588, 45, '2002-10-31', '2002-10-31', 'Saint Louis University - College of Medicine', 'A. Bonifacio Street, Baguio City', 'Office of the Dean', 'College Secretary', '2025-10-23 19:35:45', '2025-10-23 19:35:45'),
(589, 64, '2023-01-01', '2025-10-24', 'TAP-HSP,DCERP-CHE', 'UPLB,Los Baños,Laguna', 'TAP-HSP,DCERP-CHE', 'Science Research Analyst', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(590, 64, '2022-03-01', '2022-06-01', 'Municipality of Ormoc City', 'Ormoc City, Leyte', 'Situational Analysis for Disaster Risk Reduction Management Plan', 'Job Order', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(591, 64, '2021-03-01', '2021-11-01', 'Municipality of Calauan', 'Calauan, Laguna', 'Formulation of the Comprehensive Land Use Plan', 'Job Order', '2025-10-23 20:09:05', '2025-10-23 20:09:05'),
(592, 65, '2025-01-01', '2025-10-24', 'LAGUNA LAKE DEVELOPMENT AUTHORITY', 'N/A', 'N/A', 'DEPUTY SPATIAL DEVELOPMENT AND ENVIRONMENTAL MANAGEMENT SPECIALIST', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(593, 65, '2025-01-01', '2025-10-24', 'BANGSAMORO ECO ZONE AUTHORITY', 'N/A', 'N/A', 'PROJECT COORDINATOR AND INFRASTRUCTURE DEVELOPMENT SPECIALIST', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(594, 65, '2025-01-01', '2025-10-24', 'METRO MANILA DEVELOPMENT AUTHORITY', 'N/A', 'N/A', 'INFRASTRUCTURE AND TRANSPORTATION JUNIOR SPECIALIST', '2025-10-23 21:21:02', '2025-10-23 21:21:02'),
(595, 65, '2024-01-01', '2025-10-24', 'CITY GOVERNMENT OF PASIG', 'N/A', 'N/A', 'SECTORAL TEAM LEADER 4 (INFRASTRUCTURE', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(596, 65, '2024-01-01', '2024-01-01', 'MINISTRY OF TRADE, INVESTMENT, AND TOURISM', 'N/A', 'N/A', 'PROJECT COORDINATOR and INFRASTRUCTURE DEVELOPMENT PLANNER', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(597, 65, '2021-01-01', '2022-01-01', 'CITY GOVERNMENT OF MAKATI', 'N/A', 'N/A', 'INFRASTRUCTURE AND UTILITIES PLANNER', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(598, 65, '2023-01-01', '2025-01-01', 'CITY GOVERNMENT OF MAKATI', 'N/A', 'N/A', 'INFRASTRUCTURE DEVELOPMENT ASSOCIATE', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(599, 65, '2021-01-01', '2022-01-01', 'CITY GOVERNMENT OF PASIG', 'N/A', 'N/A', 'ECONOMIC SECTOR FACILITATOR', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(600, 65, '2022-01-01', '2023-01-01', 'MINISTRY OF TRADE, INVESTMENT, AND TOURISM (MTIT - BARMM', 'N/A', 'N/A', 'INFRASTRUCTURE DEVELOPMENT SPECIALIST', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(601, 65, '2022-01-01', '2023-01-01', 'CITY GOVERNMENT OF OZAMIZ', 'N/A', 'N/A', 'INFRASTRUCTURE DEVELOPMENT SPECIALIST', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(602, 65, '2022-01-01', '2022-01-01', 'CITY GOVERNMENT OF PASIG', 'N/A', 'N/A', 'FACILITATOR', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(603, 65, '2022-01-01', '2022-01-01', 'UP SYSTEM', 'N/A', 'N/A', 'DOCUMENTER', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(604, 65, '2020-01-01', '2023-01-01', 'LOCAL GOVERNMENT UNIT OF RAGAY, CAMARINES SUR', 'N/A', 'N/A', 'INFRASTRUCTURE DEVELOPMENT PLANNING SPECIALIST', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(605, 65, '2019-01-01', '2019-01-01', 'DILG-UP SURP', 'N/A', 'N/A', 'INFRASTRUCTURE SECTOR DOCUMENTER', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(606, 65, '2012-01-01', '2012-01-01', 'LOCAL GOVERNMENT UNIT OF VICTORIA, TARLAC', 'N/A', 'N/A', 'INFRASTRUCTURE DEVELOPMENT PLANNING SPECIALIST', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(607, 65, '2021-10-01', '2022-09-30', 'MUNICIPAL GOVERNMENT OF STA. CRUZ, MARINDUQUE', 'N/A', 'N/A', 'MUNICIPAL PLANNING AND DEVELOPMENT COORDINATOR', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(608, 65, '2020-10-01', '2021-09-30', 'MUNICIPAL GOVERNMENT OF STA. CRUZ, MARINDUQUE', 'N/A', 'N/A', 'MUNICIPAL PLANNING AND DEVELOPMENT COORDINATOR', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(609, 65, '2018-01-01', '2018-02-28', 'DEPARTMENT OF PUBLIC WORKS AND HIGHWAYS REGION IV-B (MIMAROPA)', 'N/A', 'N/A', 'ENGINEER II', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(610, 65, '2015-08-16', '2017-12-31', 'DEPARTMENT OF PUBLIC WORKS AND HIGHWAYS REGION IV-B (MIMAROPA)', 'N/A', 'N/A', 'ENGINEER II', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(611, 65, '2012-08-16', '2015-08-15', 'DEPARTMENT OF PUBLIC WORKS AND HIGHWAYS REGION IV-B (MIMAROPA)', 'N/A', 'N/A', 'ENGINEER II', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(612, 65, '2010-01-03', '2011-01-06', 'GOLDEN ABC', 'N/A', 'N/A', 'PROJECT MANAGEMENT SPECIALIST', '2025-10-23 21:21:03', '2025-10-23 21:21:03'),
(613, 66, '1994-01-01', '2025-10-24', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'President', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(614, 66, '1998-05-01', '2025-10-24', 'School of Urban and Regional Planning, University of the Philippines - Diliman', 'N/A', 'N/A', 'Assistant Professor', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(615, 66, '1994-10-01', '1997-11-01', 'School of Urban and Regional Planning, University of the Philippines - Diliman', 'N/A', 'N/A', 'University Researcher I', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(616, 66, '1989-07-01', '1994-01-01', 'School of Urban and Regional Planning, University of the Philippines - Diliman', 'N/A', 'N/A', 'University Research Associate II', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(617, 66, '1981-02-02', '1988-01-01', 'School of Urban and Regional Planning, University of the Philippines - Diliman', 'N/A', 'N/A', 'Research Assistant', '2025-10-23 22:10:59', '2025-10-23 22:10:59'),
(640, 67, '2024-01-02', '2025-10-24', 'National Economic And Development Authority', 'N/A', 'N/A', 'Chief Economic Development Specialist', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(641, 67, '2021-10-15', '2024-01-31', 'National Economic And Development Authority', 'N/A', 'N/A', 'Supervising Economic Development Specialist', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(642, 67, '2019-06-20', '2021-10-14', 'National Economic And Development Authority', 'N/A', 'N/A', 'Senior Economic Development Specialist', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(643, 67, '2017-07-28', '2019-06-19', 'National Economic And Development Authority', 'N/A', 'N/A', 'Economic Development Specialist II', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(644, 67, '2015-07-16', '2017-07-27', 'National Economic And Development Authority', 'N/A', 'N/A', 'RDC And External Linkages Coordinator', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(645, 67, '2012-04-09', '2015-07-15', 'Intercontinental Hotels Group', 'N/A', 'N/A', 'Reservations Sales Specialist', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(646, 67, '2011-06-01', '2011-10-01', 'University of Baguio', 'N/A', 'N/A', 'College Instructor', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(647, 67, '2009-08-25', '2011-02-15', 'Department of Trade and Industry', 'N/A', 'N/A', 'Planning Assistant', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(648, 67, '2009-05-05', '2009-06-30', 'National Food Authority', 'N/A', 'N/A', 'Clerk-Cashier Section', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(649, 67, '2008-05-01', '2008-10-01', 'Center for Technical Excellence Integrated School, Inc.', 'N/A', 'N/A', 'Assistant Training Department Head', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(650, 67, '2008-12-09', '2008-04-30', 'Center for Technical Excellence Integrated School, Inc.', 'N/A', 'N/A', 'Medical Transcription Coach/Instructor', '2025-10-23 22:35:45', '2025-10-23 22:35:45'),
(656, 68, '2018-07-02', '2025-10-24', 'LAND CRIS SOMERSET DEVELOPMENT CORP', 'N/A', 'N/A', 'SENIOR PROJECT DEVELOPMENT OFFICER', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(657, 68, '2024-07-01', '2025-10-24', 'CITY GOVERNMENT OF PASIG THROUGH RURBAN STRATEGIC DEVELOPMENT PLANNERS INC (RSDPI)', 'N/A', 'N/A', 'RESEARCH ASSISTANT / DOCUMENTER 11 (INSTITUTIONAL)', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(658, 68, '2023-12-01', '2025-03-01', 'CITY GOVERNMENT OF MAKATI THROUGH RURBAN STRATEGIC DEVELOPMENT PLANNERS INC', 'N/A', 'N/A', 'AFFORDABILITY NEEDS AND OPTIONS SPECIALIST', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(659, 68, '2021-07-01', '2022-08-01', 'DEPARTMENT OF PUBLIC WORKS AND HIGHWAYS THROUGH URBAN ENGINEERS (UE) AND RURBAN STRATEGIC PLANNERS DEVELOPMENT INC', 'N/A', 'N/A', 'PLANNING ASSOCIATE', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(660, 68, '2021-04-01', '2022-06-01', 'LOCAL GOVERNMENT OF GENERAL LUNA THROUGH RURBAN STRATEGIC DEVELOPMENT PLANNERS INC', 'N/A', 'N/A', 'SOCIAL SECTOR PLANNING SPECIALIST', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(661, 68, '2021-04-01', '2022-10-01', 'CITY GOVERNMENT OF PASIG THROUGH PLANADES', 'N/A', 'N/A', 'JUNIOR PLANNING CONSULTANT', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(662, 68, '2020-03-01', '2023-03-01', 'MUNICIPAL GOVERNMENT OF RAGAY THROUGH RURBAN STRATEGIC DEVELOPMENT PLANNERS INC', 'N/A', 'N/A', 'SOCIAL SECTOR PLANNING SPECIALIST', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(663, 68, '2020-11-01', '2022-08-01', 'DEPARTMENT OF PUBLIC WORKS AND HIGHWAYS THROUGH URBAN ENGINEERS (UE) AND RURBAN STRATEGIC PLANNERS DEVELOPMENT INC', 'N/A', 'N/A', 'PLANNING ASSOCIATE', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(664, 68, '2019-09-01', '2020-09-01', 'DEPARTMENT OF PUBLIC WORKS AND HIGHWAYS THROUGH URBAN ENGINEERS (UE) AND RURBAN STRATEGIC PLANNERS DEVELOPMENT INC', 'N/A', 'N/A', 'PLANNING ASSOCIATE', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(665, 68, '2019-03-01', '2022-03-01', 'MUNICIPAL GOVERNMENT OF FAMY THROUGH RURBAN STRATEGIC DEVELOPMENT PLANNERS INC', 'N/A', 'N/A', 'SOCIAL SECTOR PLANNING SPECIALIST', '2025-10-23 22:47:25', '2025-10-23 22:47:25'),
(694, 49, '2022-03-16', '2025-10-20', 'DepEd School Division of Abra', 'Bangued, Abra', 'Abra High School', 'Teacher III', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(695, 49, '2021-12-01', '2022-03-15', 'DepEd School Division of Abra', 'Bangued, Abra', 'Abra High School', 'Teacher II', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(696, 49, '2017-06-27', '2021-11-01', 'DepEd School Division of Abra', 'Bangued, Abra', 'Abra High School', 'Teacher I', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(697, 49, '2015-06-08', '2015-12-31', 'DSWD-CAR', 'Benguet', 'N/S', 'Administrative Assistant', '2025-10-23 23:09:46', '2025-10-23 23:09:46'),
(719, 69, '2025-05-01', '2025-10-24', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Deputy Team Leader for the Environmental Impact Statement', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(720, 69, '2025-03-01', '2026-03-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Climate and Disaster Risk Specialist for the Formulation of the Comprehensive', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(721, 69, '2024-12-01', '2025-12-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Junior Climate and Disaster Risk Specialist', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(722, 69, '2024-08-01', '2026-01-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Project Coordinator and Environmental Development Planner', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(723, 69, '2024-01-01', '2024-06-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Social and Environmental Planner for the formulation of the Environmental', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(724, 69, '2024-01-04', '2024-12-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Planning Specialist / Climate and Disaster Risk Specialist', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(725, 69, '2023-12-01', '2025-10-24', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Shelter Needs Specialist for the Updating/Formulation of the Makati', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(726, 69, '2023-04-01', '2024-11-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Research Associate for the Updating/Formulation of the Zoning', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(727, 69, '2023-03-01', '2025-10-24', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Environmental Development Planner for the Updating/Formulation', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(728, 69, '2023-03-01', '2025-04-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Environmental Management Associate for the Formulation', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(729, 69, '2022-12-01', '2023-12-01', 'Rurban Strategic Development Planners Inc', 'N/A', 'N/A', 'Planning Specialist / Climate and Disaster Risk Specialist', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(730, 69, '2022-10-01', '2024-11-01', 'Rurban Strategic Development Planners Inc', 'N/A', 'N/A', 'Climate and Disaster Risk Specialist for the Formulation of the Climate', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(731, 69, '2022-04-01', '2022-12-01', 'Envia Consultancy', 'N/A', 'N/A', 'Technical Consultant for the Formulation of the Local Shelter Plan', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(732, 69, '2022-01-01', '2022-12-01', 'Rurban Strategic Development Planners Inc', 'N/A', 'N/A', 'Planning Specialist for the Formulation of the Master Development Plan', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(733, 69, '2020-07-01', '0001-01-01', 'Rurban Strategic Development Planners Inc', 'N/A', 'N/A', 'Planning Specialist / Climate and Disaster Risk Specialist', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(734, 69, '2020-04-01', '2022-12-01', 'Envia Consultancy', 'N/A', 'N/A', 'Technical Consultant', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(735, 69, '2020-02-01', '2021-12-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Planning Specialist / Climate and Disaster Risk Specialist', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(736, 69, '2020-02-01', '2023-12-01', 'Rurban Strategic Development Planners Inc.', 'N/A', 'N/A', 'Planning Specialist / Climate and Disaster Risk Specialist', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(737, 69, '2019-03-01', '2020-12-01', 'PLANADES', 'N/A', 'N/A', 'Project Coordinator/Junior Consultant', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(738, 69, '2019-01-01', '2019-04-01', 'PHILKOEI International Inc. & TAM Planners Co.', 'N/A', 'N/A', 'Research Associate', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(739, 69, '2018-02-01', '0001-01-01', '260 Inc.', 'N/A', 'N/A', 'Head Researcher', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(740, 69, '2017-09-01', '2019-01-01', 'PLANADES', 'N/A', 'N/A', 'Junior Consultant', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(741, 69, '2017-04-01', '2018-07-01', 'PLANADES', 'N/A', 'N/A', 'Research Associate', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(742, 69, '2017-04-01', '2017-12-01', 'UP NCPAG', 'N/A', 'N/A', 'Project Researcher', '2025-10-23 23:34:39', '2025-10-23 23:34:39'),
(813, 51, '2016-06-30', '2023-09-22', 'DOST-National Capital Region', 'Bicutan, Taguig', 'Technical Support Services', 'Senior Science Research Specialist cum Food Safety Program Manager (Retired)', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(814, 51, '2012-01-01', '2016-10-31', 'DOST-National Capital Region', 'Bicutan, Taguig', 'Technical Support Services', 'Science Research Associate', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(815, 51, '1990-01-01', '2010-06-30', 'DOST-Industrial Technology Development Institute', 'Bicutan, Taguig', 'Food Proccessing Division', 'Senior Science Research Specialist', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(816, 51, '1989-01-06', '1990-09-30', 'DOST-Industrial Technology Development Institute', 'Bicutan, Taguig', 'Food Proccessing Division', 'Science Research Specialist II', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(817, 51, '1987-01-01', '1989-05-31', 'DOST-Industrial Technology Development Institute', 'Bicutan, Taguig', 'Food Proccessing Division', 'Science Research Specialist I', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(818, 51, '1984-02-04', '1986-12-31', 'National Institute of Science and Technology', 'N/A', 'N/A', 'Science Research Specialist I', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(819, 51, '1984-01-01', '1984-03-31', 'National Science and Technology Authority-ASEAN-Australia Economic Cooperation Program\'s Food Technology Research and Development Project', 'N/A', 'N/A', 'Science Research Associate I', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(820, 51, '1983-01-03', '1983-12-31', 'National Science and Technology Authority-ASEAN-Australia Economic Cooperation Program\'s Food Technology Research and Development Project', 'N/A', 'N/A', 'Science Research Assistant II', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(821, 51, '1982-04-01', '1983-02-28', 'National Institute of Science and Technology', 'N/A', 'N/A', 'Science Research Assistant I', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(822, 51, '1981-01-05', '1981-12-31', 'National Institute of Science and Technology', 'N/A', 'N/A', 'Emergency Employee', '2025-10-23 23:56:56', '2025-10-23 23:56:56'),
(823, 70, '2025-01-01', '2025-10-24', 'Department of Trade and Industry - CAR', 'N/A', 'N/A', 'Senior Trade and Industry Development Specialist', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(824, 70, '2024-01-15', '2024-12-30', 'Department of Trade and Industry - CAR', 'N/A', 'N/A', 'Senior Trade and Industry Development Specialist', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(825, 70, '2023-01-01', '2024-01-14', 'Department of Trade and Industry - CAR', 'N/A', 'N/A', 'Senior Trade and Industry Development Specialist', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(826, 70, '2022-01-01', '2022-12-30', 'Department of Trade and Industry - CAR', 'N/A', 'N/A', 'Senior Trade and Industry Development Specialist', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(827, 70, '2021-01-01', '2021-12-31', 'Department of Trade and Industry - CAR', 'N/A', 'N/A', 'Senior Trade and Industry Development Specialist', '2025-10-24 00:04:18', '2025-10-24 00:04:18'),
(900, 53, '2015-11-20', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'Senior Science Research Specialist', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(901, 53, '0214-09-08', '2015-11-19', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'Science Research Specialist II', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(902, 53, '2021-10-25', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'Quality Manager', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(903, 53, '2021-10-22', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'ITDI CPD Manager', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(904, 53, '2016-07-05', '2021-10-25', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'Document and Information Controller', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(905, 53, '2014-12-03', '2017-02-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'Deputy Quality Manager', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(906, 53, '2014-12-03', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Standards and Testing Division (STD)', 'Internal Quality Auditor', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(907, 53, '2014-11-17', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'STD-ITDI’s Marketing and Promotions Committee', 'Chair', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(908, 53, '2018-07-02', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'STD-ITDI’s Technical Service Continuity Strategy Incident Response Team', 'Communications Manager', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(909, 53, '2021-10-25', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'STD-ITDI’s Writers’ Pool Committee', 'Chairperson', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(910, 53, '2020-07-01', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Inorganic Chemistry Section, Chemistry Laboratory', 'Technical Manager', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(911, 53, '2020-07-01', '2025-10-21', 'Industrial Technology Development Institute (ITDI)', 'DOST Compound, Gen. Santos Avenue, Bicutan, Taguig City, Metro Manila', 'Inorganic Chemistry Section, Chemistry Laboratory', 'Section Head', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(912, 53, '2013-03-18', '2014-04-15', 'DOST-X', 'J.V. Seriña St., Carmen, Cagayan de Oro City', 'Regional Standards and Testing Laboratories', 'Document Custodian', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(913, 53, '2011-06-30', '2014-04-15', 'DOST-X', 'J.V. Seriña St., Carmen, Cagayan de Oro City', 'Chemical Testing Laboratory', 'Deputy Technical Manager', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(914, 53, '2012-01-02', '2014-04-15', 'DOST-X', 'J.V. Seriña St., Carmen, Cagayan de Oro City', 'Chemical Testing Laboratory', 'Science Research Specialist II', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(915, 53, '2011-07-01', '2011-12-29', 'DOST-X', 'J.V. Seriña St., Carmen, Cagayan de Oro City', 'Chemical Testing Laboratory', 'Science Research Specialist I', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(916, 53, '2011-03-01', '2011-06-30', 'DOST-X', 'J.V. Seriña St., Carmen, Cagayan de Oro City', 'Chemical Testing Laboratory', 'Science Research Analyst', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(917, 53, '2011-02-08', '2011-02-28', 'DOST-X', 'J.V. Seriña St., Carmen, Cagayan de Oro City', 'Chemical Testing Laboratory', 'Science Research Assistant I', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(918, 53, '2012-11-01', '2013-03-01', 'Xavier University-Ateneo de Cagayan', 'Corrales Avenue, Cagayan de Oro City', 'Department of Chemistry', 'Lecturer Assistant Instructor for Organic Chemistry  (Part-time)', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(919, 53, '2011-06-01', '2013-10-01', 'Xavier University-Ateneo de Cagayan', 'Corrales Avenue, Cagayan de Oro City', 'Department of Chemistry', 'Lecturer Assistant Instructor for General Chemistry  (Part-time)', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(920, 53, '2012-06-01', '2013-10-01', 'University of Science and Technology in Southern Philippines (formerly Mindanao University of Science and Technology)', 'Claro M. Recto Avenue, Lapasan, Cagayan de Oro City', 'Department of Chemistry', 'Instructor I for Biochemistry, Quantum Chemistry and Spectroscopy  (Part-time)', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(921, 53, '2012-12-01', '2013-03-01', 'University of Science and Technology in Southern Philippines (formerly Mindanao University of Science and Technology)', 'Claro M. Recto Avenue, Lapasan, Cagayan de Oro City', 'Department of Chemistry', 'Instructor I for Physical Chemistry  (Part-time)', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(922, 53, '2013-06-01', '2013-10-01', 'University of Science and Technology in Southern Philippines (formerly Mindanao University of Science and Technology)', 'Claro M. Recto Avenue, Lapasan, Cagayan de Oro City', 'Department of Chemistry', 'Instructor I for Physical Chemistry  (Part-time)', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(923, 53, '2014-11-01', '2014-03-01', 'University of Science and Technology in Southern Philippines (formerly Mindanao University of Science and Technology)', 'Claro M. Recto Avenue, Lapasan, Cagayan de Oro City', 'Department of Chemistry', 'Instructor I for Physical Chemistry  (Part-time)', '2025-10-24 00:34:36', '2025-10-24 00:34:36'),
(924, 39, '2018-07-02', '2025-10-20', 'PRC - CAR', 'Pine Lake View Bldg., B. Salvosa Drive, Otek St., Baguio City', 'Licensure and Registration Division - Application Section', 'Professional Regulation Officer III', '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(925, 39, '2014-12-29', '2018-07-01', 'PRC - CAR', 'Pine Lake View Bldg., B. Salvosa Drive, Otek St., Baguio City', 'Licensure and Registration Division - Application Section', 'Administrative Assistant I', '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(926, 39, '2003-02-05', '2024-12-29', 'PRC - CAR', 'Court of Appeals Bldg., Upper Seesion Road Ext., Baguio City', 'Licensure Division', 'Staff Assistant', '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(927, 39, '2000-02-20', '2002-05-20', 'Baguio Long Live Corp.', 'Guisad Road, Baguio City', 'Key Accounts', 'Billing Clerk', '2025-10-24 00:42:31', '2025-10-24 00:42:31'),
(928, 39, '1997-11-17', '1999-10-31', 'University of Baguio (UB)', 'General Luna Road, Baguio City', 'College of Commerce', 'Instructor', '2025-10-24 00:42:31', '2025-10-24 00:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'MIS', '2024-10-16 16:59:22', '2024-10-16 17:00:09'),
(2, 'Records', '2024-10-16 16:59:55', '2025-07-07 00:09:23'),
(3, 'Planning', '2025-02-25 18:05:17', '2025-02-25 18:05:17'),
(4, 'RRDIC', '2025-02-25 18:05:41', '2025-02-25 18:05:41'),
(5, 'R & D', '2025-03-03 23:31:38', '2025-03-03 23:32:06'),
(6, 'LGIA', '2025-09-11 00:16:35', '2025-09-11 00:16:35'),
(7, 'SETUP', '2025-09-11 00:16:48', '2025-09-11 00:16:48'),
(8, 'SSCP', '2025-09-11 00:17:09', '2025-09-11 00:17:09'),
(9, 'S & T Promo', '2025-09-11 00:17:43', '2025-09-11 00:17:43'),
(10, 'Scholarship', '2025-09-11 00:18:05', '2025-09-11 00:18:05'),
(11, 'HRMO', '2025-09-11 00:18:36', '2025-09-11 00:18:36'),
(12, 'Procurement', '2025-09-11 00:18:57', '2025-09-11 00:18:57'),
(13, 'Budget', '2025-09-11 00:19:20', '2025-09-11 00:19:20'),
(14, 'Accounting', '2025-09-11 00:19:41', '2025-09-11 00:19:41'),
(15, 'Cashier', '2025-09-11 00:20:01', '2025-09-11 00:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groups` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_id`, `division`, `unit`, `province`, `region`, `groups`, `roles`, `firstname`, `middlename`, `lastname`, `gender`, `position`, `emp_type`, `username`, `email`, `email_verified_at`, `password`, `address`, `mobile_no`, `last_login`, `is_active`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, '69', NULL, NULL, NULL, NULL, NULL, NULL, 'Clint', NULL, 'Dyzher', NULL, NULL, NULL, 'clint007', 'clint007@gmail.com', NULL, '$2y$10$Wcr4W29uKpqFynrRiSOEGeH83/rY6LIrm1pUfJxSmR2VAXA9vB4G6', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-09-23 22:36:20', '2024-09-23 22:36:20'),
(7, 'B0801', 'TSD', 'R & D', 'Mountain Province', 'CAR', 'gfd', 'io', 'DYZHER CLINT', 'Angtan', 'BAB-ATING', '<--Select Gender-->', 'Project Technical Assistant II', '2', 'Clint', 'dostcarcest@gmail.com', NULL, '$2y$10$t3CzMlmbcpAQXgF1X2eBn.DppRxdIGLBrME8QtMl3tySdmx6dxLYe', 'mt. prov.', '09491255555', NULL, 1, NULL, NULL, NULL, '2024-10-03 21:33:34', '2025-07-07 00:14:25'),
(12, '963', 'TSD', 'Planning', 'ABRA', 'CAR', 'frghh', 'dfgciuoi', 'Hazel', 'K', 'Tayab', 'Female', 'Project Technical Assistant II', '0', 'hazel', 'hazel@gmail.com', NULL, '$2y$10$6gLCgfsLcrpi3vgEu16wAuhfgUYT/farXULRcFDwh.lp2R.zCdmhm', 'MT. prov.', '09491756325', NULL, 1, 'DkqGVgCJWX2VFiCUBPTxFcRk7wGsLnrcDM2Leh0SQx2RnxTVwicuFlzQYqXX', NULL, NULL, '2024-10-17 18:57:27', '2025-09-11 00:10:25'),
(14, 'd345', 'PSTO-Abra', 'MIS', 'Ifugao', 'qgyiu', NULL, NULL, 'Ryan', 'A', 'Againab', '<--Select Gender-->', 'Project Technical Assistant II', '2', 'Ryan', 'Ryan@gmail.com', NULL, '$2y$10$IOc92icFYIAc0PKGaUdRL.f7mNqhJF7YeSm9yjtqCPtTicLTCacne', 'MP', '09491297536', NULL, 1, NULL, NULL, NULL, '2025-06-19 00:30:59', '2025-07-07 18:34:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accreditations`
--
ALTER TABLE `accreditations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accreditations_rstbl_id_foreign` (`rstbl_id`);

--
-- Indexes for table `accreditation_averages`
--
ALTER TABLE `accreditation_averages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expertis`
--
ALTER TABLE `expertis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expertis_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_resource_speakers`
--
ALTER TABLE `request_resource_speakers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_resource_speakers_rstbl_id_foreign` (`rstbl_id`);

--
-- Indexes for table `rstbl`
--
ALTER TABLE `rstbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rstbl_email_unique` (`email`);

--
-- Indexes for table `rs_educational`
--
ALTER TABLE `rs_educational`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs_educational_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `rs_experience_trainer`
--
ALTER TABLE `rs_experience_trainer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs_experience_trainer_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `rs_publications`
--
ALTER TABLE `rs_publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs_publications_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `rs_references_trainings`
--
ALTER TABLE `rs_references_trainings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs_references_trainings_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `rs_training`
--
ALTER TABLE `rs_training`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs_training_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `rs_work_experiences`
--
ALTER TABLE `rs_work_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rs_work_experiences_rs_id_foreign` (`rs_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_emp_id_unique` (`emp_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accreditations`
--
ALTER TABLE `accreditations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accreditation_averages`
--
ALTER TABLE `accreditation_averages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expertis`
--
ALTER TABLE `expertis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `office`
--
ALTER TABLE `office`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `request_resource_speakers`
--
ALTER TABLE `request_resource_speakers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rstbl`
--
ALTER TABLE `rstbl`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `rs_educational`
--
ALTER TABLE `rs_educational`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=719;

--
-- AUTO_INCREMENT for table `rs_experience_trainer`
--
ALTER TABLE `rs_experience_trainer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2023;

--
-- AUTO_INCREMENT for table `rs_publications`
--
ALTER TABLE `rs_publications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1294;

--
-- AUTO_INCREMENT for table `rs_references_trainings`
--
ALTER TABLE `rs_references_trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT for table `rs_training`
--
ALTER TABLE `rs_training`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=943;

--
-- AUTO_INCREMENT for table `rs_work_experiences`
--
ALTER TABLE `rs_work_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=929;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accreditations`
--
ALTER TABLE `accreditations`
  ADD CONSTRAINT `accreditations_rstbl_id_foreign` FOREIGN KEY (`rstbl_id`) REFERENCES `rstbl` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expertis`
--
ALTER TABLE `expertis`
  ADD CONSTRAINT `expertis_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `office_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `request_resource_speakers`
--
ALTER TABLE `request_resource_speakers`
  ADD CONSTRAINT `request_resource_speakers_rstbl_id_foreign` FOREIGN KEY (`rstbl_id`) REFERENCES `rstbl` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rs_educational`
--
ALTER TABLE `rs_educational`
  ADD CONSTRAINT `rs_educational_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `rs_experience_trainer`
--
ALTER TABLE `rs_experience_trainer`
  ADD CONSTRAINT `rs_experience_trainer_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `rs_publications`
--
ALTER TABLE `rs_publications`
  ADD CONSTRAINT `rs_publications_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `rs_references_trainings`
--
ALTER TABLE `rs_references_trainings`
  ADD CONSTRAINT `rs_references_trainings_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `rs_training`
--
ALTER TABLE `rs_training`
  ADD CONSTRAINT `rs_training_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);

--
-- Constraints for table `rs_work_experiences`
--
ALTER TABLE `rs_work_experiences`
  ADD CONSTRAINT `rs_work_experiences_rs_id_foreign` FOREIGN KEY (`rs_id`) REFERENCES `rstbl` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
