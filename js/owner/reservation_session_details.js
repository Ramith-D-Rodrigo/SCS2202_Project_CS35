import { disableElementsInMain, enableElementsInMain } from "../FUNCTIONS.js";
import { currency } from "../CONSTANTS.js";

const cellandReservationMap = new Map();
//open the reservation details

const coachDetails = document.querySelector("#coachDetails");
const userDetails = document.querySelector("#userDetails");

const openReservationDetails = (e) => {
    e.stopPropagation();
    const reservationCellID = e.target.id;
    const reservationDetails = cellandReservationMap.get(reservationCellID);

    const main = document.querySelector("main");
    disableElementsInMain(main);
    main.style.opacity = "0.5";

    //disable reservation cells
    const reservationCells = document.querySelectorAll(".reserved");
    reservationCells.forEach(cell => {
        cell.style.pointerEvents = "none";
    });

    main.addEventListener("click", function mainClick(){
        enableElementsInMain(main);
        main.style.opacity = "1";
        main.removeEventListener("click", mainClick);

        coachDetails.classList.remove("show");
        userDetails.classList.remove("show");

        //enable reservation cells
        reservationCells.forEach(cell => {
            cell.style.pointerEvents = "auto";
        });
    });
        
    if(reservationDetails[0] === "reservation"){
        openUserReservationDetails(reservationDetails[1])
    }
    else{
        openCoachingSessionDetails(reservationDetails[1]);
    }
}

const openUserReservationDetails = (reservationID) => {
    const urlParams = new URLSearchParams();
    urlParams.append("reservationID", reservationID);
    urlParams.append("type", "userReservation")

    fetch("../../controller/owner/specific_reservation_session_details_controller.php?" + urlParams)
        .then(res => res.json())
        .then(data => {
            //add user image if available
            if(data.userDetails.profilePhoto !== undefined){
                document.querySelector("#userImg").src = data.userDetails.profilePhoto;
            }

            
            //add user contact number
            const contactVal = document.querySelector("#userContactNum");

            //add user name
            const username = document.querySelector("#userName");
            if(data.userDetails.reservationHolder !== undefined){   //onsite reservation
                username.value = data.userDetails.reservationHolder;
                contactVal.value = data.userDetails.contactNumber;
                
            }
            else{ //online reservation
                username.value = data.userDetails.firstName + " " + data.userDetails.lastName;
                contactVal.value = data.userDetails.contactNum;
                //check gender and add it to the user name
                if(data.userDetails.gender == 'm'){
                    username.value = "Mr. " + username.value;
                }
                else{
                    username.value = "Ms. " + username.value;
                }
            }

            //reserved timestamp
            document.querySelector("#timestamp").value = data.reservedDate;

            //attending count
            document.querySelector("#peopleCount").value = data.noOfPeople;

            //payment amount
            document.querySelector("#payment").value = currency + " " + parseFloat(data.paymentAmount).toFixed(2);

            //reservation status
            document.querySelector("#status").value = data.status;

            //display the details
            userDetails.classList.add("show");
        })

}

const openCoachingSessionDetails = (sessionID) => {
    const urlParams = new URLSearchParams();
    urlParams.append("sessionID", sessionID);
    urlParams.append("type", "coachingSession");

    fetch("../../controller/owner/specific_reservation_session_details_controller.php?" + urlParams)
        .then(res => res.json())
        .then(data => {
            //add coach image
            document.querySelector("#coachImg").src = data.coachDetails.profilePhoto;

            //add coach name
            const coachName = document.querySelector("#coachName");

            coachName.value = data.coachDetails.name;

            //add gender
            if(data.coachDetails.gender == 'm'){
                coachName.value = "Mr. " + coachName.value;
            }
            else{
                coachName.value = "Ms. " + coachName.value;
            }

            //add coach contact number
            document.querySelector("#coachContactNum").value = data.coachDetails.contactNum;

            //coach monthly payment
            document.querySelector("#monthlyPayment").value = currency + " " + parseFloat(data.coachMonthlyPayment).toFixed(2);

            //current number of students
            document.querySelector("#noOfStudents").value = data.noOfStudents;

            //student payment amount
            document.querySelector("#studentPayment").value = currency + " " + parseFloat(data.paymentAmount).toFixed(2);

            //session start date
            document.querySelector("#sessionStartDate").value = data.startDate;

            //session cancellation date
            if(data.cancelDate !== null && data.cancelDate !== undefined){
                document.querySelector("#sessionCancelDate").value = data.cancelDate;
            }

            //display the popup
            coachDetails.classList.add("show");
        });
    
}


export {openReservationDetails, cellandReservationMap}