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
    require_once("../../src/general/uuid.php");
    
    $user = new User();
    $user -> setDetails(uid: $_SESSION['userid']);
    $reservationHistory = $user -> getReservationHistory($connection);
    
/*     if(isset($_SESSION['reservationHistory'])){ //previous reservation history clear
        unset($_SESSION['reservationHistory']);
    } */
    $neededInfo = [];

    if(count($reservationHistory) !== 0){  //has reservations
        $reservationJSON = json_encode($reservationHistory);
        $reservationASSOC = json_decode($reservationJSON, true);
        foreach($reservationASSOC as $i){
            //echo($i['user_id']);
            unset($i["user_id"]);
            unset($i['formal_manager_id']);
            unset($i['onsite_receptionist_id']);
            array_push($neededInfo, $i);
        }
        unset($reservationASSOC);
        unset($reservationJSON);
        //$_SESSION['reservationHistory'] = $reservationHistory;
    }
    unset($reservationHistory);


    unset($user);
    //header("Location: /public/user/reservation_history.php");    
    $connection -> close();
    echo json_encode($neededInfo);
?>