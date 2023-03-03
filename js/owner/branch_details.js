let feedbacks = []; //to store the feedbacks for pagination
let branches = [];  //store the branches

const branchDetailsForm = document.querySelector("#branchContainer");

//get the data from the server
fetch("../../controller/owner/branch_details_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);

        //initialize and store the data
        for(let i = 0; i < data.length; i++){
            branches.push(data[i]);
        }

        //select branch option
        const selectBranch = document.querySelector("#branchFilter");

        //create an option for each branch
        branches.forEach(branch => {
            const option = document.createElement("option");
            option.value = branch.branchDetails.branchID;
            option.innerHTML = branch.branchDetails.city;
            selectBranch.appendChild(option);
        });

        //add event listener to the select branch
        selectBranch.addEventListener("change", displayBranchDetails);
    })
    .then(() => {
        console.log(branches);
    })


const displayBranchDetails = (e) => {
    const branchID = e.target.value;

    const courtCountInput = document.querySelector("#courtCount");
    const contactNumbers = branchDetailsForm.querySelector("#contactNumbers");
    const sports = branchDetailsForm.querySelector("#sports");

    branchDetailsForm.reset();

    contactNumbers.innerHTML = "";
    courtCountInput.value = "";
    sports.innerHTML = "";

    if(branchID == ""){
        displayFeedbacks(branchID);
        return;
    }
    else{
        //get the branch details
        const branch = branches.find(branch => {
            return branch.branchDetails.branchID == branchID;
        });

        //display the branch details
        branchDetailsForm.querySelector("#address").value = branch.branchDetails.address;

        //branch manager
        let manager = "";
        if(branch.branchManager.gender == 'm'){
            manager = "Mr. ";
        }
        else{
            manager = "Ms. ";
        }
        manager += `${branch.branchManager.firstName} ${branch.branchManager.lastName}`;

        branchDetailsForm.querySelector("#manager").value = manager;

        //branch receptionist
        let receptionist = "";
        if(branch.branchReceptionist.gender == 'm'){
            receptionist = "Mr. ";
        }
        else{
            receptionist = "Ms. ";
        }
        receptionist += `${branch.branchReceptionist.firstName} ${branch.branchReceptionist.lastName}`;

        branchDetailsForm.querySelector("#receptionist").value = receptionist;

        branchDetailsForm.querySelector("#startDate").value = branch.branchDetails.openingDate;
        branchDetailsForm.querySelector("#openingTime").value = branch.branchDetails.openingTime;
        branchDetailsForm.querySelector("#closingTime").value = branch.branchDetails.closingTime;

        //contact numbers 
        const contactOption1 = document.createElement("option");
        contactOption1.innerHTML = branch.branchManager.contactNum + " (Manager)";

        const contactOption2 = document.createElement("option");
        contactOption2.innerHTML = branch.branchReceptionist.contactNum + " (Receptionist)";


        const contactNumbers = branchDetailsForm.querySelector("#contactNumbers");
        contactNumbers.appendChild(contactOption1);
        contactNumbers.appendChild(contactOption2);

        //branch email
        branchDetailsForm.querySelector("#email").value = branch.branchDetails.branchEmail;

        //providing sports
        branch.sports.forEach(sport => {
            const option = document.createElement("option");
            option.value = sport.sportID;
            option.innerHTML = sport.sportName;
            sports.appendChild(option);
        });

        //add the first sport to the court count
        let courtCount = branch.branchCourts.filter(i => i.sportID == branch.sports[0].sportID).length;
        courtCountInput.value = courtCount;

        //event listener for the sports
        sports.addEventListener("change", (e) => {
            const sportID = e.target.value;
            let courtCount = branch.branchCourts.filter(i => i.sportID == sportID).length;
        
            courtCountInput.value = courtCount;
        });

        //get branch feedback
        //check the feedbacks array
        const feedbackKeys = Object.keys(feedbacks);
        if(!feedbackKeys.includes(branchID)){   //if the feedbacks are not in the array
            //get the feedbacks from the server
            fetch("../../controller/owner/branch_feedback_controller.php?branchID=" + branchID)
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    feedbacks[branchID] = data;
                })
                .then(() => {
                    displayFeedbacks(branchID);
                });
        }
        else{
            displayFeedbacks(branchID);
        }
    }
}

const displayFeedbacks = (branchID) => {
    const currRating = document.querySelector("#currRating");

    const ratingStars = currRating.querySelectorAll("i");

    const feedbackContainer = document.querySelector("#userFeedback");

    ratingStars.forEach(star => {
        star.className = "fa-solid fa-star";
    });

    feedbackContainer.innerHTML = "";

    if(branchID != ''){

        //add the rating according to the feedbacks
        const currBranchFeedbacks = feedbacks[branchID];

        console.log(currBranchFeedbacks);

        let i = 1;
        ratingStars.forEach(star => {
            if(i <= currBranchFeedbacks.rating){
                star.classList.add("checked");
            }
            
            //color star for decimal rating
            if(i === Math.floor(currBranchFeedbacks.rating) && currBranchFeedbacks.rating % 1 !== 0){
                star.className = "fa-solid fa-star-half-stroke";
                star.classList.add("checked");
            }
            i++;
        });

        //add the feedbacks

        for(let i = 0; i < currBranchFeedbacks.feedback.length; i++){
            const currUserFeedback = document.createElement("div");
            const currUserFeedbackHeader = document.createElement("div");
            const currUserFeedbackBody = document.createElement("div");
            const currUserFeedbackFooter = document.createElement("div");

            for(let j = 1; j <= 5; j++){
                const star = document.createElement("i");
                star.className = "fa-solid fa-star";
                currUserFeedbackHeader.appendChild(star);

                if(j <= currBranchFeedbacks.feedback[i].rating){
                    star.classList.add("checked");
                }
            }

            currUserFeedbackBody.innerHTML = currBranchFeedbacks.feedback[i].description;

            currUserFeedbackFooter.innerHTML = currBranchFeedbacks.feedback[i].userFullName + " on " + currBranchFeedbacks.feedback[i].date;

            currUserFeedback.appendChild(currUserFeedbackHeader);
            currUserFeedback.appendChild(currUserFeedbackBody);
            currUserFeedback.appendChild(currUserFeedbackFooter);

            feedbackContainer.appendChild(currUserFeedback);
        }

    }
}