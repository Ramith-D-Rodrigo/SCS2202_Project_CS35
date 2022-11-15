//Event Handling and Client Side Validation in User Registration

var verbose = true; //debugging

//Coach Qualifiactions 

const qualificationContainer = document.getElementById("quali");
const qualificationBtn = document.getElementById("qualification");

var qualificationcount = 0;   //no of qualifications of the coach
let qualificationinputID = [];

for(i = 1; i <=5; i++){ //array of qualifiactionsIDs
    qualificationsinputID.push(i);
}
if(verbose){
    console.log(qualificationsinputID);
}


qualificationBtn.addEventListener('click',(e)=>{
    qualificationCount++;
    if(verbose){
        console.log("Qualifiaction Add button clicked -> count = " + qualificationcount);
    }
    e.preventDefault(); //so that the page is not going to refresh

    const inputDiv = document.createElement("div"); //new qualification
    //inputDiv.setAttribute('id', 'concern' + qualificationCount);
    const currID = qualificationinputID.pop();    //Assigning ID
    const inputField = document.createElement("input");
    inputField.setAttribute('type', 'text');
    inputField.setAttribute('name', 'coach_qualification' + currID);
    inputField.setAttribute('placeholder', 'ex: Have back pains');
    inputField.setAttribute('required', '');
    inputField.setAttribute('pattern',"[a-zA-Z ]+");

    const removeBtn = document.createElement("button"); //remove button
    removeBtn.innerHTML = "Remove";
    removeBtn.setAttribute('id', 'removebtn' + currID);

    removeBtn.addEventListener('click', (e)=>{
        qualificationCount--;
        if(verbose){
            console.log("Qualification Remove button clicked -> count = " + qualificationcount);
        }
        e.preventDefault();
        const freedID = removeBtn.id.slice(-1);
        medicalinputID.push(freedID);
        const parent = removeBtn.parentElement;
        parent.remove();
        if(qualificationcount < 5){
            qualificationBtn.style.display = 'block';
        }
    });

    inputDiv.appendChild(inputField);
    inputDiv.appendChild(removeBtn);

    qualificationContaine.appendChild(inputDiv);
    if(qualificationCount == 5){
        qualificationBtn.style.display = 'none';
    }
});

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

maxYear[0] = (maxYear[0] - 14).toString();  //Must be atleast age of 14
if(verbose){
    console.log("Birthday Max Date = " + maxYear);
}

const maxDate = new Date(maxYear).toISOString().split("T")[0];
bday.max = maxDate;


//minDate
const minYear = today.split("-");

minYear[0] = (minYear[0] - 100).toString();  //Must be atleast age of 14
if(verbose){
    console.log("Birthday Min Date = " + minYear);
}

const minDate = new Date(minYear).toISOString().split("T")[0];
bday.min = minDate;

//message focues

const errMsg = document.getElementById("errmsg");
console.log(errMsg.innerHTML.length);
if(errMsg.innerHTML.length !== 0){
    window.location.hash = '#errmsg';
}

const successMsg = document.getElementById('successmsg');
if(successMsg.innerHTML.length !== 0){
    window.location.hash ="#successmsg";
}
