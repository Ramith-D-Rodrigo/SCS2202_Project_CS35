<?php
    session_start();

    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");


    $role = $_GET['role'];
    $branchName = $_GET['branchName'];

    $admin = Admin::getInstance();
    $branchID = $admin -> getBranchID($branchName,$connection);
    $accountDetails = $admin -> getAccountDetails($role,$branchID,$connection);

    if(count($accountDetails)===0){
        array_push($accountDetails,['errMsg' =>"Sorry no record of such role in the particular branch"]);
    }

    header('Content-Type: application/json;');
    echo  json_encode($accountDetails);
    $connection -> close();

?>