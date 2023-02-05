const staffRole = document.getElementById("staffRole");
const username = document.getElementById("username");
const email = document.getElementById("email");
const firstName = document.getElementById("fName");
const lastName = document.getElementById("lName");
const contactN = document.getElementById("contactN");
const jDate = document.getElementById("jDate");
staffRole.addEventListener("change", (e) => {      //for getting the branch names according to the role
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
                    email.value = "";
                    firstName.value = "";
                    lastName.value = "";
                    contactN.value = "";
                    jDate.value = "";
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
        email.value = "";
        firstName.value = "";
        lastName.value = "";
        contactN.value = "";
        jDate.value = "";
    }
});

const selectedBranch = document.getElementById("branch");
selectedBranch.addEventListener("change", (e) => {
    if(selectedBranch.value !== "" && staffRole.value !== ""){    //load profile details according to the correct branch and role
        fetch("../../controller/system_admin/view_account_controller.php?branchID=".concat(e.target.value, "&role=", staffRole.value))
            
            .then((res) => res.json())
            .then((data) => {
                // console.log(data);
                if(data[0]['errMsg'] !== undefined){
                    const errorDiv = document.getElementById("err-msg");
                    const searchError = document.createElement("div");
                    searchError.className = "no-result";
                    searchError.id = "no-result";
                    searchError.innerHTML = data[0]['errMsg'];
                    errorDiv.appendChild(searchError);
                }else{   
                    username.value = data[0][0];
                    email.value = data[0][2];
                    firstName.value = data[0][3];
                    lastName.value = data[0][4];
                    contactN.value = data[0][6];
                    jDate.value = data[0][5];
                }
            });
    }else{
        username.value = "";
        email.value = "";
        firstName.value = "";
        lastName.value = "";
        contactN.value = "";
        jDate.value = "";
    }
});
