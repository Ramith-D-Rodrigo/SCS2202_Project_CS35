<?php
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

        public function onlineReservation($date, $st, $et, $people, $payment, $court, $user, $database){
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

            $this -> status = 'Pending';
            $this -> formalManagerID = '';
            $this -> onsiteReceptionistID = '';
            $queryResult = $this -> create_online_reservation_entry($database);
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
            `status`)
            VALUES
            ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
            $database -> real_escape_string($this -> reservationID),
            $database -> real_escape_string($this -> date),
            $database -> real_escape_string($this -> startingTime),
            $database -> real_escape_string($this -> endingTime),
            $database -> real_escape_string($this -> noOfPeople),
            $database -> real_escape_string($this -> paymentAmount),
            $database -> real_escape_string($this -> sportCourt),
            $database -> real_escape_string($this -> userID),
            $database -> real_escape_string($this -> status));
            //print_r($sql);

            $result = $database -> query($sql);
            return $result;
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

        public function getDetails($database){
            $sql = sprintf("SELECT `r`.*,
            `b`.`city` AS `branch`,
            `s`.`sportName` as `sport`,
            `sc`.`courtName`
            FROM `reservation` `r`
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

        public function getReservedBranch($database){  //get the branch id of the reserved court that belongs to the reservation
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

            $result -> free_result();
            unset($resultObj);
            return $branchID;
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
