<?php
    require_once("../../src/general/sport.php");
    require_once("../../src/coach/coach.php");

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
        private $startDate;
        private $cancelDate;

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
                    $sql .= "`cs`.`$column`,";
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

        public function getCoach($database) : Coach{    //returns the coach who is conducting the coaching session as a Coach object
            $sql = sprintf("SELECT `coachID` FROM `coaching_session` WHERE `sessionID` = '%s'",
            $database -> real_escape_string($this -> sessionID));

            $result = $database -> query($sql);

            $obj = $result -> fetch_object();

            $coach = new Coach();
            $coach -> setUserID($obj -> coachID);
            $result -> free_result();
            unset($obj);

            return $coach;
        }

        public function getAvailability($database){
            $temp = $this -> getDetails($database, ['noOfStudents', 'coachID']);

            $currNoOfStudents = $temp -> noOfStudents;
            $coachID = $temp -> coachID;

            $sessionCoach = new Coach();    //get the coach of the coaching session
            $sessionCoach -> setUserID($coachID);

            $coachSport = new Sport();  //find the sport of the coach
            $coachSport -> setID($sessionCoach -> getSport());
            
            $coachSport -> getDetails($database, ['maxNoOfStudents']);
            $maxNoOfStudents = json_decode(json_encode($coachSport)) -> maxNoOfStudents;

            if($currNoOfStudents < $maxNoOfStudents){
                return true;
            }
            else{
                return false;
            }

        }

        public function studentPaymentAvailability($database, $studID){ //to check whether a given student has to pay or not

            //first get the join date of the student
            $joinDateSql = sprintf("SELECT `joinDate` FROM `student_coaching_session` WHERE `sessionID` = '%s' AND `studID` = '%s'",
            $database -> real_escape_string($this -> sessionID),
            $database -> real_escape_string($studID));

            $joinDateResult = $database -> query($joinDateSql);
            $joinDateObj = $joinDateResult -> fetch_object();
            $joinDate = $joinDateObj -> joinDate;


            //get student's last payment information for this session
            $paymentSql = sprintf("SELECT `paymentDate` FROM `payment` WHERE `sessionID` = '%s' AND `studID` = '%s' ORDER BY `paymentDate` DESC LIMIT 1",
            $database -> real_escape_string($this -> sessionID),
            $database -> real_escape_string($studID));       

            $paymentResult = $database -> query($paymentSql);
            
            if($paymentResult -> num_rows == 0){ //student has not paid yet (not even once)
                return true;
            }
            else{
                $paymentObj = $paymentResult -> fetch_object();
                $lastPaymentDate = $paymentObj -> paymentDate;

                //get the number of days between the last payment date and the join date
                //get the current date
                date_default_timezone_set(SERVER_TIMEZONE);
                $currDate = new DateTime("now");
                
                $date1 = new DateTime($lastPaymentDate);
                $date2 = new DateTime($joinDate);
                $diff = $date1 -> diff($date2);
                $days = $diff -> days;

                if($days >= 30){    //student has to pay
                    return true;
                }
                else{
                    return false;
                }
            }
        }
        
        public function jsonSerialize() : mixed{
            //get all class properties
            $properties = get_object_vars($this);
            $returnArr = [];

            //only return the properties that are not null
            foreach($properties as $key => $value){
                if($value != NULL){
                    $returnArr[$key] = $value;
                }
            }

            return $returnArr;
        }
    }


?>