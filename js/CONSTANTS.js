//all the constants related to the application are defined here
const verbose = true;

//constants regarding reservation goes here

const MIN_RESERVATION_TIME_HOURS = 1;  //minimum reservation time in hours (default is 1)
const MAX_RESERVATION_TIME_HOURS = 6;  //maximum reservation time in hours (default is 6)
const MIN_RESERVATION_DAYS = 3;    //minimum reservation date in days (default is 3)
const MAX_RESERVATION_DAYS = 30;   //maximum reservation date in days (default is 30)
const MIN_COACHING_SESSION_PERCENTAGE = 0.2; //minimum percentage of coaching session (default is 20%)

//seconds are not defined as they are always considered to be 0 for making reservations
//minutes are not defined as they are always considered to be 0 for making reservations

const currency = "LKR";

const MAX_COURT_COUNT = 10; //maximum number of courts that can be added to a branch (default is 10)

export {verbose, MAX_RESERVATION_DAYS, MIN_RESERVATION_DAYS, MAX_RESERVATION_TIME_HOURS, MIN_RESERVATION_TIME_HOURS, currency, MAX_COURT_COUNT, MIN_COACHING_SESSION_PERCENTAGE};