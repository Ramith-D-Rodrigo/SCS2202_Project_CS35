const profileInfoTable = document.getElementById("profileInfoTable");

//editable fields

let currValues = [];    //array of current values of the fields (associative array)
let newValues = [];

//editable fields
const editableFields = ['contactNo', 'dependents', 'height', 'weight', 'homeAddress', 'medicalConcerns', 'profilePic', 'email'];

function decodeHtml(str){     //function to decode escaped html special characters
    var map =
    {
        '&amp;': '&',
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&#039;': "'"
    };
    return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
}

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
            element.innerHTML = "<i class='fa-solid fa-eye-slash'></i>";
        }
        else{   //Hide Password
            passwordField.type = 'password';
            element.innerHTML = "<i class='fa-solid fa-eye'></i>";
        }
    });
}

const concernAddBtn = document.getElementById("medicalConcernBtn");


var medicalCount = 0;   //no of medical concerns of the user
let medicalinputID = [];

function addMedicalConcern(e){
    e.preventDefault();
    if(medicalCount === 5){ //cannot add more
        return;
    }
    medicalCount++;
    if(medicalCount === 5){
        concernAddBtn.style.display = "none";
    }
    const concernListField = document.getElementById("medicalConcernsField");
    let currList = concernListField.lastChild;    //ol element
    if(currList === null || currList.tagName !== "OL"){  //no ol element found (0 medical concerns at the start)
        currList = document.createElement("ol");
        currList.style = "list-style-position:inside";   //to put the numbers inside the div container
        concernListField.appendChild(currList);
    }

    const item = document.createElement("li");
    const currID = medicalinputID.pop();
    const inputField = document.createElement("input");
    inputField.className = "concernInput";
    inputField.setAttribute('placeholder', 'ex: Have back pains');
    inputField.setAttribute('required', '');
    inputField.setAttribute('pattern',"[a-zA-Z ]+");
    inputField.setAttribute('name', 'medical_concern' + currID);
    item.id = 'medical_concern' + currID;
    item.appendChild(inputField);

    const removeBtn = document.createElement("button");
    removeBtn.innerHTML = "<i class='fa-solid fa-circle-minus'></i>";
    removeBtn.addEventListener("click", removeMedicalConcern);
    item.appendChild(removeBtn);
    currList.appendChild(item);
}

concernAddBtn.addEventListener("click", addMedicalConcern);

function removeMedicalConcern(e){   //remove medical concern when button is pressed
    e.preventDefault();
    if(medicalCount === 0){ //cannot remove more
        return;
    }
    medicalCount--;
    const parent = e.currentTarget.parentElement;  //list element
    console.log(e.currentTarget);
    const freedID = parent.id.slice(-1);    //get the removing number
    console.log(freedID);

    if(!medicalinputID.includes(parseInt(freedID))){    //does not include the item number
        medicalinputID.push(parseInt(freedID));
    }
    parent.remove();
    if(medicalCount < 5){   //can add more
        medicalConcernBtn.style.display = '';
    }
    //console.log(medicalinputID);
    console.log(currValues.medicalConcerns);
}


let emergencyCount = 1;  //no of emergency details of the user (initially 1)
let emergencydetailID = [];


const emergencyDetailsBtn = document.getElementById("emergencyDetailsBtn");
const emergencyDetailsContainer = document.getElementById("emergencyDetails");

emergencyDetailsBtn.addEventListener("click", addEmergencyContact);

function removeEmergencyContact(e){
    e.preventDefault();
    if(emergencyCount === 1){
        return;
    }
    const clickedBtn = e.currentTarget;
    const parent = clickedBtn.parentElement.parentElement.parentElement; //first parent is right field, grandparent is row container, 3rd one is the inputDiv
    emergencyCount--;

    const freedID = clickedBtn.id.slice(-1);
    emergencydetailID.push(freedID);    //available for next use
    parent.remove();
    if(emergencyCount < 3){
        emergencyDetailsBtn.parentElement.style.display = '';
    }
}

