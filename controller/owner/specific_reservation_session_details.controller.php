<?php
    session_start();
    require_once("../../src/general/security.php");
    if(!Security::userAuthentication(logInCheck: TRUE, acceptingUserRoles: ['owner'])){
        Security::redirectUserBase();
        die();
    }

    require_once("../../src/owner/owner.php");
    require_once("../../src/general/reservation.php");
    require_once("../../src/user/user.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/coach/coaching_session.php");

    $owner = Owner::getInstance();
    $owner -> setUserID($_SESSION['userid']);

    $neededID = null;

    $returnJSON = [];

    //check if the request is for user reservation or coaching session
    if($_GET['type'] == 'userReservation'){     
        //user reservation
        $neededID = $_GET['reservationID'];
        $reservation = new Reservation();
        $reservation -> setID($neededID);
        $reservation -> getDetails($owner -> getConnection(), ['noOfPeople', 'paymentAmount', 'status', 'userID', 'formalManagerID', 'onsiteReceptionistID', 'reservedDate']);

        $reservationASSOC = json_decode(json_encode($reservation), true);

        if($reservationASSOC['userID'] != null){    //online reservation
            $reserveUser = new User();
            $reserveUser -> setUserID($reservationASSOC['userID']);
            $reserveUser -> getProfileDetails(['firstName', 'lastName', 'gender', 'profilePhoto', 'contactNum']);
            $reservationASSOC['userDetails'] = $reserveUser;

            unset($reservationASSOC['userID']); //remove the userID from the array
        }
        else if($reservationASSOC['onsiteReceptionistID'] != null){ //onsite reservation
            $reservationASSOC['userDetails'] = $reservation -> getOnsiteReservationInfo($owner -> getConnection());

            unset($reservationASSOC['onsiteReceptionistID']); //remove the onsiteReceptionistID from the array
        }

        $returnJSON = $reservationASSOC;

    }else if($_GET['type'] == 'coachingSession'){
        //coaching session
        $neededID = $_GET['sessionID'];

        $coachingSession = new Coaching_Session(sessionID: $neededID);
        $coachingSession -> getDetails($owner -> getConnection(), ['coachID', 'coachMonthlyPayment', 'paymentAmount', 'startDate', 'cancelDate', 'noOfStudents']);

        $coachingSessionASSOC = json_decode(json_encode($coachingSession), true);

        $coach = new Coach();
        $coach -> setUserID($coachingSessionASSOC['coachID']);

        $coachfName = $coach -> getDetails('firstName');
        $coachlName = $coach -> getDetails('lastName');
        $gender = $coach -> getDetails('gender');
        $profilePhoto = $coach -> getDetails('photo');
        $contactNum = $coach -> getDetails('contactNum');

        unset($coachingSessionASSOC['coachID']); //remove the coachID from the array

        $coachingSessionASSOC['coachDetails'] = ['name' => $coachfName . " " . $coachlName,
            'gender' => $gender,
            'profilePhoto' => $profilePhoto,
            'contactNum' => $contactNum];

        $returnJSON = $coachingSessionASSOC;
    }else{
        //invalid request
        http_response_code(400);
        die();
    }

    header('Content-Type: application/json');
    echo json_encode($returnJSON);
?>

