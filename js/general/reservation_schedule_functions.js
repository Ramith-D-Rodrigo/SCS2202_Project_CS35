import { MAX_RESERVATION_DAYS, MIN_RESERVATION_DAYS } from "../CONSTANTS.js";


function createReservationSchedulePage(jsonData){
    //console.log(jsonData);
    //first we insert the data we got from the server into the html 
    addReservationInformation(jsonData);

    createScheduleNavigation(jsonData);  //we create the navigation between each court

    //creating the schedules
    const schedulesArr = createScheduleObjects(jsonData);

    //console.log(schedulesArr);
    //store the schedules in the sessionStorage
    sessionStorage.setItem("schedule", JSON.stringify(schedulesArr));    //convert to string it can be stored

    const schedules = document.getElementsByClassName('court-schedule');

    for(let i = 1; i < schedules.length; i++){  //starting from 1 because we are going to ignore the 0th element
        schedules[i].style.display = 'none';
    }
    
    const tables = createReservationTable(schedulesArr, jsonData);  //create the tables and return the elements

    for(let i = 0; i < tables.length; i++){
        schedules.item(i).appendChild(tables[i]);   //add the table to the schedule div
    }

    updateTheReservationTables(schedulesArr);   //updae the table according to the reservations
    //make reservation box
    makeReservationBox(jsonData);
}

function addReservationInformation(jsonData){   //function to add the reservation details to the page

    const reservingSportNameDiv = document.getElementById("reservingSportName");    //reserving sport
    reservingSportNameDiv.innerHTML = reservingSportNameDiv.innerHTML + " " + jsonData.reservingSport.sportName;

    const reservingBranchLocationDiv = document.getElementById("reservingBranchLocation");  //reserving branch
    reservingBranchLocationDiv.innerHTML = reservingBranchLocationDiv.innerHTML + " " + jsonData.city;

    const reservationPriceDiv = document.getElementById("reservationPriceDisplay"); //reservation price display
    reservationPriceDiv.innerHTML = reservationPriceDiv.innerHTML + " Rs. " + jsonData.reservingSport.reservationPrice + " per Hour";

    const branchOpeningTimeDiv = document.getElementById("branchOpeningTime");  //branch opening time
    branchOpeningTimeDiv.innerHTML = branchOpeningTimeDiv.innerHTML + " " + jsonData.opening_time;

    const branchClosingTimeDiv = document.getElementById("branchClosingTime");  //branch closing time
    branchClosingTimeDiv.innerHTML = branchClosingTimeDiv.innerHTML + " " + jsonData.closing_time;
}

function createScheduleNavigation(jsonData){
    const allScheduleDetailsDiv = document.getElementById("allScheduleDetails");

    for(var key in jsonData.branch_reservation_schedule){   //to create the buttons and store reservation details
        const courtBtn = document.createElement("button");
        courtBtn.className = "courtBtn";
        courtBtn.id = key;
        courtBtn.innerHTML = "Court " + jsonData.branch_reservation_schedule[key].courtName;

        const navBtnsDiv = document.getElementById("scheduleNavBtns");
        allScheduleDetailsDiv.insertBefore(courtBtn, navBtnsDiv); //append the buttons before the nav buttons

        
        //create divs for reservation tables
        const courtScheduleDiv = document.createElement("div");
        courtScheduleDiv.className = "court-schedule";
        courtScheduleDiv.id = "court" + key;
        allScheduleDetailsDiv.appendChild(courtScheduleDiv);    //append it
    }
}

function createScheduleObjects(jsonData){   //function to create objects to all the reservations
    let schedulesArr = [];  //array to store the reservation info of each court

    for(var key in jsonData.branch_reservation_schedule){  //go through all the courts
        let currCourtReservations = Array();
        for(var resInfo in jsonData.branch_reservation_schedule[key].schedule){  //go through all the reservation of each court
            const resDate = jsonData.branch_reservation_schedule[key].schedule[resInfo]['date'].split("-");
            const startingTime = jsonData.branch_reservation_schedule[key].schedule[resInfo]['starting_time'].split(":"); 
            const endingTime = jsonData.branch_reservation_schedule[key].schedule[resInfo]['ending_time'].split(":");

            //create date objects for the reservation starting and ending times

            //month - 1 because JS month starts from 0
            const startingTimeDateObj = new Date(resDate[0], resDate[1] - 1, resDate[2], startingTime[0], startingTime[1], startingTime[2]);
            const endingTimeDateObj = new Date(resDate[0], resDate[1] - 1, resDate[2], endingTime[0], endingTime[1], endingTime[2]);

            //console.log(startingTimeDateObj, endingTimeDateObj);

            const userReservation = {
                startingTime : startingTimeDateObj,
                endingTime : endingTimeDateObj,
                timeDiff : (((endingTimeDateObj - startingTimeDateObj)/1000)/60)/60    //time difference in 1 hour slots
            };

            currCourtReservations.push(userReservation);
            
        }
        schedulesArr.push(currCourtReservations);
    }
    return schedulesArr;
}

