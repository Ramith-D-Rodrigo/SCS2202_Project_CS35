const deactivateBtn = document.getElementById('submitBtn3');
const deactivateForm = document.getElementById('deactivateForm');
const deactivateErrMsgBox = document.getElementById('errMsg3');
const deactivateSuccessMsgBox = document.getElementById('successMsg3');

function validateDeactivateForm(event){
    deactivateErrMsgBox.innerHTML = "";
    deactivateSuccessMsgBox.innerHTML = "";
    if(deactivateForm.reportValidity() === false){
        return false;
    }
    else{
        const formData = new FormData(deactivateForm);
        if(formData.get("password") !== formData.get("confirmPassword")){
            deactivateErrMsgBox.innerHTML = "Passwords do not match";
            return false;
        }
        else{
            return true;
        }
    }
}

deactivateForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(deactivateForm);
    const sendingReq = Object.fromEntries(formData);
    
    //send the data to the server
    fetch("../../controller/user/deactivate_account_controller.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/json"
            },
        body: JSON.stringify(sendingReq)
    })
});