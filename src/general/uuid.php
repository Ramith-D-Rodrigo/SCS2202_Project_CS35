<?php

    function generateUUID($database){
        $sql = 'SELECT UUID() AS UUID';

        $result = $database -> query($sql); //get the uuid

        $resultUUID = $result -> fetch_object();

        return $resultUUID -> UUID; //get the uuid value
    }
?>