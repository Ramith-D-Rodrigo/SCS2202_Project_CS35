<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $admin = Admin::getInstance();
    $pendingBranches  = $admin->getPendingBranches($connection);

    if(count($pendingBranches)===0){
        array_push($pendingBranches,['errMsg'=>"No Owner Requests to be displayed"]);
    }

    header('Content-type: application/json;');
    echo json_encode($pendingBranches);
    $connection -> close();    
?>