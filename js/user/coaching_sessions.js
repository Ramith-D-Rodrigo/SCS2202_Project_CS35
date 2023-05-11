import {changeToLocalTime, capitalizeFirstLetter, disableElementsInMain, enableElementsInMain} from "../FUNCTIONS.js";
import {currency} from "../CONSTANTS.js";

//code for getting data from the server starts from line 479

const coachingSessionsContainer = document.querySelector('#coachingSessionsContainer');

let successflag = false;

const sportFilter = document.querySelector('#sportFilter');
const statusFilter = document.querySelector('#statusFilter');

let selectedSession = null; //to store the selected session for the feedback form or the leave session confirmation form
let selectedCoach = null;   //to store the selected coach for the feedback form 

const confirmBtn = document.querySelector('#confirmBtn'); //confirm button for session requests cancellation and leave session confirmation
const confirmationDiv = document.querySelector('#leaveSessionConfirmationDiv'); //popup div for session requests cancellation and leave session confirmation


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

const filterSessions = (e) => {
    const sessions = document.querySelectorAll('.session'); //select all session divs

    //first display all
    sessions.forEach(session => {
        session.style.display = '';
    });

    //then filter the by status
    if(statusFilter.value !== 'all'){
        sessions.forEach(session => {
            if(!session.classList.contains(statusFilter.value)){    //if the session doesn't have the selected status
                session.style.display = 'none';
            }
        });
    }

    //then filter by sport
    if(sportFilter.value !== 'all'){
        sessions.forEach(session => {
            if(!session.classList.contains(sportFilter.value)){    //if the session doesn't have the selected sport
                session.style.display = 'none';
            }
        });
    }
}

const findInputFieldValue = (inputName, btnDiv) => {    //a function to find the input field value of the given input name
    const hiddenInputs = btnDiv.querySelectorAll('input');
    const input = Array.from(hiddenInputs).find(currInput => currInput.name === inputName);
    return input.value;
}

const coachProfile = (e) => {   //a function to redirect to the coach profile page
    const btnDiv = e.target.parentElement;
    const coachID = findInputFieldValue('coachID', btnDiv);

    window.location.href = "/public/general/coach_profile.php?coachID=" + coachID;
    return;
}

const leaveSessionPopUp = (e) => {   //popup confirmation for leaving the session
    e.preventDefault();
    confirmBtn.value = 'leave';
    const btnDiv = e.currentTarget.parentElement;
    const sessionID = findInputFieldValue('sessionID', btnDiv);

    selectedSession = sessionID;    //store the session id

    confirmationDiv.style.display = 'block'; //display the confirmation div
    const header = confirmationDiv.querySelector('h2');

    header.innerHTML = "Are you sure you want to leave this session?";

    //add a small notice
    const notice = document.createElement('p');
    notice.innerHTML = "If you have any feedback for the coach, please add it before leaving the session.";

    notice.style.fontSize = '0.8rem';
    notice.style.marginTop = '4rem';

    notice.style.fontStyle = 'italic';

    header.appendChild(notice);

    //blur the main and disable click
    const main = document.querySelector('main');
    main.classList.add('main-blur');
    disableElementsInMain(main);
}

const leaveSession = (e) => {   //a function to leave the session functionality (upon confirmation)
    const formData = new FormData();
    formData.append('sessionID', selectedSession);

    let icon = null;    //for the icon to be displayed in the message box
    icon = document.createElement('i');
    icon.style.fontSize = '6rem';
    icon.style.margin = '4rem 0';

    //disable the confirm button
    confirmBtn.disabled = true;
    confirmBtn.style.cursor = 'not-allowed';
    confirmBtn.classList.add('disabled');

    //send the sessionID to the server
    fetch("../../controller/user/leave_coaching_session_controller.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(res => {
        if(res.ok){
            //success icon
            icon.classList.add('fas', 'fa-check-circle');
            icon.style.color = 'green';
        }
        else{
            //error icon
            icon.classList.add('fas', 'fa-times-circle', 'error-icon');
            icon.style.color = 'red';
        }

        selectedSession = null; //reset the selected session

        return res.json();
    })
    .then(data => { //for the message to be displayed in the message box
        //reset the confirm button
        confirmBtn.disabled = false;
        confirmBtn.style.cursor = 'pointer';
        confirmBtn.classList.remove('disabled');

        //close the popup
        popUpCancellation(e);

        const msgBox = document.querySelector('#msgBox');
        const msg = msgBox.querySelector("#msg");

        msg.innerHTML = data.msg;
        msg.appendChild(icon);

        //display the message box
        msgBox.style.display = 'block';

        //blur the main
        const main = document.querySelector('main');
        main.classList.add('main-blur');
        disableElementsInMain(main);

        main.addEventListener('click', function mainBlur(e){
            msgBox.style.display = 'none';
            main.classList.remove('main-blur');
            enableElementsInMain(main);
            main.removeEventListener('click', mainBlur);

            //refresh the page for new data
            window.location.reload();
        });
    })
    .catch(err => {
        console.error(err);
    });
}

