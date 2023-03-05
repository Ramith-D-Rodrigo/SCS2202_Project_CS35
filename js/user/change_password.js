const  credentialForm = document.getElementById("credentialForm");
const passwordErrMsg = document.getElementById("errMsg2");
const passwordSuccessMsg = document.getElementById("successMsg2");

const passwordFieldsDiv = document.querySelector("#passwordFields");
const passwordChangeButton = document.getElementById("submitBtn2");
const verificationCodeField = document.getElementById("verificationCode");


function validateCredentialsForm(event){
    //passwords matching or not
    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("confirmPassword");
    passwordErrMsg.innerHTML = "";

    if(!credentialForm.reportValidity()){
        return false;
    }

    let flag = true;

    if(password.value == "" || passwordConfirm.value == ""){  //passwords are empty
        flag = false;
        passwordErrMsg.innerHTML = "Password cannot be empty";
    }
    else{
        if(password.value !== passwordConfirm.value){
            passwordErrMsg.innerHTML = passwordErrMsg.innerHTML + "Passwords do not match<br>";
            flag = false;
        }
        else{
            passwordErrMsg.innerHTML.replace("Passwords do not match<br>", "");
        }
    }

    if(flag === false){ //Has invalid inputs
        console.log("Form is invalid");
        return false;
    }
    else{   //valid to submit the data
        console.log("Form is valid");
        return true;
    }
}

credentialForm.addEventListener('submit', function passwordRequest(e){
    e.preventDefault();

    const formData = new FormData(credentialForm);
    const arr = Array.from(formData.entries());
    if(arr.length === 0){  //if the user is not changing anything
        passwordErrMsg.innerHTML = "You have not changed anything";
        return;
    }

    passwordSuccessMsg.innerHTML = "Please wait while we send you a verification code";

    //send the data to the server
    fetch('../../controller/user/change_password_validation_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
            },
        body: JSON.stringify(Object.fromEntries(formData.entries()))
        }).then(res => {
            if(!res.ok){
                passwordErrMsg.innerHTML = "Something went wrong. Please try again later";
                return false;
            }
            else{
                passwordSuccessMsg.innerHTML = "Please check your email for the verification code";
                return res.json();
            }
        })
        .then((data) => {
            //if the data is not success, get the new promise reject message
            if(data !== false){
                credentialForm.reset();   //clear the form
                passwordFieldsDiv.parentElement.removeChild(passwordFieldsDiv); //remove the password fields
                verificationCodeField.style.display = "";   //show the verification code input

                //remove the credential form submit event listener
                credentialForm.removeEventListener('submit', passwordRequest);

                //remove password change button event listener
                passwordChangeButton.removeAttribute("onclick");
                passwordChangeButton.innerHTML = "Verify Code";

                //add the verification code form submit event listener
                credentialForm.addEventListener('submit', function verifyCode(e){
                    e.preventDefault();

                    const formData = new FormData(credentialForm);

                    const verificationCode = Object.fromEntries(formData.entries());

                    fetch("../../controller/user/change_password_controller.php", { //send the verification code to the server
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json'
                            },
                        body: JSON.stringify(verificationCode)
                        })
                        .then(res => {
                            if(!res.ok){    //invalid response
                                if(res.status === 401){ //invalid verification code
                                    passwordErrMsg.innerHTML = "Invalid verification code";
                                }
                                else{   //server error
                                    passwordErrMsg.innerHTML = "Something went wrong. Please try again later";
                                }
                            }
                            return res.json();
                        })
                        .then((data) => {
                            if(data.errMsg === undefined){  //if there is no error message
                                passwordErrMsg.innerHTML = "";
                                passwordSuccessMsg.innerHTML = "Password Changed Successfully";

                                //remove the verification code input and show the password fields again
                                verificationCodeField.style.display = "none";
                                //remove the verification code form submit event listener
                                credentialForm.removeEventListener('submit', verifyCode);
                                //remove the verification code form submit event listener
                                credentialForm.addEventListener('submit', passwordRequest);

                                //remove password change button event listener
                                passwordChangeButton.innerHTML = "Save Changes <i class='fa-solid fa-floppy-disk'></i>";
                                passwordChangeButton.setAttribute("onclick", "validateCredentialsForm(event)");
                                //show the password fields
                                verificationCodeField.parentElement.insertBefore(passwordFieldsDiv, verificationCodeField);
                            }
                        });


                });

            }

        })

});