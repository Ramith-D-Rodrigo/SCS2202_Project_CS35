<?php
    session_start();
    require_once("../../src/general/security.php");
    require_once("../../controller/CONSTANTS.php");

    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    //server request method
    if(!$_SERVER['REQUEST_METHOD'] == 'POST'){
        Security::redirectUserBase();
        die();
    }

    $msg = [];
    $msg['msg'] = 'failed';
    
    $requiredFields = ['city', 'address', 'openingTime', 'closingTime', 'sports', 'latitude', 'longitude', 'email', 'openingDate'];

    $sportIDs = []; //array that will store the sportIDs

    $sportsAndCourts = [];   //array that will store the sports that the branch is offering

    //check if all required fields are set and validations
    date_default_timezone_set(SERVER_TIMEZONE);

    $flag = true;

    foreach($requiredFields as $field){
        if(!isset($_POST[$field])){
            $flag = false;
            break;
        }

        if($field == 'city'){
            //regex check
            if(!preg_match('/^[a-zA-Z]+/', $_POST[$field])){
                $flag = false;
                break;
            }

            if(strlen($_POST[$field]) > 50){
                $flag = false;
                break;
            }
        }

        if($field == 'address'){
            if(strlen($_POST[$field]) > 250){
                $flag = false;
                break;
            }
        }


        if($field == 'sports'){ //check if sports is an array
            //check for the number of courts
            //convert the string to an array
            $_POST[$field] = json_decode($_POST[$field], true);
            
            foreach($_POST[$field] as $sport){
                if(!isset($sport['courtCount'])){
                    $msg['msg'] = 'Invalid Court Count';
                    $flag = false;
                    break;
                }

                if($sport['courtCount'] > MAX_COURT_COUNT){    //check if the number of courts is greater than MAX_COURT_COUNT
                    $flag = false;
                    $msg['msg'] = 'Maximum number of courts is '.MAX_COURT_COUNT;
                    break;
                }

                array_push($sportIDs, $sport['sportID']); //push the sportID to the array
                array_push($sportsAndCourts, $sport); //push the sportID to the array
            }
        }

        if($field == 'email'){
            if(!Security::checkEmailAvailability($_POST[$field])){  //invalid email or unavailable email
                $msg['msg'] = 'invalid Email Address';
                $flag = false;
                break;
            }
        }

        if($field == 'latitude' || $field == 'longitude'){
            if(!is_numeric($_POST[$field])){
                $msg['msg'] = 'Invalid Latitude or Longitude';
                $flag = false;
                break;
            }
        }

        //check if opening time is before closing time
        if($field == 'openingTime' || $field == 'closingTime'){
            if(strtotime($_POST['openingTime']) >= strtotime($_POST['closingTime'])){
                $flag = false;
                $msg['msg'] = 'Opening Time must be Before Closing Time';
                break;
            }

            //opening time dateObj

            $openingTime = new DateTime($_POST['openingTime']);
            $closingTime = new DateTime($_POST['closingTime']);

            //check if the times have minutes
            if($openingTime -> format('i') != 0 || $closingTime -> format('i') != 0){
                $flag = false;
                $msg['msg'] = 'Opening Time and Closing Time must be in the form of HH:00';
                break;
            }

            //check if the times have seconds
            if($openingTime -> format('s') != 0 || $closingTime -> format('s') != 0){
                $flag = false;
                $msg['msg'] = 'Opening Time and Closing Time must be in the form of HH:00';
                break;
            }

            //check the time difference
            $timeDifference = $openingTime -> diff($closingTime);
            if($timeDifference -> format('%h') <= MAX_RESERVATION_TIME_HOURS){
                $flag = false;
                $msg['msg'] = 'The time difference between Opening Time and Closing Time must be greater than ' . MAX_RESERVATION_TIME_HOURS . ' hours';
                break;
            }

            //check if the opening date is a valid date
            if(!strtotime($_POST['openingDate'])){
                $flag = false;
                $msg['msg'] = 'Invalid Opening Date';
                break;
            }
        }
    }

    //check sport array for duplicates
    if(count($sportIDs) != count(array_unique($sportIDs))){
        $flag = false;
        $msg['msg'] = 'Duplicate Sports';
    }

    if(!$flag){
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($msg);
        die();
    }

    $sportObjects = []; //array that will store the sport objects

    require_once('../../src/owner/owner.php');
    require_once('../../src/general/sport.php');


    $owner = Owner::getInstance();  //get the owner instance

    $owner -> setUserID($_SESSION['userid']);  //set the owner's userID

    $status = $owner -> requestToAddBranch($_POST['city'], 
        $_POST['address'], 
        $_POST['openingTime'], 
        $_POST['closingTime'], 
        $_POST['email'],
        $sportsAndCourts, 
        $_POST['latitude'], 
        $_POST['longitude'],
        $_POST['openingDate']);

    
    if($status){
        http_response_code(200);
        $msg['msg'] = 'Branch Request Sent Successfully';

    }
    else{
        http_response_code(500);
        $msg['msg'] = 'Branch Request Failed';
    }

    header('Content-Type: application/json');
    echo json_encode($msg);
    die();
?>