//Event Handling and Client Side Validation in User Registration


//Medical Concerns 

const medicalConcernContainer = document.getElementById("medCon");
const medicalConcernBtn = document.getElementById("medConbtn");

var medicalCount = 0;   //no of medical concerns of the user

medicalConcernBtn.addEventListener('click',(e)=>{
    medicalCount++;
    e.preventDefault(); //so that the page is not going to refresh

    const inputDiv = document.createElement("div"); //new medical concern
    inputDiv.setAttribute('id', 'concern' + medicalCount);

    const inputField = document.createElement("input");
    inputField.setAttribute('type', 'text');

    const removeBtn = document.createElement("button"); //remove button
    removeBtn.innerHTML = "Remove";

    removeBtn.addEventListener('click', (e)=>{
        e.preventDefault();
        const parent = removeBtn.parentElement;
        medicalCount--;
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

emergencyDetailsBtn.addEventListener('click',(e)=>{
    emergencyCount++;
    e.preventDefault(); //so that the page is not going to refresh

    const inputDiv = document.createElement("div"); //new emergency concern
    inputDiv.setAttribute('id', 'emergencydetail' + emergencyCount);

    const inputName = document.createElement("input");
    inputName.setAttribute('type', 'text');

    const inputRelationship = document.createElement("input");
    inputRelationship.setAttribute('type', 'text');

    const inputContactNum = document.createElement("input");
    inputContactNum.setAttribute('type', 'number');
    inputContactNum.setAttribute('min', '0');

    const removeBtn = document.createElement("button"); //remove button
    removeBtn.innerHTML = "Remove";

    removeBtn.addEventListener('click', (e)=>{
        e.preventDefault();
        const parent = removeBtn.parentElement;
        emergencyCount--;
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


//BirthDay maxdate

const bDay = document.getElementById("bday");
bDay.max = new Date().toISOString().split("T")[0];
console.log(new Date().toISOString().split("T")[0]);
