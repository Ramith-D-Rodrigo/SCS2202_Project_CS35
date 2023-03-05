<?php
    session_start();
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user', 'coach', 'system_admin', 'receptionist', 'owner', 'manager'])){       //not logged in, so no notifications
        http_response_code(401);
        die();
    }

    require_once("../../src/general/notification.php");
    require_once("../../src/general/actor.php");

    $actor = new Actor($_SESSION['userrole']);

    $actor -> setUserID($_SESSION['userid']);
    
    $notifications = $actor -> getNotifications();

    foreach($notifications as $notification){
        $notification -> getDetails($actor -> getConnection(), ['subject', 'status', 'description']);
    }

    header("Content-Type: application/json");
    echo json_encode($notifications);

    $actor -> closeConnection();

?>