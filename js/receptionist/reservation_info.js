const location = document.getElementById("branchLoc");
const sport = document.getElementById("sport");
const sportCourt = document.getElementById("sportCourt");
const startingTime = document.getElementById("startT");
const endingTime = document.getElementById("endT");
const peopleCount = document.getElementById("peopleCount");
const reservationDate = document.getElementById("resDate");
const holderName = document.getElementById("name");
const contactNum = document.getElementById("contactNum");
const fee = document.getElementById("resFee");
const recepID = document.getElementById("recID");
const resID = document.getElementById("resID");
const branchNum = document.getElementById("branchNum");
const generatedTime = document.getElementById("time");
const fullBranchAddress = document.getElementById("fullBranchAddress");
const emailAddress= document.getElementById("emailAddress");

fetch("../../controller/receptionist/basic_payment_info_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        var formData = JSON.parse(localStorage.getItem("formData"));  /*get the reservation details using localStorage
                                                converts the json string into an object */
        console.log(formData);
        
        recepID.innerHTML = data['receptionist']['userID'];
        resID.innerHTML = data['reservationID'];
        holderName.innerHTML = formData.name;
        contactNum.innerHTML = formData.contactNumber;
        formData.reservationID = resID.innerHTML;
        formData.receptionistID = recepID.innerHTML;
        localStorage.setItem("formData", JSON.stringify(formData));
        location.innerHTML = formData.branch;
        branchNum.innerHTML = data['receptionist']['contactNum'];
        generatedTime.innerHTML = new Date().toLocaleString();
        sport.innerHTML = formData.sport;
        sportCourt.innerHTML = formData.sportCourt;
        startingTime.innerHTML = formData.reservingStartTime;
        endingTime.innerHTML = formData.reservingEndTime;
        peopleCount.innerHTML = formData.numOfPeople;
        reservationDate.innerHTML = formData.reservingDate;
        fee.innerHTML = fee.innerHTML+formData.reservationFee+"/=";
        fullBranchAddress.innerHTML = data['branch']['address'];
        emailAddress.innerHTML = data['branch']['branchEmail'];    
    });



