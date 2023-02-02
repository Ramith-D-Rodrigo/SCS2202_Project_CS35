const numBtn = document.getElementById("ChangeNumBtn");
const lNumField = document.getElementById("numberLSide");
const rNumField = document.getElementById("numberRSide");
const emailBtn = document.getElementById("EmailChangeBtn");
const lEmailField = document.getElementById("emailLSide");
const rEmailField = document.getElementById("emailRSide");
const numberInput = document.getElementById("newNumber");
const emailInput = document.getElementById("newEmail");

lNumField.style.visibility="hidden";
rNumField.style.visibility="hidden";
lEmailField.style.visibility="hidden";
rEmailField.style.visibility="hidden";


numBtn.addEventListener('click',(e)=>{
    numberInput.setAttribute("required","");
    lNumField.style.visibility = 'visible';
    rNumField.style.visibility = 'visible';
    numBtn.style.opacity = '0.5';
    numBtn.disabled = 'true';
    return;
})

emailBtn.addEventListener('click',(e)=>{
    emailInput.setAttribute("required","");
    lEmailField.style.visibility = 'visible';
    rEmailField.style.visibility = 'visible';
    emailBtn.style.opacity = '0.5';
    emailBtn.disabled = 'true';
    return;
})

// function preFilled(){
//     console.log("Hello");
//     if(!(numBtn.disabled)){
//         numberInput.value = "NULL";
//     }
//     if(!(emailBtn.disabled)){
//         emailInput.value = "NULL";
//     }
//     return;
// }

  