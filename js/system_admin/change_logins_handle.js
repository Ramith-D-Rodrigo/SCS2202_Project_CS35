const currEmail = document.getElementById("currEmail");
const confirmBtn = document.getElementById("confirmBtn");
const errMsg = document.getElementById("err-msg");
const successMsg = document.getElementById("success-msg");
const overlay = document.getElementById("overlay");
const newEmail = document.getElementById("newEmail");
const newPwd = document.getElementById("password");

fetch("../../controller/system_admin/admin_login_details_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        currEmail.value = data[1];
        confirmBtn.value = data[0];
    });


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

const password = document.getElementById("password");
const cPassword = document.getElementById("cPassword");
function validateForm(element){
    element.preventDefault();
    const form = document.querySelector("form");

    if(newEmail.value === '' && newPwd.value === ''){
        errMsg.innerHTML = "No Changes Made";
        return;
    }
    if(verbose){
        console.log(form.reportValidity());
    }

    if(newPwd.value !== ''){
        if(password.value != cPassword.value) {    //compare the password and the confirm password fields
            errMsg.innerHTML = "Passwords are mismatched";
            return;
        }
    }
    

    if(!form.reportValidity()){ //Form is invalid from HTML persepective
        errMsg.innerHTML = "Please Add Valid Information";
        return;
    }

    saveChanges();
}

function saveChanges(){
    
    const newDetails = {Email:newEmail.value, Password:newPwd.value, Profile:confirmBtn.value};
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