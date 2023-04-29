fetch("../../controller/receptionist/view_reservations_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        if(data[0]['errMsg'] !== undefined){
            const errorDiv = document.getElementById("err-msg");
            errorDiv.className = "container";
            errorDiv.innerHTML = data[0]['errMsg'];
        }else{
            // data[0].push(data[1]);
            //sort the array to display the reservations in order of starting time and ending time and finally court name
            data.sort(function(a,b){    
                if(parseInt(a.startingTime)- parseInt(b.startingTime) === 0){
                    if(parseInt(a.endingTime)-parseInt(b.endingTime) === 0){
                        return b.courtName-a.courtName;
                    }else{
                        return parseInt(a.endingTime)-parseInt(b.endingTime);
                    }
                }
                return parseInt(a.startingTime)-parseInt(b.startingTime);
            });
            
            // console.log(data);
            const reservations = document.getElementById("reservations");
            for(i=0; i<data.length; i++){
                const reservDiv = document.createElement("div");
                reservDiv.style.display = "flex";
                reservDiv.style.flexDirection = "row";
                reservDiv.className = "container";
                const leftContent = document.createElement("div");
                const rightContent = document.createElement("div");
                leftContent.style.display = "flex";
                leftContent.style.marginRight = "70px";
                rightContent.style.display = "flex";
                rightContent.style.marginRight = "20px";
                if(Object.keys(data[i]).length===10){   //for user made reservations
                    leftContent.innerHTML = "Reservation ID: ".concat(data[i].reservationID,
                        "<br>","Reserved By: ",data[i].firstName," ",data[i].lastName,
                        "<br>","Contact Number: ",data[i].contactNum,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                        "<br>","Court Name: ",data[i].courtName,
                        "<br>","Number of People: ",data[i].noOfPeople,
                        "<br>","Status: ",data[i].status);
                        
                }else if(Object.keys(data[i]).length===7){  //for onsite reservations
                    leftContent.innerHTML = "Reservation ID: ".concat(data[i].reservationID,
                        "<br>","Number of People: ",data[i].noOfPeople,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                        "<br>","Court Name: ",data[i].courtName,                 
                        "<br>","Status: ",data[i].status);
                }
                else{   //for permanent reservations
                    leftContent.innerHTML = "Session ID: ".concat(data[i].sessionID,
                        "<br>","Reserved By: ",data[i].firstName," ",data[i].lastName,
                        "<br>","Contact Number: ",data[i].contactNum,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                    "<br>","Court Name: ",data[i].courtName,
                    "<br>","Number of Students: ",data[i].noOfStudents,
                    "<br>","Status: ","Reserved");
                }
                const resID = document.createElement("input");
                resID.hidden = true;
                resID.name = "reservationID";
                const formInput = document.createElement("form");
                formInput.style.display = "flex";
                formInput.style.flexDirection = "column";
                formInput.action = "../../controller/receptionist/handle_reservation_controller.php";
                formInput.method = "POST";
                const confirmBtn = document.createElement("button");
                confirmBtn.innerHTML = "Confirm";
                confirmBtn.name = "btnVal";
                confirmBtn.style.marginBottom = "5px";
                const  cancelBtn = document.createElement("button");
                cancelBtn.name = "btnVal";
                cancelBtn.innerHTML = "Cancel";
                if(data[i].status === "Pending"){
                    resID.value = data[i].reservationID;
                    confirmBtn.value = "Checked In";
                    cancelBtn.value = "Declined";
                }else{
                    cancelBtn.disabled = true;
                    cancelBtn.style.opacity = "50%";
                    confirmBtn.disabled = true;
                    confirmBtn.style.opacity = "50%";
                }
                
                formInput.appendChild(confirmBtn);
                formInput.appendChild(cancelBtn);
                formInput.appendChild(resID);
                reservDiv.appendChild(leftContent);
                reservDiv.appendChild(rightContent);
                reservDiv.appendChild(formInput);
                reservations.appendChild(reservDiv);
            }
        }

    });