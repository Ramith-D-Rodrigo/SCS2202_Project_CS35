//all the constants related to the application are defined here
const verbose = false;

//constants regarding reservation goes here

const MIN_RESERVATION_TIME_HOURS = 1;  //minimum reservation time in hours (default is 1)
const MAX_RESERVATION_TIME_HOURS = 6;  //maximum reservation time in hours (default is 6)
const MIN_RESERVATION_DAYS = 3;    //minimum reservation date in days (default is 3)
const MAX_RESERVATION_DAYS = 30;   //maximum reservation date in days (default is 30)
const MIN_COACHING_SESSION_PERCENTAGE = 0.2; //minimum percentage of coaching session (default is 20%)
const MAX_REFUND_DAYS = 3;  //maximum number of days to refund the payment  (default is 3) (after 3 days of the reserved date, the payment will not be refunded)

//seconds are not defined as they are always considered to be 0 for making reservations
//minutes are not defined as they are always considered to be 0 for making reservations

const currency = "LKR";

const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

const MAX_COURT_COUNT = 10; //maximum number of courts that can be added to a branch (default is 10)

const MAX_FEEDBACK_DISPLAY_COUNT = 5; //maximum number of feedbacks to be displayed in the feedback page (default is 10)

//constants regarding user goes here
const MIN_USER_REGISTRATION_AGE = 14;    //minimum age for registration (default is 14)
const MAX_USER_PROFILE_PICTURE_SIZE = 1048576;  //maximum size of the profile picture in bytes (default is 1MB)

export {verbose, MAX_RESERVATION_DAYS, MIN_RESERVATION_DAYS, MAX_RESERVATION_TIME_HOURS, 
    MIN_RESERVATION_TIME_HOURS, currency, MAX_COURT_COUNT, MIN_COACHING_SESSION_PERCENTAGE
    , MAX_FEEDBACK_DISPLAY_COUNT, MIN_USER_REGISTRATION_AGE, MAX_USER_PROFILE_PICTURE_SIZE, weekdays, MAX_REFUND_DAYS};

