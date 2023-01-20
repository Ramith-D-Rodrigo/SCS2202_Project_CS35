<?php
    session_start();
    if((isset($_SESSION['userrole']) && isset($_SESSION['userid']))){  //if the user is logged in
        header("Location: /index.php"); //the user shouldn't be able to access this page
        exit();
    }

    require_once("../../src/general/mailer.php");

    //generate random code
    $code = rand(100000, 999999);
    //store the code in the session
    $_SESSION['code'] = $code;

    //get the username and email from the session
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];

    $status = Mailer::passwordReset($email, $username, $code);
    if($status === false){
        header('Content-Type: application/json;');
        echo json_encode(array("errMsg" => "Unable to send the email. <br>Please try again later"));
        exit();
    }
    echo json_encode(array("successMsg" => "A new code has been sent to your Email Address.<br>Please check your email and enter the code to reset your password"));
    exit();

?>