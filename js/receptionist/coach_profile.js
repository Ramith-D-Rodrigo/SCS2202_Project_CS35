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
            idDiv.value = data[0].coachID;
            const sportOut = document.getElementById("sport");
          
            sportOut.value = data[0].sportName;
            
            const nameOut = document.getElementById("name");
           
            nameOut.value = data[0].firstName + " " + data[0].lastName;
           
            const genderOut = document.getElementById("gender");
           
            if(data[0].gender==="m"){
                genderOut.value = "Male";
            }else{
                genderOut.value = "Female";
            }
            
            const bdayOut = document.getElementById("bday");
            
            bdayOut.value = data[0].birthday;
          
            const contactNOut = document.getElementById("contactN");
           
            contactNOut.value = data[0].contactNum;
          
            const addressOut = document.getElementById("eAddress");
            
            addressOut.value = data[0].emailAddress;
            
            const ratingOut = document.getElementById("rating");
            
            ratingOut.value = data[1];
          
            
            const qualificationsDiv = document.getElementById("qualifications");   //output the coach qualifications
            if(data[4].length === 0){
                const qualificationsOut = document.createElement("input");
                qualificationsOut.readOnly = true;
                qualificationsOut.value = "No qualifications mentioned.";
                qualificationsDiv.appendChild(qualificationsOut);
            }else{
                for(i = 0; i < data[4].length; i++){
                    const qualificationsOut = document.createElement("input");
                    qualificationsOut.readOnly = true;
                    qualificationsOut.className = "right-side-multiples";
                    qualificationsOut.value = data[4][i].qualification;
                    qualificationsDiv.appendChild(qualificationsOut);
                    qualificationsDiv.appendChild(document.createElement("br"));
                }
            }
            

            const sessionInfo = document.getElementById("sessionInfo");
            if(data[3].length === 0){
                const session = document.createElement("input");
                session.readOnly = true;
                session.value = "No available sessions yet.";
                sessionInfo.appendChild(session);
            }
            else{
                for(i=0;i<data[3].length;i++){
                    const session = document.createElement("input");
                    session.readOnly = true;
                    session.className = "right-side-multiples";
                    session.value = data[3][i][0].concat(" From ",data[3][i][1].substring(0,5)," To ",data[3][i][2].substring(0,5));
                    sessionInfo.appendChild(session);
                    const br = document.createElement("br");
                    sessionInfo.appendChild(br);   
                }
            }
               
            if(data[2].length === 0){
                const feedbackCaption = document.getElementById("feedbackCaption");
                feedbackCaption.value = "Feedbacks";
                const noFeedback  = document.getElementById("errFeedback-msg");
                noFeedback.innerHTML = "No Feedback yet.";
            }else{
                const feedbackDiv = document.getElementById("feedback");
                const feedbackCaption = document.getElementById("feedbackCaption");
                feedbackCaption.value = "Feedbacks";
                for(let i = 0; i < data[2].length; i++){
                    container = document.createElement("div");
                    container.className = "row-container";
                    container.style.flexDirection = "column";
                    container.style.alignItems = "flex-start";
                    starRating = document.createElement("div");
                    description = document.createElement("div");
                    const rating = document.createElement("span");
                    starRating.innerHTML = '';
                    rating.style.marginLeft = "10px";
                    for(let j = 1; j <= 5; j++){
                        const star = document.createElement("i");
                        star.ariaHidden = "true";   //for screen readers
                        

                        if(j <= parseInt(data[2][i].rating)){
                            star.className = "fa fa-star rating-star";
                            star.classList.add("checked");
                        }

                        //half stars for decimal value
                        if(j === Math.ceil(parseInt(data[2][i].rating)) && parseInt(data[2][i].rating) % 1 !== 0){
                            star.className = "fa-solid fa-star-half-stroke checked";
                            star.classList.add("checked");
                        }
                        rating.appendChild(star);
                    }
                    starRating.appendChild(rating);
                    description.innerHTML = data[2][i].description.concat("<br>",data[2][i].date," (Commented Date)");
                    container.appendChild(starRating);
                    container.appendChild(description);
                    feedbackDiv.appendChild(container);
                }
            }
        }
    });
