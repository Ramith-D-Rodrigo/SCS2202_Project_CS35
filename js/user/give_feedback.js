

const  feedbackBox = document.querySelector("#feedbackBox");
const cancelFeedbackBtn = document.querySelector("#cancelFeedback");
const submitFeedbackBtn = document.querySelector("#sendFeedback");

const validateFeedbackForm = (e) => {
    e.preventDefault();
    const feedbackForm = feedbackBox.querySelector("form");

    //get feedback form
    if(feedbackForm.reportValidity() === false){
        return false;
    }

    //check if the user has selected a rating
    const ratingStarsDiv = document.querySelector("#userRating");
    const stars = ratingStarsDiv.querySelectorAll("i");
    for(let i = 0; i < stars.length; i++){
        if(stars[i].style.color === "gold"){
            return true;
        }
    }

    return false;   //if the user has not selected a rating
}

//add event listener to the cancel feedback button
cancelFeedbackBtn.addEventListener("click", (e) => {
    e.preventDefault();
    //remove the reservation id from the session storage
    sessionStorage.removeItem("reservationID");


    const main = document.querySelector("main");

    //closing the authentication form
    main.classList.remove("main-darken");
    main.classList.remove("disabled");


    //add closing animation keyframes
    feedbackBox.animate([
        {top: "50%", transform: "translate(-50%, -50%)", opacity: 1},
        {top: "-50%", transform: "translate(-50%, -50%)", opacity: 0}
    ], {
        duration: 500,
        easing: "ease-in-out"
    }).finished.then(() => {    //when the animation is finished
        feedbackBox.style.display = "none";
            //reset the form
        feedbackBox.querySelector("form").reset();

        //clear the rating stars
        const ratingStarsDiv = document.querySelector("#userRating");
        const stars = ratingStarsDiv.querySelectorAll("i");
        for(let i = 0; i < stars.length; i++){
            stars[i].style.color = "black";
        }

        const msg = document.querySelector("#feedbackMsg");
        msg.innerHTML = "";
    });
});

const ratingStarsDiv = document.querySelector("#userRating");

//get star icons and add event listener to each star
const stars = ratingStarsDiv.querySelectorAll("i");
for(let i = 0; i < stars.length; i++){
    stars[i].addEventListener("click", (e) => {

        for(let j = 0; j < stars.length; j++){  //reset the color of all the stars
            stars[j].style.color = "black";
        }

        //get the checkbox associated with label star
        const ratingID = stars[i].getAttribute("id");
        //get the number of the star
        const starNum = ratingID.charAt(ratingID.length - 1);

        //color all the stars up to the selected star
        for(let j = 0; j < starNum; j++){
            stars[j].style.color = "gold";
        }

    });
}

feedbackBox.querySelector("form").addEventListener("submit", (e) => {
    const feedbackMsg = document.querySelector("#feedbackMsg");
    feedbackMsg.innerHTML = ""; //reset the feedback message
    if(validateFeedbackForm(e) === false){
        feedbackMsg.innerHTML = "Please select a Rating";
        feedbackMsg.style.color = "red";
        feedbackMsg.style.fontWeight = "bold";
        e.preventDefault();
        return;
    }

    //get the reservation id
    const reservationID = sessionStorage.getItem("reservationID");
    //remove the reservation id from the session storage
    sessionStorage.removeItem("reservationID");
    //get the feedback form
    const feedbackForm = feedbackBox.querySelector("form");
    //get the rating
    const ratingStarsDiv = document.querySelector("#userRating");
    const stars = ratingStarsDiv.querySelectorAll("i");
    let rating = 0;
    for(let i = 0; i < stars.length; i++){  //calculate the rating
        if(stars[i].style.color === "gold"){
            rating++;
        }
    }

    const formData = new FormData(feedbackForm);
    formData.append("reservationID", reservationID);
    formData.append("rating", rating);

    const userInput = JSON.stringify(Object.fromEntries(formData));

    //disable the submit button
    submitFeedbackBtn.disabled = true;
    submitFeedbackBtn.style.cursor = "not-allowed";
    submitFeedbackBtn.classList.add("disabled");

    //send the feedback to the server
    fetch("../../controller/user/give_feedback_controller.php", {
        method: "POST",
        body: userInput,
        Headers: {
            "Content-Type": "application/json"
        }     
    }).then((response) => {
        //close the feedback form
        cancelFeedbackBtn.click();

        //re-enable the submit button
        submitFeedbackBtn.disabled = false;
        submitFeedbackBtn.style.cursor = "pointer";
        submitFeedbackBtn.classList.remove("disabled");
        
        const msgBox = document.querySelector("#msgBox");
        //blur the main content and darken it
        const main = document.querySelector("main");
        main.classList.add("main-darken");
        main.classList.add("disabled");

        const msg = document.getElementById("msg");

        const icon = document.createElement("i");    //icon
        icon.style.fontSize = "2.5rem";
        icon.style.marginBottom = "1rem";

        if(response.ok){ //ok means the status code is 200
            //success icon
            icon.classList.add("fas", "fa-check-circle", "success-icon");
            msg.appendChild(icon);
            icon.style.color = "green";

            msg.innerHTML += "Thank You for Your Feedback";

            //update the reservation history table by refreshing the page

            //session storage to let know dismiss button to refresh the page
            sessionStorage.setItem("refreshPage", "true");

        }
        else{   //if the status code is not 200
            //error icon
            icon.classList.add("fas", "fa-times-circle", "error-icon");
            msg.appendChild(icon);
            icon.style.color = "red";

            msg.innerHTML += "Unable to Submit Feedback";
        }

        //display the message box
        msgBox.style.display = "block";

        return response.json();
        
    }).then((data) => {
        //console.log(data);
    }).catch((error) => {
        console.log(error);
    });
});





const init = () => {
    //get the give feedback buttons
    const feedbackButtons = document.querySelectorAll(".feedback-button");
    const feedbackForms = document.querySelectorAll(".feedback-form");

    //add event listener to each feedback button
    for(let i = 0; i < feedbackButtons.length; i++){
        feedbackButtons[i].addEventListener("click", (e) => {
            e.preventDefault();
            //get the reservation id
            const formData = new FormData(feedbackForms[i]);
            const resID = formData.get("reservationID");

            //store the reservation id in the session storage
            sessionStorage.setItem("reservationID", resID);

            //display the feedback form
            const feedbackFormDiv = document.querySelector("#feedbackBox");
            feedbackFormDiv.style.display = "block";

            const main = document.querySelector("main");
            main.classList.add("main-darken");
            main.classList.add("disabled");

            //scroll to the feedback form
            feedbackFormDiv.scrollIntoView({behavior: "smooth", block: "center"});
        });
    }
}

export { init };