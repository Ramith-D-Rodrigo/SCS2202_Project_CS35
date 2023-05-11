<?php
    session_start();
    require_once("../../src/receptionist/receptionist.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/system_admin/admin.php");
    require_once("../../src/receptionist/dbconnection.php");
    require_once("../../src/receptionist/request_availability.php");
    require_once("../../src/system_admin/staff.php");

    $requestJSON = file_get_contents("php://input");
    $requestDetails = json_decode($requestJSON, true);
    
    $reason = htmlspecialchars($requestDetails['reason'], ENT_QUOTES);     //get the necessary details
    $sportName = htmlspecialchars($requestDetails['sport'], ENT_QUOTES);    //htmlspecailchars is used to prevent inject scripts attacks
    $courtName = htmlspecialchars($requestDetails['court'], ENT_QUOTES);
    $sDate = htmlspecialchars($requestDetails['start'], ENT_QUOTES);
    $eDate = htmlspecialchars($requestDetails['end'], ENT_QUOTES);

    $flag = false;
    $msg;
    $results;

    $valid = checkAvailableSport($_SESSION['branchID'],$courtName,$sportName,$connection);
    $branch = new Branch($_SESSION['branchID']);      //get the manager ID to send the request about the maintenance
    $managerID = json_decode(json_encode($branch -> getDetails($connection,['currManager'])),true)['currManager'];  
               
    if(($valid -> num_rows > 0) || ($sportName === "ALL" && $courtName === "ALL")){
        if($sportName === "ALL" && $courtName === "ALL") {
            $brAvailable = checkBranchMaintenance($_SESSION['branchID'],$sDate,$eDate,$connection);
            if($brAvailable -> num_rows > 0) {
                $msg = "There's an already pending branch maintenance request that overlap to this request";
                $flag = true;
            }else {
                $staffMember = new Staff();
                $receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);
                $results = $receptionist -> branchMaintenance($reason,$sDate,$eDate,$_SESSION['branchID'],$_SESSION['userid'],$connection);    

                $desc = "You have a pending branch maintenance request starting from ".$sDate. "to".$eDate;
                $triggerDate = date('Y-m-d', strtotime($sDate. ' - 7 days'));   //trigger the notification to the manager atleast 7 days before the maintenance
                $notificationID = uniqid("notmainten");
                $recep -> addNotification($notificationID,"Branch Maintenance Request",$desc,$triggerDate,$managerID);
            
            }
           
        }else if($sportName != "ALL" && $courtName != "ALL") {
            $brAvailable = checkBranchMaintenance($_SESSION['branchID'],$sDate,$eDate,$connection);
            $crtAvailable = checkCourtMaintenance($_SESSION['branchID'],$courtName,$sportName,$sDate,$eDate,$connection);
            if( $brAvailable -> num_rows > 0 ){
                $msg = "There's a pending branch maintenance request that overlap to this request";
                $flag = true;
            }elseif($crtAvailable -> num_rows > 0){
                $msg = "There's a pending court maintenance request that overlap to this request";
                $flag = true;
            }else{
                $staffMember = new Staff();
                $recep = $staffMember -> getStaffMemeber($_SESSION['userrole']);
                $results = $recep -> reqMaintenance($reason,$sportName,$courtName,$sDate,$eDate,$_SESSION['userid'],$connection);

                $desc = "You have a pending court maintenance request starting from ".$sDate. "to".$eDate;
                $triggerDate = date('Y-m-d', strtotime($sDate. ' - 7 days'));   //trigger the notification to the manager atleast 7 days before the maintenance
                $notificationID = uniqid("notmainten");
                $recep -> addNotification($notificationID,"Court Maintenance Request",$desc,$triggerDate,$managerID);
            }
            
        }
    }else {
        $msg = "Invalid Sport Court";
        $flag = true;
    }
    
    if(!$flag && $results){   //successfully submitted
        $msg = "Request Successfully Submitted";
    }

    header("Content-Type: application/json");
    echo json_encode(array("Message" => $msg, "Flag" => $flag));
    die();
?>