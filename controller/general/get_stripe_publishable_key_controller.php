<?php
    //this script is used to get the stripe publishable key
    require_once("../../config.php");

    header("Content-Type: application/json");
    echo json_encode(array("publishableKey" => STRIPE_PUBLISHABLE_KEY));
?>