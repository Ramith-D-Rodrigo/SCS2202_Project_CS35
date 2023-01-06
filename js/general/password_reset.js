function validateForm(event){
    const form = document.querySelector('form');    //email, username check form

    if(form.reportValidity() === false){
        return false;
    }
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
            checkBtn.innerHTML = "Verify Code";
            checkBtn.setAttribute('id', 'verifyBtn');
            checkBtn.setAttribute('onclick', '');   //remove onclick event

            //change the form's submit event listener
            form.removeEventListener('submit', checkuserInput);

            form.addEventListener('submit', (e)=>{  //now for the code check
                e.preventDefault(); //prevent page reload

                const codeCheckFormData = new FormData(form);
                const codeCheckData = Object.fromEntries(codeCheckFormData);

                fetch('../../controller/general/reset_code_check_controller.php', { //check the user input
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(codeCheckData)
                })
                .then(res => res.json())
                .then(data => {
                    if(data.errMsg === undefined){  //if no error (code is correct)
                        //remove the code input field
                        const codeInputDiv = document.getElementById('inputDiv');
                        codeInputDiv.remove();

                        //new password input field
                        const newPasswordDiv = document.createElement('div');
                        newPasswordDiv.innerHTML = "Enter your new password :";
                        const newPasswordInput = document.createElement('input');
                        newPasswordInput.setAttribute('type', 'password');
                        newPasswordInput.setAttribute('name', 'newPassword');
                        newPasswordInput.setAttribute('id', 'newPassword');
                        newPasswordInput.setAttribute('required', '');
                        newPasswordInput.setAttribute('pattern', '(?=.*\d)(?=.*[A-Z]).{8,}');
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


                        errMsgBox.innerHTML = "";
                        successMsgBox.innerHTML = data.successMsg;
                    }
                    else{
                        errMsgBox.innerHTML = data.errMsg;
                        successMsgBox.innerHTML = "";
                    }
                })
                .catch(err => {
                    console.log(err);
                });
                    
            });





        }else{
            //if email or username is incorrect, show error
            errMsgBox.innerHTML = data.errMsg;
            successMsgBox.innerHTML = "";
        }
    })
});