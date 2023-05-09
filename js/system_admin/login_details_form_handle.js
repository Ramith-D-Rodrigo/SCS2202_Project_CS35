//Event Handling in Staff Registration

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
    const errMsg = document.getElementById("err-msg");   //For Displaying the Error messages
    const password = document.getElementById("newPwd");
    const cPassword = document.getElementById("confirmPwd");
    const branch = document.getElementById("branchName");
    const staffRole = document.getElementById("staffRole");
    const male = document.getElementById("male");
    const female = document.getElementById("female");

    if(branch.value === "" || staffRole.value === ""){   //Haven't selected any specific role 
        event.preventDefault(); //do not submit
        errMsg.innerHTML = "Haven't Selected any Specific Role";
        return false;
    }
    if(!male.checked && !female.checked){
        event.preventDefault(); //do not submit
        errMsg.innerHTML = "Haven't Mentioned the Gender";
        return false;
    }
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
        
    errMsg.innerHTML = '' //empty before the validation
    return true;
    
}



