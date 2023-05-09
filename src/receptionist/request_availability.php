<?php

function checkAvailableSport($branchID,$courtName,$sportName,$database) {     //get the relevant court id
    $crtID = sprintf("SELECT DISTINCT `sports_court`.`courtID` AS court_id         
        from `sports_court` INNER JOIN 
        `sport` ON 
        `sports_court`.`sportID` = `sport`.`sportID` INNER JOIN 
        `staff` ON 
        `sports_court`.`branchID` = `staff`.`branchID` 
        WHERE `staff`.`branchID` = '%s'
        AND `sports_court`.`courtName` = '%s' 
        AND `sport`.`sportName`= '%s' 
        AND `sports_court`.`requestStatus`='a'",
        $database -> real_escape_string($branchID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($sportName));

        $crtIDRes = $database -> query($crtID);

        return $crtIDRes;
}
function checkCourtMaintenance($branchID,$courtName,$sportName,$stDate,$endDate,$database) {    /*get all the court
                                                                                                maintenance under given data range*/

    $crtIDRes = checkAvailableSport($branchID,$courtName,$sportName,$database);
    $crtIDResult = $crtIDRes -> fetch_object();
    $courtID = $crtIDResult -> court_id; 

    //have to check all the four conditions of overlapping
    $slotAvail = sprintf("SELECT * FROM `court_maintenance` WHERE (((`startingDate` BETWEEN 
        '%s' AND '%s')  OR (`endingDate` BETWEEN 
        '%s' AND '%s')) OR (`startingDate` > '%s' AND `endingDate` < '%s')) AND `courtID` = '%s' AND `decision` = 'p'", 
        $database -> real_escape_string($stDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($stDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($stDate),
        $database -> real_escape_string($endDate),
        $database -> real_escape_string($courtID));

    $result = $database -> query($slotAvail);
    
    return $result;
}


function checkBranchMaintenance($branchID,$stDate,$endDate,$database) {         /*get all the branch
                                                                                    maintenance under given data range*/

    $slotAvail = sprintf("SELECT `decision` FROM `branch_maintenance` WHERE (((`startingDate` BETWEEN 
    '%s' AND '%s')  OR (`endingDate` BETWEEN 
    '%s' AND '%s')) OR (`startingDate` > '%s' AND `endingDate` < '%s')) AND `branchID` = '%s' AND `decision` = 'p'",
    $database -> real_escape_string($stDate),
    $database -> real_escape_string($endDate),
    $database -> real_escape_string($stDate),
    $database -> real_escape_string($endDate),
    $database -> real_escape_string($stDate),
    $database -> real_escape_string($endDate),
    $database -> real_escape_string($branchID));

    $result = $database -> query($slotAvail);
    
    return $result;
}



?>