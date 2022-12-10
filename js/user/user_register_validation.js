function pictureSize(size){ //max size 2mb
    if(size > 2097152){
        return false;
    }
    else{
        return true;
    }
}

function validateForm(event){
    const errMsg = document.getElementById("errmsg");   //For Displaying the Error messages
    errMsg.innerHTML = '';
    const form = document.querySelector("form");

    if(verbose){
        console.log(form.reportValidity());
    }

    if(form.reportValidity() === false){ //Form is invalid from HTML persepective
        errMsg.innerHTML = errMsg.innerHTML + "Please Add Valid Information";
        return false;
    }
    else{   //Form is valid from HTML perspective
        //image size and type
        let flag = true;    //for final validation
        const uploadedPic = document.getElementById("user_profile_pic");
        if(uploadedPic.value !== ""){   //has uploaded a file
            if(verbose){
                console.log("Uploaded File Size : " + uploadedPic.files[0].size);
            }
    
            if(pictureSize(uploadedPic.files[0].size) === false){   //image too big
                errMsg.innerHTML = errMsg.innerHTML + "Uploaded Image is Too Big<br>";
                flag = false;  
            }
            else{
                errMsg.innerHTML.replace("Uploaded Image is Too Big<br>", "");
            }

            if(verbose){
                console.log(uploadedPic.files[0].type);
            }

            if(uploadedPic.files[0].type !== 'image/png' && uploadedPic.files[0].type !== 'image/jpeg' && uploadedPic.files[0].type !== 'image/jpg'){
                errMsg.innerHTML = errMsg.innerHTML + "Uploaded File is Not Supported. Check the File Type<br>";
                flag = false;
            }
            else{
                errMsg.innerHTML.replace("Uploaded File is Not Supported. Check the File Type<br>", "");
            }
        }

  
        //uploaded size is okay
/*         else{
            errMsg.innerHTML = errMsg.innerHTML + "Uploaded Image is okay";
            return false;
        } */
    
        //passwords matching or not
        const password = document.getElementById("password");
        const passwordConfirm = document.getElementById("passwordConfirm");

        if(password.value !== passwordConfirm.value){
            if(verbose){
                console.log("Passwords do not match");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Passwords do not match<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Passwords do not match<br>", "");
        }
    //have to check input values validity (similary)
        const emergencyDetails = document.getElementById("emergencyDetails");
        const emergencyDetailsChildren = emergencyDetails.children;
        
        let contactNum = [];    //contact number
        let relationship = [];  //relationship
        let names = [];         //name

        if(verbose){
            console.log(emergencyDetailsChildren);
        }

        //emergency contact details

        //emergencyDetailsChildren -> the children of the div container that has all the emergency contact details
        //each children is a div that contains 3 rows (row container)
        //each row has 2 children (fields -> left and right (both are divs))
        //each field has 1 element ( we need the right fields children element for input value)

        //div container -> emgcontact children -> rows -> fields -> field's children
        for(i = 0; i < emergencyDetailsChildren.length; i++){
            names[i] = emergencyDetailsChildren[i].children[0].children[1].children[0].value.toLowerCase();
            relationship[i] = emergencyDetailsChildren[i].children[1].children[1].children[0].value.toLowerCase();
            contactNum[i] = emergencyDetailsChildren[i].children[2].children[1].children[0].value; 
        }
        if(verbose){
            console.log(names, relationship, contactNum);
        }

        const usercontact = document.getElementById('usercontact').value;   //registering user contact details
        const user = (document.getElementById('firstName').value + " " + document.getElementById('lastName').value).toLowerCase(); //registering user's name

        contactNum.push(usercontact);
        names.push(user);
        console.log(user);
        //removing empty fields
        contactNum = contactNum.filter(i => i !== '');   
        relationship = relationship.filter(i => i !== '');   
        names = names.filter(i => i !== ''); 

        if(verbose){
            console.log(contactNum);
            console.log(relationship);
            console.log(names);
        }

        if(new Set(contactNum).size !== contactNum.length){ //check for duplicate contact numbers
            if(verbose){
                console.log("Duplicate Contact Details");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Duplicate Contact Number Details<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Duplicate Contact Number Details<br>", '');  //Remove Contact Details Error Message
        }

        if(new Set(relationship).size !== relationship.length){ //check for duplicate relationships
            if(verbose){
                console.log("Duplicate Relationship Details");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Duplicate Relationship Details<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Duplicate Relationship Details<br>", '');  //Remove relationship Error Message
        }

        if(new Set(names).size !== names.length){ //check for duplicate names
            if(verbose){
                console.log("Duplicate Emergency Contact Detail Names");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Duplicate Emergency Contact Detail Names<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Duplicate Emergency Contact Detail Names<br>", '');  //Remove duplicate name Error Message
        }

        
        const medicalConcernDiv =  document.getElementById("medCon");
        const medicalArr = Array.from(medicalConcernDiv.children);  //create an array for the elements inside the medical concern div
        let concerns = []

        medicalArr.forEach((val, i, arr)=> {    //traverse the array
            if(val.tagName.toLowerCase() === 'div'){    //find the child divs
                console.log(val.children);
                concerns.push(val.children.item(0).value.toLowerCase());  //push the input value 
            }
        })

        concerns = concerns.filter(i => i !== '');
        
        if(verbose){
            console.log(concerns);
        }

        if(new Set(concerns).size !== concerns.length){ //check for duplicate contact numbers
            if(verbose){
                console.log("Duplicate Medical Concern Details");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Duplicate Medical Concern Details<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Duplicate Medical Concern Details<br>", '');  //Remove Contact Details Error Message
        }
        if(flag === false){ //Has invalid inputs
            return false;
        }
        else{   //valid to submit the data
            return true;
        }
    } 
}