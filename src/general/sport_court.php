<?php
    require_once("reservation.php");

    class Sports_Court{
        private $courtID;
        private $courtName;
        private $revenue;
        private $photo;
        private $branchID;
        private $sportID;
        private $requestStatus;
        private $addedManager;

        public function __construct($court_id){
            $this -> courtID = $court_id;
        }

        public function getSchedule($database){ //get the reservation schedule of a certain court
            $sql = sprintf("SELECT * FROM `reservation` 
            WHERE `sportCourt` 
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
            $sql = sprintf("SELECT `courtName` FROM `sports_court`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            return $result -> fetch_object() -> courtName;
        }

        public function createReservation($user, $date, $starting_time, $ending_time, $payment, $num_of_people, $database){
            $reservation = new Reservation();
            $result = $reservation -> onlineReservation($date, $starting_time, $ending_time, $num_of_people, $payment, $this -> courtID, $user, $database);
            unset($reservation);
            return $result;
        }

        public function getBranch($database){
            $sql = sprintf("SELECT `branchID` FROM `sports_court`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $branch = $result -> fetch_object() -> branchID;
            $result -> free_result();
            return $branch;
        }

        public function getSport($database){
            $sql = sprintf("SELECT `sportID` FROM `sports_court`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $sport = $result -> fetch_object() -> sportID;
            $result -> free_result();
            return $sport;
        }

        public function getStatus($database){
            $sql = sprintf("SELECT requestStatus FROM `sports_court` 
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);

            return $result -> fetch_object() -> requestStatus;
        }

        public function getPhotos($database){
            $sql = sprintf("SELECT `courtPhoto` FROM `sports_court_photo`
            WHERE `courtID`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            $photos = [];
            while($row = $result -> fetch_object()){
                array_push($photos, $row -> courtPhoto);
                unset($row);
            }
            $result -> free_result();
            return $photos;
        }
    }
?>