const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const coachID = params.get("coachID");

//session objects stored in this array
let sessions = [];

//maximum number of students for the sport
let maxStudents = 0;

let branchSet = new Set();  //to store the branch names
let branchSessionMap = new Map();   //to map the branch to the sessions

const sessionBranches = document.querySelector("#sessionBranches"); //branches that the coach conducts the sessions
const coachingSessions = document.querySelector("#coachingSessions");   //sessions that the coach conducts by branch
const requestingSessionBranch = document.querySelector("#requestingSessionBranch"); //join request form branch selection
const requestingSession = document.querySelector("#requestingSession");   //join request form session selection

const sessionInfo = (e) => {    //function to get the session info when a session is selected
    let sessionID = null;
    if(e.target.id === "coachingSessions"){    //if the event is triggered from the coach profile container
        sessionID = coachingSessions.value;   //get the session id
    }
    else if(e.target.id === "requestingSession"){  //if the event is triggered from the join request form
        sessionID = requestingSession.value;   //get the session id
    }

    sessions.forEach(session => {
        //selecting the inserting fields
        const timePeriod = document.querySelector("#timePeriod");
        const day = document.querySelector("#day");
        const startingTime = document.querySelector("#startingTime");
        const endingTime = document.querySelector("#endingTime");
        const courtName = document.querySelector("#courtName");
        const noOfStudents = document.querySelector("#noOfStudents");
        const paymentAmount = document.querySelector("#paymentAmount");
        

        if(session.sessionID === sessionID){ //if the session is found
            if(e.target.id === "coachingSessions"){    //if the event is triggered from the coach profile container
                //insert the session info
                timePeriod.value = session.timePeriod;
                day.value = session.day;
                startingTime.value = session.startingTime;
                endingTime.value = session.endingTime;
                courtName.value = session.courtName;
                noOfStudents.value = session.noOfStudents;
                paymentAmount.value = session.paymentAmount;

                if(parseInt(session.noOfStudents) >= parseInt(maxStudents)){   //if the session is full
                    noOfStudents.style.color = "red";
                    noOfStudents.setAttribute("title", "This Session has Reached the Maximum Number of Students");                
                }
            }
            else if(e.target.id === "requestingSession"){  //if the event is triggered from the join request form
                const sessionFee = document.querySelector("#sessionFee");
                const errMsg = document.querySelector("#errMsg");
                errMsg.innerHTML = "";
                sessionFee.innerHTML = sessionFee.innerHTML  + session.paymentAmount;

                if(parseInt(session.noOfStudents) >= parseInt(maxStudents)){   //if the session is full
                    errMsg.innerHTML = "This Session has Reached the Maximum Number of Students";
                }
            }
        }
        else{
            //clear the fields
            if(e.target.id === "coachingSessions"){    //if the event is triggered from the coach profile container  
                timePeriod.value = "";
                day.value = "";
                startingTime.value = "";
                endingTime.value = "";
                courtName.value = "";
                noOfStudents.value = "";
                paymentAmount.value = "";
            }
            else if(e.target.id === "requestingSession"){  //if the event is triggered from the join request form
                const sessionFee = document.querySelector("#sessionFee");
                sessionFee.innerHTML = "Session Fee: ";
                const errMsg = document.querySelector("#errMsg");
                errMsg.innerHTML = "";
            }
        }
    });
}

const branchSelected = (e) => { //function to get the sessions when a branch is selected
    let branch = null;
    let coachingSessionElement = null;
    let nextObj;
    if(e.target.id === "sessionBranches"){  //if the event is triggered from the coach profile container
        branch = sessionBranches.value;   //get the branch name
        coachingSessionElement = coachingSessions;
        nextObj = {
            target : {
                id : "coachingSessions"
            }
        }
    }
    else if(e.target.id === "requestingSessionBranch"){ //if the event is triggered from the join request form
        branch = requestingSessionBranch.value;   //get the branch name
        coachingSessionElement = requestingSession;
        nextObj = {
            target : {
                id : "requestingSession"
            }
        }
    }
    coachingSessionElement.innerHTML = "";    //remove the current sessions
    if(branch === ""){  //if no branch is selected
        const defaultOption = document.createElement("option");
        defaultOption.text = "Please Select a Branch";
        defaultOption.value = "";
        coachingSessionElement.appendChild(defaultOption);
    }
    else{
        const sessions = branchSessionMap.get(branch);  //get all the sessions for that branch (an array)
        for(let i = 0; i < sessions.length; i++){   //add the sessions
            const option = document.createElement("option");
            option.text = sessions[i];
            option.value = sessions[i];
            coachingSessionElement.appendChild(option);
        }
    }
    //invoke the session info function
    sessionInfo(nextObj);
}


