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

        public function getSchedule($database){
            $sql = sprintf("SELECT * FROM `reservation` 
            WHERE `sport_court` 
            LIKE %s",
            $database -> escape_real_string($this -> courtID));

            $result = $database -> query($sql);
            return $result;
        }

        public function makeReservation($database){

        }
    }

?>