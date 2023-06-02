-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2021 at 02:18 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `coa_accounts`
--

CREATE TABLE `coa_accounts` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coa_accounts`
--

INSERT INTO `coa_accounts` (`id`, `code`, `name`, `desc`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '001', 'AFOHS Club', NULL, 1, '2021-03-05 01:45:53', '2021-03-05 01:45:53', NULL, 2, 2, NULL),
(2, '001-001', 'AFOHS General', '001', 1, '2021-03-05 02:41:46', '2021-04-24 10:12:28', NULL, 2, 12, NULL),
(3, '002', 'Options Restaurant', NULL, 1, '2021-03-05 02:42:27', '2021-03-05 02:42:27', NULL, 2, 2, NULL),
(4, '003', 'Discover Pakistan', NULL, 1, '2021-03-05 02:42:37', '2021-03-05 02:42:37', NULL, 2, 2, NULL),
(5, '002-001', 'Options General', '002', 1, '2021-03-05 02:42:45', '2021-04-24 10:12:40', NULL, 2, 12, NULL),
(6, '003-001', 'Discover General', '003', 1, '2021-03-05 02:42:51', '2021-04-24 10:12:51', NULL, 2, 12, NULL),
(7, '004', 'Lahore Organic Villege', NULL, 1, '2021-03-06 02:23:21', '2021-03-24 10:39:12', NULL, 2, 2, NULL),
(9, '004-001', 'Lahore Organic General', '004', 1, '2021-03-06 02:23:46', '2021-04-24 10:13:08', NULL, 2, 12, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coa_accounts`
--
ALTER TABLE `coa_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `coa_accounts_code_unique` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coa_accounts`
--
ALTER TABLE `coa_accounts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
