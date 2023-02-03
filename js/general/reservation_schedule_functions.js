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

    updateTheReservationTables(schedulesArr, jsonData);   //updae the table according to the reservations
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
    branchOpeningTimeDiv.innerHTML = branchOpeningTimeDiv.innerHTML + " " + jsonData.openingTime;

    const branchClosingTimeDiv = document.getElementById("branchClosingTime");  //branch closing time
    branchClosingTimeDiv.innerHTML = branchClosingTimeDiv.innerHTML + " " + jsonData.closingTime;
}

function createScheduleNavigation(jsonData){
    const allScheduleDetailsDiv = document.getElementById("allScheduleDetails");

    for(var key in jsonData.branchReservationSchedule){   //to create the buttons and store reservation details
        const courtBtn = document.createElement("button");
        courtBtn.className = "courtBtn";
        courtBtn.id = key;
        courtBtn.innerHTML = "Court " + jsonData.branchReservationSchedule[key].courtName;

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
    let schedulesArr = {};  //object to store the reservation info of each court

    let i = 1;
    for(var key in jsonData.branchReservationSchedule){  //go through all the courts
        let courtSchedule = {};
        let currCourtReservations = Array();
        for(var resInfo in jsonData.branchReservationSchedule[key].schedule.reservations){  //go through all the reservation of each court
            const resDate = jsonData.branchReservationSchedule[key].schedule.reservations[resInfo]['date'].split("-");
            const startingTime = jsonData.branchReservationSchedule[key].schedule.reservations[resInfo]['startingTime'].split(":"); 
            const endingTime = jsonData.branchReservationSchedule[key].schedule.reservations[resInfo]['endingTime'].split(":");

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
        courtSchedule['reservations'] = currCourtReservations;

        //go through all the coaching sessions
        let currCoachReservations = Array();
        for(var resInfo in jsonData.branchReservationSchedule[key].schedule.coachingSessions){  //go through all the reservation of each court
            const sessionDay = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['day'];
            const startingTime = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['startingTime'].split(":");
            const endingTime = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['endingTime'].split(":");
            const timePeriod = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['timePeriod'];

            //create date objects for the reservation starting and ending times

            //month - 1 because JS month starts from 0
            const startingTimeDateObj = new Date();
            startingTimeDateObj.setHours(startingTime[0], startingTime[1], startingTime[2]);
            
            const endingTimeDateObj = new Date();
            endingTimeDateObj.setHours(endingTime[0], endingTime[1], endingTime[2]);

            //console.log(startingTimeDateObj, endingTimeDateObj);

            const coachingSession = {
                startingTime : startingTimeDateObj,
                endingTime : endingTimeDateObj,
                timeDiff : (((endingTimeDateObj - startingTimeDateObj)/1000)/60)/60,    //time difference in 1 hour slots
                day : sessionDay
            };

            currCoachReservations.push(coachingSession);
        }
        courtSchedule['coachingSessions'] = currCoachReservations;

        //go through all the court maintenance
        let currCourtMaintenance = Array();
        for(var resInfo in jsonData.branchReservationSchedule[key].schedule.courtMaintenance){  //go through all the reservation of each court
            const startingDate = jsonData.branchReservationSchedule[key].schedule.courtMaintenance[resInfo]['startingDate'].split("-");
            const endingDate = jsonData.branchReservationSchedule[key].schedule.courtMaintenance[resInfo]['endingDate'].split("-");

            //create date objects for the reservation starting and ending times

            //month - 1 because JS month starts from 0
            const startingTimeDateObj = new Date(startingDate[0], startingDate[1] - 1, startingDate[2]);
            const endingTimeDateObj = new Date(endingDate[0], endingDate[1] - 1, endingDate[2]);

            //console.log(startingTimeDateObj, endingTimeDateObj);

            const courtMaintenance = {
                startingDate : startingTimeDateObj,
                endingDate : endingTimeDateObj,
                noOfDays : (endingTimeDateObj - startingTimeDateObj)/1000/60/60/24
            };

            currCourtMaintenance.push(courtMaintenance);
        }
        courtSchedule['courtMaintenance'] = currCourtMaintenance;

        schedulesArr[i] = courtSchedule;
        i++;
    }
    return schedulesArr;
}

function createReservationTable(scheduleObjs, jsonData, dateIncrement = ''){
    //creating the reservation schedule table
        
    //creating schedule tables    
    const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    
    const branchOpeningTime = jsonData.openingTime.split(":");   //branch opening time
    const branchClosingTime = jsonData.closingTime.split(":");   //branch closing time
    //console.log(branchOpeningTime, branchClosingTime);
    let createdTables = [];

    //convert scheduleObjs to an array
    scheduleObjs = Object.values(scheduleObjs);

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

function updateTheReservationTables(scheduleObjs, jsonData){
    //convert object to array
    scheduleObjs = Object.values(scheduleObjs);
   
    
    for(let i = 0; i < scheduleObjs.length; i++){   //go through each schedule
        //user reservations
        if(scheduleObjs[i].reservations !== undefined){    //if there are reservations
            for(let j = 0; j < scheduleObjs[i]['reservations'].length; j++){    //replace the empty cells with reserved cells
                let res = scheduleObjs[i]['reservations'][j];
                if(typeof res.startingTime === "string"){   //if the reservation is a string, it means that it is a stringified date object
                    res.startingTime = new Date(res.startingTime);
                    res.endingTime = new Date(res.endingTime);
                }
                const resDate = res.startingTime.toLocaleDateString();
        
                const cell = createReservationCell("Reserved", res, i);
                const namingID = createCellID(i, resDate, res.startingTime.toLocaleTimeString());
                cell.id = namingID;
        
                const replacingCell = document.getElementById(namingID);
                if(replacingCell != null && replacingCell != undefined && replacingCell.innerHTML != "Reserved"){
                    replaceCell(replacingCell, cell, res.startingTime, resDate, res.timeDiff, i);
                }
            }
        }

        //coaching sessions
        if(scheduleObjs[i].coachingSessions !== undefined){    //if there are coaching sessions
            for(let j = 0; j < scheduleObjs[i]['coachingSessions'].length; j++){    //replace the empty cells with reserved cells
                let res = scheduleObjs[i]['coachingSessions'][j];
                if(typeof res.startingTime === "string"){   //if the reservation is a string, it means that it is a stringified date object
                    res.startingTime = new Date(res.startingTime);
                    res.endingTime = new Date(res.endingTime);
                }
                
                //coaching sessions are recurring, so we have to check the day of the week
                const sessionDay = res.day;

                //since we are considering 30 days to display in the reservation schedule, we need to create enough cells to cover the 30 days
                //we will create a cell for each day of the week, and we will check if the day of the week matches the day of the coaching session
                //if it does, we will add the cell to the table
                let tempDate = new Date();  //we will use this to increment the date
                let inc = 1; //we will increment the date by 1 day
                do{
                    //get the day of the week to string
                    const day = tempDate.toLocaleDateString('en-US', { weekday: 'long' });
                    if(day === sessionDay){    //if the day of the week matches the day of the coaching session
                        const resDate = tempDate.toLocaleDateString();
                        const cell = createReservationCell("Coaching Session", res);
                        const namingID = createCellID(i, resDate, res.startingTime.toLocaleTimeString());
                        cell.id = namingID;

                        const replacingCell = document.getElementById(namingID);

                        if(replacingCell != null && replacingCell != undefined && replacingCell.innerHTML != "Reserved" && replacingCell.innerHTML != "Coaching Session"){
                            replaceCell(replacingCell, cell, res.startingTime, resDate, res.timeDiff, i);
                        }
                        //since found, increment the date to the next week
                        tempDate.setDate(tempDate.getDate() + 7);
                        inc += 7;
                    }
                    else{
                        inc++;
                        tempDate.setDate(tempDate.getDate() + 1);    //increment the date by 1
                    }
                }while(inc < 30);    //we will increment the date until we reach the 30th day
            }
        }

        //court maintenance
        if(scheduleObjs[i].courtMaintenance !== undefined){    //if there are court maintenance
            for(let j = 0; j < scheduleObjs[i]['courtMaintenance'].length; j++){    //replace the empty cells with reserved cells
                let res = scheduleObjs[i]['courtMaintenance'][j];
                if(typeof res.startingDate === "string"){   //if the reservation is a string, it means that it is a stringified date object
                    res.startingDate = new Date(res.startingDate);
                    res.endingDate = new Date(res.endingDate);
                }

                //court maintenance takes a full day, so we will check the starting date and ending date
                let tempDate = new Date();  //we will use this to increment the date
                const startingTime = jsonData.openingTime.substring(0,5);   //get the opening time
                const endingTime = jsonData.closingTime.substring(0,5); //get the closing time

                const startingTimeObj = new Date(tempDate.getFullYear(), tempDate.getMonth(), tempDate.getDate(), startingTime.substring(0,2), startingTime.substring(3,5));
                const endingTimeObj = new Date(tempDate.getFullYear(), tempDate.getMonth(), tempDate.getDate(), endingTime.substring(0,2), endingTime.substring(3,5));
                



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
    reserveStartingTime.min = jsonData.openingTime.substring(0,5);
    reserveStartingTime.max = jsonData.closingTime.substring(0,5);

    const reserveEndingTime = document.getElementById("reserveEndingTime"); //reserve ending time input
    reserveEndingTime.min = jsonData.openingTime.substring(0,5);
    reserveEndingTime.max = jsonData.closingTime.substring(0,5);

    const reservationPrice = document.getElementById("reservationPrice");  //reservation price input
    reservationPrice.min = jsonData.reservingSport['reservationPrice'];
    

    
    const courtBtns = document.getElementsByClassName('courtBtn');
    const reserveBtn = document.getElementById("makeReserveBtn");   //make reservation button
    
    const selectedCourt = document.getElementById("selectedSportCourt");    //Selected Sports Court
    
    selectedCourt.value = courtBtns[0].innerHTML;   //at the start, the first court is the selected
    reserveBtn.value = courtBtns[0].id;
    courtBtns[0].style.backgroundColor = "lightblue";
    courtBtns[0].style.color = "black";
    courtBtns[0].style.boxShadow = "0 0 10px 0 rgba(0,0,0,0.5)";

    
    //court button to display the schedule of each court when pressed
    for(let i = 0; i < courtBtns.length; i++){
    
        const btn = document.getElementById(courtBtns[i].id);
        btn.addEventListener('click', ()=>{
            for(let j = 0; j < courtBtns.length; j++){  //changing back to default color
                courtBtns[j].style.backgroundColor = "";
                courtBtns[j].style.color = "";
                courtBtns[j].style.boxShadow = "";
            }
            btn.style.backgroundColor = "lightblue";
            btn.style.color = "black";
            btn.style.boxShadow = "0 0 10px 0 rgba(0,0,0,0.5)";
    
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

function createReservationCell(innerText, cellInfoObj){   //create a reservation cell (need a function because it follows the same pattern for reservation, coaching, and maintenance)
    const cell = document.createElement("td");
    cell.rowSpan = cellInfoObj.timeDiff;
    cell.innerText = innerText;
    cell.style.background = "linear-gradient(180deg, rgba(5,5,108,1) 0%, rgba(0,0,0,1) 48%, rgba(167,0,0,1) 100%)";
    cell.style.color = "white";
    cell.style.borderRadius = "10px";
    return cell;
}

function createCellID(courtNum, localeDateString, startTimeLocaleString){  //create a cell id (need a function because it follows the same pattern for reservation, coaching, and maintenance)
    const namingID  = "court" + courtNum + localeDateString.replaceAll("/", "-") + startTimeLocaleString.replaceAll(" ", "");
    return namingID;
}

function replaceCell(replacingCell, newCell, startingTime, localeDateString, timeDiff, courtNum){
    const parent = replacingCell.parentNode;    //get the parent
    const prevSibling = replacingCell.previousSibling;  //get the previous sibling
    //we need to remove the cells according to the span
    let currParent = parent;    //current parent (we go down the table)
    for(let k = 0; k < timeDiff; k++){
        const nextStart = new Date();
        nextStart.setHours(startingTime.getHours() + k); //increment the starting time by 1 hour for the next cell
        nextStart.setMinutes(startingTime.getMinutes());
        nextStart.setSeconds(0);
        const nextID = createCellID(courtNum, localeDateString, nextStart.toLocaleTimeString());
        const removingCell = document.getElementById(nextID);
        //const removingCell = parent.childNodes[replacingCell.cellIndex + k];
        currParent.removeChild(removingCell);
        currParent = currParent.nextSibling;
    }
    prevSibling.after(newCell);    //add the reservation cell after the sibling
}


//we can export updateTheReservationTables, createScheduleObjects, and createReservationTable functions aswell to use them to update the table after a reservation is made

export {updateTheReservationTables, createScheduleObjects, createReservationSchedulePage, createReservationTable};