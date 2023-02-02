const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const coachProfile = parameters.get("coachProfile");
// console.log(coachProfile);

fetch("../../controller/receptionist/view_cProfile_controller.php?coachID=".concat(coachProfile))
    .then((res)=>res.json())
    .then((data)=>{
        // console.log(data); 
        if(data[0]['errMsg'] !== undefined){   //no such coach
            const searchError = document.getElementById("errorProfile-msg");
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
            const idDiv = document.getElementById("cid");
            const idOut = document.createElement("output");
            idOut.innerHTML = data[0].coachID;
            idDiv.appendChild(idOut);
            const sportDiv = document.getElementById("sport");
            const sportOut = document.createElement("output");
            sportOut.innerHTML = data[0].sportName;
            sportDiv.appendChild(sportOut);
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
            const addressDiv = document.getElementById("eAddress");
            const addressOut = document.createElement("output");
            addressOut.innerHTML = data[0].emailAddress;
            addressDiv.appendChild(addressOut);
            const ratingDiv = document.getElementById("rating");
            const ratingOut = document.createElement("output");
            ratingOut.innerHTML = data[1];
            ratingDiv.appendChild(ratingOut);
            
            const qualificationsDiv = document.getElementById("qualifications");   //output the coach qualifications
            if(data[4].length === 0){
                qualificationsDiv.innerHTML = "No Qualifications mentioned";
            }else{
                for(i = 0; i < data[4].length; i++){
                    const qualificationsOut = document.createElement("output");
                    qualificationsOut.innerHTML = data[4][i].qualification;
                    qualificationsDiv.appendChild(qualificationsOut);
                    qualificationsDiv.appendChild(document.createElement("br"));
                    qualificationsDiv.appendChild(document.createElement("br"));
                }
            }
            

            const branch = document.getElementById("sessionBranch");
            const defaultOption = document.createElement("option");
            defaultOption.innerHTML = "Choose One...";
            defaultOption.value = "";
            branch.appendChild(defaultOption);
            
            for(j = 0; j < data[3].length; j++){   
                const branchName = document.createElement("option");
                branchName.innerHTML = data[3][j];
                branchName.value = data[3][j];
                branch.appendChild(branchName);
            }
            
            if(data[2].length === 0){
                const noFeedback  = document.getElementById("errFeedback-msg");
                noFeedback.innerHTML = "No Feedback yet.";
            }else{
                const feedbackDiv = document.getElementById("feedback");
                for(i = 0; i < data[2].length; i++){
                    const feedbackOut = document.createElement("output");
                    feedbackOut.innerHTML = data[2][i].description;
                    feedbackDiv.appendChild(feedbackOut);
                    feedbackDiv.appendChild(document.createElement("br"));
                    feedbackDiv.appendChild(document.createElement("br"));
                }
            }
        }
    });

    const branchName = document.getElementById("sessionBranch");
    branchName.addEventListener("change", (e) => {
        if(e.target.value !== ""){
            fetch("../../controller/receptionist/view_sessionInfo_controller.php?coachID=".concat(coachProfile,"&branch=",e.target.value))
            .then((res)=>res.json())
            .then((data)=>{
                // console.log(data);
                if(data[0]['errMsg'] !== undefined){   //not any dependent
                    const searchError = document.getElementById("sessionInfo");
                    searchError.innerHTML = data[0]['errMsg'];
                }else{
                    const sessionInfo = document.getElementById("sessionInfo");
                    for(i=0;i<data.length;i++){
                        const session = document.createElement("output");
                        session.innerHTML = data[i][0].concat("<br>From: ",data[i][1]," To: ",data[i][2],"<br>");
                        sessionInfo.appendChild(session);
                    }   
                }
            });
        }else{
            const sessionInfo = document.getElementById("sessionInfo");
            sessionInfo.innerHTML = "";
        }
        
    });
