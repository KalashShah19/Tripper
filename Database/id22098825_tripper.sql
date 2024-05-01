-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2024 at 12:21 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id22098825_tripper`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `name`, `amount`, `plan_id`) VALUES
(6, 'Food', 700, 28),
(7, 'Train surat - Karjat', 125, 31),
(9, 'Room 5 ppl x 2', 4000, 31),
(11, 'Rikshaw ', 500, 31);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`place_id`, `name`, `location`, `price`) VALUES
(1, 'Rebounce', 'Surat', 1300),
(3, 'Dandi beach', 'Navsari', 350),
(4, 'Marine Drives', 'Mumbai', 200),
(5, 'Go Karting', 'Mumbai', 800),
(6, 'Dumas beach', 'Surat', 50),
(8, 'Bollywood Theme Park', 'Goregaon', 1100),
(9, 'Water World Water Park', 'Mahuva', 650),
(10, 'Water Kingdom', 'Borivali', 850),
(11, 'Game Lux ', 'Kurla', 200),
(12, 'Hakone Karting ', 'Powai', 230),
(13, 'Republic of Karting ', 'Virar', 300),
(14, 'Republic of Karting, paintball 25 ball ', 'Virar', 400),
(15, 'Gravity zone', 'Powai', 500),
(34, 'Snow kingdom', 'Ghatkopar', 750),
(35, 'Snow park', 'Dumas Road', 400),
(36, 'Rebounce', 'surat', 1250),
(37, 'Fun funta fun', 'surat', 990),
(38, 'Woop', 'surat', 2500),
(39, 'Pro paintball', 'Andheri', 1500),
(40, 'Hop up trampoline', 'andheri', 650),
(41, 'Jumple tumple trampoline', 'mulund', 500),
(42, 'Smaash', 'lower parel', 600),
(43, 'Beezila trampoline', 'malad', 470),
(44, 'Bounce Inc trampoline', 'malad', 900),
(45, 'Gokarting', 'virar', 400),
(46, 'The splash of neon', 'surat vesu', 600),
(47, 'Clue hunt gokarting', 'andheri', 500),
(48, 'Funcity', 'infinity mall', 1500),
(49, 'Sakinaka rage room', 'mumbai', 500),
(50, 'No escape mystery room', 'powai', 850),
(51, 'Nandi Baag Resort ', 'Karjat, Mumbai', 1250),
(52, 'Jaipur ', 'Rajasthan ', 3000),
(55, 'Udaipur', 'Rajasthan ', 4000);

-- --------------------------------------------------------

--
-- Table structure for table `planplaces`
--

CREATE TABLE `planplaces` (
  `plan_place_id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `planplaces`
--

INSERT INTO `planplaces` (`plan_place_id`, `plan_id`, `place_id`) VALUES
(19, 28, 3),
(20, 28, 1),
(21, 29, 6),
(22, 29, 2),
(23, 30, 6),
(24, 30, 1),
(25, 31, 51),
(26, 32, 52),
(27, 32, 55);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(256) NOT NULL,
  `instructions` text NOT NULL,
  `total_cost` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_name`, `instructions`, `total_cost`, `created_at`) VALUES
(31, 'College', '-', 1250, '2024-05-01 04:11:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `planplaces`
--
ALTER TABLE `planplaces`
  ADD PRIMARY KEY (`plan_place_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `planplaces`
--
ALTER TABLE `planplaces`
  MODIFY `plan_place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
