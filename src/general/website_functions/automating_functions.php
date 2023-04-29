<?php
    //function to delete notifications that have been read and older than their lifetime period as specified in the database
    function deleteNotifications($database){
        $sql = "DELETE FROM `notification` WHERE `readTimeStamp` <= NOW() + INTERVAL `lifetime` HOUR AND status = 'Read'";
        $result = $database -> query($sql);
        return $result;
    }
?>