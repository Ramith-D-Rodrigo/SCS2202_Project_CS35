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
    
    $user = new User();
    $user -> setDetails(uid: $_SESSION['userid']);
    $reservationHistory = $user -> getReservationHistory($connection);
    while($row = $reservationHistory -> fetch_object()){
        print_r($row);
    }
    unset($user);
    $connection -> close();

?>