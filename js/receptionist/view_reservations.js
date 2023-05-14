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
            for(let i=0; i<data.length; i++){
                const reservDiv = document.createElement("div");
                reservDiv.style.display = "flex";
                reservDiv.style.flexDirection = "row";
                reservDiv.className = "container";
                const leftContent = document.createElement("div");
                const rightContent = document.createElement("div");
                leftContent.style.display = "flex";
                rightContent.style.display = "flex";
                if(Object.keys(data[i]).length===10){   //for user made reservations
                    leftContent.style.marginRight = "70px";
                    rightContent.style.marginRight = "45px";
                    leftContent.innerHTML = "Reservation ID: ".concat(data[i].reservationID,
                        "<br>","Reserved By: ",data[i].firstName," ",data[i].lastName,
                        "<br>","Contact Number: ",data[i].contactNum,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                        "<br>","Court Name: ",data[i].courtName,
                        "<br>","Number of People: ",data[i].noOfPeople,
                        "<br>","Status: ",data[i].status);
                        
                }else if(Object.keys(data[i]).length===9 && data[i].sessionID === undefined){  //for onsite reservations
                    leftContent.style.marginRight = "25px";   //the resID to long than the user made reservation
                    rightContent.style.marginRight = "20px";
                    leftContent.innerHTML = "Reservation ID: ".concat(data[i].reservationID,
                        "<br>","Reserved By: ",data[i].reservationHolder,
                        "<br>","Contact Number: ",data[i].contactNumber,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                        "<br>","Court Name: ",data[i].courtName,
                        "<br>","Number of People: ",data[i].noOfPeople,                 
                        "<br>","Status: ",data[i].status);
                }
                else{   //for permanent reservations
                    leftContent.style.marginRight = "150px";
                    leftContent.innerHTML = "Session ID: ".concat(data[i].sessionID,
                        "<br>","Reserved By: ",data[i].firstName," ",data[i].lastName,
                        "<br>","Contact Number: ",data[i].contactNum,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                    "<br>","Court Name: ",data[i].courtName,
                    "<br>","Number of Students: ",data[i].noOfStudents,
                    "<br>","Status: ","Reserved");
                }
                const btnDiv = document.createElement("div");
                btnDiv.style.display = "flex";
                btnDiv.style.flexDirection = "column";
                const confirmBtn = document.createElement("button");
                confirmBtn.onclick = submitDecision;
                confirmBtn.innerHTML = "Confirm";
                confirmBtn.style.marginBottom = "5px";
                const  cancelBtn = document.createElement("button");
                cancelBtn.innerHTML = "Cancel";
                cancelBtn.onclick = submitDecision;
                reservDiv.appendChild(leftContent);
                reservDiv.appendChild(rightContent);

                if(data[i].status !== undefined){    //remove adding two buttons for permanent reservations
                    if(data[i].status === "Pending"){
                        confirmBtn.value = "Checked In".concat(",",data[i].reservationID);
                        cancelBtn.value = "Declined".concat(",",data[i].reservationID);
                                            
                    }else{    
                        cancelBtn.disabled = true;
                        cancelBtn.style.opacity = "50%";
                        confirmBtn.disabled = true;
                        confirmBtn.style.opacity = "50%";
                    }
                    btnDiv.appendChild(confirmBtn);
                    btnDiv.appendChild(cancelBtn);
                    reservDiv.appendChild(btnDiv);
                }
                    
                reservations.appendChild(reservDiv);
            }
        }

    });

function submitDecision(){
    // console.log(JSON.stringify(this.value));

    fetch("../../controller/receptionist/handle_reservation_controller.php",{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.value)   //convert the decision details object to JSON
    })
        .then((res) => res.json())
        .then((data) => {
            const successMsg = document.getElementById("success-msg");
            const errMsg = document.getElementById("err-msg");
            const overlay = document.getElementById("overlay");
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            if(data){
                successMsg.style.display = "block";
                successMsg.innerHTML = "Saved Successfully";
                overlay.style.display = "block";
                
            }else{
                errMsg.style.display = "block";
                errMsg.innerHTML = "Error Occured When Saving";
                overlay.style.display = "block";
            }
            setTimeout(function(){
                location.reload();
            },3000);
            // console.log(data);
        });

}