const cancelSessionRequestPopUp = (e) => {   //popup confirmation for session request cancellation
    e.preventDefault();
    confirmBtn.value = 'cancel';
    //get session id from e's current target
    const btnDiv = e.currentTarget.parentElement;
    const sessionID = findInputFieldValue('sessionID', btnDiv);

    selectedSession = sessionID;    //store the session id

    confirmationDiv.style.display = 'block'; //display the confirmation div
    const header = confirmationDiv.querySelector('h2');

    header.innerHTML = "Are you sure you want to cancel your request to join this session?";

    //blur the main and disable click
    const main = document.querySelector('main');
    main.classList.add('main-blur');
    disableElementsInMain(main);
}

const cancelSessionRequest = (e) => {   //a function to cancel the session request functionality (upon confirmation)
    const formData = new FormData();

    formData.append('sessionID', selectedSession);

    let successflag = false;

    let icon = null;    //for the icon to be displayed in the message box
    icon = document.createElement('i');
    icon.style.fontSize = '6rem';
    icon.style.margin = '4rem 0';

    //disable the confirm button
    confirmBtn.disabled = true;
    confirmBtn.style.cursor = 'not-allowed';
    confirmBtn.classList.add('disabled');
    
    //send the request to the server
    fetch("../../controller/user/cancel_coaching_session_request_controller.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(res => {

        if(res.ok){
            successflag = true;
            const removingSession = document.getElementById(selectedSession); //select the session div
            removingSession.remove();   //remove the session div

            //successful icon
            icon.classList.add('fas', 'fa-check-circle', 'success-icon');
            icon.style.color = 'green';
        }
        else{
            //error icon
            icon.classList.add('fas', 'fa-times-circle', 'error-icon');
            icon.style.color = 'red';
        }
                //reset the selected session
        selectedSession = null;

        return res.json();
    })
    .then(data => { //for the message to be displayed in the message box
        //reset the confirm button
        confirmBtn.disabled = false;
        confirmBtn.style.cursor = 'pointer';
        confirmBtn.classList.remove('disabled');

        //close the popup
        popUpCancellation(e);

        const msgBox = document.querySelector('#msgBox');
        const msg = msgBox.querySelector("#msg");

        msg.innerHTML = data.msg;
        msg.appendChild(icon);
        msgBox.style.display = 'block';


        //display the message box
        msgBox.style.display = 'block';

        //blur the main
        const main = document.querySelector('main');
        main.classList.add('main-blur');
        disableElementsInMain(main);

        main.addEventListener('click', function mainBlur(e){
            msgBox.style.display = 'none';
            main.classList.remove('main-blur');
            enableElementsInMain(main);
            main.removeEventListener('click', mainBlur);
        });
    })
    .catch(err => {
        //console.log(err);
    });
}

const popUpCancellation = (e) => {   //close the confirmation div
    confirmationDiv.style.display = 'none';

    confirmBtn.value = '';  //reset the value of the confirm butto
    selectedSession = null; //reset the selected session

    const main = document.querySelector('main');
    main.classList.remove('main-blur');
    enableElementsInMain(main);
}

const popUpConfirmation = (e) => {   //close the confirmation div
    if(e.currentTarget.value === 'leave'){
        leaveSession(e);
    }else if(e.currentTarget.value === 'cancel'){
        cancelSessionRequest(e);
    }
}


