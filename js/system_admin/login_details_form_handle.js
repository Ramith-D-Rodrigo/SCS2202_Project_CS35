var errMsg = document.getElementById("err-msg");   //For Displaying the Error messages
const password = document.getElementById("newPwd");
const cPassword = document.getElementById("confirmPwd");
const branch = document.getElementById("branchName");
var staffRole = document.getElementById("staffRole");
const newEmail = document.getElementById("newEmail");
const confirmBtn = document.getElementById("confirmBtn");
const overlay = document.getElementById("overlay");
const successMsg = document.getElementById("success-msg");

var verbose = true; //debugging

//Toggle Password

const togglePasswordbtns = document.querySelectorAll(".togglePassword");
togglePasswordbtns.forEach(togglePassword);

function togglePassword(element){
    element.addEventListener('click',(e)=>{
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

function validateForm(event){
    event.preventDefault();
    if(branch.value === "" || staffRole.value === ""){   //Haven't selected any specific role 
        event.preventDefault(); //do not submit
        errMsg.innerHTML = "Haven't Selected any Specific Role";
        return false;
    }
    if(newEmail.value === '' && password.value === ''){
        errMsg.innerHTML = "No Changes Made";
        return;
    }
    if(verbose){
        console.log(form.reportValidity());
    }

    if(password.value !== ''){
        if(password.value != cPassword.value) {    //compare the password and the confirm password fields
            errMsg.innerHTML = "Passwords are mismatched";
            return;
        }
    }

    if(!form.reportValidity()){ //Form is invalid from HTML persepective
        errMsg.innerHTML = "Please Add Valid Information";
        return;
    }

    errMsg.innerHTML = '' //empty before the validation
    saveChanges();
    
}

function saveChanges(){
    
    const newDetails = {Email:newEmail.value, Password:password.value, Profile:confirmBtn.value};
    console.log(newDetails);
    fetch("../../controller/system_admin/change_login_controller.php",{
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(newDetails),
    })
    .then((res)=>res.json())
    .then((data)=>{
        console.log(data);
        if(!data['Flag']){
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            successMsg.style.display = "block";

            successMsg.innerHTML = data['Message'];
            overlay.style.display = "block";

            setTimeout(function(){
                location.reload();
            },3000);
        }else{
            errMsg.innerHTML = data['Message'];
        }
    });
    
}
