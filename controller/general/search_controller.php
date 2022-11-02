<?php
    session_start();

    require_once("../../src/user/user.php");
    require_once("../../src/user/dbconnection.php");

    $user = new User();
    $sportName = htmlspecialchars($_POST['sportName']);

    $result = $user -> searchSport($sportName, $connection);  //search the sport

    $rows = $result -> fetch_object();

    if($rows === NULL){ //No matching results
        $_SESSION['searchErrorMsg'] = 'Sorry, Cannot find what you are looking For';
    }
    else{
        $_SESSION['description'] = $rows -> description;
    }
    header("Location: /public/general/search_results.php");
    $connection -> close();
?>