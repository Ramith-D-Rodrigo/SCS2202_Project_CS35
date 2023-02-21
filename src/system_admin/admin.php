<?php
require_once("../../src/system_admin/staff.php");
require_once("../../src/general/actor.php");

class Admin extends Actor{

    private static $admin;
    private $adminID;

    private function __construct() {}  //make the construct private so that no new object can be created

    public static function getInstance($actor = NULL) {
        if(!isset(self::$admin)){
            $admin = new Admin();
        }
        if($actor !== NULL){
            $admin -> userID = $actor -> getUserID();
            $admin -> username = $actor -> getUsername();
        }
        require("dbconnection.php");   //get the user connection to the db
        $admin -> connection = $connection;
        return $admin;
    }

    public function getAdminID(){    //adminID getter
        return $this -> adminID;
    }

    // public function login($username, $password, $database){
    //     $sql = sprintf("SELECT `userID`,
    //     `username`,
    //     `password`,
    //     `userRole`
    //     FROM `login_details`
    //     WHERE `username` = '%s'",
    //     $database -> real_escape_string($username));

    //     $result = $database -> query($sql);

    //     $rows = $result -> fetch_object();

    //     if($rows === NULL){ //no result. hence no user
    //         return ["No Such User Exists"];
    //     }

    //     $hash = $rows -> password;
    //     if(password_verify($password, $hash) === FALSE){    //Incorrect Password
    //         return ["Incorrect Password"];
    //     }

    //     //setting admin data for session
    //     $this -> adminID = $rows -> userID;

    //     return ["Successfully Logged In", $rows -> userRole, $rows -> username];  //return the message, user role and username
    // }

    public function registerStaff($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID,$staffRole,$database) {
        $staffMember = new Staff();
        $staffMember = $staffMember -> getStaffMemeber($staffRole);
        $staffMember -> setDetails($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID);

        $result1 = $staffMember -> register($database);
        if($result1 === TRUE){
            $branch = new Branch($branchID);
            $result2 = $branch -> updateCurrentStaff($userid, $staffRole, $database);
            return $result2;
        }
        else{
            return FALSE;
        }

    }

    public function getAllBranches($database){
        $result = $database -> query("SELECT `city` from `branch`");

        $branches = [];
        while($rows = $result -> fetch_object()){
            array_push($branches,$rows -> city);
        }

        return $branches;
    }

    public function getBranchID($branchName,$database){
        $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `city`= '%s'",
        $database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branchID;
        return $branchID;
    }

    public function getBranchDetails($role,$database){
        $availBranchResult = '';
        if($role === "receptionist"){
            $availBranchResult = $database -> query("SELECT `branchID`,`city` FROM `branch` WHERE `currReceptionist` IS NOT NULL");  //get only the branches that have a receptionist
        }else{
            $availBranchResult = $database -> query("SELECT `branchID`,`city` FROM `branch` WHERE `currManager` IS NOT NULL");  //get only the branches that have a manager
        }
        $branchInfo = [];
        while($row = $availBranchResult -> fetch_object()){
            array_push($branchInfo,[$row->city,$row->branchID]);
        }
        return $branchInfo;
    }

    public function getPendingBranchDetails($branchID,$database){
        $pendingBr = new Branch($branchID);    //get details of the pending branch
        $sql = sprintf("SELECT `branchID`,`branchEmail`,`city`,`address`,`openingTime`,`closingTime`,`ownerRequestDate` FROM Branch WHERE branchID = '%s'",
        $database -> real_escape_string($branchID));
        $generalDetails  = $database -> query($sql) -> fetch_object();
        $pendingBranch = [];
        array_push($pendingBranch,$generalDetails);
        $sports = $pendingBr -> getAllSports($database);
        foreach($sports as $sport){
            $courts = $pendingBr -> getSportCourtNames($sport->sportID,$database);
            $courtCount = count($courts);
            array_push($pendingBranch,[$sport->sportName,$courtCount]);
        }

        return $pendingBranch;
    }

    public function getLoginDetails($role,$branch,$database) {
        
        $sql = sprintf("SELECT `l`.`userID`,`l`.`username`,`l`.`emailAddress` FROM `login_details` `l` INNER JOIN
        `staff` `s` ON `l`.`userID` = `s`.`staffID` WHERE `s`.`branchID` = '%s' AND `s`.`staffRole` = '%s'",
        $database -> real_escape_string($branch),
        $database -> real_escape_string($role));
        
        $row = $database -> query($sql) -> fetch_object();
        $loginResults = [];
        array_push($loginResults,[$row -> userID,$row -> username,$row -> emailAddress]);
        return $loginResults;
    }

    public function getAccountDetails($role,$branch,$database){
        $profileSQL = sprintf("SELECT `l`.`userID`,`l`.`emailAddress`,`l`.`username`,`s`.`firstName`,`s`.`lastName`,`s`.`joinDate`,`s`.`contactNum` FROM `login_details` `l` INNER JOIN
        `staff` `s` ON `l`.`userID` = `s`.`staffID` WHERE `s`.`branchID` = '%s' AND `s`.`staffRole` = '%s'",
        $database -> real_escape_string($branch),
        $database -> real_escape_string($role));

        $row = $database -> query($profileSQL) -> fetch_object();
        $accountDetails = [];
        array_push($accountDetails,[$row -> userID,$row -> username,$row -> emailAddress,$row->firstName,$row->lastName,$row->joinDate,$row->contactNum]);
        return $accountDetails;
    }

    public function getPendingBranches($database){
        $pendingBranches = $database -> query("SELECT * FROM `branch` WHERE `requestStatus` = 'p'");
        $branchInfo = [];
        while($row = $pendingBranches -> fetch_object()){
            array_push($branchInfo,$row);
        }

        return $branchInfo;
    }

    public function updateStaffLogin($userID,$newEmail,$newPwd,$database){
        $sql = sprintf("UPDATE `login_details` SET `emailAddress` = '%s', `password` = '%s' WHERE `userID` = '%s'",
        $database -> real_escape_string($newEmail),
        $database -> real_escape_string($newPwd),
        $database -> real_escape_string($userID));

        $result = $database -> query($sql);
        return $result;
    }
}

?>
