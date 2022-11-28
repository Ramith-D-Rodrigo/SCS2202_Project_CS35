<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/receptionist/request_availability.php");
    require_once("../../src/system_admin/staff.php");

    //all possible inputs for prefilling
    $inputFields = [`reason`, `sportName`,`courtName`,`sDate`,`eDate`];

    //Compulsary Details

    foreach($inputFields as $i){    //store session details
        if(isset($_POST[$i])){
            $_POST[$i] = htmlspecialchars($_POST[$i], ENT_QUOTES);
            $_SESSION[$i] = $_POST[$i];
        }
    }
    
    $reason = htmlspecialchars($_POST['reason'], ENT_QUOTES);
    $sportName = htmlspecialchars($_POST['sportName'], ENT_QUOTES);
    $courtName = htmlspecialchars($_POST['courtName'], ENT_QUOTES);
    $sDate = htmlspecialchars($_POST['sDate'], ENT_QUOTES);
    $eDate = htmlspecialchars($_POST['eDate'], ENT_QUOTES);

    $results = '';
    $valid = checkAvailableSport($_SESSION['userid'],$courtName,$sportName,$connection);
    if($valid -> num_rows > 0){
        if($sportName === "ALL" && $courtName === "ALL") {
            $brAvailable = checkBranchMaintenance($_SESSION['branchid'],$sDate,$eDate,$connection);
            if($brAvailable -> num_rows > 0) {
                $_SESSION['slotUnavailability'] = "There's an already pending branch maintenance request that overlap to this request";
                header("Location: /public/receptionist/request_maintenance.php");
                $connection -> close(); //close the database connection
                exit(); //exit the submission
            }else {
                unset($_SESSION['slotUnavailability']);
                $staffMember = new Staff();
                $receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);
                $results = $receptionist -> branchMaintenance($reason,$sDate,$eDate,$_SESSION['branchid'],$_SESSION['userid'],$connection);    
            }
           
        }else if($sportName != "ALL" && $courtName != "ALL") {
            $brAvailable = checkBranchMaintenance($_SESSION['branchid'],$sDate,$eDate,$connection);
            $crtAvailable = checkCourtMaintenance($_SESSION['userid'],$courtName,$sportName,$sDate,$eDate,$connection);
            if( $brAvailable -> num_rows > 0 || $crtAvailable -> num_rows > 0){
                $_SESSION['slotUnavailability'] = "There's an already pending request that overlap to this request";
                header("Location: /public/receptionist/request_maintenance.php");
                $connection -> close(); //close the database connection
                exit(); //exit the submission
            }else{
                unset($_SESSION['slotUnavailability']);
                $staffMember = new Staff();
                $recep = $staffMember -> getStaffMemeber($_SESSION['userrole']);
                $results = $recep -> reqMaintenance($reason,$sportName,$courtName,$sDate,$eDate,$_SESSION['userid'],$connection);
            }
            
        }else {
            $results = false;
        }
    }else {
        $_SESSION['courtUnavailability'] = "Invalid Sport Court";
        header("Location: /public/receptionist/request_maintenance.php");
        $connection -> close(); //close the database connection
        exit(); //exit the submission
    }
    
    

    if($results === TRUE){   //successfully submitted
        echo "Successfully Submitted";
        foreach($inputFields as $i){    //store session details
            if(isset($_SESSION[$i])){   //unsetting input values
                session_unset($i);
            }
        }
        // session_unset(); //free all current session variables  || the userid and the userrole has unset

        $_SESSION['RequestsuccessMsg'] = 'Submitted';
        header("Location: /public/receptionist/request_maintenance.php");
    }else {
        $_SESSION['errMsg'] = 'There was a problem when inserting data to the database';
        header("Location: /public/receptionist/request_maintenance.php");
    }

    $connection -> close(); //close the database connection
?>