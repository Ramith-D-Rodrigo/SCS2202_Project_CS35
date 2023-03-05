<?php
    //The application's constants are defined in this script
    //This only affects Server side, to Affect Client Side, make sure to change the Javascript constants file located in js folder

    //constants regarding reservation goes here

    define("MIN_RESERVATION_TIME_HOURS", 1);  //minimum reservation time in hours (default is 1)
    define("MAX_RESERVATION_TIME_HOURS", 6);  //maximum reservation time in hours (default is 6)
    define("MIN_RESERVATION_DAYS", 3);    //minimum reservation date in days (default is 3)
    define("MAX_RESERVATION_DAYS", 30);   //maximum reservation date in days (default is 30)
    define("MIN_COACHING_SESSION_PERCENTAGE", 0.2);  //minimum coaching session percentage (default is 0.25)

    //seconds are not defined as they are always considered to be 0 to making reservations
    //minutes are not defined as they are always considered to be 0 or 30 to making reservations

    define("CURRENCY", "LKR");  //currency used in the application (default is LKR)

    define("SERVER_TIMEZONE", "Asia/Colombo");  //the timezone of the server (default is Asia/Colombo)

    define("MAX_COURT_COUNT", 10); //maximum number of courts in a branch (default is 10)

    //array to store the alphabet characters
    $alphabet = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
    );

    define("ALPHABET", $alphabet);  //the alphabet array

    define("NOTIFICATION_LIFE_TIME_DAYS", 3);  //the life time of a notification in days (default is 3 days)
    define("NOTIFICATION_LIFE_TIME_HOURS", 24 * NOTIFICATION_LIFE_TIME_DAYS);  //the life time of a notification in hours 
?>