<?php

function checkAvailableSport($stfID,$courtName,$sportName,$database) {     //get the relevant court id
    $crtID = sprintf("SELECT `sports_court`.`courtID` AS court_id         
        from `sports_court` INNER JOIN 
        `sport` ON 
        `sports_court`.`sportID` = `sport`.`sportID` INNER JOIN 
        `staff` ON 
        `sports_court`.`branchID` = `staff`.`branchID` 
        WHERE `staff`.`staffID` = '%s'
        AND `sports_court`.`courtName` = '%s' 
        AND `sport`.`sportName`= '%s' 
        AND `sports_court`.`requestStatus`='a'",
        $database -> real_escape_string($stfID),
        $database -> real_escape_string($courtName),
        $database -> real_escape_string($sportName));

        $crtIDRes = $database -> query($crtID);

        return $crtIDRes;
}
function checkCourtMaintenance($stfID,$courtName,$sportName,$stDate,$endDate,$database) {    /*get all the court
                                                                                                maintenance under given data range*/

        $crtIDRes = checkAvailableSport($stfID,$courtName,$sportName,$database);
        $crtIDResult = $crtIDRes -> fetch_object();
        $courtID = $crtIDResult -> court_id; 

    $slotAvail = sprintf("SELECT * FROM `court_maintenance` WHERE (`startingDate` BETWEEN 
        '%s' AND '%s') OR (`endingDate` BETWEEN 
        '%s' AND '%s') AND `courtID` = '%s' AND `decision` = 'p'",
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

    $slotAvail = sprintf("SELECT `decision` FROM `branch_maintenance` WHERE (`startingDate` BETWEEN 
    '%s' AND '%s') OR (`endingDate` BETWEEN 
    '%s' AND '%s') AND `branchID` = '%s' AND `decision` = 'p'",
    $database -> real_escape_string($stDate),
    $database -> real_escape_string($endDate),
    $database -> real_escape_string($stDate),
    $database -> real_escape_string($endDate),
    $database -> real_escape_string($branchID));

    $result = $database -> query($slotAvail);
    
    return $result;
}



?>