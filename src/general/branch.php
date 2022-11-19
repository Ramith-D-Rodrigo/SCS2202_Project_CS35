<?php
    require_once("../../src/general/uuid.php");

    class Branch{
        private $branchID;
        private $city;
        private $address;
        private $contactNum;
        private $email;
        private $manager;
        private $receptionist;
        private $opening_time;
        private $closing_time;

        public function __construct($branch_binary_id){    //use the binary id to construct
            $this -> branchID = $branch_binary_id;
        }

        public function getDetails($database){
            $sql = sprintf("SELECT * FROM `branch`
            WHERE 
            `branch_id` 
            LIKE '%s'", 
            $database -> real_escape_string($this -> branchID));
            $result =  $database -> query($sql);
            return $result;
        }

        public function getAllSports($userID,$database){
            $sql = sprintf("SELECT DISTINCT `sport`.`sport_name` from `sport` INNER JOIN `sports_court` 
            ON `sport`.`sport_id` = `sports_court`.`sport_id` INNER JOIN `staff` 
            ON `sports_court`.`branch_id` = `staff`.`branch_id` WHERE `staff`.`staff_id` = UUID_TO_BIN('%s',1)",
            $database -> real_escape_string($userID));

            $result =  $database -> query($sql);
            $sportNames = [];
            while($row = $result -> fetch_object()) {
                array_push($sportNames,$row -> sport_name);
            }
            return $sportNames;
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
            }

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
            $database -> real_escape_string($sportID));     //get the number of sports courts in a branch when the sport id is given

            $result = $database -> query($sql);
            return $result;
        }

        public function getBranchPictures($database){
            $sql = sprintf("SELECT `photo`
            FROM branch_photo
            WHERE branch_id = '%s'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);
            return $result;
        }
    }

?>