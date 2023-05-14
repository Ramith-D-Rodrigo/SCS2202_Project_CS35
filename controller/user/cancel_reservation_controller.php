<?php
    //this script is used to cancel a reservation of a user
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck :  TRUE, acceptingUserRoles : ['user'])){
        Security::redirectUserBase();
        die();
    }

    if(!isset($_SESSION['userAuth']) || $_SESSION['userAuth'] !== true){   //if the user is not authenticated
        http_response_code(401);
        echo json_encode(['msg' => 'User is not authenticated']);
        die();
    }

    //server request method check
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405);
        die();
    }

    //now that user is authenticated, we can proceed with the cancellation process
    unset($_SESSION['userAuth']);   //unset the userAuth session variable

    require_once("../../src/user/user.php");
    require_once("../../src/general/reservation.php");
    require_once("../../controller/CONSTANTS.php");
    require_once("../../src/general/paymentGateway.php");

    $cancellingUser = new User();
    $cancellingUser -> setUserID($_SESSION['userid']);
    $selectedReservation = json_decode(file_get_contents("php://input"), true)['reservationID'];

    $cancellingReservation = new Reservation();
    $cancellingReservation -> setID($selectedReservation);

    $cancellingReservation -> getDetails($cancellingUser -> getConnection(), ['chargeID', 'status', 'reservedDate', 'paymentAmount', 'userID', 'notificationID']);

    $reservationDetails = json_decode(json_encode($cancellingReservation), true);

    if($reservationDetails['status'] !== 'Pending'){   //if the reservation is not in pending state
        http_response_code(400);
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode(array('msg' => "Invalid Reservation"));
        die();
    }

    if($reservationDetails['userID'] !== $_SESSION['userid']){   //if the reservation is not made by the requesting user
        http_response_code(400);
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode(array('msg' => "Invalid Reservation"));
        die();
    }

   $result = $cancellingUser -> cancelReservation($cancellingReservation);

   //reservedDate timestamp
    $reservedDate = $reservationDetails['reservedDate'];

    $returnMsg = array();
    $statusCode = null;

    if($result === TRUE){   //if cancelling the reservation is successful
        $statusCode = 200;
        $returnMsg['msg'] = "Reservation Cancelled Successfully";

        //delete reservation notification
        require_once("../../src/general/notification.php");
        
        if(isset($reservationDetails['notificationID'])){
            $notificationID = $reservationDetails['notificationID'];
            $deletingNotification = new Notification($notificationID);
            $deletingNotification -> deleteNotification($cancellingUser -> getConnection());
        }

        //server timezone set
        date_default_timezone_set(SERVER_TIMEZONE);

        //check if the cancellation is within 3 days of the reserved timestamp for refund process
        $reservedDateTimeStamp = new DateTime($reservedDate);
        $dateDiff = $reservedDateTimeStamp -> diff(new DateTime(date('Y-m-d H:i:s')));

        if($dateDiff -> days < MAX_REFUND_DAYS){ //can refund
            $result = paymentGateway::chargeRefund($reservationDetails['chargeID'], $reservationDetails['paymentAmount']);
            if($result[0] === false){
                $returnMsg['msg'] = "Reservation Cancelled Successfully.<br>Refund Failed : " . $result[1];
            }
            else{
                $returnMsg['msg'] = "Reservation Cancelled Successfully.<br>Refund Successful";

                //update the status of the reservation
                $cancellingReservation -> updateStatus($cancellingUser -> getConnection(), 'Refunded');
            }
        }
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