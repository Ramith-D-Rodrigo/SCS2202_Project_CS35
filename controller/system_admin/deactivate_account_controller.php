<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $profileID = htmlspecialchars($_POST['deactivateBtn'],ENT_QUOTES);
    $staffRole = htmlspecialchars($_POST['staffRole'],ENT_QUOTES);
    $branchName = htmlspecialchars($_POST['branchName'],ENT_QUOTES);

    $admin = Admin::getInstance();
    $branchID = $admin -> getBranchID($branchName,$connection);

    $deactivateResult = $admin -> deactivateAccount($branchID, $staffRole, $profileID, $connection);
    
    if($deactivateResult){
        $_SESSION['successMsg'] = "Account Deactivated Successfully.";
        header("Location: /public/system_admin/deactivate_account.php");
        $connection -> close();
        exit();
    }



?>