<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/reservation.php");
    require_once("../../src/user/user.php");

    session_start();
    if($_SESSION['userrole'] !== 'user'){   //not a user
        header("Location: /public/general/reservation_schedule.php");
        exit();
    }

    print_r($_POST);

    //store the reservation details

    $court_id = $_POST['makeReserveBtn'];
    $numOfpeople = htmlspecialchars($_POST['numOfPeople'], ENT_QUOTES);
    $startingTime = $_POST['reservingStartTime'];
    $endingTime = $_POST['reservingEndTime'];
    $date = $_POST['reservingDate'];
    $payment = $_POST['reservationPrice'];
    $user = $_SESSION['userid'];

    $reservingUser = new User(); 
    $reservingUser -> setDetails(uid : $user);//create an user with logged in userid
    
    $result = $reservingUser -> makeReservation($date, $startingTime, $endingTime, $numOfpeople, $payment, $court_id, $connection);
    if($result === TRUE){
        $_SESSION['reservationSuccess'] = "Reservation has been made Successfully";
    }
    else{
        $_SESSION['reservationFail'] = "Reservation has not been made";
    }
    header("Location: /controller/general/reservation_schedule_controller.php");
    header("Location: /public/general/reservation_schedule.php");
    unset($reservingUser);
    $connection -> close();
?>