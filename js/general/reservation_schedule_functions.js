import { MAX_RESERVATION_DAYS, MIN_RESERVATION_DAYS, MIN_RESERVATION_TIME_HOURS, currency } from "../CONSTANTS.js";
import {changeToLocalTime} from "../FUNCTIONS.js";


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
    reservationPriceDiv.innerHTML = reservationPriceDiv.innerHTML + currency + " " + jsonData.reservingSport.reservationPrice + " per Hour";

    const branchOpeningTimeDiv = document.getElementById("branchOpeningTime");  //branch opening time
    branchOpeningTimeDiv.innerHTML = branchOpeningTimeDiv.innerHTML + " " + changeToLocalTime(jsonData.openingTime);

    const branchClosingTimeDiv = document.getElementById("branchClosingTime");  //branch closing time
    branchClosingTimeDiv.innerHTML = branchClosingTimeDiv.innerHTML + " " + changeToLocalTime(jsonData.closingTime);
}

function createScheduleNavigation(jsonData){
    const allScheduleDetailsDiv = document.getElementById("allScheduleDetails");

    const navBtnsDiv = document.getElementById("scheduleNavBtns");

    const courtBtnDiv = document.createElement("div");
    courtBtnDiv.className = "courtBtnDiv";
    //allScheduleDetailsDiv.insertBefore(courtBtnDiv, navBtnsDiv); //append the buttons before the nav buttons

    allScheduleDetailsDiv.appendChild(courtBtnDiv);

    for(var key in jsonData.branchReservationSchedule){   //to create the buttons and store reservation details
        const courtBtn = document.createElement("button");
        courtBtn.className = "courtBtn";
        courtBtn.id = key;
        courtBtn.innerHTML = "Court " + jsonData.branchReservationSchedule[key].courtName;

        courtBtnDiv.appendChild(courtBtn); //append the buttons before the nav buttons
        
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

            if(jsonData.branchReservationSchedule[key].schedule.reservations[resInfo]['reservationID'] !== undefined){
                userReservation['reservationID'] = jsonData.branchReservationSchedule[key].schedule.reservations[resInfo]['reservationID'];
            }

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

            if(jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['startDate'] !== undefined){
                const startDate = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['startDate'];
                coachingSession['startDate'] = startDate;
            }

            if(jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['cancelDate'] !== undefined){
                if(jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['cancelDate'] !== null){
                    const cancelDate = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['cancelDate'];
                    coachingSession['cancelDate'] = cancelDate;
                }
            }

            if(jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['sessionID'] !== undefined){
                coachingSession['sessionID'] = jsonData.branchReservationSchedule[key].schedule.coachingSessions[resInfo]['sessionID'];
            }

            currCoachReservations.push(coachingSession);
        }
        courtSchedule['coachingSessions'] = currCoachReservations;

        //go through all the court maintenance
        let currCourtMaintenance = Array();
        for(var resInfo in jsonData.branchReservationSchedule[key].schedule.courtMaintenance){  //go through all the maintenance of each court
            const startingDate = jsonData.branchReservationSchedule[key].schedule.courtMaintenance[resInfo]['startingDate'].split("-");
            const endingDate = jsonData.branchReservationSchedule[key].schedule.courtMaintenance[resInfo]['endingDate'].split("-");

            //create date objects for the reservation starting and ending times

            //month - 1 because JS month starts from 0
            const startingTimeDateObj = new Date(startingDate[0], startingDate[1] - 1, startingDate[2]);
            const endingTimeDateObj = new Date(endingDate[0], endingDate[1] - 1, endingDate[2]);

            //console.log(startingTimeDateObj, endingTimeDateObj);

            const courtMaintenance = {
                startingDate : jsonData.branchReservationSchedule[key].schedule.courtMaintenance[resInfo]['startingDate'],
                endingDate : jsonData.branchReservationSchedule[key].schedule.courtMaintenance[resInfo]['endingDate'],
                noOfDays : ((endingTimeDateObj - startingTimeDateObj)/1000/60/60/24) + 1 //+1 because the ending date is included
            };

            currCourtMaintenance.push(courtMaintenance);
        }
        courtSchedule['courtMaintenance'] = currCourtMaintenance;
        courtSchedule['courtID'] = key;

        schedulesArr[i] = courtSchedule;
        i++;
    }

    //branch maintenance
    let branchMaintenance = Array();
    for(var resInfo in jsonData.branchMaintenance){  //go through all the maintenance info of the branch
        const startingDate = jsonData.branchMaintenance[resInfo]['startingDate'].split("-");
        const endingDate = jsonData.branchMaintenance[resInfo]['endingDate'].split("-");

        //create date objects for maintenance starting and ending dates
        const startingTimeDateObj = new Date(startingDate[0], startingDate[1] - 1, startingDate[2]);
        const endingTimeDateObj = new Date(endingDate[0], endingDate[1] - 1, endingDate[2]);

        const branchMaintenanceObj = {
            startingDate : jsonData.branchMaintenance[resInfo]['startingDate'],
            endingDate : jsonData.branchMaintenance[resInfo]['endingDate'],
            noOfDays : ((endingTimeDateObj - startingTimeDateObj)/1000/60/60/24) + 1 //+1 because the ending date is included
        };

        branchMaintenance.push(branchMaintenanceObj);
    }
    schedulesArr[i] = branchMaintenance;

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

    for(let i = 0; i < scheduleObjs.length - 1; i++){//going through each reservation schedule of the courts ( - 1 because the last element is the branch maintenance)
        const table = document.createElement("table");  //initial table
        const tableHeader = document.createElement("thead");   //table header

        const headerRow = document.createElement("tr"); //header row
        const firstCell = document.createElement("th");   //first empty cell

        headerRow.appendChild(firstCell);
        tableHeader.appendChild(headerRow);
    
        for(let j = 0;  j < 10; j++){   //adding days to the header of the table (only 10 days)
            const weekdayCell = document.createElement("th");
            headerRow.appendChild(weekdayCell);
            const tempDate = new Date();
            tempDate.setDate(tempDate.getDate() + 1);   //ignoring the current day
            if(dateIncrement !== ''){    //not the initial table (the user has pressed the navigation buttons)
                tempDate.setDate(tempDate.getDate() + dateIncrement);   //we have to set the starting date for that increment
            }
            tempDate.setDate(tempDate.getDate() + j);
            weekdayCell.innerHTML =  tempDate.toLocaleDateString() +"<br>" + weekdays[tempDate.getDay()];
        }

        tableHeader.appendChild(headerRow);
        table.appendChild(tableHeader);
    
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

        //table body
        const tableBody = document.createElement("tbody");
        table.appendChild(tableBody);
    
        while(currTime < closingTime){
            const tableRow = tableBody.insertRow(); //table row
    
            const timePeriod = tableRow.insertCell(); //time period cell

            const periodStartPrint = currTime.toLocaleTimeString(); //print to print in the page
    
            currTime.setMinutes(currTime.getMinutes() + MIN_RESERVATION_TIME_HOURS * 60);    //append the time period by the reservation time (in minutes)
    
            const periodEndPrint = currTime.toLocaleTimeString();

            for(let j = 0; j < 10; j++){ //creating the table cells for the reservation table
                const cell = tableRow.insertCell();
                const tempDate = new Date();
                tempDate.setDate(tempDate.getDate() + 1);   //ignoring the current day
                if(dateIncrement !== ''){    //not the initial table (the user has pressed the navigation buttons)
                    tempDate.setDate(tempDate.getDate() + dateIncrement);   //we have to set the starting date for that increment
                }
                tempDate.setDate(tempDate.getDate() + j);
                cell.id = createCellID(i, tempDate.toLocaleDateString(), periodStartPrint);
                //cell.id = "court" + i +tempDate.toLocaleDateString().replaceAll("/", "-") + periodStartPrint.replaceAll(" ", '');   //id is => "Court , Reservation Date, Starting Time"

            }
            tableRow.id = "court" + i + periodStartPrint.replaceAll(" ", '') + periodEndPrint.replaceAll(" ", '');
    
            timePeriod.innerText = periodStartPrint + " - " + periodEndPrint;       //setting the time period in the cell
        }
        createdTables.push(table);
    }
    return createdTables;
}

