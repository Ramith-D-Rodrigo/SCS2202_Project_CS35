const coachListDivContainer = document.getElementById("coachList");
const sportsFilter = document.getElementById("sportSelect");

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
            coachInfoDiv.className = "coach-row";

            const coachImgContainer = document.createElement("div");
            coachImgContainer.className = "coach-image-container";

            const coachImg = document.createElement("img");
            coachImg.setAttribute("class", "coach-image");

            coachImg.setAttribute("src", data[i].photo);
            coachImg.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

            coachImgContainer.appendChild(coachImg);
            coachInfoDiv.appendChild(coachImgContainer);

            const formDiv = document.createElement("div");
            const form = document.createElement("form");

            form.id = data[i].coachID; //coach id for each form
            form.className = "coachInfo";
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
            sportSet.add(data[i].sport);

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
        sportsFilter.addEventListener("change", () => {
            const sport = sportsFilter.value;   //get selected sport

            const coachList = document.getElementsByClassName("coachInfo"); //get all coach info divs

            for(let j = 0; j < coachList.length; j++){
                const coachSport = coachList[j].children[1].innerHTML.split(" : ")[1];  //get the sport of that coach

                if(sport === ""){   //if no sport is selected, show all coaches
                    coachList[j].parentElement.parentElement.style.display = "flex";
                }
                else if(coachSport === sport){
                    coachList[j].parentElement.parentElement.style.display = "flex";
                }
                else{
                    coachList[j].parentElement.parentElement.style.display = "none";
                }
            }
        });
    })