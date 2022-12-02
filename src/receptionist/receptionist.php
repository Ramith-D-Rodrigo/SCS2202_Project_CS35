<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/general/sport_court.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staffMember.php");
    require_once("../../src/user/user.php");

class Receptionist implements StaffMember{
    private $receptionistID;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $contactNum;
    private $joinDate;
    private $leaveDate;
    private $dateOfBirth;
    private $username;
    private $password;
    private $gender;
    private $branchID;
    private $staffRole;


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

    public function getReceptionistID(){    //receptionistID getter
        return $this -> receptionistID;
    }

    private function create_login_details_entry($database){   //enter details to the login_details table
        $result = $database -> query(sprintf("INSERT INTO `login_details`
        (`user_id`,
        `username`,
        `email_address`,
        `password`,
        `user_role`,
        `is_active`)
        VALUES
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','receptionist',1)",
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
        (`staff_id`,
        `contact_number`,
        `gender`,
        `date_of_birth`,
        `first_name`,
        `last_name`,
        `join_date`,
        `leave_date`,
        `branch_id`,
        `staff_role`)
        VALUES
        (UUID_TO_BIN('%s', 1),'%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), UUID_TO_BIN('%s', 1), '%s')",
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
        $sql = sprintf("INSERT INTO `receptionist` (`receptionist_id`)
        VALUES (UUID_TO_BIN('%s',1))",
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

    public function login($username, $password, $database){
        $sql = sprintf("SELECT `user_id`
        `username`,
        `password`,
        `user_role`
        FROM `login_details`
        WHERE `username` = '%s'",
        $database -> real_escape_string($username));

        $result = $database -> query($sql);

        $rows = $result -> fetch_object();  //get the resulting row

        if($rows === NULL){ //no result. hence no user
            return ["No Such User Exists"];
        }

        $hash = $rows -> password;
        if(password_verify($password, $hash) === FALSE){    //Incorrect Password
            return ["Incorrect Password"];
        }

        //setting user data for session
        $this -> receptionistID = $rows -> user_id;

        $getBranch = sprintf("SELECT `branch_id` AS brid
        FROM `staff`
        WHERE `staff_id` = '%s'",
        $database -> real_escape_string($this -> receptionistID));

        $brResult = $database -> query($getBranch);

        $branchIDResult = $brResult -> fetch_object();   //get the branch_id
        $this -> branchID = $branchIDResult -> brid;

        $getBrName = sprintf("SELECT `city`
        FROM `branch`
        WHERE `branch_id` = '%s'",
        $database -> real_escape_string($this -> branchID));

        $brNameResult = $database -> query($getBrName);

        $branchName = $brNameResult -> fetch_object();   //get the branch_city

        return ["Successfully Logged In", $rows -> user_role, $branchName -> city, $this -> branchID, $rows -> username];  //return the message and other important details
    }

    public function branchMaintenance($reason,$startDate,$endDate,$brID,$stfID,$database) {
        $branchQuery = sprintf("INSERT INTO `branch_maintenance`
        (`branch_id`,
        `starting_date`,
        `ending_date`,
        `status`,
        `message`,
        `decision`,
        `requested_receptionist`) VALUES
        (UUID_TO_BIN('%s',1),'%s','%s','pending','%s','p',UUID_TO_BIN('%s',1))",
        $database -> real_escape_string($brID),
        $database -> real_escape_string($startDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($reason),
        $database -> real_escape_string($stfID));

        $results = $database -> query($branchQuery);

        return $results;
    }
    public function reqMaintenance($reason,$sportName,$courtName,$startDate,$endDate,$stfID,$database) {

        $crtID = sprintf("SELECT BIN_TO_UUID(`sports_court`.`court_id`,1) AS court_id
        from `sports_court` INNER JOIN
        `sport` ON
        `sports_court`.`sport_id` = `sport`.`sport_id` INNER JOIN
        `staff` ON
        `sports_court`.`branch_id` = `staff`.`branch_id`
        WHERE `staff`.`staff_id` = UUID_TO_BIN('%s',1)
        AND `sports_court`.`court_name` = '%s'
        AND `sport`.`sport_name`= '%s'
        AND `sports_court`.`request_status`='a'",
        $database -> real_escape_string($stfID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($sportName));

        $crtIDRes = $database -> query($crtID);
        $crtIDResult = $crtIDRes -> fetch_object();
        $courtID = $crtIDResult -> court_id;             //get the court id

        $courtQuery = sprintf("INSERT INTO `court_maintenance`
        (`court_id`,
        `starting_date`,
        `ending_date`,
        `status`,
        `message`,
        `decision`,
        `requested_receptionist`) VALUES
        (UUID_TO_BIN('%s',1),'%s','%s','pending','%s','p',UUID_TO_BIN('%s',1))",
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
        `branch`.`branch_email` AS email
        from `branch` INNER JOIN `staff` ON
        `branch`.`branch_id` = `staff`.`branch_id`
        WHERE `staff`.`branch_id` = UUID_TO_BIN('%s',1)",
        $database -> real_escape_string($branchID));

        $branchResult = $database -> query($branchSql);   //get the branch results

        $row = $branchResult -> fetch_object();   //get the branch details

        $branchLoc = $row -> location;
        $branchEmail = $row -> email;

        $branchNum = sprintf("SELECT DISTINCT `contact_number` AS contact_number
        from `staff`
        WHERE `staff`.`branch_id` = UUID_TO_BIN('%s',1) AND `staff`.`leave_date` is NULL",
        $database -> real_escape_string($branchID));

        $numResult = $database -> query($branchNum);   //get the branch contact numbers


        $numArray = [];
        while($row = $numResult -> fetch_object()){   //get the branch numbers one by one
            $number = $row -> contact_number;
            array_push($numArray,$number);
        }

        $branchPhotos = sprintf("SELECT  `photo`
        from `branch_photo`
        WHERE `branch_id` = UUID_TO_BIN('%s',1) ",
        $database -> real_escape_string($branchID));

        $photoResult = $database -> query($branchPhotos);   //get the branch photos


        $photoArray = [];
        while($row = $photoResult -> fetch_object()){   //get the photos one by one
            $photo = $row -> photo;
            array_push($photoArray,$photo);
        }

        $result = [];

        array_push($result,$branchLoc,$branchEmail,$numArray,$photoArray);

        if(count($result) === 0){   //couldn't find any branch that provide the searched sport
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }

        return $result;
    }

    public function getAllSports($branchID,$database) {
        $branch = new Branch(uuid_to_bin($branchID,$database));
        $sportNames = $branch -> getAllSports($database);

        return $sportNames;
    }

    public function getAllCourts($branchID,$database) {
        $branch = new Branch(uuid_to_bin($branchID,$database));
        $courtNames = $branch -> getAllCourts($database);

        return $courtNames;
    }

    public function getUserProfiles($database) {
        $userProResult = $database -> query("SELECT `first_name`,`last_name`,`contact_num`,`profile_photo` FROM `user`");
        $profileResult = [];
        while($row = $userProResult->fetch_object()){   //get profiles one by one
            array_push($profileResult,['fName' => $row->first_name,'lName' => $row ->last_name, 'contactN' => $row -> contact_num, 'profile' => $row->profile_photo]);
        }

        return $profileResult;
    }

    public function getWantedUserProfile($fName,$lName,$contactN,$database) {
        $findUser = sprintf("SELECT * FROM `user` WHERE `first_name` = '%s'
        AND `last_name` = '%s' AND `contact_num` = '%s'",
        $database -> real_escape_string($fName),
        $database -> real_escape_string($lName),
        $database -> real_escape_string($contactN));

        $user = $database -> query($findUser) -> fetch_Object() ;  //get the user id of the particular user
        // $user = new User('uid:$userID');
        // $user = $user -> getProfileDetails($database);
        $medicalConcernsSql = sprintf("SELECT `medical_concern` FROM `user_medical_concern` WHERE `user_id` = '%s'",
        $database -> real_escape_string($user -> user_id)); //medical concerns

        $medicalConcernResult = $database -> query($medicalConcernsSql);
        $medicalConcernsArr = $medicalConcernResult -> fetch_all(MYSQLI_ASSOC);

        $dependentsSql = sprintf("SELECT `name`,`relationship`,`contact_num` FROM `user_dependent` WHERE `owner_id` = '%s'",
        $database -> real_escape_string($user -> user_id)); //user dependents

        $dependentResult = $database -> query($dependentsSql);
        $dependentArr = $dependentResult -> fetch_all(MYSQLI_ASSOC);

        $allInfo = [];
        array_push($allInfo,$user,$medicalConcernsArr,$dependentArr);

        return $allInfo;
    }
}

?>
