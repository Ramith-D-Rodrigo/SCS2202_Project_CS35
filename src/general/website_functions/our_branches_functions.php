<?php

    function getAllBranches($database){ //branch id in binary
        $sql = sprintf("SELECT 
        `branch_id`
        FROM `branch` 
        WHERE `request_status` = 'a'");

        $result = $database -> query($sql);
        return $result;
    }





?>