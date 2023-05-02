const fromDate3 = document.getElementById("from3");
const toDate3 = document.getElementById("to3");
const branch3 = document.getElementById("branch3");
const sport3 = document.getElementById("sport3");
const errMsg3 = document.getElementById("err-msg3");

const today3 = new Date();
const lastYear3 = new Date(new Date().setFullYear(new Date().getFullYear()-1)).toISOString().split('T')[0];
    
fromDate3.setAttribute("max",today3.toISOString().split("T")[0]);
toDate3.setAttribute("max",today3.toISOString().split("T")[0]);

fromDate3.setAttribute("min",lastYear3);
toDate3.setAttribute("min",lastYear3);

var branchData3 = {};

// console.log(fromDate3.max);
fetch("../../controller/owner/branch_info_revenue_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
        branchData3 = data;
        for(let i=0; i<data.length; i++){
            const option = document.createElement("option");
            option.value = data[i]['basicInfo'].branchID;
            option.innerHTML = data[i]['basicInfo'].city;
            branch3.appendChild(option);
        }
    });
function filterSports(event){
    if(branch3.value !== ''){
        const branchID = branch3.value;
        for(let i=0; i<branchData3.length; i++){
            if(branchData3[i]['basicInfo'].branchID == branchID){
                for(let j=0; j<branchData3[i]['sports'].length; j++){
                    const option = document.createElement("option");
                    option.value = branchData3[i]['sports'][j].sportID;
                    option.innerHTML = branchData3[i]['sports'][j].sportName;
                    sport3.appendChild(option);
                }
                break;
            }
        }
    }else{
        sport3.innerHTML = '';
        const option = document.createElement("option");
        option.value = 'all';
        option.innerHTML = 'All Sports';
        sport3.appendChild(option);
    }
}

function displayChart(event){
    console.log(fromDate3.value);
    errMsg3.innerHTML = '';
    const from = new Date(fromDate3.value);
    const to = new Date(toDate3.value);

    if(from>to || fromDate3.min<lastYear3 || toDate3.min<lastYear3 || fromDate3.max>today3 || toDate3.max>today3){
        errMsg3.innerHTML = "Invalid date input or date range";
    }
    
    if(errMsg3.innerHTML === "" && fromDate3.value !== '' && toDate3.value !== '' &&  branch3.value !== ''){

        var days = Math.ceil(to-from)/(1000*60*60*24);  //get the count of days between the two dates
        days = days+1;  //including the first day itself(from date)
        currDate = fromDate3.value;
        console.log(days);
        var xLabels = [];
        var dataSet = [];
        
        if(days<=30){     
            fetch("../../controller/owner/get_court_revenue_controller.php?branchID=".concat(branch3.value,"&from=",currDate,"&to=",currDate,"&days=",days,"&sport=",sport3.value))
            .then(res => res.json())
            .then(data => {
                console.log(data);
                for(let i=0; i<data.length; i++){
                    xLabels.push(data[i].date);
                    dataSet.push(data[i].revenue);
                }
                var ctx = document.getElementById("myChart3").getContext("2d");
                if (window.myChart3 instanceof Chart) {
                    window.myChart3.destroy(); // destroy the previous chart instance
                }
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);   //adding gradient to the chart
                gradient.addColorStop(0, '#6F0808');
                gradient.addColorStop(0.45, '#000000');
                gradient.addColorStop(0.7845, '#000956');
                window.myChart3 = new Chart(ctx, {  //have to wait for the data to be fetched
                    type: 'bar',
                    data: {
                        labels: xLabels, // use date values as labels
                        datasets: [{
                            label: 'Income (Court Bookings)',
                            data: dataSet, // use income values as data
                            backgroundColor: gradient,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                        }]
                    },
                });
            });

            
        }else{
            fetch("../../controller/owner/get_court_revenue_controller.php?branchID=".concat(branch3.value,"&from=",currDate,"&to=",currDate,"&days=",days,"&sport=",sport3.value))
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
                var ctx = document.getElementById("myChart3").getContext("2d");;
                if (window.myChart3 instanceof Chart) {
                    window.myChart3.destroy(); // destroy the previous chart instance
                }
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);   //adding gradient to the chart
                gradient.addColorStop(0, '#6F0808');
                gradient.addColorStop(0.45, '#000000');
                gradient.addColorStop(0.7845, '#000956');
                window.myChart3 = new Chart(ctx, {  //have to wait for the data to be fetched
                    type: 'bar',
                    data: {
                        labels: xLabels, // use date values as labels
                        datasets: [{
                            label: 'Income (Court Bookings)',
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
        var ctx = document.getElementById("myChart3").getContext("2d");
        if (window.myChart3 instanceof Chart) {
            window.myChart3.destroy(); // destroy the previous chart instance
        }
    }
}

fromDate3.addEventListener("change",displayChart);
toDate3.addEventListener("change",displayChart);
branch3.addEventListener("change",displayChart);
sport3.addEventListener("change",displayChart);
branch3.addEventListener("change",filterSports);