const giveFeedbackPopUp = (e) => {   //give feedback popup
    e.stopPropagation();
    const btnDiv = e.currentTarget.parentElement;

    //need to get the coach id and session id 
    const coachID = findInputFieldValue('coachID', btnDiv);
    const sessionID = findInputFieldValue('sessionID', btnDiv);

    const feedbackDiv = document.querySelector('#coachFeedbackFormDiv');

    feedbackDiv.style.display = 'block'; //display the feedback div

    const feedbackHeader = feedbackDiv.querySelector("h2");

    feedbackHeader.innerHTML = "Give your thoughts about " + Array.from(coachSet).find(coach => coach.id === coachID).name;   //find the coach name and add it to the header

    const coachInput = feedbackDiv.querySelector("input");
    coachInput.value = coachID;  //set the coach id to the hidden input

    const sessionInput = coachInput.nextElementSibling;
    sessionInput.value = sessionID; //set the session id to the hidden input

    //blur the main
    const main = document.querySelector('main');
    main.classList.add('main-blur');

    //disable all inputs and buttons
    disableElementsInMain(main);

    main.addEventListener('click', function mainBlur(e){
        feedbackDiv.style.display = 'none';
        main.classList.remove('main-blur');
        enableElementsInMain(main);
        main.removeEventListener('click', mainBlur);

        //clear the rating colors
        for(let j = 0; j < stars.length; j++){  //reset the color of all the stars
            stars[j].style.color = "black";
        }

        //clear the error message
        const feedbackErrMsg = feedbackDiv.querySelector('#feedbackErrMsg');

        //clear the text area
        feedbackDiv.querySelector('textarea').value = "";
        feedbackErrMsg.innerHTML = "";
    });

    //add the event listener to the form submission
    const form = feedbackDiv.querySelector("form");
    form.addEventListener('submit', giveFeedback);
}

const giveFeedback = (e) => {   //give feedback functionality
    e.preventDefault();

    const feedbackFormDiv = document.querySelector('#coachFeedbackFormDiv');

    const feedbackForm = feedbackFormDiv.querySelector('form');

    const feedbackErrMsg = feedbackFormDiv.querySelector('#feedbackErrMsg');
    feedbackErrMsg.innerHTML = "";

    const formData = new FormData(feedbackForm);

    if(!feedbackForm.reportValidity() || !formData.get('feedback')){  //check if the form is valid
        feedbackErrMsg.innerHTML = "Please Enter Your Feedback";
        return;
    }
    else if(formData.get('feedback').length > 500){   //check if the feedback is too long
        feedbackErrMsg.innerHTML = "Feedback is too long";
        return;
    }
    else if(formData.get('feedback').length < 5){   //check if the feedback is too short
        feedbackErrMsg.innerHTML = "Feedback is too short";
        return;
    }

    //check rating stars
    let rating = 0;
    for(let i = 0; i < stars.length; i++){
        if(stars[i].style.color === "gold"){
            rating++;
        }
    }

    if(rating === 0){   //not rated
        feedbackErrMsg.innerHTML = "Please Give your Rating";
        return;
    }

    formData.append('rating', rating);

    let successflag = false;
    const icon = document.createElement('i'); //for the icon to be displayed in the message box
    icon.style.fontSize = '6rem';
    icon.style.color = 'green';

    //disable the submit button
    const submitBtn = feedbackForm.querySelector('input[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.style.cursor = 'not-allowed';
    submitBtn.classList.add('disabled');
    
    //send the feedback data to the server
    fetch("../../controller/user/give_coach_feedback_controller.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(res => {
        successflag = res.ok;
        return res.json();
    })
    .then(data => {
        //enable the submit button
        submitBtn.disabled = false;
        submitBtn.style.cursor = 'pointer';
        submitBtn.classList.remove('disabled');
        
        if(successflag){    //if the feedback is successfully sent
            feedbackFormDiv.style.display = 'none'; //close the feedback div

            const msgBox = document.querySelector('#msgBox');   //the message box
            const msg = msgBox.querySelector("#msg");

            msg.innerHTML = data.msg;
            icon.className = 'fas fa-check-circle';
            msg.appendChild(icon);
            msgBox.style.display = 'block';

            //blur the main
            const main = document.querySelector('main');
            main.classList.add('main-blur');
            disableElementsInMain(main);

            main.addEventListener('click', function mainBlur(e){    //one time event listener for the main
                msgBox.style.display = 'none';
                main.classList.remove('main-blur');
                enableElementsInMain(main);
                main.removeEventListener('click', mainBlur);
            });
        }
        else{
            feedbackErrMsg.innerHTML = data.msg;    //display the error message in the feedback div
        }
    })
    .catch(err => {
        //console.log(err);
    });
}


let sportSet = new Set();   //to store the sports of the coaching sessions
let coachSet = new Set();   //to store the coaches of the coaching sessions


