const warningMsg = document.getElementById("warning-msg");
const errMsg = document.getElementById("err-msg");
const successMsg = document.getElementById("success-msg");
const overlay = document.getElementById("overlay");

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

function promptMsg(){

    const prompt = document.createElement("p");
    prompt.innerHTML = "Are you sure with the decision?";           
    const yesBtn = document.getElementById("Yes");
    const noBtn = document.getElementById("No");
    yesBtn.value = this.value;
    yesBtn.addEventListener("click", submitDecision);
    noBtn.addEventListener("click", function(){location.reload();}); 
    warningMsg.appendChild(prompt);
    overlay.className = "overlay";
    warningMsg.className = "dialog-box";
    warningMsg.style.display = "block";
    overlay.style.display = "block";
        
}

function submitDecision(){
    warningMsg.style.display = "none";
    overlay.style.display = "none";
    
    fetch("/controller/system_admin/remove_sys_maintenance_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(!data['Flag']){
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            successMsg.style.display = "block";
            successMsg.innerHTML = data['Message'];
            overlay.style.display = "block";
                
            setTimeout(function(){
                location.reload();
            },3000);
        }else{
            errMsg.innerHTML = data['Message'];
        }
    });
}