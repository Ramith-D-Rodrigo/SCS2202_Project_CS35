<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $admin = Admin::getInstance();
    $admin ->setDetails($connection);
    $result = $admin -> viewSystemMaintenance($connection);

    if(count($result)===0){
        array_push($result,['errMsg' =>"There is no System Maintenance Notification"]);

    }
    
    header('Content-Type : application/json;');
    echo json_encode($result);
    $connection -> close();

?>