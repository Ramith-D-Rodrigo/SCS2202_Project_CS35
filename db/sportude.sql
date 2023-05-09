-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2023 at 04:58 PM
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
('Anur64560bae11051', 'Test Address', 'anuaddress@gmail.com', 'Anuradhapura', '08:00:00', '17:00:00', '2023-05-12', NULL, 'ownermn74625612', NULL, NULL, '2023-05-06', 'p', '6.9173248', '79.8588928'),
('col128423', 'Colombo Branch, Colombo', 'colombobr@sp.com', 'Colombo', '09:00:00', '20:00:00', '2022-12-07', 9150, NULL, 'managersecond1234', 'receptionisttwo123', NULL, 'a', '7.28683660', '80.243020505'),
('Kada6412745c32a13', 'kadawatha branch address', 'asdasdasda@sdnmfsnd.vom', 'Kadawatha', '07:00:00', '15:00:00', '2023-03-17', 500, 'ownermn74625612', 'mngr64589f895170c', 'rcptnst644f4f1f49c7b', '2023-03-16', 'a', '6.9992448', '79.9506432'),
('Kand64030c042c114', 'Kandy Branch', 'kandybr@gmail.com', 'Kandy', '08:00:00', '18:00:00', '2023-03-01', 5800, 'ownermn74625612', 'mngr6458a04a2aa58', 'rcptnst6458a12f43d74', '2023-03-04', 'a', '7.28683660', '80.63020505'),
('kiri987521', 'Example Road, Kiribathgoda', 'kribathgodabr@sp.com', 'Kiribathgoda', '08:00:00', '19:00:00', '2022-11-26', 20090, NULL, 'managerkiri5436', 'receptionistkiri1241', NULL, 'a', '6.977590', '79.926753'),
('test64057012608ab', 'test address', 'testbranch@br.com', 'test', '08:00:00', '16:00:00', '2023-03-09', NULL, 'ownermn74625612', NULL, NULL, '2023-03-06', 'd', '6.926721400829939', '79.86620664596559');

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

--
-- Dumping data for table `branch_photo`
--

