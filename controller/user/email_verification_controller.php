<?php
    //generate  verification code
    $mailPrefix1 = uniqid();    //generate unique id
    $mailPrefix2 = uniqid();    //generate unique id
    $mailVerificationCode = substr($mailPrefix1, 3, 4) . substr($mailPrefix2, 8, 4);    //concat the two unique ids' substrings to get the verification code

    $_SESSION['mailVerificationCode'] = $mailVerificationCode;    //store the verification code in the session
    $_SESSION['verifyUserID'] = $userid;  //store the userid in the session (userid value is set from includes)

    $emailResult = Mailer::registerAccount($email, $fName . ' ' . $lName, $mailVerificationCode);    //send the email

?>