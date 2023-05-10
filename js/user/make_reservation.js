const reservationForm = document.querySelector('form');

import {updateTheReservationTables, createScheduleObjects} from '../general/reservation_schedule_functions.js';

import { currency } from '../CONSTANTS.js';

let sendingRequest = null;  //to store the reservation details
let stripe = null;  //to store the payment gateway
let cardElement = null;  //to store the card element
const cardHolderName = document.getElementById("card-holder-name");

const errorElement = document.getElementById("card-errors");
const paymentGatewayPopup = document.getElementById("paymentBox");
const main = document.querySelector("main");


const animateGateWayClosing = () => {
    paymentGatewayPopup.animate([
        {top: "50%", transform: "translate(-50%, -50%)", opacity: 1},
        {top: "-50%", transform: "translate(-50%, -50%)", opacity: 0}
    ], {
        duration: 500,
        easing: "ease-in-out"
    })
    .onfinish = () => {
        paymentGatewayPopup.style.display = "none";
        main.style.opacity = "1";
        //clear the card element
        cardElement.clear();
        errorElement.textContent = "";
        //clear the card holder name
        cardHolderName.value = "";

        //enable all buttons and inputs in the main content
        const buttons = main.querySelectorAll("button");
        const inputs = main.querySelectorAll("input");

        buttons.forEach((button) => {
            button.disabled = false;
        });
        inputs.forEach((input) => {
            input.disabled = false;
        });
    };
};

//get the publishable key from the server
fetch("../../controller/general/get_stripe_publishable_key_controller.php")
    .then((res) => res.json())
    .then((data) => {   //set the payment gateway
        //console.log(data);
        stripe = Stripe(data.publishableKey);

        const elements = stripe.elements();

        cardElement = elements.create("card");    //create the card element
        cardElement.mount("#card-element");
    });


