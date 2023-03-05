import {currency} from "../CONSTANTS.js";
//get data from server

const revenueCard = document.querySelector("#revenue");
const branchesCard = document.querySelector("#branches");
const feedbackCard = document.querySelector("#feedbacks");
const requestsCard = document.querySelector("#requests");
const sportCard = document.querySelector("#sports");

fetch("../../controller/owner/dashboard_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);

        //add the data to the revenue card
        revenueCard.innerHTML = `${currency} ${parseFloat(data.revenue).toFixed(2)}`;
        
        //add the data to the branches card
        //create a list
        const branchesList = document.createElement("ul");
        branchesCard.appendChild(branchesList);

        data.branches.forEach(branch => {
            const listItem = document.createElement("li");
            listItem.classList.add("list-item");
            listItem.classList.add("simple-list");
            listItem.innerHTML = `${branch}`;
            branchesList.appendChild(listItem);
        });

        //add the data to the feedback card

        //create a list
        const feedbackList = document.createElement("ul");
        feedbackCard.appendChild(feedbackList);

        //sort the feedbacks by date
        data.feedbacks.sort((a, b) => {
            return new Date(b.date) - new Date(a.date);
        });

        data.feedbacks.forEach(feedback => {
            const listItem = document.createElement("li");
            listItem.className = "list-item";
            
            //rating stars
            const rating = document.createElement("div");
            rating.className = "rating";
            for(let i = 0; i < 5; i++){
                const star = document.createElement("i");
                star.style.fontSize = "1.5rem";
                star.className = "fas fa-star";
                if(i < feedback.rating){
                    star.style.color = "gold";
                }
                rating.appendChild(star);
            }
            listItem.appendChild(rating);

            const p = document.createElement("p");
            p.innerHTML = `${feedback.description}`;
            listItem.appendChild(p);
            feedbackList.appendChild(listItem);
        });

        //add the data to the requests card

        if(data.requests != 0){
            requestsCard.innerHTML = `You Have ${data.requests} Pending Requests`;
        }
        else{
            requestsCard.innerHTML = `No Pending Requests`;
        }

        //add the data to the sports card

        data.sports.forEach(sport => {
            const sportDiv = document.createElement("div");
            sportDiv.className = "sport-icon-container";
            //image for the sport
            const img = document.createElement("img");
            img.src = `/uploads/sport_images/${sport.sportName}.jpg`;

            img.className = "sport-icon";

            //hidden div to show the sport name
            const hiddenDiv = document.createElement("div");
            hiddenDiv.className = "sport-name";
            hiddenDiv.innerHTML = `${sport.sportName}`;
            sportDiv.appendChild(hiddenDiv);

            sportDiv.appendChild(img);
            sportCard.appendChild(sportDiv);
        });


    });
