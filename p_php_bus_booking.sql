-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 02:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p_php_bus_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `username`, `image`, `date`) VALUES
(1, 'admin@gmail.com', '$2y$04$r7DbJOYYEX2ctJM.T8VsHuxnfyOd6F.JtEhp2v/N5Iz4eIsey8stG', 'admin', '', '2023-12-03 04:57:08');

-- --------------------------------------------------------

--
-- Table structure for table `bus_booking`
--

CREATE TABLE `bus_booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `destination` varchar(115) NOT NULL,
  `departure` varchar(255) DEFAULT NULL,
  `date_of_return` varchar(255) DEFAULT NULL,
  `date_of_depart` varchar(255) DEFAULT NULL,
  `bus_no` varchar(115) NOT NULL,
  `seat_booking` varchar(255) NOT NULL,
  `booked_id` varchar(255) NOT NULL,
  `no_of_pass` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `card_no` int(25) NOT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `exp_month` int(2) NOT NULL,
  `exp_year` int(2) NOT NULL,
  `cvv` int(3) NOT NULL,
  `pin` int(4) NOT NULL,
  `total` float NOT NULL,
  `total_amount` float NOT NULL,
  `j_type` varchar(50) NOT NULL,
  `booked_date` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_booking`
--

INSERT INTO `bus_booking` (`id`, `user_id`, `email`, `destination`, `departure`, `date_of_return`, `date_of_depart`, `bus_no`, `seat_booking`, `booked_id`, `no_of_pass`, `status`, `card_no`, `card_name`, `exp_month`, `exp_year`, `cvv`, `pin`, `total`, `total_amount`, `j_type`, `booked_date`) VALUES
(50, 45, 'bunny@gmail.com', 'Shah Alam', 'Segamat', '', '2023-12-31', 'ERGT43G', '[[32,\"Economy Class\",9.99]]', 'booked_6587f5ab7fb620.95439148', 1, 1, 2147483647, 'john doe', 44, 44, 444, 4444, 9.99, 9.99, 'single', '2023-12-27 14:42:38'),
(51, 45, 'bunny@gmail.com', 'Kluang', 'Singapore', '', '2023-12-29', 'G5TRG45', '[[7,\"First Class\",60.99],[14,\"Economy Class\",22.5]]', 'booked_658abc3d36ca83.75392286', 2, 1, 2147483647, 'emy bat', 222, 222, 222, 2222, 83.49, 83.49, 'single', '2023-12-27 14:42:38'),
(54, 1, 'user@gmail.com', 'Desaru', 'Ipoh', '', '2023-12-28', 'VRFEH5', '[[9,\"Economy Class\",22.5],[8,\"First Class\",66.99]]', 'booked_658afc4947f461.72179430', 2, 1, 2147483647, 'lulu hui', 3333, 3333, 333, 3333, 89.49, 178.98, 'return', '2023-12-27 14:42:38'),
(58, 1, 'user@gmail.com', 'Malacca', 'KLIA', '', '2024-01-07', 'FRG45YGHT', '[[11,\"Economy Class\",5.66],[18,\"Economy Class\",5.66]]', 'booked_658afdfa889775.54558216', 2, 1, 2147483647, 'YARA MOON', 33, 33, 33, 3333, 11.32, 22.64, 'return', '2023-12-27 14:42:38'),
(71, 1, 'user@gmail.com', 'Kluang', 'Singapore', '', '2023-12-31', 'G5TRG45', '[[34,\"Economy Class\",22.5]]', 'booked_658d5ebbb6cbe3.06332938', 1, 1, 0, 'riot ru', 444, 444, 444, 444, 22.5, 22.5, 'single', '2023-12-28'),
(73, 47, 'jstfunky@gmail.com', 'Penang', 'YangChang', '2024-01-25', '2024-01-19', 'GR5GT43GT', '[[20,\"Economy Class\",24.6]]', 'booked_6593eff59446c0.93257056', 1, 1, 2147483647, 'Lily Beth', 42, 42, 244, 4444, 24.6, 49.2, 'return', '2024-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `bus_route`
--

CREATE TABLE `bus_route` (
  `id` int(11) NOT NULL,
  `departure` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `f_price` float DEFAULT NULL,
  `bus_no` varchar(115) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `dep_date` date DEFAULT NULL,
  `dep_time` time DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_route`
--

INSERT INTO `bus_route` (`id`, `departure`, `destination`, `price`, `f_price`, `bus_no`, `class`, `dep_date`, `dep_time`, `status`, `date`) VALUES
(4, 'Johor Bahru', 'Kuala Lumpur', 22.5, 50.99, 'G5R3T3GT', 'First Class,Second Class,A.C', '2026-12-24', '22:40:00', 1, '2023-12-28 11:44:20'),
(5, 'YangChang', 'Penang', 24.6, 60.99, 'GR5GT43GT', 'Second Class,A.C,Tv,First Class', '2026-12-02', '22:40:00', 1, '2023-12-23 18:01:58'),
(7, 'Singapore', 'Tioman Island', 22.5, 60.99, 'RGF4E5GT54', 'Second Class,A.C,Tv,First Class', '2028-08-22', '22:39:00', 1, '2023-12-23 18:02:18'),
(8, 'Singapore', 'Port Dickson', 22.5, 58.99, 'ERGT43TRF', 'First Class,Second Class,A.C', '2023-12-20', '22:38:00', 1, '2023-12-23 18:12:01'),
(9, 'Segamat', 'Shah Alam', 9.99, 69.99, 'ERGT43G', 'First Class,Second Class,A.C,Tv', '2024-03-08', '03:34:00', 1, '2023-12-12 09:15:44'),
(10, 'Singapore', 'Kluang', 20.66, 50.99, 'G5TRG45', 'First Class,Second Class,A.C', '2032-12-22', '20:18:00', 1, '2023-12-23 18:13:05'),
(11, 'Cameron Highlands', 'Sunway Lagoon', 2.99, 66.99, 'FVRG54TGG', 'First Class,Second Class,Tv', '2032-11-22', '22:37:00', 1, '2023-12-23 18:13:29'),
(12, 'KLIA', 'Malacca', 5.66, 58.99, 'FRG45YGHT', 'A.C,Tv,First Class,Second Class', '2023-12-30', '22:38:00', 1, '2023-12-12 09:17:39'),
(13, 'Ipoh', 'Desaru', 22.5, 66.99, 'VRFEH5', 'First Class,Second Class,Tv', '2027-11-30', '22:24:00', 1, '2023-12-23 18:13:58'),
(14, 'Singapore', 'Genting Highlands', 29.99, 66.99, 'FRG45YGHT', 'Second Class,First Class,A.C', '2030-07-31', '22:23:00', 1, '2023-12-23 18:01:28'),
(15, 'Singapore', 'Seremban', 24.66, 66.99, 'FVRG54T', 'First Class,Tv,Second Class,A.C', '2023-12-10', '22:23:00', 1, '2023-12-12 09:19:04'),
(17, 'froler', 'Genting Highlands', 33.99, 58.99, 'cxvwrfasc', 'First Class,Second Class,A.C', '2023-12-28', '23:27:00', 1, '2023-12-12 09:19:49'),
(18, 'Kuala Perlis ', 'lotus', 33.99, 50.99, 'cxvwrfasc', 'First Class,Second Class,A.C', '2027-04-28', '23:27:00', 1, '2023-12-12 09:20:38'),
(19, 'poyarn', 'GOA', 33.99, 58.99, 'cxvwrfasc', 'First Class,Second Class,A.C', '2023-12-31', '08:32:00', 1, '2023-12-24 08:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `departure` varchar(255) NOT NULL,
  `date` varchar(30) NOT NULL,
  `time` varchar(10) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `destination`, `departure`, `date`, `time`, `price`) VALUES
(4, 'Tioman Island', 'Singapore', '30-12-2023', '15:00', 33.99),
(5, 'Malacca', 'KLIA', '31-12-2033', '16:07', 88.99),
(6, 'Sunway Lagoon', 'Cameron Highlands', '30-11-2027', '22:02', 88.99);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_booking`
--

CREATE TABLE `schedule_booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `destination` varchar(115) NOT NULL,
  `departure` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(11) NOT NULL,
  `bus_no` varchar(115) NOT NULL,
  `booked_id` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `card_no` int(25) NOT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `exp_month` int(2) NOT NULL,
  `exp_year` int(2) NOT NULL,
  `cvv` int(3) NOT NULL,
  `pin` int(4) NOT NULL,
  `price` float NOT NULL,
  `pass` int(11) NOT NULL,
  `booked_date` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_booking`
--

INSERT INTO `schedule_booking` (`id`, `user_id`, `schedule_id`, `email`, `destination`, `departure`, `date`, `time`, `bus_no`, `booked_id`, `status`, `card_no`, `card_name`, `exp_month`, `exp_year`, `cvv`, `pin`, `price`, `pass`, `booked_date`) VALUES
(105, 45, 6, 'bunny@gmail.com', 'Sunway Lagoon', 'Cameron Highlands', '2023-12-23 19:13:29', '22:02', 'FVRG54TGG', 'BOOKED658ff3a49112b', 1, 3333333, 'Yuri Moon', 33, 33, 33, 3333, 98.67, 33, '2023-12-30'),
(106, 45, 5, 'bunny@gmail.com', 'Malacca', 'KLIA', '2023-12-12 10:17:39', '16:07', 'FRG45YGHT', 'BOOKED658ff41291bb1', 1, 2147483647, 'Rita Martin', 44, 44, 44, 44, 22.64, 4, '2023-12-30'),
(107, 45, 4, 'bunny@gmail.com', 'Tioman Island', 'Singapore', '2023-12-23 19:02:18', '15:00', 'RGF4E5GT54', 'BOOKED658ff43a095f0', 1, 2147483647, 'Tony Umez', 55, 55, 55, 5555, 112.5, 5, '2023-12-30'),
(108, 45, 5, 'bunny@gmail.com', 'Malacca', 'KLIA', '2023-12-12 10:17:39', '16:07', 'FRG45YGHT', 'BOOKED658ff48462dbb', 1, 2147483647, 'julius Beger', 44, 44, 444, 4444, 22.64, 4, '2023-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `selected_seats` varchar(255) DEFAULT NULL,
  `booked` tinyint(11) NOT NULL DEFAULT 0,
  `bus_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `departure` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `selected_seats`, `booked`, `bus_no`, `email`, `departure`, `destination`) VALUES
(31, '3_4,2_2,9_3', 1, 'GR5GT43GT', 'bunny@gmail.com', 'Segamat', 'Shah Alam'),
(32, '9_2', 1, 'ERGT43G', 'bunny@gmail.com', 'Sagamat', 'Shah Alam'),
(34, '2_4,4_2', 1, 'G5TRG45', 'bunny@gmail.com', 'Singapore', 'Kluang'),
(35, '3_1,2_5', 1, 'VRFEH5', 'user@gmail.com', 'Ipoh', 'Desaru'),
(36, '3_4,5_2', 1, 'FRG45YGHT', 'user@gmail.com', 'KLIA', 'Malacca'),
(39, '9_4', 1, 'G5TRG45', 'user@gmail.com', 'Singapore', 'Kluang'),
(40, '6_2', 1, 'GR5GT43GT', 'jstfunky@gmail.com', 'YangChang', 'Penang');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `phone`, `image`, `status`, `date`) VALUES
(1, 'user@gmail.com', '$2y$04$r7DbJOYYEX2ctJM.T8VsHuxnfyOd6F.JtEhp2v/N5Iz4eIsey8stG', 'user', '2147483647', NULL, 1, '2023-12-02 16:49:45'),
(45, 'bunny@gmail.com', '$2y$04$T93BH0xeYPxusC3kSTVMceLiFEl0rj/HQNzs9Q6QSywcnNxdzCQH6', 'bunny', '09045634211', NULL, 1, '2023-12-03 05:01:35'),
(46, 'quis.massa@yahoo.net', '$2y$04$nzpMeZcXfvpTsgjwdqPQW.d0xjRLJU6LWtObCW3jBwH8KtnP5LV36', 'vyonne', '07033464616', NULL, 1, '2023-12-04 08:37:01'),
(47, 'jstfunky@gmail.com', '$2y$04$XDtm.Qq6J1Gnad4NOLbk3utrU9W0J1dN8sb1cIZW5C40o0zLACN.y', 'juli bunn', '09044567345', NULL, 1, '2023-12-30 13:26:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_booking`
--
ALTER TABLE `bus_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_route`
--
ALTER TABLE `bus_route`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_booking`
--
ALTER TABLE `schedule_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bus_booking`
--
ALTER TABLE `bus_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `bus_route`
--
ALTER TABLE `bus_route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedule_booking`
--
ALTER TABLE `schedule_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
