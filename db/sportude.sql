-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2022 at 09:10 AM
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
  `branch_email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `opening_date` date NOT NULL,
  `revenue` double DEFAULT NULL,
  `owner_id` binary(16) DEFAULT NULL,
  `owner_request_date` date DEFAULT NULL,
  `request_status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `address`, `branch_email`, `city`, `opening_time`, `closing_time`, `opening_date`, `revenue`, `owner_id`, `owner_request_date`, `request_status`) VALUES
(0x11ed5ea66b492747b1c40a0027000004, 'Branch Address 1, Colombo', 'colombobranch@sp.com', 'Colombo', '08:00:00', '18:00:00', '2022-11-07', 0, NULL, NULL, 'a'),
(0x11ed5ea69c453168b1c40a0027000004, 'Branch Address 2, Kiribathgoda', 'kirbathgodabranch@sp.com', 'Kiribathgoda', '09:00:00', '20:00:00', '2022-11-07', 0, NULL, NULL, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `branch_maintenance`
--

CREATE TABLE `branch_maintenance` (
  `branch_id` binary(16) NOT NULL,
  `decision` char(1) NOT NULL,
  `status` varchar(15) NOT NULL,
  `message` varchar(250) NOT NULL,
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
  `photo` varchar(100) NOT NULL
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
  `gender` char(1) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `sport` binary(16) NOT NULL,
  `register_date` date NOT NULL
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
  `coach_monthly_payment` double NOT NULL,
  `time_period` time NOT NULL,
  `no_of_students` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach_qualification`
--

CREATE TABLE `coach_qualification` (
  `coach_id` binary(16) NOT NULL,
  `qualification` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `court_maintenance`
--

CREATE TABLE `court_maintenance` (
  `court_id` binary(16) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `message` varchar(250) NOT NULL,
  `decision` char(1) NOT NULL,
  `requested_receptionist` binary(16) NOT NULL
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
  `email_address` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`user_id`, `username`, `email_address`, `password`, `user_role`, `is_active`) VALUES
(0x11ed59eddbe16fffb1c40a0027000004, 'ramith_rodrigo', 'ramith@yahoo.com', '$2y$10$c.L2T0TrwvjCmmH0hdPK2.TJog.TXkWf8YhgCHI7KbIKHPmy2pTU6', 'user', 1),
(0x11ed604d6f2489c0b1c40a0027000004, 'dihan_hansaja', 'dihanhansaja@gmail.com', '$2y$10$NkNFBMd8VhmhWjq4Hw8oLupFr5pSADhrGGXKAcx8ZZIaStL53Z8vK', 'user', 1),
(0x11ed60a98d7173a5b1c40a0027000004, 'ramith_dulsara', 'ramithdulsara@gmail.com', '$2y$10$/SpxuByD0jbH7ogRdkjIC.nFap48IObS9/Vb0EJ7lT33RJgcBUPU6', 'user', 1),
(0x11ed64a743d47e3fbf8b0a0027000004, 'john_doe', 'johndoe@gmail.com', '$2y$10$sdM2kRu2KNCcpUfhhcwsq.laI2Ju6jUBc.AdQj1rsxsUdgyUALrzq', 'user', 1),
(0x11ed64bca96ac9fabf8b0a0027000004, 'dhanuka_iroshan', 'dhanukairoshan@gmail.com', '$2y$10$ULH8ID8rZo.J9OU/juVs8.9zEN3kH4/jW3XM61etC/NEm7.bnV5j6', 'user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` binary(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` binary(16) NOT NULL,
  `subject` varchar(25) NOT NULL,
  `status` varchar(10) NOT NULL,
  `description` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `lifetime` time DEFAULT NULL,
  `staff_id` binary(16) DEFAULT NULL,
  `user_id` binary(16) DEFAULT NULL,
  `coach_id` binary(16) DEFAULT NULL,
  `owner_id` binary(16) DEFAULT NULL,
  `admin_id` binary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `subject`, `status`, `description`, `date`, `lifetime`, `staff_id`, `user_id`, `coach_id`, `owner_id`, `admin_id`) VALUES
(0x11ed6035dc9c4516b1c40a0027000004, 'test', 'pending', 'asdadsa', '2020-09-22', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` binary(16) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
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
  `no_of_people` int NOT NULL,
  `payment_amount` double NOT NULL,
  `sport_court` binary(16) NOT NULL,
  `user_id` binary(16) DEFAULT NULL,
  `formal_manager_id` binary(16) DEFAULT NULL,
  `onsite_receptionist_id` binary(16) DEFAULT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `date`, `starting_time`, `ending_time`, `no_of_people`, `payment_amount`, `sport_court`, `user_id`, `formal_manager_id`, `onsite_receptionist_id`, `status`) VALUES
(0x11ed5fe4ee1c1ad5b1c40a0027000004, '2022-11-23', '12:30:00', '14:30:00', 5, 700, 0x11ed5ebbfa362095b1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Pending'),
(0x11ed5fe5a58864a9b1c40a0027000004, '2022-11-24', '13:30:00', '14:30:00', 5, 350, 0x11ed5ebbfa362095b1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Cancelled'),
(0x11ed5ff38ca12669b1c40a0027000004, '2022-12-09', '09:00:00', '10:00:00', 2, 350, 0x11ed5f2b8158bd0ab1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Pending'),
(0x11ed5ff525e17c7ab1c40a0027000004, '2022-11-28', '12:00:00', '14:00:00', 4, 700, 0x11ed5ebbfa362095b1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Pending'),
(0x11ed603891bf2a2cb1c40a0027000004, '2022-11-28', '12:00:00', '14:00:00', 2, 700, 0x11ed5f2b8158bd0ab1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Pending'),
(0x11ed603cb027df13b1c40a0027000004, '2022-11-23', '11:30:00', '13:30:00', 3, 700, 0x11ed5ebba056e35fb1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Cancelled'),
(0x11ed603d47d75dadb1c40a0027000004, '2022-11-23', '14:00:00', '16:30:00', 8, 875, 0x11ed5ebba056e35fb1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Pending'),
(0x11ed6426c137963cbf8b0a0027000004, '2022-11-17', '09:30:00', '10:30:00', 4, 500, 0x11ed5ebbcfd61c81b1c40a0027000004, 0x11ed59eddbe16fffb1c40a0027000004, NULL, NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `sport_id` binary(16) NOT NULL,
  `sport_name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  `reservation_price` double NOT NULL,
  `min_coaching_session_price` double NOT NULL,
  `max_no_of_students` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`sport_id`, `sport_name`, `description`, `reservation_price`, `min_coaching_session_price`, `max_no_of_students`) VALUES
(0x11ed5a8c43820cccb1c40a0027000004, 'Badminton', 'badminton is fun', 350, 600, NULL),
(0x11ed5ea6e1819685b1c40a0027000004, 'Basketball', 'Basketball is amazing', 500, 750, NULL),
(0x11ed6182926f56e8b1c40a0027000004, 'Tennis', 'Played with a Tennis Ball', 600, 850, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sports_court`
--

CREATE TABLE `sports_court` (
  `court_id` binary(16) NOT NULL,
  `sport_id` binary(16) NOT NULL,
  `court_name` varchar(5) NOT NULL,
  `branch_id` binary(16) NOT NULL,
  `added_manager` binary(16) DEFAULT NULL,
  `request_status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sports_court`
--

INSERT INTO `sports_court` (`court_id`, `sport_id`, `court_name`, `branch_id`, `added_manager`, `request_status`) VALUES
(0x11ed5ebba056e35fb1c40a0027000004, 0x11ed5a8c43820cccb1c40a0027000004, 'A', 0x11ed5ea66b492747b1c40a0027000004, NULL, 'a'),
(0x11ed5ebbcfd61c81b1c40a0027000004, 0x11ed5ea6e1819685b1c40a0027000004, 'A', 0x11ed5ea66b492747b1c40a0027000004, NULL, 'a'),
(0x11ed5ebbfa362095b1c40a0027000004, 0x11ed5a8c43820cccb1c40a0027000004, 'A', 0x11ed5ea69c453168b1c40a0027000004, NULL, 'a'),
(0x11ed5f2b8158bd0ab1c40a0027000004, 0x11ed5a8c43820cccb1c40a0027000004, 'B', 0x11ed5ea69c453168b1c40a0027000004, NULL, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `sports_court_photo`
--

CREATE TABLE `sports_court_photo` (
  `court_photo_id` binary(16) NOT NULL,
  `court_id` binary(16) NOT NULL,
  `court_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` binary(16) NOT NULL,
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
  `admin_id` binary(16) NOT NULL
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
  `gender` char(1) NOT NULL,
  `profile_photo` varchar(100) DEFAULT NULL,
  `home_address` varchar(250) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `birthday` date NOT NULL,
  `register_date` date NOT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `gender`, `profile_photo`, `home_address`, `contact_num`, `birthday`, `register_date`, `height`, `weight`) VALUES
(0x11ed59eddbe16fffb1c40a0027000004, 'Ramith', 'Rodrigo', 'f', NULL, 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0767275867', '2008-10-13', '2022-11-01', 2, 3),
(0x11ed604d6f2489c0b1c40a0027000004, 'Dihan', 'Hansaja', 'm', NULL, 'Dihan&amp;#039;s Address', '0786542891', '2000-07-18', '2022-11-09', 174, 50),
(0x11ed60a98d7173a5b1c40a0027000004, 'Ramith', 'Dulsara', 'm', 'ramith_dulsara636c72e5adc60.jpg', 'Ramith Address', '0767275867', '2008-05-17', '2022-11-10', 178, 60),
(0x11ed64a743d47e3fbf8b0a0027000004, 'John', 'Doe', 'm', NULL, '102/3B, Kiribathgoda', '07542136549', '1995-07-22', '2022-11-15', 166, 65),
(0x11ed64bca96ac9fabf8b0a0027000004, 'Dhanuka', 'Iroshan', 'm', NULL, 'Dhanuka address', '0755412365', '1999-06-18', '2022-11-15', 175, 64);

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
(0x11ed59eddbe16fffb1c40a0027000004, 'Dulsara', 'Sibling', '0233654782'),
(0x11ed604d6f2489c0b1c40a0027000004, 'De Silva', 'Sibling 1', '0774123654'),
(0x11ed604d6f2489c0b1c40a0027000004, 'Sujith', 'Sibling 2', '0741369852'),
(0x11ed60a98d7173a5b1c40a0027000004, 'Ajith', 'Father', '0714831744'),
(0x11ed64a743d47e3fbf8b0a0027000004, 'Kevin', 'Friend 1', '0365482154'),
(0x11ed64bca96ac9fabf8b0a0027000004, 'Test', 'Sibling 1', '0236541258'),
(0x11ed64bca96ac9fabf8b0a0027000004, 'Test two', 'Sibling 2', '0785412368');

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
(0x11ed604d6f2489c0b1c40a0027000004, 'short sighted'),
(0x11ed60a98d7173a5b1c40a0027000004, 'headaches'),
(0x11ed64bca96ac9fabf8b0a0027000004, 'another concern'),
(0x11ed64bca96ac9fabf8b0a0027000004, 'concern');

-- --------------------------------------------------------

--
-- Table structure for table `user_request_coaching_session`
--

CREATE TABLE `user_request_coaching_session` (
  `user_id` binary(16) NOT NULL,
  `session_id` binary(16) NOT NULL,
  `request_date` date NOT NULL,
  `message` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD UNIQUE KEY `branch_email` (`branch_email`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `branch_maintenance`
--
ALTER TABLE `branch_maintenance`
  ADD PRIMARY KEY (`branch_id`,`starting_date`),
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
  ADD KEY `sport` (`sport`);

--
-- Indexes for table `coaching_session`
--
ALTER TABLE `coaching_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `court_ID` (`court_id`),
  ADD KEY `coach_id` (`coach_id`);

--
-- Indexes for table `coach_qualification`
--
ALTER TABLE `coach_qualification`
  ADD PRIMARY KEY (`coach_id`,`qualification`);

--
-- Indexes for table `court_maintenance`
--
ALTER TABLE `court_maintenance`
  ADD PRIMARY KEY (`court_id`,`starting_date`),
  ADD KEY `requested_receptionist` (`requested_receptionist`);

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
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email_address` (`email_address`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `coach_id` (`coach_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`);

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
-- Indexes for table `sports_court_photo`
--
ALTER TABLE `sports_court_photo`
  ADD PRIMARY KEY (`court_photo_id`),
  ADD KEY `court_id` (`court_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
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
  ADD PRIMARY KEY (`user_id`);

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
-- Indexes for table `user_request_coaching_session`
--
ALTER TABLE `user_request_coaching_session`
  ADD PRIMARY KEY (`user_id`,`session_id`),
  ADD KEY `session_id` (`session_id`);

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
  ADD CONSTRAINT `branch_maintenance_ibfk_2` FOREIGN KEY (`requested_receptionist`) REFERENCES `receptionist` (`receptionist_id`),
  ADD CONSTRAINT `branch_maintenance_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
-- Constraints for table `coach_qualification`
--
ALTER TABLE `coach_qualification`
  ADD CONSTRAINT `coach_qualification_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`coach_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `court_maintenance`
--
ALTER TABLE `court_maintenance`
  ADD CONSTRAINT `court_maintenance_ibfk_1` FOREIGN KEY (`court_id`) REFERENCES `sports_court` (`court_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `court_maintenance_ibfk_2` FOREIGN KEY (`requested_receptionist`) REFERENCES `receptionist` (`receptionist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `system_admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`coach_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_4` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `sports_court_photo`
--
ALTER TABLE `sports_court_photo`
  ADD CONSTRAINT `sports_court_photo_ibfk_1` FOREIGN KEY (`court_id`) REFERENCES `sports_court` (`court_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `user_dependent_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_medical_concern`
--
ALTER TABLE `user_medical_concern`
  ADD CONSTRAINT `user_medical_concern_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_request_coaching_session`
--
ALTER TABLE `user_request_coaching_session`
  ADD CONSTRAINT `user_request_coaching_session_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `coaching_session` (`session_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_request_coaching_session_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;