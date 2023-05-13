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

        public function getRevenue($dateFrom, $dateTo, $branch = null,$sport = null){    //get the revenue of the branches
            if($branch == null){    //all branches are needed
                $branchArr = $this -> getBranches();
                $revenue = 0;

                foreach($branchArr as $branch){
                    $revenue += $branch -> getBranchRevenue($this -> connection, $dateFrom, $dateTo);
                }

                return $revenue;
            }
            else{
                if($sport == null){
                    return $branch -> getBranchRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo);
                }else{
                    return $branch -> getBranchRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo,sport: $sport);
                }
                
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

        public function getCoachingSessionRevenue($dateFrom, $dateTo, $branch = null, Sport $sport = null){    //get the revenue of the coaching sessions of the branch
            if($branch == null){    //all branches are needed
                $branchArr = $this -> getBranches();
                $revenue = 0;

                foreach($branchArr as $branch){
                    $revenue += $branch -> coachSessionPaymentRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo);
                }
                return $revenue;
            }
            else{
                if($sport == null){
                    return $branch -> coachSessionPaymentRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo,sport: null);
                }else{
                    return $branch -> coachSessionPaymentRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo,sport: $sport);
                }
                
            }
        }

        public function getReservationRevenue($dateFrom, $dateTo, $branch = null, Sport $sport = null){    //get the revenue of the reservations of the branch
            if($branch == null){
                $branchArr = $this -> getBranches();
                $revenue = 0;

                foreach($branchArr as $branch){
                    $revenue += $branch -> courtReservationRevenue(database:$this -> connection,dateFrom: $dateFrom,dateTo: $dateTo);
                }
                return $revenue;
            }
            else{
                if($sport == null) {
                    return $branch -> courtReservationRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo,sport: null);
                }else{
                    return $branch -> courtReservationRevenue(database: $this -> connection,dateFrom: $dateFrom,dateTo: $dateTo,sport: $sport);
                }
                
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

        public function managerRequests($manager = null, $discountDecision = '%', $courtDecision = '%'){   //% for wildcard
            $totalRequests =  array_merge($this -> getDiscountRequests(manager: $manager, decision: $discountDecision), $this -> getSportCourtRequests(manager: $manager, decision: $courtDecision));
            return $totalRequests;
        }

        public function updateManagerRequest($manager = null,$courtID = null, $startingDate = null,$decision = '%'){
            
            $sql = '';
            if($manager == null){
                $sql = sprintf("UPDATE `sports_court` SET `requestStatus` = '%s' WHERE `courtID` = '%s'",
                $this -> connection -> real_escape_string($decision),
                $this -> connection -> real_escape_string($courtID));

            }else{
                $sql = sprintf("UPDATE `discount` SET `decision` = '%s' WHERE `managerID` = '%s' AND `startingDate` = '%s'",
                $this -> connection -> real_escape_string($decision),
                $this -> connection -> real_escape_string($manager),
                $this -> connection -> real_escape_string($startingDate));

            }

            $result = $this -> connection -> query($sql);
            return $result;
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

        public function getSportCourtRequests($manager = null, $decision = '%'){ //get all the sport court requests including court photos(adding new sports court to some branch)
            if($manager == null){
                $sql = sprintf("SELECT `sc`.*,`scp`.`courtPhoto` FROM 
                `sports_court` `sc` LEFT JOIN `sports_court_photo` `scp` ON `sc`.`courtID` = `scp`.`courtID` 
                WHERE `sc`.`requestStatus` LIKE '%s' AND `sc`.`addedManager` IS NOT NULL", 
                $this -> connection -> real_escape_string($decision));
                $result = $this -> connection -> query($sql);
            }
            else{
                $sql = sprintf("SELECT `sc`.*,`scp`.`courtPhoto` FROM 
                `sports_court` `sc` LEFT JOIN `sports_court_photo` `scp` ON `sc`.`courtID` = `scp`.`courtID`
                WHERE `managerID` = '%s' AND `requestStatus` LIKE '%s'",
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

        public function addNewSport($sportName, $description, $reservationPrice, $maxPlayers){
            $newSport = new Sport();

            $sportID = uniqid(substr($sportName, 0, 4));    //set the sport ID
            $newSport -> setID($sportID);

            $coachingSessionPrice = $reservationPrice * MIN_COACHING_SESSION_PERCENTAGE  + $reservationPrice;   //set the coaching session price

            $newSport -> setDetails($sportName, $description, $reservationPrice, $coachingSessionPrice, $maxPlayers);

            $result = $newSport -> createSportEntry($this -> connection);

            return $result;
        }

    }
?>