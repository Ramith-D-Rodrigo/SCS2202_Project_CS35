function validateForm(event){
    const errMsg = document.getElementById("errmsg");   //For Displaying the Error messages
    errMsg.innerHTML = '';
    const form = document.querySelector("form");

    if(verbose){
        console.log(form.reportValidity());
    }

    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = errMsg.innerHTML + "Please Add Valid Information";
        return false;
    }
    else{   //Form is valid from HTML perspective
    
    //have to check input values validity
        let flag = true;    //for final validation
        if(flag === false){ //Has invalid inputs
            return false;
        }
        else{   //valid to submit the data
            return true;
        }
    }
    
}