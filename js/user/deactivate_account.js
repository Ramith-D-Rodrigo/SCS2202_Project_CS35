const deactivateBtn = document.getElementById('submitBtn3');
const deactivateForm = document.getElementById('deactivateForm');
const deactivateErrMsgBox = document.getElementById('errMsg3');
const deactivateSuccessMsgBox = document.getElementById('successMsg3');

function validateDeactivateForm(event){
    deactivateErrMsgBox.innerHTML = "";
    deactivateSuccessMsgBox.innerHTML = "";
    if(deactivateForm.reportValidity() === false){
        return false;
    }
    else{
        const formData = new FormData(deactivateForm);
        if(formData.get("password") !== formData.get("confirmPassword")){
            deactivateErrMsgBox.innerHTML = "Passwords do not match";
            return false;
        }
        else{
            return true;
        }
    }
}

deactivateForm.addEventListener("submit", function deactivatePasswordCheck(e){
    e.preventDefault();
    const formData = new FormData(deactivateForm);
    const sendingReq = Object.fromEntries(formData);

    let msgDiv = null;
    let success = null; //check the response status
    
    //add the please wait message
    deactivateSuccessMsgBox.innerHTML = "Please Wait...";

    //disable the deactivate button
    deactivateBtn.disabled = true;
    deactivateBtn.classList.add("disabled");
      
    //send the data to the server
    fetch("../../controller/user/deactivate_account_validation_controller.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
            },
        body: JSON.stringify(sendingReq)
    })
    .then(res =>{
        deactivateSuccessMsgBox.innerHTML = "";
        deactivateErrMsgBox.innerHTML = "";

        //enable the deactivate button
        deactivateBtn.disabled = false;
        deactivateBtn.classList.remove("disabled");

        if(res.ok){ //if the response status is ok
            msgDiv = deactivateSuccessMsgBox;
            success = true;
            deactivateForm.reset();         
        }
        else{   //if the response status is not ok
            msgDiv = deactivateErrMsgBox;
            success = false;
        }
        return res.json();
    })
    .then(data => { //extract the json data from the response
        msgDiv.innerHTML = data.msg;

        if(success){    //if the response status is ok
            //add the verification code input field
            const verificationCodeDiv = document.createElement("div");
            verificationCodeDiv.className = "left-field";
            verificationCodeDiv.innerHTML = "Verification Code";

            const rowContainer = document.createElement("div");
            rowContainer.className = "row-container";

            const verificationCodeInput = document.createElement("input");
            verificationCodeInput.className = "right-field";
            verificationCodeInput.required = true;
            verificationCodeInput.type = "text";
            verificationCodeInput.name = "verificationCode";

            rowContainer.appendChild(verificationCodeDiv);
            rowContainer.appendChild(verificationCodeInput);

            //delete first 2 children of the form (the password and confirm password fields)
            deactivateForm.removeChild(deactivateForm.firstElementChild);
            deactivateForm.removeChild(deactivateForm.firstElementChild);

            deactivateForm.insertBefore(rowContainer, deactivateForm.firstElementChild);

            //remove the onclick attribute of the deactivate button
            deactivateBtn.removeAttribute("onclick");
            deactivateBtn.innerHTML = "Verify the Code";

            //remove the submit event listener of the form
            deactivateForm.removeEventListener("submit", deactivatePasswordCheck);

            //add the submit event listener to the form
            deactivateForm.addEventListener("submit", (e) => {
                e.preventDefault();

                deactivateErrMsgBox.innerHTML = "";
                deactivateSuccessMsgBox.innerHTML = "";
                
                //simple verification code validation
                if(verificationCodeInput.value.length !== 6){
                    deactivateErrMsgBox.innerHTML = "Invalid verification code";
                    return;
                }

                //disable the button
                deactivateBtn.disabled = true;
                deactivateBtn.classList.add("disabled");

                const verificationCode = verificationCodeInput.value;

                const lastReq = {
                    verificationCode: verificationCode
                };

                deactivateSuccessMsgBox.innerHTML = "You will be logged out after the deactivation process.<br> Please Wait...";

                setTimeout(() => {
                    fetch("../../controller/user/deactivate_account_controller.php", {
                        method: "POST",
                        headers: {
                            "Content-Type" : "application/json"
                        },
                        body: JSON.stringify(lastReq)
                    })
                    .then(res => {

                        deactivateSuccessMsgBox.innerHTML = "";
                        deactivateErrMsgBox.innerHTML = "";

                        if(res.ok){ //successful deactivation
                            window.location.href = "../../";
                            success = true;
                        }
                        else{   //unsuccessful deactivation
                            msgDiv = deactivateErrMsgBox;
                            success = false;

                            //re-enable the button
                            deactivateBtn.disabled = false;
                            deactivateBtn.classList.remove("disabled");

                        }
                        return res.json();
                    })
                    .then((data) => {
                        if(!success){   //deactivation unsuccessful
                            msgDiv.innerHTML = data.msg;    //show the error message
                        }
                    })
                }, 1000);
            });
        }
    })
});