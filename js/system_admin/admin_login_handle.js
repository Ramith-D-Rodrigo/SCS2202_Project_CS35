const togglePasswordbtn = document.getElementById("togglePassword");

togglePasswordbtn.addEventListener('click',(e)=>{
    e.preventDefault();
    const parentDiv = togglePasswordbtn.parentElement;
    const passwordField = parentDiv.children[0];

    if(passwordField.type === 'password'){  //Show password
        passwordField.type = 'text';
        togglePasswordbtn.innerHTML = "Hide Password";
    }
    else{   //Hide Password
        passwordField.type = 'password';
        togglePasswordbtn.innerHTML = "Show Password";
    }
});