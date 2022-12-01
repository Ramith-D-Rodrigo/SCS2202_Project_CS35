<?php
    session_start();

    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/uuid.php");

    $user = new User();
    $sportName = htmlspecialchars($_GET['sportName']);

    $result = $user -> searchSport($sportName, $connection);  //search the sport

    if(isset($result['errMsg'])){   //no sport was found
       echo json_encode($result);
    }
    else{
        $final_result = [];
        foreach($result as $i){ //traverse the search result array
            $branch = new Branch($i['branch']);
            $branch -> getDetails($connection);    //get branch details

            $courts = $branch -> getSportCourts($i['sport_id'], $connection);    //get the number of courts of the current considering branch

            $branchJSON = json_encode($branch);
            $neededInfo = json_decode($branchJSON, true);

            unset($neededInfo['manager']);  //do not need manager and receptionist info
            unset($neededInfo['receptionist']);
            
            //other needed info
            $neededInfo['num_of_courts'] = sizeof($courts);
            $neededInfo['reserve_price'] = $i['reserve_price'];
            $neededInfo['sport_name'] = $i['sport_name'];
            $neededInfo['sport_id'] = $i['sport_id'];
            
            array_push($final_result, $neededInfo);

            unset($neededInfo);
            unset($courts);
            unset($branch); //remove the reference
        }

        $_SESSION['searchResult'] = $final_result;
        echo json_encode($_SESSION['searchResult']);
    }
    //header("Location: /public/general/search_results.php");
    $connection -> close();
?>