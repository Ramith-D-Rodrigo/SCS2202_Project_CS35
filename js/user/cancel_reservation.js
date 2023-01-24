const authFormDisplay = (e) => {
    e.preventDefault();
    //get the reservation id
    const form = e.currentTarget.parentElement;
    const formData = new FormData(form);
    const reservationID = formData.get("reservationID");

    //store the reservation id in the session storage
    sessionStorage.setItem("reservationID", reservationID);

    //show the authentication form
    const authenticationFormDiv = document.querySelector("#authFormDiv");
    authenticationFormDiv.style.display = "block";

    //scroll to the authentication form and animate it
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
    
    //blur the main content and darken it
    const main = document.querySelector("main");
    main.style.filter = "blur(5px)";
    //animate the blur effect
    main.style.transition = "filter 0.5s ease-in-out";

    //disable main 
    main.style.pointerEvents = "none";

    const authCancel = document.querySelector("#authCancel");
    authCancel.addEventListener("click", (e) => {   //cancel the authentication form
        e.preventDefault();
        authenticationFormDiv.style.display = "none";
        main.style.filter = "blur(0px)";
        main.style.pointerEvents = "auto";

        //remove the reservation id from the session storage
        sessionStorage.removeItem("reservationID");

        authenticationFormDiv.childNodes[1].reset();    //reset the form
    });

}

const validateAuthForm = (e) => {
    //get auth form
    const authForm = document.querySelector("#authFormDiv form");
    if(authForm.reportValidity() === false){
        return false;
    }
    return true;
}


const init = () => {
    //get all the cancel buttons
    const cancelButtons = document.querySelectorAll(".cancel-button");
    const cancelForms = document.querySelectorAll(".cancel-form");


    console.log(cancelButtons);

    //add event listener to each cancel button
    for(let i = 0; i < cancelButtons.length; i++){
        cancelButtons[i].addEventListener("click", authFormDisplay); 
    }

    //authentication form submit event listener
    const authForm = document.querySelector("#authFormDiv form");
    authForm.addEventListener("submit", (e) => {
        if(validateAuthForm(e) === false){
            e.preventDefault();
            return;
        }
        e.preventDefault();
        //get the reservation id from the session storage
        //add the reservation id to the form data
        const formData = new FormData(authForm);

        //send the form data to the server
        fetch("../../controller/user/authentication_controller.php", {  //authentication first
            method: "POST",
            body: JSON.stringify(Object.fromEntries(formData)),
            Headers: {
                "Content-Type" : "application/json"
            }

        }).then((res) => {
            if(res.ok){ //ok means the status code is 200
                return res.json();
            }
            else{   //if the status code is not 200
                throw new Error("Server error");
            }
        })
        .then((data) => {
            console.log(data);
        })
        .catch((err) => {
            console.log(err);
        });
    });

}

//export the init function and the validateAuthForm function
export {init, validateAuthForm};



