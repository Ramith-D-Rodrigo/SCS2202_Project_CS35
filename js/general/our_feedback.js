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

const filterFeedback = (e) =>{
    const searchVal = searchBar.value.toLowerCase();
    const branchVal = branchFilter.value;
    const ratingVal = ratingFilter.value;

    const allRows = Array.from(document.querySelectorAll("tr")).filter(i => i.className !== "headRow"); //select all the table rows other than the header
    allRows.forEach(i => i.style.display = ""); //show all the rows

    let filteredRows = Array(); //to store the filtered rows

    //filtering the search result
    if(searchVal.length >= 3){  //if the search value is more than 3 characters (can filter)
        allRows.forEach(row => {    //go each row
            let flag = false;
            const cells = Array.from(row.childNodes);
            cells.forEach(cell => {   //go each cell of that row
                if(cell.innerHTML.toLowerCase().includes(searchVal)){ //if found
                    flag = true;
                }
            });
    
            if(flag === false){ //result not available in the current checking row
                row.style.display = "none"; //hide it
            }
            else{
                row.style.display = "";
                filteredRows.push(row);
            }
        });       
    }
    else{   //show all the rows
        filteredRows = [...allRows];
    }

    //console.log(filteredRows);

    let temp = null;

    if(filteredRows.length === 0){  //no such result
        return;
    }
    else{   //if there are filtered rows
        temp = [...filteredRows];
        filteredRows.length = 0;    //clear the filtered rows array
    }

    //filtering the branch
    if(branchVal !== ""){   //if the user wants to filter the branch
        temp.forEach(i => { //go through search filtered rows
            if(i.classList.contains(branchVal)){    //found a row that matches the branch
                i.style.display = "";
                filteredRows.push(i);   //add the rows to the filtered rows array
            }
            else{
                i.style.display = "none";
            }
        });
    }
    else{
        filteredRows = [...temp];
    }

    //console.log(filteredRows);
 
    //filtering the rating
    if(filteredRows.length === 0){  // no results
        return;
    }
    else{
        temp = [...filteredRows];
        filteredRows.length = 0;
    }

    if(ratingVal !== ""){   //if the user wants to filter the rating 
        temp.forEach(i => {
            if(i.classList.contains("Rating" + ratingVal)){
                i.style.display = "";
                filteredRows.push(i);   //add the rows to the filtered rows array
            }
            else{
                i.style.display = "none";
            }
        }); 
    }

    //console.log(filteredRows);
}

//event listeners

searchBar.addEventListener("keyup", filterFeedback);    //add event listener to the searchbar
branchFilter.addEventListener("change", filterFeedback);  //add event listener to the branchfilter
ratingFilter.addEventListener("change", filterFeedback);  //add event listener to the ratingfilter

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
            filterFeedback(eventObj);
            localStorage.removeItem("feedbackBranch");  //remove the item from the local storage

            branchFilter.value = selectedBranch;    //set the value to display the correct filter option
        }
    })
    .catch(err => console.error(err));