const loginForm = document.querySelector("form");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault(); //prevent the form from submitting
    const formData = new FormData(loginForm);
    const username = formData.get("username");
    const password = formData.get("password");
    const user = { username, password };

    fetch("../../controller/general/login_controller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(user),
    }).then((res) => res.json())
    .then((data) => {
        if(data.successMsg !== undefined){  //login success
            const successMsgBox = document.getElementById("successmsgbox");
            successMsgBox.innerHTML = data.successMsg;

            //disabling buttons

            const loginBtn = document.getElementById("loginBtn");   //disabling login button
            loginBtn.disabled = true;
            loginBtn.style.cursor = "not-allowed";

            const regBtn = document.getElementById("regBtn"); //disabling register button
            regBtn.disabled = true;
            regBtn.style.cursor = "not-allowed";

            if(data.userrole === 'user'){
                successMsgBox.innerHTML = successMsgBox.innerHTML + ".<br>You will be Redirected to the home page in 2 seconds";
                setTimeout(() =>{
                    window.location.href = "/index.php";
                }, 2000);
            }
            else if(data.userrole === 'coach'){
                setTimeout(() =>{
                    window.location.href = "/public/coach/coach_dashboard.php";
                }, 2000);
            }
        }else{  //login failed
            const errMsgBox = document.getElementById("errmsgbox");
            errMsgBox.innerHTML = data.errMsg;
        }
    }).catch((err) => {
        console.log(err);
    });
});