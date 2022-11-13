<?php

    function getAllSports($database){
        $sql = sprintf("SELECT * FROM `sport`");   //sport id in binary
        $result = $database -> query($sql);
        return $result;
    }

    function branchesWithThatSport($sportID, $database){
        $sql = sprintf("SELECT DISTINCT BIN_TO_UUID(`branch_id`, 1)
        FROM `sports_court` 
        WHERE `sport_id` 
        LIKE '%s' 
        AND 
        `request_status` ='a'", $database -> real_escape_string($sportID));   //requested status a means accepted

        $result = $database -> query($sql);

        return $result;
    }

?>