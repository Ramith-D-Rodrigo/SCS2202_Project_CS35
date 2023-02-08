<?php
    session_start();

    $returningMsg = [];

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $reservationDetails = json_decode($requestJSON, true);

    if(!isset($_SESSION['userrole']) || !isset($_SESSION['userid'])){  //not logged in
        //$_SESSION['reservationFail'] = "Please Log in to make a Reservation";
        $returningMsg['errMsg'] = "Please Log in to make a Reservation";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }

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

    if($_SESSION['userrole'] !== 'user'){   //not a user
        header("Location: /index.php");
        exit();
    }
    
    //store the reservation details

    $court_id = $reservationDetails['makeReserveBtn'];
    $numOfpeople = htmlspecialchars($reservationDetails['numOfPeople'], ENT_QUOTES);
    $startingTime = $reservationDetails['reservingStartTime'];
    $endingTime = $reservationDetails['reservingEndTime'];
    $date = $reservationDetails['reservingDate'];
    $user = $_SESSION['userid'];
    
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
    else if($timeDifference -> h < MIN_RESERVATION_TIME_HOURS || $timeDifference -> h > MAX_RESERVATION_TIME_HOURS || ($timeDifference -> h === MAX_RESERVATION_TIME_HOURS && $timeDifference -> i === 30)){ //minimum and maximum reservation time period check
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
    $reservingUser -> setDetails(uid : $user);//create an user with logged in userid

    $reservingCourt = new Sports_Court($court_id);
    $sport = $reservingCourt -> getSport($reservingUser -> getConnection());

    if($sport === false){   //no sport
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }
    
    $reservingSport = new Sport();
    $reservingSport -> setID($sport);
    $reservationPrice = $reservingSport -> getDetails($reservingUser -> getConnection(), 'reservationPrice');
    $calculation = ($timeDifference -> h + ($timeDifference -> i/60));  //get hours and minutes and convert minutes to hours to get the period in hours
    $payment = $reservationPrice * $calculation;//calculate the payment


    //reservation availability check
    $schedule = $reservingCourt -> getSchedule($reservingUser -> getConnection());


    //branch maintenance
    $branchID = $reservingCourt -> getBranch($reservingUser -> getConnection());
    $branch = new Branch($branchID);
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

    //court maintenance
    foreach($schedule['maintenance'] as $maintenance){
        if(strtotime($maintenance -> startingDate) <= strtotime($date) && strtotime($maintenance -> endingDate) >= strtotime($date)){   //the reservation date is in middle of the maintenance period
            $returningMsg['errMsg'] = "Court is under Maintenance";
            header('Content-Type: application/json;');    //because we are sending json
            echo json_encode($returningMsg);
            exit();
        }
    }

    //coaching sessions
    foreach($schedule['coachingSessions'] as $coachingSession){
        //get the day of the week of reservation date
        if($coachingSession -> noOfStudents > 0){   //ongoing session
            $dayOfWeek = date('l', strtotime($date));
            if($coachingSession -> day === $dayOfWeek){ //reservation is on the same day
                if(strtotime($coachingSession -> startingTime) > strtotime($startingTime) && strtotime($coachingSession -> endingTime) < strtotime($endingTime)){
                    $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                    header('Content-Type: application/json;');    //because we are sending json
                    echo json_encode($returningMsg);
                    exit();
                }
                else if(strtotime($coachingSession -> startingTime) <= strtotime($startingTime) && strtotime($coachingSession -> endingTime) >= strtotime($endingTime)){ //before coaching session starting time, but reservation ending time is inside the coaching session
                    $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                    header('Content-Type: application/json;');    //because we are sending json
                    echo json_encode($returningMsg);
                    exit();
                }
                else if(strtotime($coachingSession -> startingTime) > strtotime($startingTime) && (strtotime($endingTime) <= strtotime($coachingSession -> endingTime) && strtotime($endingTime) > strtotime($coachingSession -> startingTime))){ //current reserving time slot is over an already reserved time slot
                    $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                    header('Content-Type: application/json;');    //because we are sending json
                    echo json_encode($returningMsg);
                    exit();
                }
                else if((strtotime($startingTime) >= strtotime($coachingSession -> startingTime) && strtotime($startingTime) < strtotime($coachingSession -> endingTime)) && strtotime($coachingSession -> endingTime) < strtotime($endingTime)){ //current reserving time slot is over an already reserved time slot
                    $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                    header('Content-Type: application/json;');    //because we are sending json
                    echo json_encode($returningMsg);
                    exit();
                }
            }
        }
    }


    //user reservations
    foreach($schedule['reservations'] as $reservation){
        //print_r($reservation);
        if($reservation -> date === $date && $reservation -> status === 'Pending'){ //only need the reservations that are pending
            if(strtotime($startingTime) < strtotime($reservation -> startingTime) && strtotime($endingTime) > strtotime($reservation -> endingTime)){ //current reserving time slot is over an already reserved time slot
                $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                header('Content-Type: application/json;');    //because we are sending json
                echo json_encode($returningMsg);
                exit();
                //echo "Over the top"."<br>";
            }
            else if(strtotime($startingTime) >= strtotime($reservation -> startingTime) && strtotime($endingTime) <= strtotime($reservation -> endingTime)){    //current reserving time slot is within an already reserved time slot
                $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                header('Content-Type: application/json;');    //because we are sending json
                echo json_encode($returningMsg);
                exit();
                //echo "within or same"."<br>";
            }
            else if(strtotime($startingTime) < strtotime($reservation -> startingTime) && (strtotime($endingTime) <= strtotime($reservation -> endingTime) && strtotime($endingTime) > strtotime($reservation -> startingTime))){    //ending time is within an already resevred slot
                $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                header('Content-Type: application/json;');    //because we are sending json
                echo json_encode($returningMsg);
                exit();
                //echo "ending is within or same. starting is outside"."<br>";
            }
            else if((strtotime($startingTime) >= strtotime($reservation -> startingTime) && strtotime($startingTime) < strtotime($reservation -> endingTime)) && strtotime($endingTime) > strtotime($reservation -> endingTime)){   //starting time is within an already reserved slot
                $returningMsg['errMsg'] = "Entered Time Period is already Reserved";
                header('Content-Type: application/json;');    //because we are sending json
                echo json_encode($returningMsg);
                exit();
                //echo "starting is within or same. ending is outside"."<br>";
            }
            else{
                continue;   //can be reserved
            }
        }
    }

    //now making the reservation
    $result = $reservingUser -> makeReservation($date, $startingTime, $endingTime, $numOfpeople, $payment, $reservingCourt);   //pass the reserving court object to the function
    if($result === TRUE){
        $returningMsg['successMsg'] = "Reservation has been made Successfully";
        echo json_encode($returningMsg);
    }
    else{
        $returningMsg['errMsg'] = "Reservation has not been made";
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