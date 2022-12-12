<?php

    function getAllBranches($database){ //branch id
        $sql = sprintf("SELECT 
        `branch_id`
        FROM `branch` 
        WHERE `request_status` = 'a'");

        $result = $database -> query($sql);
        $branchIDs = [];
        while($row = $result -> fetch_object()){
            array_push($branchIDs, $row -> branch_id);
            unset($row);
        }
        $result -> free_result();
        return $branchIDs;
    }

?>