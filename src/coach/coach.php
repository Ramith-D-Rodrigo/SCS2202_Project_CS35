<?php
    require_once("../../src/general/actor.php");
    require_once("../../src/general/sport.php");
    require_once("coaching_session.php");
class Coach extends Actor implements JsonSerializable{
    private $firstName;
    private $lastName;
    private $homeAddress;
    private $contactNum;
    private $registeredDate;
    private $dateOfBirth;
    private $qualifications;
    private $gender;
    private $isactive;
    private $profilePic;
    private $sportID;
    private $sport;

    public function __construct($actor = null){
        if($actor !== null){
            $this -> userID = $actor -> getUserID();
            $this -> username = $actor -> getUsername();
        }
        require("dbconnection.php");   //get the user connection to the db
        $this -> connection = $connection;
    }

    public function setDetails($fName='', $lName='', $email='', $address='', $contactNo='', $dob='', $uid='',$qualifications='', $username='', $password='', $gender='',$sport=''){
        $this -> userID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> homeAddress = $address;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> qualifications = $qualifications;
        $this -> username = $username;
        $this -> password = $password;
        $this -> gender = $gender;
        $this -> sportID = $sport;
    }

    public function setProfilePic($profilePic){
        $this -> profilePic = $profilePic;
    }

    public function getProfilePic(){
        return $this -> profilePic;
    }

    private function create_login_details_entry($database){   //first we createe the log in details entry
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`user_id`, 
        `username`, 
        `password`,
        `email_address`, 
        `is_active`,
        `user_role`) 
        VALUES 
        ('%s','%s','%s','%s','%s','coach')",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> password),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> isactive),
    )); 

