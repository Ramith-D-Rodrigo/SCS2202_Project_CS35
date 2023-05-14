fetch("../../controller/general/system_maintenance_notify_controller.php")
    .then(response => response.json())
    .then(data => {
        const systemNotifyDiv = document.getElementById("system-notify");
        const para = document.createElement("p");

        para.style.textAlign = "center";
        para.style.padding = "1rem";
    
        if(data != [] && data != null){
            let msg = "There will be a system maintenance on " + data.startingDate;
            msg += " at " + data.startingTime;
            msg += ". The expected downtime is " + data.expectedDowntime + ". Thank you for your patience.";

            para.innerHTML = msg;
            systemNotifyDiv.appendChild(para);
        }
    });