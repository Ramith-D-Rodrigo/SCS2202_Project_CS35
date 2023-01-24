<?php
    session_start();
    require_once("../../src/general/actor.php");
    require_once("../../src/general/security.php");

    $userInput = json_decode(file_get_contents("php://input"), true);
    
    
    




?>