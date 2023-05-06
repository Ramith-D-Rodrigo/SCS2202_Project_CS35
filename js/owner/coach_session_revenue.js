const fromDate2 = document.getElementById("from2");
const toDate2 = document.getElementById("to2");
const branch2 = document.getElementById("branch2");
const sport2 = document.getElementById("sport2");
const errMsg2 = document.getElementById("err-msg2");

const today2 = new Date();
const lastYear2 = new Date(new Date().setFullYear(new Date().getFullYear()-1)).toISOString().split('T')[0];
    
fromDate2.setAttribute("max",today2.toISOString().split("T")[0]);
toDate2.setAttribute("max",today2.toISOString().split("T")[0]);

fromDate2.setAttribute("min",lastYear2);
toDate2.setAttribute("min",lastYear2);

var branchData2 = {};

// console.log(fromDate.max);
fetch("../../controller/owner/branch_info_revenue_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        branchData2 = data;
        for(let i=0; i<data.length; i++){
            const option = document.createElement("option");
            option.value = data[i]['basicInfo'].branchID;
            option.innerHTML = data[i]['basicInfo'].city;
            branch2.appendChild(option);
        }
    });
function filterSports(event){
    if(branch2.value !== ''){
        const branchID = branch2.value;
        sport2.innerHTML = '';
        const option = document.createElement("option");   
        option.value = 'all';
        option.innerHTML = 'All Sports';   //default option
        sport2.appendChild(option);
        for(let i=0; i<branchData2.length; i++){
            if(branchData2[i]['basicInfo'].branchID == branchID){
                for(let j=0; j<branchData2[i]['sports'].length; j++){
                    const option = document.createElement("option");
                    option.value = branchData2[i]['sports'][j].sportID;
                    option.innerHTML = branchData2[i]['sports'][j].sportName;
                    sport2.appendChild(option);
                }
                break;
            }
        }
    }else{
        sport2.innerHTML = '';
        const option = document.createElement("option");
        option.value = 'all';
        option.innerHTML = 'All Sports';
        sport2.appendChild(option);
    }
}

function displayChart(event){
    console.log(fromDate2.value);
    errMsg.innerHTML = '';
    const from = new Date(fromDate2.value);
    const to = new Date(toDate2.value);

    if(from>to || fromDate2.min<lastYear2 || toDate2.min<lastYear2 || fromDate2.max>today2 || toDate2.max>today2){
        errMsg.innerHTML = "Invalid date input or date range";
    }
    
    if(errMsg.innerHTML === "" && fromDate2.value !== '' && toDate2.value !== '' &&  branch2.value !== ''){

        var days = Math.ceil(to-from)/(1000*60*60*24);  //get the count of days between the two dates
        days = days+1;  //including the first day itself(from date)
        currDate = fromDate2.value;
        console.log(days);
        var xLabels = [];
        var dataSet = [];
        
        if(days<=30){     
            fetch("../../controller/owner/get_coaching_session_revenue_controller.php?branchID=".concat(branch2.value,"&from=",currDate,"&to=",currDate,"&days=",days,"&sport=",sport2.value))
            .then(res => res.json())
            .then(data => {
                console.log(data);
                for(let i=0; i<data.length; i++){
                    xLabels.push(data[i].date);
                    dataSet.push(data[i].revenue);
                }
                var ctx = document.getElementById("myChart2").getContext("2d");
                if (window.myChart2 instanceof Chart) {
                    window.myChart2.destroy(); // destroy the previous chart instance
                }
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);   //adding gradient to the chart
                gradient.addColorStop(0, '#6F0808');
                gradient.addColorStop(0.45, '#000000');
                gradient.addColorStop(0.7845, '#000956');
                window.myChart2 = new Chart(ctx, {  //have to wait for the data to be fetched
                    type: 'bar',
                    data: {
                        labels: xLabels, // use date values as labels
                        datasets: [{
                            label: 'Income (Coaching Session Payments)',
                            data: dataSet, // use income values as data
                            backgroundColor: gradient,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        }]
                    },
                });
            });

            
        }else{
            fetch("../../controller/owner/get_coaching_session_revenue_controller.php?branchID=".concat(branch2.value,"&from=",currDate,"&to=",currDate,"&days=",days,"&sport=",sport2.value))
            .then(res => res.json())
            .then(data => {
                // console.log(data);
                var revenue = 0;
                var start = data[0].date;
                const columnCount = Math.floor(days/30);  //divide the data into 30 day columns
                for(let i=0; i<data.length; i++){   
                    if(i<columnCount*30){    //if the data is not in the last column
                        revenue += data[i].revenue;
                        if(i!==0 && i%29===0){
                            xLabels.push(start.concat(">>",data[i].date));
                            dataSet.push(revenue);
                            start = data[i+1].date;
                            revenue = 0;
                        }
                        
                    }else{      //if the data is in the last column
                        revenue += data[i].revenue;
                        if(i===data.length-1){
                            xLabels.push(start.concat(">>",data[i].date));
                            dataSet.push(revenue);
                        }
                        
                    }  
                }
                console.log(xLabels);
                console.log(dataSet);  
                var ctx = document.getElementById("myChart2").getContext("2d");;
                if (window.myChart2 instanceof Chart) {
                    window.myChart2.destroy(); // destroy the previous chart instance
                }
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);   //adding gradient to the chart
                gradient.addColorStop(0, '#6F0808');
                gradient.addColorStop(0.45, '#000000');
                gradient.addColorStop(0.7845, '#000956');
                window.myChart2 = new Chart(ctx, {  //have to wait for the data to be fetched
                    type: 'bar',
                    data: {
                        labels: xLabels, // use date values as labels
                        datasets: [{
                            label: 'Income (Coaching Session Payments)',
                            data: dataSet, // use income values as data
                            backgroundColor: gradient,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        }]
                    },
                });
            });
        }   
    }else{
        var ctx = document.getElementById("myChart2").getContext("2d");
        if (window.myChart2 instanceof Chart) {
            window.myChart2.destroy(); // destroy the previous chart instance
        }
    }
}

fromDate2.addEventListener("change",displayChart);
toDate2.addEventListener("change",displayChart);
branch2.addEventListener("change",displayChart);
sport2.addEventListener("change",displayChart);
branch2.addEventListener("change",filterSports);