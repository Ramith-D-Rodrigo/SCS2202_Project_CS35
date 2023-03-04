<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    //check server request method
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(405);
        die();
    }

    //check authorization
    if(!isset($_SESSION['userAuth']) || $_SESSION['userAuth'] != true){
        http_response_code(401);
        die();
    }

    //unset the userAuth session variable
    unset($_SESSION['userAuth']);

    //get the user inputs
    $userInputs = json_decode(file_get_contents("php://input"), true);

    //server side validation
    if(!isset($userInputs['name']) || !isset($userInputs['description']) || !isset($userInputs['reservationPrice']) || !isset($userInputs['reReservationPrice'])){
        http_response_code(400);
        die();
    }

    if(strlen($userInputs['name']) > 25 || strlen($userInputs['description']) > 100){
        http_response_code(400);
        die();
    }

    if(!preg_match("/^[A-Z][a-zA-Z ]*$/", $userInputs['name'])){
        http_response_code(400);
        die();
    }

    if($userInputs['reservationPrice'] <= 0 || $userInputs['reservationPrice'] % 10 != 0){
        http_response_code(400);
        die();
    }

    //check reservation price and re-reservation price equality
    if($userInputs['reservationPrice'] != $userInputs['reReservationPrice']){
        http_response_code(400);
        die();
    }

    $maxPlayers = null;

    if(isset($userInputs['maxPlayers'])){   //maxPlayers is optional
        if($userInputs['maxPlayers'] <= 0){ //maxPlayers should be positive
            http_response_code(400);
            die();
        }
        $maxPlayers = $userInputs['maxPlayers'];
    }

    $returnMsg = [];
    require_once("../../src/owner/owner.php");
    $owner = Owner::getInstance();

    $result = $owner -> addNewSport($userInputs['name'], $userInputs['description'], $userInputs['reservationPrice'], $maxPlayers);
        
    if($result){
        http_response_code(200);
        $returnMsg['msg'] = "Sport Added Successfully";
    }
    else{
        http_response_code(500);
        $returnMsg['msg'] = "Error Occured While Adding Sport";
    }

    header("Content-Type: application/json");
    echo json_encode($returnMsg);
    die();
?>

