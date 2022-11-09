//Event Handling and Client Side Validation in User Registration

var verbose = true; //debugging

//Medical Concerns 

const medicalConcernContainer = document.getElementById("medCon");
const medicalConcernBtn = document.getElementById("medConbtn");

var medicalCount = 0;   //no of medical concerns of the user
let medicalinputID = [];

for(i = 1; i <=5; i++){ //array of medicalIDs
    medicalinputID.push(i);
}
if(verbose){
    console.log(medicalinputID);
}


medicalConcernBtn.addEventListener('click',(e)=>{
    medicalCount++;
    if(verbose){
        console.log("Medical concern Add button clicked -> count = " + medicalCount);
    }
    e.preventDefault(); //so that the page is not going to refresh

    const inputDiv = document.createElement("div"); //new medical concern
    //inputDiv.setAttribute('id', 'concern' + medicalCount);
    const currID = medicalinputID.pop();    //Assigning ID
    const inputField = document.createElement("input");
    inputField.setAttribute('type', 'text');
    inputField.setAttribute('name', 'medical_concern' + currID);
    inputField.setAttribute('placeholder', 'ex: Have back pains');
    inputField.setAttribute('required', '');
    inputField.setAttribute('pattern',"[a-zA-Z ]+");

    const removeBtn = document.createElement("button"); //remove button
    removeBtn.innerHTML = "Remove";
    removeBtn.setAttribute('id', 'removebtn' + currID);

    removeBtn.addEventListener('click', (e)=>{
        medicalCount--;
        if(verbose){
            console.log("Medical concern Remove button clicked -> count = " + medicalCount);
        }
        e.preventDefault();
        const freedID = removeBtn.id.slice(-1);
        medicalinputID.push(freedID);
        const parent = removeBtn.parentElement;
        parent.remove();
        if(medicalCount < 5){
            medicalConcernBtn.style.display = 'block';
        }
    });

    inputDiv.appendChild(inputField);
    inputDiv.appendChild(removeBtn);

    medicalConcernContainer.appendChild(inputDiv);
    if(medicalCount == 5){
        medicalConcernBtn.style.display = 'none';
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

//Emergency Contact Details

const emergencyDetailsContainer = document.getElementById("emergencyDetails");
const emergencyDetailsBtn = document.getElementById("emergencyDetailsbtn");

var emergencyCount = 1;   //no of emergency details of the user
let emergencydetailID = [];

for(i = 2; i <=3; i++){ //array of medicalIDs
    emergencydetailID.push(i);
}
if(verbose){
    console.log(emergencydetailID);
}

emergencyDetailsBtn.addEventListener('click',(e)=>{
    emergencyCount++;
    if(verbose){
        console.log("Emergency contact Add button clicked -> count = " + emergencyCount);
    }
    e.preventDefault(); //so that the page is not going to refresh

    const inputDiv = document.createElement("div"); //new emergency concern
    //inputDiv.setAttribute('id', 'emergencydetail' + emergencyCount);
    const currID = emergencydetailID.pop();    //Assigning ID

    const inputName = document.createElement("input");
    inputName.setAttribute('type', 'text');
    inputName.setAttribute('name', 'name' + currID);
    inputName.setAttribute('required', '');

    const inputRelationship = document.createElement("select");
    inputRelationship.setAttribute('name', 'relationship' + currID);
    inputRelationship.setAttribute('required', '');

    const relationshipOptions = ["Mother", "Father", "Sibling 1", "Sibling 2", "Friend 1", "Friend 2", "Partner"];

    const initialOption = document.createElement("option");
    initialOption.setAttribute('value','');
    initialOption.innerHTML = "Choose One";
    inputRelationship.appendChild(initialOption);


    for(i = 0; i < 7; i++){
        const optionField = document.createElement("option");
        optionField.setAttribute('value',relationshipOptions[i]);
        optionField.innerHTML = relationshipOptions[i];
        inputRelationship.appendChild(optionField); //append the child option
    }

    const inputContactNum = document.createElement("input");
    inputContactNum.setAttribute('type', 'text');
    inputContactNum.setAttribute('min', '0');
    inputContactNum.setAttribute('pattern', '[0-9]{10,11}');
    inputContactNum.setAttribute('name', 'emgcontactNum' + currID);
    inputContactNum.setAttribute('required', '');

    const removeBtn = document.createElement("button"); //remove button
    removeBtn.innerHTML = "Remove";
    removeBtn.setAttribute('id', 'removebtn' + currID);

    removeBtn.addEventListener('click', (e)=>{
        e.preventDefault();
        const parent = removeBtn.parentElement;
        emergencyCount--;

        const freedID = removeBtn.id.slice(-1);
        emergencydetailID.push(freedID);
        if(verbose){
            console.log("Emergency contact Remove button clicked -> count = " + emergencyCount);
        }
        parent.remove();
        if(emergencyCount < 3){
            emergencyDetailsBtn.style.display = 'block';
        }
    });

    const breakpoint1 = document.createElement("br");
    const breakpoint2 = document.createElement("br");
    const nameField = document.createTextNode("Name: ");
    const relationshipField = document.createTextNode("Relationship: ");
    const contactNoField = document.createTextNode("Contact Number: ");
    
    inputDiv.appendChild(nameField);
    inputDiv.appendChild(inputName);
    inputDiv.appendChild(breakpoint1);

    inputDiv.appendChild(relationshipField);
    inputDiv.appendChild(inputRelationship);
    inputDiv.appendChild(breakpoint2);

    inputDiv.appendChild(contactNoField);
    inputDiv.appendChild(inputContactNum);
    inputDiv.appendChild(removeBtn);

    emergencyDetailsContainer.appendChild(inputDiv);
    if(emergencyCount == 3){
        emergencyDetailsBtn.style.display = 'none';
    }
});


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