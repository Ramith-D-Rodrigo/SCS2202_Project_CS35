const staffRole = document.getElementById("staffRole");
const selectedBranch = document.getElementById("branchName");
const username = document.getElementById("username");
const email = document.getElementById("email");
const firstName = document.getElementById("fName");
const lastName = document.getElementById("lName");
const contactN = document.getElementById("contactN");
const jDate = document.getElementById("jDate");
const dButton = document.getElementById("deactivateBtn");
const errorDiv = document.getElementById("err-msg");

staffRole.addEventListener("change", (e) => {      //for getting the branch names according to the role
    if(selectedBranch.value !== "" && staffRole.value !== ""){    //load profile details according to the correct branch and role
        fetch("../../controller/system_admin/view_account_controller.php?branchName=".concat(selectedBranch.value, "&role=", e.target.value))   
            .then((res) => res.json())
            .then((data) => {
                // console.log(data);
                if(data[0]['errMsg'] !== undefined){
                    errorDiv.innerHTML = data[0]['errMsg'];
                    username.value = '';
                    email.value = '';
                    firstName.value = '';
                    lastName.value = '';
                    contactN.value = '';
                    jDate.value = '';
                }else{   
                    errorDiv.innerHTML = "";
                    username.value = data[0][1];
                    email.value = data[0][2];
                    firstName.value = data[0][3];
                    lastName.value = data[0][4];
                    contactN.value = data[0][6];
                    jDate.value = data[0][5];
                    dButton.value = data[0][0];
                }
            });
    }else{
        errorDiv.innerHTML = ""; 
        username.value = "";
        email.value = "";
        firstName.value = "";
        lastName.value = "";
        contactN.value = "";
        jDate.value = "";
    }
});


selectedBranch.addEventListener("change", (e) => {
    if(selectedBranch.value !== "" && staffRole.value !== ""){    //load profile details according to the correct branch and role
        fetch("../../controller/system_admin/view_account_controller.php?branchName=".concat(e.target.value, "&role=", staffRole.value))
            .then((res) => res.json())
            .then((data) => {
                // console.log(data);
                if(data[0]['errMsg'] !== undefined){
                    errorDiv.innerHTML = data[0]['errMsg'];
                    username.value = '';
                    email.value = '';
                    firstName.value = '';
                    lastName.value = '';
                    contactN.value = '';
                    jDate.value = '';
                }else{  
                    errorDiv.innerHTML = "";  
                    username.value = data[0][1];
                    email.value = data[0][2];
                    firstName.value = data[0][3];
                    lastName.value = data[0][4];
                    contactN.value = data[0][6];
                    jDate.value = data[0][5];
                    dButton.value = data[0][0];
                }
            });
    }else{
        errorDiv.innerHTML = ""; 
        username.value = "";
        email.value = "";
        firstName.value = "";
        lastName.value = "";
        contactN.value = "";
        jDate.value = "";
    }
});
