const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const courtDetails = parameters.get("requestDetails");  //get the discount details
const court = JSON.parse(courtDetails);   //parse and return javascript object
console.log(court);

const branch = document.getElementById("branch");
branch.value = court['branch'].city;
const manager = document.getElementById("manager");
manager.value = court['manager'].firstName.concat(" ", court['manager'].lastName);
const sport = document.getElementById("sport");
sport.value = court['sport'].sportName;
const existingCourts = document.getElementById("exCourts");
var flag = 0;
for(let i=0; i<court['existingCourts'].length; i++){
    if(court['existingCourts'][i].sportID == court['sport'].sportID && 
        court['existingCourts'][i].branchID == court['branch'].branchID){
            flag = 1; //there exists a court for this sport in this branch
            existingCourts.value += court['existingCourts'][i].Count;
    }else{
        continue;
    }
    existingCourts.value += court['existingCourts'][i].courtName.concat(" ");
}
if(flag == 0){
    existingCourts.value = "No courts exist";
}

const photos = document.getElementById("photos");
if(court.courtPhoto === null){
    const input = document.createElement('input');
    input.readOnly = true;
    input.value = "No photos uploaded";
    photos.appendChild(input);
}else{
    for(let i=0; i<court.courtPhoto.length; i++){
        const image = document.createElement('img');
        image.src = court.courtPhoto[i];
        image.style.width = "200px";
        image.style.height = "200px";
        photos.appendChild(image);
    }
}

const accept = document.getElementById("accept");
const decline = document.getElementById("decline");

function submitDecision(event){
    event.preventDefault();    //prevent the form from submitting in default way
    const decision = document.getElementById("decision");
    if(decision.value !== ""){
        var decisionInfo = null;
        if(event.target.value === "Accepted"){
            decisionInfo = {
                decision: "a",
                courtID: court.courtID
            }  
        }else{
            decisionInfo = {
                decision: "p",
                courtID: court.courtID
            } 
        }
        console.log(decisionInfo);
        fetch("../../controller/owner/handle_manager_request_controller.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(decisionInfo)   //convert the decision details object to JSON
        })
        .then((res) => res.json())
        .then((data) => {
            // console.log(data);
            if(data){
                const successMsg = document.getElementById("success-msg");
                successMsg.innerHTML = "Decision submitted successfully";
                accept.disabled = true;
                decline.disabled = true;
                setTimeout(function(){
                window.location.href = '../../public/owner/owner_dashboard.php';}, 3000);
            }else{
                errMsg = document.getElementById("err-msg");
                errMsg.innerHTML = "Error submitting decision";
            }
        })
        .then((err) => console.log(err));
    }
}

accept.addEventListener("click", submitDecision);
decline.addEventListener("click", submitDecision);