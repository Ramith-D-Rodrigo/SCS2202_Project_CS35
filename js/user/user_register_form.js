const regForm = document.querySelector("form");

regForm.addEventListener("submit", (e) => {
    e.preventDefault(); //prevent default submit

    const formData = new FormData(regForm);

    //adding just formData is enough since the browser will automatically set the header as multipart/form-data (this is useful for file uplaoding)

    fetch("../../controller/user/register_controller.php", {
        method: "POST",
        body : formData
    })
    .then((res) => res.json())
    .then((data) => {
        if(data.RegUnsuccessMsg !== undefined){ //registration failed
            const errMsgBox = document.getElementById("errmsg");
            errMsgBox.innerHTML = data.RegUnsuccessMsg;
        }
        else if(data.RegSuccessMsg !== undefined){  //registration success
            const successMsgBox = document.getElementById("successmsg");
            successMsgBox.innerHTML = data.RegSuccessMsg;
            successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>You will be Redirected to the home page in 2 seconds";
            setTimeout(() =>{
                window.location.href = "/index.php";
            }
            , 2000);
        }
    })
    .catch((err) => {
        console.log(err);
    });
});