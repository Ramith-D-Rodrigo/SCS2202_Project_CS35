<?php
    class Branch_Feedback implements JsonSerializable{
        private $userFeedbackID;
        private $userID;
        private $date;
        private $rating;
        private $description;
        private $branchID;

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
                $sql = sprintf("SELECT * FROM `user_branch_feedback` WHERE `userFeedbackID`  = '%s'",
                $database -> real_escape_string($this -> userFeedbackID));
    
                $sql = $database -> query($sql);
    
                $row = $sql -> fetch_object();
    
                $this -> setDetails(userfeedback_id : $row -> userFeedbackID, 
                user_id: $row -> userID, 
                date: $row -> date, 
                rating: $row -> rating, 
                description: $row -> description, 
                branch_id: $row -> branchID);
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

        public function jsonSerialize() : mixed{
            return [
                "feedbackID" => $this -> userFeedbackID,
                "date" => $this -> date,
                "rating" => $this -> rating,
                "description" => $this -> description,
                "branch" => $this -> branchID
            ];
        }
    }
?>