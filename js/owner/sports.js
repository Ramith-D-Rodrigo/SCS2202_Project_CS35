let sports = [];    // Array to hold sports

import {currency} from "../CONSTANTS.js";

fetch("../../controller/owner/sport_details_controller.php")
    .then(response => response.json())
    .then(data => {
        console.log(data);

        sports = data;
    })
    .then(() => {
        //first add the sports to the filtering
        const sportFilter = document.getElementById("sportsFilter");

        sports.forEach(sport => {
            const option = document.createElement("option");
            option.value = sport.sportID;
            option.innerHTML = sport.sportName;
            sportFilter.appendChild(option);
        });

        //add an event listener to the filter
        sportFilter.addEventListener("change", displaySportInfo);

        //display the first sport
        displaySportInfo({target: {value: sports[0].sportID}});

    });


const displaySportInfo = (e) => {
    const sportID = e.target.value;

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

}