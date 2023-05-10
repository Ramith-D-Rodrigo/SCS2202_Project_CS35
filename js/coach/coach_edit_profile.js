//editable fields

let currValues = [];    //array of current values of the fields (associative array)

//editable fields
const editableFields = ['contactNo', 'profilePic', 'email'];

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
    inputField.setAttribute('name', 'medicalConcern' + currID);
    item.id = 'medicalConcern' + currID;
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
    const freedID = parent.id.slice(-1);    //get the removing number
    console.log(freedID);

    if(!medicalinputID.includes(parseInt(freedID))){    //does not include the item number
        medicalinputID.push(parseInt(freedID));
    }
    parent.remove();
    if(medicalCount < 5){   //can add more
        concernAddBtn.style.display = '';
    }
    //console.log(medicalinputID);
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

const errMsg = document.querySelector("#errMsg");
const successMsg = document.querySelector("#successMsg");

function validateChanges(e){
    if(editForm.reportValidity() === false){ //if the form is not valid   
        errMsg.innerHTML = "Please Enter Correct Information<br>";
        return false;
    }
    errMsg.innerHTML = "";  //reset the error message
    //the form is valid from html perspective
    //check if the user has changed anything

    let flag = true;   //if the user has changed anything
    const uploadedPic = document.getElementById("profilePicUploadInput");
    if(uploadedPic.value !== ""){   //has uploaded a file
        if(!pictureSize(uploadedPic.files[0].size)){   //image too big
            errMsg.innerHTML = errMsg.innerHTML + "Uploaded Image is Too Big<br>";
            flag = false;  
        }
        else{
            errMsg.innerHTML.replace("Uploaded Image is Too Big<br>", "");
        }

        if(uploadedPic.files[0].type !== 'image/png' && uploadedPic.files[0].type !== 'image/jpeg' && uploadedPic.files[0].type !== 'image/jpg'){
            errMsg.innerHTML = errMsg.innerHTML + "Uploaded File is Not Supported. Check the File Type<br>";
            flag = false;  
        }
        else{
            errMsg.innerHTML.replace("Uploaded File is Not Supported. Check the File Type<br>", "");
        }
    }


//have to check input values validity (similary)
    const emergencyDetails = document.getElementById("emergencyDetails");
    const emergencyDetailsChildren = emergencyDetails.children;
    
    let contactNum = [];    //contact number
    let relationship = [];  //relationship
    let names = [];         //name

    //emergency contact details

    //emergencyDetailsChildren -> the children of the div container that has all the emergency contact details
    //each children is a div that contains 3 rows (row container)
    //each row has 2 children (fields -> left and right (both are divs))
    //each field has 1 element ( we need the right fields children element for input value)

    //div container -> emgcontact children -> rows -> fields -> field's children
    for(i = 0; i < emergencyDetailsChildren.length; i++){
        names[i] = emergencyDetailsChildren[i].children[0].children[1].children[0].value.toLowerCase();
        relationship[i] = emergencyDetailsChildren[i].children[1].children[1].children[0].value.toLowerCase();
        contactNum[i] = emergencyDetailsChildren[i].children[2].children[1].children[0].value; 
    }

    const usercontact = document.getElementById('usercontact').value;   //registering user contact details
    const user = document.getElementById('nameField').innerHTML.toLowerCase(); //registering user's name

    contactNum.push(usercontact);
    names.push(user);
    //removing empty fields
    contactNum = contactNum.filter(i => i !== '');   
    relationship = relationship.filter(i => i !== '');   
    names = names.filter(i => i !== ''); 

    if(new Set(contactNum).size !== contactNum.length){ //check for duplicate contact numbers
        errMsg.innerHTML = errMsg.innerHTML + "Duplicate Contact Number Details<br>";
        flag = false;  
    }
    else{
        errMsg.innerHTML.replace("Duplicate Contact Number Details<br>", '');  //Remove Contact Details Error Message
    }

    if(new Set(relationship).size !== relationship.length){ //check for duplicate relationships
        errMsg.innerHTML = errMsg.innerHTML + "Duplicate Relationship Details<br>";
        flag = false;  
    }
    else{
        errMsg.innerHTML.replace("Duplicate Relationship Details<br>", '');  //Remove relationship Error Message
    }

    if(new Set(names).size !== names.length){ //check for duplicate names
        errMsg.innerHTML = errMsg.innerHTML + "Duplicate Emergency Contact Detail Names<br>";
        flag = false;  
    }
    else{
        errMsg.innerHTML.replace("Duplicate Emergency Contact Detail Names<br>", '');  //Remove duplicate name Error Message
    }

    
    const medicalConcernDiv =  document.getElementById("medicalConcernsField");
    let medicalArr = null;
    let concerns = []
    if(medicalConcernDiv.children[0] !== undefined){
        medicalArr = Array.from(medicalConcernDiv.children[0].children);  //create an array for the elements inside (list elements) the medical concern div
        medicalArr.forEach((val, i, arr)=> {    //traverse the array
            if(val.tagName.toLowerCase() === 'li'){    //find the child list elements
                if(val.childNodes[0].nodeType === 3){  //check if the child is a text node
                    concerns.push(val.childNodes[0].nodeValue.toLowerCase());    //push the text node value
                }
                else{
                    concerns.push(val.children.item(0).value.toLowerCase());  //push the input value 
                }
            }
        })
    }

    concerns = concerns.filter(i => i !== '');
    

    if(new Set(concerns).size !== concerns.length){ //check for duplicate contact numbers
        errMsg.innerHTML = errMsg.innerHTML + "Duplicate Medical Concern Details<br>";
        flag = false;
    }
    else{
        errMsg.innerHTML.replace("Duplicate Medical Concern Details<br>", '');  //Remove Contact Details Error Message
    }

    if(flag === false){ //Has invalid inputs
        console.log("Form is invalid");
        return false;
    }
    else{   //valid to submit the data
        console.log("Form is valid");
        return true;
    }
}

