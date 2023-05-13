<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");


    $role = $_GET['role'];
    $branchName = $_GET['branchName'];

    $admin = Admin::getInstance();
    $branchID = $admin -> getBranchID($branchName,$connection);
    $accountDetails = $admin -> getAccountDetails($role,$branchID,$connection);

    if(count($accountDetails)===0){
        array_push($accountDetails,['errMsg' =>"Sorry No Record of Such Role in the Particular Branch"]);
    }

    header('Content-Type: application/json;');
    echo  json_encode($accountDetails);
    $connection -> close();

?>