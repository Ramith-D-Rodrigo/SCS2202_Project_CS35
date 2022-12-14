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

    //store the session details

     $branch_id = $_POST['branch'];
     $court_id = $_POST['Court'];
     $day = $_POST['Day'];
     $startingTime = $_POST['StartingTime'];
     $endingTime = $_POST['EndingTime'];
     $sessionfee = $_POST['session_fee'];
     $coach_monthly_payment = $_POST['monthly_payment'];
     $coach = $_SESSION['coachid'];

    //session availability check

    // $consideringSchedule = $_SESSION['coaching_session_schedule'][$court_id]['schedule'];  //get the schedule of the currently reserving court
    // foreach($consideringSchedule as $coachsession){
    //     //print_r($session);
    //     if($coachsession['date'] === $date){
    //         if(strtotime($startingTime) < strtotime($coachsession['starting_time']) && strtotime($endingTime) > strtotime($coachsession['ending_time'] && )){ //current reserving time slot is over an already reserved time slot
    //             $_SESSION['addsessionFail'] = "Entered Time Period is already Reserved";
    //             echo "Over the top"."<br>";
    //             header("Location: /public/coach/coach_addsession.php");
    //             exit();
    //         }
    //         else if(strtotime($startingTime) >= strtotime($coachsession['starting_time']) && strtotime($endingTime) <= strtotime($coachsession['ending_time'])){    //current reserving time slot is within an already reserved time slot
    //             $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
    //             echo "within or same"."<br>";
    //             header("Location: /public/coach/coach_addsession.php");
    //             exit();
    //         }
    //         else if(strtotime($startingTime) < strtotime($coachsession['starting_time']) && (strtotime($endingTime) <= strtotime($coachsession['ending_time']) && strtotime($endingTime) > strtotime($coachsession['starting_time']))){    //ending time is within an already resevred slot
    //             $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
    //             echo "ending is within or same. starting is outside"."<br>";
    //             header("Location: /public/coach/coach_addsession.php");
    //             exit();
    //         }
    //         else if((strtotime($startingTime) >= strtotime($coachsession['starting_time']) && strtotime($startingTime) < strtotime($coachsession['ending_time'])) && strtotime($endingTime) > strtotime($coachsession['ending_time'])){   //starting time is within an already reserved slot
    //             $_SESSION['reservationFail'] = "Entered Time Period is already Reserved";
    //             echo "starting is within or same. ending is outside"."<br>";
    //             header("Location: /public/coach/coach_addsession.php");
    //             exit();
    //         }
    //         else{
    //             continue;   //can be reserved
    //         }
    //     }
    // }

    $addseession= new Coach(); 

    $reservingSes = new session($court_id);
    
    $result = $addseession -> addsession($day, $startingTime, $endingTime, $payment_amount, $court_id, $coach_monthly_payment, $coach, $connection,);   //pass the reserving court object to the function
    if($result === TRUE){
        $_SESSION['addsessionSuccess'] = "Session has been made Successfully";
    }
    else{
        $_SESSION['addsessionFail'] = "Session has not been made";
    }
    header("Location: /controller/general/reservation_schedule_controller.php");
    unset($reservingUser);
    $connection -> close();
?>