<?php
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staffMember.php");
    require_once("../../src/user/user.php");
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

    public function getDetails($database){
        $sql = sprintf("SELECT * FROM `staff`
        WHERE
        `staffID` = '%s'
        AND
        `staffRole` = 'receptionist'",
        $database -> real_escape_string($this -> receptionistID));

        $result = $database -> query($sql);
        $row = $result -> fetch_object();

        if($row === NULL){
            return FALSE;
        }

        $this -> setDetails(fName: $row -> firstName, 
            lName: $row -> lastName,
            contactNo: $row -> contactNum,
            dob: $row -> dateOfBirth,
            brID: $row -> branchID,
            gender: $row -> gender);

        $this -> joinDate = $row -> joinDate;
        $this -> leaveDate = $row -> leaveDate;
        $this -> staffRole = $row -> staffRole;

        $result -> free_result();
        unset($row);
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
        $courtID = $crtIDResult -> courtID;             //get the court id

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

    public function editBranch($staffID,$branchID,$database) {

        $branchSql = sprintf("SELECT DISTINCT `branch`.`city` AS location,
        `branch`.`branchEmail` AS email
        from `branch` INNER JOIN `staff` ON
        `branch`.`branchID` = `staff`.`branchID`
        WHERE `staff`.`branchID` = '%s'",
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
            $number = $row -> contactNum;
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
        $sportNames = $branch -> getAllSports($database);

        return $sportNames;
    }

    public function getAllCourts($branchID,$database) {
        $branch = new Branch($branchID);
        $courtNames = $branch -> getAllCourts($database);

        return $courtNames;
    }

    public function getAvailableCourts($branchID,$sportID,$database) {
        $branch = new Branch($branchID);
        $courtNames = $branch -> getSportCourtNames($sportID, $database);

        return $courtNames;
    }

    public function getUserProfiles($database) {
        $userProResult = $database -> query("SELECT `firstName`,`lastName`,`contactNum`,`profilePhoto` FROM `user`");
        $profileResult = [];
        while($row = $userProResult->fetch_object()){   //get profiles one by one
            array_push($profileResult,['fName' => $row->firstName,'lName' => $row ->lastName, 'contactN' => $row -> contactNum, 'profile' => $row->profilePhoto]);
        }

        return $profileResult;
    }

    public function getWantedUserProfile($fName,$lName,$contactN,$database) {
        $findUser = sprintf("SELECT * FROM `user` WHERE `firstName` = '%s'
        AND `lastName` = '%s' AND `contactNum` = '%s'",
        $database -> real_escape_string($fName),
        $database -> real_escape_string($lName),
        $database -> real_escape_string($contactN));

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
    public function jsonSerialize() : mixed {
        return [
            'receptionistID' => $this -> receptionistID,
            'firstName' => $this -> firstName,
            'lastName' => $this -> lastName,
            'emailAddress' => $this -> emailAddress,
            'contactNum' => $this -> contactNum,
            'joinDate' => $this -> joinDate,
            'leaveDate' => $this -> leaveDate,
            'dateOfBirth' => $this -> dateOfBirth,
            'username' => $this -> username,
            'password' => $this -> password,
            'gender' => $this -> gender,
            'branchID' => $this -> branchID,
            'staffRole' => $this -> staffRole
        ];

    }
}

?>
