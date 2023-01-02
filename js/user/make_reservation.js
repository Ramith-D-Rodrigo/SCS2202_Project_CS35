const reservationForm = document.querySelector('form');

import {updateTheReservationTables, createScheduleObjects} from '../general/reservation_schedule_functions.js';

reservationForm.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent the form from submitting
    const formData = new FormData(reservationForm);
    const reserveBtn = document.getElementById("makeReserveBtn");

    const sendingRequest = {
        "numOfPeople" : formData.get("numOfPeople"),
        "reservingStartTime" : formData.get("reservingStartTime"),
        "reservingEndTime" : formData.get("reservingEndTime"),
        "reservingDate" : formData.get("reservingDate"),
        "makeReserveBtn" : reserveBtn.value
    };

    //send the reservation details to the server
    fetch("../../controller/user/make_reservation_controller.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
        },
        body: JSON.stringify(sendingRequest)
    })
    .then((res) => res.json())
    .then((data) => {
        if(data.successMsg !== undefined){  //reservation success
            const successMsgBox = document.getElementById("successMsg");
            const errMsgBox = document.getElementById("errMsg");
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            successMsgBox.innerHTML = data.successMsg;

            //update the table
            const url = new URL(window.location);   //get the url
            const params = new URLSearchParams(url.search); //search parameters
            //console.log(params);
            const getReq = params.get("reserveBtn");
            //console.log(getReq);

            let schedulesArr = [];  //array to store the reservation info of each court
            fetch("../../controller/general/reservation_schedule_controller.php?reserveBtn=".concat(getReq))
                .then(res => res.json())
                .then(data => {
                    const scheduleObjs = createScheduleObjects(data);
                    updateTheReservationTables(scheduleObjs);
                });
        }
        else if(data.errMsg !== undefined){  //reservation failed
            const successMsgBox = document.getElementById("successMsg");
            const errMsgBox = document.getElementById("errMsg");
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            errMsgBox.innerHTML = data.errMsg;
        }
    })
    .catch((err) => {
        console.log(err);
    }
    );
});