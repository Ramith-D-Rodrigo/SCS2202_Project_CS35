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
            $this -> reservationID = generateUUID($database);
            $this -> date = $date;
            $this -> startingTime = $st;
            $this -> endingTime = $et;
            $this -> numOfPeople = $people;
            $this -> paymentAmount = $payment;
            $this -> sport_court = $court;
            $this -> user_id = $user;
            $this -> status = 'Pending';
            $this -> formal_manager_id = '';
            $this -> onsite_receptionist_id = '';
            $queryResult = $this -> create_online_reservation_entry($database);
            return $queryResult;
        }

        private function create_online_reservation_entry($database){
            $reserve_bin = uuid_to_bin($this -> reservationID, $database);
            $court_bin = uuid_to_bin($this -> sport_court, $database);
            $user_bin = uuid_to_bin($this -> user_id, $database);
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
            $database -> real_escape_string($reserve_bin),
            $database -> real_escape_string($this -> date),
            $database -> real_escape_string($this -> startingTime),
            $database -> real_escape_string($this -> endingTime),
            $database -> real_escape_string($this -> numOfPeople),
            $database -> real_escape_string($this -> paymentAmount),
            $database -> real_escape_string($court_bin),
            $database -> real_escape_string($user_bin),
            $database -> real_escape_string($this -> status));
            //print_r($sql);

            $result = $database -> query($sql);
            return $result;
        }
    }
?>