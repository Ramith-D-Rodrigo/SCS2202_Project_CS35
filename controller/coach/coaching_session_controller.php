<?php
    session_start();
    if(!(isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is not logged in
        header("Location: /index.php");
        exit();
    }

    if($_SESSION['userrole'] !== 'coach'){   //not an user (might be another actor)
        header("Location: /index.php");
        exit();
    }
    require_once("../../src/coach/coach.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/uuid.php");

    $user = new Coach();
    $user -> setDetails(uid: $_SESSION['userid']);
    $sessionDetails = $user -> getSessionDetail($connection);

    $sessions = [];

    while($row = $sessionDetails -> fetch_object()){
        $row -> session_id =bin_to_uuid($row ->session_id,$connection);

        array_push($sessions,$row);
       
    }
    // print_r($sessions);
    $_SESSION['sessionDetails'] =  $sessions;

    header("Location: /public/coach/coach_session.php");
    

    ?>