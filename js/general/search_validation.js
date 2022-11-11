verbose = true; //for debugging

function searchValidation(event){
    const formDiv = document.getElementById("searchBar");

    if(verbose){
        console.log(formDiv.reportValidity());
    }

    if(formDiv.reportValidity() === false){
        return false;
    }
    else{
        return true;
    }
}