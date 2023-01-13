<?php

    class Coaching_Session implements JsonSerializable{
        private $sessionID;
        private $coachID;
        private $courtID;
        private $coachMonthlyPayment;
        private $timePeriod;
        private $noOfStudents;
        private $day;
        private $startingTime;
        private $endingTime;
        private $paymentAmount;
        private $branchName;
        private $courtName;

        public function __construct($sessionID, $coachID = NULL, $courtID = NULL){
            $this -> sessionID = $sessionID;
            $this -> coachID = $coachID;
            $this -> courtID = $courtID;
            $sessionFeedback = array();
        }

        public function getDetails($database, $wantedProperty = ''){
            $sql = sprintf("SELECT `cs`.*, `b`.`city`, `c`.`court_name` FROM coaching_session cs 
            INNER JOIN sports_court c ON  `c`.`court_id` = `cs`.`court_id`
            INNER JOIN branch b ON `c`.`branch_id` = `b`.`branch_id`

            WHERE session_id = '%s'",
            $database -> real_escape_string($this -> sessionID));

            $result = $database -> query($sql);

            $obj = $result -> fetch_object();
            $this -> coachID = $obj -> coach_id;
            $this -> courtID = $obj -> court_id;
            $this -> coachMonthlyPayment = $obj -> coach_monthly_payment;
            $this -> timePeriod = $obj -> time_period;
            $this -> noOfStudents = $obj -> no_of_students;
            $this -> day = $obj -> day;
            $this -> startingTime = $obj -> starting_time;
            $this -> endingTime = $obj -> ending_time;
            $this -> paymentAmount = $obj -> payment_amount;
            $this -> courtName = $obj -> court_name;
            $this -> branchName = $obj -> city;

            unset($obj);
            $result -> free_result();
            
            return $this;
        }
        
        public function jsonSerialize() : mixed{
            return [
                "sessionID" => $this -> sessionID,
                "coachID" => $this -> coachID,
                "courtID" => $this -> courtID,
                "coachMonthlyPayment" => $this -> coachMonthlyPayment,
                "timePeriod" => $this -> timePeriod,
                "noOfStudents" => $this -> noOfStudents,
                "day" => $this -> day,
                "startingTime" => $this -> startingTime,
                "endingTime" => $this -> endingTime,
                "paymentAmount" => $this -> paymentAmount,
                "courtName" => $this -> courtName,
                "branchName" => $this -> branchName,
            ];
        }
    }


?>