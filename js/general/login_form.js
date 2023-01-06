const loginForm = document.querySelector("form");
const errMsgBox = document.getElementById("errmsgbox");
const successMsgBox = document.getElementById("successmsgbox");
const activateDiv = document.getElementById("accActivationBox");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault(); //prevent the form from submitting
    activateDiv.innerHTML = ""; //clear the activation div

    const formData = new FormData(loginForm);
    const username = formData.get("username");
    const password = formData.get("password");
    const user = { username, password };

    fetch("../../controller/general/login_controller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(user),
    }).then((res) => res.json())
    .then((data) => {
        if(data.successMsg !== undefined){  //login success
            successMsgBox.innerHTML = data.successMsg;

            //disabling buttons

            const loginBtn = document.getElementById("loginBtn");   //disabling login button
            loginBtn.disabled = true;
            loginBtn.style.cursor = "not-allowed";

            const regBtn = document.getElementById("regBtn"); //disabling register button
            regBtn.disabled = true;
            regBtn.style.cursor = "not-allowed";

            if(data.userrole === 'user'){
                successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>You will be Redirected to the home page in 2 seconds";
                setTimeout(() =>{
                    window.location.href = "/index.php";
                }, 2000);
            }
            else if(data.userrole === 'coach'){
                successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>You will be Redirected to your Dashboard in 2 seconds";
                setTimeout(() =>{
                    window.location.href = "/public/coach/coach_dashboard.php";
                }, 2000);
            }
            else if(data.userrole === 'manager'){
                successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>You will be Redirected to your Dashboard in 2 seconds";
                setTimeout(() =>{
                    window.location.href = "/public/manager/Manager_Dashboard.php";
                }, 2000);
            }
        }else{  //login failed
            successMsgBox.innerHTML = "";
            errMsgBox.innerHTML = data.errMsg;
            if(data.errMsg.includes('Activate your account using the code that has been sent to your email')){  //need to activate
                const activateDiv = document.getElementById("accActivationBox");  //get the activation div
                const activateForm = document.createElement("form");  //new form activation
                const codeInput = document.createElement("input");  //input for activation code
                codeInput.placeholder = "Enter the code sent to your email";
                codeInput.type = "text";
                codeInput.name = "verificationCode";
    
                const verifyBtn = document.createElement("button"); //button for verification
                verifyBtn.innerHTML = "Activate";
                verifyBtn.type = "submit";
    
                activateForm.appendChild(codeInput);
                activateForm.appendChild(verifyBtn);
    
                activateDiv.appendChild(activateForm);

                activateForm.addEventListener("submit", (e) => {
                    e.preventDefault(); //prevent default submit
                    errMsgBox.innerHTML = "";
                    successMsgBox.innerHTML = "";
            
                    const activationData = new FormData(activateForm);
                    const userCode = activationData.get("verificationCode");
            
                    const request = {"verificationCode" : userCode, "activationType" : "activate"};    //create a json object to send to the server
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
                            successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>Now you can login to your account.";
                            activateDiv.innerHTML = ""; //remove the activation div

                        }
                        else if(data.errMsg !== undefined){  //verification failed
                            errMsgBox.innerHTML = "";
                            successMsgBox.innerHTML = "";
                            errMsgBox.innerHTML = data.errMsg;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
                });
            }
        }
    }).catch((err) => {
        console.log(err);
    });
});