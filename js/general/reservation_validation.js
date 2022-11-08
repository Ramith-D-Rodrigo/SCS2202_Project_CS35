verbose = true;

const reserveStartingTime = document.getElementById("reserveStartingTime");

reserveStartingTime.addEventListener('change', (e)=>{
    const min = e.target.value.split(":")[1];
    if(verbose){
        console.log(e.target.value);
        console.log(min)   //get the minutes
    }

    if(!(min == '00' || min == '30')){
        console.log("Error");
        e.target.style.border = "medium solid red";
    }
    else{
        e.target.style.border = "none";
    }
});