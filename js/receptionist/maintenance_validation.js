verbose = true; //for debugging

function validateForm(event){
    const errMsg = document.getElementById("errmsg");    //For Displaying the Error messages
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

// const spName = document.getElementById("sportName");
// const crtName = document.getElementById("courtName");

// spName.addEventListener('change',(e) => {
//     const errorMsg = document.getElementById('errmsg2');
//     spVal = e.target.value;

//     if((spVal === 'ALL' && crtName.value != 'ALL') || (spVal != 'ALL' && crtName.value === 'ALL')) {
//         errorMsg.innerHTML = "Both the Sport Name and Sport Court Have to be ALL or Neither";
//         return;
//     }
//     errorMsg.innerHTML = "";
// })

// crtName.addEventListener('change',(e) => {
//     const errorMsg = document.getElementById('errmsg2');
//     crtVal = e.target.value;

//     if((crtVal === 'ALL' && spName.value != 'ALL') || (crtVal != 'ALL' && spName.value === 'ALL')) {
//         errorMsg.innerHTML = "Both the Sport Name and Sport Court Have to be ALL or Neither";
//         return;
//     }
//     errorMsg.innerHTML = "";

// })

const sDate = document.getElementById("sDate");
const eDate = document.getElementById("eDate");
const today = new Date().toISOString().split("T")[0];

function setMonths(months) {
    let result = new Date(today);
    result.setMonth(result.getMonth() + months);
    return result;
}

const sminDate = setMonths(1).toISOString().split("T")[0];
const smaxDate = setMonths(2).toISOString().split("T")[0];

sDate.min = sminDate;
sDate.max = smaxDate;

const eminDate = sminDate;
const emaxDate = setMonths(3).toISOString().split("T")[0];

eDate.min = eminDate;
eDate.max = emaxDate;

sDate.addEventListener('change',(e) => {
    const errorMsg = document.getElementById('errmsg');
    if(eDate.value === ''){
        return;
    }

    const startDate = e.target.value;
    stDate = new Date(startDate)
    const endDate = eDate.value;
    enDate = new Date(endDate);

    dayDiff = (enDate.getTime()-stDate.getTime())/(1000*3600*24);   //get the difference of days
    // console.log(dayDiff);

    if(dayDiff <0) {
        errorMsg.innerHTML = "Invalid Date Range";
        return;
    }
    if(dayDiff <7) {
        errorMsg.innerHTML = "Date Range should be atleast for 7 days";
        return;
    }
    if(dayDiff > 31){
        errorMsg.innerHTML = "Date Range should be atmost for 30 days";
        return;
    }
    errorMsg.innerHTML = "";
})

eDate.addEventListener('change',(e) => {
    const errorMsg = document.getElementById('errmsg');
    if(sDate.value === ''){
        return;
    }

    const endDate = e.target.value;
    enDate = new Date(endDate)
    const startDate = sDate.value;
    stDate = new Date(startDate);

    dayDiff = (enDate.getTime()-stDate.getTime())/(1000*3600*24);   //get the difference of days
    // console.log(dayDiff);

    if(dayDiff <0) {
        errorMsg.innerHTML = "Invalid Date Range";
        return
    }
    if(dayDiff <7) {
        errorMsg.innerHTML = "Date Range should be atleast for 7 days";
        return;
    }
    if(dayDiff > 31){
        errorMsg.innerHTML = "Date Range should be atmost for 30 days";
        return;
    }

    errorMsg.innerHTML = "";
})
