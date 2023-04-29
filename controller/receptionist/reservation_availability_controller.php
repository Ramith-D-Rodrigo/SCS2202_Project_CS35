<?php
    session_start();
    // require_once("../../src/general/security.php");
    // //check the authentication
    // if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){
    //     Security::redirectUserBase();
    //     die();
    // }

    //post request check
    // if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    //     Security::redirectUserBase();
    //     die();
    // }

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
    require_once("../../src/system_admin/staff.php");
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/branch.php");
    require_once("../CONSTANTS.php");

    
    //store the reservation details

    $court_id = $reservationDetails['makeReserveBtn'];
    $numOfpeople = htmlspecialchars($reservationDetails['numOfPeople'], ENT_QUOTES);
    $startingTime = $reservationDetails['reservingStartTime'];
    $endingTime = $reservationDetails['reservingEndTime'];
    $date = $reservationDetails['reservingDate'];
    $recepID = $_SESSION['userid'];
    
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

    if($today > $reservingDateObj || $dateDifference -> days > MAX_RESERVATION_DAYS){  //reservation date validation
        $validationFlag = true;
    }

    if($validationFlag === true){
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }

    //can continue
    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMemeber('receptionist');   
    $receptionist -> setDetails(uid : $recepID);

    $reservingCourt = new Sports_Court($court_id);
    $reservingSport = $reservingCourt -> getSport($receptionist -> getConnection());

    if($reservingSport === false){   //no sport
        $returningMsg['errMsg'] = "Invalid Inputs";
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($returningMsg);
        exit();
    }
    
    $temp = $reservingSport -> getDetails($receptionist -> getConnection(), ['reservationPrice']);
    $reservationPrice = json_decode(json_encode($temp)) -> reservationPrice; //get the reservation price
    $calculation = ($timeDifference -> h + ($timeDifference -> i/60));  //get hours and minutes and convert minutes to hours to get the period in hours
    $payment = $reservationPrice * $calculation;//calculate the payment

    //check for branch discount
    $branchID = $reservingCourt -> getBranch($receptionist -> getConnection());
    $branch = new Branch($branchID);

    $discountValue = $branch -> getCurrentDiscount($receptionist -> getConnection());

    if($discountValue != null){    //branch has a discount
        $payment = $payment - ($payment * ($discountValue/100));
    }


    //reservation availability check
    $schedule = $reservingCourt -> getSchedule($receptionist -> getConnection());

    //branch maintenance
    $branchMaintenance = $branch -> getBranchMaintenance($receptionist -> getConnection(),['startingDate', 'endingDate'], $date, 'a');

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

    $returningMsg['successMsg'] = "Can make the reservation. <br> 
                                    Will be redirected to the payment receipt interface";
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($returningMsg);
    exit();
?>