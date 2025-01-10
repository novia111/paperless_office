-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 08:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paperless_office`
--

-- --------------------------------------------------------

--
-- Table structure for table `calibration_schedules`
--

CREATE TABLE `calibration_schedules` (
  `id` int(11) NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `schedule_date` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calibration_schedules`
--

INSERT INTO `calibration_schedules` (`id`, `tool_name`, `client_name`, `schedule_date`, `status`) VALUES
(3, 'Thermometer', 'PT. XYZ Industri', '2025-01-15', 'Scheduled'),
(4, 'Rontgen', 'Klinik Sehat', '2024-11-04', 'Completed'),
(5, 'Timbangan Analitik', 'PT. ABC Teknologi', '2025-01-18', 'Scheduled'),
(6, 'Elektrokardiogram (EKG)', 'RS. Medika', '2025-01-22', 'Scheduled'),
(7, 'Spektrometer', 'PT. Tech Lab', '2024-12-04', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `calibration_tools`
--

CREATE TABLE `calibration_tools` (
  `id` int(11) NOT NULL,
  `tool_name` varchar(255) NOT NULL,
  `calibration_status` enum('Terkalibrasi','Belum Terkalibrasi') NOT NULL,
  `last_calibrated` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calibration_tools`
--

INSERT INTO `calibration_tools` (`id`, `tool_name`, `calibration_status`, `last_calibrated`, `created_at`) VALUES
(1, 'Digital Multimeter Fluke 87V', 'Terkalibrasi', '2025-01-03', '2025-01-09 01:55:11'),
(2, 'Oscilloscope Rigol DS1054Z', 'Terkalibrasi', '2024-12-15', '2025-01-09 01:55:45'),
(3, 'Thermometer Infrared FLIR TG165', 'Belum Terkalibrasi', '2024-11-20', '2025-01-09 01:56:21'),
(4, 'Pressure Gauge WIKA 232.50', 'Terkalibrasi', '2024-12-05', '2025-01-09 01:56:53'),
(5, 'Weighing Scale Mettler Toledo', 'Belum Terkalibrasi', '2024-10-10', '2025-01-09 01:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`) VALUES
(4, 'PT. ABC Teknologi', 'abc@teknologi.com', '081234567890', 'Jl. Teknologi No. 12, Palembang'),
(5, 'CV. XYZ Engineering', 'xyz@engineering.com', '082345678901', 'Jl. Industri No. 8, Surabaya'),
(6, 'UD. PQR Instrument', 'pqr@instrument.com', '085456789012', 'Jl. Alat No. 23, Bandung'),
(7, 'PT. MNO Elektronik ', 'mno@elektronik.com', '089567890123', 'Jl. Elektronik No. 15, Yogyakarta'),
(8, 'CV. STU Manufacturing', 'stu@manufacturing', '087678901234', 'Jl. Produksi No. 5, Medan');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `title`, `file_name`, `created_at`) VALUES
(4, 'Laporan Kalibrasi Termometer Digital', 'MAKALAH ENDOSKOPI_NOVIA_01202205032.pdf', '2025-01-09 03:28:08'),
(5, 'Laporan Kalibrasi Timbangan Elektronik', 'Basis Data 6_32_Novia.pdf', '2025-01-09 03:28:46'),
(6, 'Laporan Kalibrasi Kalibrator Tegangan', 'NOVIA_32_UAS BASIS DATA.pdf', '2025-01-09 03:29:16'),
(7, 'Laporan Kalibrasi Mesin Penguji Kekerasan', 'MAKALAH TREADMILL_NOVIA_01202205032.pdf', '2025-01-09 03:29:48'),
(8, 'Laporan Kalibrasi Multimeter Digital', 'MAKALAH USG_NOVIA SURYA SUKAWATI_32.pdf', '2025-01-09 03:30:08'),
(9, 'Laporan Kalibrasi Termometer Digital', 'MAKALAH TREADMILL_NOVIA_01202205032.pdf', '2025-01-10 03:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--
-- Error reading structure for table paperless_office.schedules: #1932 - Table 'paperless_office.schedules' doesn't exist in engine
-- Error reading data for table paperless_office.schedules: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `paperless_office`.`schedules`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Novia', '$2y$10$CGeHc8oSwVNzuGSeuEPJX.7jH0GF2qsXV6xgtU8Hz1jYRxZ0AgE/.', 'user', '2025-01-03 13:22:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calibration_schedules`
--
ALTER TABLE `calibration_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calibration_tools`
--
ALTER TABLE `calibration_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calibration_schedules`
--
ALTER TABLE `calibration_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `calibration_tools`
--
ALTER TABLE `calibration_tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
