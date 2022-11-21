const result = document.getElementById("branches");

fetch("../../controller/general/our_branches_controller.php")
    .then((res) => res.json())
    .then((data) => {
        let branches = [];
        for(i = 0; i < data.length; i++){
            branches[i] = JSON.parse(data[i]);  //convert and store the json objects in the array
            console.log(branches[i]);
            const branchRow = document.createElement("div");
            branchRow.setAttribute("class", "branch-row");

            const branchImageContainer = document.createElement("div");
            branchImageContainer.setAttribute("class","branch-image-container");

            const branchImage = document.createElement("img");
            branchImage.src = "/public/general/branch/" + branches[i].photos;
            branchImage.setAttribute("class", "branch-image");
            branchImage.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

            branchImageContainer.appendChild(branchImage);
            branchRow.appendChild(branchImage);

            const formDiv = document.createElement("div");
            const form = document.createElement("form");
            form.className = "search_result";
            form.action = "/controller/general/user_selection_controller.php";
            form.method = "post";

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

            form.innerHTML = "Location : " + branches[i].city + "<br>" +
                             "Address : " + branches[i].address + "<br>" +
                             "Email : " + branches[i].email + "<br>" +
                             "Opening Time : " + openingTime.toLocaleTimeString() + "<br>" +
                             "Closing Time : " + closingTime.toLocaleTimeString() + "<br>";

            const reserveBtn = document.createElement("button");
            reserveBtn.innerHTML = "Make a Reservation";
            reserveBtn.type = "submit";

            form.appendChild(reserveBtn);

            formDiv.appendChild(form);
            branchRow.appendChild(formDiv);

            result.appendChild(branchRow);
        }
    });



