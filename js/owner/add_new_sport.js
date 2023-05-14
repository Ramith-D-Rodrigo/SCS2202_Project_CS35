const form = document.querySelector('#sportForm');

const msg = document.querySelector('.msg');

import {disableElementsInMain, enableElementsInMain, togglePassword} from '../FUNCTIONS.js';

const authFormDiv = document.querySelector('#authFormDiv');

const password = authFormDiv.querySelector('#password');

const passwordToggle = authFormDiv.querySelector('#togglePasswordBtn');

const main = document.querySelector('main');

let formData = null;

passwordToggle.addEventListener('click', function(e){
    e.preventDefault();
    togglePassword(passwordToggle, password);
});

form.addEventListener('submit', (e) => {
    msg.innerHTML = '';

    e.preventDefault();
    e.stopPropagation();
    if(!form.reportValidity()){
        return;
    }

    formData = new FormData(form);

    //validation
    const name = formData.get('name');
    const description = formData.get('description');
    const reservationPrice = formData.get('reservationPrice');
    const reReservationPrice = formData.get('reReservationPrice');
    const maxPlayers = formData.get('maxPlayers');

    if(name.length < 3){
        msg.innerHTML = 'Sport Name is too Short';
        msg.style.color = 'red';
        return;
    }

    //captialize first letter
    const nameCapitalized = name.charAt(0).toUpperCase() + name.toLowerCase().slice(1);
    formData.set('name', nameCapitalized);

    if(description.length < 5){
        msg.innerHTML = 'Description is too Short';
        msg.style.color = 'red';
        return;
    }

    if(reservationPrice < 0 || reservationPrice % 10 !== 0){    //must be multiple of 10
        msg.innerHTML = 'Invalid Reservation Price';
        if(reservationPrice % 10 !== 0){
            msg.innerHTML = ' Price Must be a multiple of 10';
        }
        msg.style.color = 'red';
        return;
    }


    if(reReservationPrice !== reservationPrice){
        msg.innerHTML = 'Re-Reservation Price is not the same as Reservation Price';
        msg.style.color = 'red';
        return;
    }

    if(maxPlayers !== '' && maxPlayers <= 0){
        msg.innerHTML = 'Invalid Max Players';
        msg.style.color = 'red';
        return;
    }
    
    if(maxPlayers === ''){
        formData.delete('maxPlayers');
    }

    //open the auth form
    const authFormDiv = document.querySelector('#authFormDiv');
    authFormDiv.style.display = 'block';
    const authMsg = authFormDiv.querySelector('#authMsg');

    main.style.opacity = '0.5';
    disableElementsInMain(main);

    //close the auth form
    main.addEventListener('click', function mainClick(e){
        enableElementsInMain(main);
        authFormDiv.style.display = 'none';
        authMsg.innerHTML = '';
        authFormDiv.querySelector('form').reset();

        main.style.opacity = '1';

        //remove the event listener
        main.removeEventListener('click', mainClick);
    });
});

//submit the form
const authForm = authFormDiv.querySelector('form');

authForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const authFormData = new FormData(authForm);

    let authStatus = null;
    
    //disable the submit button
    const submitBtn = authForm.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.classList.add('disabled');

    fetch("../../controller/general/authentication_controller.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
            },
        body: JSON.stringify(Object.fromEntries(authFormData))
    })
    .then(res => {
        authStatus = res.ok;
        return res.json();
    })
    .then(data => {
        if(!authStatus){    //invalid credentials
            const authMsg = authFormDiv.querySelector('#authMsg');
            authMsg.innerHTML = data.errMsg;
            authMsg.style.color = 'red';

            //enable the submit button
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');

            return;
        }
        //valid credentials

        //close the auth form
        main.click();

        //send the sport data
        let status = null;

        //disable main form submit button
        const mainSubmitBtn = form.querySelector('button[type="submit"]');
        mainSubmitBtn.disabled = true;
        mainSubmitBtn.classList.add('disabled');

        fetch("../../controller/owner/add_new_sport_controller.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
                },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(res => {
            status = res.ok;
            return res.json();
        })
        .then(data => {

            //enable main form submit button
            mainSubmitBtn.disabled = false;
            mainSubmitBtn.classList.remove('disabled');

            //enable the submit button of the auth form
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
            
            if(!status){
                msg.innerHTML = data.msg;
                msg.style.color = 'red';
                return;
            }

            msg.innerHTML = data.msg;
            msg.style.color = 'green';
            form.reset();   //reset the initial form
        })
    })

});