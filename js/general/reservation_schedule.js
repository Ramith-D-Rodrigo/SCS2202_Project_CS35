const schedules = document.getElementsByClassName('court-schedule');

for(i = 1; i < schedules.length; i++){  //starting from 1 because we are going to ignore the 0th element
    schedules[i].style.display = 'none';
}


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


//creating the reservation schedule table

let schedulesArr = [];  //array to store the reservation info of each court

//getting the reservation information
for(i = 0; i < schedules.length; i++){
    const reservationInfo = schedules.item(i).getElementsByClassName("reservationInfo");    //get reservations of each court schedule
    //console.log(reservationInfo);

    let currCourtReservations = Array();

    for(j = 0; j < reservationInfo.length; j++){    //access the information of each reservation
        const resDate = reservationInfo.item(j).children.item(0).innerHTML.split("-"); //0th index is date
        const startingTime = reservationInfo.item(j).children.item(1).innerHTML.split(":"); //1st index is starting time
        const endingTime = reservationInfo.item(j).children.item(2).innerHTML.split(":"); //2nd index is ending time

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
}

//console.log(schedulesArr);

//creating schedule tables 

const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

const branchOpeningTime = document.getElementById("reserveStartingTime").getAttribute("min").split(":");   //branch opening time
const branchClosingTime = document.getElementById("reserveEndingTime").getAttribute("max").split(":");     //branch closing time
//console.log(branchOpeningTime, branchClosingTime);

for(i = 0; i < schedulesArr.length; i++){
    const table = document.createElement("table");  //initial table
    const tableRow = table.insertRow();
    const tableCell = tableRow.insertCell();    //first empty cell

/*     for(j = 0; j < weekdays.length; j++){   //adding days to the header
        const currDay = document.createElement("th");
        currDay.innerHTML = weekdays[j];
        tableRow.appendChild(currDay);
    } */
    let reservationCells = [];
    let datesWithReservations = []; //array to store the dates that has reservations

    for(j = 0; j < schedulesArr[i].length; j++){
        const res = schedulesArr[i][j];
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
        reservationCells[i + "," + resDate + "," + res.startingTime.toLocaleTimeString()] = cell;  //key is => "Court , Reservation Date, Starting Time"
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
/*             const resOnThatDate = datesWithReservations[key];
            //console.log(currRes);
            //const currResDate = currRes.startingTime.toISOString().split("T")[0];

            //get the time in hours format
            const reservations = resOnThatDate.map(i => [i.startingTime.toTimeString(), i.endingTime.toTimeString()]); //map it to pairs

            //console.log(currResST, currResET);

            if(reservations.map(i => i[0]).includes(periodStartCompare)){  //found the reservation starting point
                //console.log(key + " " + periodStartPrint);
                tableRow.appendChild(reservationCells[key + " " + periodStartPrint]);
            }
            else if(true){    //within a reservation block
                continue;   //do not enter any cell
            }
            else{
                const cell = tableRow.insertCell();
            } */
            //console.log(cell.cellIndex);
            const cell = tableRow.insertCell();

            cell.id = i + "," + key  + "," + periodStartPrint;  //unique cell id
            //console.log(cell.id.length + " " + cell.id);
        }

    }

    schedules.item(i).appendChild(table);

    for(cell in reservationCells){
        const insertingCell = document.getElementById(cell);
        const row = insertingCell.parentNode;
        reservationCells[cell].id = insertingCell.id;
        const cellID = insertingCell.cellIndex;
        row.replaceChild(reservationCells[cell], insertingCell);

        const rowSpan = reservationCells[cell].rowSpan;
        var i = 1;
        var curRow = row;

        while(i < rowSpan){
            const sibling = curRow.nextSibling;
            console.log(sibling.childNodes.item(cellID));
            sibling.removeChild(sibling.childNodes.item(cellID));
            curRow = sibling;
            i++;
        }
    }
}
