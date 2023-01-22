<?php
    class Sport implements JsonSerializable{
        private $sportID;
        private $sportName;
        private $description;
        private $reservationPrice;
        private $minCoachingSessionPrice;
        private $maxNoOfStudents;

        public function getDetails($database, $wantedProperty = ''){
            $sql = sprintf("SELECT * FROM `sport` 
            WHERE `sportID`
            LIKE '%s'", $database -> real_escape_string($this -> sportID));
            $result = $database -> query($sql);

            $row = $result -> fetch_object();

            //using foreach to set the object properties
            foreach($row as $key => $value){
                $this -> $key = $value;
            }

/*             $this -> sportName = $row -> sportName;
            $this -> description = $row -> description;
            $this -> reservationPrice = $row -> reservationPrice;
            $this -> manNoOfStudents = $row -> manNoOfStudents; */

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

        public function getSportID($spName, $database) {
            $sql = sprintf("SELECT `sportID` FROM `sport` 
            WHERE `sportName`
            LIKE '%s'", $database -> real_escape_string($spName));
            $result = $database -> query($sql);
            return $result;
        }

        public function jsonSerialize() : mixed{
            return [
                "sportID" => $this -> sportID,
                "sportName" => $this -> sportName,
                "description" => $this -> description,
                "reservationPrice" => $this -> reservationPrice,
                "maxNoOfStudents" => $this -> maxNoOfStudents
            ];
            
        }
    }


?>