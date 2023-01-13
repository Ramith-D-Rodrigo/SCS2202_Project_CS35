const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const coachID = params.get("coachID");

//session objects stored in this array
let sessions = [];

//maximum number of students for the sport
let maxStudents = 0;


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
        const sessionBranches = document.querySelector("#sessionBranches");

        let branchSet = new Set();
        let branchSessionMap = new Map();   //to map the branch to the sessions

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
                if(j <= data.coachFeedback[i].rating){
                    star.classList.add("checked");
                }
                rating.appendChild(star);
            }

            feedback.appendChild(rating);
            feedbackDiv.appendChild(feedback);
        }


        //join session form
        const requestingSessionBranch = document.querySelector("#requestingSessionBranch");

        //add the branches to the select
        for(let i = 0; i < branchSessionMap.size; i++){
            const option = document.createElement("option");
            option.text = Array.from(branchSessionMap.keys())[i];
            option.value = branchSessionMap.keys()[i];

            requestingSessionBranch.appendChild(option);
        }

        //create objects for the sessions (need them for event listeners)
    
        for(let i = 0; i < data.coachingSessions.length; i++){
            const session = {
                sessionID: data.coachingSessions[i].sessionID,
                timePeriod: data.coachingSessions[i].timePeriod,
                noOfStudents: data.coachingSessions[i].noOfStudents,
                day: data.coachingSessions[i].day,
                startingTime: data.coachingSessions[i].startingTime,
                endingTime: data.coachingSessions[i].endingTime,
                branchName: data.coachingSessions[i].branchName,
                courtName: data.coachingSessions[i].courtName,
                paymentAmount: data.coachingSessions[i].paymentAmount,
            }

            sessions.push(session);
        }

        maxStudents = data.sportInfo.maxNoOfStudents;   //maxmimum number of students for the sport

        //add the event listeners
        
    })