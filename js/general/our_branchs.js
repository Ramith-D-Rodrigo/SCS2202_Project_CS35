import { intializeMap, setMarker} from "../MAP_FUNCTIONS.js";
import {disableElementsInMain, enableElementsInMain} from "../FUNCTIONS.js";

const result = document.getElementById("branches");

function viewFeedback(e){
    e.preventDefault();
    const parent = e.target.parentNode.parentNode;
    const branchID = parent.querySelector("form").id;
    localStorage.setItem("feedbackBranch", branchID);
    window.location.href = "/public/general/our_feedback.php";
}

const showMap = (e) => {
    e.preventDefault();
    e.stopPropagation();

    //get the latitude and longitude
    const parentDiv = e.target.parentNode;
    console.log(parentDiv);
    const latitude = parentDiv.querySelector(".latitude").value;
    const longitude = parentDiv.querySelector(".longitude").value;

    //get the map div
    const mapDiv = document.querySelector(".map-container");

    //show the map div
    mapDiv.style.display = "block";

    //initialize the map
    const map = intializeMap("map", latitude, longitude);

    //set the marker
    setMarker(map, latitude, longitude);
    
    //google link
    const googleLinkDiv = document.querySelector(".google-link");

    //set the google link
    const link = googleLinkDiv.querySelector("a");

    link.setAttribute("href", `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`);

    //open in new tab
    link.setAttribute("target", "_blank");

    //select main and disable
    const main = document.querySelector("main");
    main.style.opacity = "0.5";

    disableElementsInMain(main);

    main.addEventListener("click", function mainClick(e){
        //hide the map div
        mapDiv.style.display = "none";
        //enable main
        main.style.opacity = "1";
        enableElementsInMain(main);
        main.removeEventListener("click", mainClick);

        const map = mapDiv.querySelector("#map");

        //remove the map
        map.remove();

        //add the map div again
        const newMapDiv = document.createElement("div");
        newMapDiv.setAttribute("id", "map");
        mapDiv.insertBefore(newMapDiv, mapDiv.firstChild);

    });
}

let branches = [];
let branch_pictures = [];

