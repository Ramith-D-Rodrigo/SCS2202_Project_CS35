<?php
    class Sport{
        private $sportID;
        private $sportName;
        private $description;
        private $reservationPrice;
        private $minCoachingSessionPrice;
        private $maxNumberOfStudents;

        function getDetails($database){
            $sql = sprintf("SELECT * FROM `sport` 
            WHERE `sport_id`
            LIKE `'%s'", $database -> real_escape_string(uuid_to_bin($this -> sportID, $database)));
            $result = $database -> query($sql);
            return $result;
        }
    }


?>