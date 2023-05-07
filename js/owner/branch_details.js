import {intializeMap, setMarker} from "../MAP_FUNCTIONS.js";
import {changeToLocalTime, feedbackPagination, disableElementsInMain, enableElementsInMain} from "../FUNCTIONS.js";
import {MAX_FEEDBACK_DISPLAY_COUNT} from "../CONSTANTS.js";

let feedbacks = []; //to store the feedbacks for pagination
let branches = [];  //store the branches
let currPage = 1;   //current page of the feedbacks

const nextPage = document.querySelector("#nextPage");
const prevPage = document.querySelector("#prevPage");

//disable the previous button
prevPage.classList.add("disabled");

//disable the next button
nextPage.classList.add("disabled");

let selectedBranch = null; //store the selected branch

const feedbackContainer = document.querySelector("#userFeedback");  //feedback container

const nextFeedbacks = (e) => {
    if(currPage * MAX_FEEDBACK_DISPLAY_COUNT >= feedbacks[selectedBranch].feedback.length){   //if the current page is the last page
        //disable the next button
        e.target.classList.add("disabled");
        return;
    }
    feedbackPagination(currPage + 1, currPage, feedbackContainer, feedbacks[selectedBranch].feedback, MAX_FEEDBACK_DISPLAY_COUNT, nextPage, prevPage);
    currPage++;
}

const prevFeedbacks = (e) => {
    if(currPage == 1){  //if the current page is the first page
        //disable the previous button
        e.target.classList.add("disabled");
        return;
    }
    feedbackPagination(currPage - 1, currPage, feedbackContainer, feedbacks[selectedBranch].feedback, MAX_FEEDBACK_DISPLAY_COUNT, nextPage, prevPage);
    currPage--;
}

//add the event listeners
nextPage.addEventListener("click", nextFeedbacks);
prevPage.addEventListener("click", prevFeedbacks);


const branchDetailsForm = document.querySelector("#branchContainer");

