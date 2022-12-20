<?php
    session_start();
    if(isset($_SESSION['userid'])){  //if the user is logged in previously (not at the login time)
        header("Location: /index.php"); //the user shouldn't be able to access the login page
        exit();
    }
    require_once("../../src/general/actor.php");
    require_once("../../src/user/user.php");

    $requestJSON =  file_get_contents("php://input");   //get the raw json string
    $userInput = json_decode($requestJSON, true);
    $username = $userInput['username'];
    $password = $userInput['password'];

    $loginActor = new Actor();

    $result = $loginActor -> login($username, $password);   //log in to the system

    $returnJSON = [];

    if(count($result) === 1){   //login failure
        $returnJSON['errMsg'] = $result[0];
    }
    else{   //login success
        $returnJSON['successMsg'] = $result[0];

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
    }
    
    $loginActor -> closeConnection();
    unset($loginActor);

    header('Content-Type: application/json');
    echo json_encode($returnJSON);
?>
