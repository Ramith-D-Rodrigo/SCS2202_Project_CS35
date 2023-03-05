<?php
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staffMember.php");
    require_once("../../src/user/user.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/coach/coaching_session.php");
    require_once("../../src/general/actor.php");

class Receptionist extends Actor implements JsonSerializable , StaffMember{

    private $receptionistID;
    private $firstName;
    private $lastName;
    private $contactNum;
    private $joinDate;
    private $leaveDate;
    private $dateOfBirth;
    private $gender;
    private $branchID;
    private $staffRole;

    public function __construct($actor = null){
        if($actor !== null){
            $this -> userID = $actor -> getUserID();
            $this -> username = $actor -> getUsername();
        }
        require("dbconnection.php");   //get the user connection to the db
        $this -> connection = $connection;
    }

    public function setDetails($fName='', $lName='', $email='', $contactNo='', $dob='', $gender='', $uid='', $username='', $password='', $brID = ''){
        $this -> receptionistID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> gender = $gender;
        $this -> username = $username;
        $this -> password = $password;
        $this -> branchID = $brID;
        $this -> staffRole = 'receptionist';
    }

    public function getDetails($wantedColumns = []){
        $sql = "SELECT ";
        if(empty($wantedColumns)){
            $sql .= "*";
        }else{
            $sql .= implode(", ", $wantedColumns);
        }

        $sql .= sprintf(" FROM `staff`
        WHERE
        `staffID` = '%s'
        AND
        `staffRole` = 'receptionist'",
        $this -> connection -> real_escape_string($this -> userID));

        $result = $this -> connection -> query($sql);
        $row = $result -> fetch_object();

        foreach($row as $key => $value){
            $this -> $key = $value;
        }

        return $this;
    }

    public function getReceptionistID(){    //receptionistID getter
        return $this -> receptionistID;
    }

    private function create_login_details_entry($database){   //enter details to the login_details table
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`userID`,
        `username`,
        `emailAddress`,
        `password`,
        `userRole`,
        `isActive`)
        VALUES
        ('%s','%s','%s','%s','receptionist',1)",
        $database -> real_escape_string($this -> receptionistID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> password)));

