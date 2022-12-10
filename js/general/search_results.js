const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const sportName = params.get("sportName");
//console.log(sportName);
const resultContainer = document.getElementById("searchResult");

fetch("../../controller/general/search_controller.php?sportName=".concat(sportName))    //call the controller
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        if(data['errMsg'] !== undefined){   //no sport was found
            const errorMsgDiv = document.createElement("div");
            errorMsgDiv.className = "err-msg";
            errorMsgDiv.id = "err-msg";
            errorMsgDiv.innerHTML = data['errMsg'];
            resultContainer.appendChild(errorMsgDiv);
        }  
        else{
            for(i = 0; i < data.length; i++){   //for each branch result
                const form = document.createElement("form");
                form.className = "search_result";
                form.action = "/public/general/reservation_schedule.php";
                form.method = "get";

                const sportDiv = document.createElement("div");
                sportDiv.innerHTML = "Sport : "+ data[i].sport_name;
                form.appendChild(sportDiv);

                const cityDiv = document.createElement("div");
                cityDiv.innerHTML = "Branch : " + data[i].city;
                form.appendChild(cityDiv);

                const courtCountDiv = document.createElement("div");
                courtCountDiv.innerHTML = "Number of Courts : "+ data[i].num_of_courts;
                form.appendChild(courtCountDiv);

                const reservationPrice = document.createElement("div");
                reservationPrice.innerHTML = "Reservation Price : Rs. "+ data[i].reserve_price;
                form.appendChild(reservationPrice);

                const button = document.createElement("button");
                button.name = "reserveBtn";
                button.value = [data[i].branchID, data[i].sport_id];

                button.innerHTML = "Make a Reservation";
                form.appendChild(button);

                resultContainer.appendChild(form);
            }
            //creating coach content box
            const coachResults = document.createElement("div");
            coachResults.style = "flex:auto; text-align:center";
            coachResults.id = "coachResults";
            coachResults.className = "content-box";
            coachResults.innerHTML = "Coaches";
            console.log(coachResults);
            resultContainer.parentNode.appendChild(coachResults);
        }
    });
