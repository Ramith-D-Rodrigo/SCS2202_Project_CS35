const searchError = document.getElementById("errMsg");
var sportDetails = [];
fetch("../../controller/receptionist/req_maintenance_entry_controller.php")    //call the controller
    .then((res) => res.json())
    .then((data) => {
        searchError.innerHTML = "";   //empty the error message div
        sportDetails = data;   //for the event listener
        console.log(data);
        if(data[0]['errMsg'] !== undefined){   //no sport was found
            const searchErrorDiv = document.createElement("div");
            searchErrorDiv.className = "search_err-msg";
            searchErrorDiv.id = "search_err-msg";
            searchErrorDiv.innerHTML = data[0]['errMsg'];
            searchError.appendChild(searchErrorDiv);
        }  
        else{
            const sportOptions = document.getElementById("sportName"); //getting the sportName select element
            const emptyOption = document.createElement("option");  //adding the ALL option
            emptyOption.value = "";
            emptyOption.innerHTML = "Select a sport";
            sportOptions.appendChild(emptyOption);
            uniqueSports = [];
            for(i = 0; i < data.length; i++){   //for each branch result
                if(!uniqueSports.includes(data[i]['Sport'].sportName)){   //append only the unique sports
                    uniqueSports.push(data[i]['Sport'].sportName);
                    const option = document.createElement("option");
                    option.value = data[i]['Sport'].sportName;
                    option.innerHTML = data[i]['Sport'].sportName;
                    sportOptions.appendChild(option);
                }   
            }
            const option = document.createElement("option");  //adding the ALL option
            option.value = "ALL";
            option.innerHTML = "ALL";
            sportOptions.appendChild(option);
        }
    });

const selectedSport = document.getElementById("sportName");
const courtOptions = document.getElementById("courtName"); //getting the courtName select element
selectedSport.addEventListener("change", (e) => {
    if(e.target.value !== "ALL" && e.target.value !== ""){
        searchError.innerHTML = "";   //empty the error message div
        if(sportDetails[0]['errMsg'] !== undefined){   //no court was found
            const searchErrorDiv = document.createElement("div");
            searchErrorDiv.className = "search_err-msg";
            searchErrorDiv.id = "search_err-msg";
            searchErrorDiv.innerHTML = sportDetails[0]['errMsg'];
            searchError.appendChild(searchErrorDiv);
        }  
        else{
            courtOptions.innerHTML = "";    //empty the select element
            for(i = 0; i < sportDetails.length; i++){   //for each branch result
                if(sportDetails[i]['Sport'].sportName === e.target.value){
                    const option = document.createElement("option");
                    option.value = sportDetails[i].Court;
                    option.innerHTML = sportDetails[i].Court;
                    courtOptions.appendChild(option);
                } 
            }
        }
    }else if(e.target.value === "ALL"){
        courtOptions.innerHTML = "";    //empty the select element
        const option = document.createElement("option");  //adding the ALL option
        option.value = "ALL";
        option.innerHTML = "ALL";
        courtOptions.appendChild(option);
    }else{
        courtOptions.innerHTML = "";    //empty the select element
    }
    
});
