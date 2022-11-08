<?php
    session_start();

    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/branch.php");

    $user = new User();
    $sportName = htmlspecialchars($_POST['sportName']);

    $result = $user -> searchSport($sportName, $connection);  //search the sport

    if(isset($result['errMsg'])){   //no sport was found
        $_SESSION['searchErrorMsg'] = $result['errMsg'];
    }
    else{
        unset($_SESSION['searchErrorMsg']);
        $final_result = [];
        foreach($result as $i){ //traverse the search result array
            $branch = new Branch($i['branch']);
            $branchDetails = $branch -> getDetails($connection);    //get branch details
            $branchResult = $branchDetails -> fetch_object();

            $numOfCourts = $branch -> getSportCourts($i['sport_id'], $connection);    //get the number of courts of the current considering branch

            array_push($final_result, 
            ['location' => $branchResult -> city, 
            'num_of_courts' => $numOfCourts -> num_rows, 
            'sport_name' => $i['sport_name'],
            'branch_id' => $i['branch'],
            'sport_id' => $i['sport_id']]);

            unset($branch); //remove the reference
        }

        $_SESSION['searchResult'] = $final_result;
    }

    header("Location: /public/general/search_results.php");
    $connection -> close();
?>