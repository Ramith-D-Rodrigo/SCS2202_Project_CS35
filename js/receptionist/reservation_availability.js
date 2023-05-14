
let reservationForm = document.getElementById('formData');

import {updateTheReservationTables, createScheduleObjects} from './reservation_schedule_functions.js';

let sendingRequest = null;  //to store the reservation details

// reservationForm = null;
// const main = document.querySelector("main");

reservationForm.addEventListener('submit', (event) => { 
    event.preventDefault(); // Prevent the form from submitting
    const formData = new FormData(reservationForm);
    const reserveBtn = document.getElementById("makeReserveBtn");
    
    sendingRequest = {
        "sport" : formData.get("reservingSport"),
        "sportCourt" : formData.get("reservingSportCourt"),
        "branch" : formData.get("reservingBranch"),
        "numOfPeople" : formData.get("numOfPeople"),
        "reservingStartTime" : formData.get("reservingStartTime"),
        "reservingEndTime" : formData.get("reservingEndTime"),
        "reservingDate" : formData.get("reservingDate"),
        "reservationFee" : formData.get("reservationPrice"),
        "name" : formData.get("name"),
        "contactNumber" : formData.get("contactNum"),
        "makeReserveBtn" : reserveBtn.value
    }
    localStorage.setItem("formData", JSON.stringify(sendingRequest));  /*converts form data to a json string and 
                                                                    store it in localStorage to access by a diff js file*/
    fetch("../../controller/receptionist/reservation_availability_controller.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(sendingRequest)
    })
    .then((res) => res.json())
    .then((data) => {
        // console.log(data);
        const successMsgBox = document.getElementById("successMsg");
        const errMsgBox = document.getElementById("errMsg");
        successMsgBox.innerHTML = "";
        errMsgBox.innerHTML = "";
        
        if(data.successMsg !== undefined){           
            successMsgBox.innerHTML = data.successMsg;
            window.location.href = '../../public/receptionist/reservation_payment.php';

        }else if(data.errMsg !== undefined){
            errMsgBox.innerHTML = data.errMsg;
        }
    });
});

// export {sendingRequest};
