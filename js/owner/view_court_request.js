const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const discountDetails = parameters.get("requestDetails");  //get the discount details
const discount = (discountDetails);//parse and return javascript object
// console.log(discount[0]);
var managerID = '';
var court = '';
fetch("../../controller/owner/view_manager_request_controller.php?btn=".concat(discount))
.then(res => res.json())
.then(data => {
    court = data[0];
    const branch = document.getElementById("branch");
    branch.value = data[3];
    const manager = document.getElementById("manager");
    manager.value = data[1].concat(" ",data[2]);
    const sport = document.getElementById("sport");
    sport.value = data[5].sportName;
    const existingCourts = document.getElementById("exCourts");
    
    
    if(data[4] == 0){
        existingCourts.value = "No courts exist";
    }else{
        existingCourts.value = data[4];
    }

    for(let i=6;i<data.length;i++){
        if(data[i].courtID == data[0]){
            managerID = data[i].addedManager;
            const photos = document.getElementById("photos");
            if(data[i].courtPhoto === null){
                const input = document.createElement('input');
                input.readOnly = true;
                input.value = "No photos uploaded";
                photos.appendChild(input);
            }else{
                for(let j=0; j<data[i].courtPhoto.length; j++){
                    const image = document.createElement('img');
                    image.src = data[i].courtPhoto[j];
                    image.style.width = "200px";
                    image.style.height = "200px";
                    photos.appendChild(image);
                }
            }
        }
       
    }
    
})


const accept = document.getElementById("accept");
const decline = document.getElementById("decline");

function submitDecision(event){
    event.preventDefault();    //prevent the form from submitting in default way
    const decision = document.getElementById("decision");
    if(decision.value !== ""){
        var decisionInfo = null;
        if(event.target.value === "Accepted"){
            decisionInfo = {
                manager : managerID,
                decision : 'a',
                desc: decision.value,
                courtID: court
            }  
        }else{
            decisionInfo = {
                manager : managerID,
                decision : 'd',
                desc: decision.value,
                courtID: court
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