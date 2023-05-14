const startingDate = document.getElementById("startingDate");
const startingTime = document.getElementById("startingTime");
const hrs = document.getElementById("Hrs");
const mins = document.getElementById("Mins");
const errMsg = document.getElementById("err-msg");
const successMsg = document.getElementById("success-msg");
const overlay = document.getElementById("overlay");

const today = new Date().toISOString().split("T")[0];
// console.log(today);
const minDate = new Date(today);
minDate.setDate(minDate.getDate() + 7);
startingDate.min = minDate.toISOString().split("T")[0];
// console.log(minDate.toISOString().split("T")[0]);

const maxDate = new Date(today);
maxDate.setDate(maxDate.getDate() + 30);
startingDate.max = maxDate.toISOString().split("T")[0];
// console.log(maxDate.toISOString().split("T")[0]);

function validateForm(event){
    event.preventDefault();
    const form = document.querySelector("form");
  
    if(hrs.value < 0 || hrs.value > 168){
        errMsg.innerHTML = "Hours should be between 0 and 168";
        return;
    }
    if(mins.value < 0 || mins.value > 59){
        errMsg.innerHTML = "Minutes should be between 0 and 59";
        return;
    }
    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = "Please Add Valid Information";
        return;
    }

    errMsg.innerHTML = '';
    addMaintenance();
}

function addMaintenance(){
    const maintenanceDetails = {
        startingDate : startingDate.value,
        startingTime : startingTime.value,
        hours : hrs.value,
        minutes : mins.value
    }
    fetch("../../controller/system_admin/system_maintenance_controller.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(maintenanceDetails),
    })
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        if(!data['Flag']){
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            successMsg.style.display = "block";

            successMsg.innerHTML = data['Message'];
            overlay.style.display = "block";

            setTimeout(function(){
                location.reload();
            },3000);
        }else{
            errMsg.innerHTML = data['Message'];
        }
    });
}