//get the coaching sessions from the server
fetch("../../controller/user/coaching_sessions_controller.php")
    .then(res => {
        successflag = res.ok;
        return res.json();
    })
    .then(data => {
        if(successflag){
            for(let i = 0; i < data.coachingSessions.length; i++){
                //create a div for each coaching session
                const sessionDiv = document.createElement('div');
                sessionDiv.className = 'content-box';

                sessionDiv.classList.add("session");
                sessionDiv.id = data.coachingSessions[i].sessionID;

                //coach name
                const coachObj = {
                    name: data.coaches[data.coachingSessions[i].coachID].name,
                    sport: data.coaches[data.coachingSessions[i].coachID].sport,
                    id: data.coachingSessions[i].coachID,
                    photo: data.coaches[data.coachingSessions[i].coachID].photo
                }
                coachSet.add(coachObj);

                const imagesContainer = document.createElement('div');  //container for the images (both coach and sport)
                imagesContainer.className = 'images-container';
                //add coach image to the div
                const coachImgContainer = document.createElement('div');
                coachImgContainer.className = 'coach-img-container';

                const coachImg = document.createElement('img');
                coachImg.className = 'coach-img';
                coachImg.src = data.coaches[data.coachingSessions[i].coachID].photo;

                coachImg.setAttribute('onerror', 'this.src = "/styles/icons/no-results.png"');
                coachImgContainer.appendChild(coachImg);
                imagesContainer.appendChild(coachImgContainer);

                //add sport image to the div
                const sportImgContainer = document.createElement('div');
                sportImgContainer.className = 'sport-img-container';

                const sportImg = document.createElement('img');
                sportImg.className = 'sport-img';

                sportImg.src = "/uploads/sport_images/" + data.coaches[data.coachingSessions[i].coachID].sport.toLowerCase() + ".jpg";

                sportImgContainer.appendChild(sportImg);
                imagesContainer.appendChild(sportImgContainer);

                sessionDiv.appendChild(imagesContainer);

                //sport class for filtering
                sessionDiv.classList.add(data.coaches[data.coachingSessions[i].coachID].sport);
                sportSet.add(data.coaches[data.coachingSessions[i].coachID].sport);

                //session day
                const sessionDay = document.createElement('p');
                sessionDay.innerHTML = data.coachingSessions[i].day;
                sessionDiv.appendChild(sessionDay);

                //session time
                const sessionTime = document.createElement('p');
                sessionTime.innerHTML = changeToLocalTime(data.coachingSessions[i].startingTime) + " - " + changeToLocalTime(data.coachingSessions[i].endingTime);
                sessionDiv.appendChild(sessionTime);

                //session location
                const sessionLocation = document.createElement('p');
                sessionLocation.innerHTML = "Court " + data.courts[data.coachingSessions[i].courtID].name + " @ " + data.courts[data.coachingSessions[i].courtID].branch;
                sessionDiv.appendChild(sessionLocation);


                //status
                const sessionStatus = document.createElement('p');
                sessionStatus.innerHTML = capitalizeFirstLetter(data.coachingSessions[i].status);
                sessionDiv.appendChild(sessionStatus);

                //session fee
                const sessionFee = document.createElement('p');
                sessionFee.innerHTML =  data.coachingSessions[i].paymentAmount + " " + currency;
                sessionDiv.appendChild(sessionFee);

                //div cointaining buttons
                const btnDiv = document.createElement('div');
                btnDiv.className = 'btnDiv';

                //buttons and filtering based on status
                if(data.coachingSessions[i].status === "pending"){
                    const cancelBtn = document.createElement('button');
                    cancelBtn.className = 'cancelRequest';
                    cancelBtn.innerHTML = 'Cancel Request';
                    
                    //icon
                    const cancelIcon = document.createElement('i');
                    cancelIcon.style.margin = '0 0.5rem';
                    cancelIcon.className = 'fas fa-times';
                    cancelBtn.appendChild(cancelIcon);
                    btnDiv.appendChild(cancelBtn);

                    sessionDiv.appendChild(btnDiv);
                    sessionDiv.classList.add('pending');

                }
                else if(data.coachingSessions[i].status === "ongoing"){
                    //coach profile
                    const coachProfile = document.createElement('button');
                    coachProfile.innerHTML = 'Coach Profile';
                    coachProfile.className = 'coachProfile';  //to add event listeners

                    const coachProfileIcon = document.createElement('i');
                    coachProfileIcon.style.margin = '0 0.5rem';
                    coachProfileIcon.className = 'fas fa-user';
                    coachProfile.appendChild(coachProfileIcon);
                    btnDiv.appendChild(coachProfile);

                    //feedback button
                    const feedbackBtn = document.createElement('button');
                    feedbackBtn.innerHTML = 'Give Feedback';
                    feedbackBtn.className = 'feedbackBtn';  //to add event listeners

                    const feedbackIcon = document.createElement('i');
                    feedbackIcon.style.margin = '0 0.5rem';
                    feedbackIcon.className = 'fas fa-comment';
                    feedbackBtn.appendChild(feedbackIcon);

                    btnDiv.appendChild(feedbackBtn);
                    
                    //leave session button
                    const leaveBtn = document.createElement('button');
                    leaveBtn.innerHTML = 'Leave Session';
                    leaveBtn.className = 'leaveSession';  //to add event listeners

                    const leaveIcon = document.createElement('i');
                    leaveIcon.style.margin = '0 0.5rem';
                    leaveIcon.className = 'fas fa-sign-out-alt';
                    leaveBtn.appendChild(leaveIcon);
                    btnDiv.appendChild(leaveBtn);


                    sessionDiv.appendChild(btnDiv);
                    sessionDiv.classList.add('ongoing');                                   

                }
                else if(data.coachingSessions[i].status === "left"){
                    //coach profile
                    const coachProfile = document.createElement('button');
                    coachProfile.innerHTML = 'Coach Profile';
                    coachProfile.className = 'coachProfile';  //to add event listeners

                    const coachProfileIcon = document.createElement('i');
                    coachProfileIcon.style.margin = '0 0.5rem';
                    coachProfileIcon.className = 'fas fa-user';
                    coachProfile.appendChild(coachProfileIcon);
                    btnDiv.appendChild(coachProfile);

                    sessionDiv.appendChild(btnDiv);
                    sessionDiv.classList.add('left');
                
                }
                //add hidden inputs for sessionID and coachID
                const sessionID = document.createElement('input');
                sessionID.type = 'hidden';
                sessionID.value = data.coachingSessions[i].sessionID;
                sessionID.name = 'sessionID';
                btnDiv.appendChild(sessionID);

                const coachID = document.createElement('input');
                coachID.type = 'hidden';
                coachID.value = data.coachingSessions[i].coachID;
                coachID.name = 'coachID';
                btnDiv.appendChild(coachID);

                coachingSessionsContainer.appendChild(sessionDiv);
            }

            return sportSet;
        }

        //if no sessions
        const msgDiv = document.createElement('div');
        msgDiv.className = 'content-box';
        msgDiv.innerHTML = data.msg;
        coachingSessionsContainer.appendChild(msgDiv);
        
        return new Set();   //empty set


    }).then((sportSet) => { //filtering and adding event listeners

        //filtering
        sportSet.forEach(sport => { //add sports to the filter
            const option = document.createElement('option');
            option.value = sport;
            option.innerHTML = sport;
            sportFilter.appendChild(option);
        });


        sportFilter.addEventListener('change', filterSessions);

        statusFilter.addEventListener('change', filterSessions);

        //button event listeners

        //coach profile button
        const coachProfileBtns = document.querySelectorAll('.coachProfile');
        coachProfileBtns.forEach(btn => {
            btn.addEventListener('click', coachProfile);
        });

        //leave session button
        const leaveSessionBtns = document.querySelectorAll('.leaveSession');
        leaveSessionBtns.forEach(btn => {
            btn.addEventListener('click', leaveSessionPopUp);
        });

        //cancel session request button
        const cancelSessionBtns = document.querySelectorAll('.cancelRequest');
        cancelSessionBtns.forEach(btn => {
            btn.addEventListener('click', cancelSessionRequestPopUp);
        });

        //feedback button
        const feedbackBtns = document.querySelectorAll('.feedbackBtn');
        feedbackBtns.forEach(btn => {
            btn.addEventListener('click', giveFeedbackPopUp);
        });

        //popup button cancel event
        const popupCancelBtn = document.querySelector('#cancelBtn');

        popupCancelBtn.addEventListener('click', popUpCancellation);

        //popup button confirm event
        const popupConfirmBtn = document.querySelector('#confirmBtn');

        popupConfirmBtn.addEventListener('click', popUpConfirmation);

    });

