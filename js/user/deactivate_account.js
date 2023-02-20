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

deactivateForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(deactivateForm);
    const sendingReq = Object.fromEntries(formData);

    let msgDiv = null;
    
    //add the please wait message
    deactivateSuccessMsgBox.innerHTML = "Please Wait...";
      
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
        if(res.ok){
            msgDiv = deactivateSuccessMsgBox;
            deactivateForm.reset();

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
            
        }
        else{
            msgDiv = deactivateErrMsgBox;
        }
        return res.json();
    })
    .then(data => {
        msgDiv.innerHTML = data.msg;
    })
});