function addEmergencyContact(e){
    e.preventDefault(); //so that the page is not going to refresh
    if(emergencyCount === 3){
        return;
    }
    emergencyCount++;

    const inputDiv = document.createElement("div"); //new emergency concern
    const currID = emergencydetailID.pop();    //Assigning ID
    inputDiv.setAttribute('id', 'emergencydetail' + currID);

    const inputName = document.createElement("input");
    inputName.setAttribute('type', 'text');
    inputName.setAttribute('name', 'name' + currID);
    inputName.setAttribute('required', '');
    inputName.setAttribute('pattern', '[a-zA-Z ]+');
    inputName.setAttribute('id', 'name' + currID);

    const inputRelationship = document.createElement("select");
    inputRelationship.setAttribute('name', 'relationship' + currID);
    inputRelationship.setAttribute('required', '');
    inputRelationship.setAttribute('id', 'relationship' + currID);

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
    inputContactNum.setAttribute('id', 'contact' + currID);

    const removeBtn = document.createElement("button"); //remove button
    removeBtn.innerHTML = "<i class='fa-solid fa-circle-minus'></i>";
    removeBtn.setAttribute('id', 'removebtn' + currID);

    removeBtn.addEventListener('click', removeEmergencyContact);

    /*     const breakpoint1 = document.createElement("br");
    const breakpoint2 = document.createElement("br"); */
    const nameField = document.createTextNode("Name : ");
    const relationshipField = document.createTextNode("Relationship :");
    const contactNoField = document.createTextNode("Contact Number :");
    
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
            rightField.appendChild(removeBtn);
            row.appendChild(leftField);
            row.appendChild(rightField);
        }
        else if(info === 3){    //contact number
            leftField.appendChild(contactNoField);
            rightField.appendChild(inputContactNum);


            row.appendChild(leftField);
            row.appendChild(rightField);
        }
        inputDiv.appendChild(row);
    }
    emergencyDetailsContainer.appendChild(inputDiv);
    if(emergencyCount == 3){
        emergencyDetailsBtn.parentElement.style.display = 'none';   //hide the whole div
    }
    return currID;
}

//profile pic upload size check
function pictureSize(size){ //max size 2mb
    if(size > 2097152){
        return false;
    }
    else{
        return true;
    }
}

const editForm = document.querySelector("#editForm");   //edit form

const submitBtn = document.querySelector("#submitBtn");
submitBtn.addEventListener('click', validateChanges);

function validateChanges(e){
    if(editForm.checkValidity() === false){ //if the form is not valid   
        console.log("Form is not valid");
        return false;
    }
    console.log("Form is valid");
    return true;
}

editForm.addEventListener('submit', (e) => {
    e.preventDefault();
    console.log("Form is v2alid");
});





