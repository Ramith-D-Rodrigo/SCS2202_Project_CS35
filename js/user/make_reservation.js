const reservationForm = document.querySelector('form');

import {updateTheReservationTables, createScheduleObjects} from '../general/reservation_schedule_functions.js';

import { currency } from '../CONSTANTS.js';

let sendingRequest = null;  //to store the reservation details
let stripe = null;  //to store the payment gateway
let cardElement = null;  //to store the card element

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

    sendingRequest = {
        "numOfPeople" : formData.get("numOfPeople"),
        "reservingStartTime" : formData.get("reservingStartTime"),
        "reservingEndTime" : formData.get("reservingEndTime"),
        "reservingDate" : formData.get("reservingDate"),
        "makeReserveBtn" : reserveBtn.value
    };

    //add the amount to the payment gateway
    const amount = document.getElementById("amount");
    amount.innerHTML = "You are paying " + currency + " ";
    amount.innerHTML += formData.get("reservationPrice");

    //payment gateway popup div display
    paymentGatewayPopup.style.display = "block";

    //scroll to the payment gateway and animate it
    paymentGatewayPopup.scrollIntoView({behavior: "smooth", block: "center"});
    
    //lower the opacity of the main content
    main.style.opacity = "0.5";

    //animate the opacity
    main.style.transition = "opacity 0.5s ease-in-out";

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
    stripe.createToken(cardElement).then((result) => {  //create the token
        if(result.error){   //if there is an error
            errorElement.textContent = result.error.message;
        }
        else{
            //animate the payment gateway popup
            animateGateWayClosing();
            main.click();

            //send the token to the server
            stripeTokenHandler(result.token);
        }
    });
});

//send the token to the server
const stripeTokenHandler = (token) => {
    const tokenID = token.id;
    sendingRequest.tokenID = tokenID;   //add the token to the request

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
        if(data.successMsg !== undefined){  //reservation success
            const successMsgBox = document.getElementById("successMsg");
            const errMsgBox = document.getElementById("errMsg");
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            successMsgBox.innerHTML = data.successMsg;

            //update the table
            const url = new URL(window.location);   //get the url
            const params = new URLSearchParams(url.search); //search parameters
            //console.log(params);
            const getReq = params.get("reserveBtn");
            //console.log(getReq);

            //update the reservation table
            fetch("../../controller/general/reservation_schedule_controller.php?reserveBtn=".concat(getReq))
                .then(res => res.json())
                .then(data => {
                    const scheduleObjs = createScheduleObjects(data);
                    sessionStorage.removeItem("schedule");   //remove the previous schedule
                    sessionStorage.setItem("schedule", JSON.stringify(scheduleObjs));
                    updateTheReservationTables(scheduleObjs);
                });
        }
        else if(data.errMsg !== undefined){  //reservation failed
            const successMsgBox = document.getElementById("successMsg");
            const errMsgBox = document.getElementById("errMsg");
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            errMsgBox.innerHTML = data.errMsg;
        }
    })
    .catch((err) => {
        console.log(err);
    });
}