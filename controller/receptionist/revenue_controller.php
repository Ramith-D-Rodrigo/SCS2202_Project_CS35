<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['receptionist'])){
        Security::redirectUserBase();
        die();
    }


    require_once("../../src/system_admin/staff.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/sport.php");

    $getIndexes = ['all-revenue', 'reservation', 'coachingsession', 'sportID', 'fromDate', 'toDate'];

    foreach($getIndexes as $currIndex){
        if(!isset($_GET[$currIndex])){
            http_response_code(400);    // Bad Request
            die();
        }
    }

    $staffMember  = new Staff();
    $receptionist = $staffMember -> getStaffMemeber($_SESSION['userrole']);

    $branch = new Branch($_SESSION['branchID']);

    $sport = null;

    if($_GET['sportID'] !== 'all'){
        //need some sport;
        $sport = new Sport();
        $sport -> setID($_GET['sportID']);
    }

    $returnJSON = [];

    //start with from date and to date and loop through all days
    $toDate   = new DateTime($_GET['toDate']);
    
    if($_GET['all-revenue'] === 'true'){    // All revenue
        $currDate = new DateTime($_GET['fromDate']);

        $returnJSON['allrevenue'] = [];

        while($currDate <= $toDate){    // loop through all days
            $currDateStr = $currDate -> format('Y-m-d');
            $currRevenue = $branch -> getBranchRevenue($receptionist -> getConnection(), $_GET['fromDate'], $currDateStr, $sport);
            $returnJSON['allrevenue'][$currDateStr] = $currRevenue;
            $currDate -> add(new DateInterval('P1D')); // add one day
        }
    }

    if($_GET['reservation'] === 'true'){    // Reservation revenue
        $currDate = new DateTime($_GET['fromDate']);

        $returnJSON['reservation'] = [];
        while($currDate <= $toDate){    // loop through all days
            
            $currDateStr = $currDate -> format('Y-m-d');
            $currRevenue = $branch -> courtReservationRevenue($_GET['fromDate'], $currDateStr, $sport, $receptionist -> getConnection());
            $returnJSON['reservation'][$currDateStr] = $currRevenue;
            $currDate -> add(new DateInterval('P1D')); // add one day
        }
    }

    if($_GET['coachingsession'] === 'true'){    // Coaching session revenue
        $currDate = new DateTime($_GET['fromDate']);

        $returnJSON['coachingsession'] = [];

        while($currDate <= $toDate){    // loop through all days
            $currDateStr = $currDate -> format('Y-m-d');
            $currRevenue = $branch -> coachSessionPaymentRevenue($_GET['fromDate'], $currDateStr, $sport, $receptionist -> getConnection());
            $returnJSON['coachingsession'][$currDateStr] = $currRevenue;
            $currDate -> add(new DateInterval('P1D')); // add one day
        }
    }

    header("Content-Type: application/json;");
    echo json_encode($returnJSON);
    die();
?>
    