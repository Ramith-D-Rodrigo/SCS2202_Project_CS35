<?php
    session_start();
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/system_admin/dbconnection.php");
    require_once("../../src/system_admin/credentials_availability.php");

    $role = htmlspecialchars($_POST['role'],ENT_QUOTES);
    //check for the email availability
    $emailAvail = null;
    $emailAvailStaff = checkStaffEmail($_POST['newEmail'], $connection);  //check whether the email is already exists on login table
    $emailAvailBranch = checkBranchEmail($_POST['newEmail'], $connection);  //check wehter the email is already exists on branch table

    if($role !== "Admin"){
        if($emailAvailStaff || $emailAvailBranch){
            $_SESSION['emailError'] = "Email Address Already Exists.";
            header("Location: /public/system_admin/change_staff_logins.php");
            $connection -> close();
            exit();
        }else{
            unset($_SESSION['emailError']);
        }
    }else{
        if($emailAvailStaff || $emailAvailBranch){
            $_SESSION['emailError'] = "Email Address Already Exists.";
            header("Location: /public/system_admin/account_settings.php");
            $connection -> close();
            exit();
        }else{
            unset($_SESSION['emailError']);
        }
    }

    $newEmail = htmlspecialchars($_POST['newEmail'], ENT_QUOTES);
    $profileID = htmlspecialchars($_POST['confirmBtn'],ENT_QUOTES);

    $hashPwd = password_hash($_POST['newPwd'], PASSWORD_DEFAULT);  //hash the new password
    $admin = Admin::getInstance();
    $updateResult = $admin -> updateStaffLogin($profileID, $newEmail, $hashPwd, $connection);
    
    if($role !== "Admin"){
        if($updateResult){
            $_SESSION['successMsg'] = "Login Details Updated Successfully.";
            header("Location: /public/system_admin/change_staff_logins.php");
            $connection -> close();
            exit();
        }
    }else{
        if($updateResult){
            $_SESSION['successMsg'] = "Login Details Updated Successfully.";
            header("Location: /public/system_admin/account_settings.php");
            $connection -> close();
            exit();
        }
    }
    

    


?>