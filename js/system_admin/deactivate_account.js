const warningMsg = document.getElementById("warning-msg");
const errMsg = document.getElementById("err-msg");
const successMsg = document.getElementById("success-msg");
const overlay = document.getElementById("overlay");
const deactivateBtn = document.getElementById("deactivateBtn");

deactivateBtn.addEventListener("click", promptMsg);

function promptMsg(event){
    event.preventDefault();
    if(document.getElementById("branchName").value === '' ||
    document.getElementById("staffRole").value === ''){
        errMsg.innerHTML = "Not Selected Any Particular Role";
    }else{
        const prompt = document.createElement("p");
        prompt.innerHTML = "Are you sure with the decision?";           
        const yesBtn = document.getElementById("Yes");
        const noBtn = document.getElementById("No");
        yesBtn.value = this.value;
        yesBtn.addEventListener("click", deactivateAccount);
        noBtn.addEventListener("click", function(){location.reload();}); 
        warningMsg.appendChild(prompt);
        overlay.className = "overlay";
        warningMsg.className = "dialog-box";
        warningMsg.style.display = "block";
        overlay.style.display = "block";
    }
    
        
}

function deactivateAccount(){
    warningMsg.style.display = "none";
    overlay.style.display = "none";

    const profile = {
        ProfileID: document.getElementById("deactivateBtn").value,
        StaffRole: document.getElementById("staffRole").value,
        BranchName: document.getElementById("branchName").value
    }
    fetch("../../controller/system_admin/deactivate_account_controller.php",{
        method: "POST",
        header: {
            "Content-type": "application/json"
        },
        body: JSON.stringify(profile)
    })
    .then((res)=>res.json())
    .then((data)=>{
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