reservationForm.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent the form from submitting
    const formData = new FormData(reservationForm);
    const reserveBtn = document.getElementById("makeReserveBtn");

    const errMsgBox = document.getElementById("errMsg");
    errMsgBox.innerHTML = "";

    const successMsgBox = document.getElementById("successMsg");
    successMsgBox.innerHTML = "";

    sendingRequest = {
        "numOfPeople" : formData.get("numOfPeople"),
        "reservingStartTime" : formData.get("reservingStartTime"),
        "reservingEndTime" : formData.get("reservingEndTime"),
        "reservingDate" : formData.get("reservingDate"),
        "courtID" : reserveBtn.value
    };

    //client side validation
    let clientValFlag = true;
    //get the schedule
    const schedules = Object.values(JSON.parse(sessionStorage.getItem("schedule")));
    //console.log(schedules);
    const reservingDate = new Date(sendingRequest.reservingDate);
    const reserveStartingTime = sendingRequest.reservingStartTime + ":00";
    const reserveEndingTime = sendingRequest.reservingEndTime + ":00";

    const reservingCourtSchedule = schedules.filter((schedule) => reserveBtn.value === schedule.courtID);

    //check if the reserving time is not in court maintenance time
    try{
        reservingCourtSchedule[0].courtMaintenance.forEach((maintenance) => {
            const maintenanceStartDate = new Date(maintenance.startingDate);
            const maintenanceEndDate = new Date(maintenance.endingDate);

            maintenanceStartDate.setHours(0, 0, 0, 0);
            maintenanceEndDate.setHours(23, 59, 59, 999);

            if(reservingDate >= maintenanceStartDate && reservingDate <= maintenanceEndDate){
                clientValFlag = false;
                throw new Error("The court is under maintenance at this time");
            }
        });
    }
    catch(err){
        if(err.name === "TypeError"){   //if there is no court maintenance
            clientValFlag = true;
        }
        else{
            errMsgBox.innerHTML = err.message;
            return;
        }
    }

    //check if the reserving time is in branch maintenance date
    try{
        //length - 1 because the last index has the branch maintenance schedule
        schedules[schedules.length - 1].forEach((maintenance) => {
            const maintenanceStartDate = new Date(maintenance.startingDate);
            const maintenanceEndDate = new Date(maintenance.endingDate);

            maintenanceStartDate.setHours(0, 0, 0, 0);
            maintenanceEndDate.setHours(23, 59, 59, 999);
    
            if(reservingDate >= maintenanceStartDate && reservingDate <= maintenanceEndDate){
                clientValFlag = false;
                throw new Error("The branch is under maintenance at this time");
            }
        });
    }
    catch(err){
        if(err.name === "TypeError"){   //if there is no branch maintenance
            clientValFlag = true;
        }
        else{
            errMsgBox.innerHTML = err.message;
            return;
        }
    }

    //check if the reserving time is in a coaching session
    try{
        reservingCourtSchedule[0].coachingSessions.forEach((coaching) => {
            const sessionStartDate = new Date(coaching.startDate);
            const sessionCancelDate = new Date(coaching.cancelDate);

            sessionStartDate.setHours(0, 0, 0, 0);
            if(sessionCancelDate != "Invalid Date"){
                sessionCancelDate.setHours(23, 59, 59, 999);
            }

            const day = reservingDate.toLocaleDateString('en-US', { weekday: 'long' });
            if(day === coaching.day && sessionStartDate <= reservingDate && (sessionCancelDate == "Invalid Date" || sessionCancelDate >= reservingDate)){
                //4 cases
                const startingTimeObj = new Date(coaching.startingTime);
                const endingTimeObj = new Date(coaching.endingTime);
    
                const startingTime = startingTimeObj.toLocaleTimeString('en-US', { hour12: false });
                const endingTime = endingTimeObj.toLocaleTimeString('en-US', { hour12: false });
    
                //1. the reserving time is in the middle of the coaching session
                if(reserveStartingTime >= startingTime && reserveEndingTime <= endingTime){
                    clientValFlag = false;
                }
    
                //2. the reserve starting start time is before the coaching session start time but the reserve ending time is in the middle of the coaching session
                else if(reserveStartingTime < startingTime && reserveEndingTime > startingTime && reserveEndingTime <= endingTime){
                    clientValFlag = false;
                }
    
                //3. the reserve starting start time is in the middle of the coaching session but the reserve ending time is after the coaching session end time
                else if(reserveStartingTime >= startingTime && reserveStartingTime < endingTime && reserveEndingTime > endingTime){
                    clientValFlag = false;
                }
    
                //4. the reserve starting start time is before the coaching session start time and the reserve ending time is after the coaching session end time
                else if(reserveStartingTime < startingTime && reserveEndingTime > endingTime){
                    clientValFlag = false;
                }

                if(!clientValFlag){
                    throw new Error("The Time is already reserved for a Coaching Session");
                }
            }  
        });
    }
    catch(err){
        if(err.name === "TypeError"){   //if there is no coaching session
            clientValFlag = true;
        }
        else{
            errMsgBox.innerHTML = err.message;
            return;
        }
    }

    //check if the reserving time is in a reservation
    try{
        reservingCourtSchedule[0].reservations.forEach((reservation) => {
            const startingTime = new Date(reservation.startingTime);
            const endingTime = new Date(reservation.endingTime);
    
            const checkingReservationDate = startingTime.toISOString().split('T')[0];
    
            if(checkingReservationDate === sendingRequest.reservingDate){
                const startingTimeStr = startingTime.toLocaleTimeString('en-US', { hour12: false });
                const endingTimeStr = endingTime.toLocaleTimeString('en-US', { hour12: false });
    
                //4 cases
                //1. the reserving time is in the middle of the reservation
                if(reserveStartingTime >= startingTimeStr && reserveEndingTime <= endingTimeStr){
                    clientValFlag = false;
                    //console.log("middle");
                    throw new Error("The Time is already reserved");
                }
    
                //2. the reserve starting start time is before the reservation start time but the reserve ending time is in the middle of the reservation
                else if(reserveStartingTime < startingTimeStr && reserveEndingTime > startingTimeStr && reserveEndingTime <= endingTimeStr){
                    clientValFlag = false;
                    //console.log("before");
                    throw new Error("The Time is already reserved");
                }
    
                //3. the reserve starting start time is in the middle of the reservation but the reserve ending time is after the reservation end time
                else if(reserveStartingTime >= startingTimeStr && reserveStartingTime < endingTimeStr && reserveEndingTime > endingTimeStr){
                    clientValFlag = false;
                    //console.log("after");
                    throw new Error("The Time is already reserved");
                }
    
                //4. the reserve starting start time is before the reservation start time and the reserve ending time is after the reservation end time
                else if(reserveStartingTime < startingTimeStr && reserveEndingTime > endingTimeStr){
                    clientValFlag = false;
                    //console.log("before and after");
                    throw new Error("The Time is already reserved");
                }
            }
        });
    }
    catch(err){
        if(err.name === "TypeError"){   //if there is no reservation
            clientValFlag = true;
        }
        else{
            errMsgBox.innerHTML = err.message;
            return;
        }
    }

    //add the amount to the payment gateway
    const amount = document.getElementById("amount");
    amount.innerHTML = "You are paying "+ " ";
    amount.innerHTML += formData.get("reservationPrice");   //currency is already added in formData

    //payment gateway popup div display
    paymentGatewayPopup.style.display = "block";

    //scroll to the payment gateway and animate it
    paymentGatewayPopup.scrollIntoView({behavior: "smooth", block: "center"});
    
    //lower the opacity of the main content
    main.style.opacity = "0.5";

    //animate the opacity
    main.style.transition = "opacity 0.5s ease-in-out";

    //disable all buttons and inputs in the main content
    const buttons = main.querySelectorAll("button");
    const inputs = main.querySelectorAll("input");
    
    buttons.forEach((button) => {
        button.disabled = true;
    });
    inputs.forEach((input) => {
        input.disabled = true;
    });

    //click event listener for the close button
    main.addEventListener("click", function mainClick(){
        animateGateWayClosing();
        //remove the event listener
        main.removeEventListener("click", mainClick);
    });
});

