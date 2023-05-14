<?php
    function getSysMaintenanceInfo($database){
        $sql = sprintf("SELECT `expectedDowntime`, `startingTime`, `startingDate` FROM `system_maintenance` WHERE startingDate > CURDATE()");

        $result = $database -> query($sql);
    
        $row = $result -> fetch_object();

        $result -> free_result();
        return $row;
    }
?>