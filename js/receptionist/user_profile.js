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
            const nameDiv = document.getElementById("name");
            const nameOut = document.createElement("output");
            nameOut.innerHTML = data[0].firstName + " " + data[0].lastName;
            nameDiv.appendChild(nameOut);
            const genderDiv = document.getElementById("gender");
            const genderOut = document.createElement("output");
            if(data[0].gender==="m"){
                genderOut.innerHTML = "Male";
            }else{
                genderOut.innerHTML = "Female";
            }
            genderDiv.appendChild(genderOut);
            const bdayDiv = document.getElementById("bday");
            const bdayOut = document.createElement("output");
            bdayOut.innerHTML = data[0].birthday;
            bdayDiv.appendChild(bdayOut);
            const contactNDiv = document.getElementById("contactN");
            const contactNOut = document.createElement("output");
            contactNOut.innerHTML = data[0].contactNum;
            contactNDiv.appendChild(contactNOut);
            const addressDiv = document.getElementById("address");
            addressDiv.innerHTML = data[0].homeAddress;
            const weightDiv = document.getElementById("weight");
            const weightOut = document.createElement("output");
            weightOut.innerHTML = data[0].weight+" kg";
            weightDiv.appendChild(weightOut);
            const heightDiv = document.getElementById("height");
            const heightOut = document.createElement("output");
            heightOut.innerHTML = data[0].height+" cm";
            heightDiv.appendChild(heightOut);
            
            const eDetails = document.getElementById("eDetails");
            for(j = 0; j < data[2].length; j++){
                const nameContainer = document.createElement("div");
                nameContainer.className = "row-container";
                const relaContainer = document.createElement("div");
                relaContainer.className = "row-container";
                const contactContainer = document.createElement("div");
                contactContainer.className = "row-container";
                const nameDiv = document.createElement("div");
                nameDiv.className = "left-side";
                nameDiv.innerHTML = "Name: ";
                const nameOutput = document.createElement("div");
                nameOutput.className = "right-side";
                nameOutput.innerHTML = data[2][j].name;
                nameContainer.appendChild(nameDiv);
                nameContainer.appendChild(nameOutput);
                const relationDiv = document.createElement("div");
                relationDiv.className = "left-side";
                relationDiv.innerHTML = "Relationship: ";
                const relaOutput = document.createElement("div");
                relaOutput.className = "right-side";
                relaOutput.innerHTML = data[2][j].relationship;
                relaContainer.appendChild(relationDiv);
                relaContainer.appendChild(relaOutput);
                const contactDiv = document.createElement("div");
                contactDiv.className = "left-side";
                contactDiv.innerHTML = "Contact Number: ";
                const contactOutput = document.createElement("div");
                contactOutput.className = "right-side";
                contactOutput.innerHTML = data[2][j].contactNum;
                contactContainer.appendChild(contactDiv);
                contactContainer.appendChild(contactOutput);
                eDetails.appendChild(nameContainer);
                eDetails.appendChild(relaContainer);
                eDetails.appendChild(contactContainer);
                eDetails.appendChild(document.createElement("br"));

            }
            
            const medConcernDiv = document.getElementById("medicalConcerns");
            if(data[1].length===0){
                medConcernDiv.innerHTML = "No medical concerns recorded";
            }else{
                for(i = 0; i < data[1].length; i++){
                    const medConcerns = document.createElement("div");
                    const medConcernOut = document.createElement("output");
                    medConcernOut.innerHTML = data[1][i].medicalConcern;
                    medConcerns.appendChild(medConcernOut);
                    medConcernDiv.appendChild(medConcerns);
                    medConcernDiv.appendChild(document.createElement("br"));
                }
            } 
        }
    });