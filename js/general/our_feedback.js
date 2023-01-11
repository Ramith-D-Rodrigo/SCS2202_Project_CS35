//getting the elements

const branchFilter = document.getElementById("branchFilter");   //branch filter
const searchBar = document.querySelector("#feedbackSearch");    //searchbar
const ratingFilter = document.getElementById("ratingFilter");   //rating filter

//functions

function sortByDate(row1, row2){    //sort feedback rows by dates (rows are table rows)
    const dateCell1 = row1.firstChild;
    const dateCell2 = row2.firstChild;

    const date1 = new Date(dateCell1.innerHTML);
    const date2 = new Date(dateCell2.innerHTML);
    
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

function filterBranch(e){
    if(e.target.value === ""){
        const allRows = Array.from(document.querySelectorAll("tr")); //select all the table rows
        allRows.filter(i => i.className !== "headRow").forEach(i => i.style.display = ""); //show all the rows
    }
    else{
        const allRows = Array.from(document.querySelectorAll("tr")).filter(i => i.className !== "headRow"); //select all the table rows other than the header

        const hidingRows = allRows.filter(i => !i.classList.contains(e.target.value));
        hidingRows.forEach(i => i.style.display = "none"); //hide the rows that don't match the branch id
        const showingRows = allRows.filter(i => i.classList.contains(e.target.value));
        showingRows.forEach(i => i.style.display = ""); //show the rows that match the branch id
    }
}


const feedbackSearchFilter = (e) => {    //function to filter the feedback by user input (date, feedback, branch) 
    const allRows = Array.from(document.querySelectorAll("tr")).filter(i => i.className !== 'headRow'); //select all the table rows and filter out the header
    const searchInput = e.target.value.toLowerCase();    //get the user input

    if(searchInput.length < 3){
        allRows.forEach(i => i.style.display = ""); //show all the rows
    }
    else{
        allRows.forEach(row => {    //go each row
            let flag = false;
            const cells = Array.from(row.childNodes);
            cells.forEach(cell => {   //go each cell of that row
                if(cell.innerHTML.toLowerCase().includes(searchInput)){ //if found
                    flag = true;
                }
            });
    
            if(flag === false){
                row.style.display = "none";
            }
            else{
                row.style.display = "";
            }
        });       
    }
}

const filterRating = (e) => {   //function to filter the feedback by rating
    const allRows = Array.from(document.querySelectorAll("tr")).filter(i => i.className !== 'headRow'); //select all the table rows and filter out the header
    const rating = e.target.value;

    if(rating === ""){
        allRows.forEach(i => i.style.display = ""); //show all the rows
    }
    else{
        const hidingRows = allRows.filter(i => !i.classList.contains("Rating" + rating));
        hidingRows.forEach(i => i.style.display = "none"); //hide the rows that don't match the rating
    
        const showingRows = allRows.filter(i => i.classList.contains("Rating" + rating));
        showingRows.forEach(i => i.style.display = ""); //show the rows that match the rating
    }
}

//event listeners

searchBar.addEventListener("keyup", feedbackSearchFilter);    //add event listener to the searchbar
branchFilter.addEventListener("change", filterBranch);  //add event listener to the branchfilter
ratingFilter.addEventListener("change", filterRating);  //add event listener to the ratingfilter

//data fetch from server

fetch("../../controller/general/our_feedback_controller.php")
    .then(res => res.json())
    .then(data =>{
        //console.log(data);
        const tableBody = document.querySelector("tbody");

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
                const feedbackRow = document.createElement("tr");   //feedback row
                feedbackRow.className = currBranch.branchID;    //same class to identify feedback rows for each branch

                const dateCell = document.createElement("td");  //date cell
                dateCell.innerHTML = data[dataKeys[i]][j].date;
                feedbackRow.appendChild(dateCell);

                const branchCell = document.createElement("td");    //branch cell
                branchCell.innerHTML = currBranch.branchCity;
                feedbackRow.appendChild(branchCell);

                const feedbackCell = document.createElement("td");    //description cell
                feedbackCell.innerHTML = data[dataKeys[i]][j].description;
                feedbackRow.appendChild(feedbackCell);

                const ratingCell = document.createElement("td");    //rating cell
                const userRating = parseInt(data[dataKeys[i]][j].rating);
                feedbackRow.classList.add("Rating" + userRating); //add the rating as a class to the row
               
                for(let k = 1; k <= 5; k++){ //create the stars
                    const star = document.createElement("span");
                    star.className = "fa fa-star checked";
                    if(k > userRating){    //if the k has exceeded the user rating, change the star to empty
                        star.className = "fa fa-star";
                    }
                    ratingCell.appendChild(star);
                }
                feedbackRow.appendChild(ratingCell);

                branchFeedbacks.push(feedbackRow);
            }
        }
        
        //console.log(branchFeedbacks);
        branchFeedbacks.sort(sortByDate);
        //console.log(branchFeedbacks);

        branchFeedbacks.forEach(i => tableBody.appendChild(i)); //append the table rows

        //check if we are coming from the our branches page
        const selectedBranch = localStorage.getItem("feedbackBranch");
        if(selectedBranch !== null){
            const eventObj = {"target" : {"value" : selectedBranch}};
            filterBranch(eventObj);
            localStorage.removeItem("feedbackBranch");  //remove the item from the local storage

            branchFilter.value = selectedBranch;    //set the value to display the correct filter option
        }
    })
    .catch(err => console.error(err));