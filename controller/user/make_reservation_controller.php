<?php
    session_start();
/*     $requestJSON =  file_get_contents("php://input");   //get the raw json string
    print_r(json_decode($requestJSON, true));
    exit(); */
    $previousPage = $_SESSION['prevPage'];
    //$returningMsg = [];
    if(!isset($_SESSION['userrole']) || !isset($_SESSION['userid'])){  //not logged in
        $_SESSION['reservationFail'] = "Please Log in to make a Reservation";
        header("Location: {$previousPage}");
/*         header('Content-Type: application/json;');    //because we are sending json
        $returningMsg['msg'] = "Please Log in to make a Reservation";
        echo json_encode($returningMsg); */
        exit();
    }

    if(empty($_POST)){ //have not made the reservation
        //$returningMsg['msg'] = "Not made any reservations yet";
        header("Location: {$previousPage}");
        exit();
    }

    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/reservation.php");
    require_once("../../src/user/user.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/sport.php");
    require_once("../CONSTANTS.php");

    if($_SESSION['userrole'] !== 'user'){   //not a user
        header("Location: /index.php");
        exit();
    }
    
    //store the reservation details

    $court_id = $_POST['makeReserveBtn'];
    $numOfpeople = htmlspecialchars($_POST['numOfPeople'], ENT_QUOTES);
    $startingTime = $_POST['reservingStartTime'];
    $endingTime = $_POST['reservingEndTime'];
    $date = $_POST['reservingDate'];
    $user = $_SESSION['userid'];
    
    //user inputs validation
    $validationFlag = false;
    if($numOfpeople <= 0){  //number of people input
        $validationFlag = true;
    }

    if($validationFlag === true){
        $_SESSION['reservationFail'] = "Reservation Failed";
        $connection -> close();
        header("Location: {$previousPage}");
        exit(); 
    }

    $startingTimeObj = new DateTime($startingTime);
    $endingTimeObj = new DateTime($endingTime);
    $timeDifference = date_diff($startingTimeObj, $endingTimeObj);

    if($startingTimeObj >= $endingTimeObj){ //time range validation
        $validationFlag = true;
    }
    else if($startingTimeObj -> format('i') !== '30' && $startingTimeObj -> format('i') !== '00'){  //minutes should be 0 or 30
        $validationFlag = true;
    }
    else if($endingTimeObj -> format('i') !== '30' && $endingTimeObj -> format('i') !== '00'){  //minutes should be 0 or 30
        $validationFlag = true;
    }
    else if($startingTimeObj -> format('s') != '00'){    //seconds should be 0
        $validationFlag = true;
    }
    else if($endingTimeObj -> format('s') != '00'){    //seconds should be 0
        $validationFlag = true;
    }
    else if($timeDifference -> h < MIN_RESERVATION_TIME_HOURS || $timeDifference -> h > MAX_RESERVATION_TIME_HOURS || ($timeDifference -> h === MAX_RESERVATION_TIME_HOURS && $timeDifference -> i === 30)){ //minimum and maximum reservation time period check
        $validationFlag = true;
    }
    if($validationFlag === true){
        $_SESSION['reservationFail'] = "Reservation Failed";
        $connection -> close();
        header("Location: {$previousPage}");
        exit(); 
    }
    
    $today = new DateTime();
    $reservingDateObj = new DateTime($date);
    $dateDifference = date_diff($today, $reservingDateObj);

    if($today >= $reservingDateObj || $dateDifference -> days < MIN_RESERVATION_DAYS || $dateDifference -> days > MAX_RESERVATION_DAYS){  //reservation date validation
        $validationFlag = true;
    }

    if($validationFlag === true){
        $_SESSION['reservationFail'] = "Reservation Failed";
        $connection -> close();
        unset($today);
        unset($reservingDateObj);
        header("Location: {$previousPage}");
        exit(); 
    }

    //can continue

    $reservingCourt = new Sports_Court($court_id);
    $sport = $reservingCourt -> getSport($connection);

    if($sport === false){   //no sport
        $_SESSION['reservationFail'] = "Reservation Failed";
        $connection -> close();
        unset($reservingCourt);
        header("Location: {$previousPage}");
        exit(); 
    }
    
    $reservingSport = new Sport();
    $reservingSport -> setID($sport);
    $reservationPrice = $reservingSport -> getDetails($connection, 'reservationPrice');
    $calculation = ($timeDifference -> h + ($timeDifference -> i/60));  //get hours and minutes and convert minutes to hours to get the period in hours
    $payment = $reservationPrice * $calculation;//calculate the payment


    //reservation availability check
    $schedule = $reservingCourt -> getSchedule($connection);

    foreach($schedule as $reservation){
        //print_r($reservation);
        if($reservation -> date === $date && $reservation -> status === 'Pending'){ //only need the reservations that are pending
            if(strtotime($startingTime) < strtotime($reservation -> starting_time) && strtotime($endingTime) > strtotime($reservation -> ending_time)){ //current reserving time slot is over an already reserved time slot
                //$returningMsg['reservationFailMsg'] = "Entered Time Period is already Reserved";
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "Over the top"."<br>";
                $connection -> close();
                unset($reservingCourt);
                unset($reservingSport);
                header("Location: {$previousPage}");
                //echo json_encode($returningMsg);
                exit();
            }
            else if(strtotime($startingTime) >= strtotime($reservation -> starting_time) && strtotime($endingTime) <= strtotime($reservation -> ending_time)){    //current reserving time slot is within an already reserved time slot
                //$returningMsg['reservationFailMsg'] = "Entered Time Period is already Reserved";
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "within or same"."<br>";
                $connection -> close();
                unset($reservingCourt);
                unset($reservingSport);
                header("Location: {$previousPage}");
                //echo json_encode($returningMsg);
                exit();
            }
            else if(strtotime($startingTime) < strtotime($reservation -> starting_time) && (strtotime($endingTime) <= strtotime($reservation -> ending_time) && strtotime($endingTime) > strtotime($reservation -> starting_time))){    //ending time is within an already resevred slot
                //$returningMsg['reservationFailMsg'] = "Entered Time Period is already Reserved";
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "ending is within or same. starting is outside"."<br>";
                $connection -> close();
                unset($reservingCourt);
                unset($reservingSport);
                header("Location: {$previousPage}");
                //echo json_encode($returningMsg);
                exit();
            }
            else if((strtotime($startingTime) >= strtotime($reservation -> starting_time) && strtotime($startingTime) < strtotime($reservation -> ending_time)) && strtotime($endingTime) > strtotime($reservation -> ending_time)){   //starting time is within an already reserved slot
                //$returningMsg['reservationFailMsg'] = "Entered Time Period is already Reserved";
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "starting is within or same. ending is outside"."<br>";
                $connection -> close();
                unset($reservingCourt);
                unset($reservingSport);
                header("Location: {$previousPage}");
                //echo json_encode($returningMsg);
                exit();
            }
            else{
                continue;   //can be reserved
            }
        }
    }
    //now making the reservation
    $reservingUser = new User(); 
    $reservingUser -> setDetails(uid : $user);//create an user with logged in userid

    
    $result = $reservingUser -> makeReservation($date, $startingTime, $endingTime, $numOfpeople, $payment, $reservingCourt, $connection);   //pass the reserving court object to the function
    if($result === TRUE){
        $_SESSION['reservationSuccess'] = "Reservation has been made Successfully";
        //$returningMsg['reservationSuccessMsg'] = "Reservation has been made Successfully";
    }
    else{
        $_SESSION['reservationFail'] = "Reservation has not been made";
        //$returningMsg['reservationFailMsg'] = "Reservation has not been made";
    }
/*     $branch = $reservingCourt -> getBranch($connection);
    $sport = $reservingCourt -> getBranch */
    unset($reservingCourt);
    unset($reservingUser);
    unset($reservingSport);
    $connection -> close();
    header("Location: {$previousPage}");
?>