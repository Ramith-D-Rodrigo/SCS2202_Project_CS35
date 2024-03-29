const coachListDivContainer = document.getElementById("coachList");
const sportsFilter = document.getElementById("sportSelect");
const showFilter = document.getElementById("showSelect");


fetch("../../controller/general/reg_coaches_controller.php")
    .then(res => res.json())
    .then(data => {

        let sportSet = new Set();

        //sort the coach list in descending rating order
        data.sort((a, b) => {
            return b.rating - a.rating;
        });

        for(let i = 0; i < data.length; i++){
            const coachInfoDiv = document.createElement("div");
            coachInfoDiv.className = "coach";
            coachInfoDiv.classList.add("content-box");

            const coachImgContainer = document.createElement("div");
            coachImgContainer.className = "coach-image-container";

            const coachImg = document.createElement("img");
            coachImg.setAttribute("class", "coach-image");

            coachImg.setAttribute("src", data[i].photo);
            coachImg.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

            coachImgContainer.appendChild(coachImg);
            coachInfoDiv.appendChild(coachImgContainer);

            const formDiv = document.createElement("div");
            formDiv.className = "coach-info";
            const form = document.createElement("form");

            form.id = data[i].coachID; //coach id for each form
            form.action = "/public/general/coach_profile.php";
            form.method = "get";

            let name = '';

            if(data[i].gender === 'm'){
                name = "Mr. " + data[i].firstName + " " + data[i].lastName;
            }
            else{
                name = "Mrs. " + data[i].firstName + " " + data[i].lastName;
            }

            const nameDiv = document.createElement("div");  //coach name
            nameDiv.className = "info";
            nameDiv.innerHTML = "Name : " + name;

            form.appendChild(nameDiv);

            const sportDiv = document.createElement("div"); //coach sport
            sportDiv.className = "info";
            sportDiv.innerHTML = "Sport : " + data[i].sport;

            //add sport to set
            sportSet.add(data[i].sport);

            //add sport name as a class to the coach div
            coachInfoDiv.classList.add(data[i].sport);

            form.appendChild(sportDiv);

            const ratingDiv = document.createElement("div");    //coach rating
            ratingDiv.className = "info";
            ratingDiv.innerHTML = "Rating : ";

            //create rating stars
            for(let j = 1; j <= 5; j++){
                const star = document.createElement("i");
                star.className = "fa fa-star";
                star.style.margin = "0 0.2em";
                star.style.fontSize = "1.5em";

                if(j <= data[i].rating){
                    star.classList.add("checked");
                }

                //decimal rating
                if(data[i].rating % 1 !== 0 && j === Math.ceil(data[i].rating)){
                    star.className = "fa-solid fa-star-half-stroke checked";
                }

                ratingDiv.appendChild(star);
            }

            form.appendChild(ratingDiv);

            const profileBtn = document.createElement("button");
            profileBtn.type = "submit";
            profileBtn.name = "coachID";
            profileBtn.value = data[i].coachID;
            profileBtn.innerHTML = "View Profile";
            form.appendChild(profileBtn);

            formDiv.appendChild(form);
            coachInfoDiv.appendChild(formDiv);
            coachListDivContainer.appendChild(coachInfoDiv);
        }

        //create sport filter options
        for(let sport of sportSet){
            const option = document.createElement("option");
            option.value = sport;
            option.innerHTML = sport;
            sportsFilter.appendChild(option);
        }

        //add event listener to filter coaches by sport
        sportsFilter.addEventListener("change", CoachFilter);

        //show filter

        //get the count of coaches
        const coachCount = data.length;
        let inc = 0;

        while(inc < coachCount){
            inc += 5;

            if(inc > coachCount){   //if the increment is greater, then break
                break;
            }
            //otherwise can add option for increment of 5

            //create option for select element
            const option = document.createElement("option");
            option.value = inc;
            option.innerHTML = inc;

            //add option to select element
            showFilter.appendChild(option);
        }


        //add event listener to filter coaches by count
        showFilter.addEventListener("change", CoachFilter);
    })

const CoachFilter = () => {
    //get the sport selected
    const sport = sportsFilter.value;

    //get the count selected
    const count = showFilter.value;

    //get the coach list
    const coachList = document.getElementsByClassName("coach");

    let currDisplayingCoaches  = [];

    //first display all coaches
    for(let i = 0; i < coachList.length; i++){
        coachList[i].style.display = "flex";
        currDisplayingCoaches.push(coachList[i]);
    }

    if(sport === "" && count === ""){   //if no filter is selected, return
        return;
    }

    //now filter by sport
    for(let i = 0; i < currDisplayingCoaches.length; i++){
        const coachSport = currDisplayingCoaches[i].classList[2];

        if(sport === ""){
            currDisplayingCoaches[i].style.display = "flex";
        }
        else if(coachSport === sport){
            currDisplayingCoaches[i].style.display = "flex";
        }
        else{
            currDisplayingCoaches[i].style.display = "none";

            //remove coach from currDisplayingCoaches
            currDisplayingCoaches.splice(i, 1);
            i--;    //decrement i to account for the removed coach
        }
    }


    if(count === ""){   //if no count is selected, return
        return;
    }

    if(currDisplayingCoaches.length < count){   //if the count is greater than the number of coaches, return
        return;
    }

    if(currDisplayingCoaches.length === count){   //if the count is equal to the number of coaches, return
        return;
    }

    if(currDisplayingCoaches.length === 0){   //if there are no coaches, return
        return;
    }

    //now filter by count
    for(let i = 0; i < currDisplayingCoaches.length; i++){
        if(i < count){
            currDisplayingCoaches[i].style.display = "flex";
        }
        else{
            currDisplayingCoaches[i].style.display = "none";
        }
    }
}