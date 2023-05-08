fetch("../../controller/receptionist/edit_branch_controller.php")
    .then((res) => res.json())   //removing the headers
    .then((data) => {
        console.log(data);
        // console.log(data[1]);
        const outputLocation = document.createElement("input");
        outputLocation.readOnly = true;
        const locationDiv = document.getElementById("location");
        outputLocation.innerHTML = data[0];    //get the branch location
        outputLocation.value = data[0];
        locationDiv.appendChild(outputLocation);

        const outputEmail = document.createElement("input");
        outputEmail.readOnly = true;
        const mailDiv = document.getElementById("email");
        outputEmail.innerHTML = data[1];     //get the branch email
        outputEmail.value = data[1];
        mailDiv.appendChild(outputEmail);

        const numbersDiv = document.getElementById("numbers");
        numberArray = data[2];
        for(i=0;i<numberArray.length;i++){
            // console.log(numberArray[i]);
            const outputNumber = document.createElement("input");
            outputNumber.readOnly = true;
            outputNumber.innerHTML = numberArray[i];
            outputNumber.value = numberArray[i];
            numbersDiv.appendChild(outputNumber);   //append to the number div
        }

        const photo = document.getElementById("photo");
        photoArray = data[3];
        for(j=0;j<photoArray.length;j++){
            // console.log(photoArray[j]);
            const image = document.createElement("img");  //create the image tag
            image.src = String(photoArray[j]);   //convert it into a string and set the image source
            image.className = "branch-img";
            photo.appendChild(image);   //append to the photo div
        }


    });
