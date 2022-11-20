verbose = true;

const StartingTime = document.getElementById("StartingTime");
const EndingTime = document.getElementById("EndingTime");
const session_fee = document.getElementById("session_fee");
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
    if(verbose){
        //console.log(e.target.value);
        //console.log(min)   //get the minutes
    }

    if(!(min == '00' || min == '30') ){
        e.target.style.border = "medium solid red";
    }
    else{
        e.target.style.border = "none";
    }

});


//price calculation

StartingTime.addEventListener('change', (e)=>{
    const errorMsg = document.getElementById("errMsg");
    if(EndingTime.value === ""){
        return;
    }
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
        errorMsg.innerHTML = "Invalid Time Range";
        return;
    }
    errorMsg.innerHTML = "";

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
    
    const minRevPrice = document.getElementById("min_coaching_session_price");
    calulatedPrice = minRevPrice * timeDifferenceHours *4;
    monthly_payment.value = calulatedPrice;
});

EndingTime.addEventListener('change', (e)=>{
    const errorMsg = document.getElementById("errmsg");
    if(StartingTime.value === ""){
        return;
    }
    const enTime = e.target.value.split(":");
    const stTime = StartingTime.value.split(":");

    const start = new Date();
    start.setHours(stTime[0]);
    start.setMinutes(stTime[1]);

    const end = new Date();
    end.setHours(enTime[0])
    end.setMinutes(enTime[1]);



    if(e.target.style.border === "medium solid red" || StartingTime.style.border === "medium solid red"){  //invalid time input
        monthly_payment.value = "";
        return;
    }
    const timeDifferenceMilli = end - start;
    if(timeDifferenceMilli <= 0){ //ending time is lower than starting time
        errorMsg.innerHTML = "Invalid Time Range";
        monthly_payment.value = "";
        return;
    }
    errorMsg.innerHTML = "";
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
    
    const minRevPrice = document.getElementById("min_coaching_session_price");
    calulatedPrice = minRevPrice * timeDifferenceHours * 4;
    reservationPrice.value = calulatedPrice;
});


function validateForm(e){
    const errorMsg = document.getElementById("errMsg");
    if(StartingTime.value > EndingTime.value){
        console.log(StartingTime, EndingTime);
        errorMsg.innerHTML = "Time Range is wrong. Please check again";
        return false;
    }
    errorMsg.innerHTML = "";    //reset the error message

    const form = document.querySelector("form");
    if(monthly_payment.value === "" || form.reportValidity() === false){
        errorMsg.innerHTML = "Please Enter Information Correctly";
        return false;
    }
   

   
}