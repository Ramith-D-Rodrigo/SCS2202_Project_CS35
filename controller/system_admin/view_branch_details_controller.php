<?php
    session_start();

    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $role = $_GET['role'];

    $admin = Admin::getInstance();
    $branchInfo = $admin -> getBranchDetails($role,$connection);
    
    if(count($branchInfo)===0){
        array_push($branchInfo,['errMsg' =>"No available branches which have that role"]);
    }

    header('Content-Type: application/json;');
    echo  json_encode($branchInfo);
    $connection -> close();
    
?>