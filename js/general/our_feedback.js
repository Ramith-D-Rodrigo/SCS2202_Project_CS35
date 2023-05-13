//getting the elements
const branchFilter = document.getElementById("branchFilter");   //branch filter
const searchBar = document.querySelector("#feedbackSearch");    //searchbar
const ratingFilter = document.getElementById("ratingFilter");   //rating filter
const showAmountFilter = document.getElementById("amountFilter");   //show amount filter

const feedbackContainer = document.querySelector("#feedbackContainer"); //feedback container

//functions

function sortByDate(div1, div2){    //sort feedbacks by date
    const dateSpan1 = div1.querySelector(".feedbackDate");   //get the date span of the first div
    const dateSpan2 = div2.querySelector(".feedbackDate");   //get the date span of the second div

    const date1 = new Date(dateSpan1.innerHTML);
    const date2 = new Date(dateSpan2.innerHTML);
    
    if(date1 < date2){
        return 1;
    }
    else if(date1 === date2){
        return 0;
    }
    else{
        return -1;
    }
}

const filterFeedback = (e) =>{
    const searchVal = searchBar.value.toLowerCase();
    let branchVal = null;
    if(e.target.flag !== undefined && e.target.flag === true){    //if we coming from the branches page
        branchVal = e.target.value;
    }
    else{
        branchVal = branchFilter.value;
    }
    const ratingVal = ratingFilter.value;
    const showAmountVal = showAmountFilter.value;

    const allDivs = feedbackContainer.children; //get all the feedback divs
    
    for(let i = 0; i < allDivs.length; i++){    //show all the the divs
        allDivs[i].style.display = "";
    }

    let filteredDivs = Array(); //to store the filtered rows

    //filtering the search result
    if(searchVal.length > 3){  //if the search value is more than 3 characters (can filter)
        for(let i = 0; i < allDivs.length; i++){
            let flag = false;
            const childDivs = Array.from(allDivs[i].childNodes);
            childDivs.forEach(cell => {   //go each cell of that row
                if(cell.innerText.toLowerCase().includes(searchVal)){ //if found
                    flag = true;
                }
            });
    
            if(flag === false){ //result not available in the current checking row
                allDivs[i].style.display = "none"; //hide it
            }
            else{
                allDivs[i].style.display = "";
                filteredDivs.push(allDivs[i]);
            }
        }       
    }
    else{   //show all the rows
        filteredDivs = [...allDivs];
    }


    let temp = null;

    if(filteredDivs.length === 0){  //no such result
        return;
    }
    else{   //if there are filtered rows
        temp = [...filteredDivs];
        filteredDivs.length = 0;    //clear the filtered rows array
    }

    //filtering the branch
    if(branchVal !== ""){   //if the user wants to filter the branch
        temp.forEach(i => { //go through search filtered rows
            if(i.classList.contains(branchVal)){    //found a row that matches the branch
                i.style.display = "";
                filteredDivs.push(i);   //add the rows to the filtered rows array
            }
            else{
                i.style.display = "none";
            }
        });
    }
    else{
        filteredDivs = [...temp];
    }
 
    //filtering the rating
    if(filteredDivs.length === 0){  // no results
        return;
    }
    else{
        temp = [...filteredDivs];
        filteredDivs.length = 0;
    }


    if(ratingVal !== ""){   //if the user wants to filter the rating 
        temp.forEach(i => {
            if(i.classList.contains("Rating" + ratingVal)){
                i.style.display = "";
                filteredDivs.push(i);   //add the rows to the filtered rows array
            }
            else{
                i.style.display = "none";
            }
        }); 
    }
    else{
        filteredDivs = [...temp];
    }

    if(filteredDivs.length === 0){  //no results
        return;
    }
    else{
        temp = [...filteredDivs];
        filteredDivs.length = 0;
    }


    if(showAmountVal != ""){ //if the user wants to filter the amount of feedbacks to show
        for(let i = showAmountVal; i < temp.length; i++){
            temp[i].style.display = "none";
        }
    }
}

//event listeners

searchBar.addEventListener("keyup", filterFeedback);    //add event listener to the searchbar
branchFilter.addEventListener("change", filterFeedback);  //add event listener to the branchfilter
ratingFilter.addEventListener("change", filterFeedback);  //add event listener to the ratingfilter
showAmountFilter.addEventListener("change", filterFeedback);  //add event listener to the show amount filter

//data fetch from server

