//Event Handling and Client Side Validation in Staff Registration

var verbose = true; //debugging

//Toggle Password

const togglePasswordbtns = document.querySelectorAll(".togglePassword");
togglePasswordbtns.forEach(togglePassword);

function togglePassword(element){
    element.addEventListener('click',(e)=>{
        e.preventDefault();
        const parentDiv = element.parentElement;
        const passwordField = parentDiv.children[0];

        if(passwordField.type === 'password'){  //Show password
            passwordField.type = 'text';
            element.innerHTML = "Hide Password";
        }
        else{   //Hide Password
            passwordField.type = 'password';
            element.innerHTML = "Show Password";
        }
    });
}



//BirthDay maxDate and minDate

//maxDate
const bDay = document.getElementById("bday");
const today = new Date().toISOString().split("T")[0];
const maxYear = today.split("-");

maxYear[0] = (maxYear[0] - 20).toString();  //Must be atleast age of 14
if(verbose){
    console.log("Birthday Max Date = " + maxYear);
}

const maxDate = new Date(maxYear).toISOString().split("T")[0];
bday.max = maxDate;


//minDate
const minYear = today.split("-");

minYear[0] = (minYear[0] - 60).toString();  //Must be atleast age of 14
if(verbose){
    console.log("Birthday Min Date = " + minYear);
}

const minDate = new Date(minYear).toISOString().split("T")[0];
bday.min = minDate;