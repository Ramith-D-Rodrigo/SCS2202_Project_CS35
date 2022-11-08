<?php

    function generateUUID($database){
        $sql = 'SELECT UUID() AS UUID';

        $result = $database -> query($sql); //get the uuid

        $resultUUID = $result -> fetch_object();

        return $resultUUID -> UUID; //get the uuid value
    }


    function uuid_to_bin($uuid, $database){
        $sql = sprintf("SELECT UUID_TO_BIN('%s', true) AS uuid", $database -> real_escape_string($uuid));

        $result = $database -> query($sql);

        $row = $result -> fetch_object();

        return $row -> uuid;
    }

    function bin_to_uuid($uuid, $database){
        $sql = sprintf("SELECT BIN_TO_UUID('%s', true) AS uuid", $database -> real_escape_string($uuid));

        $result = $database -> query($sql);

        $row = $result -> fetch_object();

        return $row -> uuid;        
    }
?>