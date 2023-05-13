const currEmail = document.getElementById("currEmail");
const confirmBtn = document.getElementById("confirmBtn");
const role = document.getElementById("role");
fetch("../../controller/system_admin/admin_login_details_controller.php")
    .then((res) => res.json())
    .then((data) => {
        //console.log(data);
        currEmail.value = data[1];
        confirmBtn.value = data[0];
        role.value = "Admin";
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
    const form = document.querySelector("form");

    if(verbose){
        console.log(form.reportValidity());
    }

    if(password.value != cPassword.value) {    //compare the password and the confirm password fields
        errMsg.innerHTML = "Passwords are mismatched";
        return false;
    }

    if(!form.reportValidity()){ //Form is invalid from HTML persepective
        errMsg.innerHTML = "Please Add Valid Information";
        return false;
    }

    return true;
    
}