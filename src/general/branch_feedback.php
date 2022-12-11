<?php
    class Branch_Feedback implements JsonSerializable{
        private $userfeedback_id;
        private $user_id;
        private $date;
        private $rating;
        private $description;
        private $branch_id;

        public function setDetails($userfeedback_id = '', $user_id = '', $date = '', $rating = '', $description = '', $branch_id = ''){
            $this -> userfeedback_id = $userfeedback_id;
            $this -> user_id = $user_id;
            $this -> date = $date;
            $this -> rating = $rating;
            $this -> description = $description;
            $this -> branch_id = $branch_id;
        }

        public function getDetails($database, $wantedProperty = ''){
            if($wantedProperty === 'userfeedback_id'){
                return $this -> userfeedback_id;
            }
            else if($wantedProperty === ''){
                $sql = sprintf("SELECT * FROM `user_branch_feedback` WHERE `userfeedback_id`  = '%s'",
                $database -> real_escape_string($this -> userfeedback_id));
    
                $sql = $database -> query($sql);
    
                $row = $sql -> fetch_object();
    
                $this -> setDetails(userfeedback_id : $row -> userfeedback_id, 
                user_id: $row -> user_id, 
                date: $row -> date, 
                rating: $row -> rating, 
                description: $row -> description, 
                branch_id: $row -> branch_id);
                return $this;
            }
            else{   //any other property (single)
                $sql = sprintf("SELECT `%s` as `wanted_property` FROM `user_branch_feedback` WHERE `userfeedback_id`  = '%s'",
                $database -> real_escape_string($wantedProperty),
                $database -> real_escape_string($this -> userfeedback_id));
    
                $result = $database -> query($sql);
    
                $row = $result -> fetch_object();
                $wantedInfo = $row -> wanted_property;
                unset($row);
                $result -> free_result();
                return $wantedInfo;
            }

        }

        public function jsonSerialize(){
            return [
                "feedbackID" => $this -> userfeedback_id,
                "date" => $this -> date,
                "rating" => $this -> rating,
                "description" => $this -> description,
                "branch" => $this -> branch_id
            ];
        }
    }
?>