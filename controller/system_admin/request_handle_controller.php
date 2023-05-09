<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $requestJSON = file_get_contents("php://input");
    $decision = json_decode($requestJSON, true);

    $message = null;
    $flag = false;
    $admin = Admin::getInstance();
   
    $location = htmlspecialchars($decision['Location'],ENT_QUOTES);
    $branchID = htmlspecialchars($decision['BranchID'],ENT_QUOTES);
    $decision = htmlspecialchars($decision['Decision'],ENT_QUOTES);

    $branchUnavail = checkDuplicateBranch($location,$connection);
    if($branchUnavail){
        $message = "Branch with the Same Location Exists.<br>Option is to Decline the Request";
        $flag = true;
    }

    
    if(!$flag){
        $result = $admin -> makeBranchActive($decision,$branchID,$connection);
        if($result){
            $message = "Branch Request Decision Added Successfully";
        }else{
            $message = "Error Occured While Adding Branch Request Decision";
            $flag = true;
        }
    }

    header('Content-type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();


?>