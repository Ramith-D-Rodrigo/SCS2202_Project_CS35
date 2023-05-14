<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['admin'])){
        Security::redirectUserBase();
        die();
    }
    
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $requestJSON = file_get_contents("php://input");
    $profile = json_decode($requestJSON, true);

    $staffRole = htmlspecialchars($profile['StaffRole'], ENT_QUOTES);
    $branchName = htmlspecialchars($profile['Branch'],ENT_QUOTES);
    $fName = htmlspecialchars($profile['FirstName'],ENT_QUOTES);
    $lName = htmlspecialchars($profile['LastName'],ENT_QUOTES);
    $bday = htmlspecialchars($profile['Birthday'],ENT_QUOTES);
    $gender = htmlspecialchars($profile['Gender'],ENT_QUOTES);
    $email = htmlspecialchars($profile['Email'],ENT_QUOTES);
    $contactNo = htmlspecialchars($profile['Contact'],ENT_QUOTES);
    $username = htmlspecialchars($profile['Username'],ENT_QUOTES);
    
    $message;
    $flag = false;
    //email availability
    $hasEmailResult = null;
    $hasEmailResult = checkStaffEmail($email, $connection);

    if($hasEmailResult){    //account already exists
        $message = "Account with same Email Address exists.";
        $flag = true;
    }
    
    //contact number availability
    $hasContactNumber = checkContactNumber($contactNo,$connection);

    if($hasContactNumber){    //contact number already exists
        $message = "Contact Number already exists.";
        $flag = true;
    }
    
    //username availability    
    $hasUsernameResult = checkUsername($username, $connection);

    if($hasUsernameResult){    //account already exists
        $message = "Account with same Username exists.";
        $flag = true;
    }

    if($staffRole === 'receptionist') {
        $hasReceptionist = checkReceptionist($branchName,$connection);

        if($hasReceptionist){    //receptionist already exists
            $message = "Receptionist exists in the particular branch.";
            $flag = true;
        }
    }else {
        $hasManager = checkManager($branchName,$connection);

        if($hasManager){    //manager already exists
            $message = "Manager exists in the particular branch.";
            $flag = true;
        }
    }
    
    
    
    //can continue to register
    if(!$flag){
        //can create a account

        $password = password_hash($profile['Password'], PASSWORD_DEFAULT);    //hash the password
        $userid;
        $substr; 
        if($staffRole === 'receptionist'){
            $firstPart = "receptionist".substr($branchName,0,4);
            $userid = uniqid($firstPart);
        }else{
            $secondPart = "manager".substr($branchName,0,4);
            $userid = uniqid($secondPart);
        }
        $admin = Admin::getInstance();
        $branchID = $admin -> getBranchID($branchName,$connection);
        
        $result = false;
        $result = $admin -> registerStaff($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID,$staffRole,$connection);
        
        if($result){   //successfully registered
            // echo "Successfully Registered";
            $message = 'Registered Successfully';
            //send a mail regarding the change of login details
            require_once("../../src/general/mailer.php");
            Mailer::sendCredentials($email, $fName, $lName,$username,$profile['Password']);
        
        }else{
            $message = "There was Error in Registering ";
            $flag = true;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode(["Message"=>$message,"Flag"=>$flag]);
    die();

    
?>