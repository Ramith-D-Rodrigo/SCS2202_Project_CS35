fetch("../../controller/receptionist/req_maintenance_entry_controller.php")  //this controller does the job
    .then(res => res.json())
    .then(data => {
        // console.log(data[0].sportName);
        const sportSelect = document.getElementById("sport");  //get the available sports details
        let sportName = [];
        for(i = 0; i < data.length; i++){
            if(!sportName.includes(data[i]['Sport'].sportName)){
                sportName.push(data[i]['Sport'].sportName)
                const option = document.createElement("option");
                option.value = data[i]['Sport'].sportID;
                option.innerHTML = data[i]['Sport'].sportName;
                sportSelect.appendChild(option);
            }
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