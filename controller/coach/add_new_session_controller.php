<?php 
    session_start();

    require_once("../../src/general/security.php"); 

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['coach'])){
        Security::redirectUserBase();
        die();
    }
    // require_once("../../src/general/uuid.php");
     require_once("../../src/coach/dbconnection.php");
     require_once("../../src/coach/coach.php");
     require_once("../../src/general/sport.php");
   

     $branchID = htmlspecialchars($_POST['branch'], ENT_QUOTES);
     $courtID = htmlspecialchars($_POST['court'], ENT_QUOTES);
     $day = htmlspecialchars($_POST['day'], ENT_QUOTES);
     $startingTime = htmlspecialchars($_POST['StartingTime'], ENT_QUOTES);
     $endingTime = htmlspecialchars($_POST['EndingTime'], ENT_QUOTES);
     $sessionFee = htmlspecialchars($_POST['sessionFee'], ENT_QUOTES);
     $coachMonthlyPayment = htmlspecialchars($_POST['monthlyPayment'], ENT_QUOTES);
     $coachID = htmlspecialchars($_SESSION['userid'], ENT_QUOTES);



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