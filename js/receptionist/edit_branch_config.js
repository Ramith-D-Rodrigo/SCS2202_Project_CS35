const numBtn = document.getElementById("ChangeNumBtn");
const emailBtn = document.getElementById("EmailChangeBtn");
const newNumberDiv = document.getElementById("newNumberField");
const newEmailDiv = document.getElementById("newEmailField");
const newNumber = document.getElementById("numberRSide");
const newEmail = document.getElementById("emailRSide");
const photos = document.getElementById("photo");
const changeBtn = document.getElementById("changeBtn");
const successMsg = document.getElementById("success-msg");
const errMsg = document.getElementById("err-msg");
const overlay = document.getElementById("overlay");

newNumberDiv.style.display = "none";
newEmailDiv.style.display = "none";
changeBtn.addEventListener('click',saveChanges);

numBtn.addEventListener('click',(e)=>{
    numBtn.style.opacity = '0.5';
    numBtn.disabled = 'true';
    newNumberDiv.style.display = "flex";
    newNumber.required = true;
    newEmail.required = true;
});

emailBtn.addEventListener('click',(e)=>{
    emailBtn.style.opacity = '0.5';
    emailBtn.disabled = 'true';
    newEmailDiv.style.display = "flex";
})

let newPhoto = document.getElementById('newPhoto');
newPhoto.addEventListener('change', function() {
    let file = newPhoto.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function() {
        let img = document.createElement('img');
        img.src = reader.result;
        photos.appendChild(img);
    };
});

function saveChanges(event){
    event.preventDefault();
    const newEmail = document.getElementById("newEmail");
    const newNumber = document.getElementById("newNumber");
    const branchForm = document.getElementById("branchForm");
    if(!branchForm.reportValidity()){
        errMsg.innerHTML = "Data Not Valid";
        return;
    }
    if(newEmail.value === '' && newNumber.value === '' && newPhoto.files.length === 0){
        return;
    }
    // console.log(newEmail.value);
    // console.log(newNumber.value);
    // console.log(newPhoto.files);
    let images = [];
    if(newPhoto.files !== ''){
        const files = newPhoto.files;     //get all the user selected files
        console.log(files);
        for (let i = 0; i < files.length; i++) {
            if(files[i]['type'] !== "image/png" && files[i]['type'] !== "image/jpg" && files[i]['type'] !== "image/jpeg"){  //validate thr image type
                errMsg.innerHTML = "Upload Image Type is invalid";
                return;
            }
            // const file = files[i];
            // console.log(file);
            images.push(files[i]['name']);  //save to the images array
        }
    }
    // const editedDetails = {Email: newEmail.value, Number: newNumber.value, Images: images};
    const formDetails = document.querySelector('form');
    const formData = new FormData(formDetails);
    fetch("../../controller/receptionist/branch_changes_controller.php",{
        method: 'POST',
        body: formData
    })
    .then((res) => res.json())
    .then((data) => {
        // console.log(data);
        if(!data['Flag']){
            overlay.className = "overlay";
            successMsg.className = "dialog-box";
            successMsg.style.display = "flex";
            successMsg.innerHTML = "Branch Details Updated Successfully";
            overlay.style.display = "block";
            
            setTimeout(function(){
                location.reload();
            },3000);
        }else{
            errMsg.innerHTML = data['Message'];
        }
    });
}

  