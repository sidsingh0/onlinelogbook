-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2023 at 09:19 AM
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
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `groupno`, `student_id`, `guide_id`, `sem`, `year`, `title`) VALUES
(7, 1, '20102109', '20102176', 'V', 'TE', 'Hello World'),
(8, 1, '20102109', '20102176', 'V', 'TE', 'Hello World'),
(9, 1, '20102109', '20102176', 'V', 'TE', 'Hello World'),
(10, 1, '20102109', '20102176', 'V', 'TE', 'Hello World'),
(11, 2, '20102137', '20102176', 'IV', 'SE', 'Bye World'),
(12, 2, '20102137', '20102176', 'IV', 'SE', 'Bye World'),
(13, 2, '20102137', '20102176', 'IV', 'SE', 'Bye World'),
(14, 2, '20102137', '20102176', 'IV', 'SE', 'Bye World'),
(15, 3, '20102125', '20102176', 'V', 'TE', 'Wow MOMOS'),
(16, 3, '20102125', '20102176', 'V', 'TE', 'Wow MOMOS'),
(17, 3, '20102125', '20102176', 'V', 'TE', 'Wow MOMOS'),
(18, 3, '20102125', '20102176', 'V', 'TE', 'Wow MOMOS'),
(19, 4, '20102095', '20102095', 'V', 'TE', 'Ev Startup'),
(20, 4, '20102095', '20102095', 'V', 'TE', 'Ev Startup'),
(21, 4, '20102095', '20102095', 'V', 'TE', 'Ev Startup'),
(22, 4, '20102095', '20102095', 'V', 'TE', 'Ev Startup');

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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_content`
--

INSERT INTO `log_content` (`id`, `sem`, `groupno`, `log_no`, `progress_planned`, `progress_achieved`, `guide_review`, `date`) VALUES
(8, 'V', 1, 1, 'project topic socha', 'ho gaya\r\n', 'very good', '2023-02-04'),
(9, 'V', 1, 2, 'done work', 'maja aya', 'nice work', '2023-02-04'),
(10, 'V', 1, 3, 'nice work done', 'hello', 'good work again', '2023-02-04');

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
  `date_to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_creation`
--

INSERT INTO `log_creation` (`id`, `log_no`, `year`, `sem`, `date_from`, `date_to`) VALUES
(1, 1, 'TE', 'V', '2023-02-02', '2023-02-10'),
(2, 2, 'SE', 'IV', '2023-02-18', '2023-02-25'),
(3, 2, 'TE', 'V', '2023-02-02', '2023-02-06'),
(4, 3, 'TE', 'V', '2023-02-03', '2023-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `procos`
--

CREATE TABLE `procos` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `procos`
--

INSERT INTO `procos` (`id`, `username`, `sem`, `year`) VALUES
(1, '20102137', 'V', 'TE');

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
('20102176', 'bandar', 'bandar@pmail.com', '8789685786', 'COMP'),
('20102125', 'godhbandar', 'godhbandar@pmail.com', '8789685786', 'COMP'),
('20102095', 'Samosa Pav', 'samosa@pmail.com', '8789685786', 'COMP');

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
('20102095', '1234', 'guide'),
('20102109', '1234', 'student'),
('20102125', '1234', 'admin'),
('20102137', '1234', 'proco'),
('20102176', '1234', 'guide');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `log_content`
--
ALTER TABLE `log_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `log_creation`
--
ALTER TABLE `log_creation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
