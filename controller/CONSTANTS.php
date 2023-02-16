<?php
    //The application's constants are defined in this script
    //This only affects Server side, to Affect Client Side, make sure to change the Javascript constants file located in js folder

    //constants regarding reservation goes here

    define("MIN_RESERVATION_TIME_HOURS", 1);  //minimum reservation time in hours (default is 1)
    define("MAX_RESERVATION_TIME_HOURS", 6);  //maximum reservation time in hours (default is 6)
    define("MIN_RESERVATION_DAYS", 3);    //minimum reservation date in days (default is 3)
    define("MAX_RESERVATION_DAYS", 30);   //maximum reservation date in days (default is 30)

    //seconds are not defined as they are always considered to be 0 to making reservations
    //minutes are not defined as they are always considered to be 0 or 30 to making reservations

    define("CURRENCY", "LKR");  //currency used in the application (default is LKR)

?>