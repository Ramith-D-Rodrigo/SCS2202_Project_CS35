<?php
    session_start();

    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $role = $_GET['role'];
    $branchID = $_GET['branchID'];

    $admin = Admin::getInstance();
    $loginInfo = $admin -> getLoginDetails($role, $branchID, $connection);

    if(count($loginInfo)===0){
        array_push($loginInfo,['errMsg' =>"There is no such role exist in this branch"]);
    }

    header('Content-Type: application/json;');
    echo  json_encode($loginInfo);
    $connection -> close();
?>