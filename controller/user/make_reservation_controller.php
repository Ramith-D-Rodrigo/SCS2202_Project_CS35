<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/reservation.php");
    require_once("../../src/user/user.php");
    require_once("../../src/general/sport_court.php");

    session_start();
    if($_SESSION['userrole'] !== 'user'){   //not a user
        header("Location: /index.php");
        exit();
    }

    $previousPage = $_SESSION['prevPage'];
    //print_r($_POST);

    //store the reservation details

    $court_id = $_POST['makeReserveBtn'];
    $numOfpeople = htmlspecialchars($_POST['numOfPeople'], ENT_QUOTES);
    $startingTime = $_POST['reservingStartTime'];
    $endingTime = $_POST['reservingEndTime'];
    $date = $_POST['reservingDate'];
    $payment = $_POST['reservationPrice'];
    $user = $_SESSION['userid'];

    //reservation availability check
    $reservingCourt = new Sports_Court($court_id);
    $schedule = $reservingCourt -> getSchedule($connection);

    foreach($schedule as $reservation){
        //print_r($reservation);
        if($reservation -> date === $date){
            if(strtotime($startingTime) < strtotime($reservation -> starting_time) && strtotime($endingTime) > strtotime($reservation -> ending_time)){ //current reserving time slot is over an already reserved time slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "Over the top"."<br>";
                header("Location: {$previousPage}");
                exit();
            }
            else if(strtotime($startingTime) >= strtotime($reservation -> starting_time) && strtotime($endingTime) <= strtotime($reservation -> ending_time)){    //current reserving time slot is within an already reserved time slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "within or same"."<br>";
                header("Location: {$previousPage}");
                exit();
            }
            else if(strtotime($startingTime) < strtotime($reservation -> starting_time) && (strtotime($endingTime) <= strtotime($reservation -> ending_time) && strtotime($endingTime) > strtotime($reservation -> starting_time))){    //ending time is within an already resevred slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "ending is within or same. starting is outside"."<br>";
                header("Location: {$previousPage}");
                exit();
            }
            else if((strtotime($startingTime) >= strtotime($reservation -> starting_time) && strtotime($startingTime) < strtotime($reservation -> ending_time)) && strtotime($endingTime) > strtotime($reservation -> ending_time)){   //starting time is within an already reserved slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                //echo "starting is within or same. ending is outside"."<br>";
                header("Location: {$previousPage}");
                exit();
            }
            else{
                continue;   //can be reserved
            }
        }
    }

    $reservingUser = new User(); 
    $reservingUser -> setDetails(uid : $user);//create an user with logged in userid

    
    $result = $reservingUser -> makeReservation($date, $startingTime, $endingTime, $numOfpeople, $payment, $reservingCourt, $connection);   //pass the reserving court object to the function
    if($result === TRUE){
        $_SESSION['reservationSuccess'] = "Reservation has been made Successfully";
    }
    else{
        $_SESSION['reservationFail'] = "Reservation has not been made";
    }
/*     $branch = $reservingCourt -> getBranch($connection);
    $sport = $reservingCourt -> getBranch */
    header("Location: {$previousPage}");

    unset($reservingCourt);
    unset($reservingUser);

    $connection -> close();
?>