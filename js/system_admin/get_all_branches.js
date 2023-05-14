fetch("../../controller/system_admin/view_branch_list_controller.php")
    .then((res)=>res.json())
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
            const branch = document.getElementById("branchName");
            for(let i=0;i<data.length;i++){
                const option = document.createElement("option");
                option.value = data[i];
                option.innerHTML = data[i];
                branch.appendChild(option);
            }
        }
        
    });