<?php
    require_once("../../src/manager/manager.php");
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/general/branch_feedback.php");

    class Branch implements JsonSerializable{
        private $branchID;
        private $city;
        private $address;
        private $email;
        private $manager;
        private $receptionist;
        private $opening_time;
        private $closing_time;
        private $photos;

        public function __construct($branch_id){
            $this -> branchID = $branch_id;
        }

        public function getDetails($database, $wantedProperty = ''){
            if($wantedProperty === 'branch_id'){
                return $this -> branchID;
            }
            else if($wantedProperty === ''){
                $branchSql = sprintf("SELECT * FROM `branch`
                WHERE
                `branch_id`
                LIKE '%s'",
                $database -> real_escape_string($this -> branchID));
                $result =  $database -> query($branchSql);

                $row = $result -> fetch_object();
                $result -> free_result();

                $managerID = $row -> curr_manager;
                //get manager details by setting the manager object values
                $manager = new Manager();
                $manager -> setDetails(uid: $managerID);
                $manager -> getDetails($database);

                //get receptionist details by setting the receptionist object values
                $receptionistID = $row -> curr_receptionist;
                $receptionist = new Receptionist();
                $receptionist -> setDetails(uid :$receptionistID);
                $receptionist -> getDetails($database);


                $this -> setDetails(city: $row -> city, address: $row -> address,email: $row -> branch_email, opening_time: $row -> opening_time, closing_time: $row -> closing_time, manager: $manager, receptionist: $receptionist);

                //set branch photos from database
                $this -> getBranchPictures($database);

                return $this;
            }
            else{
                $sql = sprintf("SELECT `%s` as `wanted_property` FROM `branch` WHERE `branch_id` LIKE '%s'",
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
            if(!isset($this -> email) || $email  === ''){
                $this -> email = $email;
            }
            if(!isset($this -> manager) || $manager  === ''){
                $this -> manager = $manager;
            }
            if(!isset($this -> receptionist) || $receptionist  === ''){
                $this -> receptionist = $receptionist;
            }
            if(!isset($this -> opening_time) || $opening_time  === ''){
                $this -> opening_time = $opening_time;
            }
            if(!isset($this -> closing_time) || $closing_time  === ''){
                $this -> closing_time = $closing_time;
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

            $sql = sprintf("SELECT staff_id
            FROM staff
            WHERE branch_id = '%s'
            AND staff_role = 'receptionist'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $receptionist = $result -> fetch_object();
            $this -> receptionist = $receptionist;
            return $receptionist;
        }


        public function getAllSports($database){    //only courts with accepted status
            $sql = sprintf("SELECT DISTINCT `s`.`sport_id`,`s`.`sport_name` from `sport` `s`
            INNER JOIN `sports_court` `sc`
            ON `s`.`sport_id` = `sc`.`sport_id`
            INNER JOIN `branch` `b`
            ON `b`.`branch_id` = `sc`.`branch_id`
            WHERE `b`.`branch_id` = '%s'
            AND `sc`.`request_status` = 'a'",

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
            $sql = sprintf("SELECT `court_name`
            FROM
            `sports_court`
            WHERE
            `branch_id`
            LIKE
            '%s' ",
            $database -> real_escape_string($this -> branchID));     //get the number of sports courts in a branch when the sport id is given

            $result = $database -> query($sql);
            $courtNames = [];
            while($row = $result -> fetch_object()) {
                array_push($courtNames,$row -> court_name);
                unset($row);
            }
            $result -> free_result();
            return $courtNames;
        }

        public function getSportCourts($sportID, $database){
            $sql = sprintf("SELECT `court_id`
            FROM
            `sports_court`
            WHERE
            `branch_id`
            LIKE
            '%s'
            AND
            `sport_id`
            LIKE
            '%s'",
            $database -> real_escape_string($this -> branchID),
            $database -> real_escape_string($sportID));

            $result = $database -> query($sql);
            $courts = [];
            while($row = $result -> fetch_object()){
                array_push($courts, $row -> court_id);
                unset($row);
            }
            $result -> free_result();
            return $courts;
        }

        public function updateBranchEmail($newEmail,$database) {
            $updateSQL = sprintf("UPDATE `branch` SET `branch_email` = '%s' WHERE `branch`.`branch_id` = '%s'",
            $database -> real_escape_string($newEmail),
            $database -> real_escape_string($this-> branchID));

            $result = $database -> query($updateSQL);
            return $result;
        }
        public function getBranchPictures($database){   //function get branch photos and store in the object

            if(isset($this -> photos)){ //if the object has photos set
                return $this -> photos;
            }
            //if the object doesn't have photos set
            $sql = sprintf("SELECT `photo`
            FROM branch_photo
            WHERE branch_id = '%s'",
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


        public function getBranchFeedback($database){
            $sql = sprintf("SELECT `userfeedback_id` FROM `user_branch_feedback` WHERE `branch_id` = '%s'",
            $database -> real_escape_string($this -> branchID));    //sql to get the feedback ids

            $result = $database -> query($sql);

            $allFeedbacks = [];

            while($row = $result -> fetch_object()){    //traverse each result
                $currFeedbackID = $row -> userfeedback_id;
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
                $updatingColumn = 'curr_receptionist';
            }
            else if($staffRole === 'manager'){
                $updatingColumn = 'curr_manager';
            }
            else{
                return FALSE;
            }

            $sql = sprintf("UPDATE `branch` SET '%s'= '%s' WHERE branch_id = '%s'",
            $database -> real_escape_string($updatingColumn),
            $database -> real_escape_string($staffID),
            $database -> real_escape_string($this -> branchID));

            $result  = $database -> query($sql);

            return $result;

        }

        public function jsonSerialize(){
            return [
                'branchID' => $this -> branchID,
                'city' => $this -> city,
                'address' => $this -> address,
                'email' => $this -> email,
                'manager' => $this -> manager,
                'receptionist' => $this -> receptionist,
                'opening_time' => $this -> opening_time,
                'closing_time' => $this -> closing_time,
                'photos' => $this -> photos
            ];
        }
    }



?>
