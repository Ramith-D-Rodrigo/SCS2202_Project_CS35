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
            for(let i=0;i<data.length;i++){
                date = new Date(data[i].date);
                today = new Date();
                if(date >= today.setDate(today.getDate()+2)){   //get only the reservations two days or more days after today's date
                    const container = document.createElement('div');
                    container.className = 'container';
                    container.style.width = '100%';
                    // const form = document.createElement("form");
                    // form.action = ;
                    // form.method = "GET";
                    const leftContainer = document.createElement('div');
                    const rightContainer = document.createElement('div');
                    const cancelBtn = document.createElement('div');
                    const btn = document.createElement('button');
                    container.style.display = 'flex';
                    container.style.flexDirection = 'row';
                    container.style.justifyContent = 'space-between';
                    leftContainer.innerHTML = "Reservation ID: ".concat(data[i].reservationID, "<br>",
                    "Sport: ",data[i].sport, "<br>", "Sport Court: ",data[i].sportCourt, "<br>");
                    rightContainer.innerHTML = "Reservation Date: ".concat(data[i].date, "<br>",
                    "Starting Time: ",data[i].startingTime, "<br>", "Ending Time: ",data[i].endingTime, "<br>");
                    btn.innerHTML = "Cancel";
                    btn.value = data[i].reservationID;
                    // btn.name = "reservationID";
                    // btn.type = "submit";
                    if(data[i].status !== 'Pending'){   //disable the cancel btn if the status is not pending
                        btn.disabled = true;
                        btn.style.opacity = 0.4;
                    }else{
                        btn.disabled = false;
                    }
                    btn.onclick = function(){
                        // console.log("Hello");
                        window.location.href = "../../controller/receptionist/cancel_onsite_reservation_controller.php?reservationID=".concat(btn.value);
                    }
                    // form.appendChild(btn);
                    cancelBtn.appendChild(btn);
                    // container.appendChild(form);
                    container.appendChild(leftContainer);
                    container.appendChild(rightContainer);
                    container.appendChild(cancelBtn);
                    searchResults.appendChild(container);
                }
            }
        }      
    });

function cancelReservation(reservationID){
    console.log(reservationID);
    // window.location.href = "../../controller/receptionist/cancel_onsite_reservation_controller.php?".concat("reservationID=", reservationID);
}