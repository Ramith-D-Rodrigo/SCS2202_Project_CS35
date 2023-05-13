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

            $result -> free_result();
            unset($row);
            return $this;
        }

        public function setDetails($sportName = '', $description = '', $reservationPrice = '', $minCoachingSessionPrice = '', $maxNoOfStudents = ''){
            $args = get_defined_vars();

            foreach($args as $key => $value){
                if($value !== ''){
                    $this -> $key = $value;
                }
            }
        }

        public function createSportEntry($database){
            $sql = sprintf("INSERT INTO `sport` 
                (`sportID`,`sportName`, `description`, `reservationPrice`, `minCoachingSessionPrice`, `maxNoOfStudents`) 
                VALUES ('%s','%s', '%s', '%s', '%s', NULLIF('%s', ''))",
                $database -> real_escape_string($this -> sportID),
                $database -> real_escape_string($this -> sportName),
                $database -> real_escape_string($this -> description),
                $database -> real_escape_string($this -> reservationPrice),
                $database -> real_escape_string($this -> minCoachingSessionPrice),
                $database -> real_escape_string($this -> maxNoOfStudents));

            $result = $database -> query($sql);

            return $result;
        }

        public function setID($id){
            $this -> sportID = $id;
        }

        public function getID(){
            return $this -> sportID;
        }

        public function getSportID($spName, $database) {
            $sql = sprintf("SELECT `sportID` FROM `sport`
            WHERE `sportName`
            LIKE '%s'", $database -> real_escape_string($spName));
            $result = $database -> query($sql);
            return $result;
        }

        public function updateDetails($updatingColumns, $database){
            $sql = "UPDATE `sport` SET ";
            foreach($updatingColumns as $column => $value){
                $sql .= sprintf("`%s` = '%s',", 
                $database -> real_escape_string($column),
                $database -> real_escape_string($value));
            }
            $sql = substr($sql, 0, -1); //remove the last comma
            $sql .= sprintf(" WHERE `sportID` LIKE '%s'", $database -> real_escape_string($this -> sportID));

            $result = $database -> query($sql);

            return $result;
        }

        public function jsonSerialize() : mixed{
            $classProperties = get_object_vars($this);

            $returnJSON = [];

            foreach($classProperties as $key => $value){
                if(isset($value)){
                    $returnJSON[$key] = $value;
                }
            }

            return $returnJSON;
        }
    }


?>
