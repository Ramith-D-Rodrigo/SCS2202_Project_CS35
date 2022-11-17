<?php
    $resultArr = [];
    require_once("../../src/user/dbconnection.php");
    $sql = sprintf("SELECT * from `branch` WHERE city = 'Kiribathgoda'");
    $result = $connection -> query($sql);

    echo json_encode($result -> fetch_object() -> city);
?>