
//import the functions from the other js files
import {createScheduleNavigation, createScheduleObjects, createReservationTable, updateTheReservationTables, createCellID} from '../general/reservation_schedule_functions.js';
//import the date constraints
import { MAX_RESERVATION_DAYS , weekdays} from '../CONSTANTS.js';
import { addLeadingZeros} from '../FUNCTIONS.js';
import { openReservationDetails,  cellandReservationMap} from './reservation_session_details.js';

//store branch and sports
let branchSpotArr = [];
const branchSelect = document.getElementById("branchVal");
const sportSelect = document.getElementById("sportVal");
const startingDate = document.getElementById("startDate");

//get branch and related sports from the controller
fetch("../../controller/owner/reservation_schedule_details_select_controller.php")
.then(res => res.json())
.then(data => {
    for(let i = 0; i < data.length; i++){   //traverse each branch
        //add options to the branch select
        
        const option = document.createElement("option");
        option.value = data[i].branchID;
        option.textContent = data[i].city;
        branchSelect.appendChild(option);

        //add the branch and sport to the array
        branchSpotArr[data[i].branchID] = data[i].sports;
    }
})
.then(() => {
    //add event listener to the branch select
    branchSelect.addEventListener("change", () => {
        const branchID = branchSelect.value;

        if(branchID === ""){
            sportSelect.innerHTML = "";
            //add the default option
            const option = document.createElement("option");
            option.value = "";
            option.textContent = "Sport";
            sportSelect.appendChild(option);
            return;
        }

        const sports = branchSpotArr[branchID];
        //clear the sport select
        sportSelect.innerHTML = "";
        //add the sports
        sports.forEach(el => {
            const option = document.createElement("option");
            option.value = el.sportID;
            option.textContent = el.sportName;
            sportSelect.appendChild(option);
        });
    });

    //add event listener to the form
    const form = document.getElementById("court-select");
    form.addEventListener("submit", courtSelect);

    //check whether the owner comes from the branch page
    if(sessionStorage.getItem("branchID") !== null){
        //select the branch and sport
        branchSelect.value = sessionStorage.getItem("branchID");
        sessionStorage.removeItem("branchID");
    }
    else{
        //select the first branch and sport
        branchSelect.value = branchSelect.options[1].value;
    }

    //set the starting date to today
    const today = new Date().toLocaleDateString().split("/");
    startingDate.value = today[2] + "-" + addLeadingZeros(today[0]) + "-" + addLeadingZeros(today[1]);
    branchSelect.dispatchEvent(new Event("change"));
    //call the event listener to display the schedule by submitting the form
    form.dispatchEvent(new Event("submit"));
    

});

