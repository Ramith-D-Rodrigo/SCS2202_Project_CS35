import { intializeMap, getCurrentLocationSync, getClickedCoordinates, resetMap, setMarker} from '../MAP_FUNCTIONS.js';
import {MAX_COURT_COUNT} from '../CONSTANTS.js';
import { formHandle } from './add_new_branch_handle.js';

//first get the current location of the user
const currentLocation = await getCurrentLocationSync();

//to get the coordinates of the clicked point on the map

//default it is the current location of the user
let latitude = currentLocation.latitude;
let longitude = currentLocation.longitude;

const formMsg = document.getElementById('msg');

const myMap = intializeMap('map', currentLocation.latitude, currentLocation.longitude); //initialize the map with the current location of the user

setMarker(myMap, currentLocation.latitude, currentLocation.longitude);

//add event listener to the map to get the coordinates of the clicked point
myMap.on('click', (event) => {
    const clickedCoordinates = getClickedCoordinates(myMap, event);
    latitude = clickedCoordinates.latitude;
    longitude = clickedCoordinates.longitude;
    setMarker(myMap, latitude, longitude);

});

//current location button
const currentLocationButton = document.getElementById('currLocation');
currentLocationButton.addEventListener('click', () => {
    resetMap(myMap);
    setMarker(myMap, currentLocation.latitude, currentLocation.longitude);
    latitude = currentLocation.latitude;
    longitude = currentLocation.longitude;
});


//array to store sports
let sportsArr = [];

//get the sports from the database
fetch("../../controller/owner/add_new_branch_get_details_controller.php")
    .then(response => response.json())
    .then(data => {
        //console.log(data);
        sportsArr = data;

        //add the sports to the checkboxes
        const sportsContainer = document.getElementById('sports');
        sportsArr.forEach(sport => {
            const sportDiv = document.createElement('div');

            const sportInput = document.createElement('input');
            sportInput.type = 'checkbox';
            sportInput.id = sport.sportID;
            sportInput.value = sport.sportID;
            sportInput.name = 'sports[]';   //name is an array so that we can get all the selected sports

            const sportLabel = document.createElement('label');
            sportLabel.setAttribute('for', sport.sportID);
            sportLabel.innerHTML = sport.sportName;

            sportDiv.appendChild(sportInput);
            sportDiv.appendChild(sportLabel);

            //number of courts select
            const courtSelect = document.createElement('select');
            courtSelect.id = sport.sportID + 'Select';

            courtSelect.className = "court-select";

            for(let i = 1; i <= MAX_COURT_COUNT; i++){
                const option = document.createElement('option');
                option.value = i;
                option.innerHTML = i;
                courtSelect.appendChild(option);
            }

            const textNode = document.createTextNode(' Courts');

            sportDiv.appendChild(courtSelect);
            sportDiv.appendChild(textNode);

            sportsContainer.appendChild(sportDiv);
        });
    });


const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    const status = formHandle(form);

    formMsg.innerHTML = '';

    if(status[0]){ //if the form is valid
        const formData = new FormData(form);
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);

        const selectedSports = formData.getAll('sports[]');

        let sendingSportArr = [];
        selectedSports.forEach(sport => {
            const courtCount = document.getElementById(sport + 'Select');
            
            const sportObj = {
                sportID: sport,
                courtCount: courtCount.value
            }

            sendingSportArr.push(sportObj);
        });

        formData.delete('sports[]');
        formData.append('sports', JSON.stringify(sendingSportArr)); //add the sports array to the form data

        //disable the submit button
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.classList.add('disabled');

        //send the data to the controller
        let status = true;
        fetch("../../controller/owner/add_new_branch_controller.php", {
            method: 'POST',
            body: formData
        })
        .then(response => {
            status = response.ok;
            return response.json();
        })
        .then(data => {
            //re-enable the submit button
            submitButton.disabled = false;
            submitButton.classList.remove('disabled');

            if(status){
                formMsg.innerHTML = data.msg;
                formMsg.style.color = 'green';
            }
            else{
                formMsg.innerHTML = data.msg;
                formMsg.style.color = 'red';
            }
        });
    }
    else{
        formMsg.innerHTML = status[1];
        formMsg.style.color = 'red';
    }
});

