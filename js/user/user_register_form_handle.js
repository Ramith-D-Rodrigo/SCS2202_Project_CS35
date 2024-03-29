//Event Handling and Client Side Validation in User Registration

import { MIN_USER_REGISTRATION_AGE } from "../CONSTANTS.js";

var verbose = false; //debugging

//Medical Concerns 

const medicalConcernContainer = document.getElementById("medCon");
const medicalConcernBtn = document.getElementById("medConbtn");

var medicalCount = 0;   //no of medical concerns of the user
let medicalinputID = [];

for(let i = 1; i <=5; i++){ //array of medicalIDs
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

for(let i = 2; i <=3; i++){ //array of emergencyIDs
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
    const currID = emergencydetailID.pop();    //Assigning ID
    inputDiv.setAttribute('id', 'emergencydetail' + currID);

    const inputName = document.createElement("input");
    inputName.setAttribute('type', 'text');
    inputName.setAttribute('name', 'name' + currID);
    inputName.setAttribute('required', '');
    inputName.setAttribute('pattern', '[a-zA-Z ]+');

    const inputRelationship = document.createElement("select");
    inputRelationship.setAttribute('name', 'relationship' + currID);
    inputRelationship.setAttribute('required', '');

    const relationshipOptions = ["Mother", "Father", "Sibling 1", "Sibling 2", "Friend 1", "Friend 2", "Partner", "Other"];

    const initialOption = document.createElement("option");
    initialOption.setAttribute('value','');
    initialOption.innerHTML = "Choose One";
    inputRelationship.appendChild(initialOption);


    for(let i = 0; i < relationshipOptions.length; i++){
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
        const parent = removeBtn.parentElement.parentElement.parentElement; //first parent is right field, grandparent is row container, 3rd one is the inputDiv
        emergencyCount--;

        const freedID = removeBtn.id.slice(-1);
        emergencydetailID.push(freedID);
        if(verbose){
            console.log("Emergency contact Remove button clicked -> count = " + emergencyCount);
        }
        parent.remove();
        if(emergencyCount < 3){
            emergencyDetailsBtn.parentElement.style.display = '';
        }
    });

    const nameField = document.createTextNode("Name");
    const relationshipField = document.createTextNode("Relationship");
    const contactNoField = document.createTextNode("Contact Number");
    
    for(let info = 1; info <= 3; info++){   //info = 1 -> name, info = 2 -> relationship, info = 3 -> contact number
        const row = document.createElement("div");
        row.className = "row-container";
    
        const leftField = document.createElement("div");
        leftField.className = "left-field";
    
        const rightField = document.createElement("div");
        rightField.className = "right-field";

        if(info === 1){ //name
            leftField.appendChild(nameField);
            rightField.appendChild(inputName);

            row.appendChild(leftField);
            row.appendChild(rightField);
        }
        else if(info === 2){    //relationship
            leftField.appendChild(relationshipField);
            rightField.appendChild(inputRelationship);

            row.appendChild(leftField);
            row.appendChild(rightField);
        }
        else if(info === 3){    //contact number
            leftField.appendChild(contactNoField);
            rightField.appendChild(inputContactNum);
            rightField.appendChild(removeBtn);

            row.appendChild(leftField);
            row.appendChild(rightField);
        }
        inputDiv.appendChild(row);
    }
    emergencyDetailsContainer.appendChild(inputDiv);
    if(emergencyCount == 3){
        emergencyDetailsBtn.parentElement.style.display = 'none';   //hide the whole div
    }
});


//BirthDay maxDate and minDate

//maxDate
const bDay = document.getElementById("bday");
const today = new Date().toISOString().split("T")[0];
const maxYear = today.split("-");

maxYear[0] = (maxYear[0] - MIN_USER_REGISTRATION_AGE).toString();  //Must be atleast age of 14
if(verbose){
    console.log("Birthday Max Date = " + maxYear);
}

const maxDate = new Date(maxYear).toISOString().split("T")[0];
bday.max = maxDate;


//minDate
const minYear = today.split("-");

minYear[0] = (minYear[0] - 100).toString();  //not more than 100 years old
if(verbose){
    console.log("Birthday Min Date = " + minYear);
}

const minDate = new Date(minYear).toISOString().split("T")[0];
bday.min = minDate;

//message focuses

const errMsg = document.getElementById("errmsg");
//console.log(errMsg.innerHTML.length);
if(errMsg.innerHTML.length !== 0){
    window.location.hash = '#errmsg';
}

const successMsg = document.getElementById('successmsg');
if(successMsg.innerHTML.length !== 0){
    window.location.hash ="#successmsg";
}
