function pictureSize(size){
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
        //image size
        const uploadedPic = document.getElementById("user_profile_pic");
        if(uploadedPic.value !== ""){   //has uploaded a file
            if(verbose){
                console.log("Uploaded File Size : " + uploadedPic.files[0].size);
            }
    
            if(pictureSize(uploadedPic.files[0].size) === false){   //image too big
                errMsg.innerHTML = errMsg.innerHTML + "Uploaded Image is Too Big";
                return false;  
            } 
        }

  
        //uploaded size is okay
/*         else{
            errMsg.innerHTML = errMsg.innerHTML + "Uploaded Image is okay";
            return false;
        } */
    
    //have to check input values validity (similary)
        let flag = true;    //for final validation
        const emergencyDetails = document.getElementById("emergencyDetails");
        const emergencyDetailsChildren = emergencyDetails.children;
        
        let contactNum = [];    //contact number
        let relationship = [];  //relationship
        let names = [];         //name

        if(verbose){
            console.log(emergencyDetailsChildren);
        }

        //1st one (Compulsary)
        contactNum[0] = emergencyDetailsChildren[5].value;   
        relationship[0] = emergencyDetailsChildren[3].value.toLowerCase();
        names[0] = emergencyDetailsChildren[1].value.toLowerCase();

        if(emergencyDetailsChildren.length == 10){    //has 2 emergency contact details
            contactNum[1] = emergencyDetailsChildren[9].children[4].value;   //2nd
            relationship[1] = emergencyDetailsChildren[9].children[2].value.toLowerCase();
            names[1] = emergencyDetailsChildren[9].children[0].value.toLowerCase();
        }

        if(emergencyDetailsChildren.length == 11){    //has 3 emergency contact details
            contactNum[1] = emergencyDetailsChildren[9].children[4].value;   //2nd
            relationship[1] = emergencyDetailsChildren[9].children[2].value.toLowerCase();
            names[1] = emergencyDetailsChildren[9].children[0].value.toLowerCase();

            contactNum[2] = emergencyDetailsChildren[10].children[4].value;  //3rd
            relationship[2] = emergencyDetailsChildren[10].children[2].value.toLowerCase();
            names[2] = emergencyDetailsChildren[10].children[0].value.toLowerCase();
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
    return false;
    
}