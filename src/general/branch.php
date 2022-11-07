<?php
    class Branch{
        private $branchID;
        private $city;
        private $address;
        private $contactNum;
        private $email;
        private $manager;
        private $receptionist;

        function __construct($branch_binary_id){    //use the binary id to construct
            $this -> branchID = $branch_binary_id;
        }

        function getDetails($database){
            $sql = sprintf("SELECT * FROM `branch`
            WHERE 
            `branch_id` 
            LIKE '%s'", 
            $database -> real_escape_string($this -> branchID));
            $result =  $database -> query($sql);
            return $result;
        }

        function numOfSportCourts($sportID, $database){
            $sql = sprintf("SELECT COUNT(`court_id`) AS courtCount
            FROM
            `sports_court`
            WHERE 
            `branch_id`
            LIKE
            '%s' 
            AND 
            `sport_id`
            LIKE 
            '%s'", 
            $database -> real_escape_string($this -> branchID),
            $database -> real_escape_string($sportID));     //get the number of sports courts in a branch when the sport id is given

            $result = $database -> query($sql);
            return $result;
        }
    }

?>