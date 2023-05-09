const errMsg = document.getElementById("errmsg");   //For Displaying the Error messages
const password = document.getElementById("password");
const cPassword = document.getElementById("cPassword");
const successMsg = document.getElementById("successmsg");
const overlay = document.getElementById("overlay");

function validateForm(event){
    event.preventDefault();   //prevent the form from submitting in default way
    

    const form = document.querySelector("form");

    if(verbose){
        console.log(form.reportValidity());
    }

    if(password.value != cPassword.value) {    //compare the password and the confirm password fields
        errMsg.innerHTML = errMsg.innerHTML + "Passwords are Mismatched";
        return false;
    }

    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = errMsg.innerHTML + "Please Add Valid Information";
        return false;
    }

    errMsg.innerHTML = '';
    registerStaff();
    
}

function registerStaff(){
    const female = document.getElementById("female");
    const male = document.getElementById("male");
    let gender;
    if(female.checked){
        gender = "f";
    }else if(male.checked){
        gender = "m";
    }
    const staffDetails = {
        StaffRole : document.getElementById("roles").value,
        Branch: document.getElementById("branchName").value,
        FirstName: document.getElementById("firstName").value,
        LastName: document.getElementById("lastName").value,
        Gender: gender,
        Birthday: document.getElementById("bday").value,
        Contact: document.getElementById("staffContact").value,
        Email: document.getElementById("emailAddress").value,
        Username: document.getElementById("username").value,
        Password: document.getElementById("password").value,
    };

    fetch("../../controller/system_admin/register_controller.php",{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(staffDetails)
    })
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        if(!data[Flag]){
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            successMsg.style.display = "block";

            successMsg.innerHTML = data['Message'];
            overlay.style.display = "block";

            setTimeout(function(){
                location.reload();
            },3000);
        }else{
            errMsg.style.color = "red";
            errMsg.style.textAlign = "center";
            errMsg.innerHTML = data['Message'];
        }
    });
}