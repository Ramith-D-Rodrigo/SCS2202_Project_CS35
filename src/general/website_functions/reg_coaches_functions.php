<?php

    function getAllCoaches($database){  //a function to ids of the all coaches
        $sql = sprintf("SELECT `coach_id`, `sport` FROM `coach`");

        $result = $database -> query($sql);

        $coaches = [];
        while($row = $result -> fetch_oject()){
            array_push($coaches, $row);
            unset($row);
        }

        $result -> free_result();
        return $coaches;
    }


?>