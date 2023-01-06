const result = document.getElementById("branches");

function changeBtnValue(e){
    const form = e.target.parentNode.parentNode;    //form
    const reseveBtn = form.lastChild;   //button
    if(e.target.value === ""){  //selected "Choose One" option
        reseveBtn.value = "";
        return;
    }
    //console.log(form);
    reseveBtn.value = [form.id, e.target.value];    //branch id first, then the sport id (here, form has the branch id)
    //console.log(reseveBtn.value);
}

function viewFeedback(e){
    e.preventDefault();
    const branchID = e.target.parentElement.id;
    console.log(branchID);
    localStorage.setItem("feedbackBranch", branchID);
    window.location.href = "/public/general/our_feedback.php";
}

let branches = [];
let branch_pictures = [];

fetch("../../controller/general/our_branches_controller.php")
    .then((res) => res.json())
    .then((data) => {
        for(let i = 0; i < data.length; i++){
            branches[i] = data[i];  //store the json objects in the array
            const branchRow = document.createElement("div");
            branchRow.setAttribute("class", "branch-row");

            const branchImageContainer = document.createElement("div");
            branchImageContainer.setAttribute("class","branch-image-container");

            const branchImage = document.createElement("img");


            branch_pictures[i] = branches[i].photos;    //add the pictures to the array
            if(branch_pictures[i] != null){ //has photos
                branchImage.src = branches[i].photos[0];    //add the first photo
            }
            else{
                branchImage.src = "/public/general/branch_images/";
            }

            branchImage.setAttribute("class", "branch-image");
            branchImage.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

            branchImageContainer.appendChild(branchImage);
            branchRow.appendChild(branchImage);

            const formDiv = document.createElement("div");
            const form = document.createElement("form");
            form.id = branches[i].branchID; //branch id for each form
            form.className = "branchInfo";
            form.action = "/public/general/reservation_schedule.php";
            form.method = "get";

            const openingTimeArr = branches[i].opening_time.split(":"); //setting opening time
            const openingTime = new Date();
            openingTime.setHours(openingTimeArr[0]);
            openingTime.setMinutes(openingTimeArr[1]);
            openingTime.setSeconds(openingTimeArr[2]);

            const closingTimeArr = branches[i].closing_time.split(":"); //setting closing time
            const closingTime = new Date();
            closingTime.setHours(closingTimeArr[0]);
            closingTime.setMinutes(closingTimeArr[1]);
            closingTime.setSeconds(closingTimeArr[2]); 

            const location = document.createElement("div"); //branch location div
            location.className = "info";
            location.innerHTML = "Location : " + branches[i].city;
            form.appendChild(location);

            const rating = document.createElement("div");   //branch rating div
            rating.className = "info";
            rating.innerHTML = "Rating : ";
            const branchRating = parseFloat(branches[i].rating);
            
            for(let j = 0; j < 5; j++){
                const star = document.createElement("span");
                star.className = "fa fa-star";
                star.style.margin = "0 0.2em";
                if(j < branchRating){
                    star.className = "fa fa-star checked";
                }
                //color star for decimal rating
                if(j === Math.floor(branchRating) && branchRating % 1 !== 0){
                    star.className = "fa fa-star-half-o checked";
                    star.style.color = "gold";
                }
                star.style.fontSize = "1.5em";
                rating.appendChild(star);
            }

            form.appendChild(rating);

            const address = document.createElement("div");  //branch address div
            address.className = "info";
            address.innerHTML = "Address : " + branches[i].address;
            form.appendChild(address);

            const opening_time = document.createElement("div"); //branch opening time div
            opening_time.className = "info";
            opening_time.innerHTML = "Opening Time : " + openingTime.toLocaleTimeString();
            form.appendChild(opening_time);
            
            const manager = document.createElement("div");  //branch manager div
            manager.className = "info";
            let managerName = "";
            if(branches[i].manager['gender'] === 'm'){
                managerName = "Mr. ";
            }
            else{
                managerName = "Mrs. ";
            }
            managerName = managerName + branches[i].manager['firstName'] + " " + branches[i].manager['lastName'];

            manager.innerHTML = "Manager : " + managerName;
            form.appendChild(manager);

            const closing_time = document.createElement("div"); //branch closing time div
            closing_time.className = "info";
            closing_time.innerHTML = "Closing Time : " + closingTime.toLocaleTimeString();
            form.appendChild(closing_time);

            const manager_contact = document.createElement("div");  //branch manager contact div
            manager_contact.className = "info";
            manager_contact.innerHTML = "Manager Contact No : " + branches[i].manager['contactNum'];
            form.appendChild(manager_contact);

            const feedbackBtn = document.createElement("button");//branch feedback button
            feedbackBtn.innerHTML = "View Feedback";
            //feedbackBtn.disabled = true;    //for now it is disabled
            feedbackBtn.addEventListener("click", viewFeedback);
            form.appendChild(feedbackBtn);

            const receptionist = document.createElement("div"); //branch receptionist div
            receptionist.className = "info";
            let receptionistName = "";
            if(branches[i].receptionist['gender'] === 'm'){
                receptionistName = "Mr. ";
            }
            else{
                receptionistName = "Mrs. ";
            }
            receptionistName = receptionistName + branches[i].receptionist['firstName'] + " " + branches[i].receptionist['lastName'];

            receptionist.innerHTML = "Receptionist : " + receptionistName;
            form.appendChild(receptionist);

            const branchEmail = document.createElement("div");  //branch email
            branchEmail.className = "info";
            branchEmail.innerHTML = "Branch Email : " + branches[i].email;
            form.appendChild(branchEmail);

            const receptionist_contact = document.createElement("div"); //branch receptionist contact div
            receptionist_contact.className = "info";    
            receptionist_contact.innerHTML = "Receptionist Contact No : " + branches[i].receptionist['contactNum'];
            receptionist_contact.style = "min-width: 100%";
            form.appendChild(receptionist_contact);

            const providing_sports = document.createElement("div"); //providing sports div
            providing_sports.className = "info";
            providing_sports.innerHTML = "Available Sports : ";

            const sportSelector = document.createElement("select");
            sportSelector.setAttribute("required", "");
            sportSelector.className = "providing_sports";

            const emptyOption = document.createElement("option");
            emptyOption.value = "";
            emptyOption.text = "Choose One";
            sportSelector.appendChild(emptyOption);

            for(j = 0; j < branches[i].sports.length; j++){ //adding the sports to the drop dowm
                const sportOption = document.createElement("option");
                sportOption.text = branches[i].sports[j].sport_name;
                sportOption.value = branches[i].sports[j].sport_id;
                sportSelector.appendChild(sportOption);
            }

            providing_sports.appendChild(sportSelector);
            form.appendChild(providing_sports);


            const reserveBtn = document.createElement("button");    //reservation button
            reserveBtn.innerHTML = "Make a Reservation";
            reserveBtn.name = "reserveBtn";
            reserveBtn.type = "submit";

            form.appendChild(reserveBtn);

            formDiv.appendChild(form);
            branchRow.appendChild(formDiv);

            result.appendChild(branchRow);
        }

        //event listener for the select options
        const selectOption = document.querySelectorAll(".providing_sports");
        //console.log(selectOption);
        selectOption.forEach(element => element.addEventListener("change", changeBtnValue));

        //change branch image using setInterval
        const branchImg = document.querySelectorAll(".branch-image");
        for(let i = 0; i < branchImg.length; i++){
            setInterval(() =>{
                if(branch_pictures[i].length === 1){    //if there is only one image
                    return;
                }
                const prev = branchImg[i].src.split("/").pop(); //previous img name
                do{
                    var nextImgIndex = Math.floor(Math.random() * branch_pictures[i].length); //next img index
                }while(branch_pictures[i][nextImgIndex] === prev);
                branchImg[i].src = "/public/general/branch_images/" + branch_pictures[i][nextImgIndex];
            }, 3000);
        }


    });



