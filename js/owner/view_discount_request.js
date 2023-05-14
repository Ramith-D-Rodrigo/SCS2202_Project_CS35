const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const discountDetails = parameters.get("requestDetails");  //get the discount details
const discount = (discountDetails);//parse and return javascript object
// console.log(discount[0]);

var managerID = '';
var startingDate = '';
fetch("../../controller/owner/view_manager_request_controller.php?btn=".concat(discount))
.then(res => res.json())
.then(data => {
    console.log(data);
    startingDate = data[0];
    for(let i=4;i<data.length;i++){
        if(data[0] === data[i]['startingDate']){
            const branch = document.getElementById("branch");
            branch.value = data[3];
            const manager = document.getElementById("manager");
            manager.value = data[1].concat(" ", data[2]);
            managerID = data[i].managerID;
            const discountValue = document.getElementById("discount");
            discountValue.value = "Rs. ".concat(data[i]['discountValue']);
            const startingDate = document.getElementById("sDate");
            startingDate.value = data[i].startingDate;
            const endingDate = document.getElementById("eDate");
            endingDate.value = data[i].endingDate;
        }
    }
    
});


const accept = document.getElementById("accept");
const decline = document.getElementById("decline");

function submitDecision(event){
    event.preventDefault();    //prevent the form from submitting in default way
    const decision = document.getElementById("decision");
    if(decision.value !== ""){
        var decisionInfo = null;
        if(event.target.value === "Accepted"){
            decisionInfo = {
                decision: 'a',
                desc: decision.value,
                manager: managerID,
                startingDate: startingDate
            }  
        }else{
            decisionInfo = {
                decision: 'p',
                desc: decision.value,
                manager: managerID,
                startingDate: startingDate
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