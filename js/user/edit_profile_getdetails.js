const profileInfoTable = document.getElementById("profileInfoTable");

//editable fields

let currentUserContact = null;
let currentHomeAddress = null;
let currentWeight = null;
let currentHeight = null;
let currentEmailAddress = null;
let currentPassword = null;
let currMedicalConcerns = [];

function decodeHtml(str)    //function to decode escaped html special characters
{
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

const concernAddBtn = document.getElementById("medicalConcernBtn");


var medicalCount = 0;   //no of medical concerns of the user
let medicalinputID = [];

for(i = 1; i <=5; i++){ //array of medicalIDs
    medicalinputID.push(i);
}

function removeButtonEvent(e){
    e.preventDefault();
    medicalCount--;
    const parent = e.target.parentElement;
    const freedID = parent.id.slice(-1);    //get the removing number
    console.log(freedID);

    if(!medicalinputID.includes(parseInt(freedID))){    //does not include the item number
        medicalinputID.push(parseInt(freedID));
    }
    parent.remove();
    if(medicalCount < 5){
        medicalConcernBtn.style.display = '';
    }
    //console.log(medicalinputID);
    if(Object.keys(currMedicalConcerns).includes("medicalConcern" + freedID)){
        currMedicalConcerns["medicalConcern" + freedID] = ""; //empty string indicates that it has been removed (the user's previously set concern (not new ones))
    }

    console.log(currMedicalConcerns);
}

concernAddBtn.addEventListener("click", (e)=>{
    e.preventDefault();
    if(medicalCount === 5){ //cannot add more
        return;
    }
    medicalCount++;
    if(medicalCount === 5){
        concernAddBtn.style.display = "none";
    }
    const concernListField = document.getElementById("medicalConcernsField");
    const currList = concernListField.lastChild;    //ol element
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
    removeBtn.innerHTML = "Remove";
    removeBtn.addEventListener("click", removeButtonEvent);
    item.appendChild(removeBtn);
    currList.appendChild(item);
});


fetch("/controller/user/edit_profile_entry_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        const nameField = document.getElementById("nameField");
        nameField.innerHTML = data["fName"] + " " + data["lName"];

        const birthdayField = document.getElementById("birthdayField");
        birthdayField.innerHTML = data["dob"];

        const userContact = document.getElementById("usercontact");
        userContact.value = data['contactNo'];
        currentUserContact = data['contactNo']; //store the current value

        const homeAddress = document.getElementById("userHomeAddress");
        homeAddress.innerHTML = decodeHtml(data['homeAddress']);
        currentHomeAddress = data['homeAddress'];

        const weight = document.getElementById("weight");
        weight.value = data['weight'];
        currentWeight = data['weight'];
        
        const height = document.getElementById("height");
        height.value = data['height'];
        currentHeight = data['height'];

        const gender = document.getElementById("genderField");
        if(data['gender'] === 'm'){
            gender.innerHTML = "Male";
        }
        else{
            gender.innerHTML = "Female";
        }

        const currEmailField = document.getElementById("currentEmailField");
        currEmailField.innerHTML = data['email'];
        currentEmailAddress = data['email'];

        const usernameField = document.getElementById("usernameField");
        usernameField.innerHTML = data['username'];

        currentPassword = data['password'];

        if(data['medicalConcerns'].length !== 0){   //the user has medical concerns
            medicalCount = data['medicalConcerns'].length;
            if(medicalCount === 5){   //maximum amount
                concernAddBtn.style.display = "none";
            }
            const medicalConcernsField = document.getElementById("medicalConcernsField");
            const concernList = document.createElement("ol");   //list to store the medical concerns
            concernList.style = "list-style-position:inside";   //to put the numbers inside the div container

            for(j = 0; j < medicalCount; j++){
                const concernItem = document.createElement("li");
                concernItem.id = "medicalConcern" + (j+1);
                currMedicalConcerns['medicalConcern' +(j+1)] = data['medicalConcerns'][j].medical_concern;   
                concernItem.innerHTML = data['medicalConcerns'][j].medical_concern;

                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "Remove";
                removeBtn.addEventListener("click", removeButtonEvent);

               concernItem.appendChild(removeBtn);
               concernList.appendChild(concernItem);
            }
            medicalConcernsField.appendChild(concernList);
        }

        const currProfilePicField = document.getElementById("profilePicField");
        const profilePicImg = document.createElement("img");
        profilePicImg.style.maxWidth = "25%";

        if(data['profilePic'] !== null){    //has a profile picture  
            profilePicImg.src = data['profilePic'];
        }
        else{
            profilePicImg.src = "/styles/icons/profile_icon.svg";
        }
        profilePicImg.style.borderRadius = "50%";
        currProfilePicField.appendChild(profilePicImg);  
    })