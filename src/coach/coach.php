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
    private $birthday;
    private $qualifications;
    private $gender;
    private $photo;
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
        $this -> birthday = $dob;
        $this -> qualifications = $qualifications;
        $this -> username = $username;
        $this -> password = $password;
        $this -> gender = $gender;
        $this -> sport = $sport;
    }

    public function setProfilePic($profilePic){
        $this -> photo = $profilePic;
    }

    public function getProfilePic(){
        return $this -> photo;
    }

    private function create_login_details_entry($database){   //first we createe the log in details entry
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`userID`, 
        `username`, 
        `password`,
        `emailAddress`, 
        `isActive`,
        `userRole`) 
        VALUES 
        ('%s','%s','%s','%s','%s','coach')",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> password),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> isActive),
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
        (`coachID`, 
        `firstName`, 
        `lastName`,
        `homeAddress`, 
        `birthday`, 
        `gender`, 
        `contactNum`, 
        `photo`,
         `sport`,
          `registerDate`)
           VALUES 
           ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
            $database -> real_escape_string($this -> userID),
            $database -> real_escape_string($this -> firstName),
            $database -> real_escape_string($this -> lastName),
            $database -> real_escape_string($this -> homeAddress),
            $database -> real_escape_string($this -> birthday),
            $database -> real_escape_string($this -> gender),
            $database -> real_escape_string($this -> contactNum),
            $database -> real_escape_string($this -> photo),
            $database -> real_escape_string($this -> sport),
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
                (`coachID`, 
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
        $this -> isActive = 1;
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
        `sc`.`courtID`, 
        `sc`.`courtName`, 
        `b`.`branchID`, 
        `b`.`city`, 
        `b`.`openingTime`, 
        `b`.`closingTime`, 
        `s`.`sportName`,
        `s`.`minCoachingSessionPrice`,
        `s`.`reservationPrice` ,
        `s`.`maxNoOfStudents`  
        FROM `sports_court` `sc`
        INNER JOIN  `branch` `b`
        ON `b`.`branchID` = `sc`.`branchID`
        INNER JOIN `sport` `s` 
        ON `s`.`sportID` = `sc`.`sportID`

        WHERE `s`.`sportID` = '%s'
        AND `b`.`requestStatus`= 'a' 
        AND `sc`.`requestStatus`='a'",
        $database -> real_escape_string($this -> sport));

        $result = $database -> query($sql);
        return $result;

       
    }

    public function getSessionDetail($database){
        $sql = sprintf("SELECT `cs`.`sessionID`, 
       `cs`.`startingTime`, 
       `cs`.`endingTime`,
       `cs`.`day`, 
       `cs`.`coachMonthlyPayment`, 
       `cs`.`noOfStudents`,
       `sc`.`courtName`, 
       `b`.`city` 
       FROM `coaching_session` `cs`
       INNER JOIN  `sports_court` `sc`
       ON `cs`.`courtID` = `sc`.`courtID`
       INNER JOIN `branch` `b` 
       ON `sc`.`branchID` = `b`.`branchID`
       INNER JOIN `coach` `c` 
       ON `c`.`coachID` = `cs`.`coachID`
       WHERE `c`.`coachID` = '%s'",
       $database -> real_escape_string($this ->userID));

       $result = $database -> query($sql);
       return $result;
    }
    public function getSport(){
        $sql = sprintf("SELECT `sport` FROM `coach` WHERE `coachID` = '%s'",    $this -> connection -> real_escape_string($this -> userID));
        $result = $this -> connection -> query($sql);
        $this -> sport = $result -> fetch_object() -> sport;
        $result -> free_result();
        return $this -> sport;
    }

    public function getAllSessions(){
        $sql = sprintf("SELECT sessionID, coachID, courtID FROM coaching_session WHERE coachID = '%s'",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);

        if($result -> num_rows == 0){    //no sessions
            return NULL;
        }

        //has sessions
        $sessionArr = [];   //to store the coaching sessions
        while($row = $result -> fetch_object()){
            $tempSession = new Coaching_Session($row -> sessionID, $row -> coachID, $row -> courtID);
            array_push($sessionArr, $tempSession);
            unset($tempSession);
            unset($row);
        }
        $result -> free_result();
        
        return $sessionArr;
    }

    public function addsession($sessionID,$coachMonthlyPayment, $startingTime, $endingTime, $noOfStudents,$coachID,$courtID,$day,$paymentAmount,$database){
        $startingTimeObj = new DateTime($startingTime);
        $endingTimeObj = new DateTime($endingTime);

        $timeDuration = $endingTimeObj -> diff($startingTimeObj);

        $hours = $timeDuration -> h;
        $minutes = $timeDuration -> i;

        $timePeriod = new DateTime();
        $timePeriod ->setTime($hours, $minutes);

        $sql = sprintf("INSERT INTO `coaching_session` 
        (`sessionID`, 
        `coachMonthlyPayment`, 
        `timePeriod`, 
        `noOfStudents`, 
        `coachID`, 
        `courtID`, 
        `day`, 
        `startingTime`, 
        `endingTime`, 
        `paymentAmount`) 
        VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        $database -> real_escape_string($sessionID),
        $database -> real_escape_string($coachMonthlyPayment),
        $database -> real_escape_string($timePeriod -> format("H:i:s")),
        $database -> real_escape_string($noOfStudents),
        $database -> real_escape_string($coachID),
        $database -> real_escape_string($courtID),
        $database -> real_escape_string($day),
        $database -> real_escape_string($startingTime),
        $database -> real_escape_string($endingTime),
        $database -> real_escape_string($paymentAmount));

        $result = $database -> query($sql);
        return $result;
    } // public function coachFeedback($database){
 
        // $sql = sprintf("SELECT `fi`.`feedback_id` 
        //     (`d`.`description`, 
        //     `r`.`rating`, 
        //     `ci`.`coach_id`, 
        //     `si`.`stu_id`) 
        //     VALUES ('%s', '%s', '%s', '%s', '%s')",
        //     $database -> real_escape_string($feedback_id),
        //     $database -> real_escape_string($description),
        //     $database -> real_escape_string($rating),
        //     $database -> real_escape_string($coach_id),
        //     $database -> real_escape_string($stu_id));
    
        //     $result = $database -> query($sql);
        //     return $result;


    public function getDetails($wantedProperty = ''){
        if($wantedProperty == ''){
            $sql = sprintf("SELECT `c`.*, `ld`.username, `ld`.emailAddress FROM coach c INNER JOIN login_details ld ON `ld`.`userID` = `c`.`coachID` WHERE coachID = '%s'",
            $this -> connection -> real_escape_string($this -> userID));
    
            $result = $this -> connection -> query($sql);

            //use foreach to set object properties
            foreach($result -> fetch_object() as $key => $value){
                $this -> $key = $value;
            }
/*             $obj = $result -> fetch_object();
            $this -> firstName = $obj -> firstName;
            $this -> lastName = $obj -> lastName;
            $this -> homeAddress = $obj -> homeAddress;
            $this -> dateOfBirth = $obj -> birthday;
            $this -> gender = $obj -> gender;
            $this -> contactNum = $obj -> contactNum;
            $this -> emailAddress = $obj -> emailAddress;
            $this -> username = $obj -> username;
            $this -> sport = $obj -> sport;
            $this -> photo = $obj -> photo; */

            unset($obj);
            $result -> free_result();
            //get qualifications
            $sql = sprintf("SELECT `qualification` FROM `coach_qualification` WHERE `coachID` = '%s'",
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
            $sql = sprintf("SELECT `%s` FROM coach WHERE coachID = '%s'",
            $this -> connection -> real_escape_string($wantedProperty),
            $this -> connection -> real_escape_string($this -> userID));

            $result = $this -> connection -> query($sql);
            $obj = $result -> fetch_object();
            $result -> free_result();
            return $obj -> $wantedProperty;
        }        
    }

    public function getRating(){
        $sql = sprintf("SELECT AVG(`rating`) AS `rating` FROM `student_coach_feedback` WHERE `coachID` = '%s'",
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
        $sql = sprintf("SELECT `description`, `rating`, `date` FROM `student_coach_feedback` WHERE `coachID` = '%s' ORDER BY `date` DESC", 
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);

        $feedbackArr = [];
        if($result -> num_rows != 0){   //coach has feedback
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
        "birthday" => $this -> birthday,
        "sport" => $this -> sport,
        "qualifications" => $this -> qualifications,
        "profilePic" => $this -> photo
      ];
    }

    public function getProfileDetails($wantedProperty = ''){   //get the profile details and store in the object
        if($wantedProperty !== ''){ //when needed only single property
            $detailsSql = sprintf("SELECT `%s` FROM `coach` WHERE `coachID` = '%s'",
            $this -> connection -> real_escape_string($wantedProperty),
            $this -> connection -> real_escape_string($this -> userID)); //user details

            $result = $this -> connection -> query($detailsSql);
            $resultObj = $result -> fetch_object();
            $returnVal = $resultObj -> {$wantedProperty};
            $result -> free_result();
            unset($resultObj);
            return $returnVal;
            }
        }


}
?>