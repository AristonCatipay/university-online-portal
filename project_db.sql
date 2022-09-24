-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2022 at 12:44 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `timestamp` text DEFAULT NULL,
  `user_id` varchar(10) NOT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `user_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `section_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `class_code` varchar(50) NOT NULL,
  `class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `user_id`, `section_id`, `class_code`, `class_name`) VALUES
('2022-ASGKS', '2022-H50T9', '2022-AAAAA', 'COSC-100', 'Automata Theory and Formal Languages'),
('2022-J8KEY', '2022-H50T9', '2022-ABCDE', 'COSC-TEST', 'This is a test class');

-- --------------------------------------------------------

--
-- Table structure for table `class_announcement`
--

CREATE TABLE `class_announcement` (
  `id` int(11) NOT NULL,
  `teacher_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `section_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_announcement`
--

INSERT INTO `class_announcement` (`id`, `teacher_id`, `section_id`, `content`, `timestamp`) VALUES
(1, '2022-H50T9', '2022-AAAAA', 'This is just a test', '2022-09-24 09:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_cards`
--

CREATE TABLE `dashboard_cards` (
  `id` int(11) NOT NULL,
  `page_path` varchar(120) DEFAULT NULL,
  `color` varchar(120) NOT NULL,
  `title` varchar(250) NOT NULL,
  `icon_name` varchar(64) NOT NULL,
  `result_query` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dashboard_cards`
--

INSERT INTO `dashboard_cards` (`id`, `page_path`, `color`, `title`, `icon_name`, `result_query`) VALUES
(1, 'users', '#000000', 'Accounts', 'fa-solid fa-user', 'SELECT COUNT(id) AS result FROM users;'),
(9, '', '#ff0505', 'Unactivated Accounts', 'fa-solid fa-user-slash', 'SELECT COUNT(id) AS result, date_activated FROM users WHERE date_activated IS NULL;');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `year_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `section_name`, `year_level`) VALUES
('2022-AAAAA', 'BSCS-4A', 4),
('2022-ABCDE', 'BSCS-4B', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `designation_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `date_activated` date DEFAULT NULL,
  `password` text CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `middle_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `profile_file_name` varchar(250) NOT NULL DEFAULT 'no-profile.jpg',
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact_no` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `designation_id`, `user_type_id`, `date_activated`, `password`, `first_name`, `middle_name`, `last_name`, `profile_file_name`, `birthday`, `gender`, `email`, `contact_no`) VALUES
('2022-ABC', 4, 3, '2022-08-04', '$2y$10$er6HROiDqrhvtCmE0EYyF.WXxa8HGmQhUpkULNPAFaEEd9MocKDtW', 'Ariston', 'Lambayan', 'Catipay', '2022-ABC=1660140902.jpg', '2001-03-30', 'male', 'aristoncatipay123@gmail.com', '09389036383'),
('2022-H50T9', 2, 2, '2022-09-23', '$2y$10$MKeqKi20NFp/QeUY5tSjTOBr1cwXO/c5wzrdgQizk3pMQQEFjof.q', 'Ramil', 'H.', 'Huele', '2022-H50T9.png', '2022-09-23', 'male', 'ramil.huele@gmail.com', '0926546135');

-- --------------------------------------------------------

--
-- Table structure for table `user_designation`
--

CREATE TABLE `user_designation` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_designation`
--

INSERT INTO `user_designation` (`id`, `designation_name`) VALUES
(1, 'STUDENT'),
(2, 'TEACHER'),
(4, 'DEVELOPER');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type_name`) VALUES
(1, 'VIEWER'),
(2, 'EDITOR'),
(3, 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `class_announcement`
--
ALTER TABLE `class_announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `section_id_cnn` (`section_id`);

--
-- Indexes for table `dashboard_cards`
--
ALTER TABLE `dashboard_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_dashboard_card_page` (`page_path`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_department` (`designation_id`),
  ADD KEY `user_type` (`user_type_id`);

--
-- Indexes for table `user_designation`
--
ALTER TABLE `user_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `class_announcement`
--
ALTER TABLE `class_announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dashboard_cards`
--
ALTER TABLE `dashboard_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_designation`
--
ALTER TABLE `user_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `section_id` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `class_announcement`
--
ALTER TABLE `class_announcement`
  ADD CONSTRAINT `section_id_cnn` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`),
  ADD CONSTRAINT `teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_designation` FOREIGN KEY (`designation_id`) REFERENCES `user_designation` (`id`),
  ADD CONSTRAINT `user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
