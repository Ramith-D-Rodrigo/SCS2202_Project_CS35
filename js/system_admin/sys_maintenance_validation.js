const startingDate = document.getElementById("startingDate");
const hrs = document.getElementById("Hrs");
const mins = document.getElementById("Mins");
const errMsg = document.getElementById("err-msg");

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
    const form = document.querySelector("form");
  
    if(hrs.value < 0 || hrs.value > 168){
        errMsg.innerHTML = "Hours should be between 0 and 168";
        return false;
    }
    if(mins.value < 0 || mins.value > 59){
        errMsg.innerHTML = "Minutes should be between 0 and 59";
        return false;
    }
    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = "Please Add Valid Information";
        return false;
    }

    errMsg.innerHTML = '';
    return true;
}

