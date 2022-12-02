<?php
require_once("../../src/system_admin/staff.php");

class Admin{

    private static $admin;
    private $adminID;

    private function __construct() {}

    public static function getInstance() {
        if(!isset(self::$admin)){
            $admin = new Admin();
        }
        return $admin;
    }

    public function getAdminID(){    //adminID getter
        return $this -> adminID;
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

        $rows = $result -> fetch_object();

        if($rows === NULL){ //no result. hence no user
            return ["No Such User Exists"];
        }

        $hash = $rows -> password;
        if(password_verify($password, $hash) === FALSE){    //Incorrect Password
            return ["Incorrect Password"];
        }

        //setting admin data for session
        $this -> adminID = $rows -> user_id;

        return ["Successfully Logged In", $rows -> user_role, $rows -> username];  //return the message, user role and username
    }

    public function registerStaff($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID,$staffRole,$database) {
        $staffMember = new Staff();
        $staffMember = $staffMember -> getStaffMemeber($staffRole);
        $staffMember -> setDetails($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID);

        return $staffMember -> register($database);

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
        $sql = sprintf("SELECT BIN_TO_UUID(`branch_id`,1) AS UUID FROM `branch` WHERE `city`= '%s'",$database -> real_escape_string($branchName));
        $result = $database -> query($sql);

        $branchID = $result -> fetch_object() -> UUID;
        return $branchID;
    }

}

?>
