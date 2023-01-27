fetch("../../controller/receptionist/view_sProfiles_controller.php")
    .then((res) => res.json())   //removing the headers
    .then((data) => {
        // console.log(data);
        if(data[0]['errMsg'] !== undefined){
            const errorDiv = document.getElementById("err-msg");
            const searchError = document.createElement("div");
            searchError.className = "err-search-result";
            searchError.id = "err-search-result";
            searchError.innerHTML = data[0]['errMsg'];
            errorDiv.appendChild(searchError);
        }else{
            const searchResults = document.getElementById("search_results");
            for(i = 0; i < data.length; i++){
                const form = document.createElement("form");
                form.action = "user_profile.php";
                form.method = "GET";
                form.className = "row-container";
                const profilePicture = document.createElement("div");
                profilePicture.className = "left-side";
                const imageTag = document.createElement("img");
                imageTag.className = "branch-img";
                if(data[i].profile === null){
                    imageTag.src = "/styles/icons/profile_icon.svg";  
                }else{
                    imageTag.src = "/styles/icons/".concat(data[i].profile);
                }
                profilePicture.appendChild(imageTag);
                
                const profileDetails = document.createElement("div");
                profileDetails.className = "right-side";
                profileDetails.style = "margin-top: 8%;"
                profileDetails.innerHTML = "Name: ".concat(data[i].fName," ",data[i].lName,"<br>","Contact Number: ",data[i].contactN);
                const viewButton = document.createElement("button");
                viewButton.className = "viewBtn";
                viewButton.id = "viewBtn";
                viewButton.value = data[i].id;
                viewButton.name = "userProfile";
                viewButton.innerHTML = "View Profile";
                viewButton.type = "submit";
                profileDetails.appendChild(viewButton);
                form.appendChild(profilePicture);
                form.appendChild(profileDetails);
                searchResults.appendChild(form);
            }
        }
    });
