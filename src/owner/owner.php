 <?php
    require_once("../../src/general/actor.php");
    require_once("../../src/general/sport.php");
    require_once("../../src/general/branch.php");
    class Owner extends Actor{
        private $firstName;
        private $lastName;
        private $contactNum;
        private static Owner $ownerInstance;  //singleton instance

        private function __construct(){ //singleton constructor

        }

        public static function getInstance(Actor $actor = null){  //singleton instance getter
            if(!isset(self::$ownerInstance)){
                self::$ownerInstance = new Owner();
            }
            //set the actor values
            if($actor != null){
                self::$ownerInstance -> userID = $actor -> getUserID();
                self::$ownerInstance -> username = $actor -> getUsername();
            }

            //set the database connection
            require("dbconnection.php");
            self::$ownerInstance -> connection = $connection;
            return self::$ownerInstance;
        }


        public function setDetails($fName='', $lName='', $email='', $contactNo='', $username='', $password='' ){
            $this -> firstName = $fName;
            $this -> lastName = $lName;
            $this -> emailAddress = $email;
            $this -> contactNum = $contactNo;
            $this -> username = $username;
            $this -> password = $password;
            $this -> userRole = 'owner';
        }


/*         private function create_login_details_entry($database){   //enter details to the login_details table
            $result = $database -> query(sprintf("INSERT INTO `login_details`
            (`user_id`, 
            `username`,
            `email_address`, 
            `password`, 
            `user_role`,
            `is_active`) 
            VALUES 
            '%s','%s','%s','%s','owner',1)",
            $database -> real_escape_string($this -> ownerID),
            $database -> real_escape_string($this -> username),
            $database -> real_escape_string($this -> emailAddress),
            $database -> real_escape_string($this -> password))); 

             if ($result === TRUE) {
                echo "New log in details record created successfully<br>";
            }
            else{
                echo "Error<br>";
            }
            return $result;
        } */

/*         private function create_owner_entry($database) {
            $sql =(sprintf("INSERT INTO `owner`
            (`owner_id`,
            `contact_no`,
            `first_name`, 
            `last_name`) 
            VALUES '%s','%s','%s','%s','%s')",
            $database -> real_escape_string($this -> contactNum),
            $database -> real_escape_string($this -> firstName),
            $database -> real_escape_string($this -> lastName)));

            $result = $database->query($sql);

            return $result;
        } */

/*         public function registerOwner($database){    //public function to register the user
            // $this -> joinDate = date("Y-m-d");
            // $this -> leaveDate = '';
            $loginEntry = $this -> create_login_details_entry($database);
            //$staffEntry = $this -> create_staff_entry($database);
            $ownerEntry = $this -> create_owner_entry($database);

            if($loginEntry  === TRUE && $ownerEntry === TRUE){    //all has to be true (successfully registered)
                return TRUE;
            }
        } */


        public function getRevenue($dateFrom, $dateTo, $branch = null){    //get the revenue of the branches
            if($branch == null){    //all branches are needed
                $branchArr = $this -> getBranches();
                $revenue = 0;

                foreach($branchArr as $branch){
                    $revenue += $branch -> getBranchRevenue($this -> connection, $dateFrom, $dateTo);
                }

                return $revenue;
            }
            else{
                return $branch -> getBranchRevenue($this -> connection, $dateFrom, $dateTo);
            }

        }
        
        public function getBranches(){  //get the branches
            $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `requestStatus` = 'a'");
            $result = $this -> connection -> query($sql);
            $branchArr = array();

            while($row = $result -> fetch_object()){
                $tempBranch = new Branch($row -> branchID);
                array_push($branchArr, $tempBranch);
                unset($tempBranch);
            }

            return $branchArr;
        }

        public function getCoachingSessionRevenue($dateFrom, $dateTo, $branch = null){    //get the revenue of the coaching sessions of the branch
            if($branch == null){    //all branches are needed
                $branchArr = $this -> getBranches();
                $revenue = 0;

                foreach($branchArr as $branch){
                    $revenue += $branch -> coachSessionPaymentRevenue($this -> connection, $dateFrom, $dateTo);
                }
                return $revenue;
            }
            else{
                return $branch -> coachSessionPaymentRevenue($this -> connection, $dateFrom, $dateTo);
            }
        }

        public function getReservationRevenue($dateFrom, $dateTo, $branch = null){    //get the revenue of the reservations of the branch
            if($branch == null){
                $branchArr = $this -> getBranches();
                $revenue = 0;

                foreach($branchArr as $branch){
                    $revenue += $branch -> courtReservationRevenue($this -> connection, $dateFrom, $dateTo);
                }
                return $revenue;
            }
            else{
                return $branch -> courtReservationRevenue($this -> connection, $dateFrom, $dateTo);
            }
        }

        public function getSports(){    //get all the sports
            $sql = sprintf("SELECT `sportID` FROM `sport`");
            $result = $this -> connection -> query($sql);
            $sportArr = array();


            while($row = $result -> fetch_object()){
                $tempSport = new Sport();
                $tempSport -> setID($row -> sportID);
                array_push($sportArr, $tempSport);
                unset($tempSport);
            }

            return $sportArr;
        }

        public function changeReservationPrice($sport, $newPrice){
            $sql = sprintf("UPDATE `sport` SET `reservationPrice` = '%s' WHERE `sportID` = '%s'",
            $this -> connection -> real_escape_string($newPrice),
            $this -> connection -> real_escape_string($sport -> getID()));
            $result = $this -> connection -> query($sql);

            if($result === TRUE){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }

        public function managerRequests($manager = null, $discountDecision = '%', $courtDecision = '%'){   //% for wildcard
            $totalRequests =  array_merge($this -> getDiscountRequests(manager: $manager, decision: $discountDecision), $this -> getSportCourtRequests(manager: $manager, decision: $courtDecision));
            return $totalRequests;
        }

        public function getDiscountRequests($manager = null, $decision = '%'){   //% for wildcard

            if($manager == null){   //get all discount requests
                $sql = sprintf("SELECT * FROM `discount` WHERE `decision` LIKE '%s'",
                $this -> connection -> real_escape_string($decision));
                $result = $this -> connection -> query($sql);
            }
            else{
                $sql = sprintf("SELECT * FROM `discount` WHERE `managerID` = '%s' AND `decision` LIKE '%s'",
                $this -> connection -> real_escape_string($manager -> getUserID()),
                $this -> connection -> real_escape_string($decision));
                $result = $this -> connection -> query($sql);
            }

            $discountArr = array();
            while($row = $result -> fetch_object()){
                array_push($discountArr, $row);
                unset($tempDiscount);
            }

            return $discountArr;
        }

        public function getSportCourtRequests($manager = null, $decision = '%'){ //get all the sport court requests (adding new sports court to some branch)
            if($manager == null){
                $sql = sprintf("SELECT * FROM `sports_court` WHERE `requestStatus` LIKE '%s' AND `addedManager` IS NOT NULL", $this -> connection -> real_escape_string($decision));
                $result = $this -> connection -> query($sql);
            }
            else{
                $sql = sprintf("SELECT * FROM `sports_court` WHERE `managerID` = '%s' AND `requestStatus` LIKE '%s'",
                $this -> connection -> real_escape_string($manager -> getUserID()),
                $this -> connection -> real_escape_string($decision));
                $result = $this -> connection -> query($sql);
            }

            $sportCourtArr = array();

            while($row = $result -> fetch_object()){
                array_push($sportCourtArr, $row);
            }

            return $sportCourtArr;
        }

        public function requestToAddBranch($city, $address, $openingTime, $closingTime, $email, $sportsAndCourts, $latitude, $longitude, $openingDate){
            $branchID = uniqid(substr($city, 0, 4));

            $newBranch = new Branch($branchID);

            $newBranch -> setDetails(city: $city,address: $address, branchEmail: $email,
            openingTime: $openingTime, closingTime: $closingTime, latitude: $latitude, longitude: $longitude, openingDate: $openingDate);

            $status = $newBranch -> createBranchEntry($this -> connection, $this -> userID);

            if(!$status){
                return FALSE;
            }

            //create the sports court entries
            foreach($sportsAndCourts as $currSport){
                $addingSport = new Sport();
                $addingSport -> setID($currSport['sportID']);
                for($i = 1; $i <= $currSport['courtCount']; $i++){
                    $status = $newBranch -> addSportCourt($addingSport, $this -> connection);
                    if(!$status){
                        return FALSE;
                    }
                }
            }

            return TRUE;

        }

        public function updateSportDetails($sport, $updatingColumns){
            return $sport -> updateDetails($updatingColumns, $this -> connection);
        }

    }
?>