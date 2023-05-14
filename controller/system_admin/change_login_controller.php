<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $requestJSON = file_get_contents("php://input");
    $credentials = json_decode($requestJSON, true);

   $message = null;
   $flag = false;

    $newEmail = null;
    $profileID = null;
    if($credentials['Email'] !== ''){
        $newEmail = htmlspecialchars($credentials['Email'], ENT_QUOTES);
        $emailAvail = null;
        $emailAvailStaff = checkStaffEmail($newEmail, $connection);  //check whether the email is already exists on login table
        $emailAvailBranch = checkBranchEmail($newEmail, $connection);  //check wehter the email is already exists on branch table

        if($emailAvailStaff || $emailAvailBranch){
            $message = "Email Address Already Exists.";
            $flag = true;
        }
    }
    
    $profileID = htmlspecialchars($credentials['Profile'],ENT_QUOTES);
    //check for the email availability
    
    $hashPwd = null;
    if($credentials['Password'] !== ''){
        $hashPwd = password_hash($credentials['Password'], PASSWORD_DEFAULT);  //hash the new password
    }
    
    $admin = Admin::getInstance();
    $updateResult = $admin -> updateStaffLogin($connection,$profileID, $newEmail, $hashPwd);
    
    if(!$flag){
        if($updateResult){
            $message = "Login Details Updated Successfully.";

            $actor = new Actor();
            $actor -> setUserID($profileID);
            //send a mail regarding the change of login details
            require_once("../../src/general/mailer.php");
            Mailer::changeStaffLoginNotification($actor -> getEmailAddress(),$newEmail,$credentials['Password'],$actor -> getUsername());
        }else{
            $message = "Error Occured While Updating Login Details.";
        }
    }

    header('Content-type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();
    

?>