const changeForm = document.querySelector("#changeForm");
const msg = document.querySelector("#msg");

import { disableElementsInMain, togglePassword, enableElementsInMain } from "../FUNCTIONS.js";
import {displaySportInfo, init, sports } from "./sports.js";


const togglePasswordBtn = document.getElementById("togglePasswordBtn");
const passwordInput = document.getElementById("password");

const authFormDiv = document.getElementById("authFormDiv");

const main = document.querySelector("main");

let formData = null;

await init();
//display the first sport
displaySportInfo({target: {value: sports[0].sportID}});

togglePasswordBtn.addEventListener("click", (e) => {
    e.preventDefault();
    togglePassword(togglePasswordBtn, passwordInput);
});

changeForm.addEventListener("submit", (e) => {
    e.preventDefault();
    msg.innerHTML = "";

    if(!changeForm.reportValidity()){
        return;
    }

    formData = new FormData(changeForm);

    //check if the new price is valid
    const newPrice = formData.get("newPrice");

    const MaxNoOfStudents = formData.get("newMaxPlayers");

    const newDescription = formData.get("newDescription");
    
    if((newPrice) == "" && (MaxNoOfStudents) == "" && (newDescription) == ""){
        msg.innerHTML = "You haven't entered anything";
        msg.style.color = "red";
        return;
    }

    if(newPrice <= 0 && newPrice != ""){
        msg.innerHTML = "Invalid Price";
        msg.style.color = "red";
        return;
    }

    if(newPrice % 10 != 0){
        msg.innerHTML = "Price must be a multiple of 10";
        msg.style.color = "red";
        return;
    }

    if(MaxNoOfStudents <= 0 && MaxNoOfStudents != ""){
        msg.innerHTML = "Invalid Max Players";
        msg.style.color = "red";
        return;
    }

    if(newDescription.length > 100){
        msg.innerHTML = "Description is too long";
        msg.style.color = "red";
        return;
    }

    //check if the new price is different from the old price
    const currentPrice = sports.find(sport => sport.sportID == formData.get("sportID")).reservationPrice;

    if(newPrice == currentPrice){
        msg.innerHTML = "Same Reservation Price as Before";
        msg.style.color = "red";
        return;
    }

    //check if the new max players is different from the old max players
    const currentMaxPlayers = sports.find(sport => sport.sportID == formData.get("sportID")).MaxNoOfStudents;

    if(MaxNoOfStudents == currentMaxPlayers){
        msg.innerHTML = "Same Max Players as Before";
        msg.style.color = "red";
        return;
    }

    //check if the new description is different from the old description
    const currentDescription = sports.find(sport => sport.sportID == formData.get("sportID")).description;

    if(newDescription == currentDescription){
        msg.innerHTML = "Same Description as Before";
        msg.style.color = "red";
        return;
    }

    //remove the empty fields from the formData
    if(newPrice == ""){
        formData.delete("newPrice");
    }

    if(MaxNoOfStudents == ""){
        formData.delete("newMaxPlayers");
    }

    if(newDescription == ""){
        formData.delete("newDescription");
    }


    //first authenticate the user
    authFormDiv.style.display = "block";

    main.style.opacity = "0.5";

    disableElementsInMain(main);

    main.addEventListener("click", function mainClick(e){
        //reset authFormDiv
        authForm.reset();

        e.preventDefault();
        authFormDiv.querySelector("#authMsg").innerHTML = "";
        authFormDiv.style.display = "none";
        main.style.opacity = "1";
        enableElementsInMain(main);
        main.removeEventListener("click", mainClick);
    });
});

//authentication form
const authForm = authFormDiv.querySelector("form");
authForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const authFormData = new FormData(authForm);

    if(!authForm.reportValidity()){
        return;
    }
    let authStatus = null;

    //disable the submit button
    const submitBtn = authForm.querySelector("button[type='submit']");
    submitBtn.disabled = true;
    submitBtn.classList.add("disabled");

    //send the request
    fetch("../../controller/general/authentication_controller.php", {
        method: "POST",
        header: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(Object.fromEntries(authFormData))
    })
    .then(res => {
        authStatus = res.ok;
        return res.json();
    })
    .then(data => {
        if(!authStatus){
            const authMsg = authForm.querySelector("#authMsg");
            authMsg.innerHTML = data.errMsg;

            //enable the submit button
            submitBtn.disabled = false;
            submitBtn.classList.remove("disabled");
        }
        else{
            //close the authFormDiv by clicking on the main
            main.click();

            //send the request to change the reservation price
            let status = null;
            //send the request
            fetch("../../controller/owner/change_sport_info_controller.php", {
                method: "POST",
                header: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(res => {
                status = res.status;
                return res.json();
            })
            .then(data => {
                if(status == 200){
                    msg.innerHTML = data.msg;
                    msg.style.color = "green";

                    
                    init().then(() => {
                        console.log(formData.get("sportID"));
                        //change the filter value to the current sport
                        document.getElementById("sportsFilter").value = formData.get("sportID");

                        //display the current sport
                        displaySportInfo({target: {value: formData.get("sportID")}});
                    });
                    
                }else{
                    msg.innerHTML = data.msg;
                    msg.style.color = "red";
                }

                //enable the submit button
                submitBtn.disabled = false;
                submitBtn.classList.remove("disabled");
            })
        }
    });
});