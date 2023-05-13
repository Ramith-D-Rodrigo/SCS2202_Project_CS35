import {MAX_RESERVATION_TIME_HOURS} from '../CONSTANTS.js';

const timeValidation = (inputValue) => {
    //function to validate time input not to have minutes, only hours
    const timeArr = inputValue.split(':');
    if(timeArr[1] == '00'){
        return true;
    }else{
        return false;
    }
}

const formHandle = (form) => {
    //check the openingtime
    const openingTime = form.querySelector('#openingTime');
    openingTime.classList.remove('error');
    if(!timeValidation(openingTime.value)){ //opening time has minutes
        openingTime.classList.add('error');
        return [false, "Opening time should be in hours only"];
    }

    //check the closing time
    const closingTime = form.querySelector('#closingTime');
    closingTime.classList.remove('error');
    if(!timeValidation(closingTime.value)){ //closing time has minutes
        closingTime.classList.add('error');
        return [false, "Closing time should be in hours only"];
    }

    const openHour = parseInt(openingTime.value.split(':')[0]);
    const closeHour = parseInt(closingTime.value.split(':')[0]);

    if(openHour >= closeHour){  //opening time is greater than closing time
        openingTime.classList.add('error');
        closingTime.classList.add('error');
        return [false, "Closing time should be greater than opening time"];
    }

    if(closeHour - openHour <= MAX_RESERVATION_TIME_HOURS){ //closing time - opening time is less than or equal to the maximum reservation time
        openingTime.classList.add('error');
        closingTime.classList.add('error');
        return [false, "Closing time should be greater than opening time by at least " + MAX_RESERVATION_TIME_HOURS + " hours"];
    }

    //check the sports
    const sports = form.querySelectorAll('input[type="checkbox"]:checked');

    //if no sports are selected
    if(sports.length == 0){
        return [false, "Please select at least one sport"];
    }

    return [true, ""];
}


export {formHandle};