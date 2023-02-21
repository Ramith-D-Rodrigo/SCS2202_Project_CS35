import {changeToLocalTime} from "../FUNCTIONS.js";


const coachingSessionsContainer = document.querySelector('#coachingSessionsContainer');

let successflag = false;

fetch("../../controller/user/coaching_sessions_controller.php")
    .then(res => {
        successflag = res.ok;
        if(!res.ok){
            coachingSessionsContainer.innerHTML = `<p class="text-center">No coaching sessions found</p>`;
        }
        return res.json();
    })
    .then(data => {
        if(successflag){
            console.log(data);

            for(let i = 0; i < data.coachingSessions.length; i++){
                //create a div for each coaching session
                const sessionDiv = document.createElement('div');
                sessionDiv.className = 'content-box';

                //add coach image to the div
                const coachImgContainer = document.createElement('div');
                const coachImg = document.createElement('img');
                coachImg.src = data.coaches[data.coachingSessions[i].coachID].photo;
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

                //session day
                const sessionDay = document.createElement('p');
                sessionDay.innerHTML = data.coachingSessions[i].day;
                sessionDiv.appendChild(sessionDay);

                //session time
                const sessionTime = document.createElement('p');
                sessionTime.innerHTML = changeToLocalTime(data.coachingSessions[i].startingTime) + " - " + changeToLocalTime(data.coachingSessions[i].endingTime);
                sessionDiv.appendChild(sessionTime);

                //status
                const sessionStatus = document.createElement('p');
                sessionStatus.innerHTML = data.coachingSessions[i].status;
                sessionDiv.appendChild(sessionStatus);


                coachingSessionsContainer.appendChild(sessionDiv);

            }
        }
    });

