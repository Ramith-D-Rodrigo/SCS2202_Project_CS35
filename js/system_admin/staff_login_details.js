const staffRole = document.getElementById("staffRole");
staffRole.addEventListener("change", (e) => {
    const username = document.getElementById("username");
    const cEmail = document.getElementById("currEmail");
    if(staffRole.value !== ""){
        fetch("../../controller/system_admin/view_branch_details_controller.php?role=".concat(e.target.value))
            .then((res) => res.json())
            .then((data) => {
                // console.log(data[0]);
                if(data[0]['errMsg'] !== undefined){
                    const errorDiv = document.getElementById("err-msg");
                    const searchError = document.createElement("div");
                    searchError.className = "no-result";
                    searchError.id = "no-result";
                    searchError.innerHTML = data[0]['errMsg'];
                    errorDiv.appendChild(searchError);
                }else{
                    const filteredBranch = document.getElementById("branch");
                    filteredBranch.innerHTML = ""; //empty the existing select elements
                    const option = document.createElement("option");
                    option.value = "";
                    option.innerHTML = "Choose Branch";
                    filteredBranch.appendChild(option);
                    for(i=0; i<data.length; i++){
                        const branchOption = document.createElement("option");
                        branchOption.value = data[i][1];
                        branchOption.innerHTML = data[i][0];
                        filteredBranch.appendChild(branchOption);
                    }
                    username.value = "";
                    cEmail.value = "";
                }
            });
    }else{
        const filteredBranch = document.getElementById("branch");
        filteredBranch.innerHTML = ""; //empty the existing select elements
        const option = document.createElement("option");
        option.value = "";
        option.innerHTML = "Choose Branch";
        filteredBranch.appendChild(option);
        username.value = "";
        cEmail.value = "";
    }
});

const selectedBranch = document.getElementById("branch");
selectedBranch.addEventListener("change", (e) => {
    const username = document.getElementById("username");
    const cEmail = document.getElementById("currEmail");
    if(selectedBranch.value !== "" && staffRole.value !== ""){
        fetch("../../controller/system_admin/view_login_detail_controller.php?branchID=".concat(e.target.value, "&role=", staffRole.value))
            
            .then((res) => res.json())
            .then((data) => {
                // console.log(data[0][0]);
                if(data[0]['errMsg'] !== undefined){
                    const errorDiv = document.getElementById("err-msg");
                    const searchError = document.createElement("div");
                    searchError.className = "no-result";
                    searchError.id = "no-result";
                    searchError.innerHTML = data[0]['errMsg'];
                    errorDiv.appendChild(searchError);
                }else{   
                    username.value = data[0][1];
                    cEmail.value = data[0][2];
                }
            });
    }else{
        username.value = "";
        cEmail.value = "";
    }
});


    