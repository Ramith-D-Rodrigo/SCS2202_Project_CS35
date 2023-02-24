<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/staff.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $newEmail = $_POST['newEmail'];
    $newContactN = $_POST['newContactN'];

    $staffMember = new Staff();
    $receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);

    $result = false;
    if($newEmail === '' && $newContactN === ''){
        $_SESSION['UpdatesuccessMsg'] = "Nothing Updated.";
        header("Location: /public/receptionist/edit_branch.php");
        $connection->close();
        exit();
    }
    elseif($newEmail ==='' && $newContactN !== ''){
        $hasContactNumber = checkContactNumber($newContactN,$connection);

        if($hasContactNumber -> num_rows > 0){    //contact number already exists
            $_SESSION['numberError'] = "Contact Number already exists.";
            header("Location: /public/receptionist/edit_branch.php");
            $connection -> close(); //close the database connection
            exit(); //exit the registration
        }
        else{
            unset($_SESSION['numberError']); //contact number is available, hence unset the error message
            $result = $receptionist -> updateContactNumber($_SESSION['userid'],$newContactN,$connection);
        }
    }elseif($newEmail!=='' && $newContactN === ''){
        $hasEmailAddress1 = checkStaffEmail($newEmail,$connection);
        $hasEmailAddress2 = checkBranchEmail($newEmail,$connection);

        if($hasEmailAddress1 -> num_rows > 0 || $hasEmailAddress2 -> num_rows > 0){    //email address already exists
            $_SESSION['emailError'] = "Email Address already exists.";
            header("Location: /public/receptionist/edit_branch.php");
            $connection -> close(); //close the database connection
            exit(); //exit the registration
        }
        else{
            unset($_SESSION['emailError']); //contact number is available, hence unset the error message
            $result = $receptionist -> updateBranchEmail($_SESSION['branchID'],$newEmail,$connection);
        }
    }else{
        $hasContactNumber = checkContactNumber($newContactN,$connection);

        if($hasContactNumber -> num_rows > 0){    //contact number already exists
            $_SESSION['numberError'] = "Contact Number already exists.";
            header("Location: /public/receptionist/edit_branch.php");
            $connection -> close(); //close the database connection
            exit(); //exit the registration
        }

        $hasEmailAddress1 = checkStaffEmail($newEmail,$connection);
        $hasEmailAddress2 = checkBranchEmail($newEmail,$connection);

        if($hasEmailAddress1 -> num_rows > 0 || $hasEmailAddress2 -> num_rows > 0){    //email address already exists
            $_SESSION['emailError'] = "Email Address already exists.";
            header("Location: /public/receptionist/edit_branch.php");
            $connection -> close(); //close the database connection
            exit(); //exit the registration
        }

        unset($_SESSION['numberError']); 
        unset($_SESSION['emailError']);
        $result = $receptionist -> updateBranch($_SESSION['userid'],$_SESSION['branchID'],$newEmail,$newContactN,$connection);
    }

    if($result === TRUE){
        $_SESSION['UpdatesuccessMsg'] = "Branch Details Updated Successfully";
        header("Location: /public/receptionist/edit_branch.php");
    }else{
        $_SESSION['updateError'] = "There was an error when updating";
        header("Location: /public/receptionist/edit_branch.php");
    }
    
    $connection -> close();
?>