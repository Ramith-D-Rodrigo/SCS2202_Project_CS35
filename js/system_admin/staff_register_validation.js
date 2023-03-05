function validateForm(event){
    const errMsg = document.getElementById("errmsg");   //For Displaying the Error messages
    const password = document.getElementById("password");
    const cPassword = document.getElementById("cPassword");

    const form = document.querySelector("form");

    if(verbose){
        console.log(form.reportValidity());
    }

    if(password.value != cPassword.value) {    //compare the password and the confirm password fields
        errMsg.innerHTML = errMsg.innerHTML + "Passwords are Mismatched";
        return false;
    }

    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = errMsg.innerHTML + "Please Add Valid Information";
        return false;
    }

    errMsg.innerHTML = '';
    return true;
    
}