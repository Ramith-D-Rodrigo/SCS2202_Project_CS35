const schedules = document.getElementsByClassName('court-schedule');

for(i = 1; i < schedules.length; i++){  //starting from 1 because we are going to ignore the 0th element
    schedules[i].style.display = 'none';
}


const courtBtns = document.getElementsByClassName('courtBtn');

const selectedCourt = document.getElementById("selectedSportCourt");    //Selected Sports Court

selectedCourt.value = courtBtns[0].innerHTML;   //at the start, the first court is the selected

for(i = 0; i < courtBtns.length; i++){

    const btn = document.getElementById(courtBtns[i].id);
    btn.addEventListener('click', ()=>{

        const allSchedules = document.getElementsByClassName('court-schedule'); //get all the schedule divs

        for(j = 0; j < allSchedules.length; j++){   //traver the divs
            allSchedules[j].style.display = 'none';   //remove the active attribute
        }

        const scheduleid = "court" + btn.id;    //get the pressed court's id
        const schedule = document.getElementById(scheduleid);   //get the element
        schedule.style.display = 'block';
        selectedCourt.value = btn.innerHTML;
    });
}