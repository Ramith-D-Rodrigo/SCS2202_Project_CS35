import {currency} from "../CONSTANTS.js";

const sportsContainer = document.getElementById("sportsContainer"); //displaying container


fetch("../../controller/general/our_sports_controller.php")
    .then((res) => res.json())
    .then((data) => {
        //console.log(data);
        
        for(let i = 0; i < data.length; i++){   //traverse each sport
            const currSportContainer = document.createElement("div"); //displaying container
            currSportContainer.className = "content-box";
            currSportContainer.id = data[i].sport_id; //set sport id
            
            const sportsIconContainerDiv = document.createElement("div");   //img container
            sportsIconContainerDiv.className = "sport-icon-container";
    
            const sportImage = document.createElement("img");   //img
            sportImage.className = "sport-icon";
            sportImage.src = "/uploads/sport_images/" + data[i].sport_name.toLowerCase() + ".jpg";
            sportImage.onerror = "this.src='/styles/icons/no-results.png''";    //set img to load when the current sport img is not found

            sportsIconContainerDiv.appendChild(sportImage); //append img to the container
            currSportContainer.appendChild(sportsIconContainerDiv);   //append the container to the row

            const sportInfoDiv = document.createElement("div"); //container to store the form

            const sportInfoForm = document.createElement("form");   //form
            sportInfoForm.method = "get";
            sportInfoForm.action = "/public/general/reservation_schedule.php";

           //sport name
            const nameDiv = document.createElement("div");
            nameDiv.className = "row-container";

            const sportField = document.createElement("div");
            sportField.className = "left-field";
            sportField.innerHTML = "Sport";

            const sportNameField = document.createElement("div");
            sportNameField.className = "right-field";
            sportNameField.innerHTML = data[i].sport_name;

            nameDiv.appendChild(sportField);
            nameDiv.appendChild(sportNameField);
            sportInfoForm.appendChild(nameDiv);

            //reservation price
            const priceDiv = document.createElement("div");
            priceDiv.className = "row-container";

            const priceField = document.createElement("div");
            priceField.className = "left-field";
            priceField.innerHTML = "Reservation Price";

            const priceValueField = document.createElement("div");
            priceValueField.className = "right-field";
            priceValueField.innerHTML = currency + " " + parseFloat(data[i].reserve_price).toFixed(2) + " per hour";

            priceDiv.appendChild(priceField);
            priceDiv.appendChild(priceValueField);
            sportInfoForm.appendChild(priceDiv);

            //available branches
            const branchDiv = document.createElement("div");
            branchDiv.className = "row-container";

            const branchField = document.createElement("div");
            branchField.className = "left-field";
            branchField.innerHTML = "Available Branches";
            
            const branchValueField = document.createElement("div");
            branchValueField.className = "right-field";

            const providingBranchSelection = document.createElement("select");  //providing branches selection
            providingBranchSelection.name = "branch";
            providingBranchSelection.setAttribute("required", "");
            providingBranchSelection.className = "providing_branches";

            const emptyOption = document.createElement("option");   //empty option
            emptyOption.text = "Choose One";
            emptyOption.value = "";
            providingBranchSelection.appendChild(emptyOption);

            for(let j = 0; j < data[i].providing_branches.length; j++){ //create option for providing branches
                const branchOption = document.createElement("option");
                branchOption.text = data[i].providing_branches[j].branch_name;
                branchOption.value = data[i].providing_branches[j].branch_id;
                providingBranchSelection.appendChild(branchOption);
            }

            branchValueField.appendChild(providingBranchSelection);
            branchDiv.appendChild(branchField);
            branchDiv.appendChild(branchValueField);

            sportInfoForm.appendChild(branchDiv);//append the branches to the form

            const btnContainer = document.createElement("div"); //container for the reserve button
            btnContainer.className = "btn-container";

            //hidden input for the sport id
            const sportIdInput = document.createElement("input");
            sportIdInput.type = "hidden";
            sportIdInput.name = "sport";
            sportIdInput.value = data[i].sport_id;

            sportInfoForm.appendChild(sportIdInput); //append the hidden input to the form

            const reserveBtn = document.createElement("button");
            reserveBtn.innerHTML = "Make a Reservation";
            reserveBtn.type = "submit";
            btnContainer.appendChild(reserveBtn);  //append the reserve button

            sportInfoForm.appendChild(btnContainer);  //append the reserve button
            sportInfoDiv.appendChild(sportInfoForm);    //append the form to the form container
            currSportContainer.appendChild(sportInfoDiv); //append the form container to the content box
            sportsContainer.appendChild(currSportContainer);
        }
    });


