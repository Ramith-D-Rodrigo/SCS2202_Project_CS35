-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 07:07 PM
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
  `branchID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(250) NOT NULL,
  `branchEmail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `city` varchar(50) NOT NULL,
  `openingTime` time NOT NULL,
  `closingTime` time NOT NULL,
  `openingDate` date NOT NULL,
  `revenue` double DEFAULT NULL,
  `ownerID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `currManager` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `currReceptionist` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ownerRequestDate` date DEFAULT NULL,
  `requestStatus` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branchID`, `address`, `branchEmail`, `city`, `openingTime`, `closingTime`, `openingDate`, `revenue`, `ownerID`, `currManager`, `currReceptionist`, `ownerRequestDate`, `requestStatus`, `latitude`, `longitude`) VALUES
('Alaw640320e9a2e9a', 'Alawathupitiya', 'ramithrosdrigo@hotmail.com', 'Alawathupitiya', '10:00:00', '18:00:00', '2023-03-07', NULL, 'ownermn74625612', NULL, NULL, '2023-03-04', 'p', '7.110521037850345', '79.88800764083864'),
('col128423', 'Colombo Branch, Colombo', 'colombobr@sp.com', 'Colombo', '09:00:00', '20:00:00', '2022-12-07', NULL, NULL, 'managersecond1234', 'receptionisttwo123', NULL, 'a', '7.28683660', '80.243020505'),
('Kand64030c042c114', 'Kandy Branch', 'kandybr@gmail.com', 'Kandy', '08:00:00', '18:00:00', '2023-03-01', NULL, 'ownermn74625612', NULL, NULL, '2023-03-04', 'p', '7.28683660', '80.63020505'),
('kiri987521', 'Example Road, Kiribathgoda', 'kribathgodabr@sp.com', 'Kiribathgoda', '08:00:00', '19:00:00', '2022-11-26', 1050, NULL, 'managerkiri5436', 'receptionistkiri1241', NULL, 'a', '0.00000000', '0.00000000');

-- --------------------------------------------------------

--
-- Table structure for table `branch_maintenance`
--

CREATE TABLE `branch_maintenance` (
  `decision` char(1) NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requestedReceptionist` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `startingDate` date NOT NULL,
  `endingDate` date NOT NULL,
  `branchID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_photo`
--

CREATE TABLE `branch_photo` (
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `branchID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `coachID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `homeAddress` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birthday` date NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sport` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contactNum` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `registerDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`coachID`, `firstName`, `lastName`, `homeAddress`, `birthday`, `gender`, `sport`, `contactNum`, `photo`, `registerDate`) VALUES
('coach_sen63f62a9821f62', 'Seniru', 'Wijesinghe', 'Seniru Address', '2000-05-10', 'm', 'basket17212', '0774145218', '../../uploads/coach_profile_images/seniru_boss63f62a9821fb1.jpg', '2023-02-22'),
('coach_tha63cce6a49befd', 'Tharuka', 'Dileepana', 'Kirulapana', '2005-01-05', 'm', 'bad65421', '0774215874', '../../uploads/coach_profile_images/tharuka_boss63cce6a49bf51.png', '2023-01-22');

-- --------------------------------------------------------

--
-- Table structure for table `coaching_session`
--

