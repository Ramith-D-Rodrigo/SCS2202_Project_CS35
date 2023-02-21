<?php
    require_once("../../src/general/sport.php");

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

        public function getSessionID(){
            return $this -> sessionID;
        }

        public function getDetails($database, $wantedColumns = []){
            $sql = "SELECT ";
            if($wantedColumns != []){  //specific columns are wanted
                foreach($wantedColumns as $column){
                    $sql .= "`$column`,";
                }
                //remove the last comma
                $sql = substr($sql, 0, -1);
            }
            else{   //all columns are wanted
                $sql = $sql . "`cs`.*, `b`.`city` as `branchName`, `c`.`courtName`";
            }
            
            $sql .= sprintf(" FROM coaching_session cs
            INNER JOIN sports_court c ON  `c`.`courtID` = `cs`.`courtID`
            INNER JOIN branch b ON `c`.`branchID` = `b`.`branchID`
            WHERE sessionID = '%s'",
            $database -> real_escape_string($this -> sessionID));

/*             $sql = sprintf("SELECT `cs`.*, `b`.`city` as `branchName`, `c`.`courtName` FROM coaching_session cs 
            INNER JOIN sports_court c ON  `c`.`courtID` = `cs`.`courtID`
            INNER JOIN branch b ON `c`.`branchID` = `b`.`branchID`

            WHERE sessionID = '%s'",
            $database -> real_escape_string($this -> sessionID)); */

            $result = $database -> query($sql);

            $obj = $result -> fetch_object();

            //foreach loop to set the object properties
            foreach($obj as $key => $value){
                $this -> $key = $value;
            }

            unset($obj);
            $result -> free_result();
            
            return $this;
        }

        public function getAvailability($database){
            $temp = $this -> getDetails($database, ['noOfStudents', 'coachID']);

            $currNoOfStudents = $temp -> noOfStudents;
            $coachID = $temp -> coachID;

            $sessionCoach = new Coach();    //get the coach of the coaching session
            $sessionCoach -> setUserID($coachID);

            $coachSport = new Sport();  //find the sport of the coach
            $coachSport -> setID($sessionCoach -> getSport($database));
            
            $coachSport -> getDetails($database, ['maxNoOfStudents']);
            $maxNoOfStudents = json_decode(json_encode($coachSport)) -> maxNoOfStudents;

            if($currNoOfStudents < $maxNoOfStudents){
                return true;
            }
            else{
                return false;
            }

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