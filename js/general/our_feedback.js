
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
    const tableCells = Array.from(document.querySelectorAll("tr"));
    const filteredCells = tableCells.filter(i => i.id === e.target.id);

    const filteredRows = filteredCells.filter(i => i.parentElement);
    console.log(filteredRows);
}



fetch("../../controller/general/our_feedback_controller.php")
    .then(res => res.json())
    .then(data =>{
        console.log(data);
        const tableBody = document.querySelector("tbody");

        const dataKeys = Object.keys(data);

        const branchInfo = [];  //array to store all branches (branch id and the city)

        const branchFilter = document.getElementById("branchFilter");
        //need to add the event listener

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

            console.log(data[dataKeys[i]]);

            for(j = 0; j < data[dataKeys[i]].length; j++){    //traversing each feedback for a particular branch
                //console.log(data[dataKeys[i]][j].description);
                const feedbackRow = document.createElement("tr");   //feedback row

                const dateCell = document.createElement("td");  //date cell
                dateCell.innerHTML = data[dataKeys[i]][j].date;
                feedbackRow.appendChild(dateCell);

                const branchCell = document.createElement("td");    //branch cell
                branchCell.innerHTML = currBranch.branchCity;
                branchCell.id = currBranch.branchID;
                feedbackRow.appendChild(branchCell);

                const feedbackCell = document.createElement("td");    //rating cell
                feedbackCell.innerHTML = data[dataKeys[i]][j].description;
                feedbackRow.appendChild(feedbackCell);

                const ratingCell = document.createElement("td");    //rating cell
                ratingCell.innerHTML = data[dataKeys[i]][j].rating;
                feedbackRow.appendChild(ratingCell);

                branchFeedbacks.push(feedbackRow);
            }
        }
        
        //console.log(branchFeedbacks);
        branchFeedbacks.sort(sortByDate);
        console.log(branchFeedbacks);

        branchFeedbacks.forEach(i => tableBody.appendChild(i)); //append the table rows

        

    })
    .catch(err => console.error(err));