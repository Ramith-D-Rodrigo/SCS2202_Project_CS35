<?php
    class Reservation implements JsonSerializable{
        private $reservationID;
        private $date;
        private $startingTime;
        private $endingTime;
        private $numOfPeople;
        private $paymentAmount;
        private $sport_court;
        private $user_id;
        private $formal_manager_id;
        private $onsite_receptionist_id;
        private $status;     //pending //checked_in //cancelled //declined  //completed
        private $branch;
        private $sport;
        private $court_name;

        public function onlineReservation($date, $st, $et, $people, $payment, $court, $user, $database){
            $this -> user_id = $user;

            //unique id prefixes
            $prefix1 = "Res-";
            $prefix2 = substr($this -> user_id, 0, 3);

            $this -> reservationID = uniqid($prefix1.$prefix2);
            
            $this -> date = $date;
            $this -> startingTime = $st;
            $this -> endingTime = $et;
            $this -> numOfPeople = $people;
            $this -> paymentAmount = $payment;
            $this -> sport_court = $court;

            $this -> status = 'Pending';
            $this -> formal_manager_id = '';
            $this -> onsite_receptionist_id = '';
            $queryResult = $this -> create_online_reservation_entry($database);
            return $queryResult;
        }

        private function create_online_reservation_entry($database){
            //echo"<br>";
            $sql = sprintf("INSERT INTO `reservation`
            (`reservation_id`, 
            `date`, 
            `starting_time`, 
            `ending_time`, 
            `no_of_people`, 
            `payment_amount`, 
            `sport_court`, 
            `user_id`,
            `status`) 
            VALUES 
            ('%s','%s','%s','%s','%s','%s','%s','%s','%s')", 
            $database -> real_escape_string($this -> reservationID),
            $database -> real_escape_string($this -> date),
            $database -> real_escape_string($this -> startingTime),
            $database -> real_escape_string($this -> endingTime),
            $database -> real_escape_string($this -> numOfPeople),
            $database -> real_escape_string($this -> paymentAmount),
            $database -> real_escape_string($this -> sport_court),
            $database -> real_escape_string($this -> user_id),
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
            WHERE `reservation_id` = '%s' 
            AND `user_id` = '%s'",
            $database -> real_escape_string($this -> reservationID),
            $database -> real_escape_string($user_id));

            $result = $database -> query($sql);

            return $result;
        }

        public function getDetails($database){
            $sql = sprintf("SELECT `r`.*,
            `b`.`city`, 
            `s`.`sport_name`,
            `sc`.`court_name`  
            FROM `reservation` `r`
            INNER JOIN `sports_court` `sc`
            ON `sc`.`court_id` = `r`.`sport_court`
            INNER JOIN `sport` `s`
            ON `sc`.`sport_id` = `s`.`sport_id`
            INNER JOIN `branch` `b`
            ON `b`.`branch_id` = `sc`.`branch_id`
            WHERE `reservation_id` = '%s'",
            $database -> real_escape_string($this -> reservationID));

            $result = $database -> query($sql);

            $resultObj = $result -> fetch_object();
            
            $this -> date = $resultObj -> date;
            $this -> startingTime = $resultObj -> starting_time;
            $this -> endingTime = $resultObj -> ending_time;
            $this -> numOfPeople = $resultObj -> no_of_people;
            $this -> paymentAmount = $resultObj -> payment_amount;
            $this -> sport_court = $resultObj -> sport_court;
            $this -> status = $resultObj -> status;
            $this -> user_id = $resultObj -> user_id;
            $this -> formal_manager_id = $resultObj -> formal_manager_id;
            $this -> onsite_receptionist_id = $resultObj -> onsite_receptionist_id;
            $this -> branch = $resultObj -> city;
            $this -> sport = $resultObj -> sport_name;
            $this -> court_name = $resultObj -> court_name;

            $result -> free_result();
            unset($resultObj);
            return $this;
        }
        public function JsonSerialize():mixed{
            return [
                "reservationID" => $this -> reservationID,
                "date" => $this -> date,
                "startingTime" => $this -> startingTime,
                "endingTime" => $this -> endingTime,
                "numOfPeople" => $this -> numOfPeople,
                "paymentAmount" => $this -> paymentAmount,
                "sport_court" => $this -> sport_court,
                "user_id" => $this -> user_id,
                "formal_manager_id" => $this -> formal_manager_id,
                "onsite_receptionist_id" => $this -> onsite_receptionist_id,
                "status" => $this -> status,     //pending //checked_in //cancelled //declined  //completed
                "branch" => $this -> branch,
                "sport" => $this -> sport,
                "court_name" => $this -> court_name
            ];
        }
    }
?>