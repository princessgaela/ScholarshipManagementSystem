-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2022 at 02:11 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbscholarship`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `announcement` varchar(10000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `academicyear` year(4) NOT NULL,
  `semester` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `currentyear`
--

CREATE TABLE `currentyear` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `correctanswer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `examscores`
--

CREATE TABLE `examscores` (
  `id` int(11) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `score` varchar(10) NOT NULL,
  `academicyear` year(4) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `accountid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `featuredscholars`
--

CREATE TABLE `featuredscholars` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `course` varchar(100) NOT NULL,
  `yeargraduated` year(4) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `scholarship` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `academicyear` year(4) NOT NULL,
  `semester` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scholars`
--

CREATE TABLE `scholars` (
  `id` int(11) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `name` varchar(500) NOT NULL,
  `course` varchar(10) NOT NULL,
  `yearlevel` varchar(20) NOT NULL,
  `scholarship` varchar(50) NOT NULL,
  `accountid` int(11) NOT NULL,
  `academicyear` year(4) NOT NULL,
  `semester` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scholarshiprequest`
--

CREATE TABLE `scholarshiprequest` (
  `id` int(11) NOT NULL,
  `examscore` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `scholarship` varchar(1000) NOT NULL,
  `studentno` varchar(50) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `course` varchar(20) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `academicyear` year(4) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `civilstatus` varchar(50) NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `contactno` varchar(100) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `fatherstatus` varchar(50) NOT NULL,
  `fathername` varchar(1000) NOT NULL,
  `fatheroccupation` varchar(1000) NOT NULL,
  `fathereducation` varchar(1000) NOT NULL,
  `motherstatus` varchar(50) NOT NULL,
  `mothername` varchar(1000) NOT NULL,
  `motheroccupation` varchar(1000) NOT NULL,
  `mothereducation` varchar(1000) NOT NULL,
  `totalgrossincome` decimal(18,2) NOT NULL,
  `siblings` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `notification` varchar(255) NOT NULL,
  `othernotif` varchar(255) DEFAULT NULL,
  `notifstatus` int(11) NOT NULL,
  `timestamp` time NOT NULL DEFAULT current_timestamp(),
  `notiffor` varchar(255) NOT NULL,
  `accountid` int(11) NOT NULL,
  `requirements` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `briefdescription` text NOT NULL,
  `fulldescription` text NOT NULL,
  `requirements` text NOT NULL,
  `renewal` tinyint(1) NOT NULL,
  `slot` int(11) NOT NULL,
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userlogs`
--

CREATE TABLE `userlogs` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(1000) NOT NULL,
  `author` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `studentno` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(20) NOT NULL,
  `yearlevel` varchar(50) NOT NULL,
  `dateofbirth` date DEFAULT NULL,
  `gender` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `civilstatus` varchar(50) NOT NULL,
  `citizenship` varchar(100) NOT NULL,
  `contactno` varchar(20) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `fatherstatus` varchar(50) NOT NULL,
  `fathername` varchar(1000) NOT NULL,
  `fatheroccupation` varchar(1000) NOT NULL,
  `fathereducation` varchar(1000) NOT NULL,
  `motherstatus` varchar(50) NOT NULL,
  `mothername` varchar(1000) NOT NULL,
  `motheroccupation` varchar(1000) NOT NULL,
  `mothereducation` varchar(1000) NOT NULL,
  `totalgrossincome` decimal(18,2) NOT NULL,
  `siblings` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currentyear`
--
ALTER TABLE `currentyear`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examscores`
--
ALTER TABLE `examscores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featuredscholars`
--
ALTER TABLE `featuredscholars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholars`
--
ALTER TABLE `scholars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarshiprequest`
--
ALTER TABLE `scholarshiprequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `studentno` (`studentno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examscores`
--
ALTER TABLE `examscores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `featuredscholars`
--
ALTER TABLE `featuredscholars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholars`
--
ALTER TABLE `scholars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholarshiprequest`
--
ALTER TABLE `scholarshiprequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
