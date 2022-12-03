<?php
    require_once("../../src/general/uuid.php");

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

        public function __construct($branch_id){    //use the binary id to construct
            $this -> branchID = $branch_id;
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

        public function setDetails($city = '', $address = '', $email = '', $manager = '', $receptionist = '', $opening_time = '', $closing_time = ''){
            $this -> city = $city;
            $this -> address = $address;
            $this -> email = $email;
            $this -> manager = $manager;
            $this -> receptionist = $receptionist;
            $this -> opening_time = $opening_time;
            $this -> closing_time = $closing_time;
        }

        public function getManager($database){  //get Manager ID
            if(isset($this -> manager)){
                return $this -> manager;
            }

            $sql = sprintf("SELECT staff_id
            FROM staff
            WHERE branch_id = '%s'
            AND staff_role = 'manager'",
            $database -> real_escape_string($this -> branchID));

            $result = $database -> query($sql);

            $manager = $result -> fetch_object();
            $this -> manager = $manager;
            return $manager;
        }

        public function getReceptionist($database){  //get Receptionist ID
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

        public function getAllSports($database){
            $sql = sprintf("SELECT DISTINCT `sport`.`sport_name` from `sport` INNER JOIN `sports_court` 
            ON `sport`.`sport_id` = `sports_court`.`sport_id` INNER JOIN `staff` 
            ON `sports_court`.`branch_id` = `staff`.`branch_id` WHERE `staff`.`branch_id` = '%s'",
            $database -> real_escape_string($this -> branchID));

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
            }
            return $this -> photos;
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