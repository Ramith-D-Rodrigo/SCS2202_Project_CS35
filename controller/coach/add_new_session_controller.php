<?php 
    // require_once("../../src/general/uuid.php");
    require_once("../../src/coach/dbconnection.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/general/sport.php");
    
    
    

    session_start();
    // if($_SESSION['userrole'] !== 'coach'){   //not a coach
    //     header("Location: /public/coach/coach_addsession.php");
    //     exit();
    // }

    print_r($_POST);

    //store the session details
   

//    if( isset($branchID) || isset($courtID) || isset($day) || isset($startingTime) || isset($endingTime) || isset($sessionfee) || isset($coach_monthly_payment) ) 
//    {
     $branchID = htmlspecialchars($_POST['branch'], ENT_QUOTES);
     $courtID = htmlspecialchars($_POST['court'], ENT_QUOTES);
     $day = htmlspecialchars($_POST['day'], ENT_QUOTES);
     $startingTime = htmlspecialchars($_POST['StartingTime'], ENT_QUOTES);
     $endingTime = htmlspecialchars($_POST['EndingTime'], ENT_QUOTES);
     $sessionFee = htmlspecialchars($_POST['sessionFee'], ENT_QUOTES);
     $coachMonthlyPayment = htmlspecialchars($_POST['monthlyPayment'], ENT_QUOTES);
     $coachID = htmlspecialchars($_SESSION['userid'], ENT_QUOTES);



    

    // }

      

   
   
   // echo $day;
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

    $coach = new Coach(); 

    //creating new session id
    $prefix1 = substr($_SESSION['userid'], 0, 3);

    $coachSportID = $_SESSION['coachsportid'];
    $sport = new Sport();
    $sport -> setID($coachSportID);
    $sportName = $sport ->getDetails($connection, 'sportName');


    $prefix1 = substr($sportName, 0, 3);
    $prefix2 = substr($_SESSION['username'], 0, 3);
    $sessionID = uniqid($prefix1."-Session-".$prefix2);


    $result = $coach ->addsession($sessionID,$coachMonthlyPayment,$startingTime,$endingTime,"0",$_SESSION['userid'],$courtID,$day,$sessionFee,$connection);
    //echo $startingTime;
    // $result = $addseession -> addsession($day, $startingTime, $endingTime, $payment_amount, $court_id, $coach_monthly_payment, $coach, $connection,);   //pass the reserving court object to the function
    if($result === TRUE){
        $_SESSION['addsessionSuccess'] = "Session has been made Successfully";
    }
    else{
        $_SESSION['addsessionFail'] = "Session has not been made";
    }

    header("Location: /controller/coach/coaching_session_controller.php");
    unset($coach);
    unset($sport);
    $connection -> close();
?>