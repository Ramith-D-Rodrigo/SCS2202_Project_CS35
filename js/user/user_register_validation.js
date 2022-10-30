function validateForm(event){
    const errMsg = document.getElementById("errmsg");   //For Displaying the Error messages
    errMsg.innerHTML = '';
    const form = document.querySelector("form");
    if(verbose){
        console.log(form.checkValidity());
        const emergencyDetails = document.getElementById("emergencyDetails");
        const emergencyDetailsChildren = emergencyDetails.children;
        let contact1, contact2, contact3; 

        if(verbose){
            console.log(emergencyDetailsChildren);
        }

        contact1 = emergencyDetailsChildren[5].value;   //1st one (Compulsary)

        if(emergencyDetailsChildren.length == 10){    //has 2 emergency contact details
            contact2 = emergencyDetailsChildren[9].children[4].value;   //2nd
        }

        if(emergencyDetailsChildren.length == 11){    //has 3 emergency contact details
            contact2 = emergencyDetailsChildren[9].children[4].value;   //2nd
            contact3 = emergencyDetailsChildren[10].children[4].value;  //3rd
        }
        const usercontact = document.getElementById('usercontact').value;   //registering user contact details
        const contactArr = [contact1, contact2, contact3, usercontact];

        if(verbose){
            console.log(contactArr);
        }

        if(new Set(contactArr).size !== contactArr.length){ //check for duplicate contact numbers
            if(verbose){
                console.log("Duplicate contact details");
            }
            errMsg.innerHTML = errMsg.innerHTML + "Duplicate contact details<br>";
        }

    }

    if(form.checkValidity() === false){ //Form is invalid
        event.preventDefault();
        errMsg.innerHTML = errMsg.innerHTML + "Please Add Valid Information";
    }
    else{   //Form is valid
        const emergencyDetails = document.getElementById("emergencyDetails");
        const emergencyDetailsChildren = emergencyDetails.childNodes;
        const contact1 = emergencyDetailsChildren[11].nodeValue;
        const contact2 = emergencyDetailsChildren[19].nodeValue;
        const contact3 = emergencyDetailsChildren[20].nodeValue;
        console.log(emergencyDetails.childNodes[11])
    }
    
}