function updateTheReservationTables(scheduleObjs, jsonData, dateIncrement = ''){    //dateIncrement is the number of days to increment the date
    //convert object to array
    scheduleObjs = Object.values(scheduleObjs);
   
    for(let i = 0; i < scheduleObjs.length - 1; i++){   //go through each schedule (i-1 because the last element is the branch maintenance)
        //user reservations
        if(scheduleObjs[i].reservations !== undefined){    //if there are reservations
            for(let j = 0; j < scheduleObjs[i]['reservations'].length; j++){    //replace the empty cells with reserved cells
                let res = scheduleObjs[i]['reservations'][j];
                if(typeof res.startingTime === "string"){   //if the reservation is a string, it means that it is a stringified date object
                    res.startingTime = new Date(res.startingTime);
                    res.endingTime = new Date(res.endingTime);
                }
                const resDate = res.startingTime.toLocaleDateString();
        
                const cell = createReservationCell("Reserved", res.timeDiff);
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
                if(dateIncrement !== ''){    //not the initial table (the user has pressed the navigation buttons, or the user has changed the date)
                    tempDate.setDate(tempDate.getDate() + dateIncrement);   //we have to set the starting date for that increment
                }
                tempDate.setHours(0, 0, 0, 0);  //set the time to 00:00:00

                let inc = 1; //we will increment the date by 1 day
                do{
                    //get the day of the week to string
                    const day = tempDate.toLocaleDateString('en-US', { weekday: 'long' });
                    if(res.startDate !== undefined){    //if the coaching session has a start date
                        const startDate = new Date(res.startDate);
                        startDate.setHours(0, 0, 0, 0);  //set the time to 00:00:00
                        if(tempDate < startDate){   //if the date is before the start date, we don't have to check it
                            inc++;
                            tempDate.setDate(tempDate.getDate() + 1);    //increment the date by 1
                            continue;
                        }
                    }

                    if(res.cancelDate !== undefined){    //if the coaching session has a cancel date
                        if(res.cancelDate !== null){    //if the cancel date is not null
                            const endDate = new Date(res.cancelDate);
                            endDate.setHours(23, 59, 59, 999);  //set the time to 23:59:59:999
                            if(tempDate > endDate){   //if the date is after the cancel date, the session is over
                                break;
                            }
                        }
                    }

                    if(day === sessionDay){    //if the day of the week matches the day of the coaching session
                        const resDate = tempDate.toLocaleDateString();
                        const cell = createReservationCell("Coaching Session", res.timeDiff);
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
                }while(inc <= 30);    //we will increment the date until we reach the 30th day
            }
        }

        //court maintenance
        if(scheduleObjs[i].courtMaintenance !== undefined){    //if there are court maintenance
            for(let j = 0; j < scheduleObjs[i]['courtMaintenance'].length; j++){    //replace the empty cells with reserved cells
                let res = scheduleObjs[i]['courtMaintenance'][j];
                createMaintenanceCell(res, jsonData.openingTime, jsonData.closingTime, i);
            }
        }

        //for each court, we need to add branch maintenance
        if(scheduleObjs[scheduleObjs.length - 1] !== undefined){
            for(let j = 0; j < scheduleObjs[scheduleObjs.length - 1].length; j++){    //replace the empty cells with reserved cells
                createMaintenanceCell(scheduleObjs[scheduleObjs.length - 1][j], jsonData.openingTime, jsonData.closingTime, i);
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
    
    if(jsonData.branchDiscount != null){
        const discount = document.createElement("div");
        discount.id = "discount";
        discount.style.fontSize = "1.5em";
        discount.style.fontWeight = "bold";
        discount.style.fontStyle = "italic";
        discount.innerHTML = jsonData.branchDiscount + "% off for reserving at this branch!";
        discount.innerHTML = discount.innerHTML.toUpperCase();

        //hidden input for the discount
        const discountInput = document.createElement("input");
        discountInput.type = "hidden";
        discountInput.id = "discountInput";

        discountInput.value = jsonData.branchDiscount;
        discount.appendChild(discountInput);

        discount.style.marginTop = "10px";

        //read only input for price without discount
        const priceWithoutDiscount = document.createElement("input");
        priceWithoutDiscount.type = "text";
        priceWithoutDiscount.id = "priceWithoutDiscount";
        priceWithoutDiscount.setAttribute("readonly", "");

        //textNode 
        const textNode = document.createTextNode("Price without Discount");
        
        const tempDiv = document.createElement("div");
        tempDiv.className = "reservation-price";
        tempDiv.appendChild(textNode);
        tempDiv.appendChild(priceWithoutDiscount);

        reservationPrice.parentNode.parentNode.insertBefore(tempDiv, reservationPrice.parentNode);

        //clear the reservation price
        const priceParent = reservationPrice.parentNode;
        priceParent.innerHTML = "";

        //new text node
        const newTextNode = document.createTextNode("The Price You are Paying");
        priceParent.appendChild(newTextNode);
        priceParent.appendChild(reservationPrice);
        priceParent.appendChild(discount);
    }
    
    const courtBtns = document.getElementsByClassName('courtBtn');
    const reserveBtn = document.getElementById("makeReserveBtn");   //make reservation button
    
    const selectedCourt = document.getElementById("selectedSportCourt");    //Selected Sports Court
    
    selectedCourt.value = courtBtns[0].innerHTML;   //at the start, the first court is the selected
    reserveBtn.value = courtBtns[0].id;
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
            selectedCourt.value = btn.innerHTML;
            reserveBtn.value = btn.id;  //assign selected court's id to reservation submit button's value 
        });
    }
}

function createReservationCell(innerText, timeDiff){   //create a reservation cell (need a function because it follows the same pattern for reservation, coaching, and maintenance)
    const cell = document.createElement("td");
    cell.rowSpan = timeDiff;
    cell.innerText = innerText;
    cell.classList.add("reserved");
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

        if(removingCell.rowSpan > 1){  //if the cell has a rowspan, we need to to increase the value of k by the rowspan for the next cell
            k += removingCell.rowSpan - 1;

            //change the parent to match the rowspan
            for(let l = 0; l < removingCell.rowSpan - 1; l++){
                currParent = currParent.nextSibling;
            }
        }
    }
    prevSibling.after(newCell);    //add the reservation cell after the sibling
}

