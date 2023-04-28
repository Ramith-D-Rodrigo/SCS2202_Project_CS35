const regForm = document.querySelector("form");
const errMsgBox = document.getElementById("errmsg");
const successMsgBox = document.getElementById("successmsg");

regForm.addEventListener("submit", (e) => {
    e.preventDefault(); //prevent default submit

    const formData = new FormData(regForm);

    const regBtn = document.getElementById("registerBtn"); //disabling register button

    regBtn.disabled = true;
    regBtn.style.cursor = "not-allowed";

    regBtn.innerHTML = "Registering...";


    //adding just formData is enough since the browser will automatically set the header as multipart/form-data (this is useful for file uplaoding)

    fetch("../../controller/user/register_controller.php", {
        method: "POST",
        body : formData
    })
    .then((res) => res.json())
    .then((data) => {
        if(data.RegUnsuccessMsg !== undefined){ //registration failed
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = "";
            errMsgBox.innerHTML = data.RegUnsuccessMsg;

            //enabling register button
            regBtn.disabled = false;
            regBtn.style.cursor = "pointer";
            regBtn.innerHTML = "Register";

        }
        else if(data.RegSuccessMsg !== undefined){  //registration success
            errMsgBox.innerHTML = "";
            successMsgBox.innerHTML = "";
            successMsgBox.innerHTML = data.RegSuccessMsg;

            const regBtn = document.getElementById("registerBtn"); //disabling register button
            regBtn.disabled = true;
            regBtn.style.cursor = "not-allowed";

            //email verification

            const formDiv = document.getElementById("mailVerificationBox");  //get the verification div

            const verifyForm = document.createElement("form");  //new form verification
            const codeInput = document.createElement("input");  //input for verification code
            codeInput.placeholder = "Enter the code sent to your email";
            codeInput.type = "text";
            codeInput.name = "verificationCode";

            const verifyBtn = document.createElement("button"); //button for verification
            verifyBtn.innerHTML = "Verify Email";
            verifyBtn.type = "submit";

            verifyForm.appendChild(codeInput);
            verifyForm.appendChild(verifyBtn);

            formDiv.appendChild(verifyForm);

            verifyForm.addEventListener("submit", (e) => {
                e.preventDefault(); //prevent default submit
                successMsgBox.innerHTML = "";
                errMsgBox.innerHTML = "";

                //disable the button
                verifyBtn.disabled = true;
                verifyBtn.style.cursor = "not-allowed";
                verifyBtn.innerHTML = "Verifying...";

    
                const verificationData = new FormData(verifyForm);
                const userCode = verificationData.get("verificationCode");


                const request = {"verificationCode" : userCode, "activationType" : "registration"};    //create a json object to send to the server
                fetch("../../controller/user/account_activation_controller.php", {
                    method: "POST",
                    header: {
                        "Content-Type" : "application/json"
                    },
                    body: JSON.stringify(request)

                })
                .then((res) => res.json())
                .then((data) => {
                    if(data.successMsg !== undefined){  //verification success
                        errMsgBox.innerHTML = "";
                        successMsgBox.innerHTML = "";
                        successMsgBox.innerHTML = data.successMsg;
                        successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>You will be Redirected to the home page in 2 seconds";
                        setTimeout(() =>{
                            window.location.href = "/";
                        }
                        , 2000);
                    }
                    else if(data.errMsg !== undefined){  //verification failed
                        errMsgBox.innerHTML = "";
                        successMsgBox.innerHTML = "";
                        errMsgBox.innerHTML = data.errMsg;

                        //re-enable the button
                        verifyBtn.disabled = false;
                        verifyBtn.style.cursor = "pointer";
                        verifyBtn.innerHTML = "Verify Email";
                    }
                })
                .catch((err) => {
                    console.log(err);

                    //re-enable the button
                    verifyBtn.disabled = false;
                    verifyBtn.style.cursor = "pointer";
                    verifyBtn.innerHTML = "Verify Email";
                });
            });
        }
    })
    .catch((err) => {
        console.log(err);

        //enabling register button
        regBtn.disabled = false;
        regBtn.style.cursor = "pointer";
        regBtn.innerHTML = "Register";
    });
});