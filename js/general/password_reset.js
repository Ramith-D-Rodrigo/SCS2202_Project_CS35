function validateForm(event){
    const form = document.querySelector('form');    //email, username check form

    if(form.reportValidity() === false){
        return false;
    }
    return true;
}

function validatePasswordForm(event){
    const form = document.querySelector('form');    //email, username check form

    if(form.reportValidity() === false){
        return false;
    }
    //now check if the passwords match
    const password = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    const errMsgBox = document.getElementById('errmsgbox');  //error message box
    errMsgBox.innerHTML = "Passwords do not match";

    if(password !== confirmPassword){
        return false;
    }
    errMsgBox.innerHTML = "";
    return true;
}

function togglePasswordVisibility(event){
    event.preventDefault();
    const parentDiv = event.target.parentNode;
    const passwordField = parentDiv.children[0];

    if(passwordField.type === 'password'){  //Show password
        passwordField.type = 'text';
        event.target.innerHTML = "Hide Password";
    }
    else{   //Hide Password
        passwordField.type = 'password';
        event.target.innerHTML = "Show Password";
    }
}

const form = document.querySelector('form');    //email, username check form
const errMsgBox = document.getElementById('errmsgbox');  //error message box
const successMsgBox = document.getElementById('successmsgbox');  //success message box

