const sportsContainer = document.getElementById("sportsContainer"); //displaying container


function changeBtnValue(e){
    const reseveBtn = e.target.parentNode.lastChild;    //get the button
    if(e.target.value === ""){  //selected "Choose One" option
        reseveBtn.value = "";
        return;
    }
    
    const sportsRow = e.target.parentNode.parentNode.parentNode;   //great grandparent is the sportsRow div (form (parent) -> form div (grandparent) -> sport row div (great grandparent))
    //console.log(sportsRow);
    
    reseveBtn.value = [e.target.value, sportsRow.id];    //branch id first, then the sport id
    //console.log(reseveBtn.value);
}


fetch("../../controller/general/our_sports_controller.php")
    .then((res) => res.json())
    .then((data) => {
        //console.log(data);
        
        for(i = 0; i < data.length; i++){   //traverse each sport
            const sportsRowDiv = document.createElement("div"); //row for each sport
            sportsRowDiv.className = "sports-row";
            sportsRowDiv.id = data[i].sport_id; //set sport id
            
            const sportsIconContainerDiv = document.createElement("div");   //img container
            sportsIconContainerDiv.className = "sport-icon-container";
    
            const sportImage = document.createElement("img");   //img
            sportImage.className = "sport-icon";
            sportImage.src = "/styles/icons/sports/" + data[i].sport_name.toLowerCase() + ".jpg";
            sportImage.onerror = "this.src='/styles/icons/no-results.png''";    //set img to load when the current sport img is not found

            sportsIconContainerDiv.appendChild(sportImage); //append img to the container
            sportsRowDiv.appendChild(sportsIconContainerDiv);   //append the container to the row

            const sportInfoDiv = document.createElement("div"); //container to store the form

            const sportInfoForm = document.createElement("form");   //form
            sportInfoForm.method = "get";
            sportInfoForm.action = "/public/general/reservation_schedule.php";
            sportInfoForm.innerHTML = "Sport : " + data[i].sport_name + "<br>" +
                                      "Reservation Price : Rs. "+ data[i].reserve_price + " per hour <br>" +
                                      "Available Branches : " ;

            const providingBranchSelection = document.createElement("select");  //providing branches selection
            providingBranchSelection.setAttribute("required", "");
            providingBranchSelection.className = "providing_branches";

            const emptyOption = document.createElement("option");   //empty option
            emptyOption.text = "Choose One";
            emptyOption.value = "";
            providingBranchSelection.appendChild(emptyOption);

            for(j = 0; j < data[i].providing_branches.length; j++){ //create option for providing branches
                const branchOption = document.createElement("option");
                branchOption.text = data[i].providing_branches[j].branch_name;
                branchOption.value = data[i].providing_branches[j].branch_id;
                providingBranchSelection.appendChild(branchOption);
            }

            sportInfoForm.appendChild(providingBranchSelection);    //append the select to the form

            const reserveBtn = document.createElement("button");
            reserveBtn.innerHTML = "Make a Reservation";
            reserveBtn.type = "submit";
            reserveBtn.name = "reserveBtn"; //we need to send this to the reservation schedule controller (get method)
            //value should be changed with user's selection (need event listener for selection)

            sportInfoForm.innerHTML = sportInfoForm.innerHTML + "<br>";

            sportInfoForm.appendChild(reserveBtn);  //append the reserve button
            sportInfoDiv.appendChild(sportInfoForm);    //append the form to the form container
            sportsRowDiv.appendChild(sportInfoDiv); //append the form container to the row

            //finally append the row
            sportsContainer.appendChild(sportsRowDiv);
        }

        //event listener for the select options
        const selectOption = document.querySelectorAll(".providing_branches");
        //console.log(selectOption);
        selectOption.forEach(element => element.addEventListener("change", changeBtnValue));
    })


