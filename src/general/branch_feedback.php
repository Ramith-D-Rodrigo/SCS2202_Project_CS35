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

        public function getDetails($database, $wantedProperty = ''){
            if($wantedProperty === 'userFeedbackID'){
                return $this -> userFeedbackID;
            }
            else if($wantedProperty === ''){
                $sql = sprintf("SELECT `uf`.*, CONCAT(`u`.`firstName`,' ', `u`.`lastName`) AS fullName FROM `user_branch_feedback` `uf` INNER JOIN user u ON `u`.`userID` = `uf`.`userID` WHERE `userFeedbackID`  = '%s'",
                $database -> real_escape_string($this -> userFeedbackID));

                $sql = $database -> query($sql);

                $row = $sql -> fetch_object();

                $this -> setDetails(userfeedback_id : $row -> userFeedbackID,
                user_id: $row -> userID,
                date: $row -> date,
                rating: $row -> rating,
                description: $row -> description,
                branch_id: $row -> branchID);

                $this -> userFullName = $row -> fullName;
                return $this;
            }
            else{   //any other property (single)
                $sql = sprintf("SELECT `%s` as `wanted_property` FROM `user_branch_feedback` WHERE `userFeedbackID`  = '%s'",
                $database -> real_escape_string($wantedProperty),
                $database -> real_escape_string($this -> userFeedbackID));

                $result = $database -> query($sql);

                $row = $result -> fetch_object();
                $wantedInfo = $row -> wanted_property;
                unset($row);
                $result -> free_result();
                return $wantedInfo;
            }

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
            return [
                "feedbackID" => $this -> userFeedbackID,
                "date" => $this -> date,
                "rating" => $this -> rating,
                "description" => $this -> description,
                "branch" => $this -> branchID,
                "userFullName" => $this -> userFullName
            ];
        }
    }
?>
