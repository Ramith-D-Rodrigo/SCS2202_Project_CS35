const profileInfoTable = document.getElementById("profileInfoTable");

//editable fields

let currentUserContact = null;
let currentHomeAddress = null;
let currentWeight = null;
let currentHeight = null;
let currentEmailAddress = null;
let currentPassword = null;

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

        if(data['medicalConcerns'] !== 0){   //the user has medical concerns
            const medicalConcernsField = document.getElementById("medicalConcernsField");
        }

        const currProfilePicField = document.getElementById("profilePicField");
        const profilePicImg = document.createElement("img");
        profilePicImg.style.maxWidth = "25%";

        if(data['profilePic'] !== null){    //has a profile picture  
            profilePicImg.src = "profile_images/" + data['profilePic'];
        }
        else{
            profilePicImg.src = "/styles/icons/profile_icon.svg";
        }
        profilePicImg.style.borderRadius = "50%";
        currProfilePicField.appendChild(profilePicImg);  


    })