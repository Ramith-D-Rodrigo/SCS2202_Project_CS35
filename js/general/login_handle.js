import { togglePassword } from '../FUNCTIONS.js';

const togglePasswordbtn = document.getElementById("togglePassword");
const password = document.getElementById("password");

togglePasswordbtn.addEventListener("click", (e) => {
    e.preventDefault();
    togglePassword(togglePasswordbtn, password);
});