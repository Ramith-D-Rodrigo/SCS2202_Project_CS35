<?php

    session_start();
    require_once("../../src/general/security.php");

    //checking user authentication
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['user'])){  //not authenticated
        Security::redirectUserBase();
        die();
    }

    //check the server request
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){  //if the request is not a POST request
        Security::redirectUserBase();
        die();
    }

    //get the user request data
    $requestJSON = json_decode(file_get_contents('php://input'), true);

    if(!isset($requestJSON['password']) || !isset($requestJSON['confirmPassword'])){  //if the request data is not set
        http_response_code(400);
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "Invalid Request"));
        die();
    }

    $password = $requestJSON['password'];
    $confirmPassword = $requestJSON['confirmPassword'];

    if($password !== $confirmPassword){  //if the password and the confirm password are not the same
        http_response_code(401);    //unauthorized
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "The passwords do not match"));
        die();
    }

    require_once("../../src/user/user.php");
    $deactivatingUser = new User();
    $deactivatingUser -> setUserID($_SESSION['userid']);

    //check the user input password and the user's actual password in the database (actual authentication)
    $authFlag = Security::ActionAuthentication('%', $password, 'user', $_SESSION['userid']);
    if(!$authFlag){ //not authenticated
        http_response_code(401);    //unauthorized
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "Invalid Password"));
        die();
    }
    //the user is authenticated

    //check for ongoing reservations of the user
    $userReservations = $deactivatingUser -> getReservationHistory();

    if($userReservations !== []){ //if the user has ongoing reservations
        foreach($userReservations as $reservation){
            $reservation -> getDetails($deactivatingUser -> getConnection(), ['status']);
            $status = json_decode(json_encode($reservation), true)['status'];
            if($status === 'Pending'){   //the reservation is pending (an ongoing reservation)
                http_response_code(401);
                header('Content-Type: application/json;');
                echo json_encode(array("msg" => "You have an ongoing reservation.<br> Please Complete or Cancel the reservation before deactivating your account"));
                die();
            }
        }
    }

    //check for ongoing coaching sessions of the user
    if($deactivatingUser -> isStudent()){
        $coachingSessions = $deactivatingUser -> getOngoingCoachingSessions();
        if($coachingSessions !== []){    //if the user has ongoing coaching sessions
            unset($coachingSessions);
            http_response_code(401);
            header('Content-Type: application/json;');
            echo json_encode(array("msg" => "You have ongoing coaching sessions.<br> Please Leave the coaching sessions before deactivating your account"));
            die();
        }
    }

    //random code generation for email pin verification
    $code = rand(100000, 999999);

    $_SESSION['verificationCode'] = $code;
    
    require_once("../../src/general/mailer.php");

    $email = $deactivatingUser->getEmailAddress();
    $username = $deactivatingUser->getUsername();

    $status = Mailer::deactivateAccount($email, $username, $code);
    if($status){
        http_response_code(200);
        header('Content-Type: application/json;');
        echo json_encode(array("msg" => "A verification code has been sent to your email address"));
        die();
    }

    http_response_code(500); //500 - internal server error
    header('Content-Type: application/json;');
    echo json_encode(array("msg" => "An error occurred while sending the verification code"));

?>