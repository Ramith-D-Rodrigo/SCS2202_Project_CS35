<?php
    class Sport implements JsonSerializable{
        private $sportID;
        private $sportName;
        private $description;
        private $reservationPrice;
        private $minCoachingSessionPrice;
        private $maxNoOfStudents;

        public function getDetails($database, $wantedColumns = []){
            $sql = "SELECT ";
            if(empty($wantedColumns)){
                $sql = $sql . "*";
            }
            else{
                foreach($wantedColumns as $column){
                    $sql .= "`$column`,";
                }
                $sql = substr($sql, 0, -1); //remove the last comma
            }
            $sql .= " FROM `sport` ";

            $sql .= sprintf("WHERE `sportID` LIKE '%s'", $database -> real_escape_string($this -> sportID));

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
            unset($row);
            return $this;
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
