<?php
    require_once("../../src/manager/manager.php");
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/general/branch_feedback.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../controller/CONSTANTS.php");

    class Branch implements JsonSerializable{
        private $branchID;
        private $city;
        private $address;
        private $branchEmail;
        private $manager;
        private $receptionist;
        private $openingTime;
        private $closingTime;
        private $openingDate;
        private $photos;
        private $currManager;
        private $currReceptionist;
        private $requestStatus;
        private $revenue;
        private $latitude;
        private $longitude;


        public function __construct($branch_id){
            $this -> branchID = $branch_id;
        }

        public function getBranchID(){
            return $this -> branchID;
        }

        public function getDetails($database, $wantedColumns = []){
            $sql = "SELECT ";
            if($wantedColumns === []){
                $sql .= "*";
            }
            else{
                $sql .= implode(", ", $wantedColumns);
            }

            $sql .= sprintf(" FROM `branch`
            WHERE
            `branchID`
            LIKE '%s'",
            $database -> real_escape_string($this -> branchID));

            $result =  $database -> query($sql);

            $row = $result -> fetch_object();
            $result -> free_result();

            foreach($row as $key => $value){
                $this -> $key = $value;
            }
        }

        public function setDetails($city = '', $address = '', $branchEmail = '', $currManager = '', $currReceptionist = '', $openingTime = '', $closingTime = '', $latitude = '', $longitude = '', $openingDate = ''){
            //get argument names and values as an array
            $args = get_defined_vars();

            foreach($args as $key => $value){
                if($value !== ''){
                    $this -> $key = $value;
                }
            }
        }

        public function createBranchEntry($database, $ownerID){

            $sql = sprintf("INSERT INTO `branch` 
                (`branchID`,
                `city`, 
                `address`, 
                `branchEmail`, 
                `openingTime`, 
                `closingTime`, 
                `latitude`, 
                `longitude`, 
                `openingDate`,
                `ownerID`,
                `ownerRequestDate`,
                `requestStatus`)
                VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                $database -> real_escape_string($this -> branchID),
                $database -> real_escape_string($this -> city),
                $database -> real_escape_string($this -> address),
                $database -> real_escape_string($this -> branchEmail),
                $database -> real_escape_string($this -> openingTime),
                $database -> real_escape_string($this -> closingTime),
                $database -> real_escape_string($this -> latitude),
                $database -> real_escape_string($this -> longitude),
                $database -> real_escape_string($this -> openingDate),
                $database -> real_escape_string($ownerID),
                $database -> real_escape_string(date("Y-m-d")),
                $database -> real_escape_string("p"));

            $result = $database -> query($sql);
            if($result){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }

        public function addSportCourt($sport, $database){   //add a sport court to the branch
            $sport -> getDetails($database, wantedColumns: ['sportName']);

            $sportName = json_decode(json_encode($sport), true)['sportName'];

            $courIDPrefix = substr($this -> branchID, 0, 3) . substr($sportName, 0, 3);
            $courtID = uniqid($courIDPrefix);

            //to select the courtName, we need to number of courts of the same sport in the branch

            $courtCount = count($this -> getBranchCourts($database, sport: $sport));
            $newCourtNo = $courtCount + 1;

            if($newCourtNo > count(ALPHABET)){  
                //if the number of courts is greater than the number of letters in the alphabet, we need to add the next letter to the new court name
                $courtName = ALPHABET[($newCourtNo / count(ALPHABET)) - 1] . (ALPHABET[($newCourtNo % count(ALPHABET)) - 1]);
            }
            else{
                $courtName = ALPHABET[$courtCount];

            }

            $court = new Sports_Court($courtID);
            $court -> setDetails($courtName, $this -> branchID, $sport -> getID());

            $status = $court -> createCourtEntry($database);

            return $status;
        }

        public function getCurrentReceptionist($database){
            $sql = sprintf("SELECT currReceptionist FROM branch WHERE branchID = '%s'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $receptionist = $result -> fetch_object();
            $this -> currReceptionist = $receptionist -> currReceptionist;

            $recep = new Receptionist();
            $recep -> setUserID($receptionist -> currReceptionist);

            return $recep;
        }

        public function getCurrentManager($database){
            $sql = sprintf("SELECT currManager FROM branch WHERE branchID = '%s'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $manager = $result -> fetch_object();
            $this -> currManager = $manager -> currManager;

            $man = new Manager();
            $man -> setUserID($manager -> currManager);

            return $man;
        }

        public function offeringSports($database){  //return an array of sports offered by the branch (the sports that have courts with accepted status)
            $sports = [];
            //get all the courts
            $courts = $this -> getBranchCourts(database : $database,  courtStatus : 'a');

            $sportIDs = [];
            foreach($courts as $court){
                $courtSport = $court -> getSport($database);

                if(!in_array($courtSport -> getID(), $sportIDs)){   //exclude duplicate sports
                    array_push($sports, $courtSport);
                    array_push($sportIDs, $courtSport -> getID());
                }
            }

            return $sports;
        }


        public function updateBranchEmail($newEmail,$database) {
            $updateSQL = sprintf("UPDATE `branch` SET `branchEmail` = '%s' WHERE `branch`.`branchID` = '%s'",
            $database -> real_escape_string($newEmail),
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($updateSQL);
            return $result;
        }

        public function getBranchPictures($database){   //function get branch photos and store in the object
            $this -> photos = [];
            $sql = sprintf("SELECT `photo`
            FROM branch_photo
            WHERE branchID = '%s'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            while($row = $result -> fetch_object()){
                if($row !== NULL){  //has photos
                    array_push($this -> photos, $row -> photo);
                }
                unset($row);
            }
            $result -> free_result();
            return $this -> photos;
        }

        public function addBranchFeedback($addedUser, $feedback, $rating, $database){
            $newFeedback = new Branch_Feedback();
            
            $addedDate = date("Y-m-d");
            $newFeedbackID = uniqid("FB");
            $newFeedback -> setDetails(user_id: $addedUser -> getUserID(), branch_id: $this -> branchID, description: $feedback, rating: $rating, date: $addedDate, userfeedback_id: $newFeedbackID);
            $result = $newFeedback -> addFeedback($database);
            return $result;
        }


        public function getBranchFeedback($database, int $limit = null, $wantedFeedbackDetails = []){
            $sql = sprintf("SELECT `userFeedbackID` FROM `user_branch_feedback` WHERE `branchID` = '%s'",
            $database -> real_escape_string($this -> branchID));    //sql to get the feedback ids

            if($limit != null){ //if limited number of feedbacks are required
                //normally the limit is given when only the latest feedbacks are required
                //so the feedbacks are sorted by date
                $sql .= " ORDER BY `date` DESC";

                $sql .= sprintf(" LIMIT %d", $limit);
            }

            $result = $database -> query($sql);

            $allFeedbacks = [];

            while($row = $result -> fetch_object()){    //traverse each result
                $currFeedbackID = $row -> userFeedbackID;
                $tempFeedback = new Branch_Feedback();  //create an feedback object for each result
                $tempFeedback -> setDetails(userfeedback_id: $currFeedbackID);

                $tempFeedback -> getDetails($database, $wantedFeedbackDetails); //get feedback details
                array_push($allFeedbacks, $tempFeedback);
                unset($tempFeedback);
                unset($row);
            }

            return $allFeedbacks;
        }

        public function updateCurrentStaff($staffID, $staffRole, $database){
            $updatingColumn = '';
            if($staffRole === 'receptionist'){
                $updatingColumn = 'currReceptionist';
            }
            else if($staffRole === 'manager'){
                $updatingColumn = 'currManager';
            }
            else{
                return FALSE;
            }

            $sql = sprintf("UPDATE `branch` SET `%s`= '%s' WHERE `branchID` = '%s'",
            $database -> real_escape_string($updatingColumn),
            $database -> real_escape_string($staffID),
            $database -> real_escape_string($this -> branchID));
            $result  = $database -> query($sql);

            return $result;

        }


        public function getBranchRating($database){
            $sql = sprintf("SELECT AVG(`rating`) as `rating` FROM `user_branch_feedback` WHERE `branchID` = '%s'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $row = $result -> fetch_object();
            $rating = $row -> rating;
            $result -> free_result();
            unset($row);

            if($rating === NULL){   //no rating
                return 0;
            }
            return $rating;
        }

        public function getCurrentDiscount($database){ //function to get the current discount of the branch (available during the current date)
            date_default_timezone_set(SERVER_TIMEZONE);
            $today = date('Y-m-d');

            $sql = sprintf("SELECT `discountValue`
            FROM `discount`
            WHERE `branchID` = '%s'
            AND `decision` = 'a'
            AND `startingDate` <= '%s'
            AND `endingDate` >= '%s'",
            $database -> real_escape_string($this -> branchID),
            $database -> real_escape_string($today),
            $database -> real_escape_string($today));

            $result = $database -> query($sql);

            $obj = $result -> fetch_object();
            if($obj === NULL){
                return null;
            }
            $discount = $obj -> discountValue;
            $result -> free_result();
            unset($obj);
            return $discount;
        }

        public function getBranchMaintenance($database,array $wantedInfo, $date = null, $decision = '%'){ //function to get the current maintenance of the branch
            if($date === null){
                //set date to 1800-01-01 so that it will return all maintenance
                $date = '1800-01-01';
            }
            //create sql query using wantedinfo column names and format it
            $sql = "SELECT ";
            foreach($wantedInfo as $column){
                $sql .= "`$column`,";
            }
            $sql = substr($sql, 0, -1); //remove the last comma

            $sql .= sprintf(" FROM `branch_maintenance` 
            WHERE `branchID` = '%s'
            AND `decision` LIKE '%s'
            AND (`startingDate` >= '%s'
            OR `endingDate` >= '%s')",
            $database -> real_escape_string($this -> branchID),
            $database -> real_escape_string($decision),
            $database -> real_escape_string($date),
            $database -> real_escape_string($date));

            $result = $database -> query($sql);

            $allMaintenances = [];

            while($row = $result -> fetch_object()){    //traverse each result
                array_push($allMaintenances, $row);
                unset($tempMaintenance);
                unset($row);
            }

            return $allMaintenances;
        }

        public function getBranchCourts($database,Sport $sport = null, $courtStatus = '%'){ //get courts of the branch (null means all, otherwise courts of specific court)
            if($sport == null){
                $sql = sprintf("SELECT `courtID` FROM `sports_court` WHERE `branchID` = '%s' AND `requestStatus` LIKE '%s'",
                $database -> real_escape_string($this -> branchID),
                $database -> real_escape_string($courtStatus));
            }
            else{
                $sql = sprintf("SELECT `courtID` FROM `sports_court` WHERE `branchID` = '%s' AND `sportID` = '%s' AND `requestStatus` LIKE '%s'",
                $database -> real_escape_string($this -> branchID),
                $database -> real_escape_string($sport -> getID()),
                $database -> real_escape_string($courtStatus));
            }

            $result = $database -> query($sql);

            $allCourts = [];
            while($row = $result -> fetch_object()){
                $tempCourt = new Sports_Court($row -> courtID);
                array_push($allCourts, $tempCourt);
                unset($tempCourt);
                unset($row);
            }

            return $allCourts;
        }

        public function getBranchRevenue($database, $dateFrom, $dateTo, Sport $sport = null){    //function to get the revenue of the branch within specific range
            $totalRevenue = 0;

            if($sport == null){
                //get the revenue of the branch from the reservations
                $totalRevenue += $this -> courtReservationRevenue(dateFrom: $dateFrom,dateTo: $dateTo,database: $database, sport: null);

                //get the revenue of the branch from the coach session payments
                $totalRevenue += $this -> coachSessionPaymentRevenue(dateFrom: $dateFrom,dateTo: $dateTo,database: $database, sport: null);
            }else{
                //get the revenue of the branch from the reservations
                $totalRevenue += $this -> courtReservationRevenue(dateFrom: $dateFrom,dateTo: $dateTo,database: $database,sport: $sport);

                //get the revenue of the branch from the coach session payments
                $totalRevenue += $this -> coachSessionPaymentRevenue(dateFrom: $dateFrom,dateTo: $dateTo,database: $database,sport: $sport);
            
            }
            
            return $totalRevenue;
        }

        public function courtReservationRevenue($dateFrom, $dateTo,Sport $sport = null, $database){
            $totalRevenue = 0;
            //first get all the courts of the branch
            if($sport == null){
                $allCourts = $this -> getBranchCourts(database: $database,sport: null);
            }else{
                $allCourts = $this -> getBranchCourts($database, $sport);
            }
            

            //build the sql query for user reservations
            $userSql = "SELECT SUM(`paymentAmount`) as `total` FROM `reservation` WHERE `sportCourt` IN (";
            foreach($allCourts as $court){
                $userSql .= "'".$court -> getID()."',";
            }

            $userSql = substr($userSql, 0, -1); //remove the last comma

            $userSql .= sprintf(") AND `date` >= '%s' AND `date` <= '%s' AND (`status` NOT LIKE 'Cancelled' AND `status` NOT LIKE 'Refunded')",
            $database -> real_escape_string($dateFrom),
            $database -> real_escape_string($dateTo));

            $result = $database -> query($userSql);
            $row = $result -> fetch_object();
            $totalRevenue += $row -> total;   //avoid getting the revenue as null

            return $totalRevenue;
        }

        public function coachSessionPaymentRevenue($dateFrom, $dateTo, Sport $sport = null,$database){
            $totalRevenue = 0;
            //first get all the courts of the branch
            if($sport == null){
                $allCourts = $this -> getBranchCourts(database: $database);
            }else{
                $allCourts = $this -> getBranchCourts($database, $sport);
            }

            //build the sql query for coaching session payments of the coach
            $coachSql = "SELECT SUM(`csp`.`paymentAmount`) as `total` 
            FROM `coach_session_payment` `csp` 
            INNER JOIN `coaching_session` `cs` 
            ON `cs`.`sessionID` = `csp`.`sessionID` 
            WHERE `cs`.`courtID` IN (";

            foreach($allCourts as $court){
                $coachSql .= "'".$court -> getID()."',";
            }

            $coachSql = substr($coachSql, 0, -1); //remove the last comma

            $coachSql .= sprintf(") AND `csp`.`paymentDate` >= '%s' AND `csp`.`paymentDate` <= '%s' AND `csp`.`status` LIKE 'Processed'",
            $database -> real_escape_string($dateFrom),
            $database -> real_escape_string($dateTo));

            $result = $database -> query($coachSql);
            $row = $result -> fetch_object();
            $totalRevenue += $row -> total;   //avoid getting the revenue as null
            
            return $totalRevenue;
        }

        public function jsonSerialize():mixed{
            //get class properties
            $properties = get_object_vars($this);

            $returnJSON = [];

            foreach($properties as $key => $value){
                if(isset($this -> $key) && $value != ''){
                    $returnJSON[$key] = $value;
                }
            }

            return $returnJSON;
        }

        public  function get_time($database){
            $sql=sprintf( "SELECT `openingTime`,`closingTime` FROM `branch` WHERE `branchID` LIKE '%s' ",

            $database -> real_escape_string($this -> branchID));
            
            $Result = $database -> query($sql);
            $timeResult=[];
             
            $row = $Result -> fetch_object();

            $timeResult['openingTime'] = $row -> openingTime;


            foreach($Result as $time){
                $temporaryOpen =$time['openingTime'];
                $temporaryClose= $time['closingTime'];
                array_push($timeResult,['openingTime'=>$temporaryOpen,'closingTime'=>$temporaryClose]);
            }
            // while($row =  $Result  -> fetch_object()) {
            //     array_push($timeResult,[ $row['openingTime'] -> openingTime,$row['closingTime'] -> closingTime]);
            // }

           
            return  $timeResult;
        }

        public function changeTime($database, $openingTime ,$closingTime){
            $result = $database -> query(sprintf("UPDATE `branch` 
            SET `openingTime` = '%s', `closingTime` = '%s' WHERE `branchID` = '%s'",
            // $database -> real_escape_string($this -> managerID),
            // $database -> real_escape_string($this -> contactNum),
            $database -> real_escape_string($openingTime),
            $database -> real_escape_string($closingTime),
            $database -> real_escape_string($this ->branchID)));
    
            return $result;
    
        }
    
    }
?>
