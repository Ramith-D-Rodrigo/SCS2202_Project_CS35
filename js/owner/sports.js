import {currency} from "../CONSTANTS.js";

let sports = [];    //array to store the sports

const init = async () => {
    await fetch("../../controller/owner/sport_details_controller.php")
        .then(response => response.json())
        .then(data => {

            //clear the sports array
            for(let i = 0; i < sports.length; i++){
                sports.pop();
            }
            sports.pop();
           
            for(const sport of data){   //add the sports to the array
                sports.push(sport);
            }
        })
        .then(() => {
            //first add the sports to the filtering
            const sportFilter = document.getElementById("sportsFilter");

            //clear the filter
            sportFilter.innerHTML = "";

            sports.forEach(sport => {
                const option = document.createElement("option");
                option.value = sport.sportID;
                option.innerHTML = sport.sportName;
                sportFilter.appendChild(option);
            });

            //add an event listener to the filter
            sportFilter.addEventListener("change", displaySportInfo);
        });
}


const displaySportInfo = (e) => {
    const sportID = e.target.value;

    //set the hidden input
    const sportIDInput = document.getElementById("sportID");
    sportIDInput.value = sportID;

    const sport = sports.find(sport => sport.sportID == sportID);   //find the sport from the array

    //set the description
    const description = document.getElementById("description");
    description.value = sport.description;

    //set the max players
    const maxPlayers = document.getElementById("maxPlayers");
    maxPlayers.value = sport.MaxNoOfStudents;

    //set the current reservation price
    const currentReservationPrice = document.getElementById("reservationPrice");
    currentReservationPrice.value = currency + " " + parseFloat(sport.reservationPrice).toFixed(2);

    //set the sport image
    const sportImage = document.getElementById("sport-icon");
    sportImage.src = "/uploads/sport_images/" + sport.sportName + ".jpg";

    //reset the change form
    const changeForm = document.getElementById("changeForm");
    changeForm.reset();
}

export {displaySportInfo, init, sports};