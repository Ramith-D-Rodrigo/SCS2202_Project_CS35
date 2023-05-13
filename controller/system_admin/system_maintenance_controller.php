<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $requestJSON = file_get_contents("php://input");
    $maintenanceDetails = json_decode($requestJSON, true);

    $message = null;
    $flag = false;

    $unavailable = checkSystemMaintenance($connection);  //check for ongoing system maintenance

    if($unavailable){
        $message = "There is an already existing System Maintenance Notification";
        $flag = true;
    }else{

        $startDate = htmlspecialchars($maintenanceDetails['startingDate'],ENT_QUOTES);
        $startTime = htmlspecialchars($maintenanceDetails['startingTime'],ENT_QUOTES);
        $downHrs = htmlspecialchars($maintenanceDetails['hours'],ENT_QUOTES);
        $downMins = htmlspecialchars($maintenanceDetails['minutes'],ENT_QUOTES);

        $admin = Admin::getInstance();
        $admin -> setDetails($connection);
        $result = $admin -> addSystemMaintenance($startDate,$downHrs,$downMins,$startTime,$connection);
        
        if($result){
            $message = "System Maintenance Notification Added Successfully";

            //send the mail regarding the system maintenance
            $duration = $downHrs .":". $downMins;
            $admin -> mailSystemMaintenance($startDate,$startTime,$duration);
        }else{
            $flag = true;
            $message = "Error Occured While Saving System Maintenance Notification";
        }
    }

    header('Content-type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();

?>