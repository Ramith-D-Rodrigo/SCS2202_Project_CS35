fetch("../../controller/receptionist/req_maintenance_entry_controller.php")  //this controller does the job
    .then(res => res.json())
    .then(data => {
        // console.log(data[0].sportName);
        const sportSelect = document.getElementById("sport");  //get the available sports details
        for(i = 0; i < data.length; i++){
            const option = document.createElement("option");
            option.value = data[i].sportID;
            option.innerHTML = data[i].sportName;
            option.value = data[i].sportID;
            sportSelect.appendChild(option);
        }
    });

const sportSelect = document.getElementById("sport");
sportSelect.addEventListener("change", (e) => {
    const sportID = document.getElementById("sportID");
    sportID.value = e.target.value;
});

const sportID = document.getElementById("sportID");
sportID.addEventListener("click", (e) => {
    if(sportID.value === ''){
        e.preventDefault();
    }
});