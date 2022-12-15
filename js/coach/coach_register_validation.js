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
        const uploadedPic = document.getElementById("coach_profile_pic");
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
    
    //have to check input values validity (similary)

       

        
        const qualificationDiv =  document.getElementById("quali");
        const qualifiacationarry = Array.from(qualificationDiv.children);  //create an array for the elements inside the medical concern div
        let concerns = []

        qualifiacationarry.forEach((val, i, arr)=> {    //traverse the array
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
                console.log("Duplicate qualification Details");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Duplicate qualification Details<br>";
            flag = false;
        }
        else{
            errMsg.innerHTML.replace("Duplicate qualification Details<br>", '');  //Remove Contact Details Error Message
        }
        if(flag === false){ //Has invalid inputs
            return false;
        }
        else{   //valid to submit the data
            return true;
        }
    } 
}