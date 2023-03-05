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
        return false;
    }

    //check the closing time
    const closingTime = form.querySelector('#closingTime');
    closingTime.classList.remove('error');
    if(!timeValidation(closingTime.value)){ //closing time has minutes
        closingTime.classList.add('error');
        return false;
    }

    const openHour = parseInt(openingTime.value.split(':')[0]);
    const closeHour = parseInt(closingTime.value.split(':')[0]);

    if(openHour >= closeHour){  //opening time is greater than closing time
        openingTime.classList.add('error');
        closingTime.classList.add('error');
        return false;
    }

    if(closeHour - openHour <= MAX_RESERVATION_TIME_HOURS){ //closing time - opening time is less than or equal to the maximum reservation time
        openingTime.classList.add('error');
        closingTime.classList.add('error');
        return false;
    }

    //check the sports
    const sports = form.querySelectorAll('input[type="checkbox"]:checked');

    //if no sports are selected
    if(sports.length == 0){
        return false;
    }

    return true;
}


export {formHandle};