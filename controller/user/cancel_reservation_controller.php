<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'user'){   //not an user (might be another actor)
        header("Location: /index.php");
        exit();
    }

    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/reservation.php");

    $cancellingUser = new User();
    $cancellingUser -> setDetails(uid: $_SESSION['userid']);
    $selectedReservation = $_POST['cancelBtn'];  //get the cancel button'value which is the reservation id

    $cancellingReservation = new Reservation();
    $cancellingReservation -> setID($selectedReservation);

    $result = $cancellingUser -> cancelReservation($cancellingReservation, $connection);

    if($result === TRUE){
        $_SESSION['reserveCancelSuccess'] = "Reservation Cancelled Successfully";
    }
    else{
        $_SESSION['reserveCancelError'] = "Could Not Cancel the Reservation";
    }

    unset($cancellingReservation);
    unset($cancellingUser);
    $connection -> close();
    header("Location: /public/user/reservation_history.php");

?>