INSERT INTO `branch_photo` (`photo`, `branchID`) VALUES
('/uploads/branch_images/col_branch.png', 'col128423'),
('/uploads/branch_images/kadawath_branch.jpg', 'Kada6412745c32a13'),
('/uploads/branch_images/kiribathgoda_branch.jpg', 'kiri987521');

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
('coach_bha645a07beaa777', 'Bhathiya', 'VanDeBona', 'Panadura Address', '1997-03-08', 'm', 'basket17212', '07785412563', '../../uploads/coach_profile_images/bhathiya_bona645a07beaa788.jpg', '2023-05-09'),
('coach_cha645a056edb3a8', 'Charith', 'Jayaranga', 'Panadura address', '1999-08-18', 'm', 'bad65421', '07711458562', '../../uploads/coach_profile_images/charith_jay645a056edb3ba.jpg', '2023-05-09'),
('coach_pub645a052680750', 'Pubudu', 'Anuradha', 'Puththalam address', '2000-01-10', 'm', 'Swim6405710541644', '0774568541', '../../uploads/coach_profile_images/pubudu_coach645a0526809b2.png', '2023-05-09'),
('coach_sen63f62a9821f62', 'Seniru', 'Wijesinghe', 'Seniru Address', '2000-05-10', 'm', 'basket17212', '0774145218', '../../uploads/coach_profile_images/basketball_coach.webp', '2023-02-22'),
('coach_tha63cce6a49befd', 'Tharuka', 'Dileepana', 'Kirulapana', '2005-01-05', 'm', 'bad65421', '0774215874', '../../uploads/coach_profile_images/badminton_coach.png', '2023-01-22'),
('coach_tha645a05cd7f35f', 'Tharindu', 'Sampath', 'Kaluthara address', '2001-08-02', 'm', 'bad65421', '07766325845', '../../uploads/coach_profile_images/tharindu_sam645a05cd7f36d.png', '2023-05-09'),
('coach_yas64526058a9e83', 'Yasodhya', 'Sesath', 'Ysodhya address', '1999-07-12', 'm', 'cricket23871', '07741512587', '../../uploads/coach_profile_images/yaso_coach64526058aa09b.jpg', '2023-05-03');

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
('session1', 5000, '02:00:00', 1, 'coach_tha63cce6a49befd', 'badcourt1212', 'Wednesday', '14:00:00', '16:00:00', 2500, '2023-03-08', NULL),
('session2', 5250, '02:00:00', 1, 'coach_sen63f62a9821f62', 'baskcourt45', 'Monday', '12:00:00', '14:00:00', 1500, '2023-03-20', NULL),
('session3', 5000, '01:00:00', 1, 'coach_sen63f62a9821f62', 'basket345', 'Tuesday', '17:00:00', '18:00:00', 600, '2023-05-08', NULL),
('session4', 5250, '03:00:00', 0, 'coach_sen63f62a9821f62', 'basket345', 'Friday', '10:00:00', '13:00:00', 1500, NULL, NULL),
('session5', 2500, '03:00:00', 0, 'coach_pub645a052680750', 'KadSwi6412745c377f6', 'Monday', '09:00:00', '12:00:00', 750, NULL, NULL),
('session6', 3600, '03:00:00', 0, 'coach_cha645a056edb3a8', 'badcourt1213', 'Friday', '15:00:00', '17:00:00', 500, NULL, NULL),
('session7', 4000, '02:00:00', 0, 'coach_tha645a05cd7f35f', 'badcourt1212', 'Saturday', '17:00:00', '19:00:00', 250, NULL, NULL),
('session8', 2500, '02:00:00', 0, 'coach_bha645a07beaa777', 'KanBas64030c042d150', 'Sunday', '16:00:00', '18:00:00', 600, NULL, NULL);

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
('pro basketball', 'coach_sen63f62a9821f62'),
('fifteen years experience swimming', 'coach_yas64526058a9e83'),
('five years experience coaching', 'coach_yas64526058a9e83');

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
('a', '2023-04-18', 'badcourt1212', '2023-04-19', 'Ongoing', 'receptionistkiri1241', 'asdasdad');

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
('ajiRod645a56b71cc35', 'ajith_rodrigo', 'tmaskr14@gmail.com', '$2y$10$1BpdsB7W4GwOtPkr2puFTOgsEl2hbEDgGoHqNXx.hfShdLRopgMWe', 'user', 1),
('coach_bha645a07beaa777', 'bhathiya_bona', 'bhathiyabona@gmail.com', '$2y$10$BGaS0Nio4I/qWVVYD2SM.eTXRE1aaBI9LImuGsSQZTGoROkRzEKdW', 'coach', 1),
('coach_cha645a056edb3a8', 'charith_jay', 'charithpieterz@gmail.com', '$2y$10$tSYqcAnWCYEs2RERNWmrF.mYPIwNb3k4viogwXovK4KeGHazfjB1G', 'coach', 1),
('coach_pub645a052680750', 'pubudu_coach', 'pubudurox@gmail.com', '$2y$10$nZ5vDxYoeQ3hp.2jDYxtsOVm6LR3JFcgV4q4ke38DGvARK3cLfiJe', 'coach', 1),
('coach_sen63f62a9821f62', 'seniru_boss', 'seniru@gmail.com', '$2y$10$9OnzUfCmxzJ3rWNDVP8SeeR.Q/88j8rEOhe.YPQIc2oM.Q3/Si/ry', 'coach', 1),
('coach_tha63cce6a49befd', 'tharuka_boss', 'tharuka@gmail.com', '$2y$10$FdqOvuJlt2ITwPYcrkR8XeTfCaWAom.tN3Yogfd63eyQH2h9QfLhi', 'coach', 1),
('coach_tha645a05cd7f35f', 'tharindu_sam', 'tharindusampath@gmail.com', '$2y$10$8MSMQjqG165.4V1SYA9lmuJoH9O0MYTTgk2y7STCxqmtYfuj2wIEu', 'coach', 1),
('coach_yas64526058a9e83', 'yaso_coach', 'yasodhyasesath@gmail.com', '$2y$10$1oSd9Qz75jKqYyW9sdQTJuoqrgh7vLsc.IOtHwbA1lSojQitP.lzi', 'coach', 1),
('johLie6453900c2e784', 'johan_liebert', 'ramithrodrigo@yahoo.com', '$2y$10$vIRrWv7/UV6N6LJz.uw7eefcbqyHWN8D6hSXVsKrVHmvDv1t5pF0S', 'user', 1),
('managerkiri5436', 'manager_test', 'manager@kiribathgoda.com', '$2a$12$WSDZ.Td2VvI4CxwDHuFCUOZucTdUwG0dkdsXGvI7v2AuOf1rNHCUK', 'manager', 1),
('managersecond1234', 'manager_test2', 'managersecond@gmail.com', '$2a$12$2JO5RyV0bbGQjJn3UEc2seM4EWzQyF5gP9KfYmboH.1ZsXamyVpEe', 'manager', 1),
('mngr64589f895170c', 'manager_lahiru', 'lahirukumara@gmail.com', '$2y$10$t7tNkIpOtF9Q63X5HDXOZ.eStPH4JP7qx6BDwRVhgp7o1xDj3XV8G', 'manager', 1),
('mngr6458a04a2aa58', 'kandy_ryan', 'managergosling@gmail.com', '$2y$10$x.y2ClbDt8jaxMjAyW26qutQlw1h1m9KkJW9U8lV55DtAag5lLzaq', 'manager', 1),
('ownermn74625612', 'sportude_owner', 'owner@gmail.com', '$2a$12$SZojPsXrTIFuqKS9HBMmDO4RytRbnYvSIOeifZEqZaeCg9AsbB51q', 'owner', 1),
('ramRod63816dc9007b4', 'ramith_rodrigo', 'ramithrodrigo@hotmail.com', '$2y$10$noC4B2ROtADFEFrweyweGO27grxaX9QtJ988WqTE33SCDuB5rt0Xe', 'user', 1),
('rcptnst644f4f1f49c7b', 'col_isuru', 'isuru@gmail.com', '$2y$10$gWGXe3JWoZVnVjxD8gtQ9OW7aG3/4ygtV/3RivDn/IomJNj1IACQ6', 'receptionist', 1),
('rcptnst6458a12f43d74', 'kandy_recep', 'sugitaboss@gmail.com', '$2y$10$nhLaX22sDeuLQn3i0MegkulNaTJaGmaQxsRaRbhFTR6qYgib09KeS', 'receptionist', 1),
('receptionistkiri1241', 'recep_test', 'receptionist@kiribathgoda.com', '$2a$12$PFT9firhsYibGVVtHel8Me/hGaVe9gflyxRmY6DyrlQUERJorny02', 'receptionist', 1),
('receptionisttwo123', 'recep_test2', 'receptionisttwo2@gmail.com', '$2y$10$xDW4oVxZ0tS4083hQlp2vubmCOxjvdy0AyzMDADKQzIbfkVGUwPcO', 'receptionist', 1),
('ucsRod645706fe1e661', 'ucsc_ramith', '2020cs150@stu.ucsc.cmb.ac.lk', '$2y$10$PbHgPhrJImhaP1ZVVABXCeV8rQfd8StSENJBbZXBlcJa4kQ0tf29.', 'user', 1);

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
('managersecond1234'),
('mngr64589f895170c'),
('mngr6458a04a2aa58');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notificationID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subject` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `lifetime` time DEFAULT NULL,
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `readTimeStamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationID`, `subject`, `status`, `description`, `date`, `lifetime`, `userID`, `readTimeStamp`) VALUES
('notDul64589cd3d93f7', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-18 from 14:00 to 15:00 at Kandy on Court A', '2023-05-15', NULL, 'ucsRod645706fe1e661', NULL),
('notDul64589e1e22fd6', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-22 from 09:00 to 12:00 at Kiribathgoda on Court A', '2023-05-19', NULL, 'ucsRod645706fe1e661', NULL),
('notDul6458d9d248533', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-15 from 11:00 to 12:00 at Kiribathgoda on Court A', '2023-05-12', NULL, 'ucsRod645706fe1e661', NULL),
('notDul645a4aa5951ec', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-19 from 12:00 to 14:00 at Kiribathgoda on Court A', '2023-05-16', NULL, 'ucsRod645706fe1e661', NULL),
('notJoh6453c7aed0a34', 'Upcoming Reservation', 'Read', 'You have a upcoming reservation on 2023-05-07 from 12:00 to 15:00 at Kiribathgoda on Court A', '2023-05-04', '72:00:00', 'johLie6453900c2e784', '2023-05-06 06:53:21'),
('notJoh6453c883b36f2', 'Upcoming Reservation', 'Read', 'You have a upcoming reservation on 2023-05-07 from 17:00 to 18:00 at Kiribathgoda on Court A', '2023-05-04', '72:00:00', 'johLie6453900c2e784', '2023-05-06 06:53:20'),
('notJoh64589c7c91e74', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-18 from 15:00 to 18:00 at Kandy on Court A', '2023-05-15', NULL, 'johLie6453900c2e784', NULL),
('notRam644d08200c3f9', 'Upcoming Reservation', 'Read', 'You have a upcoming reservation on 2023-05-03 from 13:00 to 14:00 at Kiribathgoda on Court A', '2023-04-30', '72:00:00', 'ramRod63816dc9007b4', '2023-05-03 07:03:37'),
('notRam64589b2fd6072', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-11 from 10:00 to 12:00 at Kandy on Court A', '2023-05-08', NULL, 'ramRod63816dc9007b4', NULL),
('notRam64589bd63384c', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-12 from 13:00 to 14:00 at Kadawatha on Court A', '2023-05-09', NULL, 'ramRod63816dc9007b4', NULL),
('notRam64589c1ae97b8', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-05-19 from 16:00 to 19:00 at Kiribathgoda on Court B', '2023-05-16', NULL, 'ramRod63816dc9007b4', NULL),
('notRam6459344876a90', 'Upcoming Reservation', 'Unread', 'You have a upcoming reservation on 2023-06-07 from 16:00 to 18:00 at Kandy on Court A', '2023-06-04', NULL, 'ramRod63816dc9007b4', NULL),
('notReqram644cba3aa2b25', 'New Student Request', 'Unread', 'You have a new request from an user to join your Coaching Session. Please check your Coaching Session Requests to accept or reject the request.', '2023-04-29', NULL, 'coach_sen63f62a9821f62', NULL),
('notReqram64511d78dfc04', 'New Student Request', 'Unread', 'You have a new request from an user to join your Coaching Session. Please check your Coaching Session Requests to accept or reject the request.', '2023-05-02', NULL, 'coach_tha63cce6a49befd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `onsite_reservation_holder`
--

CREATE TABLE `onsite_reservation_holder` (
  `reservationID` varchar(35) NOT NULL,
  `reservationHolder` varchar(50) NOT NULL,
  `contactNumber` varchar(11) NOT NULL
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
('rcptnst644f4f1f49c7b'),
('rcptnst6458a12f43d74'),
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
  `chargeID` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `notificationID` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservationID`, `date`, `startingTime`, `endingTime`, `noOfPeople`, `paymentAmount`, `sportCourt`, `status`, `userID`, `formalManagerID`, `onsiteReceptionistID`, `reservedDate`, `chargeID`, `notificationID`) VALUES
