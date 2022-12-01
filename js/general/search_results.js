const errorMsgDiv = document.getElementById("err-msg");
const sportName = document.URL.split("?")[1];   //get the sportName for get request


fetch("../../controller/general/search_controller.php?".concat(sportName))
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        if(data['errMsg'] !== undefined){
            errorMsgDiv.innerHTML = data['errMsg'];
        }  
        else{
            for(i = 0; i < data.length; i++){
                const form = document.createElement("form");
                form.className = "search_result";
                form.action = "/controller/general/reservation_schedule_controller.php";
                form.method = "post";

                const cityDiv = document.createElement("div");
                cityDiv.innerHTML = "Branch : " + data[i].city;
                form.appendChild(cityDiv);

                const sportDiv = document.createElement("div");
                sportDiv.innerHTML = "Sport : "+ data[i].sport_name;
                form.appendChild("sportDiv");

                const courtCountDiv = document.createElement("div");
                courtCountDiv.innerHTML = "Number of Courts : "+ data[i].num_of_courts;
                form.appendChild("courtCountDiv");

                const reservationPrice = document.createElement("div");
                reservationPrice.innerHTML = "Reservation Price : "+ data[i].reserve_price;
                form.appendChild("courtCountDiv");

                const button = document.createElement("button");
                button.type = "submit";
                button.name = "reserveBtn";
                button.value = "result"

            }
            <form class ="search_result" action="/controller/general/reservation_schedule_controller.php" method="post">
            Branch : <?php echo $result['location']; ?>
            <br>
            Sport : <?php echo $result['sport_name']; ?>
            <br>
            Number of Courts : <?php echo $result['num_of_courts']; ?>
            <br>
            Reservation Price : <?php echo $result['reserve_price']; ?> per hour
            <button style="margin-left:10px" 
            type ="submit" 
            name ="reserveBtn" 
            value="<?php echo "result".$j?>">Make a Reservation</button>
            </form>
        }
    })