fetch("../../controller/general/coach_profile_controller.php?coachID=".concat(coachID))
    .then(res => res.json())
    .then(data => { //data is added to the page

        //add the coach info data

        //coach profile pic
        const profilePic = document.querySelector("#coachProfilePic");
        profilePic.src = data.coachInfo.profilePic;
        profilePic.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

        //coach gender
        const genderDiv = document.querySelector("#coachGender");
        let nameOpening; 
        if(data.coachInfo.gender === 'm'){
            nameOpening = "Mr. ";
            genderDiv.innerHTML = genderDiv.innerHTML + "Male";
        }
        else{
            nameOpening = "Mrs. ";
            genderDiv.innerHTML = genderDiv.innerHTML + "Female";
        }

        //coach name
        const nameDiv = document.querySelector("#coachName");
        nameDiv.innerHTML = nameDiv.innerHTML + nameOpening + data.coachInfo.firstName + " " + data.coachInfo.lastName;

        //coach username
        const usernameDiv = document.querySelector("#coachUsername");
        usernameDiv.innerHTML = usernameDiv.innerHTML + data.coachInfo.username;

        //coach age
        const ageDiv = document.querySelector("#coachAge");
        ageDiv.innerHTML = ageDiv.innerHTML + data.coachInfo.age;

        //coach sport
        const sportDiv = document.querySelector("#coachSport");
        sportDiv.innerHTML = sportDiv.innerHTML + data.sportInfo.sportName;

        //coach email
        const emailDiv = document.querySelector("#coachEmail");
        emailDiv.innerHTML = emailDiv.innerHTML + data.coachInfo.emailAddress;

        //coach contact num
        const contactDiv = document.querySelector("#coachContactNo");
        contactDiv.innerHTML = contactDiv.innerHTML + data.coachInfo.contactNum;

        //coach rating
        const ratingDiv = document.querySelector("#coachRating");
        
        //rating stars
        const rating = document.createElement("span");
        rating.style.marginLeft = "10px";
        for(let i = 1; i <= 5; i++){
            const star = document.createElement("i");
            star.ariaHidden = "true";   //for screen readers
            star.className = "fa fa-star";
            star.style.margin = "0 0.2em";
            star.style.fontSize = "1.5em";
            if(i <= data.coachRating){
                star.classList.add("checked");
            }

            //half stars for decimal value
            if(i === Math.ceil(data.coachRating) && data.coachRating % 1 !== 0){
                star.className = "fa fa-star-half-o checked";
            }
            rating.appendChild(star);
        }
        ratingDiv.appendChild(rating);

        //coach qulifications 
        const qualifications = document.querySelector("#coachQulifations");
        for(let i = 0; i < data.coachInfo.qualifications.length; i++){
            const option = document.createElement("option");
            option.text = data.coachInfo.qualifications[i];

            qualifications.appendChild(option);
        }

        //session branches

        for(let i = 0; i < data.coachingSessions.length; i++){
            const option1 = document.createElement("option");   //session branches

            if(!branchSet.has(data.coachingSessions[i].branchName)){  //add the branch if not found in the set
                option1.text = data.coachingSessions[i].branchName;
                option1.value = data.coachingSessions[i].branchName;
                branchSet.add(data.coachingSessions[i].branchID);
                sessionBranches.appendChild(option1);
            }

            if(!branchSessionMap.has(data.coachingSessions[i].branchName)){  //add the branch to the map if not found
                branchSessionMap.set(data.coachingSessions[i].branchName, []);
            }
            branchSessionMap.get(data.coachingSessions[i].branchName).push(data.coachingSessions[i].sessionID);//add the session to that branch
        }

        //event listener for the branch select and coaching sessions (added at the very end)
        
        //student feedback
        const feedbackDiv = document.querySelector("#feedbackContainer");
        for(let i = 0; i < data.coachFeedback.length; i++){
            const feedback = document.createElement("div");
            feedback.innerHTML = data.coachFeedback[i].description;

            //rating stars
            const rating = document.createElement("span");
            rating.style.marginLeft = "10px";

            //add the stars
            for(let j = 1; j <= 5; j++){
                const star = document.createElement("i");
                star.className = "fa fa-star";
                star.ariaHidden = "true";   //for screen readers
                if(j <= data.coachFeedback[i].rating){
                    star.classList.add("checked");
                }
                rating.appendChild(star);
            }

            feedback.appendChild(rating);
            feedbackDiv.appendChild(feedback);
        }


        //join session form

        //add the branches to the select
        for(let i = 0; i < branchSessionMap.size; i++){
            const option = document.createElement("option");
            option.text = Array.from(branchSessionMap.keys())[i];
            option.value = Array.from(branchSessionMap.keys())[i];

            requestingSessionBranch.appendChild(option);
        }

        //create objects for the sessions (need them for event listeners)

        //change time to local
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

    
        for(let i = 0; i < data.coachingSessions.length; i++){
            const session = {
                sessionID: data.coachingSessions[i].sessionID,
                timePeriod: data.coachingSessions[i].timePeriod,
                noOfStudents: data.coachingSessions[i].noOfStudents,
                day: data.coachingSessions[i].day,
                startingTime: changeToLocalTime(data.coachingSessions[i].startingTime),
                endingTime: changeToLocalTime(data.coachingSessions[i].endingTime),
                branchName: data.coachingSessions[i].branchName,
                courtName: data.coachingSessions[i].courtName,
                paymentAmount: "Rs. " + data.coachingSessions[i].paymentAmount,
            }

            sessions.push(session);
        }

        maxStudents = data.sportInfo.maxNoOfStudents;   //maxmimum number of students for the sport

        //add the event listeners
        sessionBranches.addEventListener("change", branchSelected);
        coachingSessions.addEventListener("change", sessionInfo);
        requestingSessionBranch.addEventListener("change", branchSelected);
        
    })