function createMaintenanceCell(maintenanceObj, openingTime, closingTime, courtNum){
    let maintenance = maintenanceObj;
    if(typeof maintenance.startingDate === "string"){   //if the reservation is a string, it means that it is a stringified date object
        maintenance.startingDate = new Date(maintenance.startingDate);
        maintenance.endingDate = new Date(maintenance.endingDate);
    }

    let tempDate = new Date();  //we will use this to increment the date
    const startingTime = openingTime.substring(0,5);   //get the opening time
    const endingTime = closingTime.substring(0,5); //get the closing time

    const startingTimeObj = new Date(tempDate.getFullYear(), tempDate.getMonth(), tempDate.getDate(), startingTime.substring(0,2), startingTime.substring(3,5));
    startingTimeObj.setSeconds(0);
    const endingTimeObj = new Date(tempDate.getFullYear(), tempDate.getMonth(), tempDate.getDate(), endingTime.substring(0,2), endingTime.substring(3,5));
    endingTimeObj.setSeconds(0);

    const timeDiff = (endingTimeObj.getTime() - startingTimeObj.getTime()) / 1000 / 60/ 60; //get the time difference in hours (should be the no of hours the branch is open)

    for(let k = 0; k < maintenance.noOfDays; k++){ //for the maintenance period
        const tempDate = new Date(maintenance.startingDate);
        tempDate.setDate(maintenance.startingDate.getDate() + k);    //increment the date by 1
        const newCell = createReservationCell("Unable Due to Maintenance", timeDiff);   //create the cell
        const namingID = createCellID(courtNum, tempDate.toLocaleDateString(), startingTimeObj.toLocaleTimeString());
        newCell.classList.remove("reserved");
        newCell.classList.add("maintenance");

        newCell.id = namingID;

        const replacingCell = document.getElementById(namingID);
        if(replacingCell != null && replacingCell != undefined && replacingCell.innerHTML != "Unable Due to Maintenance"){
            replaceCell(replacingCell, newCell, startingTimeObj, tempDate.toLocaleDateString(), timeDiff, courtNum);
        }
    }
}

//we can export updateTheReservationTables, createScheduleObjects, and createReservationTable functions aswell to use them to update the table after a reservation is made

export {updateTheReservationTables, createScheduleObjects, createReservationSchedulePage, createReservationTable, createScheduleNavigation, createCellID};