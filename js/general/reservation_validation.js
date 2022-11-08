verbose = true;

const reserveStartingTime = document.getElementById("reserveStartingTime");
const reserveEndingTime = document.getElementById("reserveEndingTime");
const reservationPrice = document.getElementById("reservationPrice");

reserveStartingTime.addEventListener('change', (e)=>{
    const min = e.target.value.split(":")[1];
    if(verbose){
        //console.log(e.target.value);
        //console.log(min)   //get the minutes
    }

    if(!(min == '00' || min == '30') || !(e.target.min <= e.target.value && e.target.max >= e.target.value)){
        e.target.style.border = "medium solid red";
    }
    else{
        e.target.style.border = "none";
    }
});

reserveEndingTime.addEventListener('change', (e)=>{
    const min = e.target.value.split(":")[1];
    if(verbose){
        //console.log(e.target.value);
        //console.log(min)   //get the minutes
    }

    if(!(min == '00' || min == '30') || !(e.target.min <= e.target.value && e.target.max >= e.target.value)){
        e.target.style.border = "medium solid red";
    }
    else{
        e.target.style.border = "none";
    }

});

//date constraints    -->  atleast 3 days before, at most a month

function addDays(date, days){   //function to add days
    let result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

const today = new Date().toISOString().split("T")[0];
const reservationDate = document.getElementById("reservationDate");

const minDate = addDays(today, 3).toISOString().split("T")[0];
const maxDate = addDays(today, 30).toISOString().split("T")[0];

reservationDate.min = minDate;
reservationDate.max = maxDate;