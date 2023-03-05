const staffRole = document.getElementById("staffRole");
const selectedBranch = document.getElementById("branchName");
const username = document.getElementById("username");
const cEmail = document.getElementById("currEmail");
const confirmBtn = document.getElementById("confirmBtn");
const errorDiv = document.getElementById("err-msg");
const staff = document.getElementById("staff");

staffRole.addEventListener("change", (e) => {
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
                    // const searchError = document.createElement("div");
                    // searchError.className = "no-result";
                    // searchError.id = "no-result";
                    // searchError.innerHTML = data[0]['errMsg'];
                    // errorDiv.appendChild(searchError);
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

selectedBranch.addEventListener("change", (e) => {
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
                    // const searchError = document.createElement("div");
                    // searchError.className = "no-result";
                    // searchError.id = "no-result";
                    // searchError.innerHTML = data[0]['errMsg'];
                    // errorDiv.appendChild(searchError);
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


    