fetch("../../controller/general/our_branches_controller.php")
    .then((res) => res.json())
    .then((data) => {
        for(let i = 0; i < data.length; i++){
            branches[i] = data[i];  //store the json objects in the array
            const branchContainer = document.createElement("div");
            branchContainer.setAttribute("class", "content-box");
            const branchRow = document.createElement("div");
            branchRow.setAttribute("class", "branch-row");

            const branchImageContainer = document.createElement("div");
            branchImageContainer.setAttribute("class","branch-image-container");

            const branchImage = document.createElement("img");


            branch_pictures[i] = branches[i].photos;    //add the pictures to the array
            if(branch_pictures[i].length !== 0){ //has photos
                branchImage.src = branches[i].photos[0];    //add the first photo
            }
            else{
                branchImage.src = "/public/general/branch_images/";
            }

            setInterval(() =>{
                if(branch_pictures[i] === undefined || branch_pictures[i].length === 0){  //if there are no photos
                    return;
                }
                if(branch_pictures[i].length === 1){    //if there is only one image
                    return;
                }
                const prev = branchImage.src;
                var nextImgIndex = Math.floor(Math.random() * branch_pictures[i].length); //next img index

                if(branch_pictures[i][nextImgIndex].split("/").pop() === prev.split("/").pop()){
                    nextImgIndex++;
                }

                if(nextImgIndex === branch_pictures[i].length){
                    nextImgIndex = 0;
                }

                branchImage.src = branch_pictures[i][nextImgIndex];
            }, 3000);

            branchImage.setAttribute("class", "branch-image");
            branchImage.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

            branchImageContainer.appendChild(branchImage);
            branchRow.appendChild(branchImageContainer);

            const formDiv = document.createElement("div");

            formDiv.className = "branch-info";

            const form = document.createElement("form");
            form.className = "branchInfo";
            form.action = "/public/general/reservation_schedule.php";
            form.method = "get";

            //hidden input for branch id
            const branchID = document.createElement("input");
            branchID.setAttribute("type", "hidden");
            branchID.setAttribute("name", "branch");
            branchID.setAttribute("value", branches[i].branchID);
            form.appendChild(branchID);

            const openingTimeArr = branches[i].openingTime.split(":"); //setting opening time
            const openingTime = new Date();
            openingTime.setHours(openingTimeArr[0]);
            openingTime.setMinutes(openingTimeArr[1]);
            openingTime.setSeconds(openingTimeArr[2]);

            const closingTimeArr = branches[i].closingTime.split(":"); //setting closing time
            const closingTime = new Date();
            closingTime.setHours(closingTimeArr[0]);
            closingTime.setMinutes(closingTimeArr[1]);
            closingTime.setSeconds(closingTimeArr[2]); 

            const rating = document.createElement("div");   //branch rating div
            rating.className = "info";
            rating.innerHTML = "Rating : ";
            const branchRating = parseFloat(branches[i].rating);
            
            for(let j = 0; j < 5; j++){
                const star = document.createElement("span");
                star.className = "fa fa-star";
                star.style.margin = "0 0.2em";
                if(j < branchRating){
                    star.className = "fa fa-star checked";
                }
                //color star for decimal rating
                if(j === Math.floor(branchRating) && branchRating % 1 !== 0){
                    star.className = "fa-solid fa-star-half-stroke";
                    star.style.color = "gold";
                }
                star.style.fontSize = "1.5em";
                rating.appendChild(star);
            }

            formDiv.appendChild(rating);

            const location = document.createElement("div"); //branch location div
            location.className = "info";
            location.innerHTML = "Location : " + branches[i].city;

            const branchLocation = document.createElement("div"); //branch location div
            branchLocation.style.display = "inline-block";
            branchLocation.style.marginLeft = "1em";

            //hidden inputs for  latitude and longitude
            const latitude = document.createElement("input");
            latitude.type = "hidden";
            latitude.className = "latitude";
            latitude.value = branches[i].latitude;

            const longitude = document.createElement("input");
            longitude.type = "hidden";
            longitude.className = "longitude";
            longitude.value = branches[i].longitude;

            branchLocation.appendChild(latitude);
            branchLocation.appendChild(longitude);

            //map icon 
            const mapIcon = document.createElement("i");
            mapIcon.className = "fa fa-map";
            mapIcon.classList.add("map-icon");
            mapIcon.style.fontSize = "2em";
            mapIcon.style.cursor = "pointer";
            mapIcon.addEventListener("click", showMap);

            branchLocation.appendChild(mapIcon);

            location.appendChild(branchLocation);
            formDiv.appendChild(location);
      
            const address = document.createElement("div");  //branch address div
            address.className = "info";
            address.innerHTML = "Address : " + branches[i].address;
            formDiv.appendChild(address);

            const opening_time = document.createElement("div"); //branch opening time div
            opening_time.className = "info";
            opening_time.innerHTML = "Opening Time : " + openingTime.toLocaleTimeString();
            formDiv.appendChild(opening_time);

            const closing_time = document.createElement("div"); //branch closing time div
            closing_time.className = "info";
            closing_time.innerHTML = "Closing Time : " + closingTime.toLocaleTimeString();
            formDiv.appendChild(closing_time);
            
            const manager = document.createElement("div");  //branch manager div
            manager.className = "info";
            let managerName = "";
            if(branches[i].manager['gender'] === 'm'){
                managerName = "Mr. ";
            }
            else{
                managerName = "Mrs. ";
            }
            managerName = managerName + branches[i].manager['firstName'] + " " + branches[i].manager['lastName'];

            manager.innerHTML = "Manager : " + managerName;
            formDiv.appendChild(manager);

            const manager_contact = document.createElement("div");  //branch manager contact div
            manager_contact.className = "info";
            manager_contact.innerHTML = "Manager Contact No : " + branches[i].manager['contactNum'];
            formDiv.appendChild(manager_contact);

            const receptionist = document.createElement("div"); //branch receptionist div
            receptionist.className = "info";
            let receptionistName = "";
            if(branches[i].receptionist['gender'] === 'm'){
                receptionistName = "Mr. ";
            }
            else{
                receptionistName = "Mrs. ";
            }
            receptionistName = receptionistName + branches[i].receptionist['firstName'] + " " + branches[i].receptionist['lastName'];

            receptionist.innerHTML = "Receptionist : " + receptionistName;
            formDiv.appendChild(receptionist);

            const receptionist_contact = document.createElement("div"); //branch receptionist contact div
            receptionist_contact.className = "info";    
            receptionist_contact.innerHTML = "Receptionist Contact No : " + branches[i].receptionist['contactNum'];
            formDiv.appendChild(receptionist_contact);

            const branchEmail = document.createElement("div");  //branch email
            branchEmail.className = "info";
            branchEmail.innerHTML = "Branch Email : " + branches[i].branchEmail;
            formDiv.appendChild(branchEmail);


            const feedbackBtn = document.createElement("button");//branch feedback button
            feedbackBtn.innerHTML = "View Feedback";

            //div for feedback
            const feedbackDiv = document.createElement("div");
            feedbackDiv.className = "info";
            feedbackDiv.appendChild(feedbackBtn);
            
            feedbackBtn.addEventListener("click", viewFeedback);
            formDiv.appendChild(feedbackDiv);

            const providing_sports = document.createElement("div"); //providing sports div
            providing_sports.className = "info";
            providing_sports.innerHTML = "Available Sports : ";

            const sportSelector = document.createElement("select");
            sportSelector.setAttribute("required", "");
            sportSelector.className = "providing_sports";
            sportSelector.name = "sport";

            const emptyOption = document.createElement("option");
            emptyOption.value = "";
            emptyOption.text = "Choose One";
            sportSelector.appendChild(emptyOption);

            for(let j = 0; j < branches[i].sports.length; j++){ //adding the sports to the drop dowm
                const sportOption = document.createElement("option");
                sportOption.text = branches[i].sports[j].sportName;
                sportOption.value = branches[i].sports[j].sportID;
                sportSelector.appendChild(sportOption);
            }

            providing_sports.appendChild(sportSelector);
            form.appendChild(providing_sports);


            const reserveBtn = document.createElement("button");    //reservation button
            reserveBtn.innerHTML = "Make a Reservation";
            reserveBtn.type = "submit";

            form.appendChild(reserveBtn);

            formDiv.appendChild(form);
            branchRow.appendChild(formDiv);

            branchContainer.appendChild(branchRow);
            result.appendChild(branchContainer);
        }
    });



