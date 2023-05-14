
let branchPhotos = [];
let branchPhotosIndex = 0;

let courtPhotos = [];
let courtPhotosIndex = 0;

import { MAX_RESERVATION_DAYS, MAX_RESERVATION_TIME_HOURS, MIN_RESERVATION_DAYS, MIN_RESERVATION_TIME_HOURS } from "../CONSTANTS.js";


fetch("../../controller/general/about_us_controller.php")
.then(response => response.json())
.then(data => {
    //console.log(data);

    branchPhotos = data.branchPhotos;
    courtPhotos = data.courtPhotos;

    //add branch photos
    const branchPhotosContainer = document.querySelector("#branch-img-container");
    branchPhotosContainer.innerHTML = "";

    const branchImg = document.createElement("img");
    branchImg.src = branchPhotos[branchPhotosIndex];
    branchImg.alt = "Branch Photo";
    branchPhotosContainer.appendChild(branchImg);

    //add court photos
    const courtPhotosContainer = document.querySelector("#court-img-container");
    courtPhotosContainer.innerHTML = "";

    const courtImg = document.createElement("img");
    courtImg.src = courtPhotos[courtPhotosIndex];
    courtImg.alt = "Court Photo";
    courtPhotosContainer.appendChild(courtImg);

    //guidelines
    const guidelines = document.querySelector("#guidelines");

    const unorderedList = document.createElement("ul");

    const listItems = [
        "You can make a reservation for a maximum of " + MAX_RESERVATION_TIME_HOURS + " hours.",
        "You can make a reservation for a minimum of " + MIN_RESERVATION_TIME_HOURS + " hours.",
        "You have to make the reservation at least " + MIN_RESERVATION_DAYS + " days before the reservation date.",
        "You cannot make a reservation for a date that is more than " + MAX_RESERVATION_DAYS + " days from today."
    ];

    for(let i = 0; i < listItems.length; i++){
        const listItem = document.createElement("li");
        listItem.textContent = listItems[i];
        unorderedList.appendChild(listItem);
    }

    guidelines.appendChild(unorderedList);


    //time interval for branch photos
    setInterval(() => {
        branchPhotosIndex++;
        if(branchPhotosIndex >= branchPhotos.length) branchPhotosIndex = 0;
        branchImg.src = branchPhotos[branchPhotosIndex];
    }, 2000);

    //time interval for court photos
    setInterval(() => {
        courtPhotosIndex++;
        if(courtPhotosIndex >= courtPhotos.length) courtPhotosIndex = 0;
        courtImg.src = courtPhotos[courtPhotosIndex];
    }, 2000);

});