function createReservationTable(scheduleObjs, jsonData, dateIncrement = ''){
    //creating the reservation schedule table
        
    //creating schedule tables    
    const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    
    const branchOpeningTime = jsonData.opening_time.split(":");   //branch opening time
    const branchClosingTime = jsonData.closing_time.split(":");   //branch closing time
    //console.log(branchOpeningTime, branchClosingTime);
    let createdTables = [];

    for(let i = 0; i < scheduleObjs.length; i++){//going through each reservation schedule of the courts
        const table = document.createElement("table");  //initial table
        const tableRow = table.insertRow();
        const tableCell = tableRow.insertCell();    //first empty cell
    
        for(let j = 0;  j < 10; j++){   //adding days to the header of the table (only 10 days)
            const weekdayTab = tableRow.insertCell();
            const tempDate = new Date();
            tempDate.setDate(tempDate.getDate() + 1);   //ignoring the current day
            if(dateIncrement !== ''){    //not the initial table (the user has pressed the navigation buttons)
                tempDate.setDate(tempDate.getDate() + dateIncrement);   //we have to set the starting date for that increment
            }
            tempDate.setDate(tempDate.getDate() + j);
            weekdayTab.innerHTML =  tempDate.toLocaleDateString() +"<br>" + weekdays[tempDate.getDay()];
        }
    
        const openingTime = new Date();
        openingTime.setHours(branchOpeningTime[0]);
        openingTime.setMinutes(branchOpeningTime[1]);
        openingTime.setSeconds(0);
        //console.log(openingTime);
    
        const closingTime = new Date();
        closingTime.setHours(branchClosingTime[0]);
        closingTime.setMinutes(branchClosingTime[1]);
        closingTime.setSeconds(0);
        //console.log(closingTime);
    
    
        let currTime = openingTime; //starting the time periods
    
        while(currTime < closingTime){
            const tableRow = table.insertRow();
    
            const timePeriod = tableRow.insertCell();

            const periodStartPrint = currTime.toLocaleTimeString(); //print to print in the page
            const periodStartCompare = currTime.toTimeString(); //compare to compare the times
    
            currTime.setMinutes(currTime.getMinutes() + 60);    //append time period by 60 minutes
    
            const periodEndPrint = currTime.toLocaleTimeString();
            const periodEndCompare = currTime.toTimeString();

            for(let j = 0; j < 10; j++){
                const cell = tableRow.insertCell();
                const tempDate = new Date();
                tempDate.setDate(tempDate.getDate() + 1);   //ignoring the current day
                if(dateIncrement !== ''){    //not the initial table (the user has pressed the navigation buttons)
                    tempDate.setDate(tempDate.getDate() + dateIncrement);   //we have to set the starting date for that increment
                }
                tempDate.setDate(tempDate.getDate() + j);
                cell.id = "court" + i +tempDate.toLocaleDateString().replaceAll("/", "-") + periodStartPrint.replaceAll(" ", '');   //id is => "Court , Reservation Date, Starting Time"

            }
            tableRow.id = "court" + i + periodStartPrint.replaceAll(" ", '') + periodEndPrint.replaceAll(" ", '');
    
            timePeriod.innerText = periodStartPrint + " - " + periodEndPrint;    
        }
        createdTables.push(table);
    }
    return createdTables;
}

