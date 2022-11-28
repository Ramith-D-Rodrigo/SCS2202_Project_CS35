//Toggle Password

const togglePasswordbtns = document.querySelectorAll(".togglePassword");
togglePasswordbtns.forEach(togglePassword);

function togglePassword(element){
    element.addEventListener('click',(e)=>{
        e.preventDefault();
        const parentDiv = element.parentElement;
        const passwordField = parentDiv.children[0];

        if(passwordField.type === 'password'){  //Show password
            passwordField.type = 'text';
            element.innerHTML = "Hide Password";
        }
        else{   //Hide Password
            passwordField.type = 'password';
            element.innerHTML = "Show Password";
        }
    });
}


const addMedicalConcernBtn = document.getElementById("medicalConcernBtn");
let numberOfMedicalConcerns = document.getElementById("medicalConcernList").children.length;

console.log(numberOfMedicalConcerns);

if(numberOfMedicalConcerns === 5){  //do not display as maximum is 5
    addMedicalConcernBtn.style.display = "none";
}

let concernRemoveBtns = null;

if(numberOfMedicalConcerns !== 0){ //has medical concerns
    concernRemoveBtns = document.getElementsByClassName("concernRemoveBtn");

    for(i = 0; i < concernRemoveBtns.length; i++){
        const currBtn = concernRemoveBtns.item(i);
        currBtn.addEventListener('click', ()=>{
            console.log("remove button pressed");
            numberOfMedicalConcerns--;
            const parent = currBtn.parentElement;
            parent.remove();
            if(numberOfMedicalConcerns < 5){
                addMedicalConcernBtn.style.display = "block";
            }
        });
    }
}