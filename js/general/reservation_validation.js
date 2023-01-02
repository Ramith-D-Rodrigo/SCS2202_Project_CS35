import { verbose, MIN_RESERVATION_DAYS, MIN_RESERVATION_TIME_HOURS, MAX_RESERVATION_DAYS, MAX_RESERVATION_TIME_HOURS } from "../CONSTANTS.js";

const reserveStartingTime = document.getElementById("reserveStartingTime");
const reserveEndingTime = document.getElementById("reserveEndingTime");
const reservationPrice = document.getElementById("reservationPrice");
const numOfPeople = document.getElementById("numOfPeople");

function userInputTimeCheck(e){ //this function check for valid time input (00 minutes check and the max and min time check (opening and closing time))
    const min = e.target.value.split(":")[1];
    if(verbose){
        //console.log(e.target.value);
        //console.log(min)   //get the minutes
    }

    if(!(min == '00') || !(e.target.min <= e.target.value && e.target.max >= e.target.value)){
        e.target.style.border = "medium solid red";
    }
    else{
        e.target.style.border = "none";
    }
}

reserveStartingTime.addEventListener('change', userInputTimeCheck);

reserveEndingTime.addEventListener('change', userInputTimeCheck);

//date constraints

function addDays(date, days){   //function to add days
    let result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

const today = new Date().toLocaleDateString();
const reservationDate = document.getElementById("reservationDate");

const minDateObj = addDays(today, MIN_RESERVATION_DAYS);
minDateObj.setHours(12);    //set the time to 12:00 to avoid the date change
const minDate = minDateObj.toISOString().split("T")[0];

const maxDateObj = addDays(today, MAX_RESERVATION_DAYS);
maxDateObj.setHours(12);    //set the time to 12:00 to avoid the date change
const maxDate = maxDateObj.toISOString().split("T")[0];

reservationDate.min = minDate;
reservationDate.max = maxDate;
//price calculation

reserveStartingTime.addEventListener('change', (e)=>{
    const errorMsg = document.getElementById("errMsg");
    if(reserveEndingTime.value === ""){
        return;
    }
    const startingTime = e.target.value.split(":");
    const endingTime = reserveEndingTime.value.split(":");

    const start = new Date();
    start.setHours(startingTime[0]);
    start.setMinutes(startingTime[1]);

    const end = new Date();
    end.setHours(endingTime[0])
    end.setMinutes(endingTime[1]);

    const timeDiffMilli = end - start;
    if(timeDiffMilli <= 0){ //ending time is lower than starting time
        reservationPrice.value = "";
        errorMsg.innerHTML = "Invalid Time Range";
        return;
    }
    errorMsg.innerHTML = "";

    if(e.target.style.border === "medium solid red" || reserveEndingTime.style.border === "medium solid red"){  //invalid time input
        reservationPrice.value = "";
        return;
    }

    const timeDiffHours = ((timeDiffMilli/1000)/60)/60;
    console.log(timeDiffHours);

    if(timeDiffHours < MIN_RESERVATION_TIME_HOURS){  //minimum reservation time period
        errorMsg.innerHTML = "Minimum Reservation Period is 1 Hour";
        reservationPrice.value = "";
        return;
    }
    else if(timeDiffHours > MAX_RESERVATION_TIME_HOURS){ //maximum reservation time period
        errorMsg.innerHTML = "Maximum Reservation Period is 6 Hours";
        reservationPrice.value = "";
        return;
    }
    
    const minRevPrice = reservationPrice.min;
    const calulatedPrice = minRevPrice * timeDiffHours;
    reservationPrice.value = calulatedPrice;
});

reserveEndingTime.addEventListener('change', (e)=>{
    const errorMsg = document.getElementById("errMsg");
    if(reserveStartingTime.value === ""){
        return;
    }
    const endingTime = e.target.value.split(":");
    const startingTime = reserveStartingTime.value.split(":");

    const start = new Date();
    start.setHours(startingTime[0]);
    start.setMinutes(startingTime[1]);

    const end = new Date();
    end.setHours(endingTime[0])
    end.setMinutes(endingTime[1]);



    if(e.target.style.border === "medium solid red" || reserveStartingTime.style.border === "medium solid red"){  //invalid time input
        reservationPrice.value = "";
        return;
    }
    const timeDiffMilli = end - start;
    if(timeDiffMilli <= 0){ //ending time is lower than starting time
        errorMsg.innerHTML = "Invalid Time Range";
        reservationPrice.value = "";
        return;
    }
    errorMsg.innerHTML = "";
    const timeDiffHours = ((timeDiffMilli/1000)/60)/60;

    if(timeDiffHours < MIN_RESERVATION_TIME_HOURS){  //minimum reservation time period
        errorMsg.innerHTML = "Minimum Reservation Period is 1 Hour";
        reservationPrice.value = "";
        return;
    }
    else if(timeDiffHours > MAX_RESERVATION_TIME_HOURS){ //maximum reservation time period
        errorMsg.innerHTML = "Maximum Reservation Period is 6 Hours";
        reservationPrice.value = "";
        return;
    }
    errorMsg.innerHTML = "";
    console.log(timeDiffHours);
    
    const minRevPrice = reservationPrice.min;
    const calulatedPrice = minRevPrice * timeDiffHours;
    reservationPrice.value = calulatedPrice;
});


function validateForm(e){
    const errorMsg = document.getElementById("errMsg");
    if(reserveStartingTime.value > reserveEndingTime.value){
        console.log(reserveStartingTime, reserveEndingTime);
        errorMsg.innerHTML = "Time Range is wrong. Please check again";
        return false;
    }
    errorMsg.innerHTML = "";    //reset the error message

    const form = document.querySelector("form");
    if(reservationPrice.value === "" || form.reportValidity() === false){
        errorMsg.innerHTML = "Please Enter Information Correctly";
        return false;
    }
    errorMsg.innerHTML = "";

    const isUserloggedIn = document.getElementById("logout");   //get the div element of id logout, this is to check if the user is logged in or not
    //if the user is loggedin, this is will return the div element, otherwise null
    if(isUserloggedIn === null){
        errorMsg.innerHTML = "Please Log in to Make a Reservation";
        return false;
    }

    errorMsg.innerHTML = "";
    return true;
}

window.validateForm = validateForm; //export the function to be used in the html file