CREATE TABLE `coaching_session` (
  `sessionID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coachMonthlyPayment` double NOT NULL,
  `timePeriod` time NOT NULL,
  `noOfStudents` int NOT NULL,
  `coachID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `courtID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `day` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `startingTime` time NOT NULL,
  `endingTime` time NOT NULL,
  `paymentAmount` double NOT NULL,
  `startDate` date DEFAULT NULL,
  `cancelDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `coaching_session`
--

INSERT INTO `coaching_session` (`sessionID`, `coachMonthlyPayment`, `timePeriod`, `noOfStudents`, `coachID`, `courtID`, `day`, `startingTime`, `endingTime`, `paymentAmount`, `startDate`, `cancelDate`) VALUES
('session1', 5000, '02:00:00', 1, 'coach_tha63cce6a49befd', 'badcourt1212', 'Wednesday', '14:00:00', '16:00:00', 2500, NULL, NULL),
('session2', 5250, '02:00:00', 0, 'coach_sen63f62a9821f62', 'baskcourt45', 'Monday', '12:00:00', '14:00:00', 1500, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coach_qualification`
--

CREATE TABLE `coach_qualification` (
  `qualification` varchar(75) NOT NULL,
  `coachID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `coach_qualification`
--

INSERT INTO `coach_qualification` (`qualification`, `coachID`) VALUES
('pro basketball', 'coach_sen63f62a9821f62');

-- --------------------------------------------------------

--
-- Table structure for table `coach_session_payment`
--

CREATE TABLE `coach_session_payment` (
  `paymentID` varchar(35) NOT NULL,
  `coachID` varchar(35) NOT NULL,
  `sessionID` varchar(35) NOT NULL,
  `paymentAmount` double NOT NULL,
  `paymentDate` date NOT NULL,
  `chargeID` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL,
  `processDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `coach_session_payment`
--
DELIMITER $$
CREATE TRIGGER `update_branch_revenue_coach_insert` AFTER INSERT ON `coach_session_payment` FOR EACH ROW BEGIN
    DECLARE currBranch VARCHAR(35) DEFAULT NULL;
    DECLARE currRevenue double;
    DECLARE paymentCourt VARCHAR(35);
    
    IF(New.status LIKE 'Processed') THEN
    	SELECT sc.courtID INTO paymentCourt FROM sports_court sc INNER JOIN coaching_session cs ON cs.courtID = sc.courtID WHERE cs.sessionID = New.sessionID;
    	SELECT b.revenue , b.branchID INTO currRevenue, currBranch FROM branch b INNER JOIN sports_court sc ON sc.branchID = b.branchID WHERE sc.courtID = paymentCourt;
        IF(currRevenue IS NULL) THEN 
    		UPDATE branch SET revenue = New.paymentAmount WHERE branchID = currBranch;
    	ELSE 
    		UPDATE branch SET revenue = currRevenue + New.paymentAmount WHERE branchID = currBranch;
		END IF;
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_branch_revenue_coach_update` AFTER UPDATE ON `coach_session_payment` FOR EACH ROW BEGIN
    DECLARE currBranch VARCHAR(35) DEFAULT NULL;
    DECLARE currRevenue double;
    DECLARE paymentCourt VARCHAR(35);
    
    IF(New.status LIKE 'Refunded') THEN
    	SELECT sc.courtID INTO paymentCourt FROM sports_court sc INNER JOIN coaching_session cs ON cs.courtID = sc.courtID WHERE cs.sessionID = New.sessionID;
    	SELECT b.revenue , b.branchID INTO currRevenue, currBranch FROM branch b INNER JOIN sports_court sc ON sc.branchID = b.branchID WHERE sc.courtID = paymentCourt;
    	UPDATE branch SET revenue = New.paymentAmount WHERE branchID = currBranch;
    	UPDATE branch SET revenue = currRevenue + New.paymentAmount WHERE branchID = currBranch;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `court_maintenance`
--

CREATE TABLE `court_maintenance` (
  `decision` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `startingDate` date NOT NULL,
  `courtID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `endingDate` date NOT NULL,
  `status` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requestedReceptionist` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `court_maintenance`
--

INSERT INTO `court_maintenance` (`decision`, `startingDate`, `courtID`, `endingDate`, `status`, `requestedReceptionist`, `message`) VALUES
('a', '2023-02-07', 'badcourt1212', '2023-02-13', 'Ongoing', 'receptionistkiri1241', 'asdasdad');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `managerID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `startingDate` date NOT NULL,
  `endingDate` date NOT NULL,
  `decision` char(1) NOT NULL,
  `discountValue` double NOT NULL,
  `branchID` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `emailAddress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userRole` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`userID`, `username`, `emailAddress`, `password`, `userRole`, `isActive`) VALUES
('admin6389f6eef2e18', 'system_admin', 'admin@gmail.com', '$2y$10$U7g4y1GDl7YJS6KXfHJq4OOBPS0YmTNsbDmEpKvD8DU.SuMo1F08a', 'admin', 1),
('ajiRod63a6f59abaaf7', 'ajith_rodrigo', 'ramithgamer@gmail.com', '$2y$10$2m/.RISis5I8qmP5IqjF2etr4gmJPJGRYws5g/FOZF5sJsauI8YzG', 'user', 1),
('ajiRod63e521915a18e', 'ajith_kumara', 'tmaskr97@gmail.com', '$2y$10$lqM0RQCJQGJ.mwQZqAtS0.YS83vDJlV1uIfQ0t3Hi6A3WWRpnLJPC', 'user', 1),
('chaJay63a1cae000958', 'charith_jay', 'charithjay@gmail.com', '$2y$10$1zOlBlNt2tgK5O227re.0O68HhCLkEjs3sDQItze.g0RIMLzr91TO', 'user', 1),
('coach_sen63f62a9821f62', 'seniru_boss', 'seniru@gmail.com', '$2y$10$9OnzUfCmxzJ3rWNDVP8SeeR.Q/88j8rEOhe.YPQIc2oM.Q3/Si/ry', 'coach', 1),
('coach_tha63cce6a49befd', 'tharuka_boss', 'tharuka@gmail.com', '$2y$10$FdqOvuJlt2ITwPYcrkR8XeTfCaWAom.tN3Yogfd63eyQH2h9QfLhi', 'coach', 1),
('darRod63acc32138634', 'darbiouz', 'ramithrodrigo1@yahoo.com', '$2y$10$B8fdOjyW/vMYt/VQ2LOg0ObCS529jI179RXKU77ZnG.e1kPuuTa/u', 'user', 1),
('dihHan6384813878b75', 'dihan_hansaja', 'dihanhansaja@gmail.com', '$2a$12$j0zGDU8fDjBsSMAaKF0Cu.GtXvacZGuuQEpmTH5TEggEMjsEon1xC', 'user', 1),
('helRod63a5b32506d98', 'hello5432', 'ramithdulsara@gmail.com', '$2y$10$FrV600iWzHbk4aZSR//tBupa7UgbxYnN9i8lB5qumoKARi71hVLta', 'user', 1),
('kamPer638656b5362c7', 'kamal_per', 'kamalperera@hotmail.com', '$2y$10$d3CoQvOnHJ4O4VkQwV96s.3LMfjG4.m1G.Kc7agF/aMQW4IsTZ0PG', 'user', 1),
('lahKum63a5b52adc2df', 'lahiru_kumara', 'lahiru_kumara@gmail.com', '$2y$10$ZGWYxwSoRD8YBOrLxth1..4pMPSlKiYhxpK1LS9AKj2OmvKP8XLFO', 'user', 1),
('lahKum63a5b560507af', 'lahiru_kumara2', 'lahiru_kumara2@gmail.com', '$2y$10$MRYyYWJ6t8R3pljzp4AiNOIKTuwQwv0n7JrbTq1qyH7KRQJCKH52a', 'user', 1),
('lahRod63a6ff48ce0c4', 'lahiru_rodrigo', 'ramithrodrigo12@hotmail.com', '$2y$10$zvLbut8kFKAHcMty0l1zV.wIRk4sf2j883o1ca2Qf285O5wsyXqXi', 'user', 1),
('managerkiri5436', 'manager_test', 'manager@kiribathgoda.com', '$2a$12$WSDZ.Td2VvI4CxwDHuFCUOZucTdUwG0dkdsXGvI7v2AuOf1rNHCUK', 'manager', 1),
('managersecond1234', 'manager_test2', 'managersecond@gmail.com', '$2a$12$2JO5RyV0bbGQjJn3UEc2seM4EWzQyF5gP9KfYmboH.1ZsXamyVpEe', 'manager', 1),
('nihWij638657d83c715', 'nihal_wij', 'nihal_wije@gmail.com', '$2y$10$dWp4y/hWGGWNICJzgTdM.e0EBAZcd7qUZEOJAQrEQ43ptT3kVcPfK', 'user', 1),
('ownermn74625612', 'sportude_owner', 'owner@gmail.com', '$2a$12$SZojPsXrTIFuqKS9HBMmDO4RytRbnYvSIOeifZEqZaeCg9AsbB51q', 'owner', 1),
('ramRod63816dc9007b4', 'ramith_rodrigo', 'ramithrodrigo@hotmail.com', '$2y$10$Eqr0.DoRjgxqGq2pAZSwK.Xl1jThxRLKRXQU6QM3qNXh693P6mx7O', 'user', 1),
('receptionistkiri1241', 'recep_test', 'receptionist@kiribathgoda.com', '$2a$12$PFT9firhsYibGVVtHel8Me/hGaVe9gflyxRmY6DyrlQUERJorny02', 'receptionist', 1),
('receptionisttwo123', 'recep_test2', 'receptionisttwo@gmail.com', '$2a$12$LkkvBKEkL707dptt.X8hSuwoOaOaXG9iwrxa33s5zGofANtLgaxyG', 'receptionist', 1),
('samKum63e523eab8d76', 'saman_kumara', 'ramithrodrigo@yahoo.com', '$2y$10$W4dPOdlzRwS/iMbjEEZMkefsIoaN3SH3IEJV.W753LoKdSvx0mrBW', 'user', 1),
('thaSam639a02d983325', 'tharindu_sam', 'tharindusampath@gmail.com', '$2y$10$YD3/hAsrqWALpLp2W/aof.gpJetwFNPMwTZyAQmNy57IpiQeOx6tK', 'user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `managerID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`managerID`) VALUES
('managerkiri5436'),
('managersecond1234');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notificationID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subject` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `lifetime` time DEFAULT NULL,
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `ownerID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contacNum` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`ownerID`, `contacNum`, `firstName`, `lastName`) VALUES
('ownermn74625612', '0767567823', 'Walter', 'White');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist`
--

CREATE TABLE `receptionist` (
  `receptionistID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `receptionist`
--

INSERT INTO `receptionist` (`receptionistID`) VALUES
('receptionistkiri1241'),
('receptionisttwo123');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservationID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `startingTime` time NOT NULL,
  `endingTime` time NOT NULL,
  `noOfPeople` int NOT NULL,
  `paymentAmount` double NOT NULL,
  `sportCourt` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `formalManagerID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `onsiteReceptionistID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `reservedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `chargeID` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservationID`, `date`, `startingTime`, `endingTime`, `noOfPeople`, `paymentAmount`, `sportCourt`, `status`, `userID`, `formalManagerID`, `onsiteReceptionistID`, `reservedDate`, `chargeID`) VALUES
('Res-aji63e522aa1d0ab', '2023-02-15', '14:00:00', '16:00:00', 2, 1000, 'basket345', 'Pending', 'ajiRod63e521915a18e', NULL, NULL, '2023-02-09 16:43:22', ''),
('Res-aji63e522cb0e31c', '2023-02-12', '12:00:00', '14:00:00', 2, 1000, 'basket345', 'Pending', 'ajiRod63e521915a18e', NULL, NULL, '2023-02-09 16:43:55', ''),
('Res-dar63acd29160719', '2023-01-06', '09:00:00', '10:00:00', 2, 350, 'badcourt1212', 'Checked In', 'darRod63acc32138634', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-dar63acecea83066', '2023-01-04', '14:00:00', '16:00:00', 2, 700, 'badcourt1212', 'Pending', 'darRod63acc32138634', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-dar63aced00c15a1', '2023-01-04', '10:00:00', '12:00:00', 4, 700, 'badcourt1212', 'Pending', 'darRod63acc32138634', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-dar63aced265efb1', '2023-01-03', '11:00:00', '17:00:00', 5, 2100, 'badcourt1212', 'Pending', 'darRod63acc32138634', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-dar63aced788977f', '2023-01-08', '12:00:00', '14:00:00', 2, 700, 'badcourt1213', 'Pending', 'darRod63acc32138634', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-dih639431189c53b', '2022-12-24', '12:00:00', '15:00:00', 2, 1050, 'badcourt1213', 'Pending', 'dihHan6384813878b75', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram6381ff1962f37', '2022-12-03', '09:00:00', '12:00:00', 4, 1050, 'badcourt1213', 'Checked In feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram6389552c34f9a', '2022-12-17', '09:00:00', '12:00:00', 3, 1050, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram638955f9d5247', '2022-12-17', '16:00:00', '18:00:00', 3, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram6389622caecf9', '2022-12-14', '17:00:00', '18:30:00', 1, 525, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram6392242acaf4e', '2022-12-17', '15:30:00', '16:30:00', 2, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram639303f19962e', '2022-12-17', '13:00:00', '15:00:00', 2, 700, 'badcourt1212', 'Checked In feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63930648c43c3', '2022-12-22', '09:30:00', '11:00:00', 2, 525, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram639308b17770b', '2022-12-21', '12:00:00', '14:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63930a5c45935', '2022-12-22', '16:00:00', '17:00:00', 4, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63987a48694d7', '2023-01-05', '09:00:00', '10:30:00', 4, 525, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b29a9f5a6b2', '2023-01-14', '10:00:00', '11:00:00', 2, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b29acad030d', '2023-01-13', '10:00:00', '11:00:00', 2, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b2a388476c3', '2023-01-08', '16:00:00', '17:00:00', 2, 350, 'badcourt1213', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b2a9ca1c21c', '2023-01-06', '14:00:00', '16:00:00', 2, 700, 'badcourt1213', 'Checked In feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b2d951c5af2', '2023-01-06', '12:00:00', '16:00:00', 4, 2000, 'basket345', 'Checked In feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b2d964ae7ef', '2023-01-06', '10:00:00', '12:00:00', 4, 1000, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63b2da914e447', '2023-01-05', '13:00:00', '16:00:00', 2, 1500, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63ccf24183dbb', '2023-01-25', '15:00:00', '17:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63ccf2539478d', '2023-01-25', '15:00:00', '17:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63ccf3134ba7a', '2023-01-25', '17:00:00', '18:00:00', 1, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:08:36', ''),
('Res-ram63ccf328cfc1f', '2023-02-20', '17:00:00', '18:00:00', 1, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-16 16:08:36', ''),
('Res-ram63d154888731f', '2023-01-29', '15:00:00', '16:00:00', 3, 500, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:10:48', ''),
('Res-ram63d154f293174', '2023-01-29', '17:00:00', '18:00:00', 3, 500, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-25 16:12:34', ''),
('Res-ram63d24a4aa1d15', '2023-01-29', '18:00:00', '19:00:00', 2, 500, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-26 09:39:22', ''),
('Res-ram63d39875e2543', '2023-02-02', '10:00:00', '12:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-01-27 09:25:09', ''),
('Res-ram63dd1aaf4855a', '2023-02-08', '16:00:00', '19:00:00', 2, 1050, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-03 14:31:11', ''),
('Res-ram63dde21a1711a', '2023-02-10', '13:00:00', '15:00:00', 2, 700, 'badcourt1213', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-04 04:42:02', ''),
('Res-ram63de9a0773419', '2023-02-14', '09:00:00', '11:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-04 17:46:47', ''),
('Res-ram63e3ca3a8032b', '2023-02-14', '12:00:00', '14:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-08 16:13:46', ''),
('Res-ram63e3ca69c1754', '2023-02-14', '11:00:00', '12:00:00', 2, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-08 16:14:33', ''),
('Res-ram63e3ca8259b40', '2023-02-22', '11:00:00', '12:00:00', 2, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-08 16:14:58', ''),
('Res-ram63e3cad9a9f20', '2023-02-22', '13:00:00', '14:00:00', 2, 350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-08 16:16:25', ''),
('Res-ram63ee5468dd221', '2023-02-23', '10:00:00', '12:00:00', 2, 1000, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-16 16:06:00', ''),
('Res-ram63ee56b99b8cf', '2023-02-25', '13:00:00', '16:00:00', 2, 1050, 'badcourt1213', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-16 16:15:53', ''),
('Res-ram63ee57da3e981', '2023-02-20', '10:00:00', '14:00:00', 2, 2000, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-16 16:20:42', ''),
('Res-ram63f48625b04c0', '2023-02-25', '10:00:00', '12:00:00', 2, 700, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-21 08:51:49', ''),
('Res-ram63f8dc83d1add', '2023-03-02', '11:00:00', '12:00:00', 2, 350, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-02-24 15:49:23', 'ch_3Mf3WkKUOfa0wCPZ10vmygDn'),
('Res-ram63ff5779743f6', '2023-03-16', '10:00:00', '12:00:00', 2, 700, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-01 13:47:37', 'ch_3Mgq0eKUOfa0wCPZ1itZhsUD'),
('Res-ram63ff57af98ddf', '2023-03-16', '12:00:00', '14:00:00', 2, 700, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-01 13:48:31', 'ch_3Mgq1XKUOfa0wCPZ1ic7SswC'),
('Res-ram63ff599745df5', '2023-03-17', '12:00:00', '14:00:00', 2, 700, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-01 13:56:39', 'ch_3Mgq9OKUOfa0wCPZ0ropNH5h'),
('Res-ram63ff5e9117ab5', '2023-03-06', '12:00:00', '15:00:00', 2, 1050, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-01 14:17:53', 'ch_3MgqTwKUOfa0wCPZ03sgHEjx'),
('Res-ram63ff607f02abf', '2023-03-09', '10:00:00', '13:00:00', 2, 1500, 'basket345', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-01 14:26:07', 'ch_3MgqbuKUOfa0wCPZ1lLk9EJN'),
('Res-ram63ff61aabfe0e', '2023-03-07', '10:00:00', '12:00:00', 2, 700, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-01 14:31:06', 'ch_3MgqgkKUOfa0wCPZ1zaWVmGS'),
('Res-ram640168561938e', '2023-03-10', '10:00:00', '12:00:00', 2, 700, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-03 03:24:06', 'ch_3MhPEMKUOfa0wCPZ0Hbe6GTx'),
('Res-ram64019a45bcf40', '2023-03-11', '16:00:00', '19:00:00', 2, 1050, 'badcourt1212', 'Pending', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-03 06:57:09', 'ch_3MhSYYKUOfa0wCPZ1g7IrPbK');

--
-- Triggers `reservation`
--
DELIMITER $$
CREATE TRIGGER `update_branch_revenue_insert` AFTER INSERT ON `reservation` FOR EACH ROW BEGIN
    DECLARE currBranch VARCHAR(35) DEFAULT NULL;
    DECLARE amount double;
    DECLARE currRevenue double;
    
    SELECT b.revenue , b.branchID INTO currRevenue, currBranch FROM branch b INNER JOIN sports_court sc ON sc.branchID = b.branchID WHERE sc.courtID = New.sportCourt;
    IF(currRevenue IS NULL) THEN 
    	UPDATE branch SET revenue = New.paymentAmount WHERE branchID = currBranch;
    ELSE 
    	UPDATE branch SET revenue = currRevenue + New.paymentAmount WHERE branchID = currBranch;
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_branch_revenue_update` AFTER UPDATE ON `reservation` FOR EACH ROW BEGIN
    DECLARE currBranch VARCHAR(35) DEFAULT NULL;
    DECLARE currRevenue double;
    
    IF(Old.status LIKE 'Cancelled' AND New.status LIKE 'Refunded') THEN
    	SELECT b.revenue , b.branchID INTO currRevenue, currBranch FROM branch b INNER JOIN sports_court sc ON sc.branchID = b.branchID WHERE sc.courtID = New.sportCourt;
    	UPDATE branch SET revenue = currRevenue - New.paymentAmount WHERE branchID = currBranch;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE `sport` (
  `sportID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sportName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(100) NOT NULL,
  `reservationPrice` double NOT NULL,
  `minCoachingSessionPrice` double NOT NULL,
  `maxNoOfStudents` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`sportID`, `sportName`, `description`, `reservationPrice`, `minCoachingSessionPrice`, `maxNoOfStudents`) VALUES
('bad65421', 'Badminton', 'Fun game to play with friends', 350, 420, 10),
('basket17212', 'Basketball', 'A sport that requires speed', 550, 660, 25),
('cricket23871', 'Cricket', 'wanna play 11 vs 11?', 800, 5000, 20),
('Tabl64038296afcad', 'Table Tennis', 'highly competitive and engaging for a 2v2 sport', 200, 240, NULL),
('Voll64037fe13cf3a', 'Volleyball', 'Another fun game', 800, 960, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sports_court`
--

CREATE TABLE `sports_court` (
  `courtID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sportID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `courtName` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `branchID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requestStatus` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `addedManager` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sports_court`
--

INSERT INTO `sports_court` (`courtID`, `sportID`, `courtName`, `branchID`, `requestStatus`, `addedManager`) VALUES
('AlaBas640320e9a4563', 'basket17212', 'A', 'Alaw640320e9a2e9a', 'p', NULL),
('badcourt1212', 'bad65421', 'A', 'kiri987521', 'a', NULL),
('badcourt1213', 'bad65421', 'B', 'kiri987521', 'a', NULL),
('baskcourt45', 'basket17212', 'A', 'kiri987521', 'a', NULL),
('basket345', 'basket17212', 'A', 'col128423', 'a', NULL),
('KanBas64030c042d150', 'basket17212', 'A', 'Kand64030c042c114', 'p', NULL),
('KanBas64030c042e430', 'basket17212', 'B', 'Kand64030c042c114', 'p', NULL),
('KanCri64030c042fa53', 'cricket23871', 'A', 'Kand64030c042c114', 'p', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sports_court_photo`
--

CREATE TABLE `sports_court_photo` (
  `courtPhoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `courtID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contactNum` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateOfBirth` date NOT NULL,
  `firstName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `joinDate` date NOT NULL,
  `leaveDate` date DEFAULT NULL,
  `staffRole` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `branchID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `contactNum`, `gender`, `dateOfBirth`, `firstName`, `lastName`, `joinDate`, `leaveDate`, `staffRole`, `branchID`) VALUES
('managerkiri5436', '0785412368', 'm', '1975-10-11', 'Namal', 'Rajapaksa', '2022-10-11', NULL, 'manager', 'kiri987521'),
('managersecond1234', '0745213698', 'm', '1994-09-09', 'Kasun', 'Perera', '2022-12-01', NULL, 'manager', 'col128423'),
('receptionistkiri1241', '0741236585', 'f', '1994-12-09', 'Amali', 'Kulasinghe', '2022-12-01', NULL, 'receptionist', 'kiri987521'),
('receptionisttwo123', '0774114523', 'm', '1992-12-04', 'Imesh', 'Viduranga', '2022-12-01', NULL, 'receptionist', 'col128423');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stuID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stuID`) VALUES
('ramRod63816dc9007b4');

-- --------------------------------------------------------

--
-- Table structure for table `student_coach_feedback`
--

CREATE TABLE `student_coach_feedback` (
  `feedbackID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rating` int NOT NULL,
  `coachID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stuID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `feedbackDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_coach_feedback`
--

INSERT INTO `student_coach_feedback` (`feedbackID`, `description`, `rating`, `coachID`, `stuID`, `feedbackDate`) VALUES
('coachFB63fb6d8cde7ca', 'waeasd', 4, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-02-26'),
('feedback1', 'Amazing', 4, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2022-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `student_registered_session`
--

CREATE TABLE `student_registered_session` (
  `stuID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sessionID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `joinDate` date NOT NULL,
  `leaveDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_registered_session`
--

INSERT INTO `student_registered_session` (`stuID`, `sessionID`, `joinDate`, `leaveDate`) VALUES
('ramRod63816dc9007b4', 'session1', '2023-02-01', '2023-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `student_session_payment`
--

CREATE TABLE `student_session_payment` (
  `paymentID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `stuID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sessionID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `paymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_admin`
--

CREATE TABLE `system_admin` (
  `adminID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `system_admin`
--

INSERT INTO `system_admin` (`adminID`) VALUES
('admin6389f6eef2e18');

-- --------------------------------------------------------

--
-- Table structure for table `system_maintenance`
--

CREATE TABLE `system_maintenance` (
  `expectedDowntime` time NOT NULL,
  `adminID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `startingDate` date NOT NULL,
  `startingTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `firstName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `lastName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gender` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profilePhoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `homeAddress` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contactNum` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birthday` date NOT NULL,
  `registerDate` date NOT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `firstName`, `lastName`, `gender`, `profilePhoto`, `homeAddress`, `contactNum`, `birthday`, `registerDate`, `height`, `weight`) VALUES
('ajiRod63a6f59abaaf7', 'AJith', 'Rodrigo', 'm', '../../uploads/user_profile_images/ajith_rodrigo63a6f59abab54.png', 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0714831744', '1957-11-14', '2022-12-24', 174, 50),
('ajiRod63e521915a18e', 'Ajith', 'Rodrigo', 'm', NULL, 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0714831744', '1957-12-11', '2023-02-09', NULL, 62),
('chaJay63a1cae000958', 'Charith', 'Jayaranga', 'm', '../../uploads/user_profile_images/charith_jay63a1cae0009db.png', 'Charith&amp;#039;s Address', '0779685314', '2000-06-08', '2022-12-20', 176, 60),
('darRod63acc32138634', 'Ramith', 'Rodrigo', 'm', NULL, 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0767275867', '2008-12-17', '2022-12-28', NULL, NULL),
('dihHan6384813878b75', 'Dihan', 'Hansaja', 'm', '../../uploads/user_profile_images/dihan_hansaja6384813878ccc.jpg', 'Dihan&amp;#039;s Address, Ambalangoda', '0786541239', '2000-07-04', '2022-11-28', 170, 55),
('helRod63a5b32506d98', 'Ramith', 'Rodrigo', 'm', '../../uploads/user_profile_images/hello543263a5b32506def.png', 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0767275867', '2008-12-05', '2022-12-23', NULL, NULL),
('kamPer638656b5362c7', 'Kamal', 'Perera', 'm', NULL, 'Madamulana, Sri Lanka', '0715423658', '2003-05-09', '2022-11-29', 166, 66),
('lahKum63a5b52adc2df', 'Lahiru', 'Kumara', 'm', '../../uploads/user_profile_images/lahiru_kumara63a5b52adc335.jpg', 'Lahiru&amp;#039;s Address', '0774145632', '2002-02-06', '2022-12-23', 175, 66),
('lahKum63a5b560507af', 'Lahiru', 'Kumara', 'm', '../../uploads/user_profile_images/lahiru_kumara263a5b56050808.jpg', 'Lahiru&amp;#039;s Address', '0774145632', '2002-02-06', '2022-12-23', 175, 66),
('lahRod63a6ff48ce0c4', 'Lahiru', 'Rodrigo', 'm', NULL, 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0767275867', '2008-12-02', '2022-12-24', NULL, NULL),
('nihWij638657d83c715', 'Nihal', 'Wijesinghe', 'm', NULL, 'Some road, Galle', '0789654125', '1996-07-26', '2022-11-29', 177, 69),
('ramRod63816dc9007b4', 'Ramith', 'Rodrigo', 'm', '../../uploads/user_profile_images/ramith_rodrigo63f8d69aa0fc9.jpg', 'No.301/5 Mihindu Mawatha, Makola North, Makola', '0767275867', '2000-09-01', '2022-11-26', 180, 58),
('samKum63e523eab8d76', 'Saman', 'Kumara', 'm', '../../uploads/user_profile_images/saman_kumara63e52426da49d.jpg', 'Saman address', '0774587452', '2009-02-04', '2023-02-09', NULL, NULL),
('thaSam639a02d983325', 'Tharindu', 'Sampath', 'm', NULL, 'Some road, Kaluthara', '0774125478', '1999-06-25', '2022-12-14', 170, 70);

-- --------------------------------------------------------

--
-- Table structure for table `user_branch_feedback`
--

CREATE TABLE `user_branch_feedback` (
  `userFeedbackID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `rating` int NOT NULL,
  `description` varchar(500) NOT NULL,
  `branchID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_branch_feedback`
--

INSERT INTO `user_branch_feedback` (`userFeedbackID`, `userID`, `date`, `rating`, `description`, `branchID`) VALUES
('FB63d246278a096', 'ramRod63816dc9007b4', '2023-01-26', 5, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu', 'kiri987521'),
('FB63d246eaca834', 'ramRod63816dc9007b4', '2023-01-26', 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu', 'col128423'),
('FB63d398eec2e7f', 'ramRod63816dc9007b4', '2023-01-27', 4, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu', 'kiri987521'),
('FB63e52d728cf07', 'ramRod63816dc9007b4', '2023-02-09', 3, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu', 'kiri987521'),
('feedback1', 'ramRod63816dc9007b4', '2022-12-29', 4, 'Amazing Experience!', 'kiri987521'),
('feedback2', 'dihHan6384813878b75', '2022-12-27', 1, 'Worst Experience Ever!', 'kiri987521'),
('feedbackwolololo', 'kamPer638656b5362c7', '2023-03-15', 5, 'Had alot of fun', 'kiri987521');

-- --------------------------------------------------------

--
-- Table structure for table `user_dependent`
--

CREATE TABLE `user_dependent` (
  `ownerID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `relationship` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contactNum` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_dependent`
--

INSERT INTO `user_dependent` (`ownerID`, `name`, `relationship`, `contactNum`) VALUES
('ajiRod63a6f59abaaf7', 'Champa', 'Partner', '0774521585'),
('ajiRod63a6f59abaaf7', 'Hema', 'Mother', '0778541236'),
('ajiRod63a6f59abaaf7', 'Vajira', 'Sibling 1', '0714863258'),
('ajiRod63e521915a18e', 'Champa', 'Partner', '0741254856'),
('ajiRod63e521915a18e', 'Ramith', 'Other', '0767275867'),
('chaJay63a1cae000958', 'Daham', 'Sibling 1', '0774125635'),
('darRod63acc32138634', 'Ajith Rodrigo', 'Father', '0714831744'),
('dihHan6384813878b75', 'Kamal', 'Sibling 1', '0774532158'),
('dihHan6384813878b75', 'Ramith', 'Friend 1', '0767275867'),
('helRod63a5b32506d98', 'Rodrigo', 'Friend 1', '0774152145'),
('kamPer638656b5362c7', 'Sunil', 'Father', '0716525854'),
('lahKum63a5b52adc2df', 'Ramith Rodrigo', 'Sibling 1', '0774589963'),
('lahKum63a5b560507af', 'Ramith Rodrigo', 'Sibling 1', '0774589963'),
('lahRod63a6ff48ce0c4', 'Ramith', 'Sibling 2', '0777854521'),
('nihWij638657d83c715', 'Amitha', 'Partner', '0774532174'),
('ramRod63816dc9007b4', 'Ajith', 'Father', '0714831744'),
('samKum63e523eab8d76', 'Lahiru', 'Sibling 2', '0774151234'),
('samKum63e523eab8d76', 'Ramith', 'Sibling 1', '0774151236'),
('thaSam639a02d983325', 'Sarindu', 'Sibling 1', '0774125963');

-- --------------------------------------------------------

--
-- Table structure for table `user_medical_concern`
--

CREATE TABLE `user_medical_concern` (
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `medicalConcern` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_medical_concern`
--

INSERT INTO `user_medical_concern` (`userID`, `medicalConcern`) VALUES
('ajiRod63a6f59abaaf7', 'pain a'),
('ajiRod63a6f59abaaf7', 'pain b'),
('ajiRod63a6f59abaaf7', 'pain c'),
('ajiRod63a6f59abaaf7', 'pain d'),
('ajiRod63a6f59abaaf7', 'pain e'),
('chaJay63a1cae000958', 'headache'),
('chaJay63a1cae000958', 'short sighted'),
('dihHan6384813878b75', 'back pain'),
('dihHan6384813878b75', 'headache'),
('dihHan6384813878b75', 'my concern'),
('kamPer638656b5362c7', 'broken and fixed leg'),
('lahKum63a5b52adc2df', 'eye'),
('lahKum63a5b52adc2df', 'helo pain'),
('lahKum63a5b52adc2df', 'nice'),
('lahKum63a5b560507af', 'eye'),
('lahKum63a5b560507af', 'helo pain'),
('lahKum63a5b560507af', 'nice'),
('ramRod63816dc9007b4', 'new concern'),
('samKum63e523eab8d76', 'arm pains'),
('samKum63e523eab8d76', 'leg cramps'),
('thaSam639a02d983325', 'chest pain');

-- --------------------------------------------------------

--
-- Table structure for table `user_request_coaching_session`
--

CREATE TABLE `user_request_coaching_session` (
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sessionID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requestDate` date NOT NULL,
  `message` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branchID`),
  ADD UNIQUE KEY `branch_email` (`branchEmail`),
  ADD UNIQUE KEY `latitude` (`latitude`,`longitude`),
  ADD UNIQUE KEY `curr_manager` (`currManager`),
  ADD UNIQUE KEY `curr_receptionist` (`currReceptionist`),
  ADD KEY `owner_id` (`ownerID`);

--
-- Indexes for table `branch_maintenance`
--
ALTER TABLE `branch_maintenance`
  ADD PRIMARY KEY (`branchID`,`startingDate`),
  ADD KEY `requested_receptionist` (`requestedReceptionist`);

--
-- Indexes for table `branch_photo`
--
ALTER TABLE `branch_photo`
  ADD PRIMARY KEY (`photo`,`branchID`),
  ADD KEY `branch_id` (`branchID`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`coachID`),
  ADD KEY `sport` (`sport`);

--
-- Indexes for table `coaching_session`
--
ALTER TABLE `coaching_session`
  ADD PRIMARY KEY (`sessionID`),
  ADD KEY `coach_id` (`coachID`),
  ADD KEY `court_id` (`courtID`);

--
-- Indexes for table `coach_qualification`
--
ALTER TABLE `coach_qualification`
  ADD PRIMARY KEY (`qualification`,`coachID`),
  ADD KEY `coach_id` (`coachID`);

--
-- Indexes for table `coach_session_payment`
--
ALTER TABLE `coach_session_payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `coachID` (`coachID`),
  ADD KEY `sessionID` (`sessionID`);

--
-- Indexes for table `court_maintenance`
--
ALTER TABLE `court_maintenance`
  ADD PRIMARY KEY (`courtID`,`startingDate`),
  ADD KEY `requested_receptionist` (`requestedReceptionist`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`managerID`,`startingDate`),
  ADD KEY `branchID` (`branchID`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email_address` (`emailAddress`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`managerID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `user_id` (`userID`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`ownerID`);

--
-- Indexes for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD PRIMARY KEY (`receptionistID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `sport_court` (`sportCourt`),
  ADD KEY `user_id` (`userID`),
  ADD KEY `formal_manager_id` (`formalManagerID`),
  ADD KEY `onsite_receptionist_id` (`onsiteReceptionistID`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`sportID`);

--
-- Indexes for table `sports_court`
--
ALTER TABLE `sports_court`
  ADD PRIMARY KEY (`courtID`),
  ADD KEY `sport_id` (`sportID`),
  ADD KEY `branch_id` (`branchID`),
  ADD KEY `added_manager` (`addedManager`);

--
-- Indexes for table `sports_court_photo`
--
ALTER TABLE `sports_court_photo`
  ADD PRIMARY KEY (`courtPhoto`,`courtID`),
  ADD KEY `court_id` (`courtID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `contact_number` (`contactNum`),
  ADD KEY `branch_id` (`branchID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stuID`);

--
-- Indexes for table `student_coach_feedback`
--
ALTER TABLE `student_coach_feedback`
  ADD PRIMARY KEY (`feedbackID`),
  ADD KEY `coach_id` (`coachID`),
  ADD KEY `stu_id` (`stuID`);

--
-- Indexes for table `student_registered_session`
--
ALTER TABLE `student_registered_session`
  ADD PRIMARY KEY (`stuID`,`sessionID`,`joinDate`) USING BTREE,
  ADD KEY `session_id` (`sessionID`);

--
-- Indexes for table `student_session_payment`
--
ALTER TABLE `student_session_payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `session_id` (`sessionID`),
  ADD KEY `stu_id` (`stuID`);

--
-- Indexes for table `system_admin`
--
ALTER TABLE `system_admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  ADD PRIMARY KEY (`adminID`,`startingDate`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_branch_feedback`
--
ALTER TABLE `user_branch_feedback`
  ADD PRIMARY KEY (`userFeedbackID`),
  ADD KEY `user_id` (`userID`),
  ADD KEY `branch_id` (`branchID`);

--
-- Indexes for table `user_dependent`
--
ALTER TABLE `user_dependent`
  ADD PRIMARY KEY (`ownerID`,`name`);

--
-- Indexes for table `user_medical_concern`
--
ALTER TABLE `user_medical_concern`
  ADD PRIMARY KEY (`userID`,`medicalConcern`);

--
-- Indexes for table `user_request_coaching_session`
--
ALTER TABLE `user_request_coaching_session`
  ADD PRIMARY KEY (`userID`,`sessionID`) USING BTREE,
  ADD KEY `session_id` (`sessionID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`ownerID`) REFERENCES `owner` (`ownerID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `branch_ibfk_2` FOREIGN KEY (`currManager`) REFERENCES `manager` (`managerID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `branch_ibfk_3` FOREIGN KEY (`currReceptionist`) REFERENCES `receptionist` (`receptionistID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `branch_maintenance`
--
ALTER TABLE `branch_maintenance`
  ADD CONSTRAINT `branch_maintenance_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `branch_maintenance_ibfk_2` FOREIGN KEY (`requestedReceptionist`) REFERENCES `receptionist` (`receptionistID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `branch_photo`
--
ALTER TABLE `branch_photo`
  ADD CONSTRAINT `branch_photo_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`coachID`) REFERENCES `login_details` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coach_ibfk_2` FOREIGN KEY (`sport`) REFERENCES `sport` (`sportID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coaching_session`
--
ALTER TABLE `coaching_session`
  ADD CONSTRAINT `coaching_session_ibfk_1` FOREIGN KEY (`coachID`) REFERENCES `coach` (`coachID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coaching_session_ibfk_2` FOREIGN KEY (`courtID`) REFERENCES `sports_court` (`courtID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coach_qualification`
--
ALTER TABLE `coach_qualification`
  ADD CONSTRAINT `coach_qualification_ibfk_1` FOREIGN KEY (`coachID`) REFERENCES `coach` (`coachID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `coach_session_payment`
--
ALTER TABLE `coach_session_payment`
  ADD CONSTRAINT `coach_session_payment_ibfk_1` FOREIGN KEY (`coachID`) REFERENCES `coach` (`coachID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `coach_session_payment_ibfk_2` FOREIGN KEY (`sessionID`) REFERENCES `coaching_session` (`sessionID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `court_maintenance`
--
ALTER TABLE `court_maintenance`
  ADD CONSTRAINT `court_maintenance_ibfk_1` FOREIGN KEY (`courtID`) REFERENCES `sports_court` (`courtID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `court_maintenance_ibfk_2` FOREIGN KEY (`requestedReceptionist`) REFERENCES `receptionist` (`receptionistID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `discount`
--
ALTER TABLE `discount`
  ADD CONSTRAINT `discount_ibfk_1` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `discount_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`managerID`) REFERENCES `staff` (`staffID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `login_details` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`ownerID`) REFERENCES `login_details` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `receptionist`
--
ALTER TABLE `receptionist`
  ADD CONSTRAINT `receptionist_ibfk_1` FOREIGN KEY (`receptionistID`) REFERENCES `staff` (`staffID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`sportCourt`) REFERENCES `sports_court` (`courtID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`formalManagerID`) REFERENCES `manager` (`managerID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`onsiteReceptionistID`) REFERENCES `receptionist` (`receptionistID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sports_court`
--
ALTER TABLE `sports_court`
  ADD CONSTRAINT `sports_court_ibfk_1` FOREIGN KEY (`sportID`) REFERENCES `sport` (`sportID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sports_court_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sports_court_ibfk_3` FOREIGN KEY (`addedManager`) REFERENCES `manager` (`managerID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sports_court_photo`
--
ALTER TABLE `sports_court_photo`
  ADD CONSTRAINT `sports_court_photo_ibfk_1` FOREIGN KEY (`courtID`) REFERENCES `sports_court` (`courtID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`staffID`) REFERENCES `login_details` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`stuID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_coach_feedback`
--
ALTER TABLE `student_coach_feedback`
  ADD CONSTRAINT `student_coach_feedback_ibfk_1` FOREIGN KEY (`coachID`) REFERENCES `coach` (`coachID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_coach_feedback_ibfk_2` FOREIGN KEY (`stuID`) REFERENCES `student` (`stuID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_registered_session`
--
ALTER TABLE `student_registered_session`
  ADD CONSTRAINT `student_registered_session_ibfk_1` FOREIGN KEY (`stuID`) REFERENCES `student` (`stuID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_registered_session_ibfk_2` FOREIGN KEY (`sessionID`) REFERENCES `coaching_session` (`sessionID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_session_payment`
--
ALTER TABLE `student_session_payment`
  ADD CONSTRAINT `student_session_payment_ibfk_1` FOREIGN KEY (`sessionID`) REFERENCES `coaching_session` (`sessionID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_session_payment_ibfk_2` FOREIGN KEY (`stuID`) REFERENCES `student` (`stuID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `system_admin`
--
ALTER TABLE `system_admin`
  ADD CONSTRAINT `system_admin_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `login_details` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  ADD CONSTRAINT `system_maintenance_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `system_admin` (`adminID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `login_details` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_branch_feedback`
--
ALTER TABLE `user_branch_feedback`
  ADD CONSTRAINT `user_branch_feedback_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_branch_feedback_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_dependent`
--
ALTER TABLE `user_dependent`
  ADD CONSTRAINT `user_dependent_ibfk_1` FOREIGN KEY (`ownerID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_medical_concern`
--
ALTER TABLE `user_medical_concern`
  ADD CONSTRAINT `user_medical_concern_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_request_coaching_session`
--
ALTER TABLE `user_request_coaching_session`
  ADD CONSTRAINT `user_request_coaching_session_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_request_coaching_session_ibfk_2` FOREIGN KEY (`sessionID`) REFERENCES `coaching_session` (`sessionID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
