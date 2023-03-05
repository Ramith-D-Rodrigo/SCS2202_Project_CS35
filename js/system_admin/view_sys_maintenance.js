fetch("../../controller/system_admin/view_sys_maintenance_controller.php")
    .then(res => res.json())
    .then(data => {
        // console.log(data[0]['adminID']);
        if(data[0]['errMsg'] !== undefined){
            const errorDiv = document.getElementById("err-msg");
            errorDiv.className = "content-box";
            errorDiv.innerHTML = data[0]['errMsg'];
        }else{
            const mainResults = document.getElementById("maintenance");
            mainResults.className = "container";
            mainResults.style.width = "50%";
            mainResults.style.height = "30%";
            mainResults.style.justifyContent = "center";
            for(i=0;i<data.length;i++){
                const leftSide = document.createElement("div");
                leftSide.style.display = "flex";
                leftSide.style.marginRight = "180px";
                leftSide.innerHTML = "Starting Date: ".concat(data[i]['startingDate'],"<br>"
                ,"Starting Time: ",data[i]['startingTime']);
                $downTime = data[i]['expectedDowntime'].split(":");
                leftSide.innerHTML += "<br>".concat("Expected Downtime: ",$downTime[0]," hrs ",$downTime[1]," mins");
                const form = document.createElement("form");
                form.method = "post";
                form.action = "/controller/system_admin/remove_sys_maintenance_controller.php";
                const rightSide = document.createElement("div");
                rightSide.style.display = "flex";
                const btn = document.createElement("button");
                btn.innerHTML = "Finish";
                form.appendChild(btn);
                rightSide.appendChild(form);
                mainResults.appendChild(leftSide);
                mainResults.appendChild(rightSide);
            }
        } 
    });