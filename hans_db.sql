-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2017 at 08:50 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hans_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `msg_id` int(10) UNSIGNED NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `msg_from` tinytext NOT NULL,
  `msg_body` mediumtext NOT NULL,
  `msg_email` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `booking_id` int(10) NOT NULL,
  `booking_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `booking_first_name` varchar(20) NOT NULL,
  `booking_last_name` varchar(20) NOT NULL,
  `booking_email` varchar(20) NOT NULL,
  `booking_contact` varchar(15) NOT NULL,
  `booking_status` varchar(50) NOT NULL,
  `booking_products` varchar(50) DEFAULT NULL,
  `booking_series` varchar(50) DEFAULT NULL,
  `booking_addons` int(11) DEFAULT NULL,
  `booking_mindate` date NOT NULL,
  `booking_maxdate` date NOT NULL,
  `booking_notes` text,
  `booking_finished` varchar(50) DEFAULT NULL,
  `booking_technician` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`booking_id`, `booking_timestamp`, `booking_first_name`, `booking_last_name`, `booking_email`, `booking_contact`, `booking_status`, `booking_products`, `booking_series`, `booking_addons`, `booking_mindate`, `booking_maxdate`, `booking_notes`, `booking_finished`, `booking_technician`) VALUES
(1, '2017-10-17 14:48:04', 'Denis ', 'Setiaji', 'denis@mail.com', '08100000001', 'Member', 'Unit Printer', '10029001', 1, '2017-10-09', '2017-10-29', 'Tinta Bergaris', 'Yes', 'Toni Wahyudi'),
(5, '2017-10-20 09:43:33', '57', '655', 'zss@gmail.com', '757575', 'Member', 'Unit Printer', '5353', 0, '0000-00-00', '0000-00-00', '435345', 'Yes', NULL),
(6, '2017-10-20 09:43:27', '656454646546', '4646', 'ana@gmail.com', '44646464', 'Non Member', 'Unit Printer', '33', 1, '0000-00-00', '0000-00-00', '4324', 'Yes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(8) NOT NULL,
  `user_name` varchar(12) NOT NULL,
  `user_pw` varchar(20) NOT NULL,
  `user_full` varchar(20) DEFAULT NULL,
  `user_role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pw`, `user_full`, `user_role`) VALUES
(201305, 'admin', 'admin', 'Administrator', 'admin'),
(201306, 'Teknisi', 'teknisi', 'Teknisi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `rsrv_name` (`booking_first_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `msg_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201307;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
