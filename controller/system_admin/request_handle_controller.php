<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $admin = Admin::getInstance();
    
    $branchUnavail = checkDuplicateBranch($_POST[$location],$connection);
    if($branchUnavail){
        $_SESSION['branchExistError'] = "Branch with the Same Location Exists.<br>Option is to Decline the Request";
        header("Location: /public/system_admin/branch_request.php");
        $connection -> close();
        exit();
    }else{
        unset($_SESSION['branchExistError']);
    }

    $location = htmlspecialchars($_POST['location'],ENT_QUOTES);
    $branchID = htmlspecialchars($_POST['branchID'],ENT_QUOTES);
    $decision = htmlspecialchars($_POST['decision'],ENT_QUOTES);

    $result = $admin -> makeBranchActive($decision,$branchID,$connection);
    if($result){
        header("Location: /public/system_admin/view_owner_requests.php");
        $connection -> close();
        exit();
    }


?>