/*         if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
        return $result;
    }

    private function create_coach_entry($database){  //Create entry in coach table
       $result = $database -> query(sprintf("INSERT INTO `coach`
        (`coach_id`, 
        `first_name`, 
        `last_name`,
        `home_address`, 
        `birthday`, 
        `gender`, 
        `contact_num`, 
        `photo`,
         `sport`,
          `register_date`)
           VALUES 
           ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
            $database -> real_escape_string($this -> userID),
            $database -> real_escape_string($this -> firstName),
            $database -> real_escape_string($this -> lastName),
            $database -> real_escape_string($this -> homeAddress),
            $database -> real_escape_string($this -> dateOfBirth),
            $database -> real_escape_string($this -> gender),
            $database -> real_escape_string($this -> contactNum),
            $database -> real_escape_string($this -> profilePic),
            $database -> real_escape_string($this -> sportID),
            $database -> real_escape_string($this -> registeredDate)));
       

        return $result;
/*         if ($result === TRUE) {
            echo "New user record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
   
    }

    private function create_coach_qualifications($database){
        $flag = TRUE;
        if(count($this -> qualifications) != 0){   //has qualifications
            foreach($this -> qualifications as $i){
                $result = $database -> query(sprintf("INSERT INTO `coach_qualification`
                (`coach_id`, 
                `qualification`) 
                VALUES 
                ('%s','%s')", 
                $database -> real_escape_string($this -> userID),
                $database -> real_escape_string($i)));

                if ($result === FALSE) {    //got an error
                    return FALSE;
                }
            }
        }
        return $flag;
    }

    public function registercoach($database){    //public function to register the coach
        $this -> registeredDate = date("Y-m-d");
        $this -> isactive = 1;
        $loginEntry = $this -> create_login_details_entry($database);
        if( $loginEntry===false){
            return false;
        }
        $userEntry = $this -> create_coach_entry($database);
        if( $userEntry===false){
            return false;
        }
        $qualificationsEntry = $this -> create_coach_qualifications($database); 
        if( $qualificationsEntry===false){
            return false;
        }
        

        if($loginEntry  === TRUE && $userEntry  === TRUE && $qualificationsEntry  === TRUE ){   
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function getBranchesWithCourts($database){
         $sql = sprintf("SELECT  
        `sc`.`court_id`, 
        `sc`.`court_name`, 
        `b`.`branch_id`, 
        `b`.`city`, 
        `b`.`opening_time`, 
        `b`.`closing_time`, 
        `s`.`sport_name`,
        `s`.`min_coaching_session_price`,
        `s`.`reservation_price` ,
        `s`.`max_no_of_students`  
        FROM `sports_court` `sc`
        INNER JOIN  `branch` `b`
        ON `b`.`branch_id` = `sc`.`branch_id`
        INNER JOIN `sport` `s` 
        ON `s`.`sport_id` = `sc`.`sport_id`

        WHERE `s`.`sport_id` = '%s'
        AND `b`.`request_status`= 'a' 
        AND `sc`.`request_status`='a'",
        $database -> real_escape_string($this -> sportID));

        $result = $database -> query($sql);
        return $result;

       
    }

    public function getSessionDetail($database){
        $sql = sprintf("SELECT `cs`.`session_id`, 
       `cs`.`starting_time`, 
       `cs`.`ending_time`,
       `cs`.`day`, 
       `cs`.`coach_monthly_payment`, 
       `cs`.`no_of_students`,
       `sc`.`court_name`, 
       `b`.`city` 
       FROM `coaching_session` `cs`
       INNER JOIN  `sports_court` `sc`
       ON `cs`.`court_id` = `sc`.`court_id`
       INNER JOIN `branch` `b` 
       ON `sc`.`branch_id` = `b`.`branch_id`
       INNER JOIN `coach` `c` 
       ON `c`.`coach_id` = `cs`.`coach_id`
       WHERE `c`.`coach_id` = '%s'",
       $database -> real_escape_string($this ->userID));

       $result = $database -> query($sql);
       return $result;
    }
    public function getSport(){

        return $this->sportID;
    }

    public function getAllSessions(){
        $sql = sprintf("SELECT session_id, coach_id, court_id FROM coaching_session WHERE coach_id = '%s'",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);

        if($result == NULL){    //no sessions
            return NULL;
        }

        //has sessions
        $sessionArr = [];   //to store the coaching sessions
        while($row = $result -> fetch_object()){
            $tempSession = new Coaching_Session($row -> session_id, $row -> coach_id, $row -> court_id);
            array_push($sessionArr, $tempSession);
            unset($tempSession);
            unset($row);
        }
        $result -> free_result();
        
        return $sessionArr;
    }

    public function addsession($sessionID,$coach_monthly_payment, $startingTime, $endingTime, $no_of_students,$coach_id,$court_id,$day,$payment_amount,$database){
        $startingTimeObj = new DateTime($startingTime);
        $endingTimeObj = new DateTime($endingTime);

        $timeDuration = $endingTimeObj -> diff($startingTimeObj);

        $hours = $timeDuration -> h;
        $minutes = $timeDuration -> i;

        $timePeriod = new DateTime();
        $timePeriod ->setTime($hours, $minutes);

        $sql = sprintf("INSERT INTO `coaching_session` 
        (`session_id`, 
        `coach_monthly_payment`, 
        `time_period`, 
        `no_of_students`, 
        `coach_id`, 
        `court_id`, 
        `day`, 
        `starting_time`, 
        `ending_time`, 
        `payment_amount`) 
        VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        $database -> real_escape_string($sessionID),
        $database -> real_escape_string($coach_monthly_payment),
        $database -> real_escape_string($timePeriod -> format("H:i:s")),
        $database -> real_escape_string($no_of_students),
        $database -> real_escape_string($coach_id),
        $database -> real_escape_string($court_id),
        $database -> real_escape_string($day),
        $database -> real_escape_string($startingTime),
        $database -> real_escape_string($endingTime),
        $database -> real_escape_string($payment_amount));

        $result = $database -> query($sql);
        return $result;
    }

    public function getDetails($wantedProperty = ''){
        if($wantedProperty == ''){
            $sql = sprintf("SELECT `c`.*, `ld`.username, `ld`.email_address FROM coach c INNER JOIN login_details ld ON `ld`.`user_id` = `c`.`coach_id` WHERE coach_id = '%s'",
            $this -> connection -> real_escape_string($this -> userID));
    
            $result = $this -> connection -> query($sql);
            $obj = $result -> fetch_object();
            $this -> firstName = $obj -> first_name;
            $this -> lastName = $obj -> last_name;
            $this -> homeAddress = $obj -> home_address;
            $this -> dateOfBirth = $obj -> birthday;
            $this -> gender = $obj -> gender;
            $this -> contactNum = $obj -> contact_num;
            $this -> emailAddress = $obj -> email_address;
            $this -> username = $obj -> username;
            $this -> sportID = $obj -> sport;
            $this -> profilePic = $obj -> photo;

            unset($obj);
            $result -> free_result();
            //get qualifications
            $sql = sprintf("SELECT `qualification` FROM `coach_qualification` WHERE `coach_id` = '%s'",
            $this -> connection -> real_escape_string($this -> userID));

            $result = $this -> connection -> query($sql);
            $this -> qualifications = array();
            while($obj = $result -> fetch_object()){
                array_push($this -> qualifications, $obj -> qualification);
                unset($obj);
            }
            $result -> free_result();
            return $this;

        }
        else{
            $sql = sprintf("SELECT `%s` FROM coach WHERE coach_id = '%s'",
            $this -> connection -> real_escape_string($wantedProperty),
            $this -> connection -> real_escape_string($this -> userID));

            $result = $this -> connection -> query($sql);
            $obj = $result -> fetch_object();
            $result -> free_result();
            return $obj -> $wantedProperty;
        }        
    }

    public function getRating(){
        $sql = sprintf("SELECT AVG(`rating`) AS `rating` FROM `student_coach_feedback` WHERE `coach_id` = '%s'",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);
        $obj = $result -> fetch_object();
        $result -> free_result();
        $rating = $obj -> rating;

        if($rating === null){
            return 0;
        }
        unset($obj);
        return $rating;
    }

    
    public function getFeedback(){
        $sql = sprintf("SELECT `description`, `rating` FROM student_coach_feedback WHERE `coach_id` = '%s'", 
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);

        $feedbackArr = [];
        if($result !== NULL){   //coach has feedback
            while($row = $result -> fetch_object()){
                array_push($feedbackArr, $row);
                unset($row);
            }
        }

        $result -> free_result();
        return $feedbackArr;
    }

    public function jsonSerialize() : mixed{
      return [
        "coachID" => $this -> userID,
        "username" => $this -> username,
        "emailAddress" => $this -> emailAddress,
        "firstName" => $this -> firstName,
        "lastName" => $this -> lastName,
        "gender" => $this -> gender,
        "contactNum" => $this -> contactNum,
        "homeAddress" => $this -> homeAddress,
        "sport" => $this -> sport
      ];
    }
}


