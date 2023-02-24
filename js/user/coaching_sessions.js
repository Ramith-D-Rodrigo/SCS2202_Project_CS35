import {changeToLocalTime} from "../FUNCTIONS.js";


const coachingSessionsContainer = document.querySelector('#coachingSessionsContainer');

let successflag = false;

const sportFilter = document.querySelector('#sportFilter');
const statusFilter = document.querySelector('#statusFilter');

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

fetch("../../controller/user/coaching_sessions_controller.php")
    .then(res => {
        successflag = res.ok;
        return res.json();
    })
    .then(data => {
        if(successflag){
            let sportSet = new Set();   //to store the sports

            for(let i = 0; i < data.coachingSessions.length; i++){
                //create a div for each coaching session
                const sessionDiv = document.createElement('div');
                sessionDiv.className = 'content-box';

                sessionDiv.classList.add("session");

                //add coach image to the div
                const coachImgContainer = document.createElement('div');
                const coachImg = document.createElement('img');
                coachImg.src = data.coaches[data.coachingSessions[i].coachID].photo;
                coachImg.style.width = "18rem";
                coachImg.style.height = 'auto';

                coachImg.setAttribute('onerror', 'this.src = "/styles/icons/no-results.png"');
                coachImgContainer.appendChild(coachImg);
                sessionDiv.appendChild(coachImgContainer);

                //add sport image to the div
                const sportImgContainer = document.createElement('div');
                const sportImg = document.createElement('img');
                //resize the image
                sportImg.style.width = "10rem";
                sportImg.style.height = 'auto';

                sportImg.src = "/uploads/sport_images/" + data.coaches[data.coachingSessions[i].coachID].sport + ".jpg";

                sportImgContainer.appendChild(sportImg);
                sessionDiv.appendChild(sportImgContainer);

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
                sessionStatus.innerHTML = coachingSessions[i].status.toUpperCase();
                sessionDiv.appendChild(sessionStatus);

                //buttons and filtering based on status
                if(data.coachingSessions[i].status === "pending"){
                    const cancelBtn = document.createElement('button');
                    cancelBtn.innerHTML = 'Cancel Request';
                    
                    //icon
                    const cancelIcon = document.createElement('i');
                    cancelIcon.style.margin = '0 0.5rem';
                    cancelIcon.className = 'fas fa-times';
                    cancelBtn.appendChild(cancelIcon);

                    cancelBtn.setAttribute('onclick', 'cancelSessionRequest(' + data.coachingSessions[i].sessionID + ')');
                    sessionDiv.appendChild(cancelBtn);

                    sessionDiv.classList.add('pending');
                }
                else if(data.coachingSessions[i].status === "ongoing"){


                }
                coachingSessionsContainer.appendChild(sessionDiv);

            }

            return sportSet;
        }
        console.log(data);

        const msgDiv = document.createElement('div');
        msgDiv.className = 'content-box';
        msgDiv.innerHTML = data.msg;
        coachingSessionsContainer.appendChild(msgDiv);
        
        return new Set();   //empty set


    }).then((sportSet) => {
        //filtering
        

        sportSet.forEach(sport => { //add sports to the filter
            const option = document.createElement('option');
            option.value = sport;
            option.innerHTML = sport;
            sportFilter.appendChild(option);
        });


        sportFilter.addEventListener('change', filterSessions);

        statusFilter.addEventListener('change', filterSessions);
    });

