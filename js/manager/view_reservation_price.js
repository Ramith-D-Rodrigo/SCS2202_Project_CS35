fetch("../../controller/manager/reservationprice_controller.php")
    .then(res => res.json())
    .then(data => {
        const reservationpriceInput = document.getElementById("OpenTime");
        openingTimeInput.value = data.openingTime;

        

    const time1 = new Date();
    const time2 = new Date();
    const openingTimeArr = data.openingTime.split(":");
    time1.setHours(openingTimeArr[0]);
    time1.setMinutes(openingTimeArr[1]);
    time1.setSeconds(0);
    console.log(time1);

    const closingTimeArr = data.closingTime.split(":");
    time2.setHours(closingTimeArr[0]);
    time2.setMinutes(closingTimeArr[1]);
    time2.setSeconds(0);
    console.log(time2);

    const timeDiff = (((time2 - time1)/1000)/60)/60;
    console.log(timeDiff);
// Convert the time difference to days

// Display the result
// console.log(`The time duration between ${time1} and ${time2} is ${hoursDiff} days`);
const openingDuration = document.getElementById("Duration");
openingDuration.value = timeDiff + " Hours";

    })