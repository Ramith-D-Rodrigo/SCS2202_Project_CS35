<?php

session_start();
// require_once("../../src/general/branch.php");
require_once("../../src/general/sport.php");
// require_once("../../src/general/manager.php");
require_once("../../src/manager_db_connection.php");

$sport_obj = new Sport();

$sport_obj -> getDetails($connection,['sportID','reservationPrice']);

$sportASSOC = json_decode(json_encode($sport_obj), true);

$returnMsg = ['sportID' => $sportASSOC['sportID'], 'reservationPrice' => $sportASSOC['reservationPrice']];

echo json_encode($returnMsg);





?>