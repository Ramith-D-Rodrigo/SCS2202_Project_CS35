
const formDiv = document.getElementById("searchBar");
const input = formDiv.querySelector("input");

function searchValidation(event){
    if(formDiv.reportValidity() === false){
        event.preventDefault();
        return false;
    }
    else{
        if(input.value.length < 3){
            event.preventDefault();
            return false;
        }
        return true;
    }
}

formDiv.addEventListener("submit", searchValidation);
