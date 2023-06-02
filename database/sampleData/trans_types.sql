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
-- Table structure for table `trans_types`
--

CREATE TABLE `trans_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `mod_id` bigint DEFAULT NULL,
  `table_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_or_payment` tinyint(1) DEFAULT NULL COMMENT '0 for cash 1 for payment',
  `cashrec_due` date NOT NULL DEFAULT '2019-01-01',
  `account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_or_credit` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trans_types`
--

INSERT INTO `trans_types` (`id`, `name`, `type`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `mod_id`, `table_name`, `details`, `cash_or_payment`, `cashrec_due`, `account`, `debit_or_credit`) VALUES
(1, 'Room Booking', 1, '2020-06-15 11:41:58', '2021-04-07 15:00:32', NULL, 2, 15, NULL, NULL, 'room_booking', 'roomInvoice', 0, '2019-01-01', '810109', NULL),
(2, 'Events Management', 1, '2020-06-15 11:43:06', '2021-04-07 15:01:02', NULL, 2, 15, NULL, NULL, 'event_booking', 'eventInvoice', 0, '2019-01-01', '810112', NULL),
(3, 'Membership Fee', 1, '2020-06-15 11:43:59', '2021-04-07 15:01:25', NULL, 2, 15, NULL, NULL, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', '495000', NULL),
(4, 'Monthly Maintenance Fee', 1, '2020-06-15 11:45:21', '2021-04-07 15:01:44', NULL, 2, 15, NULL, NULL, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', '810110', NULL),
(5, 'Food and Beverage', 1, '2020-06-15 11:46:15', '2021-02-23 15:13:47', NULL, 2, 15, NULL, NULL, 'fnb_sale', 'salesInvoice', 0, '2019-01-01', NULL, NULL),
(6, 'Cake Bookings', 1, '2020-09-02 06:28:58', '2021-04-07 15:06:32', NULL, 2, 15, NULL, NULL, 'fnb_cake_booking', 'CakeBookingInvoice', 0, '2019-01-01', '810104', NULL),
(7, 'Store Purchases', 1, '2020-09-01 03:28:02', '2021-01-13 13:14:16', NULL, 2, 3, NULL, NULL, 'store_purchases', 'storePurchaseInvoice', 1, '2019-01-01', NULL, NULL),
(8, 'Store Sales', 1, '2020-11-04 10:27:44', '2021-02-23 15:13:47', NULL, 2, 15, NULL, NULL, 'store_sales', 'storeSaleInvoice', 0, '2019-01-01', NULL, NULL),
(9, 'Salary', 1, '2020-12-18 07:19:15', '2020-12-18 07:19:20', NULL, 2, 2, NULL, NULL, 'hr_employee_salaries', 'EmploymentVoucher', 1, '2019-01-01', NULL, NULL),
(10, 'Supplementary Card Charges', 2, '2020-06-22 09:45:20', '2021-04-22 09:26:23', NULL, 2, 2, NULL, 1, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(11, 'GYM', 3, '2020-06-22 09:48:20', '2021-04-21 20:35:43', NULL, 2, 15, NULL, 1, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', '810900', NULL),
(12, 'Swimming Pool', 3, '2020-06-22 09:48:49', '2021-04-21 20:35:01', NULL, 2, 15, NULL, 2, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(13, 'Snooker', 3, '2020-06-22 12:15:45', '2021-04-21 20:36:38', NULL, 2, 15, NULL, 3, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(14, 'Gaming Zone', 3, '2020-07-01 14:11:00', '2021-04-21 20:36:59', NULL, 5, 15, NULL, 4, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(15, 'Sauna / Steam', 3, '2020-07-16 09:59:59', '2021-04-21 20:37:34', NULL, 11, 15, NULL, 5, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(16, 'Squash Court', 3, '2020-07-16 10:00:30', '2021-04-21 20:38:18', NULL, 11, 15, NULL, 6, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(17, 'Personal GYM Training', 3, '2020-07-16 10:01:14', '2021-04-21 20:38:53', NULL, 11, 15, NULL, 7, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', '810900', NULL),
(18, 'JV', 4, '2020-07-21 12:52:59', '2020-07-21 12:52:59', NULL, 2, 2, NULL, 1, 'finance_general_voucher', 'JVinvoice', 1, '2019-01-01', NULL, NULL),
(19, 'Table Tennis', 3, '2020-08-10 11:58:06', '2021-04-21 20:39:25', NULL, 2, 15, 3, 8, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(20, 'Laundry', 5, '2020-08-15 10:17:08', '2020-08-15 10:17:08', NULL, 2, 2, NULL, 1, 'finance_expense', 'expenseInvoice', 1, '2019-01-01', NULL, NULL),
(21, 'Pool Training', 3, '2020-09-02 08:21:34', '2021-04-21 20:39:48', NULL, 2, 15, NULL, 9, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(22, 'Cash', 7, '2020-09-08 19:28:00', '2020-09-08 19:28:00', NULL, 2, 2, NULL, 1, '', '', 2, '2019-01-01', NULL, NULL),
(23, 'Cheque', 7, '2020-09-08 19:28:27', '2020-09-12 13:07:13', NULL, 2, 2, NULL, 2, '', '', 2, '2019-01-01', NULL, NULL),
(24, 'Credit', 7, '2020-09-08 19:28:34', '2020-09-12 13:06:46', NULL, 2, 2, NULL, 3, '', '', 2, '2019-01-01', NULL, NULL),
(25, 'Online', 7, '2020-09-08 19:28:37', '2020-09-12 13:07:02', NULL, 2, 2, NULL, 4, '', '', 2, '2019-01-01', NULL, NULL),
(26, 'Online Bank Alfalah', 7, '2020-09-09 17:03:43', '2021-01-15 13:06:39', NULL, 11, 15, NULL, 5, '', '', 2, '2019-01-01', NULL, NULL),
(27, 'Online Bank HBL', 7, '2020-09-09 17:04:18', '2021-01-15 13:06:43', NULL, 11, 15, NULL, 6, '', '', 2, '2019-01-01', NULL, NULL),
(28, 'Cheque Bank Alfalah', 7, '2020-09-11 17:05:54', '2021-01-15 13:06:47', NULL, 2, 15, NULL, 7, '', '', 2, '2019-01-01', NULL, NULL),
(29, 'Cheque Bank HBL', 7, '2020-09-11 17:06:17', '2021-01-15 13:06:52', NULL, 2, 15, NULL, 8, '', '', 2, '2019-01-01', NULL, NULL),
(30, 'Personal Squash Training', 3, '2020-10-08 00:21:39', '2021-04-21 20:40:08', NULL, 15, 15, NULL, 10, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(31, 'GYM Guest/Daily Charges', 3, '2020-11-25 10:19:04', '2021-04-21 20:41:10', NULL, 15, 15, NULL, 11, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(32, 'Pool Daily Charges', 3, '2020-11-25 10:19:42', '2021-04-21 20:41:43', NULL, 15, 15, NULL, 12, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(33, 'Advance Salary', 4, '2020-12-21 14:01:17', '2020-12-21 14:01:17', NULL, 15, 15, NULL, 2, 'finance_general_voucher', 'JVinvoice', 1, '2019-01-01', NULL, NULL),
(34, 'Guest Squash Per Day', 3, '2021-03-02 14:30:23', '2021-04-21 20:42:11', NULL, 2, 15, NULL, 13, 'finance_invoice', 'financeInvoice', 0, '2019-01-01', NULL, NULL),
(35, 'Expenses', 1, '2021-03-08 09:56:26', '2021-03-08 04:07:29', NULL, 15, 15, NULL, NULL, 'payment_finance_sheet', 'paymentSheet', 2, '2019-01-01', NULL, NULL),
(36, 'Coffee Shop POS', 6, '2021-04-09 10:51:35', '2021-04-09 10:51:35', NULL, 2, 2, NULL, 1, 'fnb_pos_location', 'salesInvoice', 0, '2019-01-01', NULL, NULL),
(37, 'Bakery POS', 6, '2021-04-09 10:51:40', '2021-04-09 10:51:40', NULL, 2, 2, NULL, 2, 'fnb_pos_location', 'salesInvoice', 0, '2019-01-01', NULL, NULL),
(38, 'Outside Lawn POS', 6, '2021-04-09 10:51:46', '2021-04-09 10:51:46', NULL, 2, 2, NULL, 3, 'fnb_pos_location', 'salesInvoice', 0, '2019-01-01', NULL, NULL),
(39, 'SOFRA POS', 6, '2021-04-09 10:51:52', '2021-04-09 10:51:52', NULL, 2, 2, NULL, 4, 'fnb_pos_location', 'salesInvoice', 0, '2019-01-01', NULL, NULL),
(40, 'CHAYE DHABA POS', 6, '2021-04-09 10:51:57', '2021-04-09 10:51:57', NULL, 2, 2, NULL, 5, 'fnb_pos_location', 'salesInvoice', 0, '2019-01-01', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trans_types`
--
ALTER TABLE `trans_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trans_types`
--
ALTER TABLE `trans_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
