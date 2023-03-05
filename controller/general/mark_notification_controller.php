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

    $markingNotificationID = json_decode(file_get_contents("php://input"), true)['notificationID'];


    
    //first get the actor notifications to check for valid notificationID

    $notifications = $actor -> getNotifications();

    $flag = false;

    $markingNotifcation = null;
    foreach($notifications as $notification){
        if($notification -> getID() === $markingNotificationID){    //found the notification

            //check for status of the notification
            $notification -> getDetails($actor -> getConnection(), ['status']);
            $status = json_decode(json_encode($notification), true)['status'];

            if($status === 'Pending'){  //status is pending, so can mark as read
                $flag = true;
                $markingNotifcation = $notification;
                break;
            }
            else{
                $flag = false;
                break;
            }
        }
    }


    if(!$flag){ //notificationID is not valid or status is not pending
        http_response_code(400);
        die();
    }

    //found the notification and status is pending, so can mark as read
    $result = $actor -> readNotification($markingNotifcation);
    
    if($result === FALSE){
        http_response_code(500);
        die();
    }
    else{
        http_response_code(200);
        header("Content-Type: application/json");
        echo json_encode("Notification Marked as Read");
    }

?>