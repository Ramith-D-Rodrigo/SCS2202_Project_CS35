<?php
    session_start();

    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/general/uuid.php");

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
            
            if($branchResult -> request_status === 'p'){    //branch is still a pending request from the owner
                unset($branch);
                continue;
            }

            $numOfCourts = $branch -> getSportCourts($i['sport_id'], $connection);    //get the number of courts of the current considering branch

            array_push($final_result, 
            ['location' => $branchResult -> city, 
            'num_of_courts' => $numOfCourts -> num_rows,
            'opening_time' => $branchResult -> opening_time,
            'closing_time' => $branchResult -> closing_time, 
            'sport_name' => $i['sport_name'],
            'reserve_price' => $i['reserve_price'],
            'branch_id' => $i['branch'],
            'sport_id' => $i['sport_id']]);

            unset($branch); //remove the reference
        }

        $_SESSION['searchResult'] = $final_result;
    }
    //print_r($_SESSION['searchResult']);
    header("Location: /public/general/search_results.php");
    $connection -> close();
?>