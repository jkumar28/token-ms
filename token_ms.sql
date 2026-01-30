-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 07:46 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `token_ms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `remember_token`, `last_login`, `is_active`, `created_at`) VALUES
(1, 'admin', '$2y$10$fa9f8Yn/HTFguY1j9zV4W.iKU6J7zjmb8TdW/crzVXrRgEtD0om7S', NULL, NULL, 1, '2026-01-20 06:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `mobile_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `mobile_no`, `is_active`, `created_at`) VALUES
(1, 'VAISHNO DHARAM KANTA', 'H.P PETROL PUMP SUGGI MADANPUR AURANGABAD BIHAR', '6204600000', 1, '2026-01-20 09:46:21');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int NOT NULL,
  `token_no` int DEFAULT NULL COMMENT 'RST No',
  `challan_no` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `vehicle_no` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vhl_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `party_name` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `party_address` text COLLATE utf8mb4_general_ci,
  `item_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gross_weight` decimal(10,0) DEFAULT NULL,
  `tare_weight` decimal(10,0) DEFAULT NULL,
  `net_weight` decimal(10,0) DEFAULT NULL,
  `net_weight_words` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gross_time` datetime DEFAULT NULL,
  `tare_time` datetime DEFAULT NULL,
  `charge_amount` decimal(10,2) DEFAULT '0.00',
  `operator_name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `supervisor_name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `print_count` int DEFAULT '1',
  `status` enum('completed','cancelled') COLLATE utf8mb4_general_ci DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `token_no`, `challan_no`, `company_id`, `vehicle_no`, `vhl_type`, `party_name`, `party_address`, `item_name`, `gross_weight`, `tare_weight`, `net_weight`, `net_weight_words`, `gross_time`, `tare_time`, `charge_amount`, `operator_name`, `supervisor_name`, `print_count`, `status`, `created_at`) VALUES
(1, 01, '01', 3, 'JH02BN8883', '16', 'BKB TRANSPORT', '0', 'POND ASH', 53680, 16215, 37465, 'THREE SEVEN FOUR SIX FIVE', '2025-10-08 21:49:00', '2026-01-30 16:02:00', 0.00, 'admin', NULL, 2, 'completed', '2026-01-30 12:30:58'),
(2, 02, '02', 3, 'JH02BM6221', '16', 'BKB TRANSPORT', '0', 'POND ASH', 53310, 16050, 37260, 'THREE SEVEN TWO SIX ZERO', '2025-10-09 17:18:00', '2026-01-30 16:02:00', 0.00, 'admin', NULL, 2, 'completed', '2026-01-30 12:32:12'),
(3, 03, '03', 3, 'JH02BN1991', '16', 'BKB TRANSPORT', '0', 'POND ASH', 53600, 16544, 37056, 'THREE SEVEN ZERO FIVE SIX', '2025-10-09 03:46:00', '2026-01-30 18:12:00', 0.00, 'admin', NULL, 2, 'completed', '2026-01-30 12:46:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_no` (`vehicle_no`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
