<?php
    //start the session if is not started
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    require_once("../../src/general/mailer.php");
    //generate  verification code
    $mailPrefix1 = uniqid();    //generate unique id
    $mailPrefix2 = uniqid();    //generate unique id
    $mailVerificationCode = substr($mailPrefix1, 3, 4) . substr($mailPrefix2, 8, 4);    //concat the two unique ids' substrings to get the verification code

    $_SESSION['mailVerificationCode'] = $mailVerificationCode;    //store the verification code in the session
    $_SESSION['verifyUserID'] = $userid;  //store the userid in the session (userid value is set from includes)
    $_SESSION['fName'] = $fName;    //store the user's first name in the session
    $_SESSION['lName'] = $lName;    //store the user's last name in the session
    $_SESSION['email'] = $email;    //store the user's email in the session

    $emailResult = Mailer::registerAccount($email, $fName . ' ' . $lName, $mailVerificationCode);    //send the email

?>