form.addEventListener('submit', checkuserInput = (e)=>{
    e.preventDefault(); //prevent page reload

    //get form data
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);

    //disable the button to prevent multiple submissions
    const checkBtn = document.getElementById('checkBtn');
    checkBtn.disabled = true;
    checkBtn.innerHTML = "Checking...";
    checkBtn.classList.add('disabled');
    

    //send data to server
    fetch('../../controller/general/email_username_check_controller.php', { //check the user input
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(res => res.json())
    .then(data => {
        if(data.errMsg === undefined){  //if no error
            //if email or username is correct, send email
            errMsgBox.innerHTML = "";
            successMsgBox.innerHTML = data.successMsg;
            const formParent = form.parentNode;


            const inputDiv = document.getElementById('inputDiv'); //input div
            inputDiv.innerHTML = "";
            inputDiv.innerHTML = "Enter the code sent to your email: <input type='text' name='userInputCode' id='code' required>";
            
            const checkBtn = document.getElementById('checkBtn'); //check button

            //re enable the button
            checkBtn.disabled = false;
            checkBtn.innerHTML = "Verify Code";
            checkBtn.classList.remove('disabled');
            checkBtn.setAttribute('id', 'verifyBtn');

            //code resend button
            const resendBtn = document.createElement('button');
            resendBtn.setAttribute('id', 'resendBtn');
            resendBtn.innerHTML = "Resend Code";

            //button container
            const btnContainer = document.getElementById('btnContainer');
            btnContainer.appendChild(resendBtn);

            //add event listener to resend button
            resendBtn.addEventListener('click', resendCode = (e)=>{
                e.preventDefault();
                
                //disable the button to prevent multiple submissions
                resendBtn.disabled = true;
                resendBtn.innerHTML = "Resending...";
                resendBtn.classList.add('disabled');

                fetch('../../controller/general/resend_code_controller.php', { //check the user input
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                }).then(res => res.json())
                .then(data => {
                    //re enable the button
                    resendBtn.disabled = false;
                    resendBtn.innerHTML = "Resend Code";
                    resendBtn.classList.remove('disabled');

                    if(data.errMsg === undefined){  //if no error
                        successMsgBox.innerHTML = data.successMsg;
                    }
                    else{
                        errMsgBox.innerHTML = data.errMsg;
                    }
                })
            });

            //change the form's submit event listener
            form.removeEventListener('submit', checkuserInput);

            form.addEventListener('submit', checkCode = (e)=>{  //now for the code check
                e.preventDefault(); //prevent page reload

                const codeCheckFormData = new FormData(form);
                const codeCheckData = Object.fromEntries(codeCheckFormData);

                //disable the button to prevent multiple submissions
                const verifyBtn = document.getElementById('verifyBtn');
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = "Verifying...";
                verifyBtn.classList.add('disabled');
                
                fetch('../../controller/general/reset_code_check_controller.php', { //check the user input
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(codeCheckData)
                })
                .then(res => res.json())
                .then(data => {
                    //re enable the button
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = "Verify Code";
                    verifyBtn.classList.remove('disabled');


                    if(data.errMsg === undefined){  //if no error (code is correct)
                        //remove the code input field
                        const codeInputDiv = document.getElementById('inputDiv');
                        codeInputDiv.remove();

                        //remove resend button
                        const resendBtn = document.getElementById('resendBtn');
                        resendBtn.remove();
                        
                        //new password input field
                        const newPasswordDiv = document.createElement('div');
                        newPasswordDiv.innerHTML = "Enter your new password :";
                        const newPasswordInput = document.createElement('input');
                        newPasswordInput.setAttribute('type', 'password');
                        newPasswordInput.setAttribute('name', 'newPassword');
                        newPasswordInput.setAttribute('id', 'newPassword');
                        newPasswordInput.setAttribute('pattern', '(?=.*\\d)(?=.*[A-Z]).{8,}');  //escape the backslash
                        newPasswordInput.setAttribute('minlength', '8');
                        newPasswordInput.setAttribute('required', '');
                        newPasswordInput.setAttribute('title', 'Password length must be atleast 8 characters. Must include an uppercase letter and a number');
                        newPasswordDiv.appendChild(newPasswordInput);
                        form.insertBefore(newPasswordDiv, form.firstChild);

                        //toggle password visibility
                        let togglePasswordbtn = document.createElement('button');
                        togglePasswordbtn.innerHTML = "Show Password";
                        togglePasswordbtn.addEventListener('click', togglePasswordVisibility);
                        newPasswordDiv.appendChild(togglePasswordbtn);

                        const confirmPasswordDiv = document.createElement('div');
                        confirmPasswordDiv.innerHTML = "Confirm your new password :";
                        const confirmPasswordInput = document.createElement('input');
                        confirmPasswordInput.setAttribute('type', 'password');
                        confirmPasswordInput.setAttribute('name', 'confirmPassword');
                        confirmPasswordInput.setAttribute('id', 'confirmPassword');
                        confirmPasswordInput.setAttribute('required', '');
                        confirmPasswordDiv.appendChild(confirmPasswordInput);

                        //toggle password visibility
                        togglePasswordbtn = document.createElement('button');
                        togglePasswordbtn.innerHTML = "Show Password";
                        togglePasswordbtn.addEventListener('click', togglePasswordVisibility);
                        confirmPasswordDiv.appendChild(togglePasswordbtn);

                        newPasswordDiv.after(confirmPasswordDiv);

                        const btn = document.getElementById('verifyBtn');
                        btn.innerHTML = "Reset Password";
                        btn.setAttribute('id', 'resetBtn');
                        btn.setAttribute('onclick', validatePasswordForm);  //validate the form

                        errMsgBox.innerHTML = "";
                        successMsgBox.innerHTML = data.successMsg;

                        //change the form's submit event listener
                        form.removeEventListener('submit', checkCode);
                        form.addEventListener('submit', resetPassword = (e)=>{  //now for the password reset
                            e.preventDefault(); //prevent page reload
                            const formData = new FormData(form);
                            const data = Object.fromEntries(formData);

                            fetch('../../controller/general/password_reset_controller.php', { //reset the password
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(data)
                            })
                            .then(res => res.json())
                            .then(data => {
                                if(data.errMsg === undefined){  //if no error (password is reset)
                                    errMsgBox.innerHTML = "";
                                    successMsgBox.innerHTML = data.successMsg + "<br>Redirecting to the login page...";
                                    setTimeout(() => {
                                        window.location.href = "../../public/general/login.php";
                                    }, 2000);
                                }
                                else{   //password reset failed
                                    errMsgBox.innerHTML = data.errMsg;
                                    successMsgBox.innerHTML = "";
                                }
                            })
                            .catch(err => {
                                //console.log(err);
                            });
                        });
                    }
                    else{   //code is incorrect
                        errMsgBox.innerHTML = data.errMsg;
                        successMsgBox.innerHTML = "";
                    }
                })
                .catch(err => {
                    //console.log(err);
                });
                    
            });
        }else{
            //if email or username is incorrect, show error
            errMsgBox.innerHTML = data.errMsg;
            successMsgBox.innerHTML = "";

            //re enable the button
            checkBtn.disabled = false;
            checkBtn.innerHTML = "Check";
            checkBtn.classList.remove('disabled');
        }
    })
});