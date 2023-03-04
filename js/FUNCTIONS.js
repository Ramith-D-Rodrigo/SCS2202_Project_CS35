const changeToLocalTime = (time) => {
    //split the time
    const timeArr = time.split(":");
    const hours = parseInt(timeArr[0]);
    const minutes = parseInt(timeArr[1]);
    const seconds = parseInt(timeArr[2]);

    const date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    date.setSeconds(seconds);

    const localTime = date.toLocaleTimeString();
    return localTime;
}

const capitalizeFirstLetter = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

const disableElementsInMain = (mainElement) => {
    const buttons = mainElement.querySelectorAll("button");
    const inputs = mainElement.querySelectorAll("input");
    const selects = mainElement.querySelectorAll("select");
    const textareas = mainElement.querySelectorAll("textarea");
    const radios = mainElement.querySelectorAll("radio");
    const checkboxes = mainElement.querySelectorAll("checkbox");

    const elements = [...buttons, ...inputs, ...selects, ...textareas, ...radios, ...checkboxes];

    elements.forEach((element) => {
        element.disabled = true;
    });

}

const enableElementsInMain = (mainElement) => {
    const buttons = mainElement.querySelectorAll("button");
    const inputs = mainElement.querySelectorAll("input");
    const selects = mainElement.querySelectorAll("select");
    const textareas = mainElement.querySelectorAll("textarea");
    const radios = mainElement.querySelectorAll("radio");
    const checkboxes = mainElement.querySelectorAll("checkbox");

    const elements = [...buttons, ...inputs, ...selects, ...textareas, ...radios, ...checkboxes];

    elements.forEach((element) => {
        element.disabled = false;
    });
}

const togglePassword = (button, passwordInput) => {
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        button.querySelector("i").classList.remove("fa-eye");
        button.querySelector("i").classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        button.querySelector("i").classList.remove("fa-eye-slash");
        button.querySelector("i").classList.add("fa-eye");
    }
}



export {changeToLocalTime, capitalizeFirstLetter, disableElementsInMain, enableElementsInMain, togglePassword};