<?php
    class Branch_Feedback implements JsonSerializable{
        private $userFeedbackID;
        private $userID;
        private $date;
        private $rating;
        private $description;
        private $branchID;
        private $userFullName;

        public function setDetails($userfeedback_id = '', $user_id = '', $date = '', $rating = '', $description = '', $branch_id = ''){
            $this -> userFeedbackID = $userfeedback_id;
            $this -> userID = $user_id;
            $this -> date = $date;
            $this -> rating = $rating;
            $this -> description = $description;
            $this -> branchID = $branch_id;
        }

        public function getUserFeedbackID(){
            return $this -> userFeedbackID;
        }

        public function getDetails($database, $wantedColumns = []){
            $sql = "SELECT ";

            if($wantedColumns == []){
                $sql .= sprintf("`uf`.*, CONCAT(`u`.`firstName`,' ', `u`.`lastName`) AS userFullName FROM `user_branch_feedback` `uf` INNER JOIN user u ON `u`.`userID` = `uf`.`userID` WHERE `userFeedbackID`  = '%s'",
                $database -> real_escape_string($this -> userFeedbackID));
            }
            else{
                $sql .= implode(", ", $wantedColumns);
                $sql .= sprintf(" FROM `user_branch_feedback` WHERE `userFeedbackID` = '%s'",
                $database -> real_escape_string($this -> userFeedbackID));
            }

            $result = $database -> query($sql);
            $row = $result -> fetch_object();

            foreach($row as $key => $value){
                $this -> $key = $value;
            }

            $result -> free_result();

            return $this;
        }

        public function addFeedback($database){
            $sql = sprintf("INSERT INTO `user_branch_feedback` 
            (`userFeedbackID`, `userID`, `date`, `rating`, `description`, `branchID`) 
            VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
            $database -> real_escape_string($this -> userFeedbackID),
            $database -> real_escape_string($this -> userID),
            $database -> real_escape_string($this -> date),
            $database -> real_escape_string($this -> rating),
            $database -> real_escape_string($this -> description),
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            return $result;
        }

        public function jsonSerialize() : mixed{
            $classProperties = get_object_vars($this);

            $jsonProperties = [];

            foreach($classProperties as $key => $value){
                if(isset($value) && $value != ''){
                    $jsonProperties[$key] = $value;
                }
            }

            return $jsonProperties;
        }
    }
?>
