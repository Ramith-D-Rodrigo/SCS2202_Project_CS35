fetch("../../controller/receptionist/view_reservations_controller.php")
    .then((res) => res.json())
    .then((data) => {
        // console.log(data);
        if(data[0]['errMsg'] !== undefined){
            const errorDiv = document.getElementById("err-msg");
            const searchError = document.createElement("div");
            searchError.className = "no-result";
            searchError.id = "no-result";
            searchError.innerHTML = data[0]['errMsg'];
            errorDiv.appendChild(searchError);
        }else{
            // data[0].push(data[1]);
            data.sort(function(a,b){    //sort the array to display the reservations in order of time
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
                if(Object.keys(data[i]).length===10){
                    leftContent.innerHTML = "Reservation ID: ".concat(data[i].reservationID,
                        "<br>","Reserved By: ",data[i].firstName," ",data[i].lastName,
                        "<br>","Contact Number: ",data[i].contactNum,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                    "<br>","Court Name: ",data[i].courtName,
                    "<br>","Number of People: ",data[i].noOfPeople,
                    "<br>","Status: ",data[i].status);
                        
                }else{
                    leftContent.innerHTML = "Session ID: ".concat(data[i].sessionID,
                        "<br>","Reserved By: ",data[i].firstName," ",data[i].lastName,
                        "<br>","Contact Number: ",data[i].contactNum,
                        "<br>","Time Slot: ",data[i].startingTime,"-",data[i].endingTime);
                    rightContent.innerHTML = "Sport: ".concat(data[i].sportName,
                    "<br>","Court Name: ",data[i].courtName,
                    "<br>","Number of Students: ",data[i].noOfStudents,
                    "<br>","Status: ","Permanently Reserved");
                }
                const formInput = document.createElement("form");
       
                formInput.style.display = "flex";
                formInput.style.flexDirection = "column";
                formInput.action = "../../controller/receptionist/handle_reservation_controller.php";
                formInput.method = "POST";
                const confirmBtn = document.createElement("button");
                confirmBtn.innerHTML = "Confirm";
                confirmBtn.style.marginBottom = "5px";
                const  cancelBtn = document.createElement("button");
                cancelBtn.innerHTML = "Cancel";
                if(Object.keys(data[i]).length===10){
                    confirmBtn.value = data[i].reservationID;
                    cancelBtn.value = data[i].reservationID;
                }else{
                    cancelBtn.value = data[i].sessionID;
                    confirmBtn.value = data[i].sessionID;
                }
                formInput.appendChild(confirmBtn);
                formInput.appendChild(cancelBtn);
                reservDiv.appendChild(leftContent);
                reservDiv.appendChild(rightContent);
                reservDiv.appendChild(formInput);
                reservations.appendChild(reservDiv);
            }
        }

    });