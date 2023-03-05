<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $unavailable = checkSystemMaintenance($connection);  //check for ongoing system maintenance
    if($unavailable){
        $_SESSION['maintenanceErr'] = "There is an already existing System Maintenance Notification";
        header("Location: /public/system_admin/add_system_maintenance.php");
        $connection -> close();
        exit();
    }else{

        $startDate = htmlspecialchars($_POST['startingDate'],ENT_QUOTES);
        $startTime = htmlspecialchars($_POST['startingTime'],ENT_QUOTES);
        $downHrs = htmlspecialchars($_POST['Hrs'],ENT_QUOTES);
        $downMins = htmlspecialchars($_POST['Mins'],ENT_QUOTES);

        $admin = Admin::getInstance();
        $admin -> setDetails($connection);
        $result = $admin -> addSystemMaintenance($startDate,$downHrs,$downMins,$startTime,$connection);
        
        if($result){
            $_SESSION['successMsg'] = "System Maintenance Notification Added Successfully";
            header("Location: /public/system_admin/add_system_maintenance.php");
            $connection -> close();
            exit();
        }
    }

?>