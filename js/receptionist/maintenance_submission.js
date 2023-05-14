const reason = document.getElementById("reason");
const sportName = document.getElementById("sportName");
const courtName = document.getElementById("courtName");
const startDate = document.getElementById("sDate");
const endDate = document.getElementById("eDate");
const successMsg = document.getElementById("successMsg");
const errMsg = document.getElementById("errMsg");
const overlay = document.getElementById("overlay");

function submitRequest(){

    const request = {
    reason: reason.value,
    sport: sportName.value,
    court: courtName.value,
    start: startDate.value,
    end: endDate.value
    };

    fetch("../../controller/receptionist/req_maintenance_controller.php",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(request)
    })
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        if(!data['Flag']){
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            successMsg.style.display = "block";
            successMsg.innerHTML = data['Message'];
            overlay.style.display = "block";
            
            setTimeout(function(){
                location.reload();
            },3000);
        }else{
            errMsg.style.color = "red";
            errMsg.style.textAlign = "center";
            errMsg.innerHTML = data['Message'];
        }
    });
}