const courtSelect = (e) =>{
    e.preventDefault();
    const branchID = branchSelect.value;
    const sportID = sportSelect.value;
    const startDate = startingDate.value;

    if(branchID === "" || sportID === "" || startDate === ""){
        return;
    }

    const params = new URLSearchParams();
    params.append("branch", branchID);
    params.append("sport", sportID);
    params.append("startDate", startDate);

    fetch("../../controller/owner/reservation_schedule_controller.php?" + params)
    .then(res => res.json())
    .then(data => {
        //first remove the previous schedule
        const scheduleDetails = document.getElementById("allScheduleDetails");
        scheduleDetails.innerHTML = "<div id='scheduleNavBtns'><button id='prevBtn'>Previous</button><button id='nextBtn'>Next</button></div>"; //the navigation buttons default

        //clear the cell and reservation map
        cellandReservationMap.clear();

        createScheduleNavigation(data);  //we create the navigation between each court

        //creating the schedules
        const schedulesArr = createScheduleObjects(data);
    
        //console.log(schedulesArr);
        //store the schedules in the sessionStorage
        sessionStorage.setItem("schedule", JSON.stringify(schedulesArr));    //convert to string it can be stored
    
        const schedules = document.getElementsByClassName('court-schedule');
    
        for(let i = 1; i < schedules.length; i++){  //starting from 1 because we are going to ignore the 0th element
            schedules[i].style.display = 'none';
        }

        //date difference
        const startDateObj = new Date(startDate);
        const today = new Date();
        startDateObj.setHours(0,0,0,0);
        today.setHours(0,0,0,0);
        
        const dateDiff = (startDateObj - today) / (1000 * 60 * 60 * 24);
        
        const tables = createReservationTable(schedulesArr, data, dateDiff - 1);  //create the tables and return the elements
    
        for(let i = 0; i < tables.length; i++){
            schedules.item(i).appendChild(tables[i]);   //add the table to the schedule div
        }
    
        updateTheReservationTables(schedulesArr, data, dateDiff - 1);   //updae the table according to the reservations

        //creating the event listeners for the reserved cells
        const reservedCells = document.getElementsByClassName('reserved');
        for(let i = 0; i < reservedCells.length; i++){
            reservedCells[i].addEventListener('click', openReservationDetails);
        }

       //creating the event listeners for the navigation buttons
        let navDateIncrement = 0;
        //next button
        const nextBtn = document.getElementById("nextBtn");
        nextBtn.addEventListener("click", ()=>{
             //get the schedule from the session storage
            const schedules = JSON.parse(sessionStorage.getItem("schedule"));
            if(navDateIncrement >= MAX_RESERVATION_DAYS - 10){    //if the limit is reached, then return
                return;
            }
            navDateIncrement += 10;   //because we are displaying the schedule for the next 10 days
            if(navDateIncrement > 0){ //re-enable the previous button
                prevBtn.disabled = false;
                prevBtn.classList.remove("nav-disable");
            }
            const tables = document.querySelectorAll("table");
            let tableParents = [];   //to store the parent
            let i = 0;
            tables.forEach(el => {
                tableParents[i] = el.parentNode;
                el.remove(); //remove the table
                i++;
            });

            const newTables = createReservationTable(schedules, data, dateDiff - 1 + navDateIncrement); //-1 because original function ignores the first day
            //console.log(schedules);
            i = 0;
            newTables.forEach(el => {   //add the new tables
                tableParents[i].appendChild(el);
                i++;
            });
            //console.log(tableParents);
            updateTheReservationTables(schedules, data, dateDiff - 1 + navDateIncrement);  //update the reservations

            //creating the event listeners for the reserved cells
            const reservedCells = document.getElementsByClassName('reserved');
            for(let i = 0; i < reservedCells.length; i++){
                reservedCells[i].addEventListener('click', openReservationDetails);
            }

            if(navDateIncrement >= MAX_RESERVATION_DAYS - 10){  //now reached the limit (disable the button)
                nextBtn.disabled = true;
                nextBtn.classList.add("nav-disable");
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
            if(navDateIncrement < MAX_RESERVATION_DAYS - 10){ //re-enable the next button
                nextBtn.disabled = false;
                nextBtn.classList.remove("nav-disable");
            }
            const tables = document.querySelectorAll("table");
            let tableParents = [];   //to store the parent
            let i = 0;
            tables.forEach(el => {
                tableParents[i] = el.parentNode;
                el.remove(); //remove the table
                i++;
            });

            const newTables = createReservationTable(schedules, data, dateDiff - 1 + navDateIncrement); //-1 because original function ignores the first day
            //console.log(schedules)
            i = 0;
            newTables.forEach(el => {   //add the new tables
                tableParents[i].appendChild(el);
                i++;
            });
            //console.log(tableParents);
            updateTheReservationTables(schedules, data, dateDiff - 1 + navDateIncrement);  //update the reservations

            //creating the event listeners for the reserved cells
            const reservedCells = document.getElementsByClassName('reserved');
            for(let i = 0; i < reservedCells.length; i++){
                reservedCells[i].addEventListener('click', openReservationDetails);
            }

            if(navDateIncrement === 0){  //now reached the limit (disable the button)
                prevBtn.disabled = true;
                prevBtn.classList.add("nav-disable");
            }
        });

        //at the start, disable the previous button
        prevBtn.disabled = true;
        prevBtn.classList.add("nav-disable");

        //navigation between the courts
    
        const courtBtns = document.getElementsByClassName('courtBtn');

        courtBtns[0].classList.add("selected");
        
        //court button to display the schedule of each court when pressed
        for(let i = 0; i < courtBtns.length; i++){
        
            const btn = document.getElementById(courtBtns[i].id);
            btn.addEventListener('click', ()=>{
                for(let j = 0; j < courtBtns.length; j++){  //changing back to default color
                    courtBtns[j].classList.remove("selected");
                }
                btn.classList.add("selected");  //change the color of the pressed button
        
                const allSchedules = document.getElementsByClassName('court-schedule'); //get all the schedule divs
        
                for(let j = 0; j < allSchedules.length; j++){   //traverse the divs
                    allSchedules[j].style.display = 'none';   //remove the active attribute
                }
        
                const scheduleid = "court" + btn.id;    //get the pressed court's id
                const schedule = document.getElementById(scheduleid);   //get the element
                schedule.style.display = 'block';
            });
        }

        //for reservation details
        //create cell ids for each reservations
        let objs = Object.values(schedulesArr);

        for(let i = 0; i < objs.length - 1; i++){ //-1 because not considering branch maintenance
            //reservations

            for(let j = 0; j < objs[i].reservations.length; j++){
                const tempDate = new Date(objs[i].reservations[j].startingTime);
                const cellID = createCellID(i, tempDate.toLocaleDateString(), tempDate.toLocaleTimeString());
                cellandReservationMap.set(cellID, ["reservation", objs[i].reservations[j].reservationID]);

            }

            //coaching sessions
            for(let j = 0; j < objs[i].coachingSessions.length; j++){
                const tempDate = new Date(objs[i].coachingSessions[j].startingTime);

                //find the index of the weekday of tempDate 
                let index = weekdays.indexOf(objs[i].coachingSessions[j].day);
                //add the difference between the current day and the day of the coaching session
                index = index - startDateObj.getDay();
                //set the date
                tempDate.setDate(startDateObj.getDate() + index);            
                
                let count = 0;
                do{ //because the coaching session is weekly
                    const cellID = createCellID(i, tempDate.toLocaleDateString(), tempDate.toLocaleTimeString());
                    cellandReservationMap.set(cellID, ["coaching_session", objs[i].coachingSessions[j].sessionID]);
                    tempDate.setDate(tempDate.getDate() + 7);
                    count += 7;
                }while(count <= MAX_RESERVATION_DAYS);
            }
        }
    });
}
