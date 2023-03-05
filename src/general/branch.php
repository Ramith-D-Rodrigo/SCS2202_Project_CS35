<?php
    require_once("../../src/manager/manager.php");
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/general/branch_feedback.php");

    class Branch implements JsonSerializable{
        private $branchID;
        private $city;
        private $address;
        private $branchEmail;
        private $manager;
        private $receptionist;
        private $openingTime;
        private $closingTime;
        private $photos;
        private $currManager;
        private $currReceptionist;
        private $requestStatus;
        private $revenue;


        public function __construct($branch_id){
            $this -> branchID = $branch_id;
        }

        public function getDetails($database, $wantedProperty = ''){
            if($wantedProperty === 'branchID'){
                return $this -> branchID;
            }
            else if($wantedProperty === ''){
                $branchSql = sprintf("SELECT * FROM `branch`
                WHERE
                `branchID`
                LIKE '%s'",
                $database -> real_escape_string($this -> branchID));
                $result =  $database -> query($branchSql);

                $row = $result -> fetch_object();
                $result -> free_result();

                $managerID = $row -> currManager;
                //get manager details by setting the manager object values
                $manager = new Manager();
                $manager -> setDetails(uid: $managerID);
                $manager -> getDetails($database);

                //get receptionist details by setting the receptionist object values
                $receptionistID = $row -> currReceptionist;
                $receptionist = new Receptionist();
                $receptionist -> setDetails(uid :$receptionistID);
                $receptionist -> getDetails($database);


                $this -> setDetails(city: $row -> city, address: $row -> address,email: $row -> branchEmail, opening_time: $row -> openingTime, closing_time: $row -> closingTime, manager: $manager, receptionist: $receptionist);

                //set branch photos from database
                $this -> getBranchPictures($database);

                return $this;
            }
            else{
                $sql = sprintf("SELECT `%s` as `wanted_property` FROM `branch` WHERE `branchID` LIKE '%s'",
                $database -> real_escape_string($wantedProperty),
                $database -> real_escape_string($this -> branchID));

                $result = $database -> query($sql);
                $row = $result -> fetch_object();
                $wantedInfo = $row -> wanted_property;
                unset($row);
                $result -> free_result();
                return $wantedInfo;
            }

        }

        public function setDetails($city = '', $address = '', $email = '', $manager = '', $receptionist = '', $opening_time = '', $closing_time = ''){
            //conditions to check if the property is set or passing the default value
            if(!isset($this -> city) || $city  !== ''){
                $this -> city = $city;
            }
            if(!isset($this -> address) || $address  === ''){
                $this -> address = $address;
            }
            if(!isset($this -> branchEmail) || $email  === ''){
                $this -> branchEmail = $email;
            }
            if(!isset($this -> manager) || $manager  === ''){
                $this -> manager = $manager;
            }
            if(!isset($this -> receptionist) || $receptionist  === ''){
                $this -> receptionist = $receptionist;
            }
            if(!isset($this -> openingTime) || $opening_time  === ''){
                $this -> openingTime = $opening_time;
            }
            if(!isset($this -> closingTime) || $closing_time  === ''){
                $this -> closingTime = $closing_time;
            }
        }

/*         public function getManager($database){      //get manager Info
            if(isset($this -> manager) || $this -> manager !== ''){
                return $this -> manager;
            }

            $this -> manager = new Manager();
            $managerID = $this -> manager -> getID($database);
            $this -> manager -> setDetails(uid: $managerID, brID: $this -> branchID);
            $this -> manager -> getDetails($database);  //get details of the manager


            $sql = sprintf("SELECT `staff_id`
            FROM `staff`
            WHERE `branch_id` = '%s'
            AND `leave_date` IS NULL
            AND `staff_role` = 'manager'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $manager = $result -> fetch_object();
            $this -> manager = $manager;
            return $manager;
        }

        public function getManagerID($database){ //get Manager ID (currently working)
            if(isset($this -> manager) || $this -> manager !== ''){ //the manager is set
                return $this -> manager -> getID($database);
            }

            $sql = sprintf("SELECT `staff_id`
            FROM `staff`
            WHERE `branch_id` = '%s'
            AND `leave_date` IS NULL
            AND `staff_role` = 'manager'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);
            $row = $result -> fetch_object();


            $manager = new Manager();
            $managerID = $row -> staff_id;
            $manager -> setDetails(uid: $managerID, brID: $this -> branchID);
            $this -> manager = $manager;    //for future use
            unset($row);
            $result -> free_result();
            return $managerID;
        } */

        public function getReceptionistID($database){  //get Receptionist ID
            if(isset($this -> receptionist)){
                return $this -> receptionist;
            }

            $sql = sprintf("SELECT staffID
            FROM staff
            WHERE branchID = '%s'
            AND staffRole = 'receptionist'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $receptionist = $result -> fetch_object();
            $this -> currReceptionist = $receptionist;
            return $receptionist;
        }


        public function getAllSports($database){    //only courts with accepted status
            $sql = sprintf("SELECT DISTINCT `s`.`sportID`,`s`.`sportName` from `sport` `s`
            INNER JOIN `sports_court` `sc`
            ON `s`.`sportID` = `sc`.`sportID`
            INNER JOIN `branch` `b`
            ON `b`.`branchID` = `sc`.`branchID`
            WHERE `b`.`branchID` = '%s'
            AND `sc`.`requestStatus` = 'a'",

            $database -> real_escape_string($this -> branchID));

            $result =  $database -> query($sql);
            $sports = [];
            while($row = $result -> fetch_object()) {
                array_push($sports,$row);
                unset($row);
            }
            $result -> free_result();
            
            return $sports;
        }

        public function getAllCourts($database) {
            $sql = sprintf("SELECT `courtName`
            FROM
            `sports_court`
            WHERE
            `branchID`
            LIKE
            '%s' ",
            $database -> real_escape_string($this -> branchID));     //get the number of sports courts in a branch when the sport id is given

            $result = $database -> query($sql);
            $courtNames = [];
            while($row = $result -> fetch_object()) {
                array_push($courtNames, $row -> courtName);
                unset($row);
            }
            $result -> free_result();
            return $courtNames;
        }

        public function getSportCourts($sportID, $database, $status = ''){

            if($status === ''){ //want all the courts of that sportID
                $status = '%';  //wildcard
            }

            $sql = sprintf("SELECT `courtID`
            FROM
            `sports_court`
            WHERE
            `branchID` LIKE '%s'
            AND
            `sportID` LIKE '%s'
            AND
            `requestStatus` LIKE '%s'",
            $database -> real_escape_string($this -> branchID),
            $database -> real_escape_string($sportID),
            $database -> real_escape_string($status));

            $result = $database -> query($sql);
            $courts = [];
            while($row = $result -> fetch_object()){
                array_push($courts, $row -> courtID);
                unset($row);
            }
            $result -> free_result();
            return $courts;
        }

        public function getSportCourtNames($sportID, $database){
            $sql = sprintf("SELECT `courtName`
            FROM
            `sports_court`
            WHERE
            `branchID`
            LIKE
            '%s'
            AND
            `sportID`
            LIKE
            '%s'",
            $database -> real_escape_string($this -> branchID),
            $database -> real_escape_string($sportID));

            $result = $database -> query($sql);
            $courtNames = [];
            while($row = $result -> fetch_object()){
                array_push($courtNames, $row -> courtName);
                unset($row);
            }
            $result -> free_result();
            return $courtNames;
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


        public function getBranchFeedback($database){
            $sql = sprintf("SELECT `userFeedbackID` FROM `user_branch_feedback` WHERE `branchID` = '%s'",
            $database -> real_escape_string($this -> branchID));    //sql to get the feedback ids

            $result = $database -> query($sql);

            $allFeedbacks = [];

            while($row = $result -> fetch_object()){    //traverse each result
                $currFeedbackID = $row -> userFeedbackID;
                $tempFeedback = new Branch_Feedback();  //create an feedback object for each result
                $tempFeedback -> setDetails(userfeedback_id: $currFeedbackID);

                $tempFeedback -> getDetails($database); //get feedback details
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

        public function jsonSerialize():mixed{
            return [
                'branchID' => $this -> branchID,
                'city' => $this -> city,
                'address' => $this -> address,
                'email' => $this -> branchEmail,
                'manager' => $this -> manager,
                'receptionist' => $this -> receptionist,
                'openingTime' => $this -> openingTime,
                'closingTime' => $this -> closingTime,
                'photos' => $this -> photos
            ];
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