/*         if ($result === TRUE) {
            echo "New log in details record created successfully<br>";
        }
        else{
            echo "Error<br>";
        } */
        return $result;
    }

    private function create_staff_entry($database){  //enter details to the staff table

        $result = $database -> query(sprintf("INSERT INTO `staff`
        (`staffID`,
        `contactNum`,
        `gender`,
        `dateOfBirth`,
        `firstName`,
        `lastName`,
        `joinDate`,
        `leaveDate`,
        `branchID`,
        `staffRole`)
        VALUES
        ('%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), '%s','%s')",
        $database -> real_escape_string($this -> receptionistID),
        $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($this -> gender),
        $database -> real_escape_string($this -> dateOfBirth),
        $database -> real_escape_string($this -> firstName),
        $database -> real_escape_string($this -> lastName),
        $database -> real_escape_string($this -> joinDate),
        $database -> real_escape_string($this -> leaveDate),
        $database -> real_escape_string($this -> branchID),
        $database -> real_escape_string($this -> staffRole)));

        return $result;
    }

    private function create_receptionist_entry($database) {
        $sql = sprintf("INSERT INTO `receptionist` (`receptionistID`)
        VALUES ('%s')",
        $database -> real_escape_string($this -> receptionistID));

        $result = $database->query($sql);

        return $result;
    }

    public function register($database){    //public function to register the user
        $this -> joinDate = date("Y-m-d");
        $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        $staffEntry = $this -> create_staff_entry($database);
        $receptionistEntry = $this -> create_receptionist_entry($database);

        if($loginEntry  === TRUE && $staffEntry  === TRUE && $receptionistEntry === TRUE){    //all has to be true (successfully registered)
            return TRUE;
        }
    }

    public function getSessionData(){

        $getBranch = sprintf("SELECT `branchID` AS brid
        FROM `staff`
        WHERE `staffID` = '%s'",
        $this-> connection -> real_escape_string($this -> userID));

        $brResult = $this-> connection -> query($getBranch);

        $branchIDResult = $brResult -> fetch_object();   //get the branch_id
        $this -> branchID = $branchIDResult -> brid;

        $getBrName = sprintf("SELECT `city`
        FROM `branch`
        WHERE `branchID` = '%s'",
        $this->connection -> real_escape_string($this -> branchID));

        $brNameResult = $this->connection -> query($getBrName);

        $branchName = $brNameResult -> fetch_object();   //get the branch_city

        return [$branchName -> city, $this -> branchID];  //return the branch name and id
    }

    public function branchMaintenance($reason,$startDate,$endDate,$brID,$stfID,$database) {
        $branchQuery = sprintf("INSERT INTO `branch_maintenance`
        (`branchID`,
        `startingDate`,
        `endingDate`,
        `status`,
        `message`,
        `decision`,
        `requestedReceptionist`) VALUES
        ('%s','%s','%s','pending','%s','p','%s')",
        $database -> real_escape_string($brID),
        $database -> real_escape_string($startDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($reason),
        $database -> real_escape_string($stfID));

        $results = $database -> query($branchQuery);

        return $results;
    }
    public function reqMaintenance($reason,$sportName,$courtName,$startDate,$endDate,$stfID,$database) {

        $crtID = sprintf("SELECT `sports_court`.`courtID` AS court_id
        from `sports_court` INNER JOIN
        `sport` ON
        `sports_court`.`sportID` = `sport`.`sportID` INNER JOIN
        `staff` ON
        `sports_court`.`branchID` = `staff`.`branchID`
        WHERE `staff`.`staffID` = '%s'
        AND `sports_court`.`courtName` = '%s'
        AND `sport`.`sportName`= '%s'
        AND `sports_court`.`requestStatus`='a'",
        $database -> real_escape_string($stfID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($sportName));

        $crtIDRes = $database -> query($crtID);
        $crtIDResult = $crtIDRes -> fetch_object();
        $courtID = $crtIDResult -> court_id;             //get the court id

        $courtQuery = sprintf("INSERT INTO `court_maintenance`
        (`courtID`,
        `startingDate`,
        `endingDate`,
        `status`,
        `message`,
        `decision`,
        `requestedReceptionist`) VALUES
        ('%s','%s','%s','pending','%s','p','%s')",
        $database -> real_escape_string($courtID),
        $database -> real_escape_string($startDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($reason),
        $database -> real_escape_string($stfID));

        $results = $database -> query($courtQuery);
        // if ($results === TRUE) {
        //     echo "Request Submitted Successfully<br>";
        // }
        // else{
        //     echo "Error<br>";
        // }
        return $results;
    }

    public function editBranch($stafID,$branchID,$database) {

        $branchSql = sprintf("SELECT DISTINCT `city` AS location,
        `branchEmail` AS email
        from `branch` WHERE `branchID` = '%s'",
        $database -> real_escape_string($branchID));

        $branchResult = $database -> query($branchSql);   //get the branch results

        $row = $branchResult -> fetch_object();   //get the branch details

        $branchLoc = $row -> location;
        $branchEmail = $row -> email;

        $branchNum = sprintf("SELECT DISTINCT `contactNum` AS contact_number
        from `staff`
        WHERE `staff`.`branchID` = '%s' AND `staff`.`leaveDate` is NULL",
        $database -> real_escape_string($branchID));

        $numResult = $database -> query($branchNum);   //get the branch contact numbers


        $numArray = [];
        while($row = $numResult -> fetch_object()){   //get the branch numbers one by one
            $number = $row -> contact_number;
            array_push($numArray,$number);
        }

        $branchPhotos = sprintf("SELECT  `photo`
        from `branch_photo`
        WHERE `branchID` = '%s'",
        $database -> real_escape_string($branchID));

        $photoResult = $database -> query($branchPhotos);   //get the branch photos


        $photoArray = [];
        while($row = $photoResult -> fetch_object()){   //get the photos one by one
            $photo = $row -> photo;
            array_push($photoArray,$photo);
        }

        $result = [];

        array_push($result,$branchLoc,$branchEmail,$numArray,$photoArray);

        return $result;
    }

    public function getAllSports($branchID,$database) {
        $branch = new Branch($branchID);
        $sportObjects = $branch -> offeringSports($database);
        $sportNames = [];
        foreach($sportObjects as $sportObject){
            array_push($sportNames,$sportObject -> getDetails($database,['sportName']));
        }
        return $sportNames;
    }

    // public function getAllCourts($branchID,$database) {
    //     $branch = new Branch($branchID);
    //     $courtNames = $branch -> getBranchCourts($database,);

    //     return $courtNames;
    // }

    public function getAvailableCourts($branchID,$sportID,$database) {
        $branch = new Branch($branchID);
        $sport  = new Sport();
        $sport ->setID($sportID);
        $courts = $branch -> getBranchCourts($database,$sport,'a');
        $courtNames = [];
        foreach($courts as $court){
            array_push($courtNames,$court -> getName($database));
        }
        return $courtNames;
    }

    public function getUserProfiles($database) {
        $userProResult = $database -> query("SELECT `userID`,`firstName`,`lastName`,`contactNum`,`profilePhoto` FROM `user`");
        $profileResult = [];
        while($row = $userProResult->fetch_object()){   //get profiles one by one
            array_push($profileResult,['id' => $row->userID,'fName' => $row->firstName,'lName' => $row ->lastName, 'contactN' => $row -> contactNum, 'profile' => $row->profilePhoto]);
        }

        return $profileResult;
    }

    public function getWantedUserProfile($userID,$database) {
        $findUser = sprintf("SELECT * FROM `user` WHERE `userID` = '%s'",
        $database -> real_escape_string($userID));

        $user = $database -> query($findUser) -> fetch_Object() ;  //get the user id of the particular user
        // $user = new User('uid:$userID');
        // $user = $user -> getProfileDetails($database);
        $medicalConcernsSql = sprintf("SELECT `medicalConcern` FROM `user_medical_concern` WHERE `userID` = '%s'",
        $database -> real_escape_string($user -> userID)); //medical concerns

        $medicalConcernResult = $database -> query($medicalConcernsSql);
        $medicalConcernsArr = $medicalConcernResult -> fetch_all(MYSQLI_ASSOC);

        $dependentsSql = sprintf("SELECT `name`,`relationship`,`contactNum` FROM `user_dependent` WHERE `ownerID` = '%s'",
        $database -> real_escape_string($user -> userID)); //user dependents

        $dependentResult = $database -> query($dependentsSql);
        $dependentArr = $dependentResult -> fetch_all(MYSQLI_ASSOC);

        $allInfo = [];
        array_push($allInfo,$user,$medicalConcernsArr,$dependentArr);

        return $allInfo;
    }

    public function getUserDependentInfo($userID,$name,$database){
        // $user  = new User();
        // $user -> setDetails(uid:$userID);
        // $user -> getProfileDetails();
        // $dependents = $user -> dependents;
        $userDependentsSql = sprintf("SELECT `name`,`relationship`,`contactNum` from `user_dependent` WHERE `ownerID` = '%s' AND `name` = '%s'",
        $database -> real_escape_string($userID),
        $database -> real_escape_string($name));
        $dependentInfo = $database -> query($userDependentsSql) -> fetch_object();
        $depInfo = [];
        array_push($depInfo,['Name'=>$dependentInfo->name,'Relationship'=>$dependentInfo->relationship,'contactN'=>$dependentInfo->contactNum]);
        
        return $depInfo;
    }

    public function getCoachProfiles($database){
        $coachProResult = $database -> query("SELECT `c`.`coachID`,`c`.`firstName`,`c`.`lastName`,`c`.`contactNum`,`c`.`photo`,`s`.`sportName` FROM `coach` `c` 
        INNER JOIN `sport` `s` ON `c`.`sport` = `s`.`sportID`");    //get the coach profile details and sport name

        $profileResult = [];
        while($row = $coachProResult->fetch_object()){   //get profiles one by one
            array_push($profileResult,['coachID' => $row->coachID,'fName' => $row->firstName,'lName' => $row ->lastName, 'sport' => $row ->sportName, 'contactN' => $row -> contactNum, 'profilePhoto' => $row->photo]);
        }

        return $profileResult;
    }

    public function getWantedCoachProfile($coachID,$branchID,$database){

        $coach = new Coach();
        $coach -> setDetails(uid:$coachID);
        $coachProfileQuery = sprintf("SELECT `c`.*,`l`.`emailAddress`,`s`.`sportName` FROM `coach` `c` 
        INNER JOIN `login_details` `l` ON `c`.`coachID` = `l`.`userID`
        INNER JOIN `sport` `s` ON `c`.`sport` = `s`.`sportID` 
        WHERE `c`.`coachID` = '%s'",
        $database -> real_escape_string($coachID));
        $coachProfile = $database -> query($coachProfileQuery) -> fetch_object();   //get the coach profile details
        
        $qualificationsql = sprintf("SELECT `qualification` FROM `coach_qualification` WHERE `coachID` = '%s'",
        $database -> real_escape_string($coachID)); //get the coach qualifications
        $qualificationArr = $database -> query($qualificationsql) -> fetch_all(MYSQLI_ASSOC);
        

        $coachingSessionsql = sprintf("SELECT `sessionID` FROM `coaching_session` WHERE `coachID` = '%s'",
        $database -> real_escape_string($coachID));
        $coachingSessions = $database -> query($coachingSessionsql);
        $sessionInfo = [];
        while($row = $coachingSessions -> fetch_object()){
            $sql = sprintf("SELECT * FROM coaching_session cs
            INNER JOIN sports_court c ON  `c`.`courtID` = `cs`.`courtID`
            INNER JOIN branch b ON `c`.`branchID` = `b`.`branchID`
            WHERE cs.sessionID = '%s' AND b.branchID = '%s'",
            $database -> real_escape_string($row -> sessionID),
            $database -> real_escape_string($branchID));
            $session = $database -> query($sql) -> fetch_object();
            array_push($sessionInfo,[$session->day,$session->startingTime,$session->endingTime]);
        }

        $rating = $coach -> getRating($database);
        $feedbackResults = $coach -> getFeedback($database);
        $feedbackArray = [];
        foreach($feedbackResults as $feedback){
            $stuID = $feedback -> stuID;
            $user = new User();
            $user -> setDetails(uid:$stuID);
            array_push($feedbackArray,[$feedback,$user -> getProfileDetails("firstName"),$user -> getProfileDetails("lastName")]);
        }
        $coachInfo = [];
        array_push($coachInfo,$coachProfile,$rating,$feedbackArray,$sessionInfo,$qualificationArr);
        return $coachInfo;
    }

    // public function getSeesionOnBranch($coachID,$branchName,$database){
    //     $coachingSessionsql = sprintf("SELECT `sessionID` FROM `coaching_session` WHERE `coachID` = '%s'",
    //     $database -> real_escape_string($coachID));
    //     $coachingSessions = $database -> query($coachingSessionsql);
    //     $sessionInfo = [];
    //     while($row = $coachingSessions -> fetch_object()){
    //         $session = new Coaching_Session($row -> sessionID);
    //         if($session -> getDetails($database,"branchName") === $branchName){
    //             $sTime = $session -> getDetails($database,"startingTime");
    //             $eTime = $session -> getDetails($database,"endingTime");
    //             $day = $session -> getDetails($database,"day");
    //             array_push($sessionInfo,[$day,$sTime,$eTime]);
    //         }  
    //     }
    //     return $sessionInfo;
    // }

    public function viewReservations($branchID,$database){
        
        $currentDate = date("Y-m-d"); //get the current date
        //get the user reservation details
        $uReservationSql = sprintf("SELECT `r`.`reservationID`,`r`.`startingTime`,`r`.`endingTime`,`r`.`noOfPeople`,`r`.`status`,`u`.`firstName`,`u`.`lastName`,`u`.`contactNum` ,`s`.`sportName`,
        `sc`.`courtName`
        FROM `reservation` `r`              
        INNER JOIN `user` `u` ON
        `r`.`userID` = `u`.`userID`
        INNER JOIN `sports_court` `sc`
        ON `sc`.`courtID` = `r`.`sportCourt`
        INNER JOIN `sport` `s`
        ON `sc`.`sportID` = `s`.`sportID`
        INNER JOIN `branch` `b`
        ON `b`.`branchID` = `sc`.`branchID`
        WHERE `b`.`branchID` = '%s' AND `r`.`date` = '%s'",
        $database -> real_escape_string($branchID),
        $database -> real_escape_string($currentDate));
        $userReservations = $database -> query($uReservationSql) -> fetch_all(MYSQLI_ASSOC);

        $currentDay = date("l"); //get the current day
        
        // echo $currentDate;
        // echo $currentDay;
        //get the coaching_session Details
        $permanentReservationsSql = sprintf("SELECT `p`.`sessionID`,`p`.`startingTime`,`p`.`endingTime`,`p`.`noOfStudents`,`s`.`sportName`,`sc`.`courtName`,`c`.`firstName`,`c`.`lastName`,`c`.`contactNum` FROM 
        `coaching_session` `p` INNER JOIN `sports_court` `sc` 
        ON `p`.`courtID` = `sc`.`courtID` INNER JOIN `branch` `b` 
        ON `sc`.`branchID` = `b`.`branchID` INNER JOIN `sport` `s` 
        ON `sc`.`sportID` = `s`.`sportID` INNER JOIN `coach` `c` 
        ON `p`.`coachID` = `c`.`coachID` 
        WHERE `b`.`branchID` = '%s' AND `p`.`noOfStudents` > 0 AND `p`.`day` = '%s'",
        $database -> real_escape_string($branchID),
        $database -> real_escape_string($currentDay));
        $permanentReservations = $database -> query($permanentReservationsSql) -> fetch_all(MYSQLI_ASSOC);
        
        foreach($permanentReservations as $row){
            array_push($userReservations,$row);   //push the permanent reservations to the same array
        }

        return $userReservations;
    }
    public function updateBranchEmail($branchID,$email,$database) {
        $branch = new Branch($branchID);
        $result = $branch -> updateBranchEmail($email,$database);

        return $result;
    }

    public function updateContactNumber($recepID,$number,$database){
        $updateSQL = sprintf("UPDATE `staff` SET `contactNum` = '%s' WHERE `staff`.`staffID` = '%s'",
        $database -> real_escape_string($number),
        $database -> real_escape_string($recepID));

        $result = $database -> query($updateSQL);
        return $result;
    }

    public function updateBranch($recepID,$branchID,$email,$number,$database){
        $updateEmail = $this -> updateBranchEmail($branchID,$email,$database);
        $updateNumber = $this -> updateContactNumber($recepID,$number,$database);

        if($updateEmail === TRUE && $updateNumber === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function handleReservation($reservationID,$decision,$database){
        $reservation = new Reservation();
        $reservation -> setID($reservationID);
        $result  = $reservation -> updateStatus($database,$decision);

        return $result;
    }
    public function jsonSerialize() : mixed {
        $classProperties = get_object_vars($this);

        $returnJSON = [];

        foreach($classProperties as $key => $value){
            if($key === 'connection'){
                continue;
            }

            if(isset($value)){
                $returnJSON[$key] = $value;
            }
        }

        return $returnJSON;
    }
}

?>
