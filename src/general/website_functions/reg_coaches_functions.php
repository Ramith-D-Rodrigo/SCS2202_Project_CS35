<?php

    function getAllCoaches($database){  //a function to ids of the all coaches
        $sql = sprintf("SELECT `coachID`, `sport` FROM `coach`");

        $result = $database -> query($sql);

        $coaches = [];
        while($row = $result -> fetch_object()){
            array_push($coaches, $row);
            unset($row);
        }

        $result -> free_result();
        return $coaches;
    }


?>