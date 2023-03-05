//check the user is logged in or not
const logInCheck = () => {
    if(document.getElementById("logout") === null){
        errMsg.innerHTML = "Please Log in to Make a Request";
        return false;
    }
    return true;
}

const requestForm = document.getElementById("requestForm");

requestForm.addEventListener("submit", (e) => {
    let msgBox = null;

    e.preventDefault();
    if(!logInCheck()){  //not logged in
        return;
    }
    const formData = new FormData(requestForm);

    if(formData.get("userMessage").length > 450){
        errMsg.innerHTML = "Message is too long";
        return;
    }

    errMsg.innerHTML = "";
    successMsg.innerHTML = "Sending Request...";

    fetch("../../controller/user/request_coaching_session_controller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(res => {  //check the response status
        errMsg.innerHTML = "";
        successMsg.innerHTML = "";
        //select the message box
        if(res.ok){ 
            msgBox = successMsg;
        }
        else{
            msgBox = errMsg;
        }
        return res.json();
    })
    .then(data => {
        
        msgBox.innerHTML = data.msg;
    })
});
