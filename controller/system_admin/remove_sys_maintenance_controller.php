<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");

    $admin = Admin::getInstance();
    $admin ->setDetails($connection);
    $result = $admin -> removeSystemMaintenance($connection);

    if($result){
        $_SESSION['removeSuccess'] = "System Maintenance Removed Successfully";
        header("Location: /public/system_admin/remove_system_maintenance.php");
        $connection -> close();
        exit();
    }
    
?>