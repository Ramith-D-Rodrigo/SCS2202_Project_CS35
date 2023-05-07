import { verbose, MIN_RESERVATION_DAYS, MIN_RESERVATION_TIME_HOURS, MAX_RESERVATION_DAYS, MAX_RESERVATION_TIME_HOURS, currency } from "../CONSTANTS.js";

const reserveStartingTime = document.getElementById("reserveStartingTime");
const reserveEndingTime = document.getElementById("reserveEndingTime");
const reservationPrice = document.getElementById("reservationPrice");
const numOfPeople = document.getElementById("numOfPeople");

function userInputTimeCheck(e){ //this function check for valid time input (00 minutes check and the max and min time check (opening and closing time))
    const min = e.target.value.split(":")[1];

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

//function to add leading zeros to the date
function addLeadingZeros(date){
    let result = date;
    if(date < 10){
        result = "0" + date;
    }
    return result;
}

const today = new Date();
today.setHours(0,0,0,0); //set the time to 00:00:00:000 to avoid the date change
const reservationDate = document.getElementById("reservationDate");

const minDateObj = addDays(today, MIN_RESERVATION_DAYS);
const minDateStr = minDateObj.getFullYear() + "-" + addLeadingZeros(minDateObj.getMonth() + 1) + "-" + addLeadingZeros(minDateObj.getDate());

const maxDateObj = addDays(today, MAX_RESERVATION_DAYS);
const maxDateStr = maxDateObj.getFullYear() + "-" + addLeadingZeros(maxDateObj.getMonth() + 1) + "-" + addLeadingZeros(maxDateObj.getDate());

reservationDate.min = minDateStr;
reservationDate.max = maxDateStr;

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
    
    let minRevPrice = reservationPrice.min;
    let calulatedPrice = minRevPrice * timeDiffHours;

    //check for discount
    const discount = document.getElementById("discountInput");

    
    if(discount != null){ //calculate the price with the discount  
        //price without discount value
        const priceWithoutDiscount = document.getElementById("priceWithoutDiscount");
        priceWithoutDiscount.value = calulatedPrice;

        const discountValue = discount.value;
        minRevPrice = minRevPrice - (minRevPrice * (discountValue/100));

        calulatedPrice = minRevPrice * timeDiffHours;
    }

    reservationPrice.value = currency + " " +  parseFloat(calulatedPrice).toFixed(2);
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
        
    let minRevPrice = reservationPrice.min;
    let calulatedPrice = minRevPrice * timeDiffHours;
    //check for discount
    const discount = document.getElementById("discountInput");

    if(discount != null){ //calculate the price with the discount
        //price without discount value
        const priceWithoutDiscount = document.getElementById("priceWithoutDiscount");
        priceWithoutDiscount.value = calulatedPrice;

        const discountValue = discount.value;
        minRevPrice = minRevPrice - (minRevPrice * (discountValue/100));

        calulatedPrice = minRevPrice * timeDiffHours;
    }

    reservationPrice.value = currency + " " +  parseFloat(calulatedPrice).toFixed(2);
});


function validateForm(e){
    const errorMsg = document.getElementById("errMsg");
    if(reserveStartingTime.value > reserveEndingTime.value){
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