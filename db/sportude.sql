-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2022 at 03:21 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportude`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` binary(16) NOT NULL,
  `address` varchar(250) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `opening_date` date NOT NULL,
  `revenue` double DEFAULT NULL,
  `owner_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_maintenance`
--

CREATE TABLE `branch_maintenance` (
  `branch_id` binary(16) NOT NULL,
  `decision` char(1) NOT NULL,
  `status` varchar(15) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `requested_receptionist` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_photo`
--

CREATE TABLE `branch_photo` (
  `branch_photo_id` binary(16) NOT NULL,
  `branch_id` binary(16) NOT NULL,
  `photo` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `coach_id` binary(16) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `home_address` varchar(250) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `gender` char(1) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `photo` mediumblob NOT NULL,
  `sport` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coaching_session`
--

CREATE TABLE `coaching_session` (
  `session_id` binary(16) NOT NULL,
  `coach_id` binary(16) NOT NULL,
  `court_id` binary(16) NOT NULL,
  `day` varchar(15) NOT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  `payment_amount` double NOT NULL,
  `time_period` time NOT NULL,
  `no_of_students` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `manager_id` binary(16) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `decision` char(1) NOT NULL,
  `discount_value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `user_id` binary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`user_id`, `username`, `password`, `user_role`) VALUES
(0x11ed59ea897760fdb1c40a0027000004, 'johndoe', '$2y$10$aMSXNdKDJYL6lNo5oK4OxOi9yHI47AyLzYlLcF8..NZoFt4WOvC52', 'user'),
(0x11ed59eddbe16fffb1c40a0027000004, 'ramith_rodrigo', '$2y$10$c.L2T0TrwvjCmmH0hdPK2.TJog.TXkWf8YhgCHI7KbIKHPmy2pTU6', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` binary(16) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `receptionist_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` binary(16) NOT NULL,
  `date` date NOT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  `payment_amount` double NOT NULL,
  `sport_court` binary(16) NOT NULL,
  `user_id` binary(16) DEFAULT NULL,
  `formal_manager_id` binary(16) DEFAULT NULL,
  `onsite_receptionist_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `sport_id` binary(16) NOT NULL,
  `sport_name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  `reservation_price` double NOT NULL,
  `min_coaching_session_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sports_court`
--

CREATE TABLE `sports_court` (
  `court_id` binary(16) NOT NULL,
  `sport_id` binary(16) NOT NULL,
  `court_name` varchar(5) NOT NULL,
  `branch_id` binary(16) NOT NULL,
  `added_manager` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` binary(16) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `gender` char(1) NOT NULL,
  `date_of_birth` date NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `join_date` date NOT NULL,
  `leave_date` date DEFAULT NULL,
  `branch_id` binary(16) NOT NULL,
  `staff_role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stud_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_coach_feedback`
--

CREATE TABLE `student_coach_feedback` (
  `feedback_id` binary(16) NOT NULL,
  `coach_id` binary(16) NOT NULL,
  `stud_id` binary(16) NOT NULL,
  `description` varchar(250) NOT NULL,
  `rating` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_registered_session`
--

CREATE TABLE `student_registered_session` (
  `stud_id` binary(16) NOT NULL,
  `session_id` binary(16) NOT NULL,
  `join_date` date NOT NULL,
  `leave_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_session_payment`
--

CREATE TABLE `student_session_payment` (
  `payment_id` binary(16) NOT NULL,
  `session_id` binary(16) NOT NULL,
  `stud_id` binary(16) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_admin`
--

CREATE TABLE `system_admin` (
  `admin_id` binary(16) NOT NULL,
  `email_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_maintenance`
--

CREATE TABLE `system_maintenance` (
  `admin_id` binary(16) NOT NULL,
  `starting_date` date NOT NULL,
  `starting_time` time NOT NULL,
  `expected_downtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` binary(16) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `gender` char(1) NOT NULL,
  `home_address` varchar(250) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `birthday` date NOT NULL,
  `register_date` date NOT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email_address`, `gender`, `home_address`, `contact_num`, `birthday`, `register_date`, `height`, `weight`, `is_active`) VALUES
(0x11ed59ea897760fdb1c40a0027000004, 'John', 'Doe', 'johndoe@gmail.com', 'm', 'No.234/4A, Reid Avenue, Colombo', '0714563211', '2000-05-09', '2022-11-01', 157, NULL, 1),
(0x11ed59eddbe16fffb1c40a0027000004, 'Ramith', 'Rodrigo', 'ramith@yahoo.com', 'f', 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0767275867', '2008-10-13', '2022-11-01', 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_branch_feedback`
--

CREATE TABLE `user_branch_feedback` (
  `userfeedback_id` binary(16) NOT NULL,
  `user_id` binary(16) NOT NULL,
  `branch_id` binary(16) NOT NULL,
  `date` date NOT NULL,
  `rating` int NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_dependent`
--

CREATE TABLE `user_dependent` (
  `owner_id` binary(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `relationship` varchar(25) NOT NULL,
  `contact_num` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_dependent`
--

INSERT INTO `user_dependent` (`owner_id`, `name`, `relationship`, `contact_num`) VALUES
(0x11ed59ea897760fdb1c40a0027000004, 'David', 'father', '0147852345'),
(0x11ed59ea897760fdb1c40a0027000004, 'Kelly', 'mother', '0786542387'),
(0x11ed59ea897760fdb1c40a0027000004, 'Kenny', 'sibling', '9856374128'),
(0x11ed59eddbe16fffb1c40a0027000004, 'Dulsara', 'Sibling', '0233654782');

-- --------------------------------------------------------

--
-- Table structure for table `user_medical_concern`
--

CREATE TABLE `user_medical_concern` (
  `user_id` binary(16) NOT NULL,
  `medical_concern` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_medical_concern`
--

INSERT INTO `user_medical_concern` (`user_id`, `medical_concern`) VALUES
(0x11ed59ea897760fdb1c40a0027000004, 'back pains'),
(0x11ed59ea897760fdb1c40a0027000004, 'chest pains'),
(0x11ed59ea897760fdb1c40a0027000004, 'leg cramps'),
(0x11ed59ea897760fdb1c40a0027000004, 'poor eyesights');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `branch_maintenance`
--
ALTER TABLE `branch_maintenance`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `requested_receptionist` (`requested_receptionist`);

--
-- Indexes for table `branch_photo`
--
ALTER TABLE `branch_photo`
  ADD PRIMARY KEY (`branch_photo_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`coach_id`),
  ADD UNIQUE KEY `emailAddress` (`email_address`),
  ADD KEY `sport` (`sport`);

--
-- Indexes for table `coaching_session`
--
ALTER TABLE `coaching_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `court_ID` (`court_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`manager_id`,`starting_date`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`receptionist_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `sport_court` (`sport_court`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `formal_manager_id` (`formal_manager_id`),
  ADD KEY `onsite_receptionist_id` (`onsite_receptionist_id`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`sport_id`);

--
-- Indexes for table `sports_court`
--
ALTER TABLE `sports_court`
  ADD PRIMARY KEY (`court_id`),
  ADD KEY `added_manager` (`added_manager`),
  ADD KEY `sport_id` (`sport_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email_address` (`email_address`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stud_id`);

--
-- Indexes for table `student_coach_feedback`
--
ALTER TABLE `student_coach_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `coach_ID` (`coach_id`),
  ADD KEY `stud_ID` (`stud_id`);

--
-- Indexes for table `student_registered_session`
--
ALTER TABLE `student_registered_session`
  ADD PRIMARY KEY (`stud_id`,`session_id`),
  ADD KEY `session_ID` (`session_id`);

--
-- Indexes for table `student_session_payment`
--
ALTER TABLE `student_session_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `session_ID` (`session_id`),
  ADD KEY `stud_ID` (`stud_id`);

--
-- Indexes for table `system_admin`
--
ALTER TABLE `system_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  ADD PRIMARY KEY (`admin_id`,`starting_date`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `emailAddress` (`email_address`);

--
-- Indexes for table `user_branch_feedback`
--
ALTER TABLE `user_branch_feedback`
  ADD PRIMARY KEY (`userfeedback_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_dependent`
--
ALTER TABLE `user_dependent`
  ADD PRIMARY KEY (`owner_id`,`name`);

--
-- Indexes for table `user_medical_concern`
--
ALTER TABLE `user_medical_concern`
  ADD PRIMARY KEY (`user_id`,`medical_concern`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`);

--
-- Constraints for table `branch_maintenance`
--
ALTER TABLE `branch_maintenance`
  ADD CONSTRAINT `branch_maintenance_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `branch_maintenance_ibfk_2` FOREIGN KEY (`requested_receptionist`) REFERENCES `receptionist` (`receptionist_id`);

--
-- Constraints for table `branch_photo`
--
ALTER TABLE `branch_photo`
  ADD CONSTRAINT `branch_photo_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `login_details` (`user_id`),
  ADD CONSTRAINT `coach_ibfk_2` FOREIGN KEY (`sport`) REFERENCES `sport` (`sport_id`);

--
-- Constraints for table `coaching_session`
--
ALTER TABLE `coaching_session`
  ADD CONSTRAINT `coaching_session_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`coach_id`),
  ADD CONSTRAINT `coaching_session_ibfk_2` FOREIGN KEY (`court_id`) REFERENCES `sports_court` (`court_id`);

--
-- Constraints for table `discount`
--
ALTER TABLE `discount`
  ADD CONSTRAINT `discount_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`manager_id`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `login_details` (`user_id`);

--
-- Constraints for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD CONSTRAINT `receptionist_ibfk_1` FOREIGN KEY (`receptionist_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`sport_court`) REFERENCES `sports_court` (`court_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`formal_manager_id`) REFERENCES `manager` (`manager_id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`onsite_receptionist_id`) REFERENCES `receptionist` (`receptionist_id`);

--
-- Constraints for table `sports_court`
--
ALTER TABLE `sports_court`
  ADD CONSTRAINT `sports_court_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`sport_id`),
  ADD CONSTRAINT `sports_court_ibfk_2` FOREIGN KEY (`added_manager`) REFERENCES `manager` (`manager_id`),
  ADD CONSTRAINT `sports_court_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `login_details` (`user_id`),
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`stud_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `student_coach_feedback`
--
ALTER TABLE `student_coach_feedback`
  ADD CONSTRAINT `student_coach_feedback_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`coach_id`),
  ADD CONSTRAINT `student_coach_feedback_ibfk_2` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `student_registered_session`
--
ALTER TABLE `student_registered_session`
  ADD CONSTRAINT `student_registered_session_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `coaching_session` (`session_id`),
  ADD CONSTRAINT `student_registered_session_ibfk_2` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `student_session_payment`
--
ALTER TABLE `student_session_payment`
  ADD CONSTRAINT `student_session_payment_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `coaching_session` (`session_id`),
  ADD CONSTRAINT `student_session_payment_ibfk_2` FOREIGN KEY (`stud_id`) REFERENCES `student` (`stud_id`);

--
-- Constraints for table `system_admin`
--
ALTER TABLE `system_admin`
  ADD CONSTRAINT `system_admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `login_details` (`user_id`);

--
-- Constraints for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  ADD CONSTRAINT `system_maintenance_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `system_admin` (`admin_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login_details` (`user_id`);

--
-- Constraints for table `user_branch_feedback`
--
ALTER TABLE `user_branch_feedback`
  ADD CONSTRAINT `user_branch_feedback_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `user_branch_feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_dependent`
--
ALTER TABLE `user_dependent`
  ADD CONSTRAINT `user_dependent_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_medical_concern`
--
ALTER TABLE `user_medical_concern`
  ADD CONSTRAINT `user_medical_concern_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
