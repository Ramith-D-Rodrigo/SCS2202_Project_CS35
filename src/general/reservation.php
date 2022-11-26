<?php
    require_once("uuid.php");

    class Reservation{
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

            $uid_bin = uuid_to_bin(($user_id), $database);
            $reserve_bin = uuid_to_bin(($this -> reservationID), $database);

            $sql = sprintf("UPDATE `reservation` 
            SET `status`='Cancelled'
            WHERE `reservation_id` = '%s' 
            AND `user_id` = '%s'",
            $database -> real_escape_string($reserve_bin),
            $database -> real_escape_string($uid_bin));

            $result = $database -> query($sql);

            return $result;
        }
    }
?>