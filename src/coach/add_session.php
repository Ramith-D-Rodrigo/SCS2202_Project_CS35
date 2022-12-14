<?php
    require_once("../../src/general/uuid.php");
   
    class Session{
   
    public function addsessiondetails($database){   //Joining sport, sport court, branch,
        $sql = sprintf("SELECT `b`.`request_status` AS branch_status,
        `sc`.`request_status` AS `court_status`, 
        `sc`.`court_id`, 
        `sc`.`court_name`, 
        `b`.`branch_id`, 
        `b`.`city`, 
        `b`.`opening_time`, 
        `b`.`closing_time`, 
        `s`.`sport_name`,
        `s`.`min_coaching_session_price` 
        FROM `sports_court` `sc`
        INNER JOIN  `branch` `b`
        ON `b`.`branch_id` = `sc`.`branch_id`
        INNER JOIN `sport` `s` 
        ON `s`.`sport_id` = `sc`.`sport_id`

        WHERE `s`.`sport_id` = '%s'
        AND `b`.`requrst_status`= `a` ,
        AND `sc`.`request_status=`a`",
        $database -> real_escape_string(uuid_to_bin($this -> userID, $database)));

        $result = $database -> query($sql);
        return $result;
   
    }
}
   ?>