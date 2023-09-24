-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2023 at 02:44 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_spots`
--

CREATE TABLE `available_spots` (
  `id` int(6) UNSIGNED NOT NULL,
  `garage_id` int(6) UNSIGNED NOT NULL,
  `garage_name` varchar(30) NOT NULL,
  `available_spots` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_spots`
--

INSERT INTO `available_spots` (`id`, `garage_id`, `garage_name`, `available_spots`) VALUES
(19, 1, 'parking lot 1', 5),
(20, 2, 'parking lot 2', 10),
(21, 3, 'Garage C', 9),
(22, 4, 'Garage D', 2);

-- --------------------------------------------------------

--
-- Table structure for table `garages`
--

CREATE TABLE `garages` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(50) NOT NULL DEFAULT 'Kerby street',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `ev_charge` enum('Yes','No') DEFAULT 'No',
  `cctv` enum('Yes','No') DEFAULT 'No',
  `garage_air_compressor` enum('Yes','No') DEFAULT 'No',
  `rent` decimal(5,2) NOT NULL DEFAULT 10.00,
  `owner_id` int(11) NOT NULL,
  `spots` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `garages`
--

INSERT INTO `garages` (`id`, `name`, `address`, `start_time`, `end_time`, `ev_charge`, `cctv`, `garage_air_compressor`, `rent`, `owner_id`, `spots`) VALUES
(1, 'Garage A', '123 Main St', '2023-03-31 04:38:00', '2023-03-31 23:38:00', 'Yes', 'Yes', 'Yes', '70.00', 1, 2),
(2, 'Garage B', '456 Elm St', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Yes', 'Yes', '', '250.00', 1, 2),
(3, 'Garage C', '789 Oak St', '2023-03-29 10:00:00', '2023-03-29 20:00:00', 'Yes', 'No', 'Yes', '120.00', 2, 2),
(4, 'Garage D', '321 Pine St', '2023-03-29 11:00:00', '2023-03-29 21:00:00', 'No', 'No', 'No', '8.00', 1, 2),
(6, 'GQWA', '410 kb st', '2023-03-31 05:07:00', '2023-03-31 21:07:00', 'Yes', 'Yes', 'Yes', '77.00', 4, 2),
(8, 'parking lot 1', 'Kerby street', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Yes', 'Yes', 'Yes', '10.00', 12, 2),
(11, 'Garage G561', 'Kerby street', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Yes', 'Yes', '', '100.00', 16, 2);

-- --------------------------------------------------------

--
-- Table structure for table `owner_users`
--

CREATE TABLE `owner_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `owner_users`
--

INSERT INTO `owner_users` (`id`, `username`, `fname`, `lname`, `mobile`, `email`, `password`) VALUES
(1, 'dhanya', 'dhanya', 'n', 9448481994, 'dhanya@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'sam', 'sam', 'm', 7554142563, 'sam@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(5, 'samhithi', 'samhithi', 's', 16823747859, 'samhithi@gmail.com', '508df4cb2f4d8f80519256258cfb975f'),
(6, 'Priyanka', 'Priyanka', 'L K', 987876567, 'pri@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(7, 'abc', 'abc', 'D', 9448583322, 'abc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(8, 'kushi', 'kushi', 'K', 7441258963, 'kushi@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(9, 'Anil', 'Anil', 'n', 7894561235, 'anil@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(10, 'abcs', 'abc', 'abc', 7452136984, 'abc@g.com', '202cb962ac59075b964b07152d234b70'),
(11, 'dhanyaq', 'qqwqwq', 'ddfwe', 7849845489, 'sdfew@wefe.verfv', '202cb962ac59075b964b07152d234b70'),
(12, 'dhanya3', 'qwe', 'qwe', 1234567985, 'hosuprithus@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(16, 'jhon', 'jhon', 'j', 9745863215, 'jhon@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `parking_spots`
--

CREATE TABLE `parking_spots` (
  `id` int(6) UNSIGNED NOT NULL,
  `spot_name` varchar(30) NOT NULL,
  `availability` int(6) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_spots`
--

INSERT INTO `parking_spots` (`id`, `spot_name`, `availability`, `location`) VALUES
(13, 'Spot A', 1, 'Level 1'),
(14, 'Spot B', 1, 'Level 2'),
(15, 'Spot C', 0, 'Level 3'),
(16, 'Spot D', 1, 'Level 1'),
(17, 'Spot E', 1, 'Level 2'),
(18, 'Spot F', 0, 'Level 3'),
(19, 'Spot G', 1, 'Level 1'),
(20, 'Spot H', 1, 'Level 2'),
(21, 'Spot I', 1, 'Level 3'),
(22, 'Spot J', 0, 'Level 1'),
(23, 'Spot K', 1, 'Level 2'),
(24, 'Spot L', 1, 'Level 3');

-- --------------------------------------------------------

--
-- Table structure for table `parkspot`
--

CREATE TABLE `parkspot` (
  `spot` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `renting_spots`
--

CREATE TABLE `renting_spots` (
  `id` int(6) UNSIGNED NOT NULL,
  `rentplace_id` int(6) UNSIGNED NOT NULL,
  `rentplace_name` varchar(30) NOT NULL,
  `renting_spots` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rentplace`
--

CREATE TABLE `rentplace` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rent_reservations`
--

CREATE TABLE `rent_reservations` (
  `id` int(11) NOT NULL,
  `rentplace_id` int(6) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `reserved_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `garage_id` int(6) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `reserved_on` datetime NOT NULL,
  `rent` decimal(6,2) NOT NULL,
  `reserved_spots` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `garage_id`, `user_name`, `reserved_on`, `rent`, `reserved_spots`) VALUES
(1, 1, 'jdoe', '2023-03-29 10:00:00', '15.00', 0),
(2, 2, 'jsmith', '2023-03-29 11:00:00', '10.00', 0),
(3, 3, 'jkim', '2023-03-29 12:00:00', '25.00', 0),
(4, 1, 'jdoe', '2023-03-29 10:00:00', '15.00', 0),
(5, 2, 'jsmith', '2023-03-29 11:00:00', '10.00', 0),
(6, 3, 'jdoe', '2023-03-29 12:00:00', '25.00', 0),
(7, 1, 'jkim', '2023-03-29 10:00:00', '15.00', 0),
(9, 3, 'jsmith', '2023-03-30 15:00:00', '25.00', 0),
(10, 3, 'jsmith', '2023-03-31 15:00:00', '25.00', 2),
(11, 3, 'jsmith', '2023-03-30 20:00:00', '25.00', 0),
(12, 1, 'jkim', '2023-03-30 21:00:00', '15.00', 0),
(13, 2, 'jkim', '2023-03-30 19:00:00', '10.00', 0),
(14, 4, 'jkim', '2023-03-30 19:00:00', '10.00', 0),
(39, 3, 'dhn', '2023-04-01 22:41:06', '120.00', 1),
(40, 1, 'dhanya', '2023-04-03 00:05:52', '70.00', 2),
(41, 8, 'dhanya', '2023-04-02 17:07:20', '0.00', 0),
(46, 2, 'jkim', '2023-03-30 11:00:00', '10.00', 0),
(51, 8, 'jim', '2023-04-03 02:44:05', '10.00', 1),
(52, 2, 'jim', '2023-04-03 02:44:20', '250.00', 1),
(53, 11, 'jim', '2023-04-03 02:44:31', '100.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `fname`, `lname`, `mobile`, `email`, `password`) VALUES
(1, 'jdoe', 'John', 'Doe', 1234567890, 'jdoe@email.com', 'password1'),
(2, 'jsmith', 'Jane', 'Smith', 2345678901, 'jsmith@email.com', 'password2'),
(3, 'jkim', 'Jin', 'Kim', 3456789012, 'jkim@email.com', 'password3'),
(4, 'dhanya', 'dhanya', 'N', 9448481552, 'dhanya@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(5, 'Nick', 'nick', 'K', 7412589632, 'suprith0112@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(6, 'jack', 'jack', 'j', 7485961236, 'hosuprith@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(7, 'samm', 'samm', 's', 123456789, 'samm@gmail.com', 'b3275960d68fda9d831facc0426c3bbc'),
(8, 'Wert', 'werty', 'ytrer', 9876545678, 'wert@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(9, 'dhn', 'dhn', 'ee', 1234567890, 'dhanya33@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(10, 'qwerty', 'dfvdr', 'sdve', 64584984, 'sdf@edfwe.sef', '202cb962ac59075b964b07152d234b70'),
(11, 'qwerty1', 'dfvdr', 'sdve', 64584984, 's1df@edfwe.sef', '202cb962ac59075b964b07152d234b70'),
(12, 'dhanya4', 'dhanya', 'd', 9874563214, 'd@f.com', 'e10adc3949ba59abbe56e057f20f883e'),
(17, 'jim', 'jim', 'j', 9784563215, 'jim@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `make` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(4) NOT NULL,
  `license_plate` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `make`, `model`, `year`, `license_plate`) VALUES
(1, 1, 'Honda', 'Accord', 2021, 'ABC123'),
(2, 1, 'Toyota', 'Camry', 2019, 'DEF456'),
(3, 2, 'Ford', 'Mustang', 2022, 'GHI789'),
(4, 2, 'Chevrolet', 'Camaro', 2020, 'JKL012'),
(5, 3, 'Tesla', 'Model S', 2021, 'MNO345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_spots`
--
ALTER TABLE `available_spots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `garage_id` (`garage_id`);

--
-- Indexes for table `garages`
--
ALTER TABLE `garages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_garages_users` (`owner_id`);

--
-- Indexes for table `owner_users`
--
ALTER TABLE `owner_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `parking_spots`
--
ALTER TABLE `parking_spots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parkspot`
--
ALTER TABLE `parkspot`
  ADD PRIMARY KEY (`spot`);

--
-- Indexes for table `renting_spots`
--
ALTER TABLE `renting_spots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rentplace_id` (`rentplace_id`);

--
-- Indexes for table `rentplace`
--
ALTER TABLE `rentplace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent_reservations`
--
ALTER TABLE `rent_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rentplace_id` (`rentplace_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `garage_id` (`garage_id`),
  ADD KEY `reservations_ibfk_2` (`user_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_spots`
--
ALTER TABLE `available_spots`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `garages`
--
ALTER TABLE `garages`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `owner_users`
--
ALTER TABLE `owner_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `parking_spots`
--
ALTER TABLE `parking_spots`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `renting_spots`
--
ALTER TABLE `renting_spots`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rentplace`
--
ALTER TABLE `rentplace`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rent_reservations`
--
ALTER TABLE `rent_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `available_spots`
--
ALTER TABLE `available_spots`
  ADD CONSTRAINT `available_spots_ibfk_1` FOREIGN KEY (`garage_id`) REFERENCES `garages` (`id`);

--
-- Constraints for table `renting_spots`
--
ALTER TABLE `renting_spots`
  ADD CONSTRAINT `renting_spots_ibfk_1` FOREIGN KEY (`rentplace_id`) REFERENCES `rentplace` (`id`);

--
-- Constraints for table `rent_reservations`
--
ALTER TABLE `rent_reservations`
  ADD CONSTRAINT `rent_reservations_ibfk_1` FOREIGN KEY (`rentplace_id`) REFERENCES `rentplace` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`garage_id`) REFERENCES `garages` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `users` (`username`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
