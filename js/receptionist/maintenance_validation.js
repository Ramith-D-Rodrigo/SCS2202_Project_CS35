verbose = true; //for debugging

function validateForm(event){
    const errMsg = document.getElementById("msgbox");    //For Displaying the Error messages
    errMsg.innerHTML = '' //empty before the validation

    const loginForm = document.getElementById("reqForm"); //get login form

    if(verbose){
        console.log(loginForm.reportValidity());
    }

    if(loginForm.reportValidity() === false){   //has errors
        errMsg.innerHTML = 'Please Enter valid information';
        event.preventDefault(); //do not submit
    }
    else{   //can submit
        return true;
    }
}

function checkAll() {
    const spName = document.getElementById("sportName");
    const crtName = document.getElementById("courtName");
    const crtOption = document.getElementById("courtOption");

    if(spName.value == 'ALL') {
        crtOption.innerText = 'Disalbed';
        crtName.value = 'ALL';
    }
    
}

const sDate = document.getElementById("sDate");
const eDate = document.getElementById("eDate");
const today = new Date().toISOString().split("T")[0];

const startDate = today.split("-");


if(startDate[1]==12) {
    startDate[0] = (parseInt(startDate[0])+1).toString();
    startDate[1] = '1';
}else{
    startDate[1] = (parseInt(startDate[1])+1).toString();
}
const minDate = new Date(startDate).toISOString().split("T")[0];
sDate.min = minDate;
if(startDate[1]==12) {
    startDate[0] = (parseInt(startDate[0])+1).toString();
    startDate[1] = '1';
}else{
    startDate[1] = (parseInt(startDate[1])+1).toString();
}
const maxDate = new Date(startDate).toISOString().split("T")[0];
sDate.max = maxDate;

const endDate = today.split("-");
if(endDate[1]==11) {
    endDate[0] = (parseInt(endDate[0])+1).toString();
    endDate[1] = '1';
}else if(endDate[1]==12){
    endDate[0] = (parseInt(endDate[0])+1).toString();
    endDate[1] = '2';
}else{
    endDate[1] = (parseInt(endDate[1])+2).toString();
}
const eMinDate = new Date(endDate).toISOString().split("T")[0];
eDate.min = eMinDate;

// if(endDate[1]==11) {
//     endDate[0] = (parseInt(endDate[0])+1).toString();
//     endDate[1] = '1';
if(endDate[1]==12){
    endDate[0] = (parseInt(endDate[0])+1).toString();
    endDate[1] = '1';
}else{
    endDate[1] = (parseInt(endDate[1])+1).toString();
}

const eMaxDate = new Date(endDate).toISOString().split("T")[0];
eDate.max = eMaxDate;