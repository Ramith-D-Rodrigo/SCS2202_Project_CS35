<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staff.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $requestJSON = file_get_contents("php://input");
    $branchDetails = json_decode($requestJSON, true);

    $newEmail = htmlspecialchars($branchDetails['Email'], ENT_QUOTES);
    $newContactN = htmlspecialchars($branchDetails['Number'], ENT_QUOTES);
    $newPhotos = $branchDetails['Images'];
    // $newEmail = $_POST['newEmail'];
    // $newContactN = $_POST['newContactN'];

    // print_r($newEmail);
    // print_r($newContactN);
    // print_r($newPhotos);
    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMember($_SESSION['userrole']);

    $flag = false;
    $msg;

    if($newEmail ==='' && $newContactN !== ''){   //only the number is not empty
        $hasContactNumber = checkContactNumber($newContactN,$connection);
        if($hasContactNumber){    //contact number already exists
            $flag = true;
            $msg =  "Contact Number already exists.";   //send the err msg as the message
        }
        else{
            $msg = $receptionist -> updateContactNumber($_SESSION['userid'],$newContactN,$connection);
        }
    }elseif($newEmail!=='' && $newContactN === ''){  //only the email input is not empty
        $hasEmailAddress1 = checkStaffEmail($newEmail,$connection);
        $hasEmailAddress2 = checkBranchEmail($newEmail,$connection);

        if($hasEmailAddress1 || $hasEmailAddress2){    //email address already exists
            $msg .= "\nEmail Address already exists.";
            $flag = true;
        }
        else{
            $msg = $receptionist -> updateBranchEmail($_SESSION['branchID'],$newEmail,$connection);
        }
    }elseif($newEmail!=='' && $newContactN !== ''){   //both email and number are not empty
        $flag2 = false;
        $hasContactNumber = checkContactNumber($newContactN,$connection);

        if($hasContactNumber){    //contact number already exists
            $flag2 = true;
            $msg .=  "\nContact Number already exists.";
        }

        $hasEmailAddress1 = checkStaffEmail($newEmail,$connection);
        $hasEmailAddress2 = checkBranchEmail($newEmail,$connection);

        if($hasEmailAddress1 || $hasEmailAddress2){    //email address already exists
            $flag2 = true;
            $msg.= "\n Email Address already exists.";
        }
        if(!$flag2){
            $msg = $receptionist -> updateBranch($_SESSION['userid'],$_SESSION['branchID'],$newEmail,$newContactN,$connection);
        }
    }

    if(!$flag){     //can continue to update photos
        if(count($newPhotos) !== 0){
            $flag3 = false;
            for($i=0;$i<count($newPhotos);$i++){
                $hasBranchPhoto = checkBranchPhotos($connection,$_SESSION['branchID'],$newPhotos[$i]);
                if($hasBranchPhoto){
                    $flag = true;
                    $flag3 = true;
                    $msg .= "\nPhoto already exists.";
                }
            }
            if(!$flag3){
                $msg = $receptionist -> updateBranchPhotos($_SESSION['branchID'],$newPhotos,$connection);
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array("Flag"=>$flag,"Message"=>$msg));  //send the result as the message
        die();
    }else{
        header('Content-Type: application/json');
        echo json_encode(array("Flag"=>$flag,"Message"=>$msg));  //send the result as the message
        die();
    } 
    
?>