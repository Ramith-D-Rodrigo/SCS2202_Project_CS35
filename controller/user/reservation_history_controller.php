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
    
    $user = new User();
    $user -> setDetails(uid: $_SESSION['userid']);
    $reservationHistory = $user -> getReservationHistory();
    

    unset($user);
    header('Content-Type: application/json;');    //because we are sending json
    echo json_encode($reservationHistory);
?>