<?php
    require_once("../../controller/CONSTANTS.php");

    class Notification implements JsonSerializable{
        private $notificationID;
        private $subject;
        private $status;
        private $description;
        private $date;
        private $lifetime;
        private $userID;
        private $readTimeStamp;

        public function __construct($notificationID){
            $this->notificationID = $notificationID;
        }

        public function setDetails($subject = '', $status = '', $description = '', $date ='', $lifetime ='', $userID ='', $reservationID ='', $readTimeStamp =''){
            $args = get_defined_vars();

            foreach($args as $key => $value){
                if($value != ''){
                    $this->$key = $value;
                }
            }
        }

        public function getID(){
            return $this -> notificationID;
        }

        public function setNotificationEntry($database){
            if(!isset($this -> lifetime)){
                $this -> lifetime = null;
            }

            if(!isset($this -> readTimeStamp)){
                $this -> readTimeStamp = null;
            }


            $sql = sprintf("INSERT INTO `notification` 
                (`notificationID`,`subject`, `status`, `description`, `date`, `lifetime`, `userID`, `readTimeStamp`) 
                VALUES ('%s', '%s', '%s', '%s', NULLIF('%s', ''), '%s', '%s', NULLIF('%s', ''), NULLIF('%s', ''))",
                $database -> real_escape_string($this -> notificationID),
                $database -> real_escape_string($this -> subject),
                $database -> real_escape_string($this -> status),
                $database -> real_escape_string($this -> description),
                $database -> real_escape_string($this -> date),
                $database -> real_escape_string($this -> lifetime),
                $database -> real_escape_string($this -> userID),
                $database -> real_escape_string($this -> readTimeStamp));

            $result = $database -> query($sql);

            return $result;
        }

        public function getDetails($database, $wantedColumns = []){
            $sql = "SELECT ";
            if(empty($wantedColumns)){
                $sql .= "*";
            }
            else{
                $sql .= implode(", ", $wantedColumns);
            }

            $sql .= sprintf(" FROM `notification` WHERE notificationID = '%s'", 
                $database -> real_escape_string($this->notificationID));

            $result = $database -> query($sql);

            $row = $result -> fetch_object();

            foreach($row as $key => $value){
                $this->$key = $value;
            }
            $result -> free_result();

            return $this;
        }

        public function markAsRead($database){
            date_default_timezone_set(SERVER_TIMEZONE);

            $sql = sprintf("UPDATE `notification` SET
                `readTimeStamp` = '%s',
                `status` = 'Read',
                `lifetime` = '%s'
                WHERE `notificationID` = '%s'",
                $database -> real_escape_string(date("Y-m-d H:i:s")),
                $database -> real_escape_string($this->lifetime),
                $database -> real_escape_string($this->notificationID));

            $result = $database -> query($sql);

            return $result;
        }

        public function deleteNotification($database){
            $sql = sprintf("DELETE FROM `notification` WHERE `notificationID` = '%s'",
                $database -> real_escape_string($this->notificationID));

            $result = $database -> query($sql);

            return $result;
        }

        public function jsonSerialize(): mixed{
            $objectProperties = get_object_vars($this);

            $returnJSON = array();

            foreach($objectProperties as $key => $value){
                if($value === null || $value === ''){
                    continue;
                }

                $returnJSON[$key] = $value;

            }
            
            return $returnJSON;
        }
    }
?>