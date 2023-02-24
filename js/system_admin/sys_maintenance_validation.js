const input = document.getElementById("mainTime");
const timeRegex = "/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/";
  
  input.addEventListener("input", (e) => {
    if (!timeRegex.test(e.target.value)) {
      e.target.value = e.target.value.slice(0, -1);
    }
  });