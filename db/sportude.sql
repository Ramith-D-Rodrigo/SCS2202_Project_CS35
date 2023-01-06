-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2023 at 05:40 PM
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
  `branch_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(250) NOT NULL,
  `branch_email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `opening_date` date NOT NULL,
  `revenue` double DEFAULT NULL,
  `owner_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `curr_manager` varchar(35) DEFAULT NULL,
  `curr_receptionist` varchar(35) DEFAULT NULL,
  `owner_request_date` date DEFAULT NULL,
  `request_status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `address`, `branch_email`, `city`, `opening_time`, `closing_time`, `opening_date`, `revenue`, `owner_id`, `curr_manager`, `curr_receptionist`, `owner_request_date`, `request_status`) VALUES
('kiri987521', 'Example Road, Kiribathgoda', 'kribathgodabr@sp.com', 'Kiribathgoda', '08:00:00', '19:30:00', '2022-11-26', NULL, NULL, 'managerkiri5436', 'receptionistkiri1241', NULL, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `branch_maintenance`
--

CREATE TABLE `branch_maintenance` (
  `decision` char(1) NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requested_receptionist` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `branch_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_photo`
--

CREATE TABLE `branch_photo` (
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `branch_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `coach_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `first_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `home_address` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sport` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `register_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`coach_id`, `first_name`, `last_name`, `home_address`, `birthday`, `gender`, `sport`, `contact_num`, `photo`, `register_date`) VALUES
('coach_63b70ff6dc7152.69619366', 'Seniru', 'Wijesinghe', 'Seniru&amp;#039;s Address', '2002-06-11', 'm', 'bad65421', '0774785153', '../../public/coach/profile_images/seniru_semal63b70ff6de032.png', '2023-01-05'),
('coach_tha63b71e629627b', 'Tharuka', 'Dileepana', 'THaruka address', '2004-12-30', 'm', 'basket17212', '0778587412', '../../public/coach/profile_images/tharuka_boss63b71e62963b5.png', '2023-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `coaching_session`
--

CREATE TABLE `coaching_session` (
  `session_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coach_monthly_payment` double NOT NULL,
  `time_period` time NOT NULL,
  `no_of_students` int NOT NULL,
  `coach_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `court_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `day` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  `payment_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach_qualification`
--

CREATE TABLE `coach_qualification` (
  `qualification` varchar(75) NOT NULL,
  `coach_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `court_maintenance`
--

CREATE TABLE `court_maintenance` (
  `decision` char(1) NOT NULL,
  `starting_date` date NOT NULL,
  `court_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ending_date` date NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requested_receptionist` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `manager_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `decision` char(1) NOT NULL,
  `discount_value` double NOT NULL,
  `branch_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`user_id`, `username`, `email_address`, `password`, `user_role`, `is_active`) VALUES
('coach_63b70ff6dc7152.69619366', 'seniru_semal', 'senirusemal@gmail.com', '$2y$10$U7AW9mirbKDOsKUFX89nduIVKRxInT9EHa3SmdSGqXye8gmENS8ci', 'coach', 1),
('coach_tha63b71e629627b', 'tharuka_boss', 'tharuka@gmail.com', '$2y$10$PzMhfrF/93rjFXlWv/3g.emBXM9JzxJK1335OMwJap9QuffUl7Uri', 'coach', 1),
('dihHan6384813878b75', 'dihan_hansaja', 'dihanhansaja@gmail.com', '$2y$10$3uW4pZCt0.MERJKzCxqypuStR38ARbHD8WuuVuZZN8S6jimPS8aXy', 'user', 1),
('kamPer638656b5362c7', 'kamal_per', 'kamalperera@hotmail.com', '$2y$10$d3CoQvOnHJ4O4VkQwV96s.3LMfjG4.m1G.Kc7agF/aMQW4IsTZ0PG', 'user', 1),
('managerkiri5436', 'manager_test', 'manager@kiribathgoda.com', '$2y$10$QuFv7nJToOszzmtRExiTtuUNvBrJjedqetonaCLLKnYlUbstMWsSW', 'manager', 1),
('nihWij638657d83c715', 'nihal_wij', 'nihal_wije@gmail.com', '$2y$10$dWp4y/hWGGWNICJzgTdM.e0EBAZcd7qUZEOJAQrEQ43ptT3kVcPfK', 'user', 1),
('ramRod63816dc9007b4', 'ramith_rodrigo', 'ramithrodrigo@hotmail.com', '$2y$10$AWdjh.zjhx563bGv6xN1TuBzR4VhvByTOGKWumo5Cg6L.DFijPBxq', 'user', 1),
('receptionistkiri1241', 'receptionist_test', 'receptionist@kiribathgoda.com', 'Testing54321', 'receptionist', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`manager_id`) VALUES
('managerkiri5436');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subject` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `lifetime` time DEFAULT NULL,
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `receptionist_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`receptionist_id`) VALUES
('receptionistkiri1241');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `starting_time` time NOT NULL,
  `ending_time` time NOT NULL,
  `no_of_people` int NOT NULL,
  `payment_amount` double NOT NULL,
  `sport_court` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `formal_manager_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `onsite_receptionist_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `date`, `starting_time`, `ending_time`, `no_of_people`, `payment_amount`, `sport_court`, `status`, `user_id`, `formal_manager_id`, `onsite_receptionist_id`) VALUES
('Res-ram6381ff1962f37', '2022-12-03', '09:00:00', '12:00:00', 4, 1050, 'badcourt1213', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL),
('Res-ram6389552c34f9a', '2022-12-17', '09:00:00', '12:00:00', 3, 1050, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL),
('Res-ram638955f9d5247', '2022-12-17', '16:00:00', '18:00:00', 3, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL),
('Res-ram6389622caecf9', '2022-12-14', '17:00:00', '18:30:00', 1, 525, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `sport_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sport_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(100) NOT NULL,
  `reservation_price` double NOT NULL,
  `min_coaching_session_price` double NOT NULL,
  `max_no_of_students` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`sport_id`, `sport_name`, `description`, `reservation_price`, `min_coaching_session_price`, `max_no_of_students`) VALUES
('bad65421', 'Badminton', 'Fun game to play with friends', 350, 1000, 10),
('basket17212', 'Basketball', 'basketball is fun', 500, 1000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `sports_court`
--

CREATE TABLE `sports_court` (
  `court_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sport_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `court_name` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `branch_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `request_status` char(1) NOT NULL,
  `added_manager` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sports_court`
--

INSERT INTO `sports_court` (`court_id`, `sport_id`, `court_name`, `branch_id`, `request_status`, `added_manager`) VALUES
('badcourt1212', 'bad65421', 'A', 'kiri987521', 'a', NULL),
('badcourt1213', 'bad65421', 'B', 'kiri987521', 'a', NULL),
('basketcourt345', 'basket17212', 'A', 'kiri987521', 'a', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sports_court_photo`
--

CREATE TABLE `sports_court_photo` (
  `court_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `court_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contact_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `join_date` date NOT NULL,
  `leave_date` date DEFAULT NULL,
  `staff_role` varchar(15) NOT NULL,
  `branch_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `contact_number`, `gender`, `date_of_birth`, `first_name`, `last_name`, `join_date`, `leave_date`, `staff_role`, `branch_id`) VALUES
('managerkiri5436', '0785412368', 'm', '1975-10-11', 'Namal', 'Rajapaksa', '2022-10-11', NULL, 'manager', 'kiri987521'),
('receptionistkiri1241', '0741236585', 'f', '1994-12-09', 'Amali', 'Kulasinghe', '2022-12-01', NULL, 'receptionist', 'kiri987521');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stu_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stu_id`) VALUES
('ramRod63816dc9007b4');

-- --------------------------------------------------------

--
-- Table structure for table `student_coach_feedback`
--

CREATE TABLE `student_coach_feedback` (
  `feedback_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(250) NOT NULL,
  `rating` int NOT NULL,
  `coach_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stu_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_coach_feedback`
--

INSERT INTO `student_coach_feedback` (`feedback_id`, `description`, `rating`, `coach_id`, `stu_id`) VALUES
('feedback1', 'asdasdad ', 5, 'coach_tha63b71e629627b', 'ramRod63816dc9007b4'),
('feedback2', 'asdasdad ', 3, 'coach_tha63b71e629627b', 'ramRod63816dc9007b4'),
('feedback4', 'asdasdad ', 2, 'coach_63b70ff6dc7152.69619366', 'ramRod63816dc9007b4');

-- --------------------------------------------------------

--
-- Table structure for table `student_registered_session`
--

CREATE TABLE `student_registered_session` (
  `stu_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `session_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `join_date` date NOT NULL,
  `leave_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_session_payment`
--

CREATE TABLE `student_session_payment` (
  `payment_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stu_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `session_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_admin`
--

CREATE TABLE `system_admin` (
  `admin_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_maintenance`
--

CREATE TABLE `system_maintenance` (
  `expected_downtime` time NOT NULL,
  `admin_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `starting_date` date NOT NULL,
  `starting_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profile_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `home_address` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contact_num` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birthday` date NOT NULL,
  `register_date` date NOT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `gender`, `profile_photo`, `home_address`, `contact_num`, `birthday`, `register_date`, `height`, `weight`) VALUES
('dihHan6384813878b75', 'Dihan', 'Hansaja', 'm', '../../public/user/profile_images/dihan_hansaja6384813878ccc.jpg', 'Dihan&amp;#039;s Address, Ambalangoda', '0786541239', '2000-07-04', '2022-11-28', 170, 55),
('kamPer638656b5362c7', 'Kamal', 'Perera', 'm', NULL, 'Madamulana, Sri Lanka', '0715423658', '2003-05-09', '2022-11-29', 166, 66),
('nihWij638657d83c715', 'Nihal', 'Wijesinghe', 'm', NULL, 'Some road, Galle', '0789654125', '1996-07-26', '2022-11-29', 177, 69),
('ramRod63816dc9007b4', 'Ramith', 'Rodrigo', 'm', '../../public/user/profile_images/ramith_rodrigo63816dc90092f.jpg', 'No.301/5 Mihindu Mawatha, Makola North, Makola', '0767275867', '2000-09-01', '2022-11-26', 178, 56);

-- --------------------------------------------------------

--
-- Table structure for table `user_branch_feedback`
--

CREATE TABLE `user_branch_feedback` (
  `userfeedback_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `rating` int NOT NULL,
  `description` varchar(500) NOT NULL,
  `branch_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_branch_feedback`
--

INSERT INTO `user_branch_feedback` (`userfeedback_id`, `user_id`, `date`, `rating`, `description`, `branch_id`) VALUES
('feedback1', 'ramRod63816dc9007b4', '2023-01-13', 4, 'The factilities were quite good and clean. We had lots of fun and hoping to come back soon!', 'kiri987521');

-- --------------------------------------------------------

--
-- Table structure for table `user_dependent`
--

CREATE TABLE `user_dependent` (
  `owner_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `relationship` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contact_num` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_dependent`
--

INSERT INTO `user_dependent` (`owner_id`, `name`, `relationship`, `contact_num`) VALUES
('dihHan6384813878b75', 'Kamal', 'Sibling 1', '0774532158'),
('dihHan6384813878b75', 'Ramith', 'Friend 1', '0767275867'),
('kamPer638656b5362c7', 'Sunil', 'Father', '0716525854'),
('nihWij638657d83c715', 'Amitha', 'Partner', '0774532174'),
('ramRod63816dc9007b4', 'Ajith', 'Father', '0714831556'),
('ramRod63816dc9007b4', 'Champa', 'Mother', '0776512846');

-- --------------------------------------------------------

--
-- Table structure for table `user_medical_concern`
--

CREATE TABLE `user_medical_concern` (
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `medical_concern` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_medical_concern`
--

INSERT INTO `user_medical_concern` (`user_id`, `medical_concern`) VALUES
('dihHan6384813878b75', 'back pain'),
('dihHan6384813878b75', 'headache'),
('dihHan6384813878b75', 'my concern'),
('kamPer638656b5362c7', 'broken and fixed leg'),
('ramRod63816dc9007b4', 'concern one'),
('ramRod63816dc9007b4', 'concern two');

-- --------------------------------------------------------

--
-- Table structure for table `user_request_coaching_session`
--

CREATE TABLE `user_request_coaching_session` (
  `user_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `session_id` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
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
  ADD UNIQUE KEY `curr_manager` (`curr_manager`),
  ADD UNIQUE KEY `curr_receptionist` (`curr_receptionist`),
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
  ADD PRIMARY KEY (`photo`,`branch_id`),
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
  ADD KEY `coach_id` (`coach_id`),
  ADD KEY `court_id` (`court_id`);

--
-- Indexes for table `coach_qualification`
--
ALTER TABLE `coach_qualification`
  ADD PRIMARY KEY (`qualification`,`coach_id`),
  ADD KEY `coach_id` (`coach_id`);

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
  ADD PRIMARY KEY (`manager_id`,`starting_date`),
  ADD KEY `branch_id` (`branch_id`);

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
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `sport_id` (`sport_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `added_manager` (`added_manager`);

--
-- Indexes for table `sports_court_photo`
--
ALTER TABLE `sports_court_photo`
  ADD PRIMARY KEY (`court_photo`,`court_id`),
  ADD KEY `court_id` (`court_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `contact_number` (`contact_number`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stu_id`);

--
-- Indexes for table `student_coach_feedback`
--
ALTER TABLE `student_coach_feedback`
  ADD KEY `coach_id` (`coach_id`),
  ADD KEY `stu_id` (`stu_id`);

--
-- Indexes for table `student_registered_session`
--
ALTER TABLE `student_registered_session`
  ADD PRIMARY KEY (`stu_id`,`session_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `student_session_payment`
--
ALTER TABLE `student_session_payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `stu_id` (`stu_id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `branch_id` (`branch_id`);

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
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `branch_ibfk_2` FOREIGN KEY (`curr_manager`) REFERENCES `manager` (`manager_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `branch_ibfk_3` FOREIGN KEY (`curr_receptionist`) REFERENCES `receptionist` (`receptionist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `branch_maintenance`
--
ALTER TABLE `branch_maintenance`
  ADD CONSTRAINT `branch_maintenance_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `branch_maintenance_ibfk_2` FOREIGN KEY (`requested_receptionist`) REFERENCES `receptionist` (`receptionist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `branch_photo`
--
ALTER TABLE `branch_photo`
  ADD CONSTRAINT `branch_photo_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `login_details` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coach_ibfk_2` FOREIGN KEY (`sport`) REFERENCES `sport` (`sport_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coaching_session`
--
ALTER TABLE `coaching_session`
  ADD CONSTRAINT `coaching_session_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`coach_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coaching_session_ibfk_2` FOREIGN KEY (`court_id`) REFERENCES `sports_court` (`court_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `discount_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`manager_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `discount_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `staff` (`staff_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login_details` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `login_details` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD CONSTRAINT `receptionist_ibfk_1` FOREIGN KEY (`receptionist_id`) REFERENCES `staff` (`staff_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`sport_court`) REFERENCES `sports_court` (`court_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`formal_manager_id`) REFERENCES `manager` (`manager_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`onsite_receptionist_id`) REFERENCES `receptionist` (`receptionist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sports_court`
--
ALTER TABLE `sports_court`
  ADD CONSTRAINT `sports_court_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`sport_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sports_court_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sports_court_ibfk_3` FOREIGN KEY (`added_manager`) REFERENCES `manager` (`manager_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sports_court_photo`
--
ALTER TABLE `sports_court_photo`
  ADD CONSTRAINT `sports_court_photo_ibfk_1` FOREIGN KEY (`court_id`) REFERENCES `sports_court` (`court_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `login_details` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_coach_feedback`
--
ALTER TABLE `student_coach_feedback`
  ADD CONSTRAINT `student_coach_feedback_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `coach` (`coach_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_coach_feedback_ibfk_2` FOREIGN KEY (`stu_id`) REFERENCES `student` (`stu_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_registered_session`
--
ALTER TABLE `student_registered_session`
  ADD CONSTRAINT `student_registered_session_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `student` (`stu_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_registered_session_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `coaching_session` (`session_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_session_payment`
--
ALTER TABLE `student_session_payment`
  ADD CONSTRAINT `student_session_payment_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `coaching_session` (`session_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_session_payment_ibfk_2` FOREIGN KEY (`stu_id`) REFERENCES `student` (`stu_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `system_admin`
--
ALTER TABLE `system_admin`
  ADD CONSTRAINT `system_admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `login_details` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  ADD CONSTRAINT `system_maintenance_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `system_admin` (`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login_details` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_branch_feedback`
--
ALTER TABLE `user_branch_feedback`
  ADD CONSTRAINT `user_branch_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_branch_feedback_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_dependent`
--
ALTER TABLE `user_dependent`
  ADD CONSTRAINT `user_dependent_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_medical_concern`
--
ALTER TABLE `user_medical_concern`
  ADD CONSTRAINT `user_medical_concern_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_request_coaching_session`
--
ALTER TABLE `user_request_coaching_session`
  ADD CONSTRAINT `user_request_coaching_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_request_coaching_session_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `coaching_session` (`session_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
