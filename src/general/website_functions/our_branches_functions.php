<?php

    function getAllBranches($database){ //branch id
        $sql = sprintf("SELECT 
        `branchID`
        FROM `branch` 
        WHERE `requestStatus` = 'a'");

        $result = $database -> query($sql);
        $branchIDs = [];
        while($row = $result -> fetch_object()){
            array_push($branchIDs, $row -> branchID);
            unset($row);
        }
        $result -> free_result();
        return $branchIDs;
    }

?>