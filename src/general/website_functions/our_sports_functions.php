<?php

    function getAllSports($database){
        $sql = sprintf("SELECT * FROM `sport`");
        $result = $database -> query($sql);
        $sports = [];
        while($row = $result -> fetch_object()){
            array_push($sports, $row);
            unset($row);
        }
        $result -> free_result();
        return $sports;
    }

    function branchesWithThatSport($sportID, $database){
        $sql = sprintf("SELECT DISTINCT `sc`.`branch_id` AS `branch_id`,
        `b`.`city` AS `branch_name`
        FROM `sports_court` `sc`
        INNER JOIN `branch` `b`
        ON `sc`.`branch_id` = `b`.`branch_id`
        WHERE `sc`.`sport_id` 
        LIKE '%s' 
        AND 
        `sc`.`request_status` ='a'", $database -> real_escape_string($sportID));   //requested status a means accepted

        $result = $database -> query($sql);

        $branches = [];

        while($row = $result -> fetch_object()){
            array_push($branches, $row);
            unset($row);
        }
        
        $result -> free_result();
        return $branches;
    }

?>