const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const branch = parameters.get("branchID");

fetch("../../controller/system_admin/view_branch_request_controller.php?branchID=".concat(branch))
    .then(res => res.json())
    .then(data => {
        // console.log(data[1][0]);
        if(data[0]['errMsg'] !== undefined){
            const errorDiv = document.getElementById("err-msg");
            errorDiv.className = "content-box";
            const searchError = document.createElement("div");
            searchError.className = "no-result";
            searchError.id = "no-result";
            searchError.innerHTML = data[0]['errMsg'];
            errorDiv.appendChild(searchError);
        }else{
            const branchID = document.getElementById("branchID");
            branchID.value = branch;
            const requestDate = document.getElementById("date");
            requestDate.value = data[0].ownerRequestDate;
            const location = document.getElementById("city");
            location.value = data[0].city;
            const address = document.getElementById("address");
            address.value = data[0].address;
            const eAddress = document.getElementById("emailAddress");
            eAddress.value = data[0].branchEmail;
            const openingTime = document.getElementById("openTime");
            openingTime.value = data[0].openingTime;
            const closingTime = document.getElementById("closeTime");
            closingTime.value = data[0].closingTime;
            const contactNum = document.getElementById("contactNum");
            contactNum.value = "Not Assigned Yet";
            const sportOptions = document.getElementById("sports");
            sportNames = [];
            occurrences = {};
            for(i=1;i<data.length;i++){    //store the sport names in an array
                sportNames[i-1] = data[i].sportName;   
            }
            for (var i = 0; i < sportNames.length; i++) {
                var sportName = sportNames[i];
                if (occurrences[sportName]) {   //store the occurences of the same sport
                    occurrences[sportName]++;
                } else {
                    occurrences[sportName] = 1;
                }
            }
            for (var sport in occurrences) {
                const opt = document.createElement("option");
                opt.value = occurrences[sport];     //store the court count in the value attribute
                opt.innerHTML = sport;
                sportOptions.appendChild(opt);
            }
                
        }
    });

    const selectedSport = document.getElementById("sports");
    selectedSport.addEventListener("change",(e) => {
        const courtCount = document.getElementById("courts");
        if(e.target.value !== ''){
            courtCount.value = e.target.value;
        }else{
            courtCount.value = '';
        }
    });