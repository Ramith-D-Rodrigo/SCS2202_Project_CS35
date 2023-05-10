const staffRole = document.getElementById("staffRole");
const selectedBranch = document.getElementById("branchName");
const username = document.getElementById("username");
const cEmail = document.getElementById("currEmail");
const confirmBtn = document.getElementById("confirmBtn");
const errorDiv = document.getElementById("err-msg");
const staff = document.getElementById("staff");

staffRole.addEventListener("change", (e) => {
    if(e.target.value === "owner"){
        selectedBranch.disabled = true;   //if the staff role is owner, disable the branch selection
    }else{
        selectedBranch.disabled = false;
    }
    if(selectedBranch.value !== "" && staffRole.value !== ""){
        fetch("../../controller/system_admin/view_login_detail_controller.php?branchName=".concat(selectedBranch.value, "&role=", e.target.value))
        .then((res) => res.json())
        .then((data) => {
            // console.log(data[0][0]);
            if(data[0]['errMsg'] !== undefined){  
                errorDiv.innerHTML = data[0]['errMsg'];
                username.value = "";
                cEmail.value = "";
                staff.value = "";
            }else{  
                errorDiv.innerHTML = ""; 
                username.value = data[0][1];
                cEmail.value = data[0][2];
                confirmBtn.value = data[0][0];
                staff.value = "Staff";
            }
        });
    }else if(staffRole.value === "owner"){
        fetch("../../controller/system_admin/view_login_detail_controller.php?branchName=".concat("Empty", "&role=", e.target.value))
        .then((res) => res.json())
        .then((data) => {
            // console.log(data[0][0]);
            if(data[0]['errMsg'] !== undefined){  
                errorDiv.innerHTML = data[0]['errMsg'];
                username.value = "";
                cEmail.value = "";
            }else{  
                errorDiv.innerHTML = ""; 
                username.value = data[0][1];
                cEmail.value = data[0][2];
                confirmBtn.value = data[0][0];
            }
        });
    }else{
        errorDiv.innerHTML = ""; 
        username.value = "";
        cEmail.value = "";
        staff.value = "";
    }
});

selectedBranch.addEventListener("change", (e) => {
    if(e.target.value === ""){
        staffRole.options[3].style.display = "block";
    }else{
        staffRole.options[3].style.display = "none";    //if there's a branch selected, hide the owner option
    }
    if(selectedBranch.value !== "" && staffRole.value !== ""){
        fetch("../../controller/system_admin/view_login_detail_controller.php?branchName=".concat(e.target.value, "&role=", staffRole.value)) 
            .then((res) => res.json())
            .then((data) => {
                // console.log(data[0][0]);
                if(data[0]['errMsg'] !== undefined){
                    errorDiv.innerHTML = data[0]['errMsg'];
                    username.value = "";
                    cEmail.value = "";
                    staff.value = "";
                }else{ 
                    errorDiv.innerHTML = "";   
                    username.value = data[0][1];
                    cEmail.value = data[0][2];
                    confirmBtn.value = data[0][0];
                    staff.value = "Staff";
                }
            });
    }else{
        errorDiv.innerHTML = ""; 
        username.value = "";
        cEmail.value = "";
        staff.value = "";
    }
});


    