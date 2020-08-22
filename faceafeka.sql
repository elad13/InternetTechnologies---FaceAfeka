-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2020 at 11:47 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faceafeka`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
CREATE TABLE IF NOT EXISTS `friend_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_requests`
--

DROP TABLE IF EXISTS `game_requests`;
CREATE TABLE IF NOT EXISTS `game_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `url` text CHARACTER SET hebrew NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET hebrew NOT NULL,
  `post_id` int(11) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `file_name`, `post_id`, `upload_time`) VALUES
(1, 'IMG_20200724_074851_235.jpg', 84, '2020-07-24 07:48:51'),
(2, 'IMG_20200724_095354_986.png', 89, '2020-07-24 09:53:54'),
(3, 'IMG_20200724_095354_217.png', 89, '2020-07-24 09:53:54'),
(4, 'IMG_20200724_095354_968.png', 89, '2020-07-24 09:53:54'),
(5, 'IMG_20200724_095354_710.png', 89, '2020-07-24 09:53:54'),
(6, 'IMG_20200724_095354_236.png', 89, '2020-07-24 09:53:54'),
(7, 'IMG_20200724_095354_990.png', 89, '2020-07-24 09:53:54'),
(8, 'IMG_20200724_095354_798.png', 89, '2020-07-24 09:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `isPrivate` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`, `user_id`, `date`, `isPrivate`) VALUES
(81, '', 5, '2020-07-24 10:32:48', 0),
(82, '', 5, '2020-07-24 10:32:52', 0),
(83, 'sdfsdf', 5, '2020-07-24 10:33:15', 0),
(84, '', 6, '2020-07-24 10:48:51', 0),
(88, '×‘×“×™×§×”', 6, '2020-07-24 11:25:43', 0),
(89, '', 5, '2020-07-24 12:53:54', 0),
(90, '×©×‘×ª', 5, '2020-08-07 18:17:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `user_id`, `comment`) VALUES
(1, 83, 5, 'es'),
(2, 84, 5, 'sdf'),
(3, 84, 5, '×”×™×™');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(5, 'Elad', '$2y$10$tCmQq5MhacuHbQ34OvKmKu0eNCX3eHC99pWZj3D8U.qAmQ3FJaOye'),
(6, 'Giron', '$2y$10$P.FpET.uT3KP7jYwiPomTei0QLJD4ajgxDr8kqgsbNKB4xeA2axbK'),
(7, 'Dor', '$2y$10$pY1KoBb8ozQRI3mUczmWQ.ZfFYPdhRPAHTxcQAxFOGlXd7WU63zE2'),
(8, 'Shir', '$2y$10$wuBiF.t5Al4516jB46LB9uxsnVbauHn2GsRPZ9wVSTG5Pjz3q.D1e'),
(9, 'Lital', '$2y$10$FwT.t8ljvofUIa9D5OnLzeDhLoEOS19boldpMVwbli6s.yDqq6kDC'),
(10, 'Moshe', '$2y$10$D4pxNYDnkIPb6.p/WOKT1.AtJorhtFOC37cODlZLKMbDCB0AddICy');

-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

DROP TABLE IF EXISTS `user_friends`;
CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_friends`
--

INSERT INTO `user_friends` (`id`, `user_id`, `friend_id`) VALUES
(1, 6, 5),
(2, 5, 6);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
