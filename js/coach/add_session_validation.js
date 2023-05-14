verbose = true;

const StartingTime = document.getElementById("startingTime");
const EndingTime = document.getElementById("closedTime");
// const session_fee = document.getElementById("session_fee");
const monthly_payment = document.getElementById("monthly_payment");


StartingTime.addEventListener('change', (e)=>{
    const min = e.target.value.split(":")[1];
       
   
    if(!(min == '00' || min == '30') ){
        e.target.style.border = "medium solid red";
       
    }
    else{
        e.target.style.border = "none";
        

    }
});

EndingTime.addEventListener('change', (e)=>{
    const min = e.target.value.split(":")[1];
    // if(verbose){
    //     console.log(e.target.value);
    //     //console.log(min)   //get the minutes
    // }

    if(!(min == '00' || min == '30') ){
        e.target.style.border = "medium solid red";
    }
    else{
        e.target.style.border = "none";
    }

});

//session_fee validate

const min_fee =document.getElementById("min_coaching_session_price");
const ses_fee =document.getElementById("session_fee");

ses_fee.addEventListener('change', (e)=>{
const errorMsg = document.getElementById("errmsg");
    // console.log(ses_fee.value);
    if(e.target.value===''){
        return;
    }

    if(1000>e.target.value){
        e.target.style.border = "medium solid red";
        errorMsg.innerHTML = "Session fee must be greater than minimum coaching session price";
        return;
    }
    else{
        e.target.style.border = "none";
        errorMsg.innerHTML = "";

    }

})


//price calculation

StartingTime.addEventListener('change', (e)=>{
    const errorMsg = document.getElementById("errmsg");
    const errorMsg1 = document.getElementById("errmsg1");
    const BranchOpeningTime = document.getElementById("opening_time")
    // console.log(e.target.value);

    if(EndingTime.value === ""){
        return;
    }
    if("08:00">e.target.value)
       { errorMsg1.innerHTML = "Should be withing branch opening hours";
            return; } 
            errorMsg1.innerHTML = "";

    const stTime = e.target.value.split(":");
    const enTime = EndingTime.value.split(":");

    const start = new Date();
    start.setHours(stTime[0]);
    start.setMinutes(enTime[1]);

    const end = new Date();
    end.setHours(enTime[0])
    end.setMinutes(enTime[1]);

    const timeDifferenceMilli = end - start;
    if(timeDifferenceMilli <= 0){ //ending time is lower than starting time
        monthly_payment.value = "";
        errorMsg1.innerHTML = "Invalid Time Range";
        return;
    }
    errorMsg1.innerHTML = "";

    // if(StartingTime.value > EndingTime.value ){
    //     // console.log(StartingTime, EndingTime);
    //     errorMsg1.innerHTML = "Time Range is wrong. Please check again";
    //  return;   
    // }
    // errorMsg1.innerHTML = "";
   

    if(e.target.style.border === "medium solid red" || EndingTime.style.border === "medium solid red"){  //invalid time input
        monthly_payment.value = "";
        return;
    }

    const timeDifferenceHours = ((timeDifferenceMilli)/(1000*60*60));
    console.log(timeDifferenceHours);

    if(timeDifferenceHours < 1){  //minimum reservation time period
        errorMsg.innerHTML = "Minimum Session Period is 1 Hour";
        monthly_payment.value = "";
        return;
    }
    else if(timeDifferenceHours > 6){ //maximum reservation time period
        errorMsg.innerHTML = "Maximum Session Period is 6 Hours";
        monthly_payment.value = "";
        return;
    }
    
   // const minRevPrice = document.getElementById("session_fee"); ;
   calulatedPrice = 350 *(5/4) * timeDifferenceHours *4;
   monthly_payment.value = calulatedPrice;
    
});

EndingTime.addEventListener('change', (e)=>{
    const errorMsg = document.getElementById("errmsg");
    const errorMsg1 = document.getElementById("errmsg1");
    const BranchClosingTime = document.getElementById("closing_time")
    // console.log(e.target.value);

    if(StartingTime.value === ""){
        return;
    }
   if("19:30"<e.target.value)
       { errorMsg1.innerHTML = "Should be withing branch opening hours";
            return; } 
            errorMsg1.innerHTML = "";

        
    const enTime = e.target.value.split(":");
    const stTime = StartingTime.value.split(":");

    const start = new Date();
    start.setHours(stTime[0]);
    start.setMinutes(stTime[1]);

    const end = new Date();
    end.setHours(enTime[0])
    end.setMinutes(enTime[1]);

    // if(StartingTime.value > EndingTime.value ){
    //     // console.log(StartingTime, EndingTime);
    //     errorMsg1.innerHTML = "Time Range is wrong. Please check again";
    //    return;
    // }
    // errorMsg1.innerHTML = "";

    if(e.target.style.border === "medium solid red" || StartingTime.style.border === "medium solid red"){  //invalid time input
        monthly_payment.value = "";
        return;
    }
    const timeDifferenceMilli = end - start;
    if(timeDifferenceMilli <= 0){ //ending time is lower than starting time
        errorMsg1.innerHTML = "Invalid Time Range";
        monthly_payment.value = "";
        return;
    }
    errorMsg1.innerHTML = "";
    const timeDifferenceHours = ((timeDifferenceMilli/1000)/60)/60;

    if(timeDifferenceHours < 1){  //minimum reservation time period
        errorMsg.innerHTML = "Minimum Session Period is 1 Hour";
        monthly_payment.value = "";
        return;
    }
    else if(timeDifferenceHours > 6){ //maximum reservation time period
        errorMsg.innerHTML = "Maximum Session Period is 6 Hours";
        monthly_payment.value = "";
        return;
    }
    errorMsg.innerHTML = "";
    console.log(timeDifferenceHours);
    
    // const minRevPrice = document.getElementById("min_coaching_session_price");
    calulatedPrice = 350 *(5/4) * timeDifferenceHours *4;
    monthly_payment.value = calulatedPrice;
});

// function validateForm(e){
//     const errorMsg = document.getElementById("errMsg");
    
//     errorMsg.innerHTML = "";    //reset the error message

   
    
    
//     }
//     errorMsg.innerHTML = "";    //reset the error message


    // const form = document.querySelector("form");
    // if(monthly_payment.value === "" || form.reportValidity() === false){
    //     errorMsg.innerHTML = "Please Enter Information Correctly";
    //     return false;
    // }
   

   
