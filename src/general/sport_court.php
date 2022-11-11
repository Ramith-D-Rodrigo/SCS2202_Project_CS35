<?php
    //make sure to use UUID FUNCTIONS
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
            return $result;
        }

        public function getName($database){ // Get sports court name
            $sql = sprintf("SELECT `court_name` FROM `sports_court`
            WHERE `court_id`
            LIKE '%s'",
            $database -> real_escape_string($this -> courtID));

            $result = $database -> query($sql);
            return $result -> fetch_object() -> court_name;
        }

        public function makeReservation($database){

        }
    }

?>