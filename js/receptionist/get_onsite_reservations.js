fetch("../../controller/receptionist/view_onsite_reservations_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        const searchResults = document.getElementById('searchResults');
        if(data[0].errMsg !== undefined){
            const errMsg = document.createElement('div');
            errMsg.innerHTML = data[0].errMsg;
            searchResults.appendChild(errMsg);
        }  
        else{
            let flag = false;
            for(let i=0;i<data.length;i++){
                reservedDate = new Date(data[i]['reservationDetails'].date);
                startingHour = data[i]['reservationDetails'].startingTime.split(":")[0]; //get the hour of starting time of the reservation
                today = new Date();
                if((reservedDate === today && startingHour >= today.getHours()) || (reservedDate > today)){   //get only the relevant reservations
                    flag = true;
                    const container = document.createElement('div');
                    container.className = 'container';
                    container.style.width = '100%';
                    const leftContainer = document.createElement('div');
                    const rightContainer = document.createElement('div');
                    const cancelBtn = document.createElement('div');
                    const btn = document.createElement('button');
                    container.style.display = 'flex';
                    container.style.flexDirection = 'row';
                    container.style.justifyContent = 'space-between';
                    leftContainer.innerHTML = "Reservation ID: ".concat(data[i]['reservationDetails'].reservationID, "<br>","Reserved By: ",data[i].name ,"<br>",
                    "Contact Number: ",data[i].contactNumber,"<br>","Sport: ",data[i]['reservationDetails'].sport,"<br>");
                    rightContainer.innerHTML = "Sport Court: ".concat(data[i]['reservationDetails'].sportCourt,"<br>","Reservation Date: ",data[i]['reservationDetails'].date, "<br>",
                    "Starting Time: ",data[i]['reservationDetails'].startingTime, "<br>", "Ending Time: ",data[i]['reservationDetails'].endingTime, "<br>");
                    btn.innerHTML = "Cancel";
                    btn.value = data[i]['reservationDetails'].reservationID;
                    if(data[i]['reservationDetails'].status !== 'Pending'){   //disable the cancel btn if the status is not pending
                        btn.disabled = true;
                        btn.style.opacity = 0.4;
                    }else{
                        btn.disabled = false;
                    }
                    btn.onclick = function(){
                        window.location.href = "../../controller/receptionist/cancel_onsite_reservation_controller.php?reservationID=".concat(btn.value);
                    }
                    cancelBtn.appendChild(btn);
                    container.appendChild(leftContainer);
                    container.appendChild(rightContainer);
                    container.appendChild(cancelBtn);
                    searchResults.appendChild(container);
                }
            }
            if(!flag){
                const div = document.createElement('div');
                div.className = 'container';
                div.innerHTML = "No onsite reservations found";
                searchResults.appendChild(div);
            } 
        }     
    });

function cancelReservation(reservationID){
    console.log(reservationID);
    // window.location.href = "../../controller/receptionist/cancel_onsite_reservation_controller.php?".concat("reservationID=", reservationID);
}