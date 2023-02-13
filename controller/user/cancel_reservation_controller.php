<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'user'){   //not a user (might be another actor)
        header("Location: /index.php");
        exit();
    }

    if(!isset($_SESSION['userAuth']) || $_SESSION['userAuth'] !== true){   //if the user is not authenticated
        header("Location: /index.php");
        exit();
    }

    require_once("../../src/user/user.php");
    require_once("../../src/general/reservation.php");

    $cancellingUser = new User();
    $cancellingUser -> setDetails(uid: $_SESSION['userid']);
    $selectedReservation = json_decode(file_get_contents("php://input"), true)['reservationID'];

    $cancellingReservation = new Reservation();
    $cancellingReservation -> setID($selectedReservation);

    $result = $cancellingUser -> cancelReservation($cancellingReservation);


    $returnMsg = array();
    $statusCode = null;

    if($result === TRUE){
        $statusCode = 200;
        $returnMsg['msg'] = "Reservation Cancelled Successfully";
    }
    else{
        $statusCode = 400;
        $returnMsg['msg'] = "Reservation Cancel Failed";
    }

    unset($cancellingReservation);
    unset($cancellingUser);

    http_response_code($statusCode);
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($returnMsg);

?>