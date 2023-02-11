-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2023 at 05:31 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `groupno` int(11) NOT NULL DEFAULT 0,
  `student_id` varchar(15) NOT NULL,
  `guide_id` varchar(15) NOT NULL,
  `sem` varchar(15) NOT NULL,
  `year` varchar(10) NOT NULL,
  `title` text NOT NULL,
  `division` varchar(5) NOT NULL DEFAULT 'A',
  `aca_year` int(10) NOT NULL DEFAULT year(current_timestamp()),
  `dept` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupno`, `student_id`, `guide_id`, `sem`, `year`, `title`, `division`, `aca_year`, `dept`) VALUES
(1, 1, '1', '20102137', 'IV', 'SE', 'testing simulator', 'B', 2023, 'COMP'),
(2, 1, '2', '20102137', 'IV', 'SE', 'testing simulator', 'B', 2023, 'COMP'),
(3, 1, '3', '20102137', 'IV', 'SE', 'testing simulator', 'B', 2023, 'COMP'),
(10, 1, '4', '20102176', 'VI', 'TE', 'farming sim', 'A', 2023, 'COMP'),
(11, 1, '5', '20102176', 'VI', 'TE', 'farming sim', 'A', 2023, 'COMP'),
(12, 1, '6', '20102176', 'VI', 'TE', 'farming sim', 'A', 2023, 'COMP'),
(13, 1, '7', '20102176', 'VI', 'TE', 'ev truck', 'C', 2023, 'COMP'),
(14, 1, '8', '20102176', 'VI', 'TE', 'ev truck', 'C', 2023, 'COMP'),
(15, 1, '9', '20102176', 'VI', 'TE', 'ev truck', 'C', 2023, 'COMP'),
(16, 2, '20102109', '20102095', 'VI', 'TE', 'gta vice city', 'A', 2023, 'COMP'),
(17, 2, '20102109', '20102095', 'VI', 'TE', 'gta vice city', 'A', 2023, 'COMP'),
(18, 2, '20102109', '20102095', 'VI', 'TE', 'gta vice city', 'A', 2023, 'COMP');

-- --------------------------------------------------------

--
-- Table structure for table `log_content`
--

CREATE TABLE `log_content` (
  `id` int(11) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `groupno` int(11) NOT NULL,
  `log_no` int(11) NOT NULL,
  `progress_planned` text NOT NULL,
  `progress_achieved` text NOT NULL,
  `guide_review` text NOT NULL,
  `date` date NOT NULL,
  `year` varchar(10) NOT NULL,
  `division` varchar(5) NOT NULL,
  `aca_year` int(10) NOT NULL DEFAULT year(current_timestamp()),
  `dept` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log_creation`
--

CREATE TABLE `log_creation` (
  `id` int(11) NOT NULL,
  `log_no` int(11) NOT NULL,
  `year` varchar(15) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `aca_year` int(10) NOT NULL DEFAULT year(current_timestamp()),
  `dept` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `procos`
--

CREATE TABLE `procos` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `dept` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `procos`
--

INSERT INTO `procos` (`id`, `username`, `sem`, `year`, `dept`) VALUES
(1, '20102137', 'VI', 'TE', 'COMP');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `username` varchar(15) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `dept` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`username`, `name`, `email`, `mobile_no`, `dept`) VALUES
('20102109', 'savresh', 'savresh@pmail.com', '8789685786', 'COMP'),
('20102137', 'bandan', 'bandan@pmail.com', '8789685786', 'COMP'),
('20102176', 'Guide Test', 'guide@pmail.com', '8789685786', 'COMP'),
('20102125', 'godhbandar', 'godhbandar@pmail.com', '8789685786', 'COMP'),
('20102095', 'GUIDE TEST1', 'samosa@pmail.com', '8789685786', 'COMP'),
('1', 'abc', 'abc@pmail.com', '8789685786', 'COMP'),
('2', 'weback', 'a4444c@pmail.com', '8789685786', 'COMP'),
('3', 'whdhrhreback', 'a4444c@pmail.com', '8789685786', 'COMP'),
('4', 'blabla', 'a4444c@pmail.com', '8789685786', 'COMP'),
('5', 'beyblade', 'a4444c@pmail.com', '8789685786', 'COMP'),
('6', 'yayyaayya', 'a4444c@pmail.com', '8789685786', 'COMP'),
('7', 'teststudent', 'a4444c@pmail.com', '8789685786', 'COMP'),
('8', 'tesfgesgegegtstudent', 'a4444c@pmail.com', '8789685786', 'COMP'),
('9', 'tesfges tttgegegt student', 'a4444c@pmail.com', '8789685786', 'COMP');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(15) NOT NULL,
  `password` varchar(300) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`) VALUES
('1', '1234', 'student'),
('2', '1234', 'student'),
('20102095', '$2y$10$DNWpyK3m9cABnWmzZjNcq.X6VTYSOS9c7XU3NFmf9F2RDCS0.2Xty', 'guide'),
('20102109', '$2y$10$spmMpkodB0w.aqNWR4gHNOHIGraEzB6UDnC6Z0Q5U2BTQm14H7gxW', 'student'),
('20102125', '$2y$10$xazcHnsBDlToScO8PIts5.CbWVL4WoAjEmBzqbW5yipYQvvIT0S4q', 'admin'),
('20102137', '$2y$10$xD1wFJJucDUoi53zgm8V3e7gwOJH09haI.59VyWVadN5Cl57To..a', 'proco'),
('20102176', '$2y$10$T4MouvBpIy8nnd6Io7dhVOj/Y7mPQkHtGDh5wCAIPCaeVC18DsZfe', 'guide'),
('3', '1234', 'student'),
('4', '1234', 'student'),
('5', '1234', 'student'),
('6', '1234', 'student'),
('7', '1234', 'student'),
('8', '1234', 'student'),
('9', '1234', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_FK_1` (`student_id`),
  ADD KEY `groups_FK_2` (`guide_id`);

--
-- Indexes for table `log_content`
--
ALTER TABLE `log_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_creation`
--
ALTER TABLE `log_creation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procos`
--
ALTER TABLE `procos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD KEY `userinfo_FK_1` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `log_content`
--
ALTER TABLE `log_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_creation`
--
ALTER TABLE `log_creation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procos`
--
ALTER TABLE `procos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_FK_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `groups_FK_2` FOREIGN KEY (`guide_id`) REFERENCES `users` (`username`);

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `userinfo_FK_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
