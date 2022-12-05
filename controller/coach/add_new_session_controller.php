<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/coach/coach.php");
    

    session_start();
    if($_SESSION['userrole'] !== 'coach'){   //not a coach
        header("Location: /public/coach/coach_addsession.php");
        exit();
    }

    //print_r($_POST);

    //store the reservation details

    // $court_id = $_POST['makeReserveBtn'];
    // $numOfpeople = htmlspecialchars($_POST['numOfPeople'], ENT_QUOTES);
    // $startingTime = $_POST['reservingStartTime'];
    // $endingTime = $_POST['reservingEndTime'];
    // $date = $_POST['reservingDate'];
    // $payment = $_POST['reservationPrice'];
    // $user = $_SESSION['userid'];

    //reservation availability check

    $consideringSchedule = $_SESSION['coaching_session_schedule'][$court_id]['schedule'];  //get the schedule of the currently reserving court
    foreach($consideringSchedule as $coachsession){
        //print_r($reservation);
        if($coachsession['date'] === $date){
            if(strtotime($startingTime) < strtotime($coachsession['starting_time']) && strtotime($endingTime) > strtotime($coachsession['ending_time'] && )){ //current reserving time slot is over an already reserved time slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                echo "Over the top"."<br>";
                header("Location: /public/coach/coach_addsession.php");
                exit();
            }
            else if(strtotime($startingTime) >= strtotime($coachsession['starting_time']) && strtotime($endingTime) <= strtotime($coachsession['ending_time'])){    //current reserving time slot is within an already reserved time slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                echo "within or same"."<br>";
                header("Location: /public/coach/coach_addsession.php");
                exit();
            }
            else if(strtotime($startingTime) < strtotime($coachsession['starting_time']) && (strtotime($endingTime) <= strtotime($coachsession['ending_time']) && strtotime($endingTime) > strtotime($coachsession['starting_time']))){    //ending time is within an already resevred slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                echo "ending is within or same. starting is outside"."<br>";
                header("Location: /public/coach/coach_addsession.php");
                exit();
            }
            else if((strtotime($startingTime) >= strtotime($coachsession['starting_time']) && strtotime($startingTime) < strtotime($coachsession['ending_time'])) && strtotime($endingTime) > strtotime($coachsession['ending_time'])){   //starting time is within an already reserved slot
                $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
                echo "starting is within or same. ending is outside"."<br>";
                header("Location: /public/coach/coach_addsession.php");
                exit();
            }
            else{
                continue;   //can be reserved
            }
        }
    }

    $reservingUser = new User(); 
    $reservingUser -> setDetails(uid : $user);//create an user with logged in userid

    $reservingCourt = new Sports_Court($court_id);
    
    $result = $reservingUser -> makeReservation($date, $startingTime, $endingTime, $numOfpeople, $payment, $reservingCourt, $connection);   //pass the reserving court object to the function
    if($result === TRUE){
        $_SESSION['reservationSuccess'] = "Reservation has been made Successfully";
    }
    else{
        $_SESSION['reservationFail'] = "Reservation has not been made";
    }
    header("Location: /controller/general/reservation_schedule_controller.php");
    unset($reservingUser);
    $connection -> close();
?>