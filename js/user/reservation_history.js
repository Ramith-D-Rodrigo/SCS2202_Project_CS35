const reservationHistory = document.getElementById("reservationHistoryBox");


fetch("../../controller/user/reservation_history_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        if(data.length === 0){  //no reservations
            const errDiv = document.createElement("div");
            errDiv.className = "err-msg";
            errDiv.innerHTML = "You have not made any reservations yet.";
            reservationHistory.appendChild(errDiv);
        }
        else{   //has reservations
            const reservationTable = document.createElement("table");

            const headers = ["Reservation ID", "Date", "Time Period", "Sport", "Branch", "Court", "Payment Amount", "Status", "Action"];
            const tableHeader = document.createElement("thead");
            const headerRow = document.createElement("tr");

            for(h = 0; h < headers.length; h++){    //creating table headers
                const currHead = document.createElement("td");
                currHead.innerHTML = headers[h];
                headerRow.appendChild(currHead);
            }

            tableHeader.appendChild(headerRow);
            reservationTable.appendChild(tableHeader);

            const tBody = document.createElement("tbody");

            for(i = 0; i < data.length; i++){
                const currRow = document.createElement("tr");
                
                const currResID = document.createElement("td"); //reservation id
                currResID.innerHTML = data[i].reservationID;
                currRow.appendChild(currResID);

                const currDate = document.createElement("td");  //date
                currDate.innerHTML = data[i].date;
                currRow.appendChild(currDate);

                const currTimePeriod = document.createElement("td");    //time period
                const startingTimeArr = data[i].startingTime.split(":"); //setting starting time
                const startingTime = new Date();
                startingTime.setHours(startingTimeArr[0]);
                startingTime.setMinutes(startingTimeArr[1]);
                startingTime.setSeconds(startingTimeArr[2]);

                const endingTimeArr = data[i].endingTime.split(":"); //setting ending time
                const endingTime = new Date();
                endingTime.setHours(endingTimeArr[0]);
                endingTime.setMinutes(endingTimeArr[1]);
                endingTime.setSeconds(endingTimeArr[2]); 

                currTimePeriod.innerHTML = startingTime.toLocaleTimeString() + " to " + endingTime.toLocaleTimeString();
                currRow.appendChild(currTimePeriod);

                const currSport = document.createElement("td");  //reserved sport
                currSport.innerHTML = data[i].sport;
                currRow.appendChild(currSport);

                const currBranch = document.createElement("td");  //branch
                currBranch.innerHTML = data[i].branch;
                currRow.appendChild(currBranch);

                const currCourt = document.createElement("td");  //Court
                currCourt.innerHTML = data[i].court_name;
                currRow.appendChild(currCourt);

                const currPaymentAmount = document.createElement("td");  //payment amount
                currPaymentAmount.innerHTML = data[i].paymentAmount;
                currRow.appendChild(currPaymentAmount);

                const currStatus = document.createElement("td");  //status
                currStatus.innerHTML = data[i].status;
                currRow.appendChild(currStatus);

                const currAction = document.createElement("td");  //action cell


                if(data[i].status === 'Pending'){   //can cancel
                    const cancelForm = document.createElement("form");
                    cancelForm.action = "/controller/user/cancel_reservation_controller.php";
                    cancelForm.method = "post";

                    const cancelBtn = document.createElement("button");
                    cancelBtn.type = "submit";
                    cancelBtn.name = data[i].reservationID;
                    cancelBtn.innerHTML = "Cancel";

                    cancelForm.appendChild(cancelBtn);
                    currAction.appendChild(cancelForm);
                }
                else if(data[i].status === 'Cancelled'){    

                }
                else if(data[i].status === 'Checked In' || data[i].status === 'Declined'){  //can give feedback
                    const feedbackBtn = document.createElement("button");
                    feedbackBtn.innerHTML = "Give Feedback";
                    currAction.appendChild(feedbackBtn);
                }
                currRow.appendChild(currAction);

                tBody.appendChild(currRow); //append the row
/*
                        <table>
                            <tbody>
                                <tr>
                                    <th>Reservation ID</th>
                                    <th>Date</th>
                                    <th>Time Period</th>
                                    <th>Sport</th>
                                    <th>Branch</th>
                                    <th>Court</th>
                                    <th>Payment Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            <?php foreach($_SESSION['reservationHistory'] as $row){
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $row -> reservation_id?></td>
                                    <td><?php echo $row -> date?></td>
                                    <td><?php echo $row -> time_period?></td>
                                    <td><?php echo $row -> sport_name?></td>
                                    <td><?php echo $row -> city?></td>
                                    <td><?php echo $row -> court_name?></td>
                                    <td><?php echo "Rs.".$row -> payment_amount?></td>
                                    <td><?php echo $row -> status?></td>
                                    <td>
                                    <?php
                                        if($row -> status === 'Pending'){   //if its pending, the user can cancel but can't give feedback
                                    ?>

                                            <form action="/controller/user/cancel_reservation_controller.php" method="post">
                                                <button type="submit" name="cancelBtn" value=<?php echo "userReserveHis".$i; ?>>Cancel</button>
                                            </form>
                                    <?php
                                        }
                                        else if($row -> status === 'Cancelled'){    //the user cannot cancel nor give feedback
                                    
                                        }
                                        else if($row -> status === 'Checked In' || $row -> status === 'Declined'){   //the user cannot cancel anymore, but can give feedback
                                    ?>
                                            <button>Give Feedback</button>
                                    <?php
                                        }
                                    ?>
                                    </td>
                                </tr>
                            <?php
                                $_SESSION["userReserveHis".$i] = $row -> reservation_id;    //get the reservationID for each for buttons 
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
*/
            }
            reservationTable.appendChild(tBody);
            reservationHistory.appendChild(reservationTable);
        }

    })