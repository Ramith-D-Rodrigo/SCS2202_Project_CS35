const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const userProfile = parameters.get("userProfile");
// console.log(userProfile);

fetch("../../controller/receptionist/view_sProfile_controller.php?userID=".concat(userProfile))
    .then((res)=>res.json())
    .then((data)=>{
        // console.log(data);
        if(data[0]['errMsg'] !== undefined){   //no such user
            const searchError = document.getElementById("searchError");
            const searchErrorDiv = document.createElement("div");
            searchErrorDiv.className = "search_err-msg";
            searchErrorDiv.id = "search_err-msg";
            searchErrorDiv.innerHTML = data[0]['errMsg'];
            searchError.appendChild(searchErrorDiv);
        }else{
            const img = document.createElement("img");
            const imgDiv = document.getElementById("profilePic");
            img.className = "branch-img";
            img.style.verticalAlign = "middle";
            if(data[0].profilePhoto === null){
                img.src = "/styles/icons/profile_icon.svg";
            }else{
                img.src = "/styles/icons/profile_icon.svg";
            }
            imgDiv.appendChild(img);
            const nameOut = document.getElementById("name");           
            nameOut.setAttribute("readonly", "readonly");
            nameOut.value = data[0].firstName + " " + data[0].lastName;
            const genderOut = document.getElementById("gender");
            genderOut.setAttribute("readonly", "readonly");
            if(data[0].gender==="m"){
                genderOut.value = "Male";
            }else{
                genderOut.value = "Female";
            }
            const bdayOut = document.getElementById("bday");
            bdayOut.setAttribute("readonly", "readonly");
            bdayOut.value = data[0].birthday;

            const contactNOut = document.getElementById("contactN");
            contactNOut.setAttribute("readonly", "readonly");
            contactNOut.value = data[0].contactNum;

            const addressDiv = document.getElementById("address");
            addressDiv.value = data[0].homeAddress;

            const weightOut = document.getElementById("weight");
            weightOut.setAttribute("readonly", "readonly");
            if(data[0].weight===null){
                weightOut.value = "Not mentioned";
            }else{
                weightOut.value = data[0].weight+" kg";
            
            }

            const heightOut = document.getElementById("height");
            heightOut.setAttribute("readonly", "readonly");
            if(data[0].height===null){
                heightOut.value = "Not mentioned";
            }else{
                heightOut.value = data[0].height+" cm";
            }
            
            const selectEName = document.getElementById("eName");
            const defaultOption = document.createElement("option");
            defaultOption.innerHTML = "Choose One...";
            defaultOption.value = "";
            selectEName.appendChild(defaultOption);
            
            for(j = 0; j < data[2].length; j++){   
                const nameOption = document.createElement("option");
                nameOption.innerHTML = data[2][j].name;
                nameOption.value = data[2][j].name;
                selectEName.appendChild(nameOption);
            }
            
            const medConcernDiv = document.getElementById("medicalConcerns");
            if(data[1].length===0){
                const medConcernOut = document.createElement("input");
                medConcernOut.setAttribute("readonly", "readonly");
                medConcernOut.value = "No medical concerns mentioned";
                medConcernDiv.appendChild(medConcernOut);
            }else{
                for(i = 0; i < data[1].length; i++){
                    const medConcernOut = document.createElement("input");
                    medConcernOut.className = "right-side-multiples";
                    medConcernOut.setAttribute("readonly", "readonly");
                    medConcernOut.value = data[1][i].medicalConcern;
                    medConcernDiv.appendChild(medConcernOut);
                }
            } 
        }
    });

    const depenedentN = document.getElementById("eName");
    depenedentN.addEventListener("change", (e) => {
        if(e.target.value !== ""){
            fetch("../../controller/receptionist/dependentInfo_controller.php?userID=".concat(userProfile, "&name=", e.target.value))
            .then((res)=>res.json())
            .then((data)=>{
                // console.log(data);
                if(data[0]['errMsg'] !== undefined){   //not any dependent
                    const searchError = document.getElementById("searchError");
                    const searchErrorDiv = document.createElement("div");
                    searchErrorDiv.className = "search_err-msg";
                    searchErrorDiv.id = "search_err-msg";
                    searchErrorDiv.innerHTML = data[0]['errMsg'];
                    searchError.appendChild(searchErrorDiv);
                }else{
                    const eRelationship = document.getElementById("eRelationship");
                    eRelationship.innerHTML = data[0].Relationship;
                    const eContactN= document.getElementById("eContactN");
                    eContactN.innerHTML = data[0].contactN;
                }
            });
        }else{
            const eRelationship = document.getElementById("eRelationship");
            eRelationship.innerHTML = "";
            const eContactN= document.getElementById("eContactN");
            eContactN.innerHTML = "";
        }
    });
