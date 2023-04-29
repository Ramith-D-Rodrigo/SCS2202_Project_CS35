const url = new URL(window.location); 
const parameters = new URLSearchParams(url.search); //search parameters

const coachProfile = parameters.get("coachProfile");
// console.log(coachProfile);

fetch("../../controller/receptionist/view_cProfile_controller.php?coachID=".concat(coachProfile))
    .then((res)=>res.json())
    .then((data)=>{
        console.log(data); 
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
            const idOut = document.createElement("input");
            idOut.value = data[0].coachID;
            idDiv.appendChild(idOut);
            const sportDiv = document.getElementById("sport");
            const sportOut = document.createElement("input");
            sportOut.value = data[0].sportName;
            sportDiv.appendChild(sportOut);
            const nameDiv = document.getElementById("name");
            const nameOut = document.createElement("input");
            nameOut.value = data[0].firstName + " " + data[0].lastName;
            nameDiv.appendChild(nameOut);
            const genderDiv = document.getElementById("gender");
            const genderOut = document.createElement("input");
            if(data[0].gender==="m"){
                genderOut.value = "Male";
            }else{
                genderOut.value = "Female";
            }
            genderDiv.appendChild(genderOut);
            const bdayDiv = document.getElementById("bday");
            const bdayOut = document.createElement("input");
            bdayOut.value = data[0].birthday;
            bdayDiv.appendChild(bdayOut);
            const contactNDiv = document.getElementById("contactN");
            const contactNOut = document.createElement("input");
            contactNOut.value = data[0].contactNum;
            contactNDiv.appendChild(contactNOut);
            const addressDiv = document.getElementById("eAddress");
            const addressOut = document.createElement("input");
            addressOut.value = data[0].emailAddress;
            addressDiv.appendChild(addressOut);
            const ratingDiv = document.getElementById("rating");
            const ratingOut = document.createElement("input");
            ratingOut.value = data[1];
            ratingDiv.appendChild(ratingOut);
            
            const qualificationsDiv = document.getElementById("qualifications");   //output the coach qualifications
            if(data[4].length === 0){
                qualificationsDiv.innerHTML = "No Qualifications mentioned";
            }else{
                for(i = 0; i < data[4].length; i++){
                    const qualificationsOut = document.createElement("input");
                    qualificationsOut.readOnly = true;
                    qualificationsOut.value = data[4][i].qualification;
                    qualificationsDiv.appendChild(qualificationsOut);
                }
            }
            

            const sessionInfo = document.getElementById("sessionInfo");
            for(i=0;i<data[3].length;i++){
                const session = document.createElement("input");
                session.readOnly = true;
                session.value = data[3][i][0].concat(" From: ",data[3][i][1]," To: ",data[3][i][2]);
                sessionInfo.appendChild(session);
            }   
            if(data[2].length === 0){
                const noFeedback  = document.getElementById("errFeedback-msg");
                noFeedback.innerHTML = "No Feedback yet.";
            }else{
                const feedbackDiv = document.getElementById("feedback");
                const feedbackCaption = document.getElementById("feedbackCaption");
                feedbackCaption.value = "Feedbacks";
                feedbackCaption.style.width = "200px";
                for(i = 0; i < data[2].length; i++){
                    container = document.createElement("div");
                    container.className = "row-container";
                    left = document.createElement("div");
                    left.className = "left-side";
                    left.style.width = "200px";
                    left.innerHTML = "Description: ".concat("<br>","Rating: ","<br>","View: ");
                    right = document.createElement("div");
                    right.className = "right-side";
                    right.style.marginLeft = "10px";
                    right.innerHTML = data[2][i].description.concat("<br>",data[2][i].rating," Stars","<br>",data[2][i].date);
                    container.appendChild(left);
                    container.appendChild(right);
                    feedbackDiv.appendChild(container);
                    feedbackDiv.appendChild(document.createElement("br"));
                }
            }
        }
    });

