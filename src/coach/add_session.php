<?php
    require_once("../../src/general/uuid.php");
   
    class Session{
   
    public function addsessiondetails($database){   //Joining sport, sport court, branch,
        $sql = sprintf("SELECT `b`.`requestStatus` AS branch_status,
        `sc`.`requestStatus` AS `court_status`, 
        `sc`.`courtID`, 
        `sc`.`courtName`, 
        `b`.`branchId`, 
        `b`.`city`, 
        `b`.`openingTime`, 
        `b`.`closingTime`, 
        `s`.`sportName`,
        `s`.`minCoachingSessionPrice` 
        FROM `sportsCourt` `sc`
        INNER JOIN  `branch` `b`
        ON `b`.`branchID` = `sc`.`branchID`
        INNER JOIN `sport` `s` 
        ON `s`.`sportID` = `sc`.`sportID`

        WHERE `s`.`sportID` = '%s'
        AND `b`.`requestStatus`= `a` ,
        AND `sc`.`requestStatus=`a`",
        $database -> real_escape_string($this -> userID));

        $result = $database -> query($sql);
        return $result;
   
    }
}
   ?>