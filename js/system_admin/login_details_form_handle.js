//Event Handling and Client Side Validation in Staff Registration

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

function validateForm(event){
    const errMsg = document.getElementById("errmsg");   //For Displaying the Error messages
    const password = document.getElementById("newPwd");
    const cPassword = document.getElementById("confirmPwd");

    errMsg.innerHTML = '';
    const form = document.querySelector("form");

    if(verbose){
        console.log(form.reportValidity());
    }

    if(password.value != cPassword.value) {    //compare the password and the confirm password fields
        errMsg.innerHTML = errMsg.innerHTML + "Passwords are mismatched";
        return false;
    }

    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = errMsg.innerHTML + "Please Add Valid Information";
        return false;
    }
    
}



