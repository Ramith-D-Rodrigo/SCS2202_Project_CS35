const url = new URL(window.location);   //get the url
const params = new URLSearchParams(url.search); //search parameters
//console.log(params);

const sportName = params.get("sportName");
//console.log(sportName);
const resultContainer = document.getElementById("searchResult");

fetch("../../controller/general/search_controller.php?sportName=".concat(sportName))    //call the controller
    .then((res) => res.json())
    .then((data) => {
        //branch photos
        let branchPhotos = [];
        if(data['errMsg'] !== undefined){   //no sport was found
            const errorMsgDiv = document.createElement("div");
            errorMsgDiv.className = "err-msg";
            errorMsgDiv.id = "err-msg";
            errorMsgDiv.innerHTML = data['errMsg'];
            resultContainer.appendChild(errorMsgDiv);
        }  
        else{
            const branches = data.branches;
            //sort the branches in descending rating order
            branches.sort((a, b) => {
                return b.rating - a.rating;
            });

            for(let i = 0; i < branches.length; i++){   //for each branch result
                const form = document.createElement("form");
                form.className = "branch-row";
                form.action = "/public/general/reservation_schedule.php";
                form.method = "get";

                const photoDiv = document.createElement("div");
                photoDiv.className = "branch-image-container";

                branchPhotos.push(branches[i].photos);  //add the photos to the array

                const photo = document.createElement("img");
                photo.className = "branch-image";
            
                photo.src = branches[i].photos[0];   //first photo
                photo.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");

                //add change photo setInterval
                setInterval(function(){
                    //get random index
                    if(branchPhotos[i] === undefined){  //if there are no photos
                        return;
                    }
                    const arrLength = branchPhotos[i].length;
                    if(arrLength === 1){
                        return; //if there is only one photo, don't change it (to avoid infinite loop)
                    }
                    const randomIndex = Math.floor(Math.random() * branchPhotos[i].length);
                    photo.src = branchPhotos[i][randomIndex];
                }, 3000);

                photoDiv.appendChild(photo);
                form.appendChild(photoDiv);

                const branchInfoDiv = document.createElement("div");

                const sportDiv = document.createElement("div"); //sport name
                sportDiv.innerHTML = "Sport : "+ branches[i].sport_name;
                sportDiv.className = "result-info";
                branchInfoDiv.appendChild(sportDiv);

                const cityDiv = document.createElement("div");  //city
                cityDiv.innerHTML = "Branch : " + branches[i].city;
                cityDiv.className = "result-info";
                branchInfoDiv.appendChild(cityDiv);

                const addressDiv = document.createElement("div");   //address
                addressDiv.innerHTML = "Location : "+ branches[i].address;
                addressDiv.className = "result-info";
                branchInfoDiv.appendChild(addressDiv);

                const ratingDiv = document.createElement("div");    //rating
                ratingDiv.innerHTML = "Rating : ";
                ratingDiv.className = "result-info";

                const rating = document.createElement("span");
                //add stars
                for(let j = 1; j <= 5; j++){
                    const star = document.createElement("i");
                    star.className = "fa fa-star";
                    star.style.margin = "0 2px";
                    star.style.fontSize = "1.5em";
                    if(j <= branches[i].rating){
                        star.className = "fa fa-star checked";
                    }
                    //decimal values for the rating
                    if(branches[i].rating % 1 !== 0 && j === Math.ceil(branches[i].rating)){
                        star.className = "fas fa-star-half-o checked";
                    }
                    rating.appendChild(star);
                }
                ratingDiv.appendChild(rating);
                branchInfoDiv.appendChild(ratingDiv);

                const courtCountDiv = document.createElement("div");    //number of courts
                courtCountDiv.innerHTML = "Number of Courts : "+ branches[i].num_of_courts;
                courtCountDiv.className = "result-info";
                branchInfoDiv.appendChild(courtCountDiv);

                const reservationPrice = document.createElement("div"); //reservation price
                reservationPrice.innerHTML = "Reservation Price : Rs. "+ branches[i].reserve_price;
                reservationPrice.className = "result-info";
                branchInfoDiv.appendChild(reservationPrice);

                const discountDiv = document.createElement("div");  //discount
                if(branches[i].discount === null){
                    discountDiv.innerHTML = "Discount : None";
                }
                else{
                    discountDiv.innerHTML = "Discount : "+ branches[i].discount + "% off";
                }
                discountDiv.className = "result-info";
                branchInfoDiv.appendChild(discountDiv);

                const button = document.createElement("button");
                button.name = "reserveBtn";
                button.value = [branches[i].branchID, branches[i].sport_id];

                button.innerHTML = "Make a Reservation";

                branchInfoDiv.appendChild(button);
                form.appendChild(branchInfoDiv);

                resultContainer.appendChild(form);
            }
            //creating coach content box
            const coachResults = document.createElement("div");
            coachResults.id = "coachResults";
            coachResults.className = "content-box";

            const coachTitle = document.createElement("h2");
            coachTitle.innerHTML = "Coaches";
            coachTitle.style.textAlign = "center";
            coachResults.appendChild(coachTitle);
            
            //creating coach results
            const coaches = data.coaches;
            //sort coaches by rating
            coaches.sort((a, b) => (a.rating < b.rating) ? 1 : -1);

            for(let i = 0; i < coaches.length; i++){
                const form = document.createElement("form");
                form.action = "/public/general/coach_profile.php";
                form.method = "get";
                form.style.margin = "1em 0";

                const coachPicDiv = document.createElement("div");  //coach image
                coachPicDiv.className = "coach-image-container";

                const coachPic = document.createElement("img");   //coach image
                coachPic.className = "coach-image";
                coachPic.src = coaches[i].profilePic;

                coachPic.setAttribute("onerror", "this.src='/styles/icons/no-results.png'");
                coachPicDiv.appendChild(coachPic);
                form.appendChild(coachPicDiv);

                const coachInfoDiv = document.createElement("div");   //coach info
                coachInfoDiv.className = "coachInfo";

                const coachNameDiv = document.createElement("div");  //coach name
                coachNameDiv.className ="info";
                coachNameDiv.innerHTML = "Name : " + coaches[i].coachName;
                coachInfoDiv.appendChild(coachNameDiv);

                const coachSportDiv = document.createElement("div");    //coach sport
                coachSportDiv.className ="info";
                coachSportDiv.innerHTML = "Sport : " + coaches[i].sport;
                coachInfoDiv.appendChild(coachSportDiv);

                const coachRatingDiv = document.createElement("div");   //coach rating
                coachRatingDiv.className ="info";
                coachRatingDiv.innerHTML = "Rating : ";
                const coachRating = document.createElement("span");

                //set the rating
                for(let j = 1; j <= 5; j++){
                    const star = document.createElement("i");
                    star.className = "fa fa-star";
                    star.style.margin = "0 0.2em";
                    star.style.fontSize = "1.5em";
                    if(j <= coaches[i].rating){
                        star.className = "fa fa-star checked";
                    }
                    //if the rating is a decimal, add a half star
                    if(j == Math.ceil(coaches[i].rating) && coaches[i].rating % 1 != 0){
                        star.className = "fa fa-star-half-o checked";
                    }
                    coachRating.appendChild(star);
                }
                
                coachRatingDiv.appendChild(coachRating);
                coachInfoDiv.appendChild(coachRatingDiv);

                //hidden input for coach id
                const coachID = document.createElement("input");    
                coachID.type = "hidden";
                coachID.name = "coachID";
                coachID.value = coaches[i].coachID;
                coachInfoDiv.appendChild(coachID);

                //view profile btn
                const button = document.createElement("button");
                button.innerHTML = "View Profile";
                button.type = "submit";
                coachInfoDiv.appendChild(button);

                form.appendChild(coachInfoDiv);
                coachResults.appendChild(form);
            }

            resultContainer.parentNode.appendChild(coachResults);
        }
    });
