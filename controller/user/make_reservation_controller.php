<?php
    //this script is used to make a reservation
    session_start();
    require_once("../../src/general/security.php");
    //check the authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
        Security::redirectUserBase();
        die();
    }

    //post request check
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        Security::redirectUserBase();
        die();
    }

    $returningMsg = [];

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $reservationDetails = json_decode($requestJSON, true);


    if(empty($requestJSON) || $requestJSON == null){ //have not made the reservation
        $returningMsg['errMsg'] = "Not made any reservations yet";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }

    require_once("../../src/general/reservation.php");
    require_once("../../src/user/user.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/branch.php");
    require_once("../CONSTANTS.php");

    
    //store the reservation details

    $court_id = $reservationDetails['courtID'];
    $numOfpeople = htmlspecialchars($reservationDetails['numOfPeople'], ENT_QUOTES);
    $startingTime = $reservationDetails['reservingStartTime'];
    $endingTime = $reservationDetails['reservingEndTime'];
    $date = $reservationDetails['reservingDate'];
    $user = $_SESSION['userid'];
    $token = $reservationDetails['tokenID'];
    
    //user inputs validation
    $validationFlag = false;
    if($numOfpeople <= 0){  //number of people input
        $validationFlag = true;
    }

    if($validationFlag === true){
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }

    date_default_timezone_set(SERVER_TIMEZONE);

    $startingTimeObj = new DateTime($startingTime);
    $endingTimeObj = new DateTime($endingTime);
    $timeDifference = date_diff($startingTimeObj, $endingTimeObj);

    if($startingTimeObj >= $endingTimeObj){ //time range validation
        $validationFlag = true;
    }
    else if($startingTimeObj -> format('i') !== '00'){  //minutes should be 0
        $validationFlag = true;
    }
    else if($endingTimeObj -> format('i') !== '00'){  //minutes should be 0
        $validationFlag = true;
    }
    else if($startingTimeObj -> format('s') != '00'){    //seconds should be 0
        $validationFlag = true;
    }
    else if($endingTimeObj -> format('s') != '00'){    //seconds should be 0
        $validationFlag = true;
    }
    else if($timeDifference -> h < MIN_RESERVATION_TIME_HOURS || $timeDifference -> h > MAX_RESERVATION_TIME_HOURS || ($timeDifference -> h === MAX_RESERVATION_TIME_HOURS && $timeDifference -> i != 0)){ //minimum and maximum reservation time period check
        $validationFlag = true;
    }
    if($validationFlag === true){
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }
    
    $today = new DateTime();
    $today -> setTime(0, 0, 0); //so that we can compare the dates correctly
    $reservingDateObj = new DateTime($date);
    $dateDifference = date_diff($today, $reservingDateObj);

    if($today >= $reservingDateObj || $dateDifference -> days < MIN_RESERVATION_DAYS || $dateDifference -> days > MAX_RESERVATION_DAYS){  //reservation date validation
        $validationFlag = true;
    }

    if($validationFlag === true){
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }

    //can continue
    $reservingUser = new User(); 
    $reservingUser -> setUserID($user);//create an user with logged in userid

    $reservingCourt = new Sports_Court($court_id);
    $reservingSport = $reservingCourt -> getSport($reservingUser -> getConnection());

    if($reservingSport === false){   //no sport
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }
    
    $reservingSport -> getDetails($reservingUser -> getConnection(), ['reservationPrice', 'sportName']);
    $reservationPrice = json_decode(json_encode($reservingSport)) -> reservationPrice; //get the reservation price
    $calculation = ($timeDifference -> h + ($timeDifference -> i/60));  //get hours and minutes and convert minutes to hours to get the period in hours
    $payment = $reservationPrice * $calculation;//calculate the payment

    //check for branch discount
    $branchID = $reservingCourt -> getBranch($reservingUser -> getConnection());
    $branch = new Branch($branchID);

    $discountValue = $branch -> getCurrentDiscount($reservingUser -> getConnection());

    if($discountValue != null){    //branch has a discount
        $payment = $payment - ($payment * ($discountValue/100));
    }


    //reservation availability check

    //branch maintenance
    $branchMaintenance = $branch -> getBranchMaintenance($reservingUser -> getConnection(),['startingDate', 'endingDate'], $date, 'a');

    if(count($branchMaintenance) !== 0){   //branch has maintenance
        foreach($branchMaintenance as $maintenance){
            if(strtotime($maintenance -> startingDate) <= strtotime($date) && strtotime($maintenance -> endingDate) >= strtotime($date)){   //the reservation date is in middle of the maintenance period
                $returningMsg['errMsg'] = "Branch is under Maintenance";
                header('Content-Type: application/json;');    //because we are sending json
                echo json_encode($returningMsg);
                unset($branch);
                exit();
            }
        }
    }

    $availabilityCheck = $reservingCourt -> reservationAvailability($date, $startingTime, $endingTime, $reservingUser -> getConnection());

    if($availabilityCheck[0] === false){   //court is not available
        $returningMsg['errMsg'] = $availabilityCheck[1];    //get the error message
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        unset($reservingCourt);
        exit();
    }
    //can be reserved

    //payment 
    require_once("../../src/general/paymentGateway.php");

    $reservingUser -> getProfileDetails(['firstName', 'lastName']);
    $userJSON = json_decode(json_encode($reservingUser), true);

    $fName = $userJSON['firstName'];
    $lName = $userJSON['lastName'];


    $branch -> getDetails($reservingUser -> getConnection(), ['city']);
    $branchName =  json_decode(json_encode($branch), true)['city'];
    //current timestamp for the timezone of the server
    date_default_timezone_set(SERVER_TIMEZONE);
    $timestamp = date('Y-m-d H:i:s');   

    //reservation description
    $reservationDescription = "Reservation for ".$date." from ".$startingTime." to ".$endingTime." for ".$numOfpeople." people on ".$branchName. " by ".$fName." ".$lName." at ".$timestamp;

    $paymentResult = paymentGateway::userReservationPayment($payment, $reservationDescription, CURRENCY, $token);
    if(!$paymentResult[0]){ //0th index is the status of the payment
        //payment failed
        $returningMsg['errMsg'] = $paymentResult[1]; //1st index is the error message
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }

    $chargeID = $paymentResult[2]; //2nd index is the charge id

    //now making the reservation since the payment succeeded
    $result = $reservingUser -> makeReservation($date, $startingTime, $endingTime, $numOfpeople, $payment, $chargeID, $reservingCourt);   //pass the reserving court object to the function
    if($result[0] === TRUE){
        $returningMsg['successMsg'] = "Reservation has been made Successfully";

        //add notification
        require_once("../../src/general/notification.php");
        $notificationID = uniqid("not". substr($fName, 0, 3));

        $notification = new Notification($notificationID);

        $courtName = $reservingCourt -> getName($reservingUser -> getConnection());
        $notificationDescription = "You have a upcoming reservation on ".$date." from ".$startingTime." to ".$endingTime." at ".$branchName." on Court ".$courtName;
        //notification trigger date is 3 days before the reservation date
        $notificationTriggerDate = date('Y-m-d', strtotime($date. ' - 3 days'));
        $notification -> setDetails(subject: "Upcoming Reservation", 
            status: 'Unread', 
            description: $notificationDescription, 
            date : $notificationTriggerDate, 
            userID: $reservingUser -> getUserID());

        $notification -> setNotificationEntry($reservingUser -> getConnection());

        //update the reservation notification id
        $createdReservation = new Reservation();
        $createdReservation -> setID($result[1]); //1st index is the reservation id
        $createdReservation -> addNotificationID($notificationID, $reservingUser -> getConnection());

        //send email regarding the reservation payment
        require_once("../../src/general/mailer.php");
        $sportName = json_decode(json_encode($reservingSport), true)['sportName'];
        Mailer::onlineReservationPayment($reservingUser -> getEmailAddress(), $reservingUser -> getUsername(), $branchName, $sportName, $courtName, $date, $startingTime, $endingTime, $payment, CURRENCY);

        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
    }
    else{//error while inserting the reservation
        $returningMsg['errMsg'] = $result[1];   //1st index is the error message
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
    }
/*     $branch = $reservingCourt -> getBranch($connection);
    $sport = $reservingCourt -> getBranch */
    unset($reservingCourt);
    unset($reservingUser);
    unset($branch);
    unset($reservingSport);

?>