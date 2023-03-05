<?php
    session_start();

    require_once("../../src/user/user.php");
    require_once("../../src/general/branch.php");
    require_once("../../src/coach/coach.php");
    require_once("../../src/general/sport_court.php");

    $user = new User();
    $sportName = htmlspecialchars($_GET['sportName']);

    $result = $user -> searchSport($sportName);  //search the sport

    if(isset($result['errMsg'])){   //no sport was found
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($result);
    }
    else{
        $branches = []; //for branch info
        $coaches = [];  //for coach info

        foreach($result['branches'] as $i){ //traverse the search result array
            $branch = new Branch($i['branch']);
            $branch -> getDetails($user -> getConnection());    //get branch details

            $branch -> getBranchPictures($user -> getConnection());  //get the branch pictures
            $tempSport = new Sport();
            $tempSport -> setID($i['sportID']);
            $courts = $branch -> getBranchCourts($user -> getConnection(), $tempSport, 'a');    //get the number of courts of the current considering branch (request status should be accepted)
            $brRating = $branch -> getBranchRating($user -> getConnection());  //get the branch rating
            $brDiscount = $branch -> getCurrentDiscount($user -> getConnection());    //get the branch discount
            $branchJSON = json_encode($branch);
            $neededInfo = json_decode($branchJSON, true);

            unset($neededInfo['manager']);  //do not need manager and receptionist info
            unset($neededInfo['receptionist']);
            unset($neededInfo['email']);
            unset($neededInfo['openingTime']);
            unset($neededInfo['closingTime']);

            foreach($courts as $currCourt){ //to get the court pictures
                $courtPics = $currCourt -> getPhotos($user -> getConnection());
                
                foreach($courtPics as $currPic){    //add the court photos to the branch photos
                    array_push($neededInfo['photos'], $currPic);
                }
            }
           
            //other needed info
            $neededInfo['num_of_courts'] = sizeof($courts);
            $neededInfo['reserve_price'] = $i['reservationPrice'];
            $neededInfo['sport_name'] = $i['sportName'];
            $neededInfo['sport_id'] = $i['sportID'];
            $neededInfo['rating'] = $brRating;
            $neededInfo['discount'] = $brDiscount;
            
            array_push($branches, $neededInfo);

            unset($neededInfo);
            unset($courts);
            unset($branch); //remove the reference
        }

        //now for coaches
        foreach($result['coaches'] as $i){
            $coach = new Coach();
            $coach -> setDetails(uid: $i['coachID'], sport: $i['sportID']);

            $rating = $coach -> getRating();
            $coachName = $coach -> getDetails('firstName') . " " . $coach -> getDetails('lastName');
            $gender = $coach -> getDetails('gender');
            if($gender == 'm'){
                $coachName = "Mr. " . $coachName;
            }
            else{
                $coachName = "Mrs. " . $coachName;
            }

            $pic = $coach -> getDetails('photo');

            $coachInfo = array(
                'coachID' => $i['coachID'],
                'coachName' => $coachName,
                'rating' => $rating,
                'sport' => $i['sportName'],
                'profilePic' => $pic
            );

            array_push($coaches, $coachInfo);

            unset($coachInfo);
            unset($coach);
        }
        function cmp($a, $b){   //to sort the branches by rating
            return $b['rating'] - $a['rating'];
        }
        usort($coaches, "cmp");    //sort the coaches by rating

        //select the top 5 coaches
        if(sizeof($coaches) > 5){
            $coaches = array_slice($coaches, 0, 5);
        }
        $final_result = array(
            'branches' => $branches,
            'coaches' => $coaches
        );
        header('Content-Type: application/json;');    //because we are sending json
        echo json_encode($final_result);
    }
    unset($user);
?>