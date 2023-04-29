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
            const form = document.createElement('form');
            form.method = "GET";
            const viewBtn = document.createElement('div');
            const btn = document.createElement('button');
            container.style.display = 'flex';
            container.style.flexDirection = 'row';
            container.style.justifyContent = 'space-between';
            rightContainer.innerHTML = "";
            btn.innerHTML = "View Request";
            btn.name = "requestDetails";
            btn.type = "submit";
            btn.value = JSON.stringify(data[i]);
            if(data[i].type === "discount"){
                flag1 = 1;
                form.action = "../../public/owner/view_discount_request.php";
                leftContainer.innerHTML = "Managed By: ".concat(data[i]['manager'].firstName, " ", data[i]['manager'].lastName, "<br>",
                "Branch: ",data[i]['branch'].city,"<br>","Discount Value: ".concat(data[i].discountValue));
            }else{
                flag2 = 1;
                container.style.marginLeft = '10%';
                form.action = "../../public/owner/view_court_request.php";
                leftContainer.innerHTML = "Sport: ".concat(data[i]['sport'].sportName, "<br>",
                "Court Name: ",data[i].courtName);
                rightContainer.innerHTML = "Managed By: ".concat(data[i]['manager'].firstName, " ", data[i]['manager'].lastName, "<br>",
                "Branch: ",data[i]['branch'].city);
            }
            form.appendChild(btn);
            viewBtn.appendChild(form);
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
            const title = document.getElementById('discountTitle');
            title.innerHTML = "No Discount Requests To Display";
            title.style.marginLeft = '-20%';
            title.style.width = '100%';
        }if(flag2 === 0){
            const title = document.getElementById('courtTitle');
            title.innerHTML = "No Court Requests To Display";
            title.style.marginLeft = '-20%';
            title.style.width = '100%';
        }
    });