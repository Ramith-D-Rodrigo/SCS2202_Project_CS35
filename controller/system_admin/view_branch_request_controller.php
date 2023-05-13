<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $branchID = $_GET['branchID'];
    $admin = Admin::getInstance();
    $pendingBranch = $admin -> getPendingBranchDetails($branchID,$connection);

    if(count($pendingBranch)===0){
        array_push($pendingBranch,['errMsg' =>"Sorry there is an error with the branch ID.Can't retrieve data"]);
    }

    header('Content-Type : application/json;');
    echo json_encode($pendingBranch);
    $connection -> close();
?>