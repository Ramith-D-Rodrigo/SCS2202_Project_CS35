<?php
    require_once("../../src/general/branch.php");
    class Reservation implements JsonSerializable{
        private $reservationID;
        private $date;
        private $startingTime;
        private $endingTime;
        private $noOfPeople;
        private $paymentAmount;
        private $sportCourt;
        private $userID;
        private $formalManagerID;
        private $onsiteReceptionistID;
        private $status;     //pending //checked_in //cancelled //declined  //not checked in
        private $branch;
        private $sport;
        private $courtName;
        private $reservedDate;  //the date and time when the reservation is made
        private $chargeID;  //the charge id from the payment gateway

        public function onlineReservation($date, $st, $et, $people, $payment, $court, $user, $chargeID, $database){
            $this -> userID = $user;

            //unique id prefixes
            $prefix1 = "Res-";
            $prefix2 = substr($this -> userID, 0, 3);

            $this -> reservationID = uniqid($prefix1.$prefix2);

            $this -> date = $date;
            $this -> startingTime = $st;
            $this -> endingTime = $et;
            $this -> noOfPeople = $people;
            $this -> paymentAmount = $payment;
            $this -> sportCourt = $court;
            $this -> chargeID = $chargeID;

            $this -> status = 'Pending';
            $this -> formalManagerID = '';
            $this -> onsiteReceptionistID = '';
            $queryResult = $this -> create_online_reservation_entry($database); //returns an array with the result and the reservation id
            return $queryResult;
        }

        private function create_online_reservation_entry($database){
            //reserved date and time is added automatically
            $sql = sprintf("INSERT INTO `reservation`
            (`reservationID`,
            `date`,
            `startingTime`,
            `endingTime`,
            `noOfPeople`,
            `paymentAmount`,
            `sportCourt`,
            `userID`,
            `status`,
            `chargeID`)
            VALUES
            ('%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s')",
            $database -> real_escape_string($this -> reservationID),
            $database -> real_escape_string($this -> date),
            $database -> real_escape_string($this -> startingTime),
            $database -> real_escape_string($this -> endingTime),
            $database -> real_escape_string($this -> noOfPeople),
            $database -> real_escape_string($this -> paymentAmount),
            $database -> real_escape_string($this -> sportCourt),
            $database -> real_escape_string($this -> userID),
            $database -> real_escape_string($this -> status),
            $database -> real_escape_string($this -> chargeID));
            //print_r($sql);

            $result = $database -> query($sql);
            return [$result, $this -> reservationID];   //return the result and the reservation id incase of failure
        }

        public function setID($reserveID){
            $this -> reservationID = $reserveID;
        }

        public function cancelReservation($user_id, $database){

            $sql = sprintf("UPDATE `reservation`
            SET `status`='Cancelled'
            WHERE `reservationID` = '%s'
            AND `userID` = '%s'",
            $database -> real_escape_string($this -> reservationID),
            $database -> real_escape_string($user_id));

            $result = $database -> query($sql);

            return $result;
        }

        public function deleteReservation($database){
            $sql = sprintf("DELETE FROM `reservation`
            WHERE `reservationID` = '%s'",
            $database -> real_escape_string($this -> reservationID));

            $result = $database -> query($sql);

            return $result;
        }



        public function getDetails($database, $wantedColumns = []){
            $sql = "SELECT ";
            if(empty($wantedColumns)){
                $sql .= "`r`.*, `b`.`city` AS `branch`, `s`.`sportName` as `sport`, `sc`.`courtName`";
            }else{
                foreach($wantedColumns as $column){
                    $sql .= "`r`.`$column`,";
                }
                //remove the last comma
                $sql = substr($sql, 0, -1);
            }
            
            $sql .= sprintf(" FROM `reservation` `r`
            INNER JOIN `sports_court` `sc`
            ON `sc`.`courtID` = `r`.`sportCourt`
            INNER JOIN `sport` `s`
            ON `sc`.`sportID` = `s`.`sportID`
            INNER JOIN `branch` `b`
            ON `b`.`branchID` = `sc`.`branchID`
            WHERE `reservationID` = '%s'",
            $database -> real_escape_string($this -> reservationID));

            $result = $database -> query($sql);

            $resultObj = $result -> fetch_object();

            //using foreach to set object properties
            foreach($resultObj as $key => $value){
                $this -> $key = $value;
            }

/*             $this -> date = $resultObj -> date;
            $this -> startingTime = $resultObj -> startingTime;
            $this -> endingTime = $resultObj -> endingTime;
            $this -> noOfPeople = $resultObj -> noOfPeople;
            $this -> paymentAmount = $resultObj -> payment_amount;
            $this -> sportCourt = $resultObj -> sportCourt;
            $this -> status = $resultObj -> status;
            $this -> userID = $resultObj -> userID;
            $this -> formalManagerID = $resultObj -> formalManagerID;
            $this -> onsiteReceptionistID = $resultObj -> onsiteReceptionistID;
            $this -> branch = $resultObj -> city;
            $this -> sport = $resultObj -> sportName;
            $this -> courtName = $resultObj -> courtName; */

            $result -> free_result();
            unset($resultObj);
            return $this;
        }

        public function getReservedBranch($database){  //get the branch id of the reserved court that belongs to the reservation and return the branch object
            $sql = sprintf("SELECT `b`.`branchID` AS `branchID`
            FROM `reservation` `r`
            INNER JOIN `sports_court` `sc`
            ON `sc`.`courtID` = `r`.`sportCourt`
            INNER JOIN `branch` `b`
            ON `b`.`branchID` = `sc`.`branchID`
            WHERE `reservationID` = '%s'",
            $database -> real_escape_string($this -> reservationID));  

            $result = $database -> query($sql);

            $resultObj = $result -> fetch_object();

            $branchID = $resultObj -> branchID;

            $branchObj = new Branch($branchID);

            $result -> free_result();
            return $branchObj;
        }

        public function updateStatus($database, $status){   //update the status of the reservation
            $sql = sprintf("UPDATE `reservation`
            SET `status` = '%s'
            WHERE `reservationID` = '%s'",
            $this -> status ." ". $database -> real_escape_string($status),
            $database -> real_escape_string($this -> reservationID));

            $result = $database -> query($sql);

            return $result;
        }


        public function JsonSerialize() : mixed{
            return [
                "reservationID" => $this -> reservationID,
                "date" => $this -> date,
                "startingTime" => $this -> startingTime,
                "endingTime" => $this -> endingTime,
                "numOfPeople" => $this -> noOfPeople,
                "paymentAmount" => $this -> paymentAmount,
                "sport_court" => $this -> sportCourt,
                "user_id" => $this -> userID,
                "formal_manager_id" => $this -> formalManagerID,
                "onsite_receptionist_id" => $this -> onsiteReceptionistID,
                "status" => $this -> status,     //pending //checked_in //cancelled //declined  //completed
                "branch" => $this -> branch,
                "sport" => $this -> sport,
                "court_name" => $this -> courtName,
                "reserved_date" => $this -> reservedDate
            ];
        }
    }
?>
