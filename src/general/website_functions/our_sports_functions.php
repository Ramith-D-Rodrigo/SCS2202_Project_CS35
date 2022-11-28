<?php

    function getAllSports($database){
        $sql = sprintf("SELECT * FROM `sport`");   //sport id in binary
        $result = $database -> query($sql);
        return $result;
    }

    function branchesWithThatSport($sportID, $database){
        $sql = sprintf("SELECT DISTINCT BIN_TO_UUID(`sc`.`branch_id`, 1) AS `branch_id`,
        `b`.`city` AS `branch_name`
        FROM `sports_court` `sc`
        INNER JOIN `branch` `b`
        ON `sc`.`branch_id` = `b`.`branch_id`
        WHERE `sc`.`sport_id` 
        LIKE '%s' 
        AND 
        `sc`.`request_status` ='a'", $database -> real_escape_string($sportID));   //requested status a means accepted

        $result = $database -> query($sql);

        return $result;
    }

?>