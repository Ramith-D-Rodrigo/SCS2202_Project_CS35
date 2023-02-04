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
        $result = $database -> query("SELECT `city` from `branch` ");

        $branches = [];
        while($rows = $result -> fetch_object()){
            array_push($branches,$rows -> city);
        }

        return $branches;
    }

    public function getBranchID($branchName,$database){
        $sql = sprintf("SELECT `branchID` FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> branchID;
        return $branchID;
    }

}

?>
