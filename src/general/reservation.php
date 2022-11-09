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
            (UUID_TO_BIN('%s', true),'%s','%s','%s','%s','%s',UUID_TO_BIN('%s', true),UUID_TO_BIN('%s', true),'%s')", 
            $this -> reservationID,
            $this -> date,
            $this -> startingTime,
            $this -> endingTime,
            $this -> numOfPeople,
            $this -> paymentAmount,
            $this -> sport_court,
            $this -> user_id,
            $this -> status);
            //print_r($sql);

            $result = $database -> query($sql);
            return $result;
        }
    }
?>