const  credentialForm = document.getElementById("credentialForm");

function validateEmailPasswordForm(event){
    //passwords matching or not
    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("confirmPassword");

    if(!credentialForm.reportValidity()){
        return false;
    }

    let flag = true;

    if(password.value !== "" || passwordConfirm.value !== ""){  //the user is changing the password
        if(password.value !== passwordConfirm.value){
            errMsg.innerHTML = errMsg.innerHTML + "Passwords do not match<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Passwords do not match<br>", "");
        }
    }

    const email = document.getElementById("emailAddress");  //email address check
    if(email.value !== ""){
        if(!email.value.includes("@") || !email.value.includes(".")){
            errMsg.innerHTML = errMsg.innerHTML + "Invalid Email Address<br>";
            flag = false;
        }
        else if(email.value === currValues.email){
            errMsg.innerHTML.replace("Invalid Email Address<br>", "");
            errMsg.innerHTML = errMsg.innerHTML + "You have entered the previous Email as the new Email<br>";
        }

        else{
            errMsg.innerHTML.replace("Invalid Email Address<br>", "");
            errMsg.innerHTML.replace("You have entered the previous Email as the new Email<br>", "");
        }
    }

    if(flag === false){ //Has invalid inputs
        console.log("Form is invalid");
        return false;
    }
    else{   //valid to submit the data
        console.log("Form is valid");
        return true;
    }
}

credentialForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let newValues = []; //new values to be updated
    const formData = new FormData(credentialForm);



    if(formData.get("newPassword") === ""){    //if the user is not changing the password
        formData.delete("newPassword");
        formData.delete("newPasswordConfirm");
    }
    if(formData.get("email") === ""){   //if the user is not changing the email
        formData.delete("email");
    }
    const arr = Array.from(formData.entries());
    console.log(arr);
    if(arr.length === 0){  //if the user is not changing anything
        errMsg.innerHTML = "You have not changed anything";
        return;
    }


});

