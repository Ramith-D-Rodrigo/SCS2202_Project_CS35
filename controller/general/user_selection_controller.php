<?php       //this php file is the controller for redirecting to reservation schedule controller from our branches and our sports pages
    session_start();

    require_once('../../src/general/sport.php');
    require_once('../../src/general/branch.php');
    require_once('../../src/general/uuid.php');
    require_once('../../src/user/dbconnection.php');

    $sport_id = '';
    $branch_id = '';

    if(isset($_POST['selectedSportBtn'])){    //user is coming from the Our Sports page
        $sport_id = $_POST['selectedSportBtn'];
        $branch_id = $_POST['selected_branch'];
    }
    else if(isset($_POST['selectedBranchBtn'])){    //user is coming from the our branches page

    }
     
    $sport = new Sport();
    $sport -> setID($sport_id);
    $branch = new Branch($branch_id);

    $branchDetails = $branch -> getDetails($connection) -> fetch_object();
    $sportDetails = $sport -> getDetails($connection) -> fetch_object();

    $finalArray = [];

    //branch id -> 0th index, 
    //sport id -> 1st index, 
    //branch location -> 2nd index, 
    //sport name -> 3rd index, 
    //opening time -> 4th index, 
    //closing time -> 5th index, 
    //reservation price -> 6th index

    array_push($finalArray,$branch_id, 
    $sport_id, 
    $branchDetails -> city, 
    $sportDetails -> sport_name, 
    $branchDetails -> opening_time, 
    $branchDetails -> closing_time, 
    $sportDetails -> reservation_price);

    $_SESSION['reservationPlace'] = $finalArray;
    unset($finalArray);
    $connection -> close();
    header("Location: /controller/general/reservation_schedule_controller.php");
?>