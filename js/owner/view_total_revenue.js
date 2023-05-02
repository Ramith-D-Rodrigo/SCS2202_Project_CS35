const fromDate = document.getElementById("from1");
const toDate = document.getElementById("to1");
const branch = document.getElementById("branch1");
const sport = document.getElementById("sport1");
const errMsg = document.getElementById("err-msg1");

const today = new Date();
const lastYear = new Date(new Date().setFullYear(new Date().getFullYear()-1)).toISOString().split('T')[0];
    
fromDate.setAttribute("max",today.toISOString().split("T")[0]);
toDate.setAttribute("max",today.toISOString().split("T")[0]);

fromDate.setAttribute("min",lastYear);
toDate.setAttribute("min",lastYear);

var branchData = {};

// console.log(fromDate.max);
fetch("../../controller/owner/branch_info_revenue_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        branchData = data;
        for(let i=0; i<data.length; i++){
            const option = document.createElement("option");
            option.value = data[i]['basicInfo'].branchID;
            option.innerHTML = data[i]['basicInfo'].city;
            branch.appendChild(option);
        }
    });
function filterSports(event){
    if(branch.value !== ''){
        const branchID = branch1.value;
        for(let i=0; i<branchData.length; i++){
            if(branchData[i]['basicInfo'].branchID == branchID){
                for(let j=0; j<branchData[i]['sports'].length; j++){
                    const option = document.createElement("option");
                    option.value = branchData[i]['sports'][j].sportID;
                    option.innerHTML = branchData[i]['sports'][j].sportName;
                    sport1.appendChild(option);
                }
                break;
            }
        }
    }else{
        sport1.innerHTML = '';
        const option = document.createElement("option");
        option.value = 'all';
        option.innerHTML = 'All Sports';
        sport1.appendChild(option);
    }
}

function displayChart(event){
    console.log(fromDate.value);
    errMsg.innerHTML = '';
    const from = new Date(fromDate.value);
    const to = new Date(toDate.value);

    if(from>to || fromDate.min<lastYear || toDate.min<lastYear || fromDate.max>today || toDate.max>today){
        errMsg.innerHTML = "Invalid date input or date range";
    }
    
    if(errMsg.innerHTML === "" && fromDate.value !== '' && toDate.value !== '' &&  branch.value !== ''){

        var days = Math.ceil(to-from)/(1000*60*60*24);  //get the count of days between the two dates
        days = days+1;  //including the first day itself(from date)
        currDate = fromDate.value;
        console.log(days);
        var xLabels = [];
        var dataSet = [];
        
        if(days<=30){     
            fetch("../../controller/owner/get_total_revenue_controller.php?branchID=".concat(branch.value,"&from=",currDate,"&to=",currDate,"&days=",days,"&sport=",sport.value))
            .then(res => res.json())
            .then(data => {
                console.log(data);
                for(let i=0; i<data.length; i++){
                    xLabels.push(data[i].date);
                    dataSet.push(data[i].revenue);
                }
                var ctx = document.getElementById("myChart").getContext("2d");
                if (window.myChart instanceof Chart) {
                    window.myChart.destroy(); // destroy the previous chart instance
                }
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);   //adding gradient to the chart
                gradient.addColorStop(0, '#6F0808');
                gradient.addColorStop(0.45, '#000000');
                gradient.addColorStop(0.7845, '#000956');
                window.myChart = new Chart(ctx, {  //have to wait for the data to be fetched
                    type: 'bar',
                    data: {
                        labels: xLabels, // use date values as labels
                        datasets: [{
                            label: 'Total Income (Coach Session Payments + Court Bookings)',
                            data: dataSet, // use income values as data
                            backgroundColor: gradient,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        }]
                    },
                });
            });

            
        }else{
            fetch("../../controller/owner/get_total_revenue_controller.php?branchID=".concat(branch.value,"&from=",currDate,"&to=",currDate,"&days=",days,"&sport=",sport.value))
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
                var ctx = document.getElementById("myChart").getContext("2d");;
                if (window.myChart instanceof Chart) {
                    window.myChart.destroy(); // destroy the previous chart instance
                }
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);   //adding gradient to the chart
                gradient.addColorStop(0, '#6F0808');
                gradient.addColorStop(0.45, '#000000');
                gradient.addColorStop(0.7845, '#000956');
                window.myChart = new Chart(ctx, {  //have to wait for the data to be fetched
                    type: 'bar',
                    data: {
                        labels: xLabels, // use date values as labels
                        datasets: [{
                            label: 'Total Income (Coach Session Payments + Court Bookings))',
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
        var ctx = document.getElementById("myChart").getContext("2d");
        if (window.myChart instanceof Chart) {
            window.myChart.destroy(); // destroy the previous chart instance
        }
    }
}

fromDate.addEventListener("change",displayChart);
toDate.addEventListener("change",displayChart);
branch.addEventListener("change",displayChart);
sport.addEventListener("change",displayChart);
branch.addEventListener("change",filterSports);