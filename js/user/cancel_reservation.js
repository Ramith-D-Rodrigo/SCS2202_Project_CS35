let reservationAndTimeStampArr = [];   //array of objects of reservation id and reserved timestamp
const msg = document.getElementById("msg"); //message div

const authFormDisplay = (e) => {
    e.preventDefault();
    //get the reservation id
    const form = e.currentTarget.parentElement;
    const formData = new FormData(form);
    const reservationID = formData.get("reservationID");

    //store the reservation id in the session storage
    sessionStorage.setItem("reservationID", reservationID);

    //show the authentication form
    const authenticationFormDiv = document.querySelector("#authFormDiv");
    authenticationFormDiv.style.display = "block";

    
    //darken the main content and disable it
    const main = document.querySelector("main");
    main.classList.add("main-darken");
    main.classList.add("disabled");

    const altMsgDiv = document.querySelector("#altMsg");

    //get the reservation id and reserved timestamp array from the global variable
    const reservedTimeStamp = reservationAndTimeStampArr.filter(i => i.reservationID === reservationID)[0].reservedTimestamp;

    //get the current time
    const currentTime = new Date().getTime();
    
    //check if 3 days have passed since the reservation was made
    if(currentTime - reservedTimeStamp > 259200000){   //259200000 is 3 days in milliseconds
        //display the alternative message
        altMsgDiv.innerHTML = "Note : You are not eligible for a refund as 3 days have passed since the reservation was made.";
    }
    else{
        altMsgDiv.innerHTML = "Note : You are eligible for a refund if you cancel the reservation within 3 days of making the reservation.";
    }

}

const animateClose = async (formDiv) => {
    const main = document.querySelector("main");

    //closing the authentication form
    await formDiv.animate([
        {top: "50%", transform: "translate(-50%, -50%)", opacity: 1},
        {top: "-50%", transform: "translate(-50%, -50%)", opacity: 0}
    ], {
        duration: 500,
        easing: "ease-in-out"
    }).finished.then(() => {    //when the animation is finished
        main.classList.remove("main-darken");
        main.classList.remove("disabled");
        formDiv.style.display = "none";
    });
}


const validateAuthForm = (e) => {
    //get auth form
    const authForm = document.querySelector("#authFormDiv form");
    const authMsg = document.querySelector("#authMsg");
    authMsg.innerHTML = "";
    authMsg.classList.remove("altMsg-invalid");

    if(authForm.reportValidity() === false){
        return false;
    }
    return true;
}

const init = (reservationAndTimeStamp) => { //reservationAndTimeStamp is an array of objects of reservation id and reserved timestamp
    //get all the cancel buttons
    const cancelButtons = document.querySelectorAll(".cancel-button");
    const cancelForms = document.querySelectorAll(".cancel-form");

    reservationAndTimeStampArr = reservationAndTimeStamp;   //store the reservation id and reserved timestamp array in the global variable

    //console.log(cancelButtons);

    //add event listener to each cancel button
    for(let i = 0; i < cancelButtons.length; i++){
        cancelButtons[i].addEventListener("click", authFormDisplay); 
    }

    //cancel button event listener of the authentication form
    const authCancel = document.querySelector("#authCancel");
    authCancel.addEventListener("click", (e) => {   //cancel the authentication form
        e.preventDefault();
        const authenticationFormDiv = document.querySelector("#authFormDiv");
        const authMsg = document.querySelector("#authMsg");
        authMsg.innerHTML = "";

        //remove the reservation id from the session storage
        sessionStorage.removeItem("reservationID");

        authenticationFormDiv.childNodes[1].reset();    //reset the form
        //add closing animation keyframes
        animateClose(authenticationFormDiv);
    });

    //dismiss button event listener of the message box
    const dismiss = document.querySelector("#dismiss");
    dismiss.addEventListener("click", (e) => {
        e.preventDefault();
        const msgBox = document.querySelector("#msgBox");
        animateClose(msgBox);
        if(sessionStorage.getItem("refreshPage") === "true"){
            sessionStorage.removeItem("refreshPage");
            window.location.reload();
        }
    });


    //authentication form submit event listener
    const authForm = document.querySelector("#authFormDiv form");
    authForm.addEventListener("submit", (e) => {
        if(validateAuthForm(e) === false){
            e.preventDefault();
            return;
        }
        e.preventDefault();
        const formData = new FormData(authForm);

        //send the form data to the server
        fetch("../../controller/general/authentication_controller.php", {  //authentication first
            method: "POST",
            body: JSON.stringify(Object.fromEntries(formData)),
            Headers: {
                "Content-Type" : "application/json"
            }

        }).then(async (res) => {
            if(res.ok){ //ok means the status code is 200
                //can cancel the reservation
                //get the reservation id from the session storage
                const reservationID = sessionStorage.getItem("reservationID");

                //remove the reservation id from the session storage
                sessionStorage.removeItem("reservationID");

                //close the authentication form
                const authenticationFormDiv = document.querySelector("#authFormDiv");
                await animateClose(authenticationFormDiv);
                
                const msgBox = document.querySelector("#msgBox");
                //send the reservation id to the server
                fetch("../../controller/user/cancel_reservation_controller.php", {
                    method: "POST",
                    body: JSON.stringify({reservationID}),
                    Headers: {
                        "Content-Type" : "application/json"
                    }
                }).then((res) => {  //response from the server

                    //blur the main content and darken it
                    const main = document.querySelector("main");
                    main.classList.add("main-darken");
                    main.classList.add("disabled");

                    msg.innerHTML = "";   //clear the message

                    const icon = document.createElement("i");    //icon
                    icon.style.fontSize = "2.5rem";
                    icon.style.marginBottom = "1rem";

                    if(res.ok){ //ok means the status code is 200
                        //success icon
                        icon.classList.add("fas", "fa-check-circle", "success-icon");
                        msg.appendChild(icon);
                        icon.style.color = "green";

                        //update the reservation history table by refreshing the page

                        //session storage to let know dismiss button to refresh the page
                        sessionStorage.setItem("refreshPage", "true");

                    }
                    else{   //if the status code is not 200
                        //error icon
                        icon.classList.add("fas", "fa-times-circle", "error-icon");
                        msg.appendChild(icon);
                        icon.style.color = "red";
                    }

                    return res.json();
                })
                .then(data =>{
                    msg.innerHTML += data.msg;   //display the message
                    //display the message box
                    msgBox.style.display = "block";
                })

            }
            else{   //if the status code is not 200
                const authMsg = document.querySelector("#authMsg");
                authMsg.innerHTML = "Invalid credentials";
                authMsg.classList.add("altMsg-invalid");
                throw new Error("Invalid credentials");
            }
        })
        .catch((err) => {
            console.log(err);
        });
    });

}

//export the init function and the validateAuthForm function
export {init, validateAuthForm};