//get the data from the server
fetch("../../controller/owner/branch_details_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);

        //initialize and store the data
        for(let i = 0; i < data.length; i++){
            branches.push(data[i]);
        }

        //select branch option
        const selectBranch = document.querySelector("#branchFilter");

        //create an option for each branch
        branches.forEach(branch => {
            const option = document.createElement("option");
            option.value = branch.branchDetails.branchID;
            option.innerHTML = branch.branchDetails.city;
            selectBranch.appendChild(option);
        });

        //add event listener to the select branch
        selectBranch.addEventListener("change", displayBranchDetails);

        //display the first branch details
        displayBranchDetails({target: {value: branches[0].branchDetails.branchID}});

        //view schedule btn event listener
        const viewScheduleBtn = document.querySelector("#scheduleBtn");
        viewScheduleBtn.addEventListener("click", (e) => {
            //get the branch id
            const branchID = document.querySelector("#branchFilter").value;

            //store in session storage
            sessionStorage.setItem("branchID", branchID);
            //redirect to the schedule page
            window.location.href = "/public/owner/reservation_schedule.php";
        });
    })
    .then(() => {
        //event listener for map icon
        const mapIcon = document.querySelector("#mapIcon");
        mapIcon.addEventListener("click", (e) => {
            e.stopPropagation();
            const branchID = document.querySelector("#branchFilter").value;
            if(branchID == ""){
                return;
            }
            const branch = branches.find(branch => {
                return branch.branchDetails.branchID == branchID;
            });

            const latitude = branch.branchDetails.latitude;
            const longitude = branch.branchDetails.longitude;

                //display the map
            const mapContainer = document.querySelector(".map-container");
            mapContainer.style.display = "flex";

            const map = intializeMap('map', latitude, longitude);
            setMarker(map, latitude, longitude);

            //add the google maps link
            const googleMapsLink = mapContainer.lastElementChild;
            const link = googleMapsLink.querySelector("a");
            link.href = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`;

            //disable the main and darken it
            const main = document.querySelector("main");
            disableElementsInMain(main);

            main.style.opacity = "0.5";

            main.addEventListener("click", function closeMap() {
                mapContainer.style.display = "none";
                enableElementsInMain(main);
                main.style.opacity = "1";

                //delete the map
                const map = document.querySelector("#map");
                map.remove();

                const newMap = document.createElement("div");
                newMap.id = "map";
                newMap.className = "map";
                mapContainer.insertBefore(newMap, googleMapsLink);


                main.removeEventListener("click", closeMap);
            });
        });
    })


const displayBranchDetails = (e) => {
    const branchID = e.target.value;

    selectedBranch = branchID;  //store the selected branch for pagination

    const courtCountInput = document.querySelector("#courtCount");
    const contactNumbers = branchDetailsForm.querySelector("#contactNumbers");
    const sports = branchDetailsForm.querySelector("#sports");

    branchDetailsForm.reset();

    contactNumbers.innerHTML = "";
    courtCountInput.value = "";
    sports.innerHTML = "";

    if(branchID == ""){
        displayFeedbacks(branchID);
        return;
    }
    else{
        //get the branch details
        const branch = branches.find(branch => {
            return branch.branchDetails.branchID == branchID;
        });

        //display the branch details
        branchDetailsForm.querySelector("#address").value = branch.branchDetails.address;

        //branch manager
        let manager = "";
        if(branch.branchManager.gender == 'm'){
            manager = "Mr. ";
        }
        else{
            manager = "Ms. ";
        }
        manager += `${branch.branchManager.firstName} ${branch.branchManager.lastName}`;

        branchDetailsForm.querySelector("#manager").value = manager;

        //branch receptionist
        let receptionist = "";
        if(branch.branchReceptionist.gender == 'm'){
            receptionist = "Mr. ";
        }
        else{
            receptionist = "Ms. ";
        }
        receptionist += `${branch.branchReceptionist.firstName} ${branch.branchReceptionist.lastName}`;

        branchDetailsForm.querySelector("#receptionist").value = receptionist;

        branchDetailsForm.querySelector("#startDate").value = branch.branchDetails.openingDate;
        branchDetailsForm.querySelector("#openingTime").value = changeToLocalTime(branch.branchDetails.openingTime);
        branchDetailsForm.querySelector("#closingTime").value = changeToLocalTime(branch.branchDetails.closingTime);

        //contact numbers 
        const contactOption1 = document.createElement("option");
        contactOption1.innerHTML = branch.branchManager.contactNum + " (Manager)";

        const contactOption2 = document.createElement("option");
        contactOption2.innerHTML = branch.branchReceptionist.contactNum + " (Receptionist)";


        const contactNumbers = branchDetailsForm.querySelector("#contactNumbers");
        contactNumbers.appendChild(contactOption1);
        contactNumbers.appendChild(contactOption2);

        //branch email
        branchDetailsForm.querySelector("#email").value = branch.branchDetails.branchEmail;

        //providing sports
        branch.sports.forEach(sport => {
            const option = document.createElement("option");
            option.value = sport.sportID;
            option.innerHTML = sport.sportName;
            sports.appendChild(option);
        });

        //add the first sport to the court count
        let courtCount = branch.branchCourts.filter(i => i.sportID == branch.sports[0].sportID).length;
        courtCountInput.value = courtCount;

        //event listener for the sports
        sports.addEventListener("change", (e) => {
            const sportID = e.target.value;
            let courtCount = branch.branchCourts.filter(i => i.sportID == sportID).length;
        
            courtCountInput.value = courtCount;
        });

        //get branch feedback
        //check the feedbacks array
        const feedbackKeys = Object.keys(feedbacks);
        if(!feedbackKeys.includes(branchID)){   //if the feedbacks are not in the array
            //get the feedbacks from the server
            fetch("../../controller/owner/branch_feedback_controller.php?branchID=" + branchID)
                .then(res => res.json())
                .then(data => {
                    console.log(data);

                    //sort the feedbacks according to the date
                    for(let i = 0; i < data.length; i++){
                        sortFeedbacks(data[i]);
                    }

                    //store the feedbacks
                    feedbacks[branchID] = data;
                })
                .then(() => {
                    displayFeedbacks(branchID);
                });
        }
        else{
            displayFeedbacks(branchID);
        }
    }
}

const displayFeedbacks = (branchID) => {
    const currRating = document.querySelector("#currRating");

    const ratingStars = currRating.querySelectorAll("i");

    ratingStars.forEach(star => {
        star.className = "fa-solid fa-star";
    });

    feedbackContainer.innerHTML = "";

    let i = 1;
    ratingStars.forEach(star => {
        if(i <= feedbacks[branchID].rating){
            star.classList.add("checked");
        }
        
        //color star for decimal rating
        if(i === Math.ceil(feedbacks[branchID].rating) && feedbacks[branchID].rating % 1 !== 0){
            star.className = "fa-solid fa-star-half-stroke";
            star.classList.add("checked");
        }
        i++;
    });

    feedbackPagination(1, currPage, feedbackContainer, feedbacks[selectedBranch].feedback, MAX_FEEDBACK_DISPLAY_COUNT, nextPage, prevPage);  //1 is the first page
}

const sortFeedbacks = (feedbackArr) => {
    feedbackArr.sort((a, b) => {
        return new Date(b.date) - new Date(a.date);
    });
}