<?php
    session_start();
    require_once("../../src/general/security.php");
    require_once("../CONSTANTS.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    //server request method
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if($requestMethod != 'POST'){
        http_response_code(400);
        die();
    }

    //check for authorization
    if(!isset($_SESSION['userAuth']) || $_SESSION['userAuth'] != true){
        http_response_code(401);
        die();
    }

    //unset the userAuth session variable
    unset($_SESSION['userAuth']);

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/sport.php");

    $owner  = Owner::getInstance();

    $userInputs = json_decode(file_get_contents("php://input"), true);

    $sportID = $userInputs['sportID'];

    $changingSport = new Sport();
    $changingSport -> setID($sportID);

    $changingColumns = array();
    $retunMsg = array();

    //check for changing values
    if(isset($userInputs['newDescription'])){
        if(strlen($userInputs['newDescription']) > 100){
            http_response_code(400);
            $retunMsg['msg'] = "Description should be less than 100 characters";
            header("Content-Type: application/json");
            echo json_encode($retunMsg);
            die();
        }
       $changingColumns['description'] = $userInputs['newDescription'];

    }

    if(isset($userInputs['newPrice'])){
        if($userInputs['newPrice'] <= 0 || $userInputs['newPrice'] % 10 != 0){
            http_response_code(400);
            $retunMsg['msg'] = "Invalid Reservation Price";
            header("Content-Type: application/json");
            echo json_encode($retunMsg);
            die();
        }
        $changingColumns['reservationPrice'] = $userInputs['newPrice'];

        //calculate the new min coaching session price 
        $changingColumns['minCoachingSessionPrice'] = $userInputs['newPrice'] * MIN_COACHING_SESSION_PERCENTAGE + $userInputs['newPrice'];
    }

    if(isset($userInputs['newMaxPlayers'])){
        if($userInputs['newMaxPlayers'] <= 0){
            http_response_code(400);
            $retunMsg['msg'] = "Invalid Max Players";
            header("Content-Type: application/json");
            echo json_encode($retunMsg);
            die();
        }
        $changingColumns['maxNoOfStudents'] = $userInputs['newMaxPlayers'];
    }


    $status = $owner -> updateSportDetails($changingSport, $changingColumns);

    if($status){
        http_response_code(200);
        $retunMsg['msg'] = "Details updated successfully";
    }
    else{
        http_response_code(500);
        $retunMsg['msg'] = "Failed to update details";
    }

    header("Content-Type: application/json");
    echo json_encode($retunMsg);
    
?>