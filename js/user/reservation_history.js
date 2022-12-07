const reservationHistory = document.getElementById("reservationHistoryBox");


fetch("../../controller/user/reservation_history_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.length === 0){  //no reservations
            const errDiv = document.createElement("div");
            errDiv.className = "err-msg";
            errDiv.innerHTML = "You have not made any reservations yet.";
            reservationHistory.appendChild(errDiv);
        }
        else{   //has reservations
            const reservationTable = document.createElement("table");

            const headers = ["Reservation ID", "Date", "Time Period", "Sport", "Branch", "Court", "Payment Amount", "Status", "Action"];
            const tableHeader = document.createElement("thead");
            const headerRow = document.createElement("tr");

            for(h = 0; h < headers.length; h++){    //creating table headers
                const currHead = document.createElement("td");
                currHead.innerHTML = headers[h];
                headerRow.appendChild(currHead);
            }

            tableHeader.appendChild(headerRow);
            reservationTable.appendChild(tableHeader);

            const tBody = document.createElement("tbody");

            for(i = 0; i < data.length; i++){
                const currRow = document.createElement("tr");
                
                const currResID = document.createElement("td"); //reservation id
                currResID.innerHTML = data[i].reservationID;
                currRow.appendChild(currResID);

                const currDate = document.createElement("td");  //date
                currDate.innerHTML = data[i].date;
                currRow.appendChild(currDate);

                const currTimePeriod = document.createElement("td");    //time period
                const startingTimeArr = data[i].startingTime.split(":"); //setting starting time
                const startingTime = new Date();
                startingTime.setHours(startingTimeArr[0]);
                startingTime.setMinutes(startingTimeArr[1]);
                startingTime.setSeconds(startingTimeArr[2]);

                const endingTimeArr = data[i].endingTime.split(":"); //setting ending time
                const endingTime = new Date();
                endingTime.setHours(endingTimeArr[0]);
                endingTime.setMinutes(endingTimeArr[1]);
                endingTime.setSeconds(endingTimeArr[2]); 

                currTimePeriod.innerHTML = startingTime.toLocaleTimeString() + " to " + endingTime.toLocaleTimeString();
                currRow.appendChild(currTimePeriod);

                const currSport = document.createElement("td");  //reserved sport
                currSport.innerHTML = data[i].sport;
                currRow.appendChild(currSport);

                const currBranch = document.createElement("td");  //branch
                currBranch.innerHTML = data[i].branch;
                currRow.appendChild(currBranch);

                const currCourt = document.createElement("td");  //Court
                currCourt.innerHTML = data[i].court_name;
                currRow.appendChild(currCourt);

                const currPaymentAmount = document.createElement("td");  //payment amount
                currPaymentAmount.innerHTML = data[i].paymentAmount;
                currRow.appendChild(currPaymentAmount);

                const currStatus = document.createElement("td");  //status
                currStatus.innerHTML = data[i].status;
                currRow.appendChild(currStatus);

                const currAction = document.createElement("td");  //action cell


                if(data[i].status === 'Pending'){   //can cancel
                    const cancelForm = document.createElement("form");
                    cancelForm.action = "/controller/user/cancel_reservation_controller.php";
                    cancelForm.method = "post";

                    const cancelBtn = document.createElement("button");
                    cancelBtn.type = "submit";
                    cancelBtn.name = "cancelBtn";
                    cancelBtn.value = data[i].reservationID;
                    cancelBtn.innerHTML = "Cancel";

                    cancelForm.appendChild(cancelBtn);
                    currAction.appendChild(cancelForm);
                }
                else if(data[i].status === 'Cancelled'){    

                }
                else if(data[i].status === 'Checked In' || data[i].status === 'Declined'){  //can give feedback
                    const feedbackBtn = document.createElement("button");
                    feedbackBtn.innerHTML = "Give Feedback";
                    currAction.appendChild(feedbackBtn);
                }
                currRow.appendChild(currAction);

                tBody.appendChild(currRow); //append the row
            }
            reservationTable.appendChild(tBody);
            reservationHistory.appendChild(reservationTable);
        }

    })