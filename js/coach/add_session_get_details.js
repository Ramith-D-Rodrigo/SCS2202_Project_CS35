const branchSelect = document.querySelector('#branch');

fetch("../../controller/coach/add_new_session_entry_controller.php")
.then(res => res.json())
.then(data  => {
    console.log(data);
   const branchDetails = data.branchAndCourts;

    for(let i = 0; i < branchDetails.length; i++){
        const option = document.createElement("option");
        option.value = branchDetails[i].branchID;
        option.text = branchDetails[i].city;

        branchSelect.appendChild(option);
    }
    const courtSelect = document.querySelector('#Court');

    branchSelect.addEventListener('change',(e) =>{
        const brValue = branchSelect.value;
        const selectedBranch = branchDetails.filter(branch => branch.branchID === brValue)[0];

        for(let i = 0; i < selectedBranch.courts.length; i++){
            const option = document.createElement("option");
            option.value = selectedBranch.courts[i].courtID;
            option.text = selectedBranch.courts[i].courtName;

            courtSelect.appendChild(option);
        }
        
        const openTime = document.querySelector('#startingTime');
        openTime.value = selectedBranch.openingTime;

        const closeTime = document.querySelector('#closedTime');
        closeTime.value = selectedBranch.closingTime;
            
        const intputStartingTime = document.querySelector('#StartingTime');//validation for session starting time
           
            intputStartingTime.addEventListener('change', (e)=>{
                const min = e.target.value.split(":")[1];
                
            
                    if(!(min == '00' || min == '30') ){
                        e.target.style.border = "medium solid red";
                    
                    }
                    else{
                        e.target.style.border = "none";
                            }
                            const errorMsg = document.getElementById("errmsg");
                            const errorMsg1 = document.getElementById("errmsg1");
                            const BranchOpeningTime = document.getElementById("opening_time")
                            // console.log(e.target.value);
                        
                            if(EndingTime.value === ""){
                                return;
                            }
                            if(selectedBranch.openingTime>e.target.value )
                               { errorMsg1.innerHTML = "Should be withing branch opening hours";
                                    return; } 
                                    errorMsg1.innerHTML = "";
                        
                            const stTime = e.target.value.split(":");
                            const enTime = EndingTime.value.split(":");
                        
                            const start = new Date();
                            start.setHours(stTime[0]);
                            start.setMinutes(enTime[1]);
                        
                            const end = new Date();
                            end.setHours(enTime[0])
                            end.setMinutes(enTime[1]);

                });


        const intputEndingTime = document.querySelector('#EndingTime');//validation for session Ending time
            
            intputEndingTime.addEventListener('change', (e)=>{
                const min = e.target.value.split(":")[1];

                    if(!(min == '00' || min == '30') ){
                        e.target.style.border = "medium solid red";
                    }
                    else{
                        e.target.style.border = "none";
                    }

                    const errorMsg = document.getElementById("errmsg");
                    const errorMsg1 = document.getElementById("errmsg1");
                   // const BranchClosingTime = document.getElementById("closing_time")
                    // console.log(e.target.value);
                
                    if(StartingTime.value === ""){
                        return;
                    }
                   if( selectedBranch.closingTime<e.target.value  )
                       { errorMsg1.innerHTML = "Should be withing branch opening hours";
                            return; } 
                            errorMsg1.innerHTML = "";
                
                        
                    const enTime = EndingTime.value.split(":");
                    const stTime = StartingTime.value.split(":");
                
                    const start = new Date();
                    start.setHours(stTime[0]);
                    start.setMinutes(stTime[1]);
                
                    const end = new Date();
                    end.setHours(enTime[0])
                    end.setMinutes(enTime[1]);    
            
          });

            const enTime = EndingTime.value.split(":");
            const stTime = StartingTime.value.split(":");

            const start = new Date();
            start.setHours(stTime[0]);
            start.setMinutes(stTime[1]);
          //  console.log(start);

            const end = new Date();
            end.setHours(enTime[0])
            end.setMinutes(enTime[1]);
           // console.log(end);


            if(e.target.style.border === "medium solid red" || StartingTime.style.border === "medium solid red"){  //invalid time input
                monthly_payment.value = "";
                return;
            }
            const timeDifferenceMilli = end - start;

            if(timeDifferenceMilli <= 0){ //ending time is lower than starting time
                errorMsg1.innerHTML = "Invalid Time Range";
                monthly_payment.value = "";
                return;
            }
            errorMsg1.innerHTML = "";
            const timeDifferenceHours = ((timeDifferenceMilli/1000)/60)/60;
        
            if(timeDifferenceHours < 1){  //minimum reservation time period
                errorMsg.innerHTML = "Minimum Session Period is 1 Hour";
                monthly_payment.value = "";
                return;
            }
            else if(timeDifferenceHours > 6){ //maximum reservation time period
                errorMsg.innerHTML = "Maximum Session Period is 6 Hours";
                monthly_payment.value = "";
                return;
            }
            errorMsg.innerHTML = "";
            console.log(timeDifferenceHours);

        

    });

    branchSelect.dispatchEvent(new Event("change"));

        

})