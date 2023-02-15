fetch("../../controller/system_admin/view_owner_requests_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data[0].city);
        if(data[0]['errMsg'] !== undefined){
            const errorDiv = document.getElementById("err-msg");
            errorDiv.className = "content-box";
            const searchError = document.createElement("div");
            searchError.className = "no-result";
            searchError.id = "no-result";
            searchError.innerHTML = data[0]['errMsg'];
            errorDiv.appendChild(searchError);
        }else{
            const requests = document.getElementById("requests");
            for(i=0;i<data.length;i++){
                const formData = document.createElement("form");
                formData.className = "container";
                formData.type = "GET";
                formData.action = "branch_request.php";
                const leftContainer = document.createElement("div");
                leftContainer.className = "left-side";
                const rightContainer = document.createElement("div");
                rightContainer.className = "right-side";
                leftContainer.innerHTML = "Branch: ".concat(data[0].city,"<br>","Requested On: ",data[0].ownerRequestDate);
                rightContainer.style.marginTop = "10px";
                const btn = document.createElement("button");
                btn.className = "viewBtn";
                btn.type = "submit";
                btn.name = "branchID";
                btn.innerHTML = "View Request";
                btn.value = data[0].branchID;
                btn.style.marginLeft = "50%";
                btn.style.marginTop = "20px";
                if(data[0].requestStatus == 'p'){
                    leftContainer.innerHTML = leftContainer.innerHTML+"<br>"+"Status: Pending";
                }else{
                    leftContainer.innerHTML = leftContainer.innerHTML+"<br>"+"Status: Accepted";
                    btn.disabled = true;
                }
                rightContainer.appendChild(btn);
                formData.appendChild(leftContainer);
                formData.appendChild(rightContainer);
                requests.appendChild(formData);

            }
            


        }
    });