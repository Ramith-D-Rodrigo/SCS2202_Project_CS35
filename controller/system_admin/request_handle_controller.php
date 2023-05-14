<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    // echo "hello";
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $requestJSON = file_get_contents("php://input");
    $decision = json_decode($requestJSON, true);

    // print_r($decision);
    // die();
    $message = null;
    $flag = false;
    $admin = Admin::getInstance();
   
    $location = htmlspecialchars($decision['Location'],ENT_QUOTES);
    $branchID = htmlspecialchars($decision['BranchID'],ENT_QUOTES);
    $adminDecision = htmlspecialchars($decision['Decision'],ENT_QUOTES);
    $email = htmlspecialchars($decision['Email'],ENT_QUOTES);

    $branchUnavail = checkDuplicateBranch($location,$connection);
   
    if($branchUnavail){
        $message = "Branch with the Same Location Exists.<br>Option is to Decline the Request";
        $flag = true;
    }
    if(checkBranchEmail($email,$connection) && checkStaffEmail($email,$connection)){
        $message = "Branch with the Same Email Address Exists.<br>Option is to Decline the Request";
        $flag = true;
    }

    
    if(!$flag){
        $result = $admin -> makeBranchActive($adminDecision,$branchID,$connection);
        if($result){
            // echo "wer";
            $message = "Branch Request Decision Added Successfully";

            //sending notification about the decision of a pending branch request
            $notificationID = uniqid('notrequest');
            $desc = "New branch request which is located in " .$location. " has been ".$adminDecision. " by the system administrator";
            $admin -> addNotification($notificationID,"Decision for the Branch Request",$desc,date('Y-m-d'),'owner6409c21e372fa');
        }else{
            $message = "Error Occured While Adding Branch Request Decision";
            $flag = true;
        }
    }

    header('Content-Type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();


?>