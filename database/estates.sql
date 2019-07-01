-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2019 at 01:10 PM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estates`
--

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `amt` float NOT NULL,
  `ref` varchar(20) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `last_added` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materials_required`
--

CREATE TABLE IF NOT EXISTS `materials_required` (
  `work_id` int(11) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `request` text,
  `id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL,
  `f_name` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `pass` varchar(80) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'FREE',
  `rank` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work_assigned`
--

CREATE TABLE IF NOT EXISTS `work_assigned` (
  `id` int(11) NOT NULL,
  `work_id` int(11) NOT NULL,
  `user_id` tinytext NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work_request`
--

CREATE TABLE IF NOT EXISTS `work_request` (
  `id` int(11) NOT NULL,
  `description` text,
  `requestedBy` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `buildingName` varchar(20) NOT NULL,
  `roomName` varchar(20) NOT NULL,
  `repairClass` varchar(20) NOT NULL,
  `status` varchar(25) DEFAULT NULL,
  `dateRequested` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials_required`
--
ALTER TABLE `materials_required`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_id` (`work_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `work_assigned`
--
ALTER TABLE `work_assigned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_id` (`work_id`);

--
-- Indexes for table `work_request`
--
ALTER TABLE `work_request`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `materials_required`
--
ALTER TABLE `materials_required`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `work_assigned`
--
ALTER TABLE `work_assigned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `work_request`
--
ALTER TABLE `work_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `materials_required`
--
ALTER TABLE `materials_required`
  ADD CONSTRAINT `materials_required_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `work_request` (`id`);

--
-- Constraints for table `work_assigned`
--
ALTER TABLE `work_assigned`
  ADD CONSTRAINT `work_assigned_ibfk_1` FOREIGN KEY (`work_id`) REFERENCES `work_request` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
