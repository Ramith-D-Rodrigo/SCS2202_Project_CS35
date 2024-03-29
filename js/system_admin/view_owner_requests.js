fetch("../../controller/system_admin/view_owner_requests_controller.php")
    .then((res) => res.json())
    .then((data) => {
        // console.log(data[0].city);
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
                const contentBox = document.createElement("div");
                contentBox.className = "container";
                const formData = document.createElement("form");
                formData.type = "GET";
                formData.action = "branch_request.php";
                const leftContainer = document.createElement("div");
                leftContainer.className = "left-field";
                // leftContainer.style.display = "flex";
                // leftContainer.style.marginRight = "180px";
                const rightContainer = document.createElement("div");
                rightContainer.className = "right-field";
                // rightContainer.style.display = "flex";
                leftContainer.innerHTML = "Branch: ".concat(data[i].city,"<br>","Requested On: ",data[i].ownerRequestDate);  
                const btn = document.createElement("button");
                btn.innerHTML = "View Request";
                btn.style.marginTop = "25px";
                if(data[i].requestStatus == 'p'){
                    btn.type = "submit";
                    btn.name = "branchID";
                    btn.value = data[i].branchID;
                    leftContainer.innerHTML = leftContainer.innerHTML+"<br>"+"Status: Pending";
                    
                }else if(data[i].requestStatus == 'd'){
                    leftContainer.innerHTML = leftContainer.innerHTML+"<br>"+"Status: Declined";
                    btn.disabled = true;
                    btn.style.opacity = "0.5";
                }else if(data[i].requestStatus == 'a'){
                    leftContainer.innerHTML = leftContainer.innerHTML+"<br>"+"Status: Accepted";
                    btn.disabled = true;
                    btn.style.opacity = "0.5";
                }
                contentBox.appendChild(leftContainer); 
                formData.appendChild(btn);
                rightContainer.appendChild(formData);
                contentBox.appendChild(rightContainer);
                requests.appendChild(contentBox);
            }
            


        }
    });