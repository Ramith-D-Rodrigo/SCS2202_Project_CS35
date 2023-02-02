<?php
    session_start();
    if(isset($_SESSION['userid'])){  //if the user is logged in previously (not at the login time)
        header("Location: /index.php"); //the user shouldn't be able to access the login page
        exit();
    }
    require_once("../../src/general/actor.php");
    require_once("../../src/user/user.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/manager/manager.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string

    if($requestJSON === '' || $requestJSON === false){ //if the json string is empty
        header("Location: /index.php"); //the user shouldn't be able to access the login controller
        exit();
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

        $returnJSON['successMsg'] = $result[0];
        $userrole = $result[1];
        $loginUser = new $userrole($loginActor);
        if($result[1] === 'user'){  //user login
            $loginUser = new User($loginActor);
            $profilePic = $loginUser -> getProfilePic();

            if($profilePic !== ''){ //user has set an profile pic
                $_SESSION['userProfilePic'] = $profilePic;
            }

            $_SESSION['userid'] = $loginUser -> getUserID();
            $loginUser -> closeConnection();
            unset($loginUser);

            $_SESSION['userrole'] = 'user';
            $returnJSON['userrole'] = 'user';
        }
        else if($result[1] === 'coach'){  //coach login
            $loginCoach = new Coach($loginActor);
            $profilePic = $loginCoach -> getProfilePic();

            if($profilePic !== ''){ //coach has set an profile pic
                $_SESSION['userProfilePic'] = $profilePic;
            }

            $_SESSION['userid'] = $loginCoach -> getUserID();
            $_SESSION['coachsportid'] = $loginCoach -> getSport();  //store the coach's sport in the session
            $loginCoach -> closeConnection();
            unset($loginCoach);
            $_SESSION['username'] = $username;  //store the username in the session
            $_SESSION['userrole'] = 'coach';
            $returnJSON['userrole'] = 'coach';
        }
        else if($result[1] === 'admin'){  //admin login

        }
        else if($result[1] === 'manager'){  //manager login
            $loginManager = new Manager($loginActor);
            $result = $loginManager -> login($username, $password);
            $_SESSION['userid'] = $loginManager -> getUserID();
            $_SESSION['city'] = $result[0];
            $_SESSION['branchID'] = $result[1];
            $_SESSION['username'] = $username;  //store the username in the session
            $loginManager -> closeConnection();
            unset($loginManager);
            $_SESSION['userrole'] = 'manager';
            $returnJSON['userrole'] = 'manager';
        }
        else if($result[1] === 'owner'){    //owner login

        }
        else if($result[1] === 'receptionist'){ //receptionist login
            $loginRcep = new Receptionist($loginActor);
            $result = $loginRcep -> login($username, $password);
            $_SESSION['userid'] = $loginRcep -> getUserID();
            $_SESSION['city'] = $result[0];
            $_SESSION['branchID'] = $result[1];
            $_SESSION['username'] = $username;  //store the username in the session
            $loginRcep -> closeConnection();
            unset($loginRcep);
            $_SESSION['userrole'] = 'receptionist';
            $returnJSON['userrole'] = 'receptionist';
        }
        else{
            $returnJSON['errMsg'] = "Error Logging in. Please try again later";
        }
    }
    
    $loginActor -> closeConnection();
    unset($loginActor);

    header('Content-Type: application/json');
    echo json_encode($returnJSON);
?>
