<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/manager/manager.php");
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/general/uuid.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");


    //all possible inputs for prefilling
    $inputFields = [`email_address`, `contact_number`, `gender`, `date_of_birth`, `first_name`, 
                                `last_name`,`branchName`];

    //Compulsary Details

    foreach($inputFields as $i){    //store session details
        if(isset($_POST[$i])){
            $_POST[$i] = htmlspecialchars($_POST[$i], ENT_QUOTES);
            $_SESSION[$i] = $_POST[$i];
        }
    }

    
    //Checking if the account already exists

    //email availability
    $hasEmailResult = null;
    $hasEmailResult = checkStaffEmail($_POST['emailAddress'], $connection);

    if(isset($_SESSION['successMsg'])){ //same user is trying to register (in the same session) We have to unset the message
        unset($_SESSION['successMsg']);
    }

    if($hasEmailResult -> num_rows > 0){    //account already exists
        $_SESSION['emailError'] = "Account with same Email Address exists.";
        header("Location: /public/system_admin/staff_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['emailError']); //email is available, hence unset the error message
    }
    
    //contact number availability
    $hasContactNumber = checkContactNumber($_POST['contact_number'],$connection);

    if($hasContactNumber -> num_rows > 0){    //contact number already exists
        $_SESSION['numberError'] = "Contact Number already exists.";
        header("Location: /public/system_admin/staff_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['numberError']); //contact number is available, hence unset the error message
    }
    //username availability    
    $hasUsernameResult = checkUsername($_POST['username'], $connection);

    if($hasUsernameResult -> num_rows > 0){    //account already exists
        $_SESSION['usernameError'] = "Account with same Username exists.";
        header("Location: /public/system_admin/staff_register.php");
        $connection -> close(); //close the database connection
        exit(); //exit the registration
    }
    else{
        unset($_SESSION['usernameError']); //username is available, hence unset the error message
    }

    $branchName = htmlspecialchars($_POST['branchName'], ENT_QUOTES);
    $staffRole = htmlspecialchars($_POST['staffRole'], ENT_QUOTES);

    if($staffRole === 'receptionist') {
        $hasReceptionist = checkReceptionist($branchName,$connection);

        if($hasReceptionist -> num_rows > 0){    //receptionist already exists
            $_SESSION['staffError'] = "Receptionist exists in the particular branch.";
            header("Location: /public/system_admin/staff_register.php");
            $connection -> close(); //close the database connection
            exit(); //exit the registration
        }
        else{
            unset($_SESSION['staffError']); //staff role is available, hence unset the error message
        }
    }else {
        $hasManager = checkManager($branchName,$connection);

        if($hasManager -> num_rows > 0){    //manager already exists
            $_SESSION['staffError'] = "Manager exists in the particular branch.";
            header("Location: /public/system_admin/staff_register.php");
            $connection -> close(); //close the database connection
            exit(); //exit the registration
        }
        else{
            unset($_SESSION['staffError']); //staff role is available, hence unset the error message
        }
    }
    
    //can create a account

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);    //hash the password
    $userid; 
    if($staffRole === 'receptionist'){
        $userid = uniqid("rcptnst");
    }else{
        $userid = uniqid("mngr");
    }
       //create an user id using uuid function
    // $userIDResult = $connection -> query($useridsql); //get the result from query

    // foreach($userIDResult as $row){   //get the user id 
    //     $userid = $row['UUID()'];
    // }

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['emailAddress'], ENT_QUOTES);
    $contactNo = htmlspecialchars($_POST['contactNum'], ENT_QUOTES);
    $fName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
    $lName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
    $bday = htmlspecialchars($_POST['birthday'], ENT_QUOTES);
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES);
    
    

    $admin = Admin::getInstance();
    $branchID = $admin -> getBranchID($branchName,$connection);
    
    $result = false;
    $result = $admin -> registerStaff($fName, $lName, $email, $contactNo, $bday,  $gender, $userid, $username, $password, $branchID,$staffRole,$connection);
    
    if($result === TRUE){   //successfully registered
            echo "Successfully Registered";
        foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        } 
        // session_unset(); free all current session variables 

        $_SESSION['RegsuccessMsg'] = 'Registered Successfully';
        header("Location: /public/system_admin/staff_register.php");
    }

    $connection -> close(); //close the database connection
?>