('Res-joh6453c3cb28a1e', '2023-05-07', '15:00:00', '17:00:00', 2, 1200, 'baskcourt45', 'Refunded', 'johLie6453900c2e784', NULL, NULL, '2023-05-04 14:40:11', 'ch_3N43L9KUOfa0wCPZ0COwzZBn', NULL),
('Res-joh6453c7aeccc50', '2023-05-07', '12:00:00', '15:00:00', 2, 1800, 'baskcourt45', 'feedbackGiven', 'johLie6453900c2e784', NULL, NULL, '2023-05-04 14:56:46', 'ch_3N43bDKUOfa0wCPZ1UdJS4L8', 'notJoh6453c7aed0a34'),
('Res-joh6453c883b093d', '2023-05-07', '17:00:00', '18:00:00', 2, 600, 'baskcourt45', 'feedbackGiven', 'johLie6453900c2e784', NULL, NULL, '2023-05-04 15:00:19', 'ch_3N43eeKUOfa0wCPZ1F6jxMXd', 'notJoh6453c883b36f2'),
('Res-joh6453d4be1e006', '2023-05-11', '11:00:00', '13:00:00', 3, 900, 'badcourt1213', 'Cancelled', 'johLie6453900c2e784', NULL, NULL, '2023-05-04 15:52:30', 'ch_3N44T8KUOfa0wCPZ08gtpCNu', NULL),
('Res-joh64546ba25a685', '2023-05-09', '14:00:00', '17:00:00', 5, 1800, 'basket345', 'Refunded', 'johLie6453900c2e784', NULL, NULL, '2023-05-05 02:36:18', 'ch_3N4EWBKUOfa0wCPZ0G2FJ021', NULL),
('Res-joh64546c0636184', '2023-05-09', '14:00:00', '17:00:00', 2, 1800, 'basket345', 'Cancelled', 'johLie6453900c2e784', NULL, NULL, '2023-05-05 02:37:58', 'ch_3N4EXnKUOfa0wCPZ0ZjllIyK', NULL),
('Res-joh6456ecc22dff8', '2023-05-10', '09:00:00', '10:00:00', 2, 850, 'KanCri64030c042fa53', 'Refunded', 'johLie6453900c2e784', NULL, NULL, '2023-05-07 00:11:46', 'ch_3N4vDPKUOfa0wCPZ18ZLvag0', NULL),
('Res-joh64589c7c8fb69', '2023-05-18', '15:00:00', '18:00:00', 2, 2550, 'KanCri64030c042fa53', 'Pending', 'johLie6453900c2e784', NULL, NULL, '2023-05-08 06:53:48', 'ch_3N5Ny2KUOfa0wCPZ1AvJ0yeo', 'notJoh64589c7c91e74'),
('Res-joh6458cc98e2e85', '2023-05-12', '17:00:00', '18:00:00', 2, 600, 'basket345', 'Refunded', 'johLie6453900c2e784', NULL, NULL, '2023-05-08 10:19:04', 'ch_3N5RAgKUOfa0wCPZ0P6M5m74', NULL),
('Res-joh6458ccea2f4ac', '2023-05-19', '17:00:00', '18:00:00', 2, 600, 'basket345', 'Refunded', 'johLie6453900c2e784', NULL, NULL, '2023-05-08 10:20:26', 'ch_3N5RC0KUOfa0wCPZ0ZIFyx9U', NULL),
('Res-ram640af5470a1d3', '2023-03-15', '12:00:00', '16:00:00', 2, 2200, 'basket345', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-10 09:15:51', 'ch_3Mk23eKUOfa0wCPZ19zoSOAh', NULL),
('Res-ram640af6e2946a6', '2023-03-17', '09:00:00', '11:00:00', 2, 1100, 'basket345', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-10 09:22:42', 'ch_3Mk2AIKUOfa0wCPZ1hEM41xU', NULL),
('Res-ram640af9403a958', '2023-03-13', '16:00:00', '18:00:00', 2, 480, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-10 09:32:48', 'ch_3Mk2K3KUOfa0wCPZ1kChuLTo', NULL),
('Res-ram640afa0717348', '2023-03-16', '17:00:00', '19:00:00', 2, 480, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-10 09:36:07', 'ch_3Mk2NGKUOfa0wCPZ1rxuX6Sn', NULL),
('Res-ram640c3bc12439c', '2023-03-16', '11:00:00', '14:00:00', 2, 1200, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-11 08:28:49', 'ch_3MkNnfKUOfa0wCPZ1kGDz34h', NULL),
('Res-ram6411e08565c1e', '2023-03-20', '15:00:00', '17:00:00', 3, 800, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-15 15:13:09', 'ch_3Mlw1CKUOfa0wCPZ0yGdAwyJ', NULL),
('Res-ram641202dac45d8', '2023-03-22', '11:00:00', '13:00:00', 5, 800, 'badcourt1213', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-15 17:39:38', 'ch_3MlyIxKUOfa0wCPZ0jANnnMT', NULL),
('Res-ram6412034caa2cc', '2023-03-21', '16:00:00', '18:00:00', 2, 800, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-15 17:41:32', 'ch_3MlyKnKUOfa0wCPZ115j3lbj', NULL),
('Res-ram641203cfd208f', '2023-03-21', '10:00:00', '11:00:00', 2, 400, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-15 17:43:43', 'ch_3MlyMvKUOfa0wCPZ0f4nNnHY', NULL),
('Res-ram6412048e3bd15', '2023-03-23', '15:00:00', '17:00:00', 2, 1100, 'basket345', 'feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-15 17:46:54', 'ch_3MlyPzKUOfa0wCPZ0UNgqunQ', NULL),
('Res-ram6412052e0462e', '2023-03-21', '14:00:00', '17:00:00', 2, 1650, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-03-15 17:49:34', 'ch_3MlySZKUOfa0wCPZ0Ai3JDmq', NULL),
('Res-ram6432b818d63e6', '2023-04-13', '12:00:00', '14:00:00', 2, 900, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-09 13:05:28', 'ch_3MuxwZKUOfa0wCPZ1KMvV47I', NULL),
('Res-ram6432b9e839247', '2023-04-14', '09:00:00', '12:00:00', 2, 1350, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-09 13:13:12', 'ch_3Muy43KUOfa0wCPZ1DnvLvgF', NULL),
('Res-ram6432ba671ae1b', '2023-04-18', '18:00:00', '19:00:00', 2, 450, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-09 13:15:19', 'ch_3Muy66KUOfa0wCPZ0WATnyxg', NULL),
('Res-ram6432ce421ed2d', '2023-04-14', '12:00:00', '13:00:00', 2, 450, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-09 14:40:02', 'ch_3MuzQ5KUOfa0wCPZ1BCg3Ir6', NULL),
('Res-ram6437acec2360d', '2023-04-17', '14:00:00', '16:00:00', 2, 900, 'badcourt1212', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-13 07:19:08', 'ch_3MwKReKUOfa0wCPZ1YKUjkho', NULL),
('Res-ram643bf6f0cc88c', '2023-04-20', '12:00:00', '16:00:00', 2, 1800, 'badcourt1212', 'feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-16 13:24:00', 'ch_3MxVZPKUOfa0wCPZ0wQTmVsa', NULL),
('Res-ram644d03abaac27', '2023-05-02', '10:00:00', '12:00:00', 2, 900, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-29 11:46:51', 'ch_3N2CFeKUOfa0wCPZ0hW1VHgH', NULL),
('Res-ram644d04b54cd7f', '2023-05-11', '16:00:00', '17:00:00', 2, 450, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-29 11:51:17', 'ch_3N2CJwKUOfa0wCPZ0JzXJgzh', NULL),
('Res-ram644d07a3e92d6', '2023-05-02', '12:00:00', '15:00:00', 5, 1350, 'badcourt1212', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-29 12:03:47', 'ch_3N2CW2KUOfa0wCPZ0Lvpppnj', NULL),
('Res-ram644d08200a013', '2023-05-03', '13:00:00', '14:00:00', 6, 450, 'badcourt1212', 'feedbackGiven', 'ramRod63816dc9007b4', NULL, NULL, '2023-04-29 12:05:52', 'ch_3N2CY2KUOfa0wCPZ08twJOJi', 'notRam644d08200c3f9'),
('Res-ram644f3bd24fe70', '2023-05-10', '13:00:00', '15:00:00', 2, 1200, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-01 04:10:58', 'ch_3N2o5ZKUOfa0wCPZ18pZXwdI', NULL),
('Res-ram64522bec1b125', '2023-05-06', '10:00:00', '12:00:00', 2, 1200, 'basket345', 'Cancelled', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-03 09:39:56', 'ch_3N3cB1KUOfa0wCPZ00UJ8NqW', NULL),
('Res-ram6456ec1389bb6', '2023-05-13', '14:00:00', '15:00:00', 2, 500, 'KadSwi6412745c377f6', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-07 00:08:51', 'ch_3N4vAbKUOfa0wCPZ062M7dtg', NULL),
('Res-ram6456ec47f20f1', '2023-05-10', '12:00:00', '17:00:00', 10, 4250, 'KanCri64030c042fa53', 'Refunded', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-07 00:09:43', 'ch_3N4vBRKUOfa0wCPZ1FezPlcF', NULL),
('Res-ram64589b2fd366f', '2023-05-11', '10:00:00', '12:00:00', 2, 1200, 'KanBas64030c042d150', 'Pending', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-08 06:48:15', 'ch_3N5NsfKUOfa0wCPZ1a0AvAM8', 'notRam64589b2fd6072'),
('Res-ram64589bd631391', '2023-05-12', '13:00:00', '14:00:00', 2, 500, 'KadSwi6412745c377f6', 'Pending', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-08 06:51:02', 'ch_3N5NvMKUOfa0wCPZ0GeVG0vK', 'notRam64589bd63384c'),
('Res-ram64589c1ae6cb4', '2023-05-19', '16:00:00', '19:00:00', 2, 1500, 'badcourt1213', 'Pending', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-08 06:52:10', 'ch_3N5NwSKUOfa0wCPZ0GAHIHOK', 'notRam64589c1ae97b8'),
('Res-ram64593448716cd', '2023-06-07', '16:00:00', '18:00:00', 2, 1200, 'KanBas64030c042d150', 'Pending', 'ramRod63816dc9007b4', NULL, NULL, '2023-05-08 17:41:28', 'ch_3N5Y4oKUOfa0wCPZ09bkZr5j', 'notRam6459344876a90'),
('Res-ucs645707a2057af', '2023-05-12', '10:00:00', '13:00:00', 5, 1500, 'badcourt1213', 'Refunded', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-07 02:06:26', 'ch_3N4x0NKUOfa0wCPZ09MzMQ14', NULL),
('Res-ucs645708ad9eb35', '2023-05-10', '10:00:00', '12:00:00', 10, 1700, 'KanCri64030c042fa53', 'Refunded', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-07 02:10:53', 'ch_3N4x4hKUOfa0wCPZ0k1qV2rb', NULL),
('Res-ucs64589cd3d04ab', '2023-05-18', '14:00:00', '15:00:00', 2, 850, 'KanCri64030c042fa53', 'Pending', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-08 06:55:15', 'ch_3N5NzRKUOfa0wCPZ15AjWnRd', 'notDul64589cd3d93f7'),
('Res-ucs64589e1e20fef', '2023-05-22', '09:00:00', '12:00:00', 2, 1800, 'baskcourt45', 'Pending', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-08 07:00:46', 'ch_3N5O4mKUOfa0wCPZ1F4QHE18', 'notDul64589e1e22fd6'),
('Res-ucs6458d9d2453be', '2023-05-15', '11:00:00', '12:00:00', 2, 600, 'baskcourt45', 'Pending', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-08 11:15:30', 'ch_3N5S3IKUOfa0wCPZ0eWcgaWP', 'notDul6458d9d248533'),
('Res-ucs6458da0b330ac', '2023-05-22', '13:00:00', '15:00:00', 2, 1200, 'baskcourt45', 'Refunded', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-08 11:16:27', 'ch_3N5S4DKUOfa0wCPZ0QDYaIJZ', NULL),
('Res-ucs645a4aa589f0b', '2023-05-19', '12:00:00', '14:00:00', 2, 1000, 'badcourt1212', 'Pending', 'ucsRod645706fe1e661', NULL, NULL, '2023-05-09 13:29:09', 'ch_3N5qcCKUOfa0wCPZ0devp6U6', 'notDul645a4aa5951ec');

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
('bad65421', 'Badminton', 'Amazing sport to play with friends', 500, 600, 10),
('basket17212', 'Basketball', 'A sport that requires speed', 600, 720, 25),
('cricket23871', 'Cricket', 'wanna play 11 vs 11?', 850, 1020, 20),
('Swim6405710541644', 'Swimming', 'test description', 500, 600, NULL),
('Tabl64038296afcad', 'Table Tennis', 'highly competitive and engaging for a 2v2 sport', 350, 420, NULL),
('Tenn64561aba2ede4', 'Tennis', '2v2 or 1v1, the choice is yours', 650, 780, NULL),
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
('AnuVol64560bae1279a', 'Voll64037fe13cf3a', 'A', 'Anur64560bae11051', 'p', NULL),
('badcourt1212', 'bad65421', 'A', 'kiri987521', 'a', NULL),
('badcourt1213', 'bad65421', 'B', 'kiri987521', 'a', NULL),
('baskcourt45', 'basket17212', 'A', 'kiri987521', 'a', NULL),
('basket345', 'basket17212', 'A', 'col128423', 'a', NULL),
('KadSwi6412745c377f6', 'Swim6405710541644', 'A', 'Kada6412745c32a13', 'a', NULL),
('KanBas64030c042d150', 'basket17212', 'A', 'Kand64030c042c114', 'a', NULL),
('KanBas64030c042e430', 'basket17212', 'B', 'Kand64030c042c114', 'a', NULL),
('KanCri64030c042fa53', 'cricket23871', 'A', 'Kand64030c042c114', 'a', NULL),
('tesBad6405701261bb3', 'bad65421', 'A', 'test64057012608ab', 'd', NULL),
('tesTab6405701263373', 'Tabl64038296afcad', 'A', 'test64057012608ab', 'd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sports_court_photo`
--

CREATE TABLE `sports_court_photo` (
  `courtPhoto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `courtID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sports_court_photo`
--

INSERT INTO `sports_court_photo` (`courtPhoto`, `courtID`) VALUES
('/uploads/sports_court_images/badminton_1.webp', 'badcourt1212'),
('/uploads/sports_court_images/basketball_court.jpg', 'baskcourt45'),
('/uploads/sports_court_images/basketball_court2.jpg', 'basket345');

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
('mngr64589f895170c', '07755889962', 'm', '1998-01-01', 'Lahiru', 'Kumara', '2023-05-08', NULL, 'manager', 'Kada6412745c32a13'),
('mngr6458a04a2aa58', '07766385421', 'm', '1988-05-22', 'Ryan', 'Gosling', '2023-05-08', NULL, 'manager', 'Kand64030c042c114'),
('rcptnst644f4f1f49c7b', '0778542145', 'm', '2003-02-06', 'Isuru', 'Heshan', '2023-05-01', NULL, 'receptionist', 'Kada6412745c32a13'),
('rcptnst6458a12f43d74', '0715632852', 'm', '1985-08-07', 'Sugita', 'Tomokazu', '2023-05-08', NULL, 'receptionist', 'Kand64030c042c114'),
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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_coach_feedback`
--

INSERT INTO `student_coach_feedback` (`feedbackID`, `description`, `rating`, `coachID`, `stuID`, `date`) VALUES
('coachFB63fb6d8cde7ca', 'waeasd', 4, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-02-26'),
('coachFB6404285fba115', 'okay good', 3, 'coach_sen63f62a9821f62', 'ramRod63816dc9007b4', '2023-03-05'),
('feedback1', 'Amazing', 4, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2022-02-03'),
('feedback2', 'I know many children ask for a pony, but I wanted a bicycle with rockets strapped to it.\r\nHe felt that dining on the bridge brought romance to his relationship with his cat.\r\nThirty years later, she still thought it was okay to put the toilet paper roll under rather than over.', 4, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-04-13'),
('feedback3', 'She folded her handkerchief neatly.\r\nThey desperately needed another drummer since the current one only knew how to play bongos.\r\nShe advised him to come back at once.', 5, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-04-04'),
('feedback4', 'You have no right to call yourself creative until you look at a trowel and think that it would make a great lockpick.\r\n8% of 25 is the same as 25% of 8 and one of them is much easier to do in your head.\r\nCar safety systems have come a long way, but he was out to prove they could be outsmarted.\r\nThe spa attendant applied the deep cleaning mask to the gentleman’s back.\r\nHenry couldn\'t decide if he was an auto mechanic or a priest.', 2, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-04-30'),
('feedback5', 'My Mum tries to be cool by saying that she likes all the same things that I do.\r\nSo long and thanks for the fish.\r\nHe had reached the point where he was paranoid about being paranoid.\r\nPeanuts don\'t grow on trees, but cashews do.\r\nIt took me too long to realize that the ceiling hadn\'t been painted to look like the sky.\r\nPink horses galloped across the sea.\r\nDon\'t put peanut butter on the dog\'s nose.\r\nThere\'s no reason a hula hoop can\'t also be a circus ring.', 5, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-04-16'),
('feedback6', 'The skeleton had skeletons of his own in the closet.\r\nWe have young kids who often walk into our room at night for various reasons including clowns in the closet.\r\nI think I will buy the red car, or I will lease the blue one.\r\nHenry couldn\'t decide if he was an auto mechanic or a priest.\r\nThe random sentence generator generated a random sentence about a random sentence.\r\nShe discovered van life is difficult with 2 cats and a dog.\r\nIt was getting dark, and we weren’t there yet.', 4, 'coach_tha63cce6a49befd', 'ramRod63816dc9007b4', '2023-04-13');

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
('ramRod63816dc9007b4', 'session1', '2023-02-01', '2023-03-06'),
('ramRod63816dc9007b4', 'session1', '2023-03-06', '2023-03-06');

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

--
-- Dumping data for table `system_maintenance`
--

INSERT INTO `system_maintenance` (`expectedDowntime`, `adminID`, `startingDate`, `startingTime`) VALUES
('02:00:00', 'admin6389f6eef2e18', '2023-05-11', '09:00:00');

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
('ajiRod645a56b71cc35', 'Ajith', 'Rodrigo', 'm', NULL, 'No.301/5, Mihindu Mawatha, Makola North, Makola', '0778548479', '1980-11-14', '2023-05-09', NULL, 55),
('johLie6453900c2e784', 'Johan', 'Liebert', 'm', '../../uploads/user_profile_images/johan_liebert6453900c2ed7e.png', 'No. 432/5A, Some Street Name, AB City', '07766451257', '1998-05-12', '2023-05-04', 180, 60),
('ramRod63816dc9007b4', 'Ramith', 'Rodrigo', 'm', '../../uploads/user_profile_images/ramith_rodrigo645211103e821.png', 'No.301/5 Mihindu Mawatha, Makola North, Makola', '0767275867', '2000-09-01', '2022-11-26', 180, 60),
('ucsRod645706fe1e661', 'Dulsara', 'Rodrigo', 'm', '../../uploads/user_profile_images/ucsc_ramith6457076046de0.jpg', 'No.301/5, Mihindu Mawatha, Makola North, Makola', '07736521485', '2000-09-01', '2023-05-07', NULL, NULL);

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
('FB644f866d30ed7', 'ramRod63816dc9007b4', '2023-05-01', 5, 'I had a lot of fun! what an amazing experience!', 'kiri987521'),
('FB64522c7728484', 'ramRod63816dc9007b4', '2023-05-03', 4, 'I want to come back again. We were able to enjoy with courts to ourselves with no issues!', 'col128423'),
('FB64570aafd8008', 'johLie6453900c2e784', '2023-05-07', 3, 'It was okay, Wish the price was cheaper', 'kiri987521'),
('FB64570b14d23e7', 'johLie6453900c2e784', '2023-05-07', 4, 'We will be coming back for more. ', 'kiri987521'),
('FB645898d28d1d6', 'ramRod63816dc9007b4', '2023-05-08', 3, 'Test feedback', 'kiri987521'),
('feedback1243wolololo', 'ramRod63816dc9007b4', '2023-04-11', 5, 'Amazing! it has been a long time that me and my friends got together and played like in the old days. Well, not exactly like the old days because this place is fancy and facilities are quite nice!', 'col128423'),
('feedbackwo1lololo', 'ramRod63816dc9007b4', '2023-04-11', 3, 'Feels like the price is bit higher. I request to lower the said prices. Other than that, no other issues. the place was quite okay', 'col128423'),
('feedbackwol112ololo', 'ramRod63816dc9007b4', '2023-04-11', 1, 'The skeleton had skeletons of his own in the closet.\r\nWe have young kids who often walk into our room at night for various reasons including clowns in the closet.\r\nI think I will buy the red car, or I will lease the blue one.\r\nHenry couldn\'t decide if he was an auto mechanic or a priest.\r\nThe random sentence generator generated a random sentence about a random sentence.\r\nShe discovered van life is difficult with 2 cats and a dog.\r\nIt was getting dark, and we weren’t there yet.', 'kiri987521'),
('feedbackwol11ololo', 'ramRod63816dc9007b4', '2023-04-11', 5, 'The skeleton had skeletons of his own in the closet.\r\nWe have young kids who often walk into our room at night for various reasons including clowns in the closet.\r\nI think I will buy the red car, or I will lease the blue one.\r\nHenry couldn\'t decide if he was an auto mechanic or a priest.\r\nThe random sentence generator generated a random sentence about a random sentence.\r\nShe discovered van life is difficult with 2 cats and a dog.\r\nIt was getting dark, and we weren’t there yet.', 'kiri987521');

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
('ajiRod645a56b71cc35', 'Champa', 'Partner', '0776325418'),
('ajiRod645a56b71cc35', 'Ramith Rodrigo', 'Other', '0774147852'),
('johLie6453900c2e784', 'Anna', 'Sibling 1', '0714541369'),
('johLie6453900c2e784', 'Tenma', 'Friend 1', '0759846328'),
('ramRod63816dc9007b4', 'Ajith', 'Father', '0714831744'),
('ucsRod645706fe1e661', 'Champa', 'Mother', '0779965428');

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
('ajiRod645a56b71cc35', 'eyesight'),
('johLie6453900c2e784', 'Leg cramps');

-- --------------------------------------------------------

--
-- Table structure for table `user_request_coaching_session`
--

CREATE TABLE `user_request_coaching_session` (
  `userID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sessionID` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requestDate` date NOT NULL,
  `message` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `notificationID` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_request_coaching_session`
--

INSERT INTO `user_request_coaching_session` (`userID`, `sessionID`, `requestDate`, `message`, `notificationID`) VALUES
('ramRod63816dc9007b4', 'session1', '2023-05-02', 'sdfsdfsdf', 'notReqram64511d78dfc04'),
('ramRod63816dc9007b4', 'session2', '2023-04-29', NULL, 'notReqram644cba3aa2b25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branchID`),
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
-- Indexes for table `onsite_reservation_holder`
--
ALTER TABLE `onsite_reservation_holder`
  ADD PRIMARY KEY (`reservationID`);

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
  ADD KEY `onsite_receptionist_id` (`onsiteReceptionistID`),
  ADD KEY `reservation_ibfk_5` (`notificationID`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`sportID`),
  ADD UNIQUE KEY `sportName` (`sportName`);

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
  ADD KEY `session_id` (`sessionID`),
  ADD KEY `notificationID` (`notificationID`);

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
-- Constraints for table `onsite_reservation_holder`
--
ALTER TABLE `onsite_reservation_holder`
  ADD CONSTRAINT `onsite_reservation_holder_ibfk_1` FOREIGN KEY (`reservationID`) REFERENCES `reservation` (`reservationID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`onsiteReceptionistID`) REFERENCES `receptionist` (`receptionistID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reservation_ibfk_5` FOREIGN KEY (`notificationID`) REFERENCES `notification` (`notificationID`) ON DELETE SET NULL ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `user_request_coaching_session_ibfk_2` FOREIGN KEY (`sessionID`) REFERENCES `coaching_session` (`sessionID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_request_coaching_session_ibfk_3` FOREIGN KEY (`notificationID`) REFERENCES `notification` (`notificationID`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