function updateTheReservationTables(scheduleObjs){
    for(let i = 0; i < scheduleObjs.length; i++){   //go through each schedule
        for(let j = 0; j < scheduleObjs[i].length; j++){    //replace the empty cells with reserved cells
            let res = scheduleObjs[i][j];
            if(typeof res.startingTime === "string"){   //if the reservation is a string, it means that it is a stringified date object
                res.startingTime = new Date(res.startingTime);
                res.endingTime = new Date(res.endingTime);
            }
            const resDate = res.startingTime.toLocaleDateString();
    
            const cell = document.createElement("td");
            cell.rowSpan = res.timeDiff;
            cell.innerText = "Reserved";
            cell.style.backgroundColor = "Red";
            cell.style.color = "white";
            cell.style.borderRadius = "10px";
            const namingID  = "court" + i + resDate.replaceAll("/", "-") + res.startingTime.toLocaleTimeString().replaceAll(" ", "");
            cell.id = namingID;
    
            const replacingCell = document.getElementById(namingID);
            if(replacingCell != null && replacingCell != undefined && replacingCell.innerHTML != "Reserved"){
                const parent = replacingCell.parentNode;    //get the parent
                const prevSibling = replacingCell.previousSibling;  //get the previous sibling
                //we need to remove the cells according to the span
                let currParent = parent;    //current parent (we go down the table)
                for(let k = 0; k < res.timeDiff; k++){
                    const nextStart = new Date();
                    nextStart.setHours(res.startingTime.getHours() + k); //increment the starting time by 1 hour for the next cell
                    nextStart.setMinutes(res.startingTime.getMinutes());
                    nextStart.setSeconds(0);
                    const nextID = "court" + i + resDate.replaceAll("/", "-") + nextStart.toLocaleTimeString().replaceAll(" ", "");
                    const removingCell = document.getElementById(nextID);
                    //console.log(removingCell);
                    //const removingCell = parent.childNodes[replacingCell.cellIndex + k];
                    currParent.removeChild(removingCell);
                    currParent = currParent.nextSibling;
                }
                prevSibling.after(cell);    //add the reservation cell after the sibling
            }
        }
    }
}

function makeReservationBox(jsonData){
    const reservingSportInput = document.getElementById("reservingSportInput"); //reserving sport
    reservingSportInput.value = jsonData.reservingSport.sportName;

    const reservingBranchInput = document.getElementById("reservingBranchInput");   //reserving branch
    reservingBranchInput.value = jsonData.city;

    const reserveStartingTime = document.getElementById("reserveStartingTime"); //reserve starting time input
    reserveStartingTime.min = jsonData.opening_time.substring(0,5);
    reserveStartingTime.max = jsonData.closing_time.substring(0,5);

    const reserveEndingTime = document.getElementById("reserveEndingTime"); //reserve ending time input
    reserveEndingTime.min = jsonData.opening_time.substring(0,5);
    reserveEndingTime.max = jsonData.closing_time.substring(0,5);

    const reservationPrice = document.getElementById("reservationPrice");  //reservation price input
    reservationPrice.min = jsonData.reservingSport['reservationPrice'];
    

    
    const courtBtns = document.getElementsByClassName('courtBtn');
    const reserveBtn = document.getElementById("makeReserveBtn");   //make reservation button
    
    const selectedCourt = document.getElementById("selectedSportCourt");    //Selected Sports Court
    
    selectedCourt.value = courtBtns[0].innerHTML;   //at the start, the first court is the selected
    reserveBtn.value = courtBtns[0].id;
    courtBtns[0].style.backgroundColor = "darkorange";
    
    //court button to display the schedule of each court when pressed
    for(let i = 0; i < courtBtns.length; i++){
    
        const btn = document.getElementById(courtBtns[i].id);
        btn.addEventListener('click', ()=>{
            for(let j = 0; j < courtBtns.length; j++){  //changing back to default color
                courtBtns[j].style.backgroundColor = "";
            }
            btn.style.backgroundColor = "darkorange";
    
            const allSchedules = document.getElementsByClassName('court-schedule'); //get all the schedule divs
    
            for(let j = 0; j < allSchedules.length; j++){   //traverse the divs
                allSchedules[j].style.display = 'none';   //remove the active attribute
            }
    
            const scheduleid = "court" + btn.id;    //get the pressed court's id
            const schedule = document.getElementById(scheduleid);   //get the element
            schedule.style.display = 'block';
            selectedCourt.value = btn.innerHTML;
            reserveBtn.value = btn.id;  //assign selected court's id to reservation submit button's value 
        });
    }
}

//we can export updateTheReservationTables, createScheduleObjects, and createReservationTable functions aswell to use them to update the table after a reservation is made

export {updateTheReservationTables, createScheduleObjects, createReservationSchedulePage, createReservationTable};