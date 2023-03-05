const timeForm = document.querySelector("form");

timeForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(timeForm);

    fetch("/controller/manager/change_time_controller.php", {
        method: "POST",
        body : formData
    })
    .then(res => res.json())
    .then(data =>{
        if(data.successMsg !== undefined){
           const successDiv = document.querySelector(".success-msg");
           successDiv.innerHTML = data.successMsg;
        }
        else{
            const errorDiv = document.querySelector(".err-msg");
            errorDiv.innerHTML = data.errMsg;
        }
    })
})