fetch("../../controller/general/our_feedback_controller.php")
    .then(res => res.json())
    .then(data =>{
        //console.log(data);
        const dataKeys = Object.keys(data);

        const branchInfo = [];  //array to store all branches (branch id and the city)

        const branchFeedbacks = [];

        for(i = 0; i < dataKeys.length; i++){
            const temp = dataKeys[i].split(" ");
            //console.log(temp);
            const currBranch = {"branchID" : temp[0], "branchCity" : temp[1]};
            //console.log(currBranch);
            branchInfo.push(currBranch);

            //create the filter option values
            const branchOption = document.createElement("option");
            branchOption.text = currBranch.branchCity;
            branchOption.value = currBranch.branchID;
            branchFilter.appendChild(branchOption);

            //create the feedbacks

            //console.log(data[dataKeys[i]]);

            for(let j = 0; j < data[dataKeys[i]].length; j++){    //traversing each feedback for a particular branch
                //console.log(data[dataKeys[i]].length);
                //const feedbackRow = document.createElement("tr");   //feedback row
                //feedbackRow.className = currBranch.branchID;    //same class to identify feedback rows for each branch
                const feedbackDiv = document.createElement("div");    //feedback div
                feedbackDiv.className = currBranch.branchID;    //same class to identify feedback divs for each branch
                feedbackDiv.classList.add("feedbackDiv");

                //create the feedback content
                const feedbackContent = document.createElement("div");
                feedbackContent.innerHTML = data[dataKeys[i]][j].description;

                //create the feedback footer
                const feedbackFooter = document.createElement("div");

                const feedbackDate = document.createElement("span");
                feedbackDate.className = "feedbackDate";
                feedbackDate.innerHTML = data[dataKeys[i]][j].date;
                feedbackDate.style.fontStyle = "italic";
                feedbackDate.style.color = "grey";

                const feedbackUser = document.createElement("span");
                feedbackUser.innerHTML = data[dataKeys[i]][j].userFullName;
                feedbackUser.style.fontStyle = "italic";
                feedbackUser.style.color = "grey";
                
                const feedbackBranch = document.createElement("span");
                feedbackBranch.innerHTML = "@" + currBranch.branchCity;
                feedbackBranch.style.fontStyle = "italic";
                feedbackBranch.style.color = "grey";
                

                feedbackFooter.appendChild(feedbackDate);
                const space1 = document.createTextNode(" ");
                feedbackFooter.appendChild(space1);
                feedbackFooter.appendChild(feedbackUser);

                const space2 = document.createTextNode(" ");
                feedbackFooter.appendChild(space2);
                feedbackFooter.appendChild(feedbackBranch);


                //create the feedback rating
                const feedbackRating = document.createElement("div");
                const userRating = parseInt(data[dataKeys[i]][j].rating);
                feedbackDiv.classList.add("Rating" + userRating); //add the rating as a class to the row
               
                for(let k = 1; k <= 5; k++){ //create the stars
                    const star = document.createElement("span");
                    star.className = "fa fa-star checked";
                    if(k > userRating){    //if the k has exceeded the user rating, change the star to empty
                        star.className = "fa fa-star";
                    }
                    feedbackRating.appendChild(star);
                }

                //append the feedback content, footer and rating to the feedback div
                feedbackDiv.appendChild(feedbackRating);
                feedbackDiv.appendChild(feedbackContent);
                feedbackDiv.appendChild(feedbackFooter);

                branchFeedbacks.push(feedbackDiv);
            }
        }
        
        //console.log(branchFeedbacks);
        branchFeedbacks.sort(sortByDate);
        //console.log(branchFeedbacks);

        branchFeedbacks.forEach(i => feedbackContainer.appendChild(i)); //append the table rows

        //check if we are coming from the our branches page
        const selectedBranch = localStorage.getItem("feedbackBranch");
        if(selectedBranch !== null){
            const eventObj = {"target" : {"value" : selectedBranch, "flag": true}};
            filterFeedback(eventObj);
            localStorage.removeItem("feedbackBranch");  //remove the item from the local storage

            branchFilter.value = selectedBranch;    //set the value to display the correct filter option
        }

        //add show amount filter
        let inc = 0;
        while(inc < branchFeedbacks.length){
            inc += 5;
            const option = document.createElement("option");
            option.value = inc;
            option.text = inc;
            showAmountFilter.appendChild(option);
        }

        //change show amount to 5 by default if have more than 5 feedbacks
        if(branchFeedbacks.length > 5){
            showAmountFilter.value = 5;
            const event = new Event("change");
            showAmountFilter.dispatchEvent(event);
        }

    })
    .catch(err => console.error(err));