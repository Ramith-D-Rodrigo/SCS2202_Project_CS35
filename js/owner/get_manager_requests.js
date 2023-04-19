fetch("../../controller/owner/get_manager_requests_controller.php")
    .then(res => res.json())   //parse the json string and returns javascript object
    .then(data => {
        console.log(data);
        const discounts = document.getElementById('discount_results');
        const courts = document.getElementById('court_results');
        let flag1 = 0;  //to check if there are any discount requests
        let flag2 = 0;  //to check if there are any court requests
        for(let i=0;i<data.length;i++){
            const container = document.createElement('div');
            container.className = 'container';
            container.style.width = '100%';
            const leftContainer = document.createElement('div');
            const rightContainer = document.createElement('div');
            const viewBtn = document.createElement('div');
            const btn = document.createElement('button');
            container.style.display = 'flex';
            container.style.flexDirection = 'row';
            container.style.justifyContent = 'space-between';
            rightContainer.innerHTML = "";
            btn.innerHTML = "View Request";
            btn.value = data[i].reservationID;
            if(data[i].type === "discount"){
                flag1 = 1;
                leftContainer.innerHTML = "Managed By: ".concat(data[i]['manager'].firstName, " ", data[i]['manager'].lastName, "<br>",
                "Branch: ",data[i]['branch'].city,"<br>","Discount Value: ".concat(data[i].discountValue));
            }else{
                flag2 = 1;
                container.style.marginLeft = '12%';
                leftContainer.innerHTML = "Sport: ".concat(data[i]['sport'].sportName, "<br>",
                "Court Name: ",data[i].courtName);
                rightContainer.innerHTML = "Managed By: ".concat(data[i]['manager'].firstName, " ", data[i]['manager'].lastName, "<br>",
                "Branch: ",data[i]['branch'].city);
            }
            viewBtn.appendChild(btn);
            container.appendChild(leftContainer);
            container.appendChild(rightContainer);
            container.appendChild(viewBtn);
            if(data[i].type === "discount"){
                discounts.appendChild(container);
            }else{
                courts.appendChild(container);
            }
        }

        if(flag1 === 0){
            discounts.innerHTML = "No Discount Requests";
        }if(flag2 === 0){
            courts.innerHTML = "No Court Requests";
        }
    });