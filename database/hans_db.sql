-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 16. Juni 2014 jam 08:28
-- Versi Server: 5.1.41
-- Versi PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hans_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `msg_from` tinytext NOT NULL,
  `msg_body` mediumtext NOT NULL,
  `msg_email` tinytext NOT NULL,
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `inbox`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `rsrv_id` int(10) NOT NULL AUTO_INCREMENT,
  `rsrv_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rsrv_first_name` varchar(20) NOT NULL,
  `rsrv_last_name` varchar(20) NOT NULL,
  `rsrv_email` varchar(20) DEFAULT NULL,
  `rsrv_contact` varchar(15) NOT NULL,
  `rsrv_room` text NOT NULL,
  `rsrv_bed` int(11) DEFAULT NULL,
  `rsrv_pillow` int(11) DEFAULT NULL,
  `rsrv_towel` int(11) DEFAULT NULL,
  `rsrv_kit` int(11) DEFAULT NULL,
  `rsrv_start` date NOT NULL,
  `rsrv_end` date NOT NULL,
  `rsrv_guest` varchar(5) DEFAULT NULL,
  `rsrv_notes` text,
  PRIMARY KEY (`rsrv_id`),
  UNIQUE KEY `rsrv_name` (`rsrv_first_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data untuk tabel `reservations`
--

INSERT INTO `reservations` (`rsrv_id`, `rsrv_timestamp`, `rsrv_first_name`, `rsrv_last_name`, `rsrv_email`, `rsrv_contact`, `rsrv_room`, `rsrv_bed`, `rsrv_pillow`, `rsrv_towel`, `rsrv_kit`, `rsrv_start`, `rsrv_end`, `rsrv_guest`, `rsrv_notes`) VALUES
(28, '2014-03-10 21:45:41', 'testing', 'testing', 'testing@test.com', '2147483647', 'Deluxe', 3, 0, 0, 0, '2014-03-14', '2014-03-27', '5', 'zgfsdfg'),
(33, '2014-03-12 23:36:00', 'gemar', 'adolfo', 'gemar@hotmail.com', '2147483647', 'Standard', 0, 0, 0, 0, '2014-03-13', '2014-03-14', '0', NULL),
(34, '2014-03-12 23:51:39', 'mirana', 'kyle', 'mkyle@hotmail.com', '2147483647', 'Deluxe', 1, 0, 1, 0, '2014-03-15', '2014-03-16', '2', NULL),
(35, '2014-03-12 23:56:01', 'diwannie', 'arillo', 'arillo@yahoo.com', '2147483647', 'Standard', 0, 1, 1, 1, '2014-03-15', '2014-03-17', '1', NULL),
(36, '2014-03-13 00:02:47', 'mary', 'mission', 'mm@yahoo.com', '2147483647', 'Standard', 1, 0, 0, 0, '2014-03-15', '2014-03-18', '1', NULL),
(37, '2014-03-13 00:03:53', 'gail', 'aplaon', 'gial@yahoo.com', '2147483647', 'Family', 0, 0, 2, 0, '2014-03-15', '2014-03-16', '3', NULL),
(38, '2014-03-13 00:18:12', 'gina', 'bulgado', 'gbulgado@yahoo.com', '1993382888', 'Family', 4, 0, 3, 0, '2014-03-15', '2014-03-16', '9', NULL),
(39, '2014-06-15 22:52:00', 'Azwar', 'Nurdin', 'azwarnurdin89@gmail.', '2147483647', 'Standard', 2, 2, 1, 2, '2014-06-16', '2014-06-16', '2', 'Pesan 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(12) NOT NULL,
  `user_pw` varchar(20) NOT NULL,
  `user_full` varchar(20) DEFAULT NULL,
  `user_role` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=201306 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pw`, `user_full`, `user_role`) VALUES
(201302, 'user', 'password', 'User', 'user'),
(201303, 'giemar', 'migakill', 'giemar adolfo', 'admin'),
(201304, 'diw', '12345', 'diwannie', 'admin'),
(201305, 'admin', 'admin', 'administrator', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
