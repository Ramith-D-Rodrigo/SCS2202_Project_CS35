//select the radio btns
const radioBtns = document.querySelectorAll("input[type='radio']");

let counter = 1;

const animation = () => {
    //check if the counter is greater than the radio btns length
    if (counter > radioBtns.length) {
        counter = 1;
    }

    //select the radio btn
    radioBtns.forEach((radioBtn) => {
        radioBtn.checked = false;
    });
    
    //select the radio btn by the counter
    document.getElementById(`radio${counter}`).checked = true;

    //select all the labels
    const labels = document.querySelectorAll("label");

    //remove the active class from all the labels
    labels.forEach((label) => {
        label.classList.remove("active");

        //add the active class to the label by the counter
        if(label.htmlFor === `radio${counter}`){
            label.classList.add("active");
        }
    });

    //increase the counter
    counter++;
}

//set the interval
let animationInterval = setInterval(animation, 5000);

//add event listener to the radio btns on click
radioBtns.forEach((radioBtn) => {
    radioBtn.addEventListener("click", () => {
        //if clicked, reset the interval
        clearInterval(animationInterval);
        //set the interval again
        animationInterval = setInterval(animation, 5000);

    });
});

