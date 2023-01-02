const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const getReq = params.get("reserveBtn");
//console.log(getReq);

let schedulesArr = [];  //array to store the reservation info of each court

//import the functions from the other js files
import {createReservationSchedulePage} from '../general/reservation_schedule_functions.js';

//store in window object so that we can access it from other js files
window.createReservationSchedulePage = createReservationSchedulePage;

fetch("../../controller/general/reservation_schedule_controller.php?reserveBtn=".concat(getReq))
    .then(res => res.json())
    .then(data => createReservationSchedulePage(data));