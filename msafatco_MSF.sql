-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 10, 2019 at 12:05 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msafatco_MSF`
--

-- --------------------------------------------------------

--
-- Table structure for table `member_tasks`
--

CREATE TABLE `member_tasks` (
  `task_id` int(11) UNSIGNED NOT NULL,
  `task_name` text NOT NULL,
  `task_time` datetime NOT NULL,
  `task_boss` varchar(70) NOT NULL,
  `task_agent` varchar(70) NOT NULL,
  `creation_date` datetime NOT NULL,
  `status` int(11) DEFAULT '0',
  `money` int(11) NOT NULL,
  `task_details` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_tasks`
--

INSERT INTO `member_tasks` (`task_id`, `task_name`, `task_time`, `task_boss`, `task_agent`, `creation_date`, `status`, `money`, `task_details`) VALUES
(1, 'test', '2019-06-11 11:18:26', 'omar', 'omar', '2019-06-06 04:18:26', 0, 5, 'test'),
(2, 'test', '2019-06-11 11:20:03', 'omar', 'omar', '2019-06-06 04:20:03', 0, 5, 'test'),
(3, 'test', '2019-06-11 11:20:06', 'omar', 'omar', '2019-06-06 04:20:06', 0, 5, 'test'),
(4, 'test', '2019-06-11 11:20:08', 'omar', 'omar', '2019-06-06 04:20:08', 0, 5, 'test'),
(5, 'test', '2019-06-11 11:20:11', 'omar', 'omar', '2019-06-06 04:20:11', 0, 5, 'test'),
(6, 'test', '2019-06-11 11:20:13', 'omar', 'omar', '2019-06-06 04:20:13', 0, 5, 'test'),
(7, 'test', '2019-06-11 11:20:16', 'omar', 'omar', '2019-06-06 04:20:16', 0, 5, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `site_members`
--

CREATE TABLE `site_members` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(70) NOT NULL,
  `user_email` varchar(70) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_admin` int(11) NOT NULL,
  `user_tele` varchar(70) NOT NULL,
  `boss` varchar(70) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  `details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `site_members`
--

INSERT INTO `site_members` (`user_id`, `user_name`, `user_email`, `user_password`, `user_admin`, `user_tele`, `boss`, `money`, `details`) VALUES
(45, 'Hassan', 'hassanl22@hotmail.com', '$2y$12$QdQUlaZkhn4I0zONNRiXCeyYuDLAo4bbjC/Hgi2y4A9UUbfQunUwO', 5, '@Katyusha_MASAFAT', '', 0, ''),
(69, 'MDX', 'adousiri8@gmail.com', '$2y$12$nGcchtGcEAB8C7Th0pcbfOtB/0tQwFACDAPJfNe45ZHGrqpM/rMK6', 1, '@MDX5x', 'AhmadBalfaqih', 0, ''),
(70, 'omar', 'o20171900@gmail.com', '$2y$12$vHbejhqkQKJnBDIqeCH1e.mutadLxZovwRFp8v9jUvUUfrC1HzSwO', 3, '@Mr_omarr', 'Hassan', 0, ''),
(71, 'ImMyaw', 'abdulrahman.msafat@gmail.com', '$2y$12$jr242q2/gzAfCcPk.7IUTeYwO1Os2UeW/ufbY9tO/O5dfFhvot2HK', 4, '@ImMyaw', 'Hassan', 0, ''),
(72, 'AhmadBalfaqih', 'abalfaqih303@gmail.com', '$2y$12$HbDa9OsvDc.NJbcec1qbs.itoR/fZbh3k/kSkFeZaUD7XDatyvDvK', 4, '@a_b303', 'Hassan', 0, ''),
(73, 'ThePunisheer', 'mypcgaming01@gmail.com', '$2y$12$D.lcBVOHTK19hbLjMGuekesUHj0CT9DwyTLpM7CFkQO9.iVnLyBv2', 4, '@ThePunisheer1', 'Hassan', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member_tasks`
--
ALTER TABLE `member_tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `site_members`
--
ALTER TABLE `site_members`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member_tasks`
--
ALTER TABLE `member_tasks`
  MODIFY `task_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `site_members`
--
ALTER TABLE `site_members`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
