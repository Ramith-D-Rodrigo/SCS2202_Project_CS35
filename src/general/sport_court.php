<?php
    require_once("reservation.php");

    class Sports_Court implements JsonSerializable{
        private $courtID;
        private $courtName;
        private $revenue;
        private $photo;
        private $branchID;
        private $sportID;
        private $requestStatus;
        private $addedManager;

        public function __construct($court_id){
            $this -> courtID = $court_id;
        }

        public function getID(){
            return $this -> courtID;
        }

        public function setDetails($courtName = '', $branchID = '', $sportID = '', $addedManager = ''){
            $funcArgs = get_defined_vars();
            foreach($funcArgs as $key => $value){
                if($value != '' || $value != NULL){
                    $this -> $key = $value;
                }
            }
        }

        public function createCourtEntry($database){    //to create a new court entry in the database 
            $sql = sprintf("INSERT INTO `sports_court` (`courtID`, `branchID`, `sportID`, `addedManager`, `requestStatus`, `courtName`)
                VALUES ('%s', '%s', '%s', NULLIF('%s', ''), '%s', '%s')",
                $database -> real_escape_string($this -> courtID),
                $database -> real_escape_string($this -> branchID),
                $database -> real_escape_string($this -> sportID),
                $database -> real_escape_string(isset($this -> addedManager) ? $this -> addedManager : ''),
                $database -> real_escape_string('p'),
                $database -> real_escape_string($this -> courtName));

            $result = $database -> query($sql);

            return $result;
        }

        public function getSchedule($database){ //get the reservation schedule of a certain court
            //get user reservations
            $sql = sprintf("SELECT * FROM `reservation` 
            WHERE `sportCourt` 
            LIKE '%s'
            AND `date` >= CURDATE()
            ORDER BY `date`",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $reservations = [];
            while($row = $result -> fetch_object()){
                array_push($reservations, $row);
                unset($row);
            }
            $result -> free_result();

            //get coaching sessions that has students
            $sql = sprintf("SELECT * FROM `coaching_session` 
            WHERE `courtID`
            LIKE '%s'
            AND `noOfStudents`  > 0",
            $database -> real_escape_string($this -> courtID));

            $coachingSessions = [];
            $result = $database -> query($sql);
            while($row = $result -> fetch_object()){
                array_push($coachingSessions, $row);
                unset($row);
            }
            $result -> free_result();

            //get maintenance information
            $sql = sprintf("SELECT * FROM `court_maintenance` 
            WHERE `courtID`
            LIKE '%s'
            AND `decision` = 'a'
            AND (`startingDate` >= CURDATE()
            OR `endingDate` >= CURDATE())",
            $database -> real_escape_string($this -> courtID));

            $maintenance = [];
            $result = $database -> query($sql);
            while($row = $result -> fetch_object()){
                array_push($maintenance, $row);
                unset($row);
            }
            $schedule = [];
            $schedule['reservations'] = $reservations;
            $schedule['coachingSessions'] = $coachingSessions;
            $schedule['maintenance'] = $maintenance;

            unset($reservations);
            unset($coachingSessions);
            unset($maintenance);

            return $schedule;
        }

        public function reservationAvailability($date, $startingTime, $endingTime, $database) : array{
            //first check court maintenance
            $sql = sprintf("SELECT `courtID` FROM `court_maintenance` WHERE
            `courtID` = '%s' AND
            `decision` = 'a' AND
            `startingDate` <= '%s' AND
            `endingDate` >= '%s'",

            $database -> real_escape_string($this -> courtID),
            $database -> real_escape_string($date),
            $database -> real_escape_string($date));

            $result = $database -> query($sql);

            if($result -> num_rows > 0){
                return [false, 'Court is Under Maintenance'];
            }
            
            //second check coaching sessions

            $conditions = sprintf("(('%s' < `startingTime` AND '%s' > `endingTime`) OR 
            ('%s' >= `startingTime` AND '%s'<= `endingTime`) OR
            ('%s' < `startingTime` AND '%s'<= `endingTime` AND '%s' > `startingTime`) OR
            ('%s' >= `startingTime` AND '%s' < `endingTime` AND '%s' > `endingTime`))",
            //1st condition - starting time is before the reservation starting time and ending time is after the reservation ending time
            $database -> real_escape_string($startingTime),
            $database -> real_escape_string($endingTime),

            //2nd condition - reserving time is between the reservation starting time and ending time
            $database -> real_escape_string($startingTime),
            $database -> real_escape_string($endingTime),

            //3rd condition - starting time is before the reservation starting time and ending time is between the reservation starting time and ending time
            $database -> real_escape_string($startingTime),
            $database -> real_escape_string($endingTime),
            $database -> real_escape_string($endingTime),

            //4th condition - starting time is between the reservation starting time and ending time and ending time is after the reservation ending time
            $database -> real_escape_string($startingTime),
            $database -> real_escape_string($startingTime),
            $database -> real_escape_string($endingTime));

            //find the day of the week of the date
            $day = date('l', strtotime($date));

            $sql = sprintf("SELECT `sessionID` FROM `coaching_session` WHERE
            `courtID` = '%s' AND
            `day` = '%s' AND ",           
            $database -> real_escape_string($this -> courtID),
            $database -> real_escape_string($day));

            $sql .= $conditions;

            $result = $database -> query($sql);
            if($result -> num_rows > 0){
                return [false, 'Court is Reserved for Coaching Session During the Given Time Period'];
            }
            
            //third check reservations

            $sql = sprintf("SELECT `reservationID` FROM `reservation` WHERE 
            `sportCourt` = '%s' AND
            `status` = 'Pending' AND
            `date` = '%s' AND " ,
            $database -> real_escape_string($this -> courtID), 
            $database -> real_escape_string($date));

            $sql .= $conditions;
            
            $result = $database -> query($sql);

            if($result -> num_rows > 0){
                return [false, 'Court is Already Reserved During the Given Time Period'];
            }

            return [true, 'Court is Available'];
        }

        public function getName($database){ // Get sports court name
            $sql = sprintf("SELECT `courtName` FROM `sports_court`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            return $result -> fetch_object() -> courtName;
        }

        public function createReservation($user, $date, $starting_time, $ending_time, $payment, $num_of_people, $chargeID, $database){
            $reservation = new Reservation();
            $result = $reservation -> onlineReservation($date, $starting_time, $ending_time, $num_of_people, $payment, $this -> courtID, $user, $chargeID, $database);
            unset($reservation);
            return $result; //an array
        }

        public function createOnsiteReservation($recep, $resID, $date, $starting_time, $ending_time, $payment, $num_of_people, $database){
            $reservation = new Reservation();
            $result = $reservation -> onsiteReservation($resID, $date, $starting_time, $ending_time, $num_of_people, $payment, $this -> courtID, $recep, $database);
            unset($reservation);
            return $result; 
        }
        
        public function getBranch($database){
            $sql = sprintf("SELECT `branchID` FROM `sports_court`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $branch = $result -> fetch_object() -> branchID;
            $result -> free_result();
            return $branch;
        }

        public function getSport($database){
            $sql = sprintf("SELECT `sportID` FROM `sports_court`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $sportID = $result -> fetch_object() -> sportID;

            $this -> sportID = $sportID;

            $newSport = new Sport();
            $newSport -> setID($sportID);
            $result -> free_result();
            return $newSport;
        }

        public function getStatus($database){
            $sql = sprintf("SELECT requestStatus FROM `sports_court` 
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);

            return $result -> fetch_object() -> requestStatus;
        }

        public function getPhotos($database){
            $sql = sprintf("SELECT `courtPhoto` FROM `sports_court_photo`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $photos = [];
            while($row = $result -> fetch_object()){
                array_push($photos, $row -> courtPhoto);
                unset($row);
            }
            $result -> free_result();
            return $photos;
        }

        public function jsonSerialize(): mixed{
            $classProperties = get_object_vars($this);
            $returnJSON = [];

            foreach($classProperties as $key => $value){
                if(isset($value) && $value != ''){
                    $returnJSON[$key] = $value;
                }
            }

            return $returnJSON;
        }
    }
?>