fetch("/controller/user/edit_profile_entry_controller.php") //get the details of the user from the server
    .then((res) => res.json())
    .then((data) => {
        console.log(data);

        //store the current values of the fields
        //get keys and values of data
        const keys = Object.keys(data);
        const values = Object.values(data);
        for(let i = 0; i < keys.length; i++){
            if(editableFields.includes(keys[i])){   //if the key is an editable field (the user can edit it)
                currValues[keys[i]] = values[i];
            }
        }
        console.log(currValues);

        const nameField = document.getElementById("nameField"); //set the name field
        nameField.innerHTML = data["fName"] + " " + data["lName"];

        const birthdayField = document.getElementById("birthdayField"); //set the birthday field
        birthdayField.innerHTML = data["dob"];

        const userContact = document.getElementById("usercontact"); //set the contact field
        userContact.value = data['contactNo'];

        const homeAddress = document.getElementById("userHomeAddress"); //set the home address field
        homeAddress.innerHTML = decodeHtml(data['homeAddress']);

        const weight = document.getElementById("weight");   //set the weight field
        weight.value = data['weight'];
        
        const height = document.getElementById("height");   //set the height field
        height.value = data['height'];

        const gender = document.getElementById("genderField");  //set the gender field
        if(data['gender'] === 'm'){
            gender.innerHTML = "Male";
        }
        else{
            gender.innerHTML = "Female";
        }

        const currEmailField = document.getElementById("currentEmailField");    //set the current email field
        currEmailField.innerHTML = data['email'];

        const usernameField = document.getElementById("usernameField");   //set the username field
        usernameField.innerHTML = data['username'];

        //set the medical concerns
        if(data['medicalConcerns'].length !== 0){   //the user has medical concerns
            medicalCount = data['medicalConcerns'].length;
            if(medicalCount === 5){   //maximum amount
                concernAddBtn.style.display = "none";
            }

            const medicalConcernsField = document.getElementById("medicalConcernsField");

            const concernList = document.createElement("ol");   //list to store the medical concerns
            concernList.style = "list-style-position:inside";   //to put the numbers inside the div container

            data['medicalConcerns'].forEach((concern, index) => {
                const concernItem = document.createElement("li");
                concernItem.id = "medicalConcern" + (index+1);
                concernItem.innerHTML = concern.medical_concern;

                const removeBtn = document.createElement("button");
                removeBtn.addEventListener("click", removeMedicalConcern);
                const icon = document.createElement("i");
                icon.className = "fa-solid fa-circle-minus";
                removeBtn.appendChild(icon);

                concernItem.appendChild(removeBtn);
                concernList.appendChild(concernItem);
            });

            medicalConcernsField.appendChild(concernList);
        }

        for(let i = medicalCount + 1; i <= 5 ; i++){   //remaining medical concerns
            medicalinputID.push(i);
        }
        console.log(medicalinputID);
        //set the profile picture
        const currProfilePicField = document.getElementById("profilePicField");
        const profilePicImg = document.createElement("img");
        //change the img container size to 100px
        currProfilePicField.style.width = "auto";
        currProfilePicField.style.height = "15rem";

        profilePicImg.style.maxHeight = "100%";

        if(data['profilePic'] !== null){    //has a profile picture  
            profilePicImg.src = data['profilePic'];
        }
        else{
            profilePicImg.src = "/styles/icons/profile_icon.svg";
        }
        profilePicImg.style.borderRadius = "50%";
        currProfilePicField.appendChild(profilePicImg);  

        //add profile picture add/edit button
        const profilePicBtn = document.getElementById("profilePicUploadBtn");

        //add event listener to the file upload input
        const fileUploadInput = document.getElementById("profilePicUploadInput");

        fileUploadInput.addEventListener("change", (e)=>{
            const file = e.target.files[0]; //get the file which has been uploaded
            if(!pictureSize(file.size)){    //if the file size is too big
                alert("File size is Too Big");
                fileUploadInput.value = ""; //clear the input
                return;
            }

            const reader = new FileReader();    //to read the file
            reader.readAsDataURL(file); //to read the file as a data url

            reader.onload = () => { //when the file is loaded
                const result = reader.result;   //get the result
                profilePicImg.src = result; //set the image source to the result
            }
        });

        //add event listener to the profile pic button
        profilePicBtn.addEventListener("click", ()=>{
            fileUploadInput.click();    //click the file upload input
        });

        //set the emergency contact details (dependents)

        //get the available id numbers
        for(let i = 2; i <= 3; i++){    //at start 2 are available (2,3)
            emergencydetailID.push(i);
        }

        //first dependent
        const dept1Name = document.getElementById("name1");
        const dept1Contact = document.getElementById("contact1");
        const dept1Relationship = document.getElementById("relationship1");

        dept1Name.value = data.dependents[0].name;
        dept1Contact.value = data.dependents[0].contact_num;
        dept1Relationship.value = data.dependents[0].relationship;

        //for other dependents
        data.dependents.forEach((dept, index) => {
            if(index !== 0){    //if not the first dependent
                const e = {
                    preventDefault: () => {}    //to prevent the default behaviour of the button
                }
                const id = addEmergencyContact(e);  //add a new emergency details
                const deptName = document.getElementById("name" + id);
                const deptContact = document.getElementById("contact" + id);
                const deptRelationship = document.getElementById("relationship" + id);

                deptName.value = dept.name;
                deptContact.value = dept.contact_num;
                deptRelationship.value = dept.relationship;
            }
        });

        if(emergencyCount === 3){   //maximum number of dependents
            emergencyDetailsBtn.parentElement.style.display = 'none';   //hide the whole div
            console.log("hide");
        }
    })
    .catch((err) => {
        console.log(err);
    });