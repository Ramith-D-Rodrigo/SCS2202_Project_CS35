<?php
    require_once("../../src/general/uuid.php");
    require_once("../../src/system_admin/staffMember.php");
    require_once("../../src/general/actor.php");

class Manager extends Actor implements JsonSerializable , StaffMember{

    private $firstName;
    private $lastName;
    private $contactNum;
    private $joinDate;
    private $leaveDate;
    private $dateOfBirth;
    private $gender;
    private $branchID;
    private $staffRole;
    private $staffID;

    public function __construct($actor = null){
        if($actor !== null){
            $this -> userID = $actor -> getUserID();
            $this -> username = $actor -> getUsername();
        }
        require("manager_dbconnection.php");   //get the user connection to the db
        $this -> connection = $connection;
    }


    public function setDetails($fName='', $lName='', $email='', $contactNo='', $dob='', $gender='', $uid='', $username='', $password='', $brID = ''){
        $this -> userID = $uid;
        $this -> staffID = $uid;
        $this -> firstName = $fName;
        $this -> lastName = $lName;
        $this -> emailAddress = $email;
        $this -> contactNum = $contactNo;
        $this -> dateOfBirth = $dob;
        $this -> gender = $gender;
        $this -> username = $username;
        $this -> password = $password;
        $this -> branchID = $brID;
        $this -> staffRole = 'manager';
    }

    public function getID(){    //managerID getter
        if(isset($this -> userID) || $this -> userID !== ''){
            return $this -> userID;
        }
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
        ('%s','%s','%s','%s','manager',1)",
        $database -> real_escape_string($this -> userID),
        $database -> real_escape_string($this -> username),
        $database -> real_escape_string($this -> emailAddress),
        $database -> real_escape_string($this -> password)));

/*      if ($result === TRUE) {
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
        ('%s','%s','%s','%s','%s','%s','%s', NULLIF('%s', ''), '%s', '%s')",
        $database -> real_escape_string($this -> userID),
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

    private function create_manager_entry($database) {
        $result = $database->query(sprintf("INSERT INTO `manager` (`managerID`) VALUES ('%s')",
        $database -> real_escape_string($this -> userID)));

        return $result;
    }

    public function register($database){    //public function to register the user
        $this -> joinDate = date("Y-m-d");
        $this -> leaveDate = '';
        $loginEntry = $this -> create_login_details_entry($database);
        $staffEntry = $this -> create_staff_entry($database);
        $managerEntry = $this -> create_manager_entry($database);

        if($loginEntry  === TRUE && $staffEntry  === TRUE && $managerEntry === TRUE){    //all has to be true (successfully registered)
            return TRUE;
        }
    }

    public function login($username, $password){
        $getBranch = sprintf("SELECT `branchID` AS brid
        FROM `staff`
        WHERE `staffID` = '%s'",
        $this -> connection -> real_escape_string($this -> userID));

        $brResult = $this -> connection -> query($getBranch);

        $branchIDResult = $brResult -> fetch_object();   //get the branch_id
        $this -> branchID = $branchIDResult -> brid;

        $getBrName = sprintf("SELECT `city`
        FROM `branch`
        WHERE `branchID` = '%s'",
        $this -> connection -> real_escape_string($this -> branchID));

        $brNameResult = $this -> connection -> query($getBrName);

        $branchName = $brNameResult -> fetch_object();   //get the branch_city

        return [$branchName -> city, $this -> branchID];  //return the message and other important details
    }
    public function getSportID($sportName, $database){
        $sportSql = sprintf("SELECT `sportID`
        FROM `sport`
        WHERE `sportName` = '%s'", //to escape % in sprintf, we need to add % again
        $database -> real_escape_string($sportName));

        $sportResult = $database -> query($sportSql);
        $sportR = mysqli_fetch_assoc($sportResult);
        return  $sportR['sportID'];  //get the sports results

        if($sportResult -> num_rows === 0){ //no such sport found
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }
    }

    public function getBranchID( $database, $branch){
        $sportSql = sprintf("SELECT `branchID`
        FROM `branch`
        WHERE `city` = '%s'",
        $database -> real_escape_string($branch)); //to escape % in sprintf, we need to add % again
        // $database -> real_escape_string($sportName));

        $sportResult = $database -> query($sportSql);
        $sportR = mysqli_fetch_assoc($sportResult);
        return  $sportR['branchID'];  //get the sports results

        if($sportResult -> num_rows === 0){ //no such sport found
            return ['errMsg' => "Sorry, Cannot find what you are looking For"];
        }
    }


    public function getDetails($database){
        $sql = sprintf("SELECT * FROM `staff`
        WHERE
        `staffID` = '%s'
        AND
        `staffRole` = 'manager'",
        $database -> real_escape_string($this -> userID));

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

    public function jsonSerialize() : mixed{
        return [
            'managerID' => $this -> userID,
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

    public function add_court($database, $courtName ,$sportID, $branchID, $courtID, $managerID){
        $result = $database -> query(sprintf("INSERT INTO `sports_court`
        (`courtID`,
        `sportID`,
        `courtName`,
        `branchID`,
        `requestStatus`,
        `addedManager`)
        VALUES
        ('%s','%s','%s','%s','p','%s')",
        // $database -> real_escape_string($this -> managerID),
        // $database -> real_escape_string($this -> contactNum),
        $database -> real_escape_string($courtID),
        $database -> real_escape_string($sportID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($branchID),
        $database -> real_escape_string($managerID)));

        return $result;

    }


    
    // public function getSportID($sportName, $database){
    //     $sportSql = sprintf("SELECT `sport_id`
    //     FROM `sport`
    //     WHERE `sport_name` = '%s'", //to escape % in sprintf, we need to add % again
    //     $database -> real_escape_string($sportName));

    //     $sportResult = $database -> query($sportSql);
    //     $sportR = mysqli_fetch_assoc($sportResult);
    //     return  $sportR['sport_id'];  //get the sports results

    //     if($sportResult -> num_rows === 0){ //no such sport found
    //         return ['errMsg' => "Sorry, Cannot find what you are looking For"];
    //     }
    // }

    // public function getBranchID( $database, $branch){
    //     $sportSql = sprintf("SELECT `branch_id`
    //     FROM `branch`
    //     WHERE `city` = '%s'",
    //     $database -> real_escape_string($branch)); //to escape % in sprintf, we need to add % again
    //     // $database -> real_escape_string($sportName));

    //     $sportResult = $database -> query($sportSql);
    //     $sportR = mysqli_fetch_assoc($sportResult);
    //     return  $sportR['branch_id'];  //get the sports results

    //     if($sportResult -> num_rows === 0){ //no such sport found
    //         return ['errMsg' => "Sorry, Cannot find what you are looking For"];
    //     }
    // }
   
   public function changeTimeofaBranch($openingTime,$closingTime,$branchID){
        $branch = new Branch($branchID);
        return $branch -> changeTime($this -> connection,$openingTime,$closingTime);
    }
      
    public function addDiscount($database, $managerID, $startingDate, $endingDate, $discountValue, $branchID){

        $result = $database -> query(sprintf("INSERT INTO `discount`
        ( `managerID`,`startingDate`,`endingDate`, `decision`, `discountValue`,`branchID`)
        VALUES 
        ('%s','%s', '%s', 'p', '%s', '%s')",
        $database -> real_escape_string( $managerID),
        $database -> real_escape_string($startingDate),
        $database -> real_escape_string($endingDate),
        $database -> real_escape_string($discountValue),
        $database -> real_escape_string($branchID)));
        
        return $result;
    }

    

    
}  

    
?>