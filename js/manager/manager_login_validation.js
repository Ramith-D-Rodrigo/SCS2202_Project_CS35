verbose = true; //for debugging

function validateForm(event){
    const errMsg = document.getElementById("errmsgbox");    //For Displaying the Error messages
    errMsg.innerHTML = '' //empty before the validation

    const loginForm = document.getElementById("loginForm"); //get login form

    if(verbose){
        console.log(loginForm.reportValidity());
    }

    if(loginForm.reportValidity() === false){   //has errors
        errMsg.innerHTML = 'Please Enter valid information';
        event.preventDefault(); //do not submit
        return false;
    }
    else{   //can submit
        return true;
    }
}