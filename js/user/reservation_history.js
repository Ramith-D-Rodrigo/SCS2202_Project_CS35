//import cancel reservation function init from cancel_reservation.js
import {init as cancelReservation} from "./cancel_reservation.js";

//import give feedback function init from give_feedback.js
import {init as giveFeedback} from "./give_feedback.js";

import {currency} from "../CONSTANTS.js";

const reservationHistory = document.getElementById("reservationHistoryBox");

let reservationAndTimeStamp = [];   //array to store reservation id and reserved timestamp


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
            reservationTable.className = "res-history-table";

            const headers = ["Reservation ID", "Date", "Time Period", "Sport", "Branch", "Court", "Payment Amount", "Status", "Reserved Timestamp", "Action"];
            const tableHeader = document.createElement("thead");
            tableHeader.className = "res-history-table-header";

            const headerRow = document.createElement("tr");

            for(let h = 0; h < headers.length; h++){    //creating table headers
                const currHead = document.createElement("td");
                currHead.innerHTML = headers[h];
                headerRow.appendChild(currHead);
            }

            tableHeader.appendChild(headerRow);
            reservationTable.appendChild(tableHeader);

            const tBody = document.createElement("tbody");
            tBody.className = "res-history-table-body";

            for(let i = 0; i < data.length; i++){
                const currRow = document.createElement("tr");
                
                const currResID = document.createElement("td"); //reservation id
                currResID.className = "reservation-id";
                currResID.innerHTML = data[i].reservationID;
                currResID.setAttribute("data-label", "Reservation ID");
                currRow.appendChild(currResID);

                const currDate = document.createElement("td");  //date
                currDate.innerHTML = data[i].date;
                currDate.setAttribute("data-label", "Date");
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
                currTimePeriod.setAttribute("data-label", "Time Period");
                currRow.appendChild(currTimePeriod);

                const currSport = document.createElement("td");  //reserved sport
                currSport.innerHTML = data[i].sport;
                currSport.setAttribute("data-label", "Sport");
                currRow.appendChild(currSport);

                const currBranch = document.createElement("td");  //branch
                currBranch.innerHTML = data[i].branch;
                currBranch.setAttribute("data-label", "Branch");
                currRow.appendChild(currBranch);

                const currCourt = document.createElement("td");  //Court
                currCourt.innerHTML = data[i].courtName;
                currCourt.setAttribute("data-label", "Court");
                currRow.appendChild(currCourt);

                const currPaymentAmount = document.createElement("td");  //payment amount
                currPaymentAmount.innerHTML = currency + " " + data[i].paymentAmount +".00";
                currPaymentAmount.setAttribute("data-label", "Payment Amount");
                currRow.appendChild(currPaymentAmount);

                const currStatus = document.createElement("td");  //status
                if(data[i].status.includes("feedbackGiven")){
                    //if feedback is given, just add checked in to the status
                    currStatus.innerHTML = "Checked In";
                }
                else{
                    currStatus.innerHTML = data[i].status;
                }
                currStatus.setAttribute("data-label", "Status");
                currRow.appendChild(currStatus);

                const reservedTimestamp = document.createElement("td");  //reserved timestamp
                const timeStamp = new Date(data[i].reservedDate);
                reservedTimestamp.innerHTML = timeStamp.toLocaleString();
                const resObj = {
                    reservationID: data[i].reservationID,
                    reservedTimestamp: timeStamp
                };
                reservationAndTimeStamp.push(resObj);
                reservedTimestamp.setAttribute("data-label", "Reserved Timestamp");
                currRow.appendChild(reservedTimestamp);

                const currAction = document.createElement("td");  //action cell


                if(data[i].status === 'Pending'){   //can cancel
                    const cancelForm = document.createElement("form");
                    cancelForm.className = "cancel-form";

                    const cancelBtn = document.createElement("button");
                    cancelBtn.className = "cancel-button";
                    cancelBtn.type = "submit";
                    cancelBtn.name = "cancelBtn";
                    cancelBtn.value = "cancel";

                    //icon for cancel button
                    const cancelIcon = document.createElement("i");
                    cancelIcon.className = "fa-regular fa-circle-xmark";
                    cancelIcon.style.color = "red";
                    cancelIcon.style.fontSize = "1.5rem";
                    cancelBtn.appendChild(cancelIcon);

                    //hidden input for reservation id
                    const resID = document.createElement("input");
                    resID.type = "hidden";
                    resID.name = "reservationID";
                    resID.value = data[i].reservationID;

                    cancelForm.appendChild(resID);
                    cancelForm.appendChild(cancelBtn);
                    currAction.appendChild(cancelForm);

                }
                else if(data[i].status === 'Checked In' || data[i].status === 'Declined'){  //can give feedback
                    const feedbackForm = document.createElement("form");
                    feedbackForm.className = "feedback-form";

                    const feedbackBtn = document.createElement("button");
                    feedbackBtn.className = "feedback-button";
                    feedbackBtn.value = "cancel";

                    //icon for feedback button
                    const feedbackIcon = document.createElement("i");
                    feedbackIcon.className = "fa-regular fa-comment";
                    feedbackIcon.style.color = "blue";
                    feedbackIcon.style.fontSize = "1.5rem";
                    feedbackBtn.appendChild(feedbackIcon);

                    //hidden input for reservation id
                    const resID = document.createElement("input");
                    resID.type = "hidden";
                    resID.name = "reservationID";
                    resID.value = data[i].reservationID;

                    feedbackForm.appendChild(resID);
                    feedbackForm.appendChild(feedbackBtn);
                    currAction.appendChild(feedbackForm);
                }

                currAction.setAttribute("data-label", "Action");
                currRow.appendChild(currAction);

                tBody.appendChild(currRow); //append the row
            }
            reservationTable.appendChild(tBody);
            reservationHistory.appendChild(reservationTable);
        }

    }).then(() => {
        cancelReservation(reservationAndTimeStamp); //initialize cancel reservation function (passing reservation id and reserved timestamp)
        giveFeedback(); //initialize give feedback function
    }).catch(err => console.log(err));