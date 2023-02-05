<?php
    session_start();

    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");


    $role = $_GET['role'];
    $branchID = $_GET['branchID'];

    $admin = Admin::getInstance();
    $accountDetails = $admin -> getAccountDetails($role,$branchID,$connection);

    if(count($accountDetails)===0){
        array_push($accountDetails,['errMsg' =>"Sorry no record of such role in the particular branch"]);
    }

    header('Content-Type: application/json;');
    echo  json_encode($accountDetails);
    $connection -> close();

?>