editForm.addEventListener('submit', (e) => {
    let newValues = []; //new values to be updated
    e.preventDefault();
    console.log("Form is valid");
    const formData = new FormData(editForm);

    let newMedicalConcerns = [];
    let newEmergencyDetails = [];

    let tempDependent = {
        name: "",
        relationship: "",
        contactNum: ""
    }

    for([key,value] of formData){
        if(key === "profilePic"){
            const photoSize = formData.get("profilePic").size;

            if(photoSize !== 0){    //if the user is changing the profile picture
                newValues["profilePic"] = value;
            }
            continue;

        }
        else if(key.includes("medicalConcern")){
            newMedicalConcerns.push(value);
            continue;
        }
        else if(key.includes("name")){
            tempDependent.name = value;
            continue;
        }
        else if(key.includes("relationship")){
            tempDependent.relationship = value;
            continue;
        }
        else if(key.includes("contact") && key !== "contactNo"){  //not the user's contact number
            tempDependent.contactNum = value;
            newEmergencyDetails.push(tempDependent);
            tempDependent = {
                name: "",
                relationship: "",
                contactNum: ""
            }
            continue;
        }
        if(key === 'height' || key === 'weight'){
            if(value === ''){
                value = null;
            }
        }

        if(currValues[key] !== value){  //if the value has changed
            newValues[key] = value; //add the new value to the newValues object
        }
    }

    //check for new medical concerns
    const prevMedicalConcerns = currValues.medicalConcerns.map(i => i.medicalConcern);

    let medFlag = false;
    
    if(newMedicalConcerns.length === prevMedicalConcerns.length){   //if the number of medical concerns is the same
        //check whether the medical concerns are the same
        for(let i = 0; i < newMedicalConcerns.length; i++){
            if(newMedicalConcerns[i] !== prevMedicalConcerns[i]){    //if the medical concerns are not the same
                medFlag = true;
                break;
            }
        }
    }
    else{
        if(newMedicalConcerns.length === 0){    //if the user has removed all the medical concerns
            console.log("removed all");
            newValues['medicalAllRemoved'] = true;
        }
        medFlag = true;
    }
    
    if(medFlag === true){   //if the medical concerns are not the same
        for(let i = 0; i < newMedicalConcerns.length; i++){
            newValues['medicalConcern' + (i+1)] = newMedicalConcerns[i];
        }
    }

    //check for new emergency details
    let depFlag = false;
    if(newEmergencyDetails.length === currValues.dependents.length){   //if the number of emergency details is the same
        //check whether the emergency details are the same
        for(let i = 0; i < newEmergencyDetails.length; i++){
            if(newEmergencyDetails[i].name !== currValues.dependents[i].name || newEmergencyDetails[i].relationship !== currValues.dependents[i].relationship || newEmergencyDetails[i].contactNum !== currValues.dependents[i].contactNum){
                depFlag = true;
                break;
            }
        }
    }
    else{
        depFlag = true;
    }

    if(depFlag === true){   //if the emergency details are not the same
        for(let i = 0; i < newEmergencyDetails.length; i++){
            newValues['name' + (i+1)] = newEmergencyDetails[i].name;
            newValues['relationship' + (i+1)] = newEmergencyDetails[i].relationship;
            newValues['contact' + (i+1)] = newEmergencyDetails[i].contactNum;
        }
    }

    console.log(newValues);
    if(Object.keys(newValues).length === 0){ //nothing changed
        errMsg.innerHTML = "You haven't changed Anything";
        return;
    }
    
    const sendingData  = new FormData();
    for(let key in newValues){  //add the new values to the sendingData object
        sendingData.append(key, newValues[key]);
    }

    //send the data to the server
    fetch("/controller/user/edit_profile_change_controller.php", {
        method: "POST",
        body: sendingData
    })
    .then((res) => res.json())
    .then((data) => {
        if(data.errMsg !== undefined){
            errMsg.innerHTML = data.errMsg;
        }
        else{
            successMsg.innerHTML = data.successMsg;
        }
    });
});



fetch("/controller/user/edit_profile_entry_controller.php") //get the details of the user from the server
    .then((res) => res.json())
    .then((data) => {
        //console.log(data);

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
                concernInput = document.createElement("input");
                concernInput.type = "text";
                concernInput.value = concern.medicalConcern;
                concernInput.name = "medicalConcern" + (index+1);
                concernItem.id = "medicalConcern" + (index+1);

                concernItem.appendChild(concernInput);

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

        //set the profile picture
        const currProfilePicField = document.getElementById("profilePicField");
        const profilePicImg = document.getElementById("profilePicImg");
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
        profilePicImg.setAttribute("onerror", "this.src='/styles/icons/profile_icon.svg';");

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

        //add event listener to the profile pic image

        profilePicImg.addEventListener("click", ()=>{
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
        dept1Contact.value = data.dependents[0].contactNum;
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
                deptContact.value = dept.contactNum;
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