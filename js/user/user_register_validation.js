function validateForm(event){
    const form = document.querySelector("form");
    console.log(form.checkValidity());
    if(form.checkValidity() === false){
        
    }
    event.preventDefault();
}