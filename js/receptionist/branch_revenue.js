import { addLeadingZeros, addDays } from "../FUNCTIONS.js";

//get current date
const todayStr = new Date().toLocaleDateString().split("/");
const today = todayStr[2] + "-" + addLeadingZeros(todayStr[0]) + "-" + addLeadingZeros(todayStr[1]);
const allRevenueTypes = ['all-revenue', 'reservation', 'coachingsession'];

const sportID = document.getElementById("sport-filter");
const fromDate = document.getElementById("from-date")
const toDate = document.getElementById("to-date");


let chart = null;

//set current date as max date for date input
document.getElementById("from-date").setAttribute("max", today);
document.getElementById("to-date").setAttribute("max", today);

//first get sport details (id and name for select option)
fetch("../../controller/receptionist/revenue_selection_controller.php")
    .then((response) => response.json())
    .then((data) => {
        //add sport name and id to select option
        data.forEach((sport) => {
            const option = document.createElement("option");
            option.value = sport.sportID;
            option.text = sport.sportName;
            sportID.appendChild(option);
        });

        //add event listener to select option
        sportID.addEventListener("change", showRevenue);
        fromDate.addEventListener("change", showRevenue);
        toDate.addEventListener("change", showRevenue);

        //add event listener to all revenue types
        allRevenueTypes.forEach((revenueType) => {
            document.getElementById(revenueType).addEventListener("change", showRevenue);
        });
    })
    .then(() => {
        //dispatch event for displaying revenue
        
        //set from date to 1 month before today
        const from = new Date();
        from.setMonth(from.getMonth() - 1);
        fromDate.value = from.getFullYear() + "-" + addLeadingZeros(from.getMonth() + 1) + "-" + addLeadingZeros(from.getDate());

        //set to date to today
        toDate.value = today;
        
        //dispatch event
        sportID.dispatchEvent(new Event("change"));

        window.addEventListener("resize", () => {
            if(chart instanceof Chart){
                chart.resize();
            }
        });

    });



const showRevenue = (e) => {
    //check if start date is before end date
    if (fromDate.value >= toDate.value) {
        return;
    }

    //check if start date or end date is in the future
    if(fromDate.value > today || toDate.value > today){
        return;
    }

    //create url params 
    const urlParams = new URLSearchParams();

    allRevenueTypes.forEach((revenueType) => {

        const val = document.getElementById(revenueType).checked;
        if(val){
            urlParams.append(revenueType, "true");  //need the revenue of this type
        }
        else{
            urlParams.append(revenueType, "false"); //don't need the revenue of this type
        }
    });

    urlParams.append("sportID", sportID.value);
    urlParams.append("fromDate", fromDate.value);
    urlParams.append("toDate", toDate.value);

    //fetch data from controller
    fetch("../../controller/receptionist/revenue_controller.php?" + urlParams)
        .then((response) => response.json())
        .then((revenueData) => {
            //create chart
            if(chart instanceof Chart){  //destroy old chart
                chart.destroy();
            }

            const ctx = document.getElementById("revenue").getContext("2d");

            //create labels
            let labels = [];
            
            //get labels from response data
            const keys = Array.from(Object.keys(revenueData));
            labels = Object.keys(revenueData[keys[0]]);


            chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "All Revenue",
                            data: revenueData.allrevenue,
                            backgroundColor: "rgba(255, 99, 132, 0.2)",
                            borderColor: "rgba(255, 99, 132, 1)",
                            borderWidth: 1,
                            tension: 0.25,
                            fill: true,
                        },

                        {
                            label: "Reservation",
                            data: revenueData.reservation,
                            backgroundColor: "rgba(54, 162, 235, 0.2)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1,
                            tension: 0.25,
                            fill: true,

                        },

                        {
                            label: "Coaching Session",
                            data: revenueData.coachingsession,
                            backgroundColor: "rgba(255, 206, 86, 0.2)",
                            borderColor: "rgba(255, 206, 86, 1)",
                            borderWidth: 1,
                            tension: 0.25,
                            fill: true,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });  
        });
}