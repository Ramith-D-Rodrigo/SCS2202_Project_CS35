let reservationAndTimeStampArr = [];   //array of objects of reservation id and reserved timestamp

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

    //scroll to the authentication form and animate it
    authenticationFormDiv.scrollIntoView({behavior: "smooth", block: "center"});
    
    //blur the main content and darken it
    const main = document.querySelector("main");
    main.style.filter = "blur(5px)";
    //animate the blur effect
    main.style.transition = "filter 0.5s ease-in-out";

    //disable main 
    main.style.pointerEvents = "none";

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

    //italic the note
    altMsgDiv.style.fontStyle = "italic";
    altMsgDiv.style.fontAlign = "center";

    authenticationFormDiv.style.maxWidth = "4in";
    authenticationFormDiv.style.maxHeight = "4in";
}

const animateClose = (formDiv) => {
    const main = document.querySelector("main");

    //closing the authentication form should remove the blur effect
    main.style.filter = "blur(0px)";
    main.style.pointerEvents = "auto";

    formDiv.animate([
        {top: "50%", transform: "translate(-50%, -50%)", opacity: 1},
        {top: "-50%", transform: "translate(-50%, -50%)", opacity: 0}
    ], {
        duration: 500,
        easing: "ease-in-out"
    }).finished.then(() => {    //when the animation is finished
        formDiv.style.display = "none";
    });
}


const validateAuthForm = (e) => {
    //get auth form
    const authForm = document.querySelector("#authFormDiv form");
    const authMsg = document.querySelector("#authMsg");
    authMsg.innerHTML = "";

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

    console.log(cancelButtons);

    //add event listener to each cancel button
    for(let i = 0; i < cancelButtons.length; i++){
        cancelButtons[i].addEventListener("click", authFormDisplay); 
    }

    //cancel button event listener of the authentication form
    const authCancel = document.querySelector("#authCancel");
    authCancel.addEventListener("click", (e) => {   //cancel the authentication form
        e.preventDefault();
        const authenticationFormDiv = document.querySelector("#authFormDiv");

        //add closing animation keyframes
        animateClose(authenticationFormDiv);

        //remove the reservation id from the session storage
        sessionStorage.removeItem("reservationID");

        authenticationFormDiv.childNodes[1].reset();    //reset the form
    });

    //dismiss button event listener of the message box
    const dismiss = document.querySelector("#dismiss");
    dismiss.style.cursor = "pointer";
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
        //get the reservation id from the session storage
        //add the reservation id to the form data
        const formData = new FormData(authForm);

        //send the form data to the server
        fetch("../../controller/user/authentication_controller.php", {  //authentication first
            method: "POST",
            body: JSON.stringify(Object.fromEntries(formData)),
            Headers: {
                "Content-Type" : "application/json"
            }

        }).then((res) => {
            if(res.ok){ //ok means the status code is 200
                //can cancel the reservation
                //get the reservation id from the session storage
                const reservationID = sessionStorage.getItem("reservationID");

                //remove the reservation id from the session storage
                sessionStorage.removeItem("reservationID");

                //close the authentication form
                const authenticationFormDiv = document.querySelector("#authFormDiv");
                animateClose(authenticationFormDiv);
                
                //send the reservation id to the server
                fetch("../../controller/user/cancel_reservation_controller.php", {
                    method: "POST",
                    body: JSON.stringify({reservationID}),
                    Headers: {
                        "Content-Type" : "application/json"
                    }
                }).then((res) => {  //response from the server

                    const msgBox = document.querySelector("#msgBox");
                    //blur the main content and darken it
                    const main = document.querySelector("main");
                    main.style.filter = "blur(5px)";
                    //animate the blur effect
                    main.style.transition = "filter 0.5s ease-in-out";
                    //disable main 
                    main.style.pointerEvents = "none";

                    const msg = document.getElementById("msg");
                    msg.innerHTML = "";   //clear the message
                    msg.style.fontSize = "1.5rem";
                    msg.style.fontWeight = "bold";
                    msg.style.textAlign = "center";

                    const icon = document.createElement("i");    //icon
                    icon.style.fontSize = "2.5rem";
                    icon.style.marginBottom = "1rem";

                    if(res.ok){ //ok means the status code is 200
                        //success icon
                        icon.classList.add("fas", "fa-check-circle", "success-icon");
                        msg.appendChild(icon);
                        icon.style.color = "green";

                        msg.innerHTML += "Reservation Cancelled Successfully";

                        //update the reservation history table by refreshing the page

                        //session storage to let know dismiss button to refresh the page
                        sessionStorage.setItem("refreshPage", "true");

                    }
                    else{   //if the status code is not 200
                        //error icon
                        icon.classList.add("fas", "fa-times-circle", "error-icon");
                        msg.appendChild(icon);
                        icon.style.color = "red";

                        msg.innerHTML += "Unable to Cancel the Reservation";
                    }

                    //display the message box
                    msgBox.style.display = "block";
                })

            }
            else{   //if the status code is not 200
                const authMsg = document.querySelector("#authMsg");
                authMsg.innerHTML = "Invalid credentials";
                authMsg.style.color = "red";
                authMsg.style.fontWeight = "bold";
                authMsg.style.fontSize = "1.2rem";
                authMsg.style.marginTop = "0.5rem";
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



