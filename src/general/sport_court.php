<?php
    //make sure to use UUID FUNCTIONS
    require_once("reservation.php");

    class Sports_Court{
        private $courtID;
        private $courtName;
        private $revenue;
        private $photo;

        public function __construct($court_id){
            $this -> courtID = $court_id;
        }

        public function getSchedule($database){ //get the reservation schedule of a certain court
            $sql = sprintf("SELECT * FROM `reservation` 
            WHERE `sport_court` 
            LIKE '%s'
            ORDER BY `date`",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $reservations = [];
            while($row = $result -> fetch_object()){
                array_push($reservations, $row);
                unset($row);
            }
            $result -> free_result();
            return $reservations;
        }

        public function getName($database){ // Get sports court name
            $sql = sprintf("SELECT `court_name` FROM `sports_court`
            WHERE `court_id`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            return $result -> fetch_object() -> court_name;
        }

        public function createReservation($user, $date, $starting_time, $ending_time, $payment, $num_of_people, $database){
            $reservation = new Reservation();
            $result = $reservation -> onlineReservation($date, $starting_time, $ending_time, $num_of_people, $payment, $this -> courtID, $user, $database);
            unset($reservation);
            return $result;
        }

        public function getBranch($database){
            $sql = sprintf("SELECT `branch_id` FROM `sports_court`
            WHERE `court_id`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $branch = $result -> fetch_object() -> branch_id;
            $result -> free_result();
            return $branch;
        }

        public function getSport($database){
            $sql = sprintf("SELECT `sport_id` FROM `sports_court`
            WHERE `court_id`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $sport = $result -> fetch_object() -> sport_id;
            $result -> free_result();
            return $sport;
        }

        public function getStatus($database){
            $sql = sprintf("SELECT request_status FROM `sports_court` 
            WHERE `court_id`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);

            return $result -> fetch_object() -> request_status;
        }

        public function getPhotos($database){
            $sql = sprintf("SELECT `court_photo` FROM `sports_court_photo`
            WHERE `court_id`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $photos = [];
            while($row = $result -> fetch_object()){
                array_push($photos, $row -> court_photo);
                unset($row);
            }
            $result -> free_result();
            return $photos;
        }
    }
?>