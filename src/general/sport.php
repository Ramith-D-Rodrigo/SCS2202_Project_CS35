<?php
    class Sport implements JsonSerializable{
        private $sportID;
        private $sportName;
        private $description;
        private $reservationPrice;
        private $minCoachingSessionPrice;
        private $maxNumberOfStudents;

        public function getDetails($database, $wantedProperty = ''){
            $sql = sprintf("SELECT * FROM `sport` 
            WHERE `sport_id`
            LIKE '%s'", $database -> real_escape_string($this -> sportID));
            $result = $database -> query($sql);

            $row = $result -> fetch_object();

            $this -> sportName = $row -> sport_name;
            $this -> description = $row -> description;
            $this -> reservationPrice = $row -> reservation_price;

            $result -> free_result();
            
            if($wantedProperty === 'sportID'){
                return $this -> sportID;
            }
            else if($wantedProperty === 'sportName'){
                return $this -> sportName;
            }
            else if($wantedProperty === 'reservationPrice'){
                return $this -> reservationPrice;
            }
            else{
                return $this;
            }
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

        public function jsonSerialize():mixed{
            return [
                "sportID" => $this -> sportID,
                "sportName" => $this -> sportName,
                "description" => $this -> description,
                "reservationPrice" => $this -> reservationPrice
            ];
            
        }
    }


?>