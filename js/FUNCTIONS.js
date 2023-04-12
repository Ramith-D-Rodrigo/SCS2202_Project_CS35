const changeToLocalTime = (time) => {
    //split the time
    const timeArr = time.split(":");
    const hours = parseInt(timeArr[0]);
    const minutes = parseInt(timeArr[1]);
    const seconds = parseInt(timeArr[2]);

    const date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    date.setSeconds(seconds);

    const localTime = date.toLocaleTimeString();
    return localTime;
}

const capitalizeFirstLetter = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

const disableElementsInMain = (mainElement) => {
    const buttons = mainElement.querySelectorAll("button");
    const inputs = mainElement.querySelectorAll("input");
    const selects = mainElement.querySelectorAll("select");
    const textareas = mainElement.querySelectorAll("textarea");
    const radios = mainElement.querySelectorAll("radio");
    const checkboxes = mainElement.querySelectorAll("checkbox");

    const elements = [...buttons, ...inputs, ...selects, ...textareas, ...radios, ...checkboxes];

    elements.forEach((element) => {
        element.disabled = true;
    });

}

const enableElementsInMain = (mainElement) => {
    const buttons = mainElement.querySelectorAll("button");
    const inputs = mainElement.querySelectorAll("input");
    const selects = mainElement.querySelectorAll("select");
    const textareas = mainElement.querySelectorAll("textarea");
    const radios = mainElement.querySelectorAll("radio");
    const checkboxes = mainElement.querySelectorAll("checkbox");

    const elements = [...buttons, ...inputs, ...selects, ...textareas, ...radios, ...checkboxes];

    elements.forEach((element) => {
        element.disabled = false;
    });
}

const togglePassword = (button, passwordInput) => {
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        button.querySelector("i").classList.remove("fa-eye");
        button.querySelector("i").classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        button.querySelector("i").classList.remove("fa-eye-slash");
        button.querySelector("i").classList.add("fa-eye");
    }
}

const feedbackPagination = (newPage, currPage, feedbackContainer, feedbackArr, maxFeedbackCount, nextBtn, prevBtn, options = {name : true, date : true}) => {
    //feedback range
    const start = (newPage - 1) * maxFeedbackCount;
    const end = start + maxFeedbackCount;

    currPage = newPage;

    feedbackContainer.innerHTML = "";   //clear the feedback container

    for(let i = start; i < end && i < feedbackArr.length; i++){
        const currUserFeedback = document.createElement("div");
        const currUserFeedbackHeader = document.createElement("div");
        const currUserFeedbackBody = document.createElement("div");

        currUserFeedbackHeader.className = "feedback-header";

        for(let j = 1; j <= 5; j++){
            const star = document.createElement("i");
            star.className = "fa-solid fa-star";
            currUserFeedbackHeader.appendChild(star);

            if(j <= feedbackArr[i].rating){
                star.classList.add("checked");
            }
        }

        currUserFeedbackBody.innerHTML = feedbackArr[i].description;

        currUserFeedback.appendChild(currUserFeedbackHeader);
        currUserFeedback.appendChild(currUserFeedbackBody);

        //options is for adding the name and date of the feedback (optional)
        if(options.name || options.date){
            const currUserFeedbackFooter = document.createElement("div");
            currUserFeedbackFooter.className = "feedback-footer";
            if(options.name){
                currUserFeedbackFooter.innerHTML = feedbackArr[i].userFullName;
            }
            if(options.date){
                currUserFeedbackFooter.innerHTML += " On " + feedbackArr[i].date;
            }
            currUserFeedback.appendChild(currUserFeedbackFooter);
        }

        feedbackContainer.appendChild(currUserFeedback);
    }

    //enable next if there are more feedbacks
    if(feedbackArr.length > end){
        nextBtn.classList.remove("disabled");
    }
    else{
        nextBtn.classList.add("disabled");
    }

    //enable previous if there are previous feedbacks
    if(currPage > 1){
        prevBtn.classList.remove("disabled");
    }
    else{
        prevBtn.classList.add("disabled");
    }
}



export {changeToLocalTime, capitalizeFirstLetter, disableElementsInMain, enableElementsInMain, togglePassword, feedbackPagination};