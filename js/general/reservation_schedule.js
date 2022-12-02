const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const getReq = params.get("reserveBtn");
//console.log(getReq);

fetch("../../controller/general/reservation_schedule_controller.php?reserveBtn=".concat(getReq))
    .then(res => res.json())
    .then(data => createReservationSchedulePage(data));


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

function createScheduleObjects(jsonData){   //function to create objects to all the reservations
    const allScheduleDetailsDiv = document.getElementById("allScheduleDetails");

    let schedulesArr = [];  //array to store the reservation info of each court

    for(var key in jsonData.branch_reservation_schedule){   //to create the buttons and store reservation details
        const courtBtn = document.createElement("button");
        courtBtn.className = "courtBtn";
        courtBtn.id = key;
        courtBtn.innerHTML = "Court " + jsonData.branch_reservation_schedule[key].courtName;

        const navBtnsDiv = document.getElementById("scheduleNavBtns");
        allScheduleDetailsDiv.insertBefore(courtBtn, navBtnsDiv); //append the buttons before the nav buttons

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
                timeDiff : (((endingTimeDateObj - startingTimeDateObj)/1000)/60)/30    //time difference in 30 min slots
            };
    
            currCourtReservations.push(userReservation);
            
        }
        schedulesArr.push(currCourtReservations);

        //create divs for reservation tables
        const courtScheduleDiv = document.createElement("div");
        courtScheduleDiv.className = "court-schedule";
        courtScheduleDiv.id = "court" + key;
        allScheduleDetailsDiv.appendChild(courtScheduleDiv);    //append it
    }
    return schedulesArr;

}

function createReservationTable(schedules, scheduleObjs, jsonData){
    //creating the reservation schedule table
        
    //creating schedule tables    
    const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    
    const branchOpeningTime = jsonData.opening_time.split(":");   //branch opening time
    const branchClosingTime = jsonData.closing_time.split(":");   //branch closing time
    //console.log(branchOpeningTime, branchClosingTime);
    
    for(i = 0; i < scheduleObjs.length; i++){
        const table = document.createElement("table");  //initial table
        const tableRow = table.insertRow();
        const tableCell = tableRow.insertCell();    //first empty cell
    
    
    /*     for(j = 0;  j < weekdays.length; j++){   //adding days to the header of the table
            const weekdayTab = tableRow.insertCell();
            weekdayTab.innerHTML = weekdays[j];
            
        } */
        let reservationCells = [];
        let datesWithReservations = []; //array to store the dates that has reservations
    
        for(j = 0; j < scheduleObjs[i].length; j++){
            const res = scheduleObjs[i][j];
            const resDate = res.startingTime.toISOString().split("T")[0];
    
            if(!Object.keys(datesWithReservations).includes(resDate)){ //current Reservation is not in the datesWithReservation (first reservation that is found for that date)
                const resHead = tableRow.insertCell();
                resHead.innerText = resDate;
                datesWithReservations[resDate] = [res];   //add the date and the corresponding reservation to the array
            }
            else{
                datesWithReservations[resDate].push(res);   //add the reservation of same date to the array
            }
    
            const cell = document.createElement("td");
            cell.rowSpan = res.timeDiff;
            cell.innerText = "Reserved";
            cell.style.backgroundColor = "Red";
            cell.style.color = "white";
            cell.style.borderRadius = "10px";
            cell.id = i + "," + resDate + "," + res.startingTime.toLocaleTimeString() + "," + res.endingTime.toLocaleTimeString();
            reservationCells[i + "," + resDate + "," + res.startingTime.toLocaleTimeString() + "," + res.endingTime.toLocaleTimeString()] = cell;  //key is => "Court , Reservation Date, Starting Time, Ending Time"
        }
        //console.log(datesWithReservations);
    
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
    
            currTime.setMinutes(currTime.getMinutes() + 30);    //append time period by 30 minutes
    
            const periodEndPrint = currTime.toLocaleTimeString();
            const periodEndCompare = currTime.toTimeString();
    
            tableRow.id = i + "," + periodStartPrint + "," + periodEndPrint;
    
            timePeriod.innerText = periodStartPrint + " - " + periodEndPrint;
    
            for(let key in datesWithReservations){    //adding the reservation to the table
                //console.log(cell.cellIndex);
                const cell = tableRow.insertCell();
    
                cell.id = i + "," + key  + "," + periodStartPrint + "," + periodEndPrint;  //unique cell id
                //console.log(cell.id.length + " " + cell.id);
            }
    
        }
        
        schedules.item(i).appendChild(table);
    
        for(cell in reservationCells){
            const temp = cell.split(",");
            const searchingCellID = temp[0] + "," + temp[1] + "," + temp[2];    // court, date, starting_time
            //console.log("Finding the time slot for : " + searchingCellID);
    
            const insertingCell = document.querySelector('[id^="'+searchingCellID+'"]');    //get the cell
            //console.log("FOUND : " + insertingCell);
    
            const rowSpan = reservationCells[cell].rowSpan; //get the rowSpan
    
            const row = insertingCell.parentNode;
            //console.log("His parent : " + row);
    
            const cellIndex = insertingCell.cellIndex;
            //console.log("Cell Index :" + cellIndex);
    
            insertingCell.style.backgroundColor = "red";    //color the first block
            insertingCell.innerText = "Reserved";
            insertingCell.style.color = "white";
    
            var m = 1;
            var traversingRow = row;
            while(m < rowSpan){ //remove the spanning extra cells
                var sibling = traversingRow.nextSibling;
                //console.log("Sibling is : " + sibling);
                //console.log("Removing : " + sibling.childNodes.item(cellIndex).id);
    
                sibling.childNodes.item(cellIndex).style.backgroundColor = "red";   //color the sibling cells
                sibling.childNodes.item(cellIndex).innerText = "Reserved";
                sibling.childNodes.item(cellIndex).style.color = "white";
                //sibling.removeChild(sibling.childNodes.item(cellIndex));    //remove the child at the same column
                traversingRow = sibling;    //next row
                m++;
            }
    
            //row.replaceChild(reservationCells[cell], insertingCell);
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
    
    //court button to display the schedule of each court when pressed
    for(i = 0; i < courtBtns.length; i++){
    
        const btn = document.getElementById(courtBtns[i].id);
        btn.addEventListener('click', ()=>{
    
            const allSchedules = document.getElementsByClassName('court-schedule'); //get all the schedule divs
    
            for(j = 0; j < allSchedules.length; j++){   //traverse the divs
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

function createReservationSchedulePage(jsonData){
    console.log(jsonData);
    //first we insert the data we got from the server into the html 
    addReservationInformation(jsonData);

    //creating the schedules
    const schedulesArr = createScheduleObjects(jsonData);

    console.log(schedulesArr);

    const schedules = document.getElementsByClassName('court-schedule');

    for(i = 1; i < schedules.length; i++){  //starting from 1 because we are going to ignore the 0th element
        schedules[i].style.display = 'none';
    }
    
    createReservationTable(schedules, schedulesArr, jsonData);
    //make reservation box
    makeReservationBox(jsonData);
}


