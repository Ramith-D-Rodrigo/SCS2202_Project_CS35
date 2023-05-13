<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/general/actor.php");

    $requestJSON = file_get_contents("php://input");
    $profile = json_decode($requestJSON, true);

    $profileID = htmlspecialchars($profile['ProfileID'],ENT_QUOTES);
    $staffRole = htmlspecialchars($profile['StaffRole'],ENT_QUOTES);
    $branchName = htmlspecialchars($profile['BranchName'],ENT_QUOTES);

    $message = null;
    $flag = false;

    $admin = Admin::getInstance();
    $branchID = $admin -> getBranchID($branchName,$connection);

    $deactivateResult = $admin -> deactivateAccount($branchID, $staffRole, $profileID, $connection);
    
    if($deactivateResult){
        $message = "Account Deactivated Successfully.";

        //send a mail regarding the account deactivation
        $actor = new Actor();
        $actor -> setUserID($profileID);

        require_once("../../src/general/mailer.php");
        Mailer::deactivateStaffAccountNotification($actor -> getEmailAddress(),$actor -> getUsername());
    }else{
        $message = "Error Occured While Deactivating Account.";
        $flag = true;
    }

    header('Content-type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();

?>