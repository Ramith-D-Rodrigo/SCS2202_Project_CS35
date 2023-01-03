const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const getReq = params.get("reserveBtn");
//console.log(getReq);

//import the functions from the other js files
import {createReservationSchedulePage, createScheduleObjects, createReservationTable, updateTheReservationTables} from '../general/reservation_schedule_functions.js';

//store in window object so that we can access it from other js files
window.createReservationSchedulePage = createReservationSchedulePage;
window.createScheduleObjects = createScheduleObjects;
window.createReservationTable = createReservationTable;


fetch("../../controller/general/reservation_schedule_controller.php?reserveBtn=".concat(getReq))
    .then(res => res.json())
    .then(data => {
        createReservationSchedulePage(data);
       //creating the event listeners for the navigation buttons
        let navDateIncrement = 0;
        //next button
        const nextBtn = document.getElementById("nextBtn");
        nextBtn.addEventListener("click", ()=>{
             //get the schedule from the session storage
            const schedules = JSON.parse(sessionStorage.getItem("schedule"));
            if(navDateIncrement === 20){    //if the limit is reached, then return
                return;
            }
            navDateIncrement += 10;   //because we are displaying the schedule for the next 10 days
            if(navDateIncrement > 0){ //re-enable the previous button
                prevBtn.disabled = false;
                prevBtn.style.backgroundColor = "";
            }
            const tables = document.querySelectorAll("table");
            let tableParents = [];   //to store the parent
            let i = 0;
            tables.forEach(el => {
                tableParents[i] = el.parentNode;
                el.remove(); //remove the table
                i++;
            });

            const newTables = createReservationTable(schedules, data, navDateIncrement);
            //console.log(schedules);
            i = 0;
            newTables.forEach(el => {   //add the new tables
                tableParents[i].appendChild(el);
                i++;
            });
            //console.log(tableParents);
            updateTheReservationTables(schedules);  //update the reservations

            if(navDateIncrement === 20){  //now reached the limit (disable the button)
                nextBtn.disabled = true;
                nextBtn.style.backgroundColor = "grey";
            }
        });

        //previous button
        const prevBtn = document.getElementById("prevBtn");
        prevBtn.addEventListener("click", ()=>{
            //get the schedule from the session storage
            const schedules = JSON.parse(sessionStorage.getItem("schedule"));
            if(navDateIncrement === 0){    //if the limit is reached, then return
                return;
            }
            navDateIncrement -= 10;   //because we are displaying the schedule for the previous 10 days (more like going back)
            if(navDateIncrement < 20){ //re-enable the next button
                nextBtn.disabled = false;
                nextBtn.style.backgroundColor = "";
            }
            const tables = document.querySelectorAll("table");
            let tableParents = [];   //to store the parent
            let i = 0;
            tables.forEach(el => {
                tableParents[i] = el.parentNode;
                el.remove(); //remove the table
                i++;
            });

            const newTables = createReservationTable(schedules, data, navDateIncrement);
            //console.log(schedules)
            i = 0;
            newTables.forEach(el => {   //add the new tables
                tableParents[i].appendChild(el);
                i++;
            });
            //console.log(tableParents);
            updateTheReservationTables(schedules);  //update the reservations

            if(navDateIncrement === 0){  //now reached the limit (disable the button)
                prevBtn.disabled = true;
                prevBtn.style.backgroundColor = "grey";
            }
        });

    });