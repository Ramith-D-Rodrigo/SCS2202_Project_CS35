<?php
    session_start();
    if(isset($_SESSION['userid'])){   //user is logged in
        header("Location: ../../index.php");
    }

    require_once('../../src/user/user.php');
    require_once("../../src/general/mailer.php");

    $userid = $_SESSION['verifyUserID'];
    $mailVerificationCode = $_SESSION['mailVerificationCode'];    //get the verification code from the session

    $requestJSON =  file_get_contents("php://input");   //get the raw json string

    if($requestJSON == '' || $requestJSON === false){ //if the json string is empty
        header("Location: /index.php"); //the user shouldn't be able to access the page
        exit();
    }

    $userInput = json_decode($requestJSON, true);
    $verificationCode = $userInput['verificationCode'];

    if($verificationCode !== $mailVerificationCode){    //if the verification code is incorrect
        require_once('email_verification_controller.php');    //send a new verification code to the user's email
        $returnJSON['errMsg'] = 'Verification code is incorrect, Please enter the new verification code that has been sent to your email';
        echo json_encode($returnJSON);
    }
    else{   //if the verification code is correct
        $verifyingUser = new User();
        $verifyingUser -> setDetails(uid: $_SESSION['verifyUserID']);    //set the user's details
        $result = $verifyingUser -> activateAccount(); //activate the user's account
        if($result === false){  //if the account activation is unsuccessful
            $returnJSON['errMsg'] = 'Account activation failed. Please Try again later by logging in.';
        }
        else{   //if the account activation is successful
            $returnJSON['successMsg'] = 'Account activated successfully';
        }
        unset($verifyingUser);
        echo json_encode($returnJSON);
    }
    
?>