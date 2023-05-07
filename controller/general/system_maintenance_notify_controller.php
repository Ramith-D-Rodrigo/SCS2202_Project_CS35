<?php
    //this script is used to get the system maintenance info
    require_once("../../src/general/website_functions/system_maintenance_info.php");
    require_once("../../src/general/dbconnection.php");

    $sysMaintenanceInfo = getSysMaintenanceInfo($connection);
    $connection -> close();

    //echo the result as a json
    header('Content-Type: application/json;');
    echo json_encode($sysMaintenanceInfo);
?>