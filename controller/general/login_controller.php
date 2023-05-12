<?php
    //this script is used to log in to the system
    session_start();
    require_once("../../src/general/security.php");

    if(!Security::userAuthentication(logInCheck : true)){
        Security::redirectUserBase();
        die();
    }

    //server request type check
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/general/actor.php");
    require_once("../../src/user/user.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/owner/owner.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string

    if($requestJSON === '' || $requestJSON === false){ //if the json string is empty
        Security::redirectUserBase();
        die();
    }

    $userInput = json_decode($requestJSON, true);
    $username = $userInput['username'];
    $password = $userInput['password'];

    $loginActor = new Actor();

    $result = $loginActor -> login($username, $password);   //log in to the system

    $returnJSON = [];

    if(count($result) === 1){   //login failure
        $returnJSON['errMsg'] = $result[0];
        if(str_contains($result[0], 'Activate your account using the code that has been sent to your email')){   //user or coach account is not active
            $userRole = $loginActor -> getUserRole();   //get the user role
            $loginUser = null;
            if($userRole === 'user'){   //create the corresponding object
                $loginUser = new User($loginActor);
            }
            else if($userRole === 'coach'){
                $loginUser = new Coach($loginActor);
            }

            $email = $loginActor -> getEmailAddress();  //get the user's email from the actor object

            $mailVerificationCode = rand(100000, 999999);   //generate a random verification code

            $_SESSION['mailVerificationCode'] = $mailVerificationCode;    //store the verification code in the session
            $_SESSION['verifyUserID'] = $loginUser -> getUserID();  //store the userid in the session (userid value is set from includes)
            $_SESSION['username'] = $username;  //store the username in the session
            $_SESSION['email'] = $email;    //store the user's email in the session
            unset($loginUser);
            require_once("../../src/general/mailer.php");
            $emailResult = Mailer::activateAccount($email, $username, $mailVerificationCode);    //send the email

            if($emailResult === false){
                $returnJSON['errMsg'] = "Error Logging in. Please try again later";
            }
        }
    }
    else{   //login success
        //unset the session variables
        session_unset();
        session_destroy();  //for new session

        session_start();    //start a new session

        $returnJSON['successMsg'] = $result[0];
        $userrole = $result[1];
        $_SESSION['userid'] = $loginActor -> getUserID();
        $_SESSION['username'] = $username;  //store the username in the session
        $_SESSION['userrole'] = $userrole;  //store the userrole in the session

        $returnJSON['userrole'] = $userrole; //store the userrole in the json string [for the frontend]
       
        if($userrole === 'user'){  //user login
            $loginUser = new User($loginActor);
            $profilePic = $loginUser -> getProfilePic();

            if($profilePic !== ''){ //user has set an profile pic
                $_SESSION['userProfilePic'] = $profilePic;
            }

            $loginUser -> closeConnection();
            unset($loginUser);
        }
        else if($userrole === 'coach'){  //coach login
            $loginCoach = new Coach($loginActor);
            $profilePic = $loginCoach -> getProfilePic();
            $_SESSION['userProfilePic'] = $profilePic;

            $_SESSION['coachsportid'] = $loginCoach -> getSport();  //store the coach's sport in the session
            $loginCoach -> closeConnection();
            unset($loginCoach);
        }
        else if($userrole === 'manager'){  //manager login
            $loginManager = new Manager($loginActor);
            $result = $loginManager -> getSessionData();
            $_SESSION['city'] = $result[1];
            $_SESSION['branchID'] = $result[0];
            $loginManager -> closeConnection();
            unset($loginManager);
        }
        else if($userrole === 'owner' || $userrole === 'admin'){    //owner login or admin login
            //no need to store any additional data in the session
        }
        else if($userrole === 'receptionist'){ //receptionist login
            $loginRecep = new Receptionist($loginActor);
            $sessionData = $loginRecep -> getSessionData();
            $_SESSION['branchName'] = $sessionData[0];
            $_SESSION['branchID'] = $sessionData[1];
            $loginRecep -> closeConnection();
            unset($loginRecep);
        }
        else{
            unset($returnJSON['userrole']);
            unset($returnJSON['successMsg']);
            $returnJSON['errMsg'] = "Error Logging in. Please try again later";
        }
    }

    $loginActor -> closeConnection();
    unset($loginActor);

    header('Content-Type: application/json');
    echo json_encode($returnJSON);
?>