//payent form event listener
const paymentForm = document.querySelector("#payment-form");

paymentForm.addEventListener("submit", (event) => {
    event.preventDefault(); //prevent the form from submitting

    stripe.createToken(cardElement, {
        name: cardHolderName.value
    }).then((result) => {  //create the token
        if(result.error){   //if there is an error
            errorElement.textContent = result.error.message;
        }
        else{
            //send the token to the server
            stripeTokenHandler(result.token);
        }
    });
});

//send the token to the server
const stripeTokenHandler = (token) => {
    const tokenID = token.id;
    sendingRequest.tokenID = tokenID;   //add the token to the request

    //pay button to please wait
    const payBtn = document.getElementById("paymentGatewaySubmitBtn");
    payBtn.innerHTML = "Please wait...";
    payBtn.classList.add("disabled");
    payBtn.disabled = true;



    fetch("../../controller/user/make_reservation_controller.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify(sendingRequest)
    })
    .then((res) => res.json())
    .then((data) => {
        //console.log(data);
        sendingRequest = null;  //clear the request
        
        if(data.successMsg !== undefined){  //reservation success
            const successMsgBox = document.getElementById("successMsg");
            const errMsgBox = document.getElementById("errMsg");
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            successMsgBox.innerHTML = data.successMsg;

        }
        else if(data.errMsg !== undefined){  //reservation failed
            const successMsgBox = document.getElementById("successMsg");
            const errMsgBox = document.getElementById("errMsg");
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            errMsgBox.innerHTML = data.errMsg;
        }

        //update the table
        const url = new URL(window.location);   //get the url
        const params = new URLSearchParams(url.search); //search parameters

        //update the reservation table
        fetch("../../controller/general/reservation_schedule_controller.php?" + params)
            .then(res => res.json())
            .then(data => {
                const scheduleObjs = createScheduleObjects(data);
                sessionStorage.removeItem("schedule");   //remove the previous schedule
                sessionStorage.setItem("schedule", JSON.stringify(scheduleObjs));
                updateTheReservationTables(scheduleObjs, data);
            })
            .then(() => {
                //animate the payment gateway popup
                animateGateWayClosing();
                main.click();

                //reset the pay button
                payBtn.innerHTML = "Pay Now";
                payBtn.classList.remove("disabled");
                payBtn.disabled = false;
            })

    })
    .catch((err) => {
        console.log(err);
    });
}