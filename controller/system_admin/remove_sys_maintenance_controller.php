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
    $admin ->setDetails($connection);
    $result = $admin -> removeSystemMaintenance($connection);

    $message = null;
    $flag = false;

    if($result){
        $message = "System Maintenance Removed Successfully";
    }else{
        $flag = true;
        $message = "Error Occured While Removing System Maintenance";
    }

    header('Content-type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();
    
?>