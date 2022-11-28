<?php
    class Sport{
        private $sportID;
        private $sportName;
        private $description;
        private $reservationPrice;
        private $minCoachingSessionPrice;
        private $maxNumberOfStudents;

        public function getDetails($database){
            $sql = sprintf("SELECT * FROM `sport` 
            WHERE `sport_id`
            LIKE '%s'", $database -> real_escape_string(uuid_to_bin($this -> sportID, $database)));
            $result = $database -> query($sql);
            return $result;
        }

        public function setID($id){
            $this -> sportID = $id;
        }

        public function getSportID($spName,$database) {
            $sql = sprintf("SELECT `sport_id` FROM `sport` 
            WHERE `sport_name`
            LIKE '%s'", $database -> real_escape_string($spName));
            $result = $database -> query($sql);
            return $result;
        }
    }


?>