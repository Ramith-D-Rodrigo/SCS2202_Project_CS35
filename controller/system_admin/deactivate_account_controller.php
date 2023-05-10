<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

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
    }else{
        $message = "Error Occured While Deactivating Account.";
        $flag = true